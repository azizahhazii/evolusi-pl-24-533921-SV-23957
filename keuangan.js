// keuangan.js — logika murni, tanpa sentuhan DOM sama sekali.
// Supaya bisa diuji dengan node:test tanpa membuka peramban.

/**
 * @typedef {Object} Transaksi
 * @property {string} tanggal   - format YYYY-MM-DD
 * @property {string} keterangan
 * @property {'masuk'|'keluar'} jenis
 * @property {number} jumlah    - nominal dalam rupiah, harus > 0
 */

/**
 * Validasi dan tambahkan satu transaksi ke daftar.
 * Tidak memutasi array asli — mengembalikan array baru.
 * @param {Transaksi[]} daftar
 * @param {Transaksi} transaksi
 * @returns {Transaksi[]}
 */
export function tambahTransaksi(daftar, transaksi) {
  if (!transaksi || typeof transaksi.jumlah !== 'number' || transaksi.jumlah <= 0) {
    throw new Error('Jumlah transaksi harus angka positif');
  }
  if (transaksi.jenis !== 'masuk' && transaksi.jenis !== 'keluar') {
    throw new Error('Jenis transaksi harus "masuk" atau "keluar"');
  }
  if (!transaksi.keterangan || transaksi.keterangan.trim() === '') {
    throw new Error('Keterangan tidak boleh kosong');
  }
  return [...daftar, transaksi];
}

/**
 * Menjumlahkan seluruh transaksi bertipe tertentu.
 * @param {Transaksi[]} daftar
 * @param {'masuk'|'keluar'} jenis
 * @returns {number}
 */
export function hitungTotal(daftar, jenis) {
  return daftar
    .filter((t) => t.jenis === jenis)
    .reduce((total, t) => total + t.jumlah, 0);
}

/**
 * Saldo akhir = total masuk - total keluar.
 * @param {Transaksi[]} daftar
 * @returns {number}
 */
export function hitungSaldo(daftar) {
  return hitungTotal(daftar, 'masuk') - hitungTotal(daftar, 'keluar');
}

/**
 * Format angka menjadi string rupiah, mis. 150000 -> "Rp150.000".
 * @param {number} angka
 * @returns {string}
 */
export function formatRupiah(angka) {
  const bulat = Math.round(angka);
  const negatif = bulat < 0;
  const digit = Math.abs(bulat).toString();
  const dipisah = digit.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  return (negatif ? '-Rp' : 'Rp') + dipisah;
}
