# 🚀 TradeSphere

> Sistema de gerenciamento de estoque multi-tenant desenvolvido com Laravel 12, Vue 3, PostgreSQL e Docker.

---

## Sobre o Projeto

O TradeSphere é uma plataforma de gerenciamento de estoque projetada para ambientes multi-tenant, construída utilizando tecnologias modernas e uma arquitetura baseada em containers.

A infraestrutura foi desenvolvida para proporcionar isolamento entre serviços, facilidade de implantação e persistência de dados, utilizando Docker Compose como orquestrador da aplicação.

---

### Tecnologias

- Laravel 12
- PHP 8.3 FPM
- Vue 3
- Vite
- PostgreSQL 15
- Docker Compose
- Nginx Alpine
- Node.js 20

---

### Arquitetura

A aplicação é composta por quatro serviços independentes.

| Serviço | Tecnologia | Função |
|----------|------------|--------|
| app | PHP 8.3 FPM | Processamento da aplicação Laravel |
| webserver | Nginx Alpine | Reverse Proxy e servidor web |
| db | PostgreSQL 15 | Persistência dos dados |
| node | Node.js 20 | Ambiente de desenvolvimento Vue 3 |

Todos os containers comunicam-se através de uma rede Docker dedicada.

---

### Estrutura da Documentação

A documentação técnica encontra-se na pasta **docs**.

| Documento | Descrição |
|------------|-----------|
| architecture.md | Arquitetura geral do sistema |
| docker.md | Infraestrutura Docker |
| database.md | Persistência de dados |
| api.md | Backend Laravel |
| deployment.md | Processo de implantação |
| tenancy.md | Arquitetura Multi-Tenant |
| decisions.md | Decisões arquiteturais |

---

### Instalação

#### 1. Subir os containers

```bash
docker compose up -d
```

#### 2. Instalar dependências do Laravel

```bash
docker compose exec app composer install
```

#### 3. Gerar a chave da aplicação

```bash
docker compose exec app php artisan key:generate
```

#### 4. Executar as migrations

```bash
docker compose exec app php artisan migrate
```

#### 5. Instalar dependências do Front-end

```bash
docker compose exec node npm install
```

#### 6. Executar o Vite

```bash
docker compose exec node npm run dev
```

---

### Estrutura da Infraestrutura

```
TradeSphere

├── app
├── docker
├── docs
├── resources
├── routes
├── docker-compose.yml
└── README.md
```

---

## Autor

Renato Oliveira

Projeto desenvolvido para fins acadêmicos e demonstração de arquitetura de software.