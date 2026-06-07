import { FormUtils } from "../../utils/form.js";
import { postEditarChamado } from "../../global/api.js";

const formEditarChamado = document.getElementById("formEditarChamado");
const chamadoCancelButton = document.getElementById("cancel-button");

// Função para preencher os campos do formulário com os dados do usuário
const fillFormWithUserData = () => {
	const urlParams = new URLSearchParams(window.location.search);
	document.getElementById("chamado-titulo").value =
		urlParams.get("titulo") || "";
	document.getElementById("chamado-descricao").value =
		urlParams.get("descricao") || "";
	document.getElementById("chamado-departamento").value =
		urlParams.get("departamento") || "";
	document.getElementById("chamado-regiao").value =
		urlParams.get("regiao") || "";
	document.getElementById("chamado-responsavel").value =
		urlParams.get("responsavel") || "";
	document.getElementById("chamado-status").value =
		urlParams.get("status") || "";
};

fillFormWithUserData();

chamadoCancelButton.addEventListener("click", () => {
	window.location.href = "/list-chamados";
});

formEditarChamado.addEventListener("submit", async (event) => {
	event.preventDefault();
	const { isSubmitting, notify, data } = new FormUtils(
		formEditarChamado,
		"chamado",
	);

	console.log("Dados do formulário:", data);

	try {
		isSubmitting(true);

		const urlParams = new URLSearchParams(window.location.search);
		const chamadoId = urlParams.get("id");

		const response = await postEditarChamado(data, chamadoId);
		const { message, error } = await response.json();

		notify(
			error || message || "Chamado editado com sucesso!",
			error ? "danger" : "success",
		);

		// Delay proposital para o usuário ver a notificação antes de redirecionar
		setTimeout(() => {
			window.location.href = "/list-chamados";
		}, 1000);
	} catch (error) {
		notify("Erro ao editar chamado. Por favor, tente novamente.", "danger");
	} finally {
		isSubmitting(false);
	}
});
