import { getFormData } from "../../handlers/form.handler.js";
import { handleException } from "../../services/handle-exception.service.js";
import { request } from "../../services/request.service.js";
import { clearMask, maskCpf } from "../../utils/mask-cpf.util.js";

document.getElementById('form').addEventListener('submit', async (e) => {
	e.preventDefault();
	const datas = getFormData('form');
	const create_client = await request('api/clients', 'POST', {
		...datas,
		is_admin: datas.is_admin === 'true'
	});
	const created = create_client.status;

	if (created === 201) {
		window.location.href = 'visualizar-clientes.html';
	}
	else {
		handleException(create_client);
	}
});

document.getElementById('cpf').addEventListener('blur', (e) => e.target.value = maskCpf(e.target.value));
document.getElementById('cpf').addEventListener('focus', (e) => e.target.value = clearMask(e.target.value));
