export function parseCookies() {
	const cookies = document.cookie.split(';');
	let parsed_cookies = {};
	cookies.forEach((cookie) => {
		const [key, value] = cookie.split('=');
		parsed_cookies = {
			...parsed_cookies,
			[key.trim()]: value.trim(),
		};
	});
	return parsed_cookies;
}
