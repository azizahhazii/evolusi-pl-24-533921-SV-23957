import { describe, expect, it, vi } from 'vitest'
import { ambilTransaksi } from '../transaksi'

// Semua test memalsukan fetch, jadi TIDAK butuh Laravel berjalan.

describe('ambilTransaksi', () => {
  it('memanggil /api/transaksi lalu mengembalikan isi "data"', async () => {
    const data = [{ id: 1, tanggal: '2026-09-01', keterangan: 'Kiriman', jenis: 'masuk', jumlah: 500000 }]
    const fetchPalsu = vi.fn().mockResolvedValue({
      ok: true,
      status: 200,
      json: async () => ({ data }),
    })

    const hasil = await ambilTransaksi('http://laravel.test', fetchPalsu)

    expect(hasil).toEqual(data)
    expect(fetchPalsu).toHaveBeenCalledWith(
      'http://laravel.test/api/transaksi',
      expect.objectContaining({ headers: { Accept: 'application/json' } }),
    )
  })

  it('membuang garis miring di akhir alamat dasar', async () => {
    const fetchPalsu = vi.fn().mockResolvedValue({ ok: true, json: async () => ({ data: [] }) })

    await ambilTransaksi('http://laravel.test///', fetchPalsu)

    expect(fetchPalsu.mock.calls[0][0]).toBe('http://laravel.test/api/transaksi')
  })

  it('memberi pesan jelas saat Laravel tidak bisa dihubungi', async () => {
    const fetchPalsu = vi.fn().mockRejectedValue(new TypeError('Failed to fetch'))

    await expect(ambilTransaksi('http://127.0.0.1:8000', fetchPalsu)).rejects.toThrow(
      /Tidak dapat menghubungi Laravel di http:\/\/127\.0\.0\.1:8000/,
    )
  })

  it('melaporkan status HTTP saat Laravel membalas galat', async () => {
    const fetchPalsu = vi.fn().mockResolvedValue({ ok: false, status: 500 })

    await expect(ambilTransaksi('http://laravel.test', fetchPalsu)).rejects.toThrow(/status 500/)
  })

  it('menolak jalan bila VITE_API_URL belum diatur', async () => {
    const fetchPalsu = vi.fn()

    await expect(ambilTransaksi(undefined, fetchPalsu)).rejects.toThrow(/VITE_API_URL belum diatur/)
    expect(fetchPalsu).not.toHaveBeenCalled()
  })
})
