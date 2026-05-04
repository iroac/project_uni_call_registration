import { API_BASE_URL } from "../../global/constants.js";

const form = document.getElementById("formLogin");

const toggleButtonLoadingState = (isLoading) => {
	const loginButton = form.querySelector("button[type='submit']");
	const spinner = document.getElementById("loginButtonSpinner");
	if (isLoading) {
		loginButton.disabled = true;
		spinner.classList.remove("d-none");
	} else {
		loginButton.disabled = false;
		spinner.classList.add("d-none");
	}
};

const disableLoginFields = (isDisabled) => {
	const emailField = document.getElementById("loginEmail");
	const passwordField = document.getElementById("loginPassword");
	emailField.disabled = isDisabled;
	passwordField.disabled = isDisabled;
};

const isSubmitting = (isSubmitting) => {
	disableLoginFields(isSubmitting);
	toggleButtonLoadingState(isSubmitting);
};

form.addEventListener("submit", async (event) => {
	event.preventDefault();
	const formData = new FormData(form);

	const data = {};

	for (const [key, value] of formData.entries()) {
		data[key] = value;
	}

	try {
		isSubmitting(true);
		const response = await fetch(`${API_BASE_URL}/auth/login`, {
			method: "POST",
			body: JSON.stringify(data),
			headers: {
				"Content-Type": "application/json",
			},
		});

		const { message } = await response.json();

		console.log("Resposta do servidor:", message);
	} catch (error) {
		console.error("Erro ao fazer login:", error);
	} finally {
		isSubmitting(false);
	}
});
