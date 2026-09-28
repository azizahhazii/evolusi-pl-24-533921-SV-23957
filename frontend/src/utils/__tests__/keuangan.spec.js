import { describe, expect, it } from 'vitest'
import { formatRupiah, hitungSaldo, hitungTotal } from '../keuangan'

const daftar = [
  { id: 1, jenis: 'masuk', jumlah: 500000 },
  { id: 2, jenis: 'keluar', jumlah: 350000 },
  { id: 3, jenis: 'masuk', jumlah: 100000 },
]

describe('hitungTotal', () => {
  it('menjumlahkan hanya transaksi dengan jenis yang diminta', () => {
    expect(hitungTotal(daftar, 'masuk')).toBe(600000)
    expect(hitungTotal(daftar, 'keluar')).toBe(350000)
  })

  it('mengembalikan 0 untuk daftar kosong', () => {
    expect(hitungTotal([], 'masuk')).toBe(0)
  })
})

describe('hitungSaldo', () => {
  it('mengurangi total masuk dengan total keluar', () => {
    expect(hitungSaldo(daftar)).toBe(250000)
  })

  it('bisa negatif jika pengeluaran lebih besar', () => {
    const boros = [
      { id: 1, jenis: 'masuk', jumlah: 100000 },
      { id: 2, jenis: 'keluar', jumlah: 350000 },
    ]
    expect(hitungSaldo(boros)).toBe(-250000)
  })
})

describe('formatRupiah', () => {
  it('memformat ribuan dengan titik', () => {
    expect(formatRupiah(150000)).toBe('Rp150.000')
    expect(formatRupiah(1000000)).toBe('Rp1.000.000')
    expect(formatRupiah(500)).toBe('Rp500')
  })

  it('menangani nilai negatif dan nol', () => {
    expect(formatRupiah(-250000)).toBe('-Rp250.000')
    expect(formatRupiah(0)).toBe('Rp0')
  })
})
