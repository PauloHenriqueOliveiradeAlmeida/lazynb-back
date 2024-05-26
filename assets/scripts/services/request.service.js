export async function request(endpoint, method, data = {}) {
	const request = await fetch(endpoint, { method, [data && body]: JSON.stringify(data) });

	const response = await request.json();

	return response;
}
