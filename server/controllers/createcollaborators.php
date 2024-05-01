<?php
require_once "../models/collaborators.php";
require_once "../utils/requestIsEmpty.php";

if (!requestIsEmpty($_POST)){
	try{
		$collaborator = new Collaborators();

		$name = $_POST['name'];
		$CPF = $_POST['CPF'];
		$email = $_POST['email'];
		$phone_number = $_POST['phone_number'];
		$is_admin = $_POST['is_admin'];
		$password = $_POST['password'];

		$collaborator->name = $name;
		$collaborator->CPF = $CPF;
		$collaborator->email = $email;
		$collaborator->phone_number = $phone_number;
		$collaborator->setPermission($is_admin);
		$collaborator->setPassword($password);

		$collaborator->create();

		echo "Criado com Sucesso!";

	} catch (mysqli_sql_exception $e){
		switch ($e->getCode()){
			case 1062:
				echo "Error Duplicate Entry";
				break;
		}
	}
};




?>
