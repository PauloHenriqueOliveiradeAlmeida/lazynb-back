export function maskCpf(value) {
	return value.replace(/[^\d]/g, "").replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4") ?? value;

}

export function clearMask(value) {
	return value.replace(/[.\-/]/g, "");
}

