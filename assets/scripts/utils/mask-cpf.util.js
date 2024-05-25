function maskCpf(input) {
	if (input.value.length === 11) {
		input.value = input.value.replace(/[^\d]/g, "").replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
	}
}

function clearMask(input) {
	input.value = input.value.replace(/[.\-/]/g, "");
}
