import { postLogout } from "../../global/api.js";
const logoutBtn = document.getElementById("logoutBtn");
const editarDadosBtn = document.getElementById("editarDadosBtn");
const openChamadoBtn = document.getElementById("openChamadoBtn");
let userInfo = null;

logoutBtn.addEventListener("click", async () => {
	await postLogout();
	window.location.href = "/login";
});

editarDadosBtn.addEventListener("click", () => {
	const url = `/editar-dados?name=${encodeURIComponent(userInfo.name)}&email=${encodeURIComponent(userInfo.email)}&telefone=${encodeURIComponent(userInfo.telefone)}&cpf=${encodeURIComponent(userInfo.cpf)}`;
	window.location.href = url;
});

openChamadoBtn.addEventListener("click", () => {
	const url = "/abrir-chamado";
	window.location.href = url;
});

const loadPage = (isLoading) => {
	const container = document.getElementById("dashboardContainer");
	const load = document.getElementById("dashboardLoad");

	if (!isLoading) {
		container.classList.remove("d-none");
		load.classList.add("d-none");
		return;
	}

	container.classList.add("d-none");
	load.classList.remove("d-none");
};

const loadDashboardData = async () => {
	loadPage(true);
	userInfo = await getUserInfo();
	renderUserInfo(userInfo);
	loadPage(false);
};

const renderUserInfo = (userInfo) => {
	const helcomeMessage = document.getElementById("h1BemVindo");
	const userNameContainer = document.getElementById("user-name");
	const userEmailContainer = document.getElementById("user-email");
	const userPhoneContainer = document.getElementById("user-phone");
	const userCpfContainer = document.getElementById("user-cpf");

	helcomeMessage.textContent = `Olá, ${userInfo.name.split(" ")[0]}`;
	userNameContainer.textContent = userInfo.name;
	userEmailContainer.textContent = userInfo.email;
	userPhoneContainer.textContent = userInfo.telefone;
	userCpfContainer.textContent = userInfo.cpf;
};

const getUserInfo = async () => {
	const response = await fetch("/api/users/me");
	const userData = await response.json();
	return userData;
};

loadDashboardData();
