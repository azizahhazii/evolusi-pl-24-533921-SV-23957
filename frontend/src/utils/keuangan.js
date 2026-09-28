// Logika murni, tanpa DOM dan tanpa jaringan -> gampang diuji tanpa Laravel.
// Padanan dari KeuanganService.php di sisi backend.

/**
 * Menjumlahkan seluruh transaksi bertipe tertentu.
 * @param {{ jenis: string, jumlah: number }[]} daftar
 * @param {'masuk'|'keluar'} jenis
 * @returns {number}
 */
export function hitungTotal(daftar, jenis) {
  return daftar
    .filter((t) => t.jenis === jenis)
    .reduce((total, t) => total + t.jumlah, 0)
}

/**
 * Saldo akhir = total masuk - total keluar.
 * @param {{ jenis: string, jumlah: number }[]} daftar
 * @returns {number}
 */
export function hitungSaldo(daftar) {
  return hitungTotal(daftar, 'masuk') - hitungTotal(daftar, 'keluar')
}

/**
 * Format angka menjadi rupiah, mis. 150000 -> "Rp150.000".
 * @param {number} angka
 * @returns {string}
 */
export function formatRupiah(angka) {
  const bulat = Math.round(angka)
  const digit = Math.abs(bulat).toString()
  const dipisah = digit.replace(/\B(?=(\d{3})+(?!\d))/g, '.')
  return (bulat < 0 ? '-Rp' : 'Rp') + dipisah
}
