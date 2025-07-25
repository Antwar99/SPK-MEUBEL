<?php

namespace App\Imports;

use App\Models\SubCriteria;
use Maatwebsite\Excel\Concerns\ToModel;

class SubCriteriaImport implements ToModel
{
    public function model(array $row)
    {
        // Skip the header row
        if ($row[0] === 'Kriteria Kode' || $row[0] == null) {
            return null;
        }

        return new SubCriteria([
            'criteria_kode' => $row[0],
            'name'          => $row[1],
            'level'         => $row[2],
            'value'         => $row[3],
        ]);
    }
}
