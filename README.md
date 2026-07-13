# Online Ticket Booking System

Aplikasi web booking tiket online yang dibangun dengan Laravel 13, PHP 8.3, MySQL, dan Vite untuk frontend development.

## Tech Stack

- **Backend:** Laravel 13 + PHP 8.3
- **Database:** MySQL 8.0
- **Frontend:** Vite + Node.js
- **Container:** Docker & Docker Compose
- **Web Server:** Nginx
- **Cache/Session:** Redis (optional)

## Prerequisites

- Docker Desktop installed dan running
- Docker Compose v2+

## Quick Start

### 1) Setup dengan Vite (Recommended)

```bash
# Clone dan masuk ke project directory
cd online-ticket

# Build dan jalankan container
docker compose -f docker-compose.vite.yml up -d --build

# Masuk ke container app
docker exec -it ticket_app bash

# Setup Laravel
composer create-project laravel/laravel . "13.*"
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate

# Setup permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Install dependencies frontend
npm install
npm run dev
```

### 2) Setup tanpa Vite

```bash
docker compose up -d --build
docker exec -it ticket_app bash

composer create-project laravel/laravel . "13.*"
cp .env.example .env
php artisan key:generate
php artisan migrate
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Environment Variables

Pastikan di `.env`:
```
DB_HOST=db
DB_PORT=3306
DB_DATABASE=ticket_booking
DB_USERNAME=ticket_user
DB_PASSWORD=secret
```

## Akses Aplikasi

- **Application:** http://localhost:8000
- **phpMyAdmin:** http://localhost:8080

## Features

- Booking tiket online
- Manajemen user & authentication
- Pilihan seat dan payment
- Riwayat transaksi

## File Structure

- `docker-compose.yml` — setup default
- `docker-compose.vite.yml` — setup dengan Vite
- `docker/php/Dockerfile.vite` — PHP image dengan Node.js
- `install-vite.sh` / `install-vite.ps1` — script auto-install
