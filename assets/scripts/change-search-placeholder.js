document.getElementById("filter-type").addEventListener("change", (event) => {
	const search = document.getElementById("search")
	search.placeholder = event.target.options[event.target.selectedIndex].text

	search.setAttribute("is_cpf_cnpj", !search.getAttribute("is_cpf_cnpj"))
});
