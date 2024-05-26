export function maskCpf(value) {
	if (value.length === 11) {
		return value.replace(/[^\d]/g, "").replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
	}
}

export function clearMask(value) {
	return value.replace(/[.\-/]/g, "");
}

