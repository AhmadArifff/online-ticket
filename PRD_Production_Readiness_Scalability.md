# PRD Addendum --- Production Readiness, Scalability & High Concurrency

## Tujuan

Dokumen ini melengkapi PRD utama untuk memastikan sistem Online Ticket
Booking siap digunakan pada lingkungan production dengan trafik tinggi.

## 1. Slot Reservation System

### Kasus

Ribuan pengguna menekan tombol **Pesan Tiket** secara bersamaan sehingga
terjadi perebutan kuota.

### Solusi

-   Saat user memilih tiket, sistem membuat **reservation** selama 10
    menit.
-   Kuota dianggap **reserved**, bukan **terjual**.
-   Jika pembayaran berhasil, reservation menjadi **paid** dan kuota
    dikurangi permanen.
-   Jika waktu habis, reservation menjadi **expired** dan kuota
    dikembalikan.

Flow:

``` text
User -> Reserve Slot -> Countdown 10 menit
           |
           +-> Bayar berhasil -> Booking Final
           |
           +-> Timeout -> Slot dilepas
```

## 2. Virtual Waiting Room

### Kasus

50.000 user masuk bersamaan dan seluruh request menuju checkout.

### Solusi

-   Terapkan antrean virtual.
-   Misal hanya 200 user aktif di checkout.
-   User lain berada pada waiting room hingga slot tersedia.

## 3. Race Condition

### Kasus

Dua user membeli tiket terakhir pada waktu yang hampir sama.

### Solusi

-   Gunakan `DB::transaction()`
-   Gunakan `lockForUpdate()`
-   Gunakan Redis Distributed Lock.

## 4. Overselling Ticket

### Kasus

Jumlah tiket terjual melebihi kuota.

### Solusi

-   Kurangi kuota hanya setelah transaksi berhasil.
-   Semua update kuota dilakukan di dalam transaction.

## 5. Double Payment Callback

### Kasus

Payment gateway mengirim callback lebih dari satu kali.

### Solusi

-   Simpan `transaction_id` sebagai UNIQUE.
-   Terapkan idempotency key.

## 6. Double Click Checkout

### Kasus

User menekan tombol Bayar berkali-kali.

### Solusi

-   Disable tombol setelah klik.
-   Validasi booking code unik di backend.

## 7. Queue Processing

### Kasus

Generate QR, PDF, dan Email memperlambat response.

### Solusi

Gunakan Queue (Redis + Horizon) untuk pekerjaan asynchronous.

## 8. Cache Strategy

Cache: - Daftar event - Detail event - Kategori - Venue

TTL 5--10 menit, invalidasi saat data berubah.

## 9. Monitoring

Gunakan: - Laravel Horizon - Laravel Pulse - Prometheus - Grafana -
Sentry

Pantau response time, queue, error rate, CPU, RAM, slow query.

## 10. Disaster Recovery

-   Backup database otomatis.
-   Simpan aset di Object Storage (S3/MinIO).
-   Target RPO 15 menit, RTO 30 menit.

## 11. Horizontal Scaling

-   Stateless Laravel
-   Redis untuk session, cache, queue
-   Load Balancer
-   Shared Object Storage

## 12. Production Checklist

-   Redis Cache
-   Redis Queue
-   Redis Lock
-   HTTPS
-   OPcache
-   Rate Limiting
-   Health Check
-   Supervisor Queue Worker
-   Slow Query Log
-   Automated Backup

## Kesimpulan

Dengan Slot Reservation, Virtual Waiting Room, Redis Lock, Database
Transaction, Queue, Cache, Monitoring, dan Horizontal Scaling, sistem
mampu mengurangi risiko overselling, race condition, crash akibat
lonjakan trafik, duplicate payment, serta meningkatkan performa dan
keandalan pada lingkungan production.
