# 🏠 Lazynb Backend

Backend do sistema de gestão imobiliária Lazynb, desenvolvido como Projeto Integrador da universidade

## 📚 Stack usada

![Stack](https://img.shields.io/badge/php-blue?logo=php&logoColor=white&style=for-the-badge) ![Stack](https://img.shields.io/badge/ravenframework-purple?logo=raven&logoColor=white&style=for-the-badge) ![Stack](https://img.shields.io/badge/docker-blue?logo=docker&logoColor=white&style=for-the-badge) ![Stack](https://img.shields.io/badge/postgresql-blue?logo=postgresql&logoColor=white&style=for-the-badge)


## 🦾 Funcionalidades

- Fluxo de autenticação (login, primeiro acesso, troca de senha)
- Fluxo de colaboradores
- Fluxo de clientes
- Fluxo de propriedades
- Consulta de CEP
- Envio de email


## 🔧 Configuração do projeto
### Faça build de uma nova imagem docker

```bash

docker build --no-cache  -t lazynb-back ./

```

### Importe o banco de dados

importe o arquivo `lazynb-dump.sql` no seu servidor PostgreSQL

### Defina as variáveis de ambiente

Crie um arquivo `.env` e defina as variáveis de ambiente:

```bash

# DATABASE
DATABASE_SERVER=string
DATABASE_PORT=integer
DATABASE_NAME=string
DATABASE_USER=string
DATABASE_PASSWORD=string

# MAILERSEND
MAILER_API_KEY=string
MAILER_DOMAIN=string
MAILER_REGISTRATION_TEMPLATE_ID=string
MAILER_RESET_PASSWORD_TEMPLATE_ID=string
MAILER_CONVERSATION_INVITE_TEMPLATE_ID=string
TALK_TO_US_EMAIL=string

# HASH
HASH_PASSWORD_COST=integer

# JWT
JWT_SECRET=integer

```

### Inicie o container

```bash

docker run -p 8000:8000 --env-file .env --name lazynb-back  lazynb-back:latest
```
