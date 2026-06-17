# PPW1 PHP + MySQL

Local development environment untuk Praktikum Pemrograman Web 1 dengan PHP 8.4 dan MySQL 8 via Docker.

## Quickstart

```sh
cp .env.example .env   # isi nilai jika perlu
docker compose up --build -d

# App:  http://localhost:8080
# PMA:  http://localhost:8081
```

Import database: buka phpMyAdmin → pilih database `ppw1` → Import → pilih file `schema.sql`.

## Struktur

```
.
├── Dockerfile             # PHP 8.4-apache + pdo_mysql + mbstring
├── docker-compose.yaml    # services: app, db (MySQL 8), pma (phpMyAdmin)
├── php.ini                # Custom PHP config (error reporting)
├── .env                   # Environment variables (credentials, tidak di-commit)
├── .env.example           # Template .env
├── schema.sql             # DDL + seed data untuk database ppw1
└── src/
    ├── index.php          # Landing page / test koneksi DB
    ├── shared/
    │   └── db.php         # PDO connection helper (singleton)
    ├── p11/               # Pertemuan 11 — PHP dasar (PicoCSS)
    │   ├── index.php
    │   ├── bmi-calculator.php
    │   ├── profile.php
    │   ├── date.php
    │   └── calculator.html
    └── p12/               # Pertemuan 12 — CRUD Mahasiswa (Bootstrap 5)
        ├── layout/
        │   ├── header.php     # Bootstrap CDN, navbar
        │   └── footer.php
        ├── index.php          # List mahasiswa (READ)
        ├── create.php         # Tambah mahasiswa (CREATE)
        ├── edit.php           # Edit mahasiswa (UPDATE)
        ├── delete.php         # Hapus mahasiswa (DELETE, POST only)
        ├── grade.php          # Konversi nilai angka → grade huruf (A–E)
        └── student-form.php   # Form mahasiswa + validasi + predikat IPK
```

## Stack

| Komponen  | Detail                 |
| --------- | ---------------------- |
| PHP       | 8.4-apache (Docker)    |
| Database  | MySQL 8                |
| GUI DB    | phpMyAdmin (port 8081) |
| CSS (p11) | PicoCSS 2 via CDN      |
| CSS (p12) | Bootstrap 5 via CDN    |
| DB Access | PDO (`shared/db.php`)  |

## Database

Dua tabel di database `ppw1`:

**`prodi`** — 93 prodi UGM, di-seed via `schema.sql`

| Kolom  | Tipe                         |
| ------ | ---------------------------- |
| `id`   | INT PK AUTO_INCREMENT        |
| `nama` | VARCHAR(100) UNIQUE NOT NULL |

**`mahasiswa`**

| Kolom        | Tipe                                |
| ------------ | ----------------------------------- |
| `id`         | INT PK AUTO_INCREMENT               |
| `nama`       | VARCHAR(100) NOT NULL               |
| `nim`        | VARCHAR(20) UNIQUE NOT NULL         |
| `prodi_id`   | INT FK → prodi.id                   |
| `ipk`        | DECIMAL(3,2) — range 0.00–4.00      |
| `semester`   | TINYINT — range 1–14                |
| `created_at` | TIMESTAMP DEFAULT CURRENT_TIMESTAMP |

## Artifact P12

File `exported-from-PMA-p12.sql` adalah dump database hasil ekspor dari phpMyAdmin yang berisi:

- DDL tabel `mahasiswa` dan `prodi`
- Data seed 93 prodi UGM
- Data mahasiswa sample (19 baris + 1 entry test)

File ini merupakan artefak tugas Pertemuan 12 (CRUD Mahasiswa).
