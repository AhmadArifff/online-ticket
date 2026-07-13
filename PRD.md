# PRD — Online Ticket Booking System

**Stack:** Laravel + Bootstrap 5 + MySQL + Docker
**Tipe Dokumen:** Product Requirement Document (Tahap Setup Awal Project)

---

## 1. Ringkasan Project

**Nama Project:** Online Ticket Booking System
**Tujuan:** Platform pemesanan tiket online (event, konser, seminar, dll) yang memungkinkan user mencari event, memilih jenis tiket, melakukan booking, dan menerima e-ticket. Admin dapat mengelola event, tiket, dan laporan penjualan.

**Target User:**
- **Customer** — mencari event, booking tiket, melihat riwayat transaksi.
- **Admin/Organizer** — mengelola event, tiket, monitoring penjualan.

**Tech Stack:**

| Layer | Teknologi |
|---|---|
| Backend Framework | Laravel 13 (PHP 8.3+) |
| Frontend Styling | Bootstrap 5 (Blade Template) |
| Build Tool | Vite (optional, requires Node.js 18+) |
| Database | MySQL 8 |
| Containerization | Docker & Docker Compose |
| Auth API | Laravel Sanctum |
| Web Server | Nginx |

---

## 2. Roadmap Pengembangan (4 Tahap)

| Tahap | Fokus | Output |
|---|---|---|
| 1 | Setup Environment (Docker) | Container siap jalan, Laravel terinstall |
| 2 | Database Design & Migration | Struktur tabel + file migration lengkap |
| 3 | Frontend Development | Tampilan Blade + Bootstrap (belum terhubung API) |
| 4 | Backend REST API | Endpoint API + integrasi ke frontend |

Catatan: Tahap 3 dikerjakan dengan data dummy/static dulu, baru di Tahap 4 dihubungkan ke REST API — supaya frontend & backend bisa dikerjakan secara terpisah dan lebih mudah di-debug.

---

## 3. TAHAP 1 — Setup Environment (Docker)

### 3.1 Struktur Folder

```
ticket-booking-system/
├── docker/
│   ├── php/
│   │   ├── Dockerfile
│   │   └── entrypoint.sh
│   └── nginx/
│       └── default.conf
├── src/                  # Laravel project di-mount di sini
├── docker-compose.yml
└── .env
```

### 3.1.1 Catatan Node.js

- Laravel 13 default skeleton menggunakan Vite untuk asset bundling.
- Jika Anda memilih **Laravel dengan Vite**, maka Node.js 18+ dan npm/yarn diperlukan untuk `npm install` dan `npm run dev` / `npm run build`.
- Node.js dapat dipasang di host lokal atau di dalam container/Node service jika Anda memperluas Docker setup.
- Jika Anda memilih **Laravel tanpa Vite**, maka Node.js tidak wajib: Anda dapat menggunakan Bootstrap via CDN atau asset statis tanpa build step.

### 3.2 docker-compose.yml

```yaml
version: '3.8'

services:
  app:
    build:
      context: ./docker/php
    container_name: ticket_app
    volumes:
      - ./src:/var/www/html
    working_dir: /var/www/html
    depends_on:
      - db
    networks:
      - ticket_network

  webserver:
    image: nginx:alpine
    container_name: ticket_webserver
    ports:
      - "8000:80"
    volumes:
      - ./src:/var/www/html
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - app
    networks:
      - ticket_network

  db:
    image: mysql:8.0
    container_name: ticket_db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: ticket_booking
      MYSQL_ROOT_PASSWORD: root
      MYSQL_USER: ticket_user
      MYSQL_PASSWORD: secret
    ports:
      - "3307:3306"
    volumes:
      - db_data:/var/lib/mysql
    networks:
      - ticket_network

  phpmyadmin:
    image: phpmyadmin:latest
    container_name: ticket_phpmyadmin
    restart: unless-stopped
    ports:
      - "8080:80"
    environment:
      PMA_HOST: db
    depends_on:
      - db
    networks:
      - ticket_network

networks:
  ticket_network:
    driver: bridge

volumes:
  db_data:
```

### 3.3 Dockerfile (docker/php/Dockerfile)

```dockerfile
FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Entrypoint yang otomatis benerin permission storage & bootstrap/cache
# setiap container start — supaya error "tempnam(): file created in the
# system's temporary directory" (gara-gara php-fpm worker jalan sebagai
# www-data tapi folder ter-mount dari Windows tidak writable) tidak
# terjadi lagi setelah composer create-project / reinstall project.
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
```

### 3.4 entrypoint.sh (docker/php/entrypoint.sh)

```bash
#!/bin/sh
set -e

# Jalan setiap kali container 'app' start.
# Kalau folder storage/bootstrap-cache sudah ada (Laravel sudah ter-install),
# pastikan writable oleh www-data (user yang menjalankan php-fpm worker).
if [ -d /var/www/html/storage ]; then
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
fi

exec "$@"
```

**Penting:** file ini butuh line ending **LF** (Unix), bukan CRLF — kalau dibuat/di-edit dari Notepad Windows biasa, simpan dengan editor yang mendukung LF (VSCode: klik "CRLF" di status bar pojok kanan bawah, ganti ke "LF"). Kalau line ending-nya salah, container akan error `entrypoint.sh: not found` atau `bad interpreter`.

### 3.5 Command Setup (jalankan di terminal cmd)

```bash
# 1. Build & jalankan container (rebuild wajib kalau Dockerfile/entrypoint.sh berubah)
docker-compose up -d --build

# 2. Masuk ke container app
docker exec -it ticket_app bash
```

#### 3.5.1 Setup A — Laravel dengan Vite

Jika Anda menggunakan Laravel 13 dengan Vite, jalankan langkah berikut di dalam container `ticket_app`:

```bash
# 1. Build & jalankan container (rebuild wajib kalau Dockerfile/entrypoint.sh berubah)
docker-compose up -d --build

# 2. Masuk ke container app
docker exec -it ticket_app bash

# 3. Install Laravel (jalankan DI DALAM container, bukan di PHP lokal Windows,
#    supaya versi dependency yang di-resolve composer konsisten dengan PHP di image)
composer create-project laravel/laravel . "13.*"

# 4. Copy .env & generate key (WAJIB sebelum apapun, tanpa ini langsung 500 error)
cp .env.example .env
php artisan key:generate

# 5. Set koneksi database di .env sesuai docker-compose
# DB_HOST=db
# DB_PORT=3306
# DB_DATABASE=ticket_booking
# DB_USERNAME=ticket_user
# DB_PASSWORD=secret

# 6. Generate migration tabel sessions — WAJIB karena default SESSION_DRIVER=database,
#    tapi skeleton Laravel tidak otomatis menyertakan migration ini
php artisan session:table

# 7. Jalankan migration dasar (users, cache, jobs, sessions) supaya aplikasi bisa
#    diakses tanpa error, SEBELUM masuk ke Tahap 2 (tabel custom project)
php artisan migrate

# 8. Pastikan storage & bootstrap/cache writable oleh php-fpm (www-data).
#    Entrypoint.sh sudah otomatis menjalankan ini setiap container start,
#    tapi jalankan manual sekali di awal untuk container yang sedang aktif:
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
npm install
npm run dev
```

- `npm install` akan menginstal dependensi Vite dan frontend package.
- `npm run dev` menjalankan Vite dev server.
- Untuk build production gunakan `npm run build`.

> Jika Anda tidak memasang Node.js di dalam container, Anda dapat menjalankan `npm install` dan `npm run dev` di host jika Node.js sudah tersedia secara lokal.

#### 3.5.2 Setup B — Laravel tanpa Vite

Jika Anda tidak ingin menggunakan Vite, gunakan Laravel dengan Blade/Bootstrap statis saja:

```bash
composer create-project laravel/laravel . "13.*"
cp .env.example .env
php artisan key:generate
```

- Lewati langkah `npm install` dan `npm run dev`.
- Gunakan Bootstrap via CDN atau aset CSS/JS statis di `public/`.

#### Langkah lanjutan (common untuk kedua alur)

```bash
# Pastikan koneksi database di .env sesuai docker-compose
# DB_HOST=db
# DB_PORT=3306
# DB_DATABASE=ticket_booking
# DB_USERNAME=ticket_user
# DB_PASSWORD=secret

# Generate migration tabel sessions — WAJIB karena default SESSION_DRIVER=database
php artisan session:table

# Jalankan migration dasar (users, cache, jobs, sessions)
php artisan migrate

# Pastikan storage & bootstrap/cache writable oleh php-fpm (www-data)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

> Migration tabel custom project (events, bookings, tickets, dll dari Tahap 2) dijalankan menyusul setelah file migration-nya dibuat — cukup `php artisan migrate` lagi, tidak perlu `migrate:fresh` supaya data yang sudah ada tidak hilang.

**Akses setelah setup:**
- App: `http://localhost:8000`
- phpMyAdmin: `http://localhost:8080`

### 3.5 Catatan Pemilihan Versi

| Opsi | Status | Kenapa tidak/dipakai |
|---|---|---|
| Laravel 11 | ❌ Dihindari | Dukungan keamanan sudah berakhir (12 Maret 2026); beberapa rilis 11.x juga sempat diblokir Composer karena security advisory saat awal setup project ini. |
| Laravel 12 | ✔️ Alternatif aman | Masih didukung, minimum PHP 8.2 — pilihan valid kalau butuh kompatibilitas package lama. |
| **Laravel 13** | ✔️ **Dipakai** | Rilis stabil terbaru, minimum PHP 8.3 (persis sama dengan image Docker kita), tanpa breaking change dari Laravel 12, dan seluruh package first-party (Sanctum, dll) sudah kompatibel. |

Karena Dockerfile kita sudah pakai `php:8.3-fpm`, tidak perlu ubah apa pun di image — Laravel 13 langsung jalan di atasnya.

---

## 4. TAHAP 2 — Database Design & Migration

### 4.1 Relasi Antar Tabel (ERD Ringkas)

```
users (1) ──< bookings (1) ──< booking_details >── (1) ticket_types >── (1) events >── (1) venues
                  │                                        │
                  └──< payments                            └── (1) categories

booking_details (1) ──< tickets (e-ticket individual per unit)
```

### 4.2 Daftar Tabel & Struktur

**users**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| name | varchar | |
| email | varchar, unique | |
| password | varchar | |
| phone | varchar | nullable |
| role | enum('customer','admin') | default customer |
| email_verified_at | timestamp | nullable |
| timestamps | | |

**categories**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| name | varchar | |
| slug | varchar, unique | |

**venues**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| name | varchar | |
| address | text | |
| city | varchar | index |
| capacity | int | |

**events**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| category_id | FK → categories | |
| venue_id | FK → venues | |
| name | varchar | |
| slug | varchar, unique | |
| description | text | |
| banner_image | varchar | nullable |
| start_date | datetime | index |
| end_date | datetime | |
| status | enum('draft','published','closed') | index |

**ticket_types**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| event_id | FK → events | index |
| name | varchar | contoh: Regular, VIP |
| price | decimal(10,2) | |
| quota | int | |
| sold | int | default 0 |

**bookings**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| user_id | FK → users | index |
| booking_code | varchar, unique | |
| total_amount | decimal(10,2) | |
| status | enum('pending','paid','cancelled','expired') | index |
| timestamps | | |

**booking_details**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| booking_id | FK → bookings | index |
| ticket_type_id | FK → ticket_types | |
| quantity | int | |
| subtotal | decimal(10,2) | |

**tickets** (e-ticket per unit, untuk scan/validasi)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| booking_detail_id | FK → booking_details | index |
| ticket_code | varchar, unique | |
| qr_code | varchar | path/string QR |
| is_used | boolean | default false |
| used_at | timestamp | nullable |

**payments**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| booking_id | FK → bookings | index |
| payment_method | varchar | |
| transaction_id | varchar, nullable | |
| amount | decimal(10,2) | |
| status | enum('pending','success','failed') | index |
| paid_at | timestamp | nullable |

### 4.3 Daftar File Migration (urutan penting karena foreign key)

```
2026_07_01_000001_create_categories_table.php
2026_07_01_000002_create_venues_table.php
2026_07_01_000003_create_events_table.php
2026_07_01_000004_create_ticket_types_table.php
2026_07_01_000005_create_bookings_table.php
2026_07_01_000006_create_booking_details_table.php
2026_07_01_000007_create_tickets_table.php
2026_07_01_000008_create_payments_table.php
```
(`users` memakai migration bawaan Laravel, tinggal tambah kolom `phone` dan `role` lewat migration tambahan.)

### 4.4 Strategi Performa & Indexing

Karena data booking berpotensi tumbuh cepat dan sering di-query (list event aktif, riwayat booking user, laporan penjualan), terapkan:
- Index pada kolom yang sering jadi filter/join: `event_id`, `user_id`, `status`, `start_date`, `booking_code`, `ticket_code`.
- Gunakan `foreignId()->constrained()->cascadeOnDelete()` sesuai kebutuhan relasi.
- Untuk laporan/agregasi berat (total penjualan per event), pertimbangkan query dengan `withCount`/`withSum` daripada N+1 query, atau cache hasilnya (Redis/cache table) selama beberapa menit.
- Gunakan `chunk()` atau queue job untuk proses massal (misal generate ratusan e-ticket sekaligus).

### 4.5 Seeder

- `CategorySeeder`, `VenueSeeder` — data awal untuk testing.
- `EventSeeder` + `TicketTypeSeeder` — beberapa event contoh dengan berbagai jenis tiket.
- `UserSeeder` — 1 admin + beberapa customer dummy.

---

## 5. TAHAP 3 — Frontend Development (Blade + Bootstrap 5)

*Dikerjakan dengan data dummy dulu, integrasi API menyusul di Tahap 4.*

### 5.1 Daftar Halaman

| Halaman | Route | Deskripsi |
|---|---|---|
| Home | `/` | Daftar event terbaru/populer |
| Event List | `/events` | List event + filter kategori/tanggal |
| Event Detail | `/events/{slug}` | Detail event + pilihan jenis tiket |
| Booking/Checkout | `/checkout` | Form pemesanan + ringkasan harga |
| Login/Register | `/login`, `/register` | Autentikasi customer |
| My Bookings | `/my-bookings` | Riwayat booking user |
| E-Ticket Detail | `/my-bookings/{code}` | Tampilkan QR code tiket |
| Admin Dashboard | `/admin` | Statistik penjualan |
| Admin Event CRUD | `/admin/events` | Kelola event & jenis tiket |

### 5.2 Layout & Komponen

- `layouts/app.blade.php` — layout utama customer (navbar, footer).
- `layouts/admin.blade.php` — layout sidebar untuk admin.
- Komponen Bootstrap yang dipakai: Navbar, Card (event card), Modal (konfirmasi booking), Form validation, Badge (status booking), Pagination.
- Gunakan Blade Components (`<x-event-card>`, `<x-status-badge>`) agar reusable dan clean.

### 5.3 Responsive Breakpoints (Bootstrap 5)

| Device | Breakpoint | Class Prefix |
|---|---|---|
| Mobile | < 768px (default) | tanpa prefix |
| Tablet | ≥ 768px | `md:` → `col-md-*` |
| Desktop | ≥ 1024px (gunakan `lg`) | `col-lg-*` |

Desain mobile-first: susun grid `col-12 col-md-6 col-lg-4` untuk card event, pastikan navbar collapse jadi hamburger menu di mobile.

---

## 6. TAHAP 4 — Backend REST API

### 6.1 Autentikasi

- Gunakan **Laravel Sanctum** untuk token-based auth (SPA/mobile-friendly, ringan dibanding Passport).
- Endpoint `POST /api/login` mengembalikan token, dipakai di header `Authorization: Bearer {token}` untuk request selanjutnya.

### 6.2 Daftar Endpoint API (prefix `/api/v1`)

| Method | Endpoint | Auth | Deskripsi |
|---|---|---|---|
| POST | `/auth/register` | - | Registrasi customer |
| POST | `/auth/login` | - | Login, return token |
| POST | `/auth/logout` | ✔ | Logout / revoke token |
| GET | `/events` | - | List event (filter, pagination) |
| GET | `/events/{slug}` | - | Detail event + ticket_types |
| POST | `/bookings` | ✔ | Buat booking baru |
| GET | `/bookings` | ✔ | Riwayat booking user |
| GET | `/bookings/{code}` | ✔ | Detail booking + e-ticket |
| POST | `/payments/{booking_code}` | ✔ | Proses/callback pembayaran |
| GET | `/admin/events` | ✔ (admin) | Kelola event |
| POST | `/admin/events` | ✔ (admin) | Tambah event |
| PUT | `/admin/events/{id}` | ✔ (admin) | Update event |
| DELETE | `/admin/events/{id}` | ✔ (admin) | Hapus event |
| GET | `/admin/reports/sales` | ✔ (admin) | Laporan penjualan |

### 6.3 Format Response Standard

```json
{
  "success": true,
  "message": "Booking berhasil dibuat",
  "data": {
    "booking_code": "TB-20260713-0001",
    "total_amount": 250000,
    "status": "pending"
  }
}
```

Error response konsisten:
```json
{
  "success": false,
  "message": "Kuota tiket tidak mencukupi",
  "errors": null
}
```

### 6.4 Arsitektur Kode (Clean Code & OOP)

Gunakan **Service Layer + Repository Pattern** agar Controller tetap ramping dan logic bisnis terpusat, memudahkan maintenance:

```
app/
├── Http/Controllers/Api/V1/
│   ├── EventController.php
│   └── BookingController.php
├── Services/
│   ├── BookingService.php     # logic hitung total, cek kuota, generate kode
│   └── TicketService.php      # generate QR code per ticket
├── Repositories/
│   ├── EventRepository.php
│   └── BookingRepository.php
└── Http/Resources/            # transform model → JSON response
    ├── EventResource.php
    └── BookingResource.php
```

### 6.5 Strategi Performa & Skalabilitas

Untuk menjaga performa saat traffic tinggi (mis. saat penjualan tiket dibuka serentak):
- **Race condition pada kuota tiket** — gunakan `DB::transaction()` + `lockForUpdate()` saat mengurangi `quota`/`sold` di `ticket_types`, agar tidak oversell saat banyak request bersamaan.
- **Queue** — proses generate e-ticket/QR code dan kirim email konfirmasi lewat `Job`/queue (Redis), bukan langsung di request-response cycle.
- **Cache** — cache response `GET /events` (list & detail) beberapa menit karena data ini jarang berubah dibanding proses booking.
- **Rate limiting** — terapkan `throttle` middleware di endpoint booking/payment untuk mencegah abuse.

---

## 7. Testing

- **Unit Test** — logic di `BookingService` (perhitungan total, validasi kuota).
- **Feature Test** — endpoint API utama (`/bookings`, `/auth/login`) menggunakan `Laravel Feature Test` + database `sqlite :memory:` untuk kecepatan.
- Laravel 13 memakai `phpunit/phpunit ^12.0` secara default (sudah otomatis ter-set lewat `composer create-project`, tidak perlu instalasi manual tambahan).

---

## 8. Ringkasan Urutan Kerja

1. ✅ Setup Docker (Laravel + MySQL + Nginx) → aplikasi bisa diakses di `localhost:8000`.
2. ✅ Buat migration sesuai struktur tabel di atas → `php artisan migrate` sukses tanpa error FK.
3. ⏳ Build tampilan Blade + Bootstrap dengan data dummy/seeder.
4. ⏳ Bangun REST API lalu hubungkan ke frontend (ganti data dummy dengan `fetch`/`axios` ke endpoint API).

---

*Dokumen ini adalah acuan awal (living document) — detail bisa disesuaikan seiring development berjalan.*