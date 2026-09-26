<?php

namespace Tests\Unit;

use App\Services\KeuanganService;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class KeuanganServiceTest extends TestCase
{
    private KeuanganService $keuangan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->keuangan = new KeuanganService();
    }

    public function test_hitung_total_menjumlahkan_hanya_jenis_yang_diminta(): void
    {
        $daftar = new Collection([
            (object) ['jenis' => 'masuk', 'jumlah' => 500000],
            (object) ['jenis' => 'keluar', 'jumlah' => 350000],
            (object) ['jenis' => 'masuk', 'jumlah' => 100000],
        ]);

        $this->assertEquals(600000, $this->keuangan->hitungTotal($daftar, 'masuk'));
        $this->assertEquals(350000, $this->keuangan->hitungTotal($daftar, 'keluar'));
    }

    public function test_hitung_total_mengembalikan_nol_untuk_daftar_kosong(): void
    {
        $daftar = new Collection([]);

        $this->assertEquals(0, $this->keuangan->hitungTotal($daftar, 'masuk'));
    }

    public function test_hitung_saldo_mengurangi_total_masuk_dengan_total_keluar(): void
    {
        $daftar = new Collection([
            (object) ['jenis' => 'masuk', 'jumlah' => 500000],
            (object) ['jenis' => 'keluar', 'jumlah' => 350000],
        ]);

        $this->assertEquals(150000, $this->keuangan->hitungSaldo($daftar));
    }

    public function test_hitung_saldo_bisa_negatif_jika_pengeluaran_lebih_besar(): void
    {
        $daftar = new Collection([
            (object) ['jenis' => 'masuk', 'jumlah' => 100000],
            (object) ['jenis' => 'keluar', 'jumlah' => 350000],
        ]);

        $this->assertEquals(-250000, $this->keuangan->hitungSaldo($daftar));
    }

    public function test_format_rupiah_memformat_ribuan_dengan_titik(): void
    {
        $this->assertEquals('Rp150.000', $this->keuangan->formatRupiah(150000));
        $this->assertEquals('Rp1.000.000', $this->keuangan->formatRupiah(1000000));
        $this->assertEquals('Rp500', $this->keuangan->formatRupiah(500));
    }

    public function test_format_rupiah_menangani_nilai_negatif(): void
    {
        $this->assertEquals('-Rp250.000', $this->keuangan->formatRupiah(-250000));
    }
}
