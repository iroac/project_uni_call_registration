import { API_BASE_URL } from "../global/constants.js";

export const postLogin = (data) =>
	fetch(`${API_BASE_URL}/auth/login`, {
		method: "POST",
		body: JSON.stringify(data),
		headers: {
			"Content-Type": "application/json",
		},
	});

export const postCadastro = (data) =>
	fetch(`${API_BASE_URL}/users/register`, {
		method: "POST",
		body: JSON.stringify(data),
		headers: {
			"Content-Type": "application/json",
		},
	});
