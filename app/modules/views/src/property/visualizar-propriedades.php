<?php

require_once __DIR__ . "/../../../../shared/auth/auth.service.php";
include_once __DIR__ . "/../../public/components/add-button/add-button.php";

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
	<div class="background visualizer-container">
		<div class="filter-container">
			<div>
				<input type="text" placeholder="Nome da Propriedade" class="input" id="search" />
				<select class="input" name="filter-type" id="filter-type">
					<option value="name" selected>Nome da Propriedade</option>
					<option value="client_name">Nome do cliente</option>
					<option value="cpf">CPF do Proprietário</option>
				</select>
			</div>
			<button id="clear-search" class="button"><span>Limpar busca</span></button>
		</div>
		<div class="table-container">
			<table id="table">
				<thead>
					<tr>
						<th>Nome:</th>
						<th>Descrição:</th>
						<th>CEP:</th>
						<th>Endereço:</th>
						<th>Cliente:</th>
						<th>CPF cliente</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	</div>
	<?php addButton("cadastrar-propriedades.php") ?>
	<script type="module" src="events/visualizar-propriedades.js"></script>
</body>

</html>
