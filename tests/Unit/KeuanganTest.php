<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\KeuanganService;

class KeuanganTest extends TestCase
{
    private KeuanganService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new KeuanganService();
    }

    public function test_tambah_transaksi_berhasil()
    {
        $awal = [];
        $baru = ['tanggal' => '2026-09-01', 'keterangan' => 'Bayar kos', 'jenis' => 'keluar', 'jumlah' => 500000];
        $hasil = $this->service->tambahTransaksi($awal, $baru);

        $this->assertCount(1, $hasil);
        $this->assertEquals($baru, $hasil[0]);
    }

    public function test_tambah_transaksi_gagal_jika_jumlah_nol()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Jumlah transaksi harus angka positif');

        $this->service->tambahTransaksi([], ['tanggal' => '2026-09-01', 'keterangan' => 'Salah', 'jenis' => 'keluar', 'jumlah' => 0]);
    }

    public function test_hitung_total()
    {
        $data = [
            ['jenis' => 'masuk', 'jumlah' => 1000000],
            ['jenis' => 'keluar', 'jumlah' => 200000],
            ['jenis' => 'masuk', 'jumlah' => 500000]
        ];

        $this->assertEquals(1500000, $this->service->hitungTotal($data, 'masuk'));
        $this->assertEquals(200000, $this->service->hitungTotal($data, 'keluar'));
    }

    public function test_hitung_saldo()
    {
        $data = [
            ['jenis' => 'masuk', 'jumlah' => 1000000],
            ['jenis' => 'keluar', 'jumlah' => 300000]
        ];

        $this->assertEquals(700000, $this->service->hitungSaldo($data));
    }

    public function test_format_rupiah()
    {
        $this->assertEquals('Rp150.000', $this->service->formatRupiah(150000));
        $this->assertEquals('-Rp50.000', $this->service->formatRupiah(-50000));
    }
}