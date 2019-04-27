function template(id)
{
	const t = document.querySelector(`template#${id}`)
	return document.importNode(t.content, true)
}

class LoginForm extends HTMLElement
{
	constructor()
	{
		super()

		this.content = template("login-form")
	}

	connectedCallback()
	{
		this.setAttribute("option", "login-form")
		this.appendChild(this.content)

		for (let obj of this.querySelectorAll(".field input"))
		{
			obj.addEventListener("input", function(e)
			{
				const value = e.currentTarget.value

				if (value.length > 0)
					obj.nextElementSibling.style.display = "none"
				else
					obj.nextElementSibling.style.display = ""
			})
		}

		let submit = this.querySelector("button.form-submit")
		submit.addEventListener("click", (e) =>
		{
			const email    = this.querySelector("input#email").value
			const password = this.querySelector("input#password").value

			const data = {email, password}

			fetch("api/login", {
				method: "POST",
				headers: {"Content-Type": "application/json"},
				body: JSON.stringify(data)
			})
				.then((r) => r.json())
				.then((r) =>
				{
					if (r.status === "accepted")
						window.location = "index.php"
				})
		})
	}
}
customElements.define("login-form", LoginForm)

class RegisterForm extends HTMLElement
{
	constructor()
	{
		super()

		this.content = template("register-form")
	}

	connectedCallback()
	{
		this.setAttribute("option", "register-form")
		this.appendChild(this.content)

		for (let obj of this.querySelectorAll(".field input"))
		{
			obj.addEventListener("input", function(e)
			{
				const value = e.currentTarget.value

				if (value.length > 0)
					obj.nextElementSibling.style.display = "none"
				else
					obj.nextElementSibling.style.display = ""
			})
		}
	}
}
customElements.define("register-form", RegisterForm)

function load()
{
	const formContainer = document.querySelector(".form-container")

	for (let obj of document.querySelectorAll(".option"))
	{
		obj.addEventListener("click", function(e)
		{
			const target = this.getAttribute("data-target")

			if (this.getAttribute("data-selected") == true)
				return

			for (let button of document.querySelectorAll(".option[data-selected=true]"))
			{
				button.setAttribute("data-selected", false)
			}

			this.setAttribute("data-selected", true)

			formContainer.innerHTML = ""

			formContainer.appendChild(document.createElement(target))
		})
	}

	document.querySelector(".container").removeAttribute("hidden")
}

document.addEventListener("DOMContentLoaded", load, false)