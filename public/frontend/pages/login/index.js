import { postLogin } from "../../global/api.js";
import { FormUtils } from "../../utils/form.js";

const form = document.getElementById("formLogin");

form.addEventListener("submit", async (event) => {
	event.preventDefault();
	const formUtils = new FormUtils(form, "login");

	try {
		formUtils.isSubmitting(true);
		const response = await postLogin(formUtils.data);
		const { message, error } = response.json();

		console.log("Resposta do servidor:", message || error);
	} catch (error) {
		console.error("Erro ao fazer login:", error);
	} finally {
		formUtils.isSubmitting(false);
	}
});
