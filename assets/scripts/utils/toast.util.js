export function toast(message, type = "sucess") {

	const toastifyTypes = {
		sucess: "#70e000",
		error: "#ef233c",
		info: "#669bbc",
		neutral: "#f7f7f7"
	}

	Toastify({
		text: message,
		duration: 3000,
		close: false,
		gravity: "bottom",
		position: "right",
		style: {
			background: toastifyTypes[type],
			fontSize: "1.2rem",
			padding: "1rem",
			color: type === "sucess" ? "#1E1E1E" : "#F7F7F7"
		}
	}).showToast();
}
