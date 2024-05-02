<?php

require_once "../controllers/collaborator.controller.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (!requestIsEmpty($_POST)) {
		CollaboratorController::create($_POST);
	}
	else {
		header("location: ../../cadastrar_colaborador.html?error=204");
	}
}
