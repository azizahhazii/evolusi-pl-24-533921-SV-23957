<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'keterangan' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'in:masuk,keluar'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'jumlah.min' => 'Jumlah transaksi harus angka positif.',
            'jenis.in' => 'Jenis transaksi harus masuk atau keluar.',
            'keterangan.required' => 'Keterangan tidak boleh kosong.',
        ];
    }
}
