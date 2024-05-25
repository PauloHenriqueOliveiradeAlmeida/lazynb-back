import { addTableData } from '../handlers/table.handler.js';
import { request } from '../services/request.service.js';
import { maskCpf, clearMask } from '../utils/mask-cpf.util.js';

document.getElementById('body').addEventListener('load', async () => {
	const datas = await request('../../../server/routes/collaborator.route.php', 'GET');
	datas.forEach((data) => {
		addTableData(document.getElementById('table'), datas);
	});
});

const limparBtn = document.getElementById('limparBtn');

limparBtn.addEventListener('click', function () {
	document.getElementById('search').value = '';
});

document.getElementById('filter-type').addEventListener('change', (event) => {
	document.getElementById('search').value = '';
	document.getElementById('search').placeholder = event.target.options[event.target.selectedIndex].text;

	if (event.target.value === 'name') {
		document.getElementById('search').removeEventListener('blur', mask);
		document.getElementById('search').removeEventListener('focus', unmask);
	} else {
		document.getElementById('search').addEventListener('blur', mask);
		document.getElementById('search').addEventListener('focus', unmask);
	}
});

function mask(event) {
	maskCpf(event.target);
}
function unmask(event) {
	clearMask(event.target);
}

