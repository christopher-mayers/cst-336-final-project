"use strict";

function template(id)
{
	const t = document.querySelector(`template#${id}`)
	return document.importNode(t.content, true)
}

function formEncode(params)
{
	return Object.keys(params).map((key) => {
		return encodeURIComponent(key) + "=" + encodeURIComponent(params[key]);
	}).join("&");
}

class FlightCard extends HTMLElement
{
	constructor()
	{
		super()

		this.content = template("flight-card")
		this._index = 0
		this._price = 0
		this._id = 0
		this._departureTime = "0000-00-00 00:00:00"
		this._arrivalTime = "0000-00-00 00:00:00"
	}

	static get observedAttributes()
	{
		return ["departure-time", "arrival-time", "price", "index"]
	}

	/* Getters and setters */
	get index()
	{
		return this._index
	}

	set index(value)
	{
		this.setAttribute("index", value)
	}

	get price()
	{
		return this._price
	}

	set price(value)
	{
		this.setAttribute("price", value)
	}

	get departureTime()
	{
		return this._departureTime
	}

	set departureTime(value)
	{
		this.setAttribute("departure-time", value)
	}

	get arrivalTime()
	{
		return this._arrivalTime
	}

	set arrivalTime(value)
	{
		this.setAttribute("arrival-time", value)
	}

	connectedCallback()
	{
		this.appendChild(this.content)

		this.update()

		this.querySelector(".card-button").addEventListener("click", (e) =>
		{
			fetch(`api/precheckout`, {
				headers: {
					"Content-Type": "application/x-www-form-urlencoded;charset=UTF-8"
				},
				method: "POST",
				body: formEncode({flight: this._id})
			})
				.then((r) => {
					if (r.status !== 200)
						return

					window.location = "checkout.php"
				})
		})
	}

	update()
	{
		/*
			If for some stupid reason we don't have children yet (yes it happens)
			then don't bother
		*/
		if (!this.hasChildNodes())
			return

		if (this.ownerDocument.defaultView !== document.defaultView)
			return

		this.calculateTimes()
		this.querySelector(".price-content").textContent = "$" + Number(this.price).toFixed(2)
		this.querySelector(".card-number > span").textContent = `${this.index.toString().padStart(2, "0")}`
	}

	calculateTimes()
	{
		let arrivalTime   = moment(this.arrivalTime),
		    departureTime = moment(this.departureTime),
		    duration      = moment.duration(arrivalTime.diff(departureTime))

		this.querySelector(".card-departure > span").textContent = departureTime.format("hh:mm")
		this.querySelector(".card-arrival > span").textContent = arrivalTime.format("hh:mm")
		this.querySelector(".card-time-container > span").textContent = `${duration.hours()}h ${duration.minutes()}m`
	}

	attributeChangedCallback(attr, oldValue, newValue)
	{
		switch (attr)
		{
			case "price":
				this._price = newValue
				break
			case "index":
				this._index = newValue
				break
			case "departure-time":
				this._departureTime = newValue
				break
			case "arrival-time":
				this._arrivalTime = newValue
				break
			default:
				break
		}

		this.update()
	}
}
customElements.define("flight-card", FlightCard)

let currentUrl    = new URL(window.location)
let queryDate     = currentUrl.searchParams.get("date")
let departureDate = queryDate ? moment(queryDate) : moment()
let simplebar

function populate(from, to, time, target)
{
	let url = `api/flights/search?origin=${from}&destination=${to}`

	if (time)
		url += `&time=${time}`

	fetch(encodeURI(url))
		.then((r) => {
			if (r.status === 400)
				throw Error("Bad request")

			return r
		})
		.then((r) => r.json())
		.then((r) => {
			let i = 1

			target.innerHTML = ""

			for (let flight of r)
			{
				const departure = flight.departureTime.date,
				      arrival   = flight.arrivalTime.date

				const card         = new FlightCard()
				card.index         = i
				card.price         = flight.price
				card.departureTime = departure
				card.arrivalTime   = arrival
				card._id            = flight.id

				target.appendChild(card)

				i++
			}
		})
		.catch((error) => {})
}

function setupInputs()
{
	const url         = currentUrl,
	      origin      = url.searchParams.get("origin"),
	      destination = url.searchParams.get("destination")

	// Synthetic event to trigger the label hiding
	const event = new Event('input', {
		'bubbles': true,
		'cancelable': true
	});

	const originEl      = document.querySelector("#origin"),
	      destinationEl = document.querySelector("#destination")

	for (let obj of document.querySelectorAll("input.name"))
	{
		obj.addEventListener("input", function(e)
		{
			const value = e.currentTarget.value;

			if (value.length > 0)
				obj.nextElementSibling.style.display = "none";
			else
				obj.nextElementSibling.style.display = "";
		});

		if (obj.id === "origin")
			obj.addEventListener("blur", function(e)
			{
				const value = e.currentTarget.value,
				      other = document.querySelector(`input#destination`)

				url.searchParams.set("origin", value)

				if (value.length <= 0 || other.value.length <= 0)
					return

				history.replaceState("Flight Search", document.title, url.toString())

				populate(value, other.value, departureDate.format("YYYY-MM-DD"), simplebar.getContentElement())
			})
		else
			obj.addEventListener("blur", function(e)
			{
				const value = e.currentTarget.value,
				      other = document.querySelector(`input#origin`)

				url.searchParams.set("destination", value)

				if (value.length <= 0 || other.value.length <= 0)
					return

				history.replaceState("Flight Search", document.title, url.toString())

				populate(other.value, value, departureDate.format("YYYY-MM-DD"), simplebar.getContentElement())
			})
	}

	originEl.value = origin;
	originEl.dispatchEvent(event);
	destinationEl.value = destination;
	destinationEl.dispatchEvent(event);

	if (originEl.value && destinationEl.value)
		populate(originEl.value, destinationEl.value, departureDate.format("YYYY-MM-DD"), simplebar.getContentElement())
}


simplebar = new SimpleBar(document.querySelector(".flight-list"), {autoHide: false})

setupInputs(simplebar.getContentElement())

const dateDisplay = document.querySelector(".date-display")

const originEl      = document.querySelector("#origin"),
      destinationEl = document.querySelector("#destination")

const datePicker = new MaterialDatepicker(".date-display", {
	outputElement: ".date-display",
	color: "#406ABC",
	outputFormat: "MMMM D, YYYY",
	orientation: "portrait",
	date: departureDate.toDate(),
	onNewDate: function(date)
	{
		date = moment(date)
		departureDate = date
		currentUrl.searchParams.set("date", date.format("YYYY-MM-DD"))
		history.replaceState("Flight Search", document.title, currentUrl.toString())
		populate(originEl.value, destinationEl.value, date.format("YYYY-MM-DD"), simplebar.getContentElement())
	}
})