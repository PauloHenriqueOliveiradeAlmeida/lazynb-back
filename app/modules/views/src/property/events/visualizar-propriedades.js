import { addTableData, clearTable } from '../../../public/scripts/handlers/table.handler.js';
import { handleException } from '../../../public/scripts/services/handle-exception.service.js';
import { request } from '../../../public/scripts/services/request.service.js';
import { maskCpf, clearMask } from '../../../public/scripts/utils/mask-cpf.util.js';

let properties = [];

document.addEventListener('DOMContentLoaded', async () => {
	try {
		properties = (await request('/api/properties', 'GET')).data;
		properties.forEach((property) => addTableData('table', {
			id: property.id,
			name: property.name,
			description: property.description,
			CEP: property.CEP,
			address: `${property.address_number}, ${property.complement} - ${property.neighborhood}, ${property.city} - ${property.UF}`,
			client_name: property.client_name,
			cpf: maskCpf(property.cpf)
		}, 'editar-propriedades.php', '/api/properties'));
	}
	catch(error) {
		handleException(error);
	}
});

function mask(event) { event.target.value = maskCpf(event.target.value); }
function unmask(event) { event.target.value = clearMask(event.target.value); }

document.getElementById('search').addEventListener('input', (event) => {
	const search_type = document.getElementById('filter-type').value;

	if (!event.target.value) {
		clearTable('table');
		properties.forEach(property => addTableData('table', {
			id: property.id,
			name: property.name,
			description: property.description,
			CEP: property.CEP,
			address: `${property.address_number}, ${property.complement} - ${property.neighborhood}, ${property.city} - ${property.UF}`,
			client_name: property.client_name,
			cpf: maskCpf(property.cpf)
		}, 'editar-propriedades.php', '/api/properties'));
	}

	const filtered_properties = properties.filter(property => {
		const searched = event.target.value.toLowerCase();
		const search_field = ['property_name', 'client_name'].includes(search_type) ? property[search_type] : clearMask(property[search_type]);
		return search_field.toLowerCase().includes(searched);
	});

	clearTable('table');
	filtered_properties.forEach(property => addTableData('table', {
		id: property.id,
		name: property.name,
		description: property.description,
		CEP: property.CEP,
		address: `${property.address_number}, ${property.complement} - ${property.neighborhood}, ${property.city} - ${property.UF}`,
		client_name: property.client_name,
		cpf: maskCpf(property.cpf)
	}, 'editar-propriedades.php', '/api/properties'));
});

document.getElementById('filter-type').addEventListener('change', (event) => {
	document.getElementById('search').value = '';
	document.getElementById('search').placeholder = event.target.options[event.target.selectedIndex].text;

	if (['name', 'client_name'].includes(event.target.value)) {
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
		id: property.id,
		name: property.name,
		description: property.description,
		CEP: property.CEP,
		address: `${property.address_number}, ${property.complement} - ${property.neighborhood}, ${property.city} - ${property.UF}`,
		client_name: property.client_name,
		cpf: maskCpf(property.cpf)
	}, 'editar-propriedades.php', '/api/properties'));
});



