export function addTableData(table, datas, edit = true, remove = true) {
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
			edit_link.classList.add('fa-solid', 'fa-edit');
			edit_link.id = 'edit';
			table_data.appendChild(edit_link);
		}

		if (remove) {
			const remove_link = document.createElement('a');
			remove_link.classList.add('fa-solid', 'fa-trash');
			remove_link.id = 'remove';
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
