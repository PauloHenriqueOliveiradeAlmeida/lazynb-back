import { addTableData, clearTable } from '../../../public/scripts/handlers/table.handler.js';
import { handleException } from '../../../public/scripts/services/handle-exception.service.js';
import { request } from '../../../public/scripts/services/request.service.js';
import { maskCpf, clearMask } from '../../../public/scripts/utils/mask-cpf.util.js';

let collaborators = [];

document.addEventListener('DOMContentLoaded', async () => {
	try {
		collaborators = await request('/api/collaborators', 'GET');

		if (collaborators.status === 200) {
			collaborators.data.forEach((collaborator) => addTableData('table', {
				...collaborator,
				is_admin: collaborator.is_admin ? 'SIM' : 'NÃO'
			}, 'editar-colaborador.php', '/api/collaborators'));
		}
		else {
			throw collaborators;
		}

	}
	catch(error) {
		handleException(error);
	}
});

const mask = (event) => event.target.value = maskCpf(event.target.value);
const unmask = (event) => event.target.value = clearMask(event.target.value);

document.getElementById('search').addEventListener('input', (event) => {
	const search_type = document.getElementById('filter-type').value;

	if (!event.target.value) {
		clearTable('table');
		collaborators.data.forEach(collaborator => addTableData('table', {
			...collaborator,
			is_admin: collaborator.is_admin ? 'SIM' : 'NÃO'
		}, 'editar-colaborador.php', '/api/collaborators'));
	}

	const filtered_collaborators = collaborators.data.filter(collaborator => {
		const searched = event.target.value.toLowerCase();
		const search_field = search_type === 'name' ? collaborator[search_type] : clearMask(collaborator[search_type]);
		return search_field.toLowerCase().includes(searched);
	});
	clearTable('table');
	filtered_collaborators.forEach(collaborator => addTableData('table', {
		...collaborator,
		is_admin: collaborator.is_admin ? 'SIM' : 'NÃO'
	}, 'editar-colaborador.php', '/api/collaborators'));
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
	collaborators.data.forEach(collaborator => addTableData('table', {
		...collaborator,
		is_admin: collaborator.is_admin ? 'SIM' : 'NÃO'
	}, 'editar-colaborador.php', '/api/collaborators'));
});



