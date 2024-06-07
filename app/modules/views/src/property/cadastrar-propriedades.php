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
		<form id="form-stage-0">
			<h2>Cadastro de Propriedades</h2>
			<div>
				<label for="nome">Nome:</label>
				<input class="input" type="text" id="name" name="name" required />
			</div>

			<div>
				<label for="comodidades">Comodidades:</label>
				<select class="amenities" id="amenities" name="amenities" multiple required>
				</select>
			</div>

			<div>
				<label for="descricao">Descrição:</label>
				<input class="input" type="text" id="description" name="description" required />
			</div>

			<div>
				<label for="cliente">Cliente:</label>
				<select class="input" id="client" name="client_id" required>
				</select>
			</div>
			<button type="submit" class="button"><span>Próxima etapa</span></button>
		</form>

		<form id="form-stage-1" style="display: none;">
			<h2>Cadastro de Propriedades</h2>
			<div>
				<label for="cep">CEP</label>
				<input class="input" type="text" id="cep" name="CEP" required />
			</div>

			<div class="form-row">
				<div>
					<label for="neighborhood">Bairro:</label>
					<input class="input" type="text" id="neighborhood" name="neighborhood" required />
				</div>
				<div class="address-number">
					<label for="address-number">Número:</label>
					<input class="input" type="text" id="address-number" name="address_number" required />
				</div>
			</div>

			<div>
				<label for="complemento">Complemento:</label>
				<input class="input" type="text" id="complement" name="complement" required />
			</div>

			<div class="form-row">
				<div>
					<label for="city">Cidade:</label>
					<input class="input" type="text" id="city" name="city" readonly required />
				</div>
				<div class="uf">
					<label for="uf">UF:</label>
					<select id="estado" class="input" name="UF" required>
						<option value="AC">Acre</option>
						<option value="AL">Alagoas</option>
						<option value="AP">Amapá</option>
						<option value="AM">Amazonas</option>
						<option value="BA">Bahia</option>
						<option value="CE">Ceará</option>
						<option value="DF">Distrito Federal</option>
						<option value="ES">Espírito Santo</option>
						<option value="GO">Goiás</option>
						<option value="MA">Maranhão</option>
						<option value="MT">Mato Grosso</option>
						<option value="MS">Mato Grosso do Sul</option>
						<option value="MG">Minas Gerais</option>
						<option value="PA">Pará</option>
						<option value="PB">Paraíba</option>
						<option value="PR">Paraná</option>
						<option value="PE">Pernambuco</option>
						<option value="PI">Piauí</option>
						<option value="RJ">Rio de Janeiro</option>
						<option value="RN">Rio Grande do Norte</option>
						<option value="RS">Rio Grande do Sul</option>
						<option value="RO">Rondônia</option>
						<option value="RR">Roraima</option>
						<option value="SC">Santa Catarina</option>
						<option value="SP">São Paulo</option>
						<option value="SE">Sergipe</option>
						<option value="TO">Tocantins</option>
						<option value="EX">Estrangeiro</option>
					</select>
				</div>
			</div>

			<button type="submit" class="button"><span>Fazer Cadastro</span></button>
		</form>

		<div class="details">
			<img src="../../public/images/logo/logo.jpeg" alt="Logotipo" width="600" height="600" />
		</div>
	</div>

	<script type="module" src="./events/cadastrar-propriedades.js"></script>
</body>

</html>
