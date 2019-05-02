"use strict"

const pay = document.querySelector("#pay")

pay.addEventListener("click", function(e)
{
	fetch(`api/checkout`, {
		method: "POST",
	})
		.then((r) => r.json())
		.then((r) => {
			console.log(r.status)
		})
})