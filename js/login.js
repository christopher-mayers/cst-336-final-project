function template(id)
{
	const t = document.querySelector(`template#${id}`);
	return document.importNode(t.content, true);
}

function load()
{
	const formContainer = document.querySelector(".form-container");
	formContainer.appendChild(template("loginForm"));

	for (let obj of document.querySelectorAll(".option"))
	{
		obj.addEventListener("click", function(e)
		{
			const target = this.getAttribute("data-target");
			const targetTemplate = template(target);
			const currentForm = document.querySelector(`.template-holder`);

			if (currentForm.getAttribute("data-option") === target)
				return;

			for (let button of document.querySelectorAll(".option[data-selected=true]"))
			{
				button.setAttribute("data-selected", false);
			}

			this.setAttribute("data-selected", true);

			formContainer.innerHTML = "";
			formContainer.appendChild(targetTemplate);
		})
	}

	document.querySelector(".container").removeAttribute("hidden")

	// document.querySelector(".branding").addEventListener("click", function()
	// {
	// 	window.location = "index.php"
	// })
}

document.addEventListener("DOMContentLoaded", load, false);