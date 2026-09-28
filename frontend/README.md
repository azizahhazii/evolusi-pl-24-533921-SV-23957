# Frontend — Catatan Keuangan Kos (Vue 3)

Aplikasi Vue 3 + Vite + Vue Router. Menampilkan data transaksi dari backend Laravel
lewat `GET /api/transaksi`.

| Halaman | Isi |
|---|---|
| `/` (Transaksi) | Ringkasan masuk/keluar/saldo + tabel data dari Laravel |
| `/#/tentang` | Penjelasan singkat aplikasi |

Router memakai *hash history*, jadi me-reload halaman kedua tetap aman di hosting statis
(GitHub Pages) tanpa aturan rewrite di server.

## Menjalankan di laptop

```bash
# 1. Jalankan Laravel dulu (di folder root repo)
php artisan serve                 # http://127.0.0.1:8000

# 2. Jalankan Vue
cd frontend
cp .env.example .env              # Windows: copy .env.example .env
npm ci
npm run dev                       # http://localhost:5173
```

Alamat API dibaca dari `VITE_API_URL` (lihat `.env.example`), tidak ditulis di kode.
Kalau Laravel mati, halaman menampilkan pesan galat yang jelas dan tombol "Coba lagi".

## Skrip

| Perintah | Fungsi |
|---|---|
| `npm run lint` | ESLint |
| `npm run test:unit` | Vitest — berjalan **tanpa** Laravel (fetch dipalsukan) |
| `npm run build` | Vite membangun `dist/` |

## Pipeline (`.github/workflows/frontend.yml`)

`lint → test → build → deploy`, dirangkai dengan `needs:`, memakai `npm ci` dan `cache: 'npm'`.

- **build** satu-satunya job yang menjalankan `npm run build`, lalu mengunggah `dist/` sebagai artifact.
- **deploy** hanya mengunduh artifact itu dan menampilkan isinya ke log — tidak ada `npm ci` / `npm run build`.
- **deploy hanya jalan dari `main`** (`github.event_name == 'push' && github.ref == 'refs/heads/main'`).
  Pull Request tetap menjalankan lint, test, dan build; job deploy berstatus *skipped*.

## Keamanan

Semua yang berawalan `VITE_` tertanam di `dist/` dan bisa dibaca siapa pun. Jangan menaruh
password, token, atau kunci API di frontend. `.env` tidak boleh di-commit (lihat `.gitignore`).
