const other = "https://camo.githubusercontent.com/0fa6afcb113bd8cdcf805fb9a47d472869abeaa7/68747470733a2f2f6c68342e676f6f676c6575736572636f6e74656e742e636f6d2f2d335377693777464d4f4d452f554f3554664a6e464845492f41414141414141414537772f452d64466c36724741726f2f73313932302d77313932302d68313038302d632f486f72736573686f6525324242656e6425324253756e7365742e6a7067";
const carouselMilli = 800;
const carouselSeconds = carouselMilli / 1000;
var imageData;
var index = 0;

fetch("https://raw.githubusercontent.com/dconnolly/chromecast-backgrounds/master/backgrounds.json")
	.then(result => result.json())
	.then(result => imageData = result);

function addCard(title, subtitle, image)
{
	document.querySelector(".carousel").innerHTML += `<div class="card" style='background: url("${image}");animation: ${carouselSeconds}s cubic-bezier(0.165, 0.84, 0.44, 1) 0s card-slide;'>` +
		`<div class="info" style="animation: ${carouselSeconds}s cubic-bezier(0.165, 0.34, 0.44, 1) 0s info-slide;opacity: 0;">` +
		`<h1>${title}</h1>` +
		`<h2>${subtitle}</h2>` +
		"</div>" +
		"</div>";

	setTimeout(function()
	{
		const nodes = document.querySelectorAll(".card");

		if (nodes && nodes.length > 1)
		{
			nodes[0].parentNode.removeChild(nodes[0]);
		}

		for (let obj of nodes)
		{
			obj.style.animation = "";

			for (let child of obj.children)
			{
				if (child.classList.contains("info"))
				{
					child.style.animation = "";
					child.style.opacity   = "";
				}
			}
		}

	}, carouselMilli);
}

function onLoad()
{
	setInterval(function()
	{
		addCard("San Pedro", "from $500", imageData[index % imageData.length].url);
		index++;
	}, 5000);

	// for (let obj of document.querySelectorAll(".picker .field input"))
	// {
	// 	obj.addEventListener("input", function(e)
	// 	{
	// 		const value = e.currentTarget.value;
	//
	// 		if (value.length > 0)
	// 			obj.nextSibling.style.display = "none";
	// 		else
	// 			obj.nextSibling.style.display = "";
	// 	});
	// }
}

document.addEventListener('DOMContentLoaded', onLoad, false);