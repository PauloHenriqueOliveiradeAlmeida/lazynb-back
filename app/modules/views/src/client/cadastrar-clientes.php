<?php

require_once __DIR__ . "/../../../../shared/auth/auth.service.php";

if (!Auth::check()) {
	header("location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<?php include_once("../../public/components/head/index.php") ?>

<body>

	<?php
	include_once("../../public/components/header/index.php");
	?>

	<div class="background">
		<form id="form">
			<h2>Cadastro de Cliente</h2>
			<div>
				<label for="nome">Nome Completo:</label>
				<input class="input" type="text" id="nome" name="name" required />
			</div>

			<div>
				<label for="cpf">CPF</label>
				<input class="input" type="text" id="cpf" name="CPF" maxlength="11" required />
			</div>

			<div>
				<label for="email">Email:</label>
				<input class="input" type="email" id="email" name="email" required />
			</div>

			<div>
				<label for="contato">Contato:</label>
				<input class="input" type="tel" id="phone_number" name="phone_number" maxlength="11" required />
			</div>

			<button type="submit" class="button"><span>Fazer Cadastro</span></button>
		</form>

		<div class="details">
			<img src="../../public/images/logo/logo.jpeg" alt="Logotipo" width="600" height="600" />
		</div>
	</div>

	<script type="module" src="events/cadastrar-clientes.event.js"></script>
</body>

</html>
