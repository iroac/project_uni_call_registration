import { postLogout } from "../../global/api.js";
const logoutBtn = document.getElementById("logoutBtn");

logoutBtn.addEventListener("click", async () => {
	await postLogout();
	window.location.href = "/login";
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
	const userInfo = await getUserInfo();
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
