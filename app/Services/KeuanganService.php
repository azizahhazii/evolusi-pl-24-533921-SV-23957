<?php

namespace App\Services;

class KeuanganService
{
    public function tambahTransaksi(array $daftar, array $transaksi): array
    {
        if (! isset($transaksi['jumlah']) || ! is_numeric($transaksi['jumlah']) || $transaksi['jumlah'] <= 0) {
            throw new \InvalidArgumentException('Jumlah transaksi harus angka positif');
        }
        if (! in_array($transaksi['jenis'] ?? '', ['masuk', 'keluar'])) {
            throw new \InvalidArgumentException('Jenis transaksi harus "masuk" atau "keluar"');
        }
        if (empty(trim($transaksi['keterangan'] ?? ''))) {
            throw new \InvalidArgumentException('Keterangan tidak boleh kosong');
        }

        $daftar[] = $transaksi;

        return $daftar;
    }

    public function hitungTotal(array $daftar, string $jenis): int
    {
        return array_reduce($daftar, function ($total, $t) use ($jenis) {
            return ($t['jenis'] ?? '') === $jenis ? $total + $t['jumlah'] : $total;
        }, 0);
    }

    public function hitungSaldo(array $daftar): int
    {
        return $this->hitungTotal($daftar, 'masuk') - $this->hitungTotal($daftar, 'keluar');
    }

    public function formatRupiah(float $angka): string
    {
        $bulat = round($angka);
        $negatif = $bulat < 0;
        $digit = number_format(abs($bulat), 0, ',', '.');

        return ($negatif ? '-Rp' : 'Rp').$digit;
    }
}
