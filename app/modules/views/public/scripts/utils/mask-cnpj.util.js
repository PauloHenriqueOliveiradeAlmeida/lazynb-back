export function maskCnpj(cnpj) {
	return cnpj.replace(/[^\d]/g, "").replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.3/$4-$5");
}

export function unmaskCnpj(cnpj) {
	return cnpj.replace(/[-./]/g, "");
}
