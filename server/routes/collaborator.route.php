<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once  "../controllers/collaborator/collaborator.controller.php";
require_once "../utils/request-is-empty.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (!requestIsEmpty($_POST)) {
		CollaboratorController::create($_POST);
	}
	else {
		header("location: ../../cadastrar_colaborador.html?error=204");
	}
}
