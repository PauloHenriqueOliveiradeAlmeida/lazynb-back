<?php

require_once __DIR__ . "/../../../../shared/auth/auth.service.php";

if (!Auth::check()) {
	header("location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<?php include_once("../../public/components/head/index.php") ?>

<body id="body">

	<?php
	include_once("../../public/components/header/index.php");
	?>

	<div class="background">
		<form id="form">
			<h2>Editar Clientes</h2>
			<div>
				<label for="nome">Nome do Cliente:</label>
				<input class="input" type="text" id="name" name="name" required />
			</div>
			<div>
				<label for="CPF">CPF do Cliente:</label>
				<input class="input" type="text" id="CPF" name="CPF" maxlength="11" required />
			</div>
			<div>
				<label for="telefone">Telefone:</label>
				<input class="input" type="text" id="phone_number" name="phone_number" maxlength="11" required />
			</div>
			<div>
				<label for="email">Email:</label>
				<input class="input" type="email" id="email" name="email" required />
			</div>


			<button type="submit" class="button"><span>Editar cliente</span></button>
		</form>

		<div class="details">
			<img src="../../public/images/logo/logo.jpeg" alt="Logotipo" width="600" height="600" />
		</div>
	</div>
	<script src="events/editar-clientes.event.js" type="module"></script>
</body>

</html>
