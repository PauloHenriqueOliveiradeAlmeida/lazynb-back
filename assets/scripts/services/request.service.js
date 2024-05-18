export async function request(endpoint, method, data = {}) {
	const request = await fetch(endpoint, { method, body: JSON.stringify(data) });

	const data = await request.json();

	return data;
}
