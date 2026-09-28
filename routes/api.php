<?php

use App\Http\Controllers\Api\TransaksiApiController;
use Illuminate\Support\Facades\Route;

// Otomatis berawalan /api -> GET /api/transaksi
Route::get('/transaksi', [TransaksiApiController::class, 'index'])->name('api.transaksi.index');
