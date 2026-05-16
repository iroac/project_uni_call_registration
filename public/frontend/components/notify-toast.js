class NotifyToast extends HTMLElement {
	connectedCallback() {
		const message = this.getAttribute("message") || "Notificação";
		const type = this.getAttribute("type") || "success"; // tipos: primary, secondary, success, danger, warning, info, light, dark
		const id = this.getAttribute("toast-id") || `notify-${Date.now()}`;

		this.innerHTML = `
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
      <div id="${id}" class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive"
      aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            ${message}
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
            aria-label="Fechar"></button>
        </div>
      </div>
    </div>`;
	}
}

customElements.define("notify-toast", NotifyToast);
