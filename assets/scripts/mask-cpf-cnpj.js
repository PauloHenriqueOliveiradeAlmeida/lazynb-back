function maskCpfCnpj(input) {
	if (input.getAttribute("is_cpf_cnpj")) {
		if (input.value.length === 11) {
			input.value = input.value.replace(/[^\d]/g, "").replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
		}
		else if (input.value.length === 14) {
			input.value = input.value.replace(/[^\d]/g, "").replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
		}
	}
}


function clearMask(input) {
	if (input.getAttribute("is_cpf_cnpj")) {
		input.value = input.value.replace(/[.\-/]/g, "")
	}
}
