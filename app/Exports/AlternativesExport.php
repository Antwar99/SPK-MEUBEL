<?php

namespace App\Exports;

use App\Models\Wood;
use App\Models\Criteria;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AlternativesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection(): Collection
    {
        $woods = Wood::with(['category', 'alternatives.criteria'])->get();
        $criterias = Criteria::orderBy('id')->get();

        $data = [];

        foreach ($woods as $wood) {
            $row = [
                'Nama Kayu'   => $wood->nama_kayu,
                'Kategori'    => $wood->category->category_name ?? '-',
            ];

            foreach ($criterias as $criteria) {
                $alt = $wood->alternatives->firstWhere('criteria_id', $criteria->id);
                $row[$criteria->name] = $alt->alternative_value ?? 0;
            }

            $data[] = $row;
        }

        return collect($data);
    }

    public function headings(): array
    {
        $criteriaNames = Criteria::orderBy('id')->pluck('name')->toArray();

        return array_merge(['Nama Kayu', 'Kategori'], $criteriaNames);
    }
}
