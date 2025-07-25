<?php

namespace App\Imports;

use App\Models\Wood;
use App\Models\Criteria;
use App\Models\Alternative;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class AlternativesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Ambil semua kriteria dan buat mapping ke nama kolom excel
        $criteriaMapping = [
            'kekuatan' => 'Kekuatan',
            'keawetan' => 'Keawetan',
            'kandungan_kelembaban' => 'Kandungan Kelembaban',
            'estetika' => 'Estetika',
            'kemudahan_pengolahan' => 'Kemudahan Pengolahan',
            'harga_dan_ketersediaan' => 'Harga dan Ketersediaan',
        ];

        // Ambil semua kriteria dari database
        $criterias = Criteria::all()->keyBy('name');

        foreach ($rows as $row) {
            $woodName = trim($row['nama_kayu']);
            $wood = Wood::where('nama_kayu', $woodName)->first();

            if (!$wood) {
                continue; // Lewati jika kayu tidak ditemukan
            }

            foreach ($criteriaMapping as $excelKey => $criteriaName) {
                if (!isset($row[$excelKey])) continue;

                $criteria = $criterias[$criteriaName] ?? null;

                if (!$criteria) continue;

               Alternative::updateOrCreate(
                    [
                        'wood_id'     => $wood->id,
                        'criteria_id' => $criteria->id,
                    ],
                    [
                        'category_id'        => $wood->category_id, // pastikan Wood punya category_id
                        'alternative_value'  => $row[$excelKey],
                        'created_by'         => Auth::id(),
                    ]
                );

            }
        }
    }
}
