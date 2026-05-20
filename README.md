# PPW1 PHP + PostgreSQL

Local development environment untuk Praktikum Pemrograman Web 1 dengan PHP 8.4 dan PostgreSQL 17 via Docker.

## Quickstart

```sh
# Setup awal (pertama kali / setelah ubah Dockerfile)
docker compose up --build -d

# Buka browser
# http://localhost:8080
```

## Struktur

```
.
├── Dockerfile
├── docker-compose.yaml
├── php.ini              # Custom PHP config (error reporting)
├── .env                 # Environment variables (credentials)
├── .env.example         # Template .env
├── setup.sh             # Command shortcuts
├── docs/                # Dokumentasi detail
│   ├── setup.md         # Setup & troubleshooting
│   └── cheatsheet.md    # Docker command reference
└── src/
    ├── index.php        # Test koneksi database
    └── shared/
        └── db.php       # PDO connection helper
```

## Stack

| Komponen    | Versi             |
| ----------- | ----------------- |
| PHP         | 8.4-apache        |
| PostgreSQL  | 17-alpine         |
| Extensions  | pdo_pgsql, mbstring |

## Dokumentasi

- [Setup detail & troubleshooting](docs/setup.md)
- [Docker command cheatsheet](docs/cheatsheet.md)
