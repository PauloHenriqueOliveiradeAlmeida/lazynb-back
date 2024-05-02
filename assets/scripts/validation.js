import { toast } from "./toast.js";

const query = new URLSearchParams(window.location.search);

switch (Number(query.get("error"))) {
	case 409:
		toast("Há informações já cadastradas, verifique os dados e tente novamente", "info");
		break;

	case 204:
		toast("Informações obrigatórias não foram preenchidas, verifique os dados e tente novamente", "info");
		break;

}

if (query.get("sucess")) {
	toast("Operação realizada com sucesso", "sucess");
}
