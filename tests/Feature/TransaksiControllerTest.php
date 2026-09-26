<?php

namespace Tests\Feature;

use App\Models\Transaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_index_menampilkan_ringkasan_saldo(): void
    {
        Transaksi::create([
            'tanggal' => '2026-09-01',
            'keterangan' => 'Kiriman ortu',
            'jenis' => 'masuk',
            'jumlah' => 500000,
        ]);
        Transaksi::create([
            'tanggal' => '2026-09-02',
            'keterangan' => 'Bayar kos',
            'jenis' => 'keluar',
            'jumlah' => 350000,
        ]);

        $response = $this->get(route('transaksi.index'));

        $response->assertOk();
        $response->assertSee('Rp150.000');
    }

    public function test_transaksi_baru_bisa_disimpan(): void
    {
        $response = $this->post(route('transaksi.store'), [
            'tanggal' => '2026-09-05',
            'keterangan' => 'Uang jajan',
            'jenis' => 'masuk',
            'jumlah' => 100000,
        ]);

        $response->assertRedirect(route('transaksi.index'));
        $this->assertDatabaseHas('transaksis', [
            'keterangan' => 'Uang jajan',
            'jumlah' => 100000,
        ]);
    }

    public function test_jumlah_nol_ditolak_validasi(): void
    {
        $response = $this->post(route('transaksi.store'), [
            'tanggal' => '2026-09-05',
            'keterangan' => 'Salah',
            'jenis' => 'masuk',
            'jumlah' => 0,
        ]);

        $response->assertSessionHasErrors('jumlah');
        $this->assertDatabaseMissing('transaksis', ['keterangan' => 'Salah']);
    }
}
