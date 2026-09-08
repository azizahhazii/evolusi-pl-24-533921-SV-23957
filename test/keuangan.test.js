import { test } from 'node:test';
import assert from 'node:assert/strict';
import { tambahTransaksi, hitungTotal, hitungSaldo, formatRupiah } from '../keuangan.js';

test('tambahTransaksi menambah transaksi valid tanpa memutasi array asli', () => {
  const daftarAwal = [];
  const transaksi = { tanggal: '2026-09-01', keterangan: 'Uang kiriman', jenis: 'masuk', jumlah: 500000 };
  const daftarBaru = tambahTransaksi(daftarAwal, transaksi);

  assert.equal(daftarAwal.length, 0, 'array asli tidak boleh berubah');
  assert.equal(daftarBaru.length, 1);
  assert.deepEqual(daftarBaru[0], transaksi);
});

test('tambahTransaksi menolak jumlah nol atau negatif', () => {
  assert.throws(() => {
    tambahTransaksi([], { tanggal: '2026-09-01', keterangan: 'Salah', jenis: 'keluar', jumlah: 0 });
  }, /Jumlah transaksi harus angka positif/);
});

test('tambahTransaksi menolak jenis yang tidak dikenal', () => {
  assert.throws(() => {
    tambahTransaksi([], { tanggal: '2026-09-01', keterangan: 'Salah', jenis: 'transfer', jumlah: 1000 });
  }, /Jenis transaksi harus/);
});

test('tambahTransaksi menolak keterangan kosong', () => {
  assert.throws(() => {
    tambahTransaksi([], { tanggal: '2026-09-01', keterangan: '  ', jenis: 'masuk', jumlah: 1000 });
  }, /Keterangan tidak boleh kosong/);
});

test('hitungTotal menjumlahkan hanya transaksi dengan jenis yang diminta', () => {
  const daftar = [
    { tanggal: '2026-09-01', keterangan: 'Kiriman ortu', jenis: 'masuk', jumlah: 500000 },
    { tanggal: '2026-09-02', keterangan: 'Bayar kos', jenis: 'keluar', jumlah: 350000 },
    { tanggal: '2026-09-03', keterangan: 'Uang jajan', jenis: 'masuk', jumlah: 100000 },
  ];

  assert.equal(hitungTotal(daftar, 'masuk'), 600000);
  assert.equal(hitungTotal(daftar, 'keluar'), 350000);
});

test('hitungTotal mengembalikan 0 untuk daftar kosong', () => {
  assert.equal(hitungTotal([], 'masuk'), 0);
});

test('hitungSaldo mengurangi total masuk dengan total keluar', () => {
  const daftar = [
    { tanggal: '2026-09-01', keterangan: 'Kiriman ortu', jenis: 'masuk', jumlah: 500000 },
    { tanggal: '2026-09-02', keterangan: 'Bayar kos', jenis: 'keluar', jumlah: 350000 },
  ];

  assert.equal(hitungSaldo(daftar), 150000);
});

test('hitungSaldo bisa menghasilkan nilai negatif jika pengeluaran lebih besar', () => {
  const daftar = [
    { tanggal: '2026-09-01', keterangan: 'Kiriman ortu', jenis: 'masuk', jumlah: 100000 },
    { tanggal: '2026-09-02', keterangan: 'Bayar kos', jenis: 'keluar', jumlah: 350000 },
  ];

  assert.equal(hitungSaldo(daftar), -250000);
});

test('formatRupiah memformat ribuan dengan titik', () => {
  assert.equal(formatRupiah(150000), 'Rp150.000');
  assert.equal(formatRupiah(1000000), 'Rp1.000.000');
  assert.equal(formatRupiah(500), 'Rp500');
});

test('formatRupiah menangani nilai negatif', () => {
  assert.equal(formatRupiah(-250000), '-Rp250.000');
});
