<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\JsonResponse;

class TransaksiApiController extends Controller
{
    /**
     * GET /api/transaksi -> daftar transaksi dalam JSON untuk frontend Vue.
     */
    public function index(): JsonResponse
    {
        $data = Transaksi::orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get()
            ->map(fn (Transaksi $t) => [
                'id' => $t->id,
                'tanggal' => $t->tanggal->format('Y-m-d'),
                'keterangan' => $t->keterangan,
                'jenis' => $t->jenis,
                'jumlah' => $t->jumlah,
            ]);

        return response()->json(['data' => $data]);
    }
}
