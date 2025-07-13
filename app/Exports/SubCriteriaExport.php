<?php

namespace App\Exports;

use App\Models\SubCriteria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubCriteriaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return SubCriteria::select('criteria_kode', 'name', 'level', 'value')->get();
    }

    public function headings(): array
    {
        return [
            'Kriteria Kode',
            'Nama Subkriteria',
            'Level',
            'Nilai'
        ];
    }
}
