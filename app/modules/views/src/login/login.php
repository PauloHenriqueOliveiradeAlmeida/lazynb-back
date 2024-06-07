<!DOCTYPE html>
<html lang="pt-br">
<?php include_once("../../public/components/head/index.php") ?>

<body>
	<div class="background">
		<form id="form">
			<h2>Fazer Login</h2>
			<div>
				<label for="email">Email:</label>
				<input class="input" type="email" id="email" name="email" required />
			</div>

			<div>
				<label for="password">Senha:</label>
				<input class="input" type="text" id="password" name="password" required />
			</div>
			<button type="submit" class="button"><span>Fazer Login</span></button>
		</form>

		<div class="details">
			<img src="../../public/images/logo/logo.jpeg" alt="Imagem de Login" width="600" height="600" />
		</div>
	</div>

	<script type="module" src="events/login.event.js"></script>
</body>

</html>
