import { API_BASE_URL } from "../global/constants.js";

export const postLogin = (data) =>
	fetch(`${API_BASE_URL}/auth/login`, {
		method: "POST",
		body: JSON.stringify(data),
		headers: {
			"Content-Type": "application/json",
		},
	});
