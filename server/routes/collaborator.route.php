<?php

require_once  __DIR__ . "/../controllers/collaborator/collaborator.controller.php";
require_once __DIR__ . "/../utils/request-is-empty.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (!requestIsEmpty($_POST)) {
		CollaboratorController::create($_POST);
	}
	else {
		header("location: ../../cadastrar_colaborador.html?error=204");
	}
}
