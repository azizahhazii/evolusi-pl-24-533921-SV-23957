# evolusi-pl-NIM

Repository tugas Pertemuan 2 — Manajemen GitHub & Prinsip CI (Evolusi & Konstruksi Perangkat Lunak, 2026).

## Aplikasi

Catatan Keuangan Kos berbasis HTML statis. Tidak butuh server: buka `index.html` langsung di peramban (lewat `npx serve .` atau Live Server, karena memakai ES module).

| Berkas | Isi |
|---|---|
| `index.html` | Struktur halaman |
| `style.css` | Tampilan |
| `app.js` | Perekat DOM — membaca form dan tabel, memanggil fungsi dari `keuangan.js` |
| `keuangan.js` | Logika murni: `tambahTransaksi()`, `hitungTotal()`, `hitungSaldo()`, `formatRupiah()` |
| `test/keuangan.test.js` | Pengujian dengan `node:test` (bawaan Node, tanpa dependensi) |

Logika perhitungan sengaja dipisah dari DOM di `keuangan.js` supaya bisa diuji tanpa peramban. Ini pola yang sama yang bikin pipeline CI gampang: kode yang mudah diuji, mudah di-CI-kan.

## Menjalankan pengujian

```bash
npm test                     # node --test test/*.test.js
npx --yes html-validate index.html
```

Butuh Node.js 20 ke atas. Tidak ada `npm install` — nol dependensi.

## Alur branch

Kode tidak pernah mendarat langsung di `main`. `main` adalah yang terakhir.

```
feature/<sesuatu>  --PR-->  dev  --PR-->  main
     kerja harian          integrasi     rilis / dinilai
```

| Branch | Peran | Boleh push langsung? |
|---|---|---|
| `feature/<sesuatu>` | satu perubahan, umurnya pendek | ya |
| `dev` | tempat semua fitur bertemu dan diuji bareng | tidak — lewat PR dari `feature/*` |
| `main` | kondisi yang dianggap layak rilis | tidak — lewat PR dari `dev` saja |

Branch default repository ini adalah `dev`, jadi PR baru otomatis menyasar `dev`.

## Alur CI

`.github/workflows/ci.yml` berisi dua job yang berjalan paralel pada setiap push dan setiap Pull Request ke `dev` maupun `main`:

- **uji** — menjalankan pengujian unit `node:test`.
- **lint** — memeriksa markup `index.html` dengan `html-validate`.

Kedua job harus hijau sebelum PR boleh di-merge. Dipasang lewat branch protection rule pada `dev` dan `main` (Settings → Branches → Add rule → Require status checks to pass).

## Peringatan

Jangan pernah melakukan commit pada `.env`, kunci SSH, atau kata sandi. Sekali masuk riwayat Git, sangat sulit dihapus. Lihat `.gitignore`.
