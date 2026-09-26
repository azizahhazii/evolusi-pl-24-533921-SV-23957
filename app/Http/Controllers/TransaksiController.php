<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaksiRequest;
use App\Models\Transaksi;
use App\Services\KeuanganService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransaksiController extends Controller
{
    public function __construct(private KeuanganService $keuangan)
    {
    }

    public function index(): View
    {
        $daftarTransaksi = Transaksi::orderByDesc('tanggal')->get();

        return view('transaksi.index', [
            'daftarTransaksi' => $daftarTransaksi,
            'totalMasuk' => $this->keuangan->formatRupiah(
                $this->keuangan->hitungTotal($daftarTransaksi, 'masuk')
            ),
            'totalKeluar' => $this->keuangan->formatRupiah(
                $this->keuangan->hitungTotal($daftarTransaksi, 'keluar')
            ),
            'saldo' => $this->keuangan->formatRupiah(
                $this->keuangan->hitungSaldo($daftarTransaksi)
            ),
        ]);
    }

    public function store(StoreTransaksiRequest $request): RedirectResponse
    {
        Transaksi::create($request->validated());

        return redirect()
            ->route('transaksi.index')
            ->with('sukses', 'Transaksi berhasil ditambahkan.');
    }
}
