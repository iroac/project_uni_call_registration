import { postLogin } from "../../global/api.js";
import { FormUtils } from "../../utils/form.js";
import { ValidationUtils } from "../../utils/validation.js";

const form = document.getElementById("formLogin");
const { validateEmail } = new ValidationUtils();

form.addEventListener("submit", async (event) => {
	event.preventDefault();
	const { isSubmitting, notify, data } = new FormUtils(form, "login");

	if (data.email && !validateEmail(data.email)) {
		notify("Por favor, insira um e-mail válido.", "danger");
		return;
	}

	try {
		isSubmitting(true);
		const response = await postLogin(data);
		const { message, error } = await response.json();

		notify(
			error || message || "Login realizado com sucesso!",
			error ? "danger" : "success",
		);

		if (response.ok) {
			window.location.href = "/dashboard";
		}
	} catch (error) {
		notify("Erro ao fazer login. Por favor, tente novamente.", "danger");
	} finally {
		isSubmitting(false);
	}
});
