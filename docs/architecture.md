# Arquitetura do TradeSphere

## Visão Geral

O TradeSphere é uma plataforma de gerenciamento de estoque desenvolvida seguindo uma arquitetura baseada em containers, com separação clara de responsabilidades entre os serviços da aplicação.

Cada componente executa uma função específica dentro da infraestrutura, permitindo maior organização, isolamento entre processos e facilidade na manutenção do ambiente.

A aplicação utiliza o Docker Compose para orquestrar todos os serviços necessários para o funcionamento do sistema.

---

### Objetivos da Arquitetura

A arquitetura do TradeSphere foi projetada com os seguintes objetivos:

- Separação de responsabilidades entre os serviços.
- Isolamento dos componentes da aplicação.
- Facilidade de configuração do ambiente de desenvolvimento.
- Persistência dos dados.
- Comunicação segura entre os containers.
- Infraestrutura preparada para ambientes modernos de implantação.

---

### Componentes da Arquitetura

A infraestrutura é composta por quatro serviços independentes.

| Serviço | Container | Tecnologia | Responsabilidade |
|----------|-----------|------------|------------------|
| app | tradesphere-app | PHP 8.3 FPM | Executa a aplicação Laravel |
| webserver | tradesphere-web | Nginx Alpine | Atua como Reverse Proxy e servidor de arquivos estáticos |
| db | tradesphere-db | PostgreSQL 15 Alpine | Armazena os dados da aplicação |
| node | tradesphere-node | Node.js 20 Alpine | Ambiente de desenvolvimento do Vue 3 utilizando Vite |

Cada serviço possui uma responsabilidade específica, evitando o acúmulo de funções em um único container.

---

### Comunicação entre os Serviços

A comunicação entre os containers ocorre através de uma rede Docker dedicada.

Todos os serviços fazem parte da mesma rede privada, permitindo que os containers se comuniquem utilizando seus respectivos hostnames internos.

O banco de dados, por exemplo, é acessado utilizando o hostname:

```text
db
```

Essa abordagem elimina a necessidade de expor serviços internos diretamente para a rede pública.

---

### Fluxo da Aplicação

O fluxo básico da infraestrutura pode ser representado da seguinte forma:

```text
Cliente
    │
    ▼
Nginx
    │
    ▼
Laravel (PHP-FPM)
    │
    ▼
PostgreSQL

Node.js (Vite)
│
└── Ambiente de desenvolvimento Front-end
```

O Nginx recebe as requisições HTTP e encaminha o processamento para a aplicação Laravel.

O Laravel executa as regras de negócio e realiza a comunicação com o PostgreSQL para persistência dos dados.

O ambiente Node.js é utilizado exclusivamente durante o desenvolvimento da interface construída com Vue 3.

---

### Organização da Infraestrutura

A arquitetura foi organizada para manter cada responsabilidade isolada.

- Nginx atua como servidor web.
- Laravel concentra a lógica da aplicação.
- PostgreSQL é responsável pela persistência dos dados.
- Node.js executa o ambiente de desenvolvimento do Front-end.

Essa divisão favorece a manutenção da infraestrutura e facilita a evolução independente de cada componente.

---

### Considerações

A utilização de containers independentes proporciona um ambiente padronizado, reduz diferenças entre ambientes de desenvolvimento e facilita a reprodução da infraestrutura em diferentes máquinas.

Toda a arquitetura é orquestrada através do Docker Compose, permitindo inicializar todos os serviços utilizando um único comando.