import { FormUtils } from "../../utils/form.js";
import { postCadastro } from "../../global/api.js";

const formCadastro = document.getElementById("formCadastro");

formCadastro.addEventListener("submit", async (event) => {
	console.log("Formulário de cadastro enviado");
	event.preventDefault();
	const { isSubmitting, notify, data } = new FormUtils(
		formCadastro,
		"cadastro",
	);

	try {
		isSubmitting(true);
		const response = await postCadastro(data);
		const { message, error } = await response.json();

		notify(
			error || message || "Cadastro realizado com sucesso!",
			error ? "danger" : "success",
		);

		window.location.href = "/login";
	} catch (error) {
		notify("Erro ao fazer cadastro. Por favor, tente novamente.", "danger");
	} finally {
		isSubmitting(false);
	}
});
