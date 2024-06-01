import { request } from "../services/request.service.js";

export function addTableData(table, datas, edit = false, remove = false) {
	const table_body = document.getElementById(table).getElementsByTagName('tbody')[0];

	const table_row = document.createElement('tr');
	table_body.appendChild(table_row);

	Object.keys(datas).forEach(key => {
		if (key !== 'id') {
			const table_data = document.createElement('td');
			table_data.innerText = datas[key];
			table_row.appendChild(table_data);
		}
	});

	if (edit || remove) {
		const table_data = document.createElement('td');
		table_data.classList.add('actions')
		table_row.appendChild(table_data);

		if (edit) {
			const edit_link = document.createElement('a');
			edit_link.href = `${edit}?id=${datas['id']}`;
			edit_link.classList.add('fa-solid', 'fa-edit');
			table_data.appendChild(edit_link);
		}

		if (remove) {
			const remove_link = document.createElement('a');
			remove_link.addEventListener('click', async () => {
				const isDeleted = await request(`${remove}?id=${datas['id']}`, 'delete');
				isDeleted.status === 200 && table_row.remove();
			});
			remove_link.classList.add('fa-solid', 'fa-trash');
			table_data.appendChild(remove_link);
		}
	}
}

export function clearTable(table) {
	const table_body = document.getElementById(table).getElementsByTagName('tbody')[0];
	const rows = [...table_body.children];
	rows.forEach(row => {
		row.remove();
	})
}
