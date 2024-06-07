export function fillForm(form, data) {
	const form_element = document.getElementById(form);

	Object.keys(data).forEach(key => {
		if (key !== 'id') {
			if (form_element.elements[key]) {
				form_element.elements[key].value = data[key];
			}
		}
	});
}

export function getFormData(form) {
	form = document.getElementById(form);
	const form_data = new FormData(form);
	return Object.fromEntries(form_data);
}
