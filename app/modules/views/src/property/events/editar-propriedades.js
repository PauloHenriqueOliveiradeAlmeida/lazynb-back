import { getFormData, fillForm } from '../../../public/scripts/handlers/form.handler.js';
import { addSelectOptions } from '../../../public/scripts/handlers/select.handler.js';
import { handleException } from '../../../public/scripts/services/handle-exception.service.js';
import { request } from '../../../public/scripts/services/request.service.js';
import { maskCep, unmaskCep } from '../../../public/scripts/utils/mask-cep.util.js';

const id = new URLSearchParams(window.location.search).get('id');
let choices;
let form_fields = {};

document.addEventListener('DOMContentLoaded', async () => {
	try {
		const clients = await request('/api/clients', 'GET');
		const amenities = await request('/api/amenities', 'GET');


		const sanitized_clients = clients.data.map(client => {
			return {
				value: client.id,
				label: client.name
			}
		});

		const sanitized_amenities = amenities.data.map(client => {
			return {
				value: client.id,
				label: client.name,
				id: client.id
			}
		});

		addSelectOptions('client', sanitized_clients);

		const amenities_element = document.getElementById('amenities');
		choices = new Choices(amenities_element, {
			choices: sanitized_amenities,
			addItems: true,
			removeItemButton: true,
			allowHTML: false,
			duplicatedItemsAllowed: false,
			noResultsText: 'Nenhum resultado encontrado...',
			noChoicesText: 'Nenhum resultado encontrado...',
			itemSelectText: ''
		});

		const property = await request(`/api/properties?id=${id}`, 'GET');

		fillForm('form-stage-0', {
			...property.data
		});
		fillForm('form-stage-1', {
			...property.data,
			CEP: maskCep(property.data.CEP)
		});

		const sanitized_selected_amenities = property.data.amenities.map(amenity => {
			return {
				value: amenity.amenityId,
				label: amenity.name
			}
		});
		choices.setValue(sanitized_selected_amenities);
	}
	catch (error) {
		handleException(error);
	}
});

document.getElementById('form-stage-0').addEventListener('submit', (e) => {
	e.preventDefault();

	e.target.style.display = 'none';
	form_fields = getFormData('form-stage-0')
	document.getElementById('form-stage-1').style = 'flex';
});

document.getElementById('form-stage-1').addEventListener('submit', async (e) => {
	e.preventDefault();
	const amenities = [...document.getElementById('amenities').children].map(amenity => amenity.value);
	const datas = getFormData('form-stage-1');
	form_fields = {...form_fields, ...datas};
	console.log(form_fields)
	delete form_fields.search_terms;
	const create_property = await request(`/api/properties?id=${id}`, 'PUT', {
		...form_fields,
		amenities
	});
	const created = create_property.status;

	if (created === 200) {
		window.location.href = 'visualizar-propriedades.php';
	}
	else {
		handleException(create_property);
	}
});

document.getElementById('cep').addEventListener('input', (e) => e.target.value = maskCep(e.target.value));
document.getElementById('cep').addEventListener('focus', (e) => e.target.value = unmaskCep(e.target.value));
document.getElementById('cep').addEventListener('blur', async (e) => {
	e.target.value = maskCep(e.target.value);
	if (e.target.value.length === 10) {
		const address_datas = (await request(`https://brasilapi.com.br/api/cep/v1/${e.target.value}`)).data;

		fillForm('form-stage-1', {
			...address_datas,
			UF: address_datas.state,
			complement: address_datas.street,
			CEP: maskCep(address_datas.cep)
		});
	}
	else {
		handleException({
			status: 200,
			data: {
				message: 'O CEP digitado é inválido, tente digitar novamente'
			}
		});
	}
});
