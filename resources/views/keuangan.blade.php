<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Catatan Keuangan Kos</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
      background: #f5f6fa;
      color: #1f2933;
      margin: 0;
      padding: 2rem 1rem;
    }

    .container {
      max-width: 720px;
      margin: 0 auto;
      background: #fff;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    h1 {
      margin-top: 0;
    }

    .subtitle {
      color: #616e7c;
      margin-top: -0.5rem;
    }

    .ringkasan {
      display: flex;
      gap: 1rem;
      margin: 1.5rem 0;
      flex-wrap: wrap;
    }

    .kartu {
      flex: 1;
      min-width: 140px;
      background: #f5f6fa;
      border-radius: 8px;
      padding: 1rem;
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }

    .label {
      font-size: 0.85rem;
      color: #616e7c;
    }

    .nilai {
      font-size: 1.25rem;
      font-weight: 700;
    }

    .nilai-masuk { color: #2f9e44; }
    .nilai-keluar { color: #e03131; }
    .nilai-saldo { color: #1971c2; }

    form {
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
      align-items: end;
      margin-bottom: 1.5rem;
    }

    .baris-form {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }

    label {
      font-size: 0.85rem;
      color: #616e7c;
    }

    input, select {
      padding: 0.5rem;
      border: 1px solid #d3d9e0;
      border-radius: 6px;
    }

    button {
      padding: 0.55rem 1.1rem;
      background: #1971c2;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      height: fit-content;
    }

    button:hover {
      background: #1863ad;
    }

    .pesan-error {
      color: #e03131;
      width: 100%;
      min-height: 1.2em;
      margin: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      text-align: left;
      padding: 0.6rem 0.5rem;
      border-bottom: 1px solid #e5e8ec;
    }

    th {
      color: #616e7c;
      font-size: 0.85rem;
    }
  </style>
</head>
<body>
  <main class="container">
    <h1>Catatan Keuangan Kos</h1>
    <p class="subtitle">Catat pemasukan dan pengeluaran selama tinggal di kos.</p>

    <section class="ringkasan" aria-label="Ringkasan saldo">
      <div class="kartu">
        <span class="label">Total Masuk</span>
        <span id="total-masuk" class="nilai nilai-masuk">Rp0</span>
      </div>
      <div class="kartu">
        <span class="label">Total Keluar</span>
        <span id="total-keluar" class="nilai nilai-keluar">Rp0</span>
      </div>
      <div class="kartu">
        <span class="label">Saldo</span>
        <span id="saldo" class="nilai nilai-saldo">Rp0</span>
      </div>
    </section>

    <form id="form-transaksi">
      <div class="baris-form">
        <label for="tanggal">Tanggal</label>
        <input type="date" id="tanggal" name="tanggal" required />
      </div>
      <div class="baris-form">
        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan" placeholder="Contoh: Bayar kos bulan Sept" required />
      </div>
      <div class="baris-form">
        <label for="jenis">Jenis</label>
        <select id="jenis" name="jenis">
          <option value="masuk">Masuk</option>
          <option value="keluar">Keluar</option>
        </select>
      </div>
      <div class="baris-form">
        <label for="jumlah">Jumlah (Rp)</label>
        <input type="number" id="jumlah" name="jumlah" min="1" required />
      </div>
      <button type="submit">Tambah Transaksi</button>
      <p id="pesan-error" class="pesan-error" role="alert"></p>
    </form>

    <div style="margin-bottom: 1rem;">
      <label for="filter-bulan">Filter Bulan:</label>
      <input type="month" id="filter-bulan">
    </div>

    <table id="tabel-transaksi">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Keterangan</th>
          <th>Jenis</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody id="daftar-transaksi">
        <!-- diisi lewat app.js -->
      </tbody>
    </table>
  </main>

  <script type="module" src="{{ asset('app.js') }}"></script>
</body>
</html>