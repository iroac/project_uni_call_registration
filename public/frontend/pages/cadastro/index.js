import { FormUtils } from "../../utils/form.js";
import { ValidationUtils } from "../../utils/validation.js";
import { InputMaskUtils } from "../../utils/inputMask.js";
import { postCadastro } from "../../global/api.js";

// Máscaras de input para telefone e CPF

const inputPhone = document.getElementById("cadastro-telefone");
const inputCpf = document.getElementById("cadastro-cpf");

const { applyPhoneMask, applyCpfMask } = new InputMaskUtils();
inputPhone.addEventListener("input", (e) => applyPhoneMask(e));
inputCpf.addEventListener("input", (e) => applyCpfMask(e));

// Validação e envio do formulário de cadastro

const { validateEmail } = new ValidationUtils();
const formCadastro = document.getElementById("formCadastro");

formCadastro.addEventListener("submit", async (event) => {
	console.log("Formulário de cadastro enviado");
	event.preventDefault();
	const { isSubmitting, notify, data } = new FormUtils(
		formCadastro,
		"cadastro",
	);

	if (data.password !== data.confirmPassword) {
		notify("As senhas não coincidem.", "danger");
		return;
	}

	if (data.email && !validateEmail(data.email)) {
		notify("Por favor, insira um e-mail válido.", "danger");
		return;
	}

	try {
		isSubmitting(true);

		const { confirmPassword, ...cadastroData } = data; // Remove confirmPassword dos dados enviados

		const response = await postCadastro(cadastroData);
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
