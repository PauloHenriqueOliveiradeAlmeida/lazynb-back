import { toast } from "../utils/toast.util.js";

export function handleException(error) {
	const http_codes = {
	200: () => 'info',
	400: () => 'info',
	401: () => 'info',
	404: () => 'info',
	409: () => 'info',
	500: () => 'error',
	}
	toast(error.data.message, http_codes[error.status]);
}


