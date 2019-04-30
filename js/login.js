"use strict";

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

		const submit = this.querySelector("button.form-submit")
		submit.addEventListener("click", (e) =>
		{
			const email    = this.querySelector("input#email").value,
			      password = this.querySelector("input#password").value,
			      error    = document.querySelector("error-message")

			if (!email || !password)
			{
				error.show("Please fill out all fields!")

				return
			}

			const data = {email, password}

			fetch("api/login", {
				method: "POST",
				headers: {"Content-Type": "application/json"},
				body: JSON.stringify(data)
			})
				.then((r) => r.json())
				.then((r) =>
				{
					switch (r.status)
					{
						case "accepted":
							window.location = "index.php"
							break
						case "invalid":
							error.show("Hmm, we don't have a record of that email.")
							break
						case "denied":
							error.show("Those credentials don't seem to be right.")
							break
						default:
							error.show("Something is reeaaally wrong. Try again in a bit!")
							break
					}
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

		const submit = this.querySelector("button.form-submit")
		submit.addEventListener("click", (e) =>
		{
			const name     = this.querySelector("input#name").value,
			      email    = this.querySelector("input#email").value,
			      password = this.querySelector("input#password").value,
			      error    = document.querySelector("error-message")

			if (!email || !password || !name)
			{
				error.show("Please fill out all fields!")

				return
			}

			const data = {name, email, password}

			fetch("api/register", {
				method: "POST",
				headers: {"Content-Type": "application/json"},
				body: JSON.stringify(data)
			})
				.then((r) => r.json())
				.then((r) =>
				{
					switch (r.status)
					{
						case "accepted":
							window.location = "index.php"
							break
						case "invalid":
							error.show("Sorry, that email is already in use! Try another one.")
							break
						case "denied":
							error.show("Those credentials don't seem to be right.")
							break
						default:
							error.show("Something is reeaaally wrong. Try again in a bit!")
							break
					}
				})
		})
	}
}
customElements.define("register-form", RegisterForm)

class ErrorMessage extends HTMLElement
{
	constructor()
	{
		super()

		this.content = template("error-message")
	}

	static get observedAttributes()
	{
		return ["message"]
	}

	connectedCallback()
	{
		this.appendChild(this.content)
		this.text = this.querySelector("span")
		this.setAttribute("hidden", "true")
	}

	show(msg)
	{
		this.removeAttribute("hidden")
		this.text.textContent = msg
	}

	hide()
	{
		this.setAttribute("hidden", "")
	}
}
customElements.define("error-message", ErrorMessage)

function load()
{
	const formContainer = document.querySelector(".form-container")

	for (let obj of document.querySelectorAll(".option"))
	{
		obj.addEventListener("click", function(e)
		{
			const target = this.getAttribute("data-target")
			const error = document.querySelector("error-message")

			if (this.getAttribute("data-selected") == true)
				return

			for (let button of document.querySelectorAll(".option[data-selected=true]"))
			{
				button.setAttribute("data-selected", false)
			}

			this.setAttribute("data-selected", true)

			formContainer.innerHTML = ""

			formContainer.appendChild(document.createElement(target))

			error.hide()
		})
	}

	document.querySelector(".container").removeAttribute("hidden")
}

document.addEventListener("DOMContentLoaded", load, false)