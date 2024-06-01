import { getFormData, fillForm } from '../../handlers/form.handler.js';
import { handleException } from '../../services/handle-exception.service.js';
import { request } from '../../services/request.service.js';
import { clearMask, maskCpf } from '../../utils/mask-cpf.util.js';

const id = new URLSearchParams(window.location.search).get('id');
document.addEventListener('DOMContentLoaded', async () => {

	try {
		const client = await request(`api/clients?id=${id}`, 'GET');
		fillForm('form', {
			...client.data,
			is_admin: !!client.data.is_admin
		});
	}
	catch(error) {
		handleException(error);
	}
});

document.getElementById('form').addEventListener('submit', async (e) => {
	e.preventDefault();
	const datas = getFormData('form');
	const update_client = await request(`api/clients?id=${id}`, 'PUT', {
		...datas,
		is_admin: datas.is_admin === 'true'
	});
	const updated = update_client.status;

	if (updated === 200) {
		window.location.href = 'visualizar-clientes.html';
	}
	else {
		handleException(update_clients);
	}
});

document.getElementById('CPF').addEventListener('blur', (e) => e.target.value = maskCpf(e.target.value));
document.getElementById('CPF').addEventListener('focus', (e) => e.target.value = clearMask(e.target.value))

