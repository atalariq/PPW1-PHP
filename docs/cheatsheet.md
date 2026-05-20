# Docker Command Cheatsheet

## Container Lifecycle

| Command                              | Keterangan                                  |
| ------------------------------------ | ------------------------------------------- |
| `docker compose up --build -d`       | Build + start (pertama kali/ubah Dockerfile)|
| `docker compose up -d`              | Start container                             |
| `docker compose down`               | Stop container                              |
| `docker compose down -v`            | Stop + hapus volume (reset database)        |
| `docker compose restart`            | Restart container                           |

## Log & Debug

| Command                              | Keterangan                                  |
| ------------------------------------ | ------------------------------------------- |
| `docker compose logs -f app`        | Streaming log PHP/Apache                    |
| `docker compose logs -f db`         | Streaming log PostgreSQL                    |
| `docker compose ps`                 | Status container                            |

## Masuk Shell Container

| Command                              | Keterangan                                  |
| ------------------------------------ | ------------------------------------------- |
| `docker compose exec app bash`      | Shell ke container PHP                      |
| `docker compose exec db psql -U ppw1 -d ppw1` | psql ke PostgreSQL                  |

## PHP

### Nambah Extension Baru

1. Cek nama installer di Docker PHP:
   ```sh
   docker compose exec app docker-php-ext-install --help
   ```

2. Edit `Dockerfile`:
   ```dockerfile
   RUN docker-php-ext-install <nama_extension>
   ```

3. Build ulang:
   ```sh
   docker compose up --build -d
   ```

### Edit php.ini

Edit `php.ini` di root project, lalu restart:
```sh
docker compose restart
```

### Lihat PHP Info

Buat file sementara:
```php
<?php phpinfo();
```
Buka di browser, lalu hapus setelah selesai.

## PostgreSQL

### Reset Database

```sh
docker compose down -v
docker compose up -d
```

### Backup Database

```sh
docker compose exec db pg_dump -U ppw1 ppw1 > backup.sql
```

### Restore Database

```sh
docker compose exec -T db psql -U ppw1 ppw1 < backup.sql
```

## Troubleshooting Cepat

| Masalah                          | Solusi                                      |
| -------------------------------- | ------------------------------------------- |
| Port bentrok                     | `docker ps` cari container, lalu `docker stop` |
| DB connection refused            | Tunggu healthcheck selesai, cek log `db`   |
| Error permission denied          | File owner di `src/` harus readable oleh www-data |
| Perubahan file gak kepantau      | `src/` sudah di-mount ke container (live)   |
| Error "role does not exist"      | Normal saat startup, abaikan                |
