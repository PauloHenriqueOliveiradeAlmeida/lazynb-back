# 🏠 StayNB

Software que está sendo desenvolvido como Projeto Integrador para 3º Semestre de Análise e Desenvolvimento de Sistemas na UNISO.

## 🚀 Instalação

* ### Inicie seu servidor APACHE

* ### Inicie seu servidor MYSQL/MARIADB

* ### Defina as variáveis de conexão
	Defina sua conexão no script `server/models/database/serverconfig.php`

* ### Importe o `dump.sql`
	Importe o código em `dump.sql` para ter acesso às tabelas

* ### Mova a pasta
	Mova a pasta do projeto para seu diretório de acesso do APACHE:
	* Para Linux:
	`/opt/lampp/htdocs/www`

	* Para Windows:
	`C:/xampp/htdocs/www`

* ### Acesse o site
	Acesse http://localhost/www/staynb/cadastrar-colaborador.html


## 👾 Tecnologias utilizadas:

![Stack](https://img.shields.io/badge/HTML-red?logo=html5&logoColor=white&style=for-the-badge) ![Stack](https://img.shields.io/badge/CSS-blue?logo=CSS3&logoColor=white&style=for-the-badge) ![Stack](https://img.shields.io/badge/JAVASCRIPT-yellow?logo=javascript&logoColor=white&style=for-the-badge) ![Stack](https://img.shields.io/badge/PHP-blue?logo=PHP&logoColor=white&style=for-the-badge) ![Stack](https://img.shields.io/badge/MYSQL-blue?logo=mysql&logoColor=white&style=for-the-badge)

## 👥 Integrantes do grupo:

- Gabriel Roel
- Guilherme Muraro
- Kaira de Miranda
- Paulo Henrique

## 🗁 Organização de diretórios:

```
.						# Páginas e arquivos de configuração
├── assets/ 			# Arquivos necessários para o frontend
│   ├── images/         # Imagens do projeto
│	│	└──...
│   ├── scripts         # Códigos javascript
│	│
│   └── styles         	# Códigos CSS
│
└── server/				# Códigos do backend
	├── controllers/	# Controladores
	├── models/			# Modelos das tabelas
	│	└── database/	# Arquivos de conexão com banco de dados
	├── routes/			# Rotas de acesso ao backend
	└── utils/	# Utilitários necessários pelo sistema
```
