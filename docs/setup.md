# Setup Guide

## Prerequisites

- Docker (Docker Engine + Docker Compose)

## First Run

```sh
# Build image dan start containers
docker compose up --build -d
```

Tunggu beberapa detik sampai PostgreSQL siap (healthcheck akan delay app startup sampai DB ready).

Buka http://localhost:8080 — harusnya muncul "Connected to PostgreSQL!".

## Daily Use

```sh
# Start (setelah pertama kali build)
docker compose up -d

# Stop
docker compose down

# Stop + hapus semua data DB (reset total)
docker compose down -v

# Lihat log aplikasi
docker compose logs -f app

# Lihat log database
docker compose logs -f db

# Restart setelah edit php.ini atau shared/db.php
docker compose restart
```

## Struktur Modul

Buat folder per modul di dalam `src/`:

```
src/
├── 01-intro/
│   └── index.php
├── 02-forms/
│   └── index.php
└── shared/
    └── db.php
```

Akses modul via: `http://localhost:8080/<nama-folder>/`

## Database Connection

Gunakan file `shared/db.php` yang sudah disediakan:

```php
<?php
require __DIR__ . '/../shared/db.php';

$pdo = getDB();

// Contoh query
$stmt = $pdo->query('SELECT * FROM users');
$users = $stmt->fetchAll();
```

Konfigurasi PDO yang sudah diset:
- `ERRMODE_EXCEPTION` — throw exception kalau query gagal
- `FETCH_ASSOC` — hasil query dalam array associative
- `EMULATE_PREPARES = false` — prepared statements diproses oleh PostgreSQL langsung

## Koneksi dari Host (DBeaver / pgAdmin)

- **Host:** localhost
- **Port:** 5432
- **Database:** ppw1
- **User:** ppw1
- **Password:** ppw1

## Troubleshooting

### Port 8080 atau 5432 sudah dipakai

Stop container yang bentrok:
```sh
docker ps  # cari container yang pakai port tersebut
docker stop <container_id>
```

### Connection refused di browser

Cek apakah DB sudah ready:
```sh
docker compose logs db | grep "database system is ready"
```
Jangan khawatir soal error berikut (normal):
```
ERROR: role "ppw1" does not exist
```
Ini normal di awal karena healthcheck ngecek sebelum DB dibuat.

### Edit Dockerfile (nambah extension baru)

1. Edit `Dockerfile`
2. Build ulang:
   ```sh
   docker compose up --build -d
   ```
