import { getFormData, fillForm } from '../../../public/scripts/handlers/form.handler.js';
import { handleException } from '../../../public/scripts/services/handle-exception.service.js';
import { request } from '../../../public/scripts/services/request.service.js';
import { clearMask, maskCpf } from '../../../public/scripts/utils/mask-cpf.util.js';
import { maskPhone } from "../../../public/scripts/utils/mask-phone.util.js";

const id = new URLSearchParams(window.location.search).get('id');
document.addEventListener('DOMContentLoaded', async () => {

	try {
		const client = await request(`/api/clients?id=${id}`, 'GET');

		if (client.status === 200) {
			fillForm('form', {
				...client.data,
				is_admin: !!client.data.is_admin
			});
		}
		else {
			throw client;
		}
	}
	catch(error) {
		handleException(error);
	}
});

document.getElementById('form').addEventListener('submit', async (e) => {
	e.preventDefault();
	const datas = getFormData('form');
	const update_client = await request(`/api/clients?id=${id}`, 'PUT', datas);
	const updated = update_client.status;

	if (updated === 200) {
		window.location.href = 'visualizar-clientes.php';
	}
	else {
		handleException(update_client);
	}
});

document.getElementById('CPF').addEventListener('blur', (e) => e.target.value = maskCpf(e.target.value));
document.getElementById('CPF').addEventListener('focus', (e) => e.target.value = clearMask(e.target.value));
document.getElementById('phone_number').addEventListener('blur', (e) => e.target.value = maskPhone(e.target.value));
document.getElementById('phone_number').addEventListener('focus', (e) => e.target.value = clearMask(e.target.value));

