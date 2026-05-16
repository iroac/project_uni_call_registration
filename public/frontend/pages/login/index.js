import { postLogin } from "../../global/api.js";
import { FormUtils } from "../../utils/form.js";

const form = document.getElementById("formLogin");

form.addEventListener("submit", async (event) => {
	event.preventDefault();
	const { isSubmitting, notify, data } = new FormUtils(form, "login");

	try {
		isSubmitting(true);
		const response = await postLogin(data);
		const { message, error } = await response.json();

		notify(
			error || message || "Login realizado com sucesso!",
			error ? "danger" : "success",
		);
	} catch (error) {
		notify("Erro ao fazer login. Por favor, tente novamente.", "danger");
	} finally {
		isSubmitting(false);
	}
});
