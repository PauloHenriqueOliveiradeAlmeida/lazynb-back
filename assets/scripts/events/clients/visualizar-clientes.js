import { addTableData, clearTable } from '../../handlers/table.handler.js';
import { handleException } from '../../services/handle-exception.service.js';
import { request } from '../../services/request.service.js';
import { maskCpf, clearMask } from '../../utils/mask-cpf.util.js';

let clients = [];

document.addEventListener('DOMContentLoaded', async () => {
	try {
		clients = (await request('api/clients', 'GET')).data;
		clients.forEach((client) => addTableData('table', client, 'editar-clientes.html', 'api/clients'));
	}
	catch(error) {
		handleException(error);
	}
});

const mask = (event) => maskCpf(event.target.value);
const unmask = (event) => clearMask(event.target.value);

document.getElementById('search').addEventListener('input', (event) => {
	const search_type = document.getElementById('filter-type').value;

	if (!event.target.value) {
		clearTable('table');
		clients.forEach(client => addTableData('table', client, 'editar-clientes.html', 'api/clients'));
	}

	const filtered_clients = clients.filter(client => {
		const searched = event.target.value.toLowerCase();
		const search_field = search_type === 'name' ? client[search_type] : clearMask(client[search_type]);
		return search_field.toLowerCase().includes(searched);
	});
	clearTable('table');
	filtered_clients.forEach(clients => addTableData('table', client, 'editar-clientes.html', 'api/clients'));
});

document.getElementById('filter-type').addEventListener('change', (event) => {
	document.getElementById('search').value = '';
	document.getElementById('search').placeholder = event.target.options[event.target.selectedIndex].text;

	if (event.target.value === 'name') {
		document.getElementById('search').removeEventListener('input', mask);
		document.getElementById('search').removeEventListener('focus', unmask);
	} else {
		document.getElementById('search').addEventListener('input', mask);
		document.getElementById('search').addEventListener('focus', unmask);
	}
});

document.getElementById('clear-search').addEventListener('click', () => {
	document.getElementById('search').value = '';

	clearTable('table');
	clients.forEach(client => addTableData('table', client, 'editar-clientes.html', 'api/clients'));
});



