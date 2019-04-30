"use strict";

function template(id)
{
	const t = document.querySelector(`template#${id}`)
	return document.importNode(t.content, true)
}

class FlightCard extends HTMLElement
{
	constructor()
	{
		super()

		this.content = template("flight-card")
		this._index = 0
		this._price = 0
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

//		departureTime = departureTime.getHours().toString().padStart(2, "0")
//			+ ":"
//			+ departureTime.getMinutes().toString().padStart(2, "0");
//
//		arrivalTime = arrivalTime.getHours().toString().padStart(2, "0")
//			+ ":"
//			+ arrivalTime.getMinutes().toString().padStart(2, "0");

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
				const departure = flight.departureTime,
				      arrival   = flight.arrivalTime

				const card         = new FlightCard()
				card.index         = i
				card.price         = flight.price
				card.departureTime = departure
				card.arrivalTime   = arrival
				card.id            = flight.id

				target.appendChild(card)

				i++
			}
		})
		.catch((error) =>
		{

		})
}

function onLoad()
{
	const url         = new URL(window.location),
	      origin      = url.searchParams.get("origin"),
	      destination = url.searchParams.get("destination")

	const simplebar = new SimpleBar(document.querySelector(".flight-list"), {autoHide: false})

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

				if (value.length <= 0 || other.value.length <= 0)
					return

				populate(value, other.value, simplebar.getContentElement())
			})
		else
			obj.addEventListener("blur", function(e)
			{
				const value = e.currentTarget.value,
				      other = document.querySelector(`input#origin`)

				if (value.length <= 0 || other.value.length <= 0)
					return

				populate(other.value, value, simplebar.getContentElement())
			})
	}

	const event = new Event('input', {
		'bubbles': true,
		'cancelable': true
	});

	const originEl      = document.querySelector("#origin"),
	      destinationEl = document.querySelector("#destination"),
	      datePicker    = document.querySelector(".date-display")

	originEl.value = origin;
	originEl.dispatchEvent(event);
	destinationEl.value = destination;
	destinationEl.dispatchEvent(event);

	const today = moment()

	datePicker.textContent = today.format("MMMM D, YYYY")

	populate(originEl.value, destinationEl.value, today.format("YYYY-MM-DD"), simplebar.getContentElement())
}

document.addEventListener('DOMContentLoaded', onLoad, false);