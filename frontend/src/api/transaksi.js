/**
 * Mengambil daftar transaksi dari Laravel (GET /api/transaksi).
 *
 * baseUrl dan fetchFn dioper dari luar supaya fungsi ini bisa diuji
 * tanpa Laravel yang berjalan (fetch cukup dipalsukan di test).
 *
 * @param {string | undefined} baseUrl  isi dari VITE_API_URL
 * @param {typeof fetch} fetchFn
 * @returns {Promise<object[]>}
 */
export async function ambilTransaksi(baseUrl, fetchFn = fetch) {
  if (!baseUrl) {
    throw new Error(
      'VITE_API_URL belum diatur. Salin .env.example menjadi .env lalu isi alamat Laravel.',
    )
  }

  const alamat = `${baseUrl.replace(/\/+$/, '')}/api/transaksi`

  let respons
  try {
    respons = await fetchFn(alamat, { headers: { Accept: 'application/json' } })
  } catch {
    throw new Error(
      `Tidak dapat menghubungi Laravel di ${baseUrl}. Pastikan php artisan serve sedang berjalan.`,
    )
  }

  if (!respons.ok) {
    throw new Error(`Laravel membalas dengan status ${respons.status}.`)
  }

  const isi = await respons.json()
  return isi.data
}
