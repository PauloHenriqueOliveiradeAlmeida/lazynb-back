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

	<?php include_once("../../public/components/header/index.php") ?>

	<div class="background visualizer-container">
		<div class="dashboard-buttons">
			<a href="../collaborator/visualizar-colaboradores.php" class="button">
				<span>Colaboradores</span>
			</a>
			<a href="../client/visualizar-clientes.php" class="button">
				<span>Clientes</span>
			</a>
			<a href="../property/visualizar-propriedades.php" class="button">
				<span>Propriedades</span>
			</a>
		</div>
	</div>
</body>

</html>
