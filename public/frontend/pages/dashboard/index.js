import { postLogout } from "../../global/api.js";
const logoutBtn = document.getElementById("logoutBtn");

logoutBtn.addEventListener("click", async () => {
	await postLogout();
	window.location.href = "/login";
});
