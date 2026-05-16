import { postLogin } from "../../global/api.js";
import { getFormData, isSubmitting } from "../../utils/form.js";

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

form.addEventListener("submit", async (event) => {
	event.preventDefault();
	const data = getFormData(form);

	try {
		isSubmitting(true);
		const response = await postLogin(data);

		const { message, error } = await response.json();

		console.log("Resposta do servidor:", message || error);
	} catch (error) {
		console.error("Erro ao fazer login:", error);
	} finally {
		isSubmitting(false);
	}
});
