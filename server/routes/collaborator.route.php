<?php

require_once "../controllers/collaborator.controller.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$_method = $_POST['_method'];
	if ($_method) {
		if ($_method == "PUT") {
			if (isset($_GET['id'])) {
				$id = $_GET['id'];
				CollaboratorController::update($id, $_POST);
			}
		} elseif ($_method == "POST") {
			CollaboratorController::create($_POST);
		}
	} else {
		CollaboratorController::create($_POST);
	}
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		return CollaboratorController::getById($id);
	} else {
		return CollaboratorController::getAll();
	}
}
