import { getFormData } from "../../../public/scripts/handlers/form.handler.js";
import { handleException } from "../../../public/scripts/services/handle-exception.service.js";
import { request } from "../../../public/scripts/services/request.service.js";
import { clearMask, maskCpf } from "../../../public/scripts/utils/mask-cpf.util.js";

document.getElementById('form').addEventListener('submit', async (e) => {
	e.preventDefault();
	const datas = getFormData('form');
	const create_collaborator = await request('/api/collaborators', 'POST', {
		...datas,
		is_admin: datas.is_admin === 'true'
	});
	const created = create_collaborator.status;

	if (created === 201) {
		window.location.href = 'visualizar-colaboradores.php';
	}
	else {
		handleException(create_collaborator);
	}
});

document.getElementById('cpf').addEventListener('blur', (e) => e.target.value = maskCpf(e.target.value) || e.target.value);
document.getElementById('cpf').addEventListener('focus', (e) => e.target.value = clearMask(e.target.value) || e.target.value);
