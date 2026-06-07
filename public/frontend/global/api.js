import { API_BASE_URL } from "../global/constants.js";

const defaultOptions = {
	credentials: "include",
	headers: { "Content-Type": "application/json" },
};

const apiFetch = (path, options = {}) => {
	const merged = {
		...defaultOptions,
		...options,
		headers: { ...defaultOptions.headers, ...(options.headers || {}) },
	};
	return fetch(`${API_BASE_URL}${path}`, merged);
};

// Auth
export const postLogin = (data) =>
	apiFetch("/auth/login", {
		method: "POST",
		body: JSON.stringify(data),
	});

export const postLogout = () =>
	apiFetch("/auth/logout", {
		method: "POST",
	});

export const postCadastro = (data) =>
	apiFetch("/users/register", {
		method: "POST",
		body: JSON.stringify(data),
	});

// User

export const getUserInfo = () => apiFetch("/users/me");

export const postUpdateUserInfo = (data) =>
	apiFetch("/users/update", {
		method: "PUT",
		body: JSON.stringify(data),
	});

// Chamados

export const getChamados = () => apiFetch("/chamados");

export const postAbrirChamado = (data) =>
	apiFetch("/chamados", {
		method: "POST",
		body: JSON.stringify(data),
	});
