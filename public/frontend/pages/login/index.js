import { postLogin } from "../../global/api.js";
import { FormUtils } from "../../utils/form.js";

const form = document.getElementById("formLogin");

form.addEventListener("submit", async (event) => {
	event.preventDefault();
	const formUtils = new FormUtils(form, "login");

	try {
		formUtils.isSubmitting(true);
		const response = await postLogin(formUtils.data);
		const { message, error } = await response.json();

		formUtils.notify(
			error || message || "Login realizado com sucesso!",
			error ? "danger" : "success",
		);
	} catch (error) {
		formUtils.notify(
			"Erro ao fazer login. Por favor, tente novamente.",
			"danger",
		);
	} finally {
		formUtils.isSubmitting(false);
	}
});
