import { getFormData, fillForm } from '../handlers/form.handler.js';
import { handleException } from '../services/handle-exception.service.js';
import { request } from '../services/request.service.js';
import { clearMask, maskCpf } from '../utils/mask-cpf.util.js';

const id = new URLSearchParams(window.location.search).get('id');
document.addEventListener('DOMContentLoaded', async () => {

	try {
		const collaborator = await request(`api/collaborators?id=${id}`, 'GET');
		fillForm('form', {
			...collaborator.data,
			is_admin: !!collaborator.data.is_admin
		});
	}
	catch(error) {
		handleException(error);
	}
});

document.getElementById('form').addEventListener('submit', async (e) => {
	e.preventDefault();
	const datas = getFormData('form');
	const update_collaborator = await request(`api/collaborators?id=${id}`, 'PATCH', {
		...datas,
		is_admin: datas.is_admin === 'true'
	});
	const updated = update_collaborator.status;

	if (updated === 200) {
		window.location.href = 'visualizar-colaboradores.html';
	}
	else {
		handleException(update_collaborator);
	}
});

document.getElementById('CPF').addEventListener('blur', (e) => e.target.value = maskCpf(e.target.value));
document.getElementById('CPF').addEventListener('focus', (e) => e.target.value = clearMask(e.target.value))

