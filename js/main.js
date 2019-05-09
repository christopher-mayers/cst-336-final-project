"use strict";

const carouselMilli = 800;
const carouselSeconds = carouselMilli / 1000

function addCard(title, subtitle, image)
{
	document.querySelector(".carousel").innerHTML += `<div class="card" style='background-image: url("${image}");animation: ${carouselSeconds}s cubic-bezier(0.165, 0.84, 0.44, 1) 0s card-slide;'>` +
		`<div class="info" style="animation: ${carouselSeconds}s cubic-bezier(0.165, 0.34, 0.44, 1) 0s info-slide;opacity: 0;">` +
		`<h1>${title}</h1>` +
		`<h2>${subtitle}</h2>` +
		"</div>" +
		"</div>";

	setTimeout(function()
	{
		const nodes = document.querySelectorAll(".card");

		for (let obj of nodes)
		{
			obj.style.animation = "";
			obj.style.width = "";

			for (let child of obj.children)
			{
				if (child.classList.contains("info"))
				{
					child.style.animation = "";
					child.style.opacity   = "";
				}
			}
		}

		if (nodes && nodes.length > 1)
		{
			nodes[0].parentNode.removeChild(nodes[0]);
		}

	}, carouselMilli);
}

function fetchCard()
{
	if (!document.hasFocus())
	{
		setTimeout(fetchCard, 8000)

		return
	}

	fetch("api/flights/random")
		.then((r) => r.json())
		.then((r) => {
			let image = new Image()
			image.onload = function()
			{
				addCard(r.destination, "from $" + Math.floor(Number(r.price)), this.src);

				setTimeout(fetchCard, 8000)
			}
			image.src = r.img
			image = null
		})
}

setTimeout(function()
{
	fetchCard()
}, 8000);

for (let obj of document.querySelectorAll(".field input"))
{
	obj.addEventListener("input", function(e)
	{
		const value = e.currentTarget.value;

		if (value.length > 0)
			obj.nextElementSibling.style.display = "none";
		else
			obj.nextElementSibling.style.display = "";
	});

	const event = new Event("input");
	obj.dispatchEvent(event);
}

const logout = document.querySelector("a[name='logout']");

if (logout !== null)
{
	logout.addEventListener("click", function (e)
	{
		fetch("api/logout", {
			method: "POST",
		})
			.then(() => window.location = "index.php");
	})
}

console.log("%cWoah there!", "background-color: #ffafaf; font-size: 64px; font-weight: bold; color: red; -webkit-text-stroke: 2px black;")
console.log("%cThere's no need to be extreme...", "font-size: 32px; font-weight: bold; color: red;")