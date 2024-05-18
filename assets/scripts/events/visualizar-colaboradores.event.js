import { addTableData } from '../handlers/table.handler';
import { request } from '../services/request.service';

document.getElementById('body').addEventListener('load', async () => {
	const datas = await request('../../../server/routes/collaborator.route.php', 'GET');
	datas.forEach((data) => {
		addTableData(document.getElementById('table'), datas);
	});
});
