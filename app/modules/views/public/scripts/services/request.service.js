import { settings } from "../../../settings.js";

export async function request(endpoint, method, data = null) {

	const body = data ? { body: JSON.stringify(data) } : {};
	try {
		const request = await fetch(settings.base_url + endpoint, { method, ...body });

		const response = await request.json();
		return {
			status: request.status,
			data: response,
		};

	}
	catch (error) {
		return {
			status: error.response ? error.response.status : error.status,
			data: error
		};
	}
}
