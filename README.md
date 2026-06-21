# 📋 To-Do List — Lista de Tarefas

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-18-4169E1?logo=postgresql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)
![Render](https://img.shields.io/badge/Deploy-Render-46E3B7?logo=render&logoColor=white)

Aplicação web de **lista de tarefas (to-do list)** desenvolvida em **Laravel (PHP)**, com operações completas de **CRUD**, notificações em tempo real via **Telegram** e deploy na nuvem.

Projeto desenvolvido para a disciplina de **Desenvolvimento Baseado em Frameworks** (UNIGUAÇU).

## 🌐 Demo online

A aplicação está hospedada e rodando em:

**https://todolist-laravel-s8ns.onrender.com**

> ⚠️ **Observação:** o serviço usa o plano gratuito do Render, que "hiberna" após alguns minutos de inatividade. O **primeiro acesso** pode levar até ~50 segundos para "acordar" o servidor. Depois disso, fica rápido normalmente.

## ✨ Funcionalidades

- ✅ **CRUD completo** — criar, listar, editar e excluir tarefas
- ✅ **Marcar como concluída / reabrir** com um clique
- 🔎 **Filtros** — visualizar todas, apenas pendentes ou apenas concluídas
- 🔢 **Contador** de tarefas pendentes
- 📝 **Validação de formulário** com mensagens em português
- 📲 **Notificações no Telegram** — toda ação (criar, concluir, reabrir, editar, remover) envia um aviso automático para um grupo
- 🕒 **Fuso horário** ajustado para o horário de Brasília (UTC-3)

## 🛠️ Tecnologias utilizadas

| Tecnologia | Uso |
|---|---|
| **PHP 8.5** | Linguagem do back-end |
| **Laravel 13** | Framework (rotas, MVC, Eloquent) |
| **Blade** | Templates / views |
| **Tailwind CSS** | Estilização (via CDN) |
| **Composer** | Gerenciador de dependências |
| **SQLite** | Banco de dados em ambiente local |
| **PostgreSQL** | Banco de dados em produção |
| **Docker** | Containerização da aplicação |
| **Git + GitHub** | Versionamento e repositório |
| **Render** | Hospedagem em nuvem |
| **API do Telegram** | Notificações automáticas |

## 🚀 Como rodar o projeto localmente

### Pré-requisitos

- PHP 8.3 ou superior
- Composer
- Git

### Passo a passo

```bash
# 1. Clonar o repositório
git clone https://github.com/LeonardoArnold/todolist-laravel.git
cd todolist-laravel

# 2. Instalar as dependências
composer install

# 3. Criar o arquivo de ambiente
cp .env.example .env

# 4. Gerar a chave da aplicação
php artisan key:generate

# 5. Criar o banco SQLite local
# (crie um arquivo vazio em database/database.sqlite)

# 6. Rodar as migrations (cria as tabelas)
php artisan migrate

# 7. Subir o servidor
php artisan serve
```

Depois, acesse **http://localhost:8000** no navegador.

### Configurar as notificações do Telegram (opcional)

Para ativar os avisos no Telegram, adicione ao arquivo `.env`:

```env
TELEGRAM_BOT_TOKEN=seu_token_do_botfather
TELEGRAM_CHAT_ID=id_do_seu_grupo
```

> O token é gerado pelo **@BotFather** no Telegram, e o `chat_id` é obtido adicionando o bot ao grupo e consultando a API.

## ☁️ Deploy

O deploy é feito automaticamente no **Render** a cada `git push` na branch `main`, usando **Docker** para empacotar a aplicação (já que o Render não tem runtime nativo de PHP). O banco de dados em produção é um **PostgreSQL** gerenciado pelo próprio Render.

## 👤 Autores

**Leonardo Arnold** — [GitHub](https://github.com/LeonardoArnold)

**Ghilherme Borghezan**

**João Victor da Silva Santos**

---

<p align="center">Desenvolvido para a disciplina de Desenvolvimento Baseado em Frameworks — UNIGUAÇU</p>