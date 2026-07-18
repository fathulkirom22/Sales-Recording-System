# Laravel Sales Recording System

A Laravel-based application for managing and recording sales, payments, and master data.  
This project provides a dashboard with analytics, sales management, payment tracking, and master data management for users and items.

---

## Features

### 1. Dashboard
- **Date Range Filter**: Affects widgets and charts.
- **Widgets**:
  - Total Transactions
  - Total Sales (in Rupiah)
  - Total Quantity of Items Sold
- **Charts**:
  - Monthly Sales (in Rupiah)
  - Item Sales Quantity per Item

### 2. Sales
- **Sales List**: Datatables + date filter
- **Add Sales**: Auto-generated code, multi-item lines, default status **Unpaid**
- **View / Edit / Delete**: Paid sales cannot be edited or deleted

### 3. Payments
- **Payment List**: Datatables + date filter
- **Add Payment**: Linked to one sale; supports partial payments (**Not Fully Paid**)
- **Delete Payment**: Reverts related sale status as needed

### 4. Master Data
- **Users**: CRUD + Spatie roles & permissions
- **Items**: Code, name, image upload, price

---

## Tech Stack
- **Framework**: Laravel 13
- **Frontend**: Blade, Tailwind, Alpine.js, jQuery Datatables (CDN)
- **Database**: PostgreSQL
- **Authentication**: Laravel Breeze (Blade)
- **Role & Permission**: Spatie Laravel Permission
- **Development & Deployment**: Docker Compose

---

## Project Structure (boilerplate)

```
app/
  Enums/SaleStatus.php
  Http/Controllers/   # Dashboard, Sale, Payment, Item, User (+ Breeze auth)
  Models/             # User, Item, Sale, SaleItem, Payment
  Support/CodeGenerator.php
database/
  migrations/         # users, permission, items, sales, sale_items, payments
  seeders/            # roles/permissions + default admin
docker/
  php/Dockerfile
  php/entrypoint.sh
resources/views/
  dashboard.blade.php
  sales|payments|items|users/   # index/create/edit/show stubs
  layouts/                      # app nav with module links
```

Controllers and views are **stubs** ready for full business logic.

---

## Default credentials

After seeding:

| Field    | Value              |
|----------|--------------------|
| Email    | `admin@example.com` |
| Password | `password`         |
| Role     | `admin`            |

---

## Local setup (without Docker)

Requirements: PHP 8.3+, Composer, Node 22+, PostgreSQL 16+

```bash
cp .env.example .env
# configure DB_* for your local PostgreSQL

composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

npm install
npm run dev   # or: npm run build

php artisan serve
```

Open http://localhost:8000 and log in with the admin credentials above.

---

## Docker Compose

Starts PHP app + PostgreSQL (optional Node Vite with profile).

```bash
cp .env.example .env

# Use postgres hostname when app runs inside Docker
# DB_HOST=postgres

docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

Frontend assets (Vite) on the host or via:

```bash
# Prefer host-side Vite (simplest):
npm install && npm run dev

# Or Vite inside Docker:
docker compose --profile frontend up node
```

App: http://localhost:8000  
Vite: http://localhost:5173  
Postgres: `localhost:5432` (`sales` / `secret` / db `sales_recording`)

**Docker + Vite note:** the container listens on `0.0.0.0:5173` so the port can be published, but the browser must use `localhost`. Set:

```env
VITE_HMR_HOST=localhost
VITE_DEV_SERVER_URL=http://localhost:5173
VITE_USE_POLLING=true
```

Do not put `0.0.0.0` in `VITE_APP_NAME` or `VITE_DEV_SERVER_URL` — `VITE_APP_NAME` is only the display name (from `APP_NAME`).

---

## Roles & permissions

Seeded roles:

- **admin** — full access
- **staff** — dashboard, sales, payments, items (view/create/update as defined)

Middleware aliases registered: `role`, `permission`, `role_or_permission`.

---

## Implementation notes

- Sale statuses: `unpaid`, `partially_paid` (Not Fully Paid), `paid` — see `App\Enums\SaleStatus`
- Document codes: use `App\Support\CodeGenerator::next(Model::class, 'SALE')` / `'PAY'`
- Paid sales must block edit/delete
- Payment amount must not exceed remaining sale amount
- Item images stored on the `public` disk

---
