export const isSubmitting = (isSubmitting) => {
	disableLoginFields(isSubmitting);
	toggleButtonLoadingState(isSubmitting);
};

export const getFormData = (form) => {
	const formData = new FormData(form);
	const data = {};

	for (const [key, value] of formData.entries()) {
		data[key] = value;
	}

	return data;
};
