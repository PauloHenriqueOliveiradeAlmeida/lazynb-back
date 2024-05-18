export function getFormData(form) {
	const form_data = new FormData(form);
	return Object.fromEntries(form_data);
}
