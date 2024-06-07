export function maskCep(cep) {
	return cep.replace(/[^\d]/g, "").replace(/(\d{2})(\d{3})(\d{3})/, "$1.$2-$3");
}

export function unmaskCep(cep) {
	return cep.replace(/[-.]/g, "");
}
