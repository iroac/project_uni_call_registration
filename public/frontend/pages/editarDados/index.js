import { FormUtils } from "../../utils/form.js";
import { ValidationUtils } from "../../utils/validation.js";
import { InputMaskUtils } from "../../utils/inputMask.js";
import { postUpdateUserInfo } from "../../global/api.js";

// Função para preencher os campos do formulário com os dados do usuário
const fillFormWithUserData = () => {
	const urlParams = new URLSearchParams(window.location.search);
	document.getElementById("editar-name").value = urlParams.get("name") || "";
	document.getElementById("editar-email").value = urlParams.get("email") || "";
	document.getElementById("editar-telefone").value = urlParams.get("telefone") || "";
	document.getElementById("editar-cpf").value = urlParams.get("cpf") || "";
};

fillFormWithUserData();

// Máscaras de input para telefone e CPF

const inputPhone = document.getElementById("editar-telefone");
const inputCpf = document.getElementById("editar-cpf");

const { applyPhoneMask, applyCpfMask } = new InputMaskUtils();
inputPhone.addEventListener("input", (e) => applyPhoneMask(e));
inputCpf.addEventListener("input", (e) => applyCpfMask(e));

// Validação e envio do formulário de cadastro

const { validateEmail } = new ValidationUtils();
const formEditarDados = document.getElementById("formEditarDados");

formEditarDados.addEventListener("submit", async (event) => {
	console.log("Formulário de edição enviado");
	event.preventDefault();
	const { isSubmitting, notify, data } = new FormUtils(
		formEditarDados,
		"editar",
	);

	if (data.email && !validateEmail(data.email)) {
		notify("Por favor, insira um e-mail válido.", "danger");
		return;
	}

	try {
		isSubmitting(true);

		const { currentPassword, ...cadastroData } = data; // Remove currentPassword dos dados enviados

		const response = await postUpdateUserInfo(cadastroData);
		const { message, error } = await response.json();

		notify(
			error || message || "Dados atualizados com sucesso!",
			error ? "danger" : "success",
		);

		window.location.href = "/dashboard";
	} catch (error) {
		notify("Erro ao atualizar dados. Por favor, tente novamente.", "danger");
	} finally {
		isSubmitting(false);
	}
});
