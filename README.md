# TradeSphere 📦

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com/)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=flat-square&logo=vue.js)](https://vuejs.org/)
[![Inertia.js](https://img.shields.io/badge/Inertia.js-Modern%20Monolith-9553E9?style=flat-square&logo=inertia)](https://inertiajs.com/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-4169E1?style=flat-square&logo=postgresql)](https://www.postgresql.org/)
[![Docker](https://img.shields.io/badge/Docker-Containerized-2496ED?style=flat-square&logo=docker)](https://www.docker.com/)

**TradeSphere** is a enterprise-grade, multi-tenant inventory management system designed to process high-concurrency stock operations safely. Built on top of a modern monolith architecture using Laravel 12, Vue 3, and PostgreSQL, it guarantees database consistency and eliminates race conditions through database-level locking.

---

## 🌟 Key Features

- **Multi-Tenant Architecture**: Multi-tenant data segregation supporting UUIDs for distributed system readiness.
- **Atomic Stock Management**: Prevents race conditions during simultaneous purchase requests using PostgreSQL Pessimistic Locking (`FOR UPDATE`).
- **Modern Monolith Stack**: Seamless single-page application experience using Vue 3 and Inertia.js without the overhead of maintaining separate REST API auth layers.
- **Fully Containerized Infrastructure**: Multi-container Docker environment (PHP 8.3 FPM, Nginx Alpine, PostgreSQL 15, Node 20 LTS).

---

## 🏗️ Architecture & Tech Stack

- **Backend**: PHP 8.3 / Laravel 12
- **Frontend**: Vue 3 (Composition API) / Inertia.js / Tailwind CSS
- **Database**: PostgreSQL 15 (UUID Primary Keys, Pessimistic Locking)
- **Containerization**: Docker & Docker Compose
- **Build Tool**: Vite

---

## 🔒 Concurrency & Race Condition Prevention

In high-volume e-commerce and logistics systems, handling concurrent inventory reductions is critical. TradeSphere implements pessimistic database locking inside atomic database transactions:

```php
DB::transaction(function () use ($productId,$quantity) {
    // Locks the row in PostgreSQL until the transaction completes
    $inventory = Inventory::where('product_id',$productId)
        ->lockForUpdate()
        ->firstOrFail();

    if ($inventory->quantity <$quantity) {
        throw new \Exception("Insufficient stock.");
    }

    $inventory->decrement('quantity',$quantity);
    return $inventory;
});
```

## 🚀 Getting Started
#### Prerequisites
Ensure you have the following installed on your host machine:

* Docker Engine
* Docker Compose
* Git

#### Installation Setup
1. Clone the repository:

```
git clone git@github.com:YOUR_USERNAME/tradesphere.git
cd tradesphere
```
2. Configure environment variables:

```
cp .env.example .env
```

3. Start the Docker environment:

```
docker compose up -d --build
```

4. Install backend dependencies:

```
docker compose exec app composer install
```

5. Generate the application key:

```
docker compose exec app php artisan key:generate
```

6. Run database migrations and seeders:

```
docker compose exec app php artisan migrate --seed
```

7. Install frontend dependencies & run Vite server:

```
docker compose run --rm node npm install
docker compose run --rm --service-ports node npm run dev
```

8. Access the Application:
Open your browser and navigate to ```http://localhost:8000```.

## 📡 API Reference
#### Stock Reduction Endpoint
```POST /api/stock/reduce```

Request Body:

```JSON
{
  "product_id": "9b1deb4d-3b7d-4112-984e-030048e7e1e6",
  "quantity": 1
}
```
Response (```200 OK```):

```JSON
{
  "success": true,
  "message": "Estoque atualizado com sucesso!",
  "current_quantity": 9
}
```

## 📄 License
This project is licensed under the MIT License.
