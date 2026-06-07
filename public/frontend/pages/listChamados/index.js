import { getChamados } from "../../global/api.js";
const openChamadoBtn = document.getElementById("openChamadoBtn");
let listChamados = null;

const initializeTooltips = () => {
	const tooltipTriggerList = [].slice.call(
		document.querySelectorAll('[data-bs-toggle="tooltip"]'),
	);
	for (const tooltipTriggerEl of tooltipTriggerList) {
		new bootstrap.Tooltip(tooltipTriggerEl);
	}
};

// Espera o DOM carregar para adicionar os event listeners
const setupEventListeners = () => {
	const backBtn = document.getElementById("backBtn");
	if (backBtn) {
		backBtn.addEventListener("click", () => {
			window.location.href = "/dashboard";
		});
	}
};

openChamadoBtn.addEventListener("click", () => {
	const url = "/abrir-chamado";
	window.location.href = url;
});

const loadPage = (isLoading) => {
	const container = document.getElementById("listChamadosContainer");
	const load = document.getElementById("listChamadosLoad");

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
	listChamados = await getListChamados();
	renderListChamados(listChamados.chamados);
	loadPage(false);
};

const renderListChamados = (chamados) => {
	const containerChamadosList = document.getElementById(
		"chamadosListContainer",
	);

	if (!chamados || chamados.length === 0) {
		containerChamadosList.innerHTML = `
	  <div class="alert alert-warning w-100 " role="alert">
		Nenhum chamado encontrado. Clique em <strong>"Novo"</strong> para abrir um chamado.
	  </div>
	`;
		return;
	}

	const chamadosHTML = chamados
		.map(
			(chamado) => `
	  <div class="card mb-3 w-100 bg-light rounded-4 shadow-sm">
	  <div class="flex-row d-flex align-items-start justify-content-between px-2 py-1 ">

		<div class="card-body">
		  <h5 class="card-title">#${chamado.id_chamado} - ${chamado.titulo}</h5>
		  <p class="card-text my-2 ">${chamado.descricao}</p>
		  <ul class="card-text list-unstyled d-flex flex-row flex-wrap align-items-center gap-2 mb-0">
			<li>${chamado.departamento}</li>
			<li class="text-muted">|</li>
			<li>${chamado.regiao}</li>
			<li class="text-muted">|</li>
			<li>Resp: ${chamado.responsavel}</li>
		  </ul>
		</div>

		<div class="card-body justify-content-between align-items-end d-flex flex-column h-100 ">
		  <div class="card rounded-4 px-2 py-1 ${
				chamado.status === "ABERTO"
					? "bg-primary text-white"
					: chamado.status === "ANDAMENTO"
						? "bg-warning text-dark"
						: chamado.status === "RESOLVIDO"
							? "bg-success text-white"
							: chamado.status === "FECHADO"
								? "bg-secondary text-white"
								: "bg-light text-dark"
			}">
			<h6 class="card-text mb-0">${chamado.status}</h6>
		  </div>

		  <i data-feather="edit-2" class="editBtn text-secondary" style="width: 22px; height: 22px;" data-chamado-id="${chamado.id_chamado}"
          data-bs-toggle="tooltip" data-bs-title="Editar chamado"></i>

		</div>

	   </div>
	  </div>
	`,
		)
		.join("");

	containerChamadosList.innerHTML = chamadosHTML;

	// Inicia os tooltips após renderizar os chamados
	feather.replace();

	// Adiciona event listeners para os botões de editar
	const editBtns = document.querySelectorAll(".editBtn");

	for (const btn of editBtns) {
		btn.addEventListener("click", () => {
			const chamadoId = btn.getAttribute("data-chamado-id");
			const foundChamado = listChamados.chamados.find(
				(chamado) => chamado.id_chamado === Number.parseInt(chamadoId),
			);

			window.location.href = `/editar-chamado?id=${foundChamado.id_chamado}&titulo=${encodeURIComponent(foundChamado.titulo)}&descricao=${encodeURIComponent(
				foundChamado.descricao,
			)}&departamento=${encodeURIComponent(foundChamado.departamento)}&regiao=${encodeURIComponent(foundChamado.regiao)}&responsavel=${encodeURIComponent(
				foundChamado.responsavel,
			)}&status=${encodeURIComponent(foundChamado.status)}`;
		});
	}
};

const getListChamados = async () => {
	const response = await getChamados();
	const chamadosData = await response.json();
	return chamadosData;
};

const initializePage = async () => {
	await loadDashboardData();
	setupEventListeners();
	// Inicia os tooltips após o bootstrap carregar
	setTimeout(() => {
		initializeTooltips();
	}, 500);
};

initializePage();
