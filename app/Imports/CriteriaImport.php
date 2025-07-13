<?php

namespace App\Imports;

use App\Models\Criteria;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CriteriaImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return Criteria::updateOrCreate(
            ['kode' => $row['kode']],
            [
                'name'       => $row['nama'], // disesuaikan ke field DB
                'kategori'   => strtolower($row['kategori']),
                'keterangan' => $row['keterangan'],
                'bobot'      => $row['bobot'] ?? null, // jika ingin ikut diimpor
            ]
        );
    }

    public function rules(): array
    {
        return [
            '*.kode'       => ['required'], // tidak pakai unique, karena sudah updateOrCreate
            '*.nama'       => ['required'],
            '*.kategori'   => ['required', Rule::in(['BENEFIT', 'COST'])],
            '*.keterangan' => ['required'],
            '*.bobot'      => ['nullable', 'numeric'], // jika bobot ikut diimpor
        ];
    }
}
