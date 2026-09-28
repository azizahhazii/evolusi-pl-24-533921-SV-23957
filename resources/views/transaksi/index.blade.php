<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catatan Keuangan Kos</title>
</head>
<body>
    <main style="max-width:720px;margin:2rem auto;font-family:sans-serif;">
        <h1>Catatan Keuangan Kos</h1>

        @if (session('sukses'))
            <p style="color:green;">{{ session('sukses') }}</p>
        @endif

        <section>
            <p>Total Masuk: <strong>{{ $totalMasuk }}</strong></p>
            <p>Total Keluar: <strong>{{ $totalKeluar }}</strong></p>
            <p>Saldo: <strong>{{ $saldo }}</strong></p>
        </section>

        <form method="POST" action="{{ route('transaksi.store') }}">
            @csrf
            <div>
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" required />
            </div>
            <div>
                <label for="keterangan">Keterangan</label>
                <input type="text" id="keterangan" name="keterangan" required />
            </div>
            <div>
                <label for="jenis">Jenis</label>
                <select id="jenis" name="jenis">
                    <option value="masuk">Masuk</option>
                    <option value="keluar">Keluar</option>
                </select>
            </div>
            <div>
                <label for="jumlah">Jumlah (Rp)</label>
                <input type="number" id="jumlah" name="jumlah" min="1" required />
            </div>
            <button type="submit">Tambah Transaksi</button>
            @error('jumlah')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </form>

        <table border="1" cellpadding="6" style="width:100%;margin-top:1rem;border-collapse:collapse;">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftarTransaksi as $t)
                    <tr>
                        <td>{{ $t->tanggal->format('Y-m-d') }}</td>
                        <td>{{ $t->keterangan }}</td>
                        <td>{{ ucfirst($t->jenis) }}</td>
                        <td>{{ number_format($t->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</body>
</html>
