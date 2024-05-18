<?php

ini_set("display_errors", 1);

include "server/controllers/collaborator.controller.php";

$collaborators = CollaboratorController::getAll();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="https://kit.fontawesome.com/4adf0a3a74.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="style.css" />
	<title>Visualizar colaboradores</title>
</head>

<body>
	<div class="background visualizer-container">
		<div class="filter-container">
			<div>
				<input type="text" onfocus="clearMask(this)" onchange="maskCpfCnpj(this)" placeholder="Nome do colaborador" class="input" id="search" />
				<select name="type" class="input" id="filter-type">
					<option value="name" selected>Nome do colaborador</option>
					<option value="cpf">CPF do colaborador</option>
				</select>
			</div>
			<button class="button"><span>Limpar busca</span></button>
		</div>
		<div class="table-container">
			<table>
				<thead>
					<tr>
						<th>Nome:</th>
						<th>Email:</th>
						<th>Telefone:</th>
						<th>CPF</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php

					foreach ($collaborators as $collaborator) { ?>
						<tr>
							<td><?php echo $collaborator["name"]?></td>
							<td><?php echo $collaborator["email"]?></td>
							<td><?php echo $collaborator["phone_number"]?></td>
							<td><?php echo $collaborator["CPF"]?></td>
							<td class="actions">
								<i class="fa-solid fa-pencil edit"></i>
								<i class="fa-solid fa-trash"></i>
							</td>
						</tr>
					<?php } ?>
					<tr>
						<td>Nome</td>
						<td>login@email.com</td>
						<td>(12) 12345-6789</td>
						<td>123.456.789-00</td>
						<td class="actions">
							<i class="fa-solid fa-pencil edit"></i>
							<i class="fa-solid fa-trash"></i>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<script src="./assets/scripts/mask-cpf-cnpj.js"></script>
	<script src="./assets/scripts/change-search-placeholder.js"></script>
</body>

</html>
