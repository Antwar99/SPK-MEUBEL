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
        $criterias = Criteria::orderBy('id')->get()->keyBy('name');

        foreach ($rows as $row) {
            $woodName = trim($row['nama_kayu']);
            $wood = Wood::where('nama_kayu', $woodName)->first();

            if (!$wood) {
                continue; // Skip jika nama kayu tidak ditemukan
            }

            foreach ($criterias as $criteriaName => $criteria) {
                if (isset($row[$criteriaName])) {
                    Alternative::updateOrCreate(
                        [
                            'wood_id'     => $wood->id,
                            'criteria_id' => $criteria->id,
                        ],
                        [
                            'alternative_value' => $row[$criteriaName],
                            'created_by'        => Auth::id(),
                        ]
                    );
                }
            }
        }
    }
}
