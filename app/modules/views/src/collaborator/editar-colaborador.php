<?php

require_once __DIR__ . "/../../../../shared/auth/auth.service.php";

if (!Auth::check()) {
	header("location: ../login/login.html");
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
			<h2>Editar Colaboradores</h2>
			<div>
				<label for="nome">Nome do colaborador:</label>
				<input class="input" type="text" id="name" name="name" required />
			</div>
			<div>
				<label for="CPF">CPF do colaborador:</label>
				<input class="input" type="text" id="CPF" name="CPF" required />
			</div>
			<div>
				<label for="telefone">Telefone:</label>
				<input class="input" type="text" id="phone_number" name="phone_number" required />
			</div>
			<div>
				<label for="email">Email:</label>
				<input class="input" type="email" id="email" name="email" required />
			</div>
			<div>
				<label>Administrador?</label>
				<label>
					<input class="input" type="radio" name="is_admin" value="true" checked>
					Sim
				</label>
				<label>
					<input class="input" type="radio" name="is_admin" value="false">
					Não
				</label>
			</div>

			<button type="submit" class="button"><span>Editar colaborador</span></button>
		</form>

		<div class="details">
			<img src="../../public/images/logo/logo.jpeg" alt="Imagem de Login" width="600" height="600" />
		</div>
	</div>
	<script src="events/editar-colaboradores.events.js" type="module"></script>
</body>

</html>
