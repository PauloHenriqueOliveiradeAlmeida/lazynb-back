<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../controllers/client/client.controller.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if (isset($_POST['_method'])) {
		$_method = $_POST['_method'];
		unset($_POST['_method']);
		if ($_method === "PUT") {
			if (isset($_GET['id'])) {
				$id = $_GET['id'];
				ClientController::update($id, $_POST);
			}
		} elseif ($_method === "POST") {
			ClientController::create($_POST);
		}
	} else {
		ClientController::create($_POST);
	}
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		return ClientController::getById($id);
	} else {
		return ClientController::getAll();
	}
}

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		return ClientController::delete($id);
	}
	else {
		throw new Exception('Id não fornecido', 400);
	}
}
