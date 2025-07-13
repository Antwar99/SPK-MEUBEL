<?php

namespace App\Imports;

use App\Models\Wood;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class WoodsImport implements ToModel, WithHeadingRow, WithValidation
{
   public function model(array $row)
{
    return Wood::updateOrCreate(
        ['kode_kayu' => $row['kode_kayu']],
        [
            'nama_kayu'   => $row['nama_kayu'],
            'supplier'    => $row['supplier'],
            'category_id' => $row['id_kategori'], // ← ini yang dipakai
            'created_by'  => Auth::id(),
        ]
    );
}


    public function rules(): array
    {
        return [
            '*.kode_kayu'   => ['required'],
            '*.nama_kayu'   => ['required'],
            '*.supplier'    => ['required'],
            '*.id_kategori' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.id_kategori.exists' => 'ID Kategori tidak ditemukan di tabel categories.',
        ];
    }
}
