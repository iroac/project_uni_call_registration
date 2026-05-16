export class FormUtils {
	data = {};
	#fields = [];

	#initFormData() {
		const formData = new FormData(this.formElement);
		const data = {};

		for (const [key, value] of formData.entries()) {
			data[key] = value;
		}

		this.data = data;
		this.#fields = Object.keys(data);
	}

	constructor(formElement, action) {
		this.formElement = formElement;
		this.action = action; // é o id do form, deve ser unico por form na página;
		this.#initFormData();
	}

	toggleButtonLoadingState = (isLoading) => {
		const button = this.formElement.querySelector("button[type='submit']");
		const spinner = document.getElementById(`${this.action}-button-spinner`);

		if (isLoading) {
			button.disabled = true;
			spinner.classList.remove("d-none");
		} else {
			button.disabled = false;
			spinner.classList.add("d-none");
		}
	};

	disableLoginFields = (isDisabled) => {
		for (const field of this.#fields) {
			const inputField = document.getElementById(`${this.action}-${field}`);

			if (inputField) {
				inputField.disabled = isDisabled;
			}
		}
	};

	isSubmitting = (isSubmitting) => {
		this.disableLoginFields(isSubmitting);
		this.toggleButtonLoadingState(isSubmitting);
	};
}
