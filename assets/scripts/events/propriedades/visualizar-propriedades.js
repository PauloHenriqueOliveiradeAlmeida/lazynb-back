import { addTableData, clearTable } from '../../handlers/table.handler.js';
import { handleException } from '../../services/handle-exception.service.js';
import { request } from '../../services/request.service.js';
import { maskCpf, clearMask } from '../../utils/mask-cpf.util.js';

let properties = [];

document.addEventListener('DOMContentLoaded', async () => {
	try {
		properties = (await request('api/properties', 'GET')).data;
		properties.forEach((property) => addTableData('table', {
			...property,
			is_admin: property.is_admin ? 'SIM' : 'NÃO'
		}, 'editar-propriedades.html', 'api/properties'));
	}
	catch(error) {
		handleException(error);
	}
});

function mask(event) { maskCpf(event.target.value); }
function unmask(event) { clearMask(event.target.value); }

document.getElementById('search').addEventListener('input', (event) => {
	const search_type = document.getElementById('filter-type').value;

	if (!event.target.value) {
		clearTable('table');
		properties.forEach(property => addTableData('table', {
			...property,
			is_admin: property.is_admin ? 'SIM' : 'NÃO'
		}, 'editar-properties.html', 'api/properties'));
	}

	const filtered_properties = properties.filter(property => {
		const searched = event.target.value.toLowerCase();
		const search_field = search_type === 'name' ? property[search_type] : clearMask(property[search_type]);
		return search_field.toLowerCase().includes(searched);
	});
	clearTable('table');
	filtered_properties.forEach(property => addTableData('table', {
		...property,
		is_admin: property.is_admin ? 'SIM' : 'NÃO'
	}, 'editar-propriedades.html', 'api/properties'));
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
	properties.forEach(property => addTableData('table', {
		...property,
		is_admin: property.is_admin ? 'SIM' : 'NÃO'
	}, 'editar-property.html', 'api/properties'));
});



