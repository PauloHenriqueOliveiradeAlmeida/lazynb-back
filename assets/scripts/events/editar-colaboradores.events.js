import { request } from '../services/request.service.js';
import { clearMask, maskCpf } from '../utils/mask-cpf.util.js';

document.getElementById('body').addEventListener('load', async () => {
	const datas = await request('../../../server/routes/collaborator.route.php', 'GET');
	datas.forEach((data) => {
		addTableData(document.getElementById('table'), datas);
	});
});

document.getElementById('CPF').addEventListener('blur', (e) => maskCpf(e.target));
document.getElementById('CPF').addEventListener('focus', (e) => clearMask(e.target))

