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
			const currentForm = document.querySelector(`form`);

			for (let button of document.querySelectorAll(".option[data-selected=true]"))
			{
				button.setAttribute("data-selected", false);
			}

			this.setAttribute("data-selected", true);

			formContainer.innerHTML = "";
			formContainer.appendChild(targetTemplate);
		})
	}
}

document.addEventListener("DOMContentLoaded", load, false);