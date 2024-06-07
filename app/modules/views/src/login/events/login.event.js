import { getFormData } from "../../../public/scripts/handlers/form.handler.js";
import { handleException } from "../../../public/scripts/services/handle-exception.service.js";
import { request } from "../../../public/scripts/services/request.service.js";

document.getElementById('form').addEventListener('submit', async (e) => {
	e.preventDefault();
	const datas = getFormData('form');
	const login = await request('/api/auth/login', 'POST', datas);

	if (login.status === 200) {
		window.location.href = '../dashboard/dashboard.php';
	}
	else {
		handleException(login);
	}
});
