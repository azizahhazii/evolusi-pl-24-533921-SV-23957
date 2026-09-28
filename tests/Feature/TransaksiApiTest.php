<?php

namespace Tests\Feature;

use App\Models\Transaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_endpoint_mengembalikan_daftar_transaksi_dalam_json(): void
    {
        Transaksi::create([
            'tanggal' => '2026-09-01',
            'keterangan' => 'Kiriman ortu',
            'jenis' => 'masuk',
            'jumlah' => 500000,
        ]);

        $this->getJson('/api/transaksi')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => ['*' => ['id', 'tanggal', 'keterangan', 'jenis', 'jumlah']],
            ])
            ->assertJsonPath('data.0.tanggal', '2026-09-01')
            ->assertJsonPath('data.0.jumlah', 500000);
    }

    public function test_endpoint_mengembalikan_data_kosong_jika_belum_ada_transaksi(): void
    {
        $this->getJson('/api/transaksi')
            ->assertOk()
            ->assertExactJson(['data' => []]);
    }
}
