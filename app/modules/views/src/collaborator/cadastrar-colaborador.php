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
			<h2>Cadastrar colaborador</h2>
			<div>
				<label for="nome">Nome Completo:</label>
				<input class="input" type="text" id="nome" name="name" required />
			</div>

			<div>
				<label for="cpf">CPF</label>
				<input class="input" type="text" id="cpf" name="CPF" required />
			</div>

			<div>
				<label for="email">Email:</label>
				<input class="input" type="email" id="email" name="email" required />
			</div>

			<div>
				<label for="contato">Contato:</label>
				<input class="input" type="tel" id="contato" name="phone_number" required />
			</div>

			<div>
				<label>Administrador?</label>
				<label>
					<input class="input" type="radio" name="is_admin" value="true" checked />
					Sim
				</label>
				<label>
					<input class="input" type="radio" name="is_admin" value="false" />
					Não
				</label>
			</div>

			<button type="submit" class="button"><span>Fazer Cadastro</span></button>
		</form>

		<div class="details">
			<img src="../../public/images/logo/logo.jpeg" alt="Imagem de Login" width="600" height="600" />
		</div>
	</div>

	<script type="module" src="events/cadastrar-colaboradores.event.js"></script>
</body>

</html>
