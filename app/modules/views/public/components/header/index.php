<header class="dashboard-header">
	<button id="menu-button">
		<i class="fa-solid fa-bars"></i>
	</button>
	<nav id="navbar" style="left: -300px">
		<ul>
			<li>
				<a href="../../src/dashboard/dashboard.php">
					<span>
						<i class="fa-solid fa-house"></i>
					</span>
					<span>Home</span>
				</a>
			</li>
			<li>
				<button id="register-button">
					<span>
						<i class="fa-solid fa-plus"></i>
					</span>
					<span>Cadastrar</span>
				</button>
				<ul id="register-submenu" class="submenu hidden">
					<li><a href="../../src/collaborator/cadastrar-colaborador.php">Colaboradores</a></li>
					<li><a href="../../src/client/cadastrar-clientes.php">Clientes</a></li>
					<li><a href="../../src/property/cadastrar-propriedades.php">Propriedades</a></li>
				</ul>
			</li>
			<li>
				<button id="consult-button">
					<span>
						<i class="fa-solid fa-eye"></i>
					</span>
					<span>Consultar</span>
				</button>
				<ul id="consult-submenu" class="submenu hidden">
					<li><a href="../../src/collaborator/visualizar-colaboradores.php">Colaboradores</a></li>
					<li><a href="../../src/client/visualizar-clientes.php">Clientes</a></li>
					<li><a href="../../src/property/visualizar-propriedades.php">Propriedades</a></li>
				</ul>
			</li>
			<li>
				<button id="logout-button">
					<span>
						<i class="fa-solid fa-right-from-bracket"></i>
					</span>
					<span>Sair</span>
				</button>
			</li>
		</ul>
	</nav>

	<script type="module">

		import { request } from "../../public/scripts/services/request.service.js";
		import { handleException } from "../../public/scripts/services/handle-exception.service.js";

		document.getElementById("menu-button").addEventListener("click", () => {
			document.getElementById("navbar").style.left = document.getElementById("navbar").style.left === "-300px" ? "0" : "-300px";
		});

		document.getElementById("register-button").addEventListener("click", () => {
			document.getElementById("register-submenu").classList.toggle("hidden");
			document.getElementById("consult-submenu").classList.add("hidden");
		});

		document.getElementById("consult-button").addEventListener("click", () => {
			document.getElementById("consult-submenu").classList.toggle("hidden");
			document.getElementById("register-submenu").classList.add("hidden");
		});

		document.getElementById("logout-button").addEventListener("click", async () => {
			try {
				const logout_successful = await request('/api/auth/logout');

				if (logout_successful.status === 200) {
					window.location.href = location.pathname + "/../../login/login.php";
				}
				else {
					throw logout_successful;
				}
			}
			catch (error) {
				handleException(error);
			}
		});
	</script>
</header>
