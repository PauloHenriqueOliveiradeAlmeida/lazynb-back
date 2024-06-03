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
				<input type="text" placeholder="Nome do Cliente" class="input" id="search" />
				<select name="type" class="input" id="filter-type">
					<option value="name" selected>Nome do cliente</option>
					<option value="CPF">CPF do cliente</option>
				</select>
			</div>
			<button id="clear-search" class="button"><span>Limpar busca</span></button>
		</div>
		<div class="table-container">
			<table id="table">
				<thead>
					<tr>
						<th>Nome:</th>
						<th>Email:</th>
						<th>Telefone:</th>
						<th>CPF:</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	</div>
	<script type="module" src="events/visualizar-clientes.event.js"></script>
</body>

</html>
