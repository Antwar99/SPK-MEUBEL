<?php

namespace App\Exports;

use App\Models\Criteria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CriteriaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil data kriteria dengan relasi bobot (priority)
        $criterias = Criteria::with('priority')->get();

      return $criterias->map(function ($criteria) {
            return [
                'Kode'       => $criteria->kode,
                'Nama'       => $criteria->name,
                'Bobot'      => optional($criteria->priority)->value ?? 0,
                'Kategori'   => strtoupper($criteria->kategori),
                'Keterangan' => $criteria->keterangan,
            ];
        });

    }

    public function headings(): array
    {
        return [ 'Kode', 'Nama', 'Bobot', 'Kategori', 'Keterangan'];
    }
}
