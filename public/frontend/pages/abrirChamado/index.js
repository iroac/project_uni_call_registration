import { FormUtils } from "../../utils/form.js";
import { postAbrirChamado } from "../../global/api.js";

const formAbrirChamado = document.getElementById("formAbrirChamado");

formAbrirChamado.addEventListener("submit", async (event) => {
	event.preventDefault();
	const { isSubmitting, notify, data } = new FormUtils(
		formAbrirChamado,
		"chamado",
	);

	console.log("Dados do formulário:", data);

	try {
		isSubmitting(true);

		const response = await postAbrirChamado({ ...data, status: "ABERTO" });
		const { message, error } = await response.json();

		notify(
			error || message || "Chamado aberto com sucesso!",
			error ? "danger" : "success",
		);

		// Delay proposital para o usuário ver a notificação antes de redirecionar
		// setTimeout(() => {
		// 	window.location.href = "/dashboard";
		// }, 1000);
	} catch (error) {
		notify("Erro ao abrir chamado. Por favor, tente novamente.", "danger");
	} finally {
		isSubmitting(false);
	}
});
