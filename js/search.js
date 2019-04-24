function getCardTemplate(i, departureTime, arrivalTime, price)
{
	let diff = Math.abs(arrivalTime - departureTime) / 36e5;
	let hours = Math.floor(diff);
	let minutes = Math.floor((diff - hours) * 60);

	departureTime = departureTime.getHours().toString().padStart(2, "0")
		+ ":"
		+ departureTime.getMinutes().toString().padStart(2, "0");

	arrivalTime = arrivalTime.getHours().toString().padStart(2, "0")
		+ ":"
		+ arrivalTime.getMinutes().toString().padStart(2, "0");

	let element = document.createElement("DIV");

	element.innerHTML = `
		<div class="card-table">
			<div class="card-info">
				<div class="card-header card-number">
					<span>${i.toString().padStart(2, "0")}</span>
				</div>
				<div class="card-header card-airline">
					<span>Valkyrie Airline Flight</span>
				</div>
				<div class="card-header card-time">
					<div class="card-time-container">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
							<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
							<path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
						</svg>
						<span>${hours}h ${minutes}m</span>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="card-data card-departure">
					<span>${departureTime}</span>
				</div>
				<div class="card-data card-decor">
					<!--<svg viewBox="0 0 700 200">-->
						<!--<line x1="40" x2="700" y1="100" y2="100" stroke="#5184AF" stroke-width="20" stroke-linecap="round" stroke-dasharray="1, 30"></line>-->
					<!--</svg>-->
				</div>
				<div class="card-data card-arrival">
					<span>${arrivalTime}</span>
				</div>
			</div>
		</div>
		<div class="card-button">
			<div class="button-header">
				<h3>Regular Fare</h3>
			</div>
			<div class="button-price" role="button">
				<span class="price-content">$${price}</span>
				<span class="arrow">
					<svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
				</span>
			</div>
		</div>
	`;

	element.classList.add("flight-card");

	return element;
}

function onLoad()
{
	const url = new URL(window.location);
	const origin = url.searchParams.get("origin");
	const destination = url.searchParams.get("destination");

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
	}

	const event = new Event('input', {
		'bubbles': true,
		'cancelable': true
	});

	const originEl = document.querySelector("#origin");
	const destinationEl = document.querySelector("#destination");

	originEl.value = origin;
	originEl.dispatchEvent(event);
	destinationEl.value = destination;
	destinationEl.dispatchEvent(event);

	let depart = new Date("2019-04-21 08:00:00");
	let arrive = new Date("2019-04-21 09:25:00");
	let flight = getCardTemplate(1, depart, arrive, 129.99);

	for (let i = 0; i < 20; i++)
	{
		let flight = getCardTemplate(1, depart, arrive, 129.99);
		document.querySelector(".flight-list").appendChild(flight);
	}

	const simplebar = new SimpleBar(document.querySelector(".flight-list"), {autoHide: false})
}

document.addEventListener('DOMContentLoaded', onLoad, false);