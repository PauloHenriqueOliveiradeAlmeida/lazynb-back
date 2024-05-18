export function addTableData(table, datas) {
	const table_body = document.getElementById(table).getElementsByTagName("tbody")[0];

	const table_row = document.createElement("tr");
	table_body.appendChild(table_row);

	Object.keys(datas).forEach(key => {
		const table_data = document.createElement("td");
		table_data.innerText = datas[key];
		table_row.appendChild(table_data);
	});
}

export function clearTable(table) {
	const table_body = document.getElementById(table).getElementsByTagName("tbody")[0];
	const rows = [...table_body.children];
	rows.forEach(row => {
		row.remove();
	})
}
