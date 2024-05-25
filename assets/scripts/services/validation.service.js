import { toast } from "../utils/toast.util.js";

const query = new URLSearchParams(window.location.search);

if (query.get("status")) {
	switch (Number(query.get("status"))) {
		case 201:
			toast("Informação cadastrada com sucesso", "sucess");
			break;

		case 409:
			toast("Há informações já cadastradas, verifique os dados e tente novamente", "info");
			break;

		case 204:
			toast("Informações obrigatórias não foram preenchidas, verifique os dados e tente novamente", "info");
			break;

	}
	query.delete("status");
	setTimeout(() => window.location.search = query, 3000);

}
