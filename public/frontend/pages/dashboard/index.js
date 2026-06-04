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
	document.getElementById("h1BemVindo").textContent = `Olá, ${userInfo.name}`;
	loadPage(false);
};

const getUserInfo = async () => {
	const response = await fetch("/api/users/me");
	const userData = await response.json();
	return userData;
};

loadDashboardData();
