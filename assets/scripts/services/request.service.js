export async function request(endpoint, method, data = null) {
	const body = data ? {body: JSON.stringify(data)} : {};
	const request = await fetch(endpoint, { method, ...body});

	try {
		const response = await request.json();
		return {
			status: request.status,
			data: response,
		};

	}
	catch {
		return {
			status: request.status,
		};
	}
}
