export function maskPhone(value) {
	return value.replace(/[^\d]/g, "").replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");

}

export function clearMask(value) {
	return value.replace(/[.\-/]/g, "");
}

