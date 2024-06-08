import { getFormData } from "../../../public/scripts/handlers/form.handler.js";
import { handleException } from "../../../public/scripts/services/handle-exception.service.js";
import { request } from "../../../public/scripts/services/request.service.js";
import { clearMask, maskCpf } from "../../../public/scripts/utils/mask-cpf.util.js";
import { maskPhone } from "../../../public/scripts/utils/mask-phone.util.js";

document.getElementById('form').addEventListener('submit', async (e) => {
	e.preventDefault();
	const datas = getFormData('form');
	const create_client = await request('/api/clients', 'POST', datas);
	const created = create_client.status;

	if (created === 201) {
		window.location.href = 'visualizar-clientes.php';
	}
	else {
		handleException(create_client);
	}
});

document.getElementById('cpf').addEventListener('blur', (e) => e.target.value = maskCpf(e.target.value));
document.getElementById('cpf').addEventListener('focus', (e) => e.target.value = clearMask(e.target.value));
document.getElementById('phone_number').addEventListener('blur', (e) => e.target.value = maskPhone(e.target.value));
document.getElementById('phone_number').addEventListener('focus', (e) => e.target.value = clearMask(e.target.value));
