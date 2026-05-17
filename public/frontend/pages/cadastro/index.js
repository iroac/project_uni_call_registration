import { FormUtils } from "../../utils/form.js";

const formCadastro = document.getElementById("formCadastro");

formCadastro.addEventListener("submit", async (event) => {
	event.preventDefault();
	const { isSubmitting, notify, data } = new FormUtils(
		formCadastro,
		"cadastro",
	);

	console.log("Dados do formulário:", data); // Verifique os dados do formulário
});
