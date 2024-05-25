export function addSelectOptions(select, datas) {
	const select_box = document.getElementById(select);

	datas.forEach(data => {
		const option = document.createElement("option");
		option.value = data;
		option.text = data;
		select_box.appendChild(option);
	});
}

export function clearSelect(select) {
	const select_box = document.getElementById(select);
	const options = [...select_box.children];
	options.forEach(option => {
		if (option.value !== "default") {
			option.remove();
		}
	})
}
