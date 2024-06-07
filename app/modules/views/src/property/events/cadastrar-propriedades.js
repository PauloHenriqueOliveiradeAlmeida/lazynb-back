import { fillForm, getFormData } from "../../../public/scripts/handlers/form.handler.js";
import { addSelectOptions } from "../../../public/scripts/handlers/select.handler.js";
import { request } from "../../../public/scripts/services/request.service.js";
import { handleException } from "../../../public/scripts/services/handle-exception.service.js";
import { maskCep } from "../../../public/scripts/utils/mask-cep.util.js";

let form_fields = {}

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
		new Choices(amenities_element, {
			choices: sanitized_amenities,
			addItems: true,
			removeItemButton: true,
			allowHTML: false,
			duplicatedItemsAllowed: false,
			noResultsText: 'Nenhum resultado encontrado...',
			noChoicesText: 'Nenhum resultado encontrado...',
			itemSelectText: ''
		});
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
	const create_property = await request('/api/properties', 'POST', {
		...form_fields,
		amenities
	});
	const created = create_property.status;

	if (created === 201) {
		window.location.href = 'visualizar-propriedades.php';
	}
	else {
		handleException(create_property);
	}
});

document.getElementById('cep').addEventListener('input', (e) => e.target.value = maskCep(e.target.value));

document.getElementById('cep').addEventListener('blur', async (e) => {
	if (e.target.value.length === 10) {
		const address_datas = (await request(`https://brasilapi.com.br/api/cep/v1/${e.target.value}`)).data;

		fillForm('form-stage-1', {
			...address_datas,
			UF: address_datas.state,
			complement: address_datas.street
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
