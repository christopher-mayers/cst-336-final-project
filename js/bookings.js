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
		this._departureTime = "0000-00-00 00:00:00"
		this._arrivalTime = "0000-00-00 00:00:00"
		this._id = 0
	}

	static get observedAttributes()
	{
		return ["departure-time", "arrival-time", "index", "flight"]
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
			fetch("api/cancel", {
				method: "POST",
				headers: {
					"Content-Type": "application/json"
				},
				body: JSON.stringify({flight: this._id})
			})

			this.parentNode.removeChild(this)

			let i = 1

			for (let obj of document.querySelectorAll("flight-card"))
			{
				obj.index = i
				i++
			}
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
			case "flight":
				if (newValue !== null)
					this._id = Number(newValue)

				this.removeAttribute("flight")
				break
			default:
				break
		}

		this.update()
	}
}
customElements.define("flight-card", FlightCard)

const simplebar = new SimpleBar(document.querySelector(".flight-list"), {autoHide: false})