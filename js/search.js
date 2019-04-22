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
}

document.addEventListener('DOMContentLoaded', onLoad, false);