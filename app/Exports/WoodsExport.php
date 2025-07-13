<?php

namespace App\Exports;

use App\Models\Wood;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WoodsExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize
{
    use Exportable;

  public function collection()
{
    return Wood::select(
        'woods.kode_kayu',
        'woods.nama_kayu',
        'woods.supplier',
        'categories.category_name',
        'woods.category_id' // ← Tambahkan ini
    )
    ->leftJoin('categories', 'woods.category_id', '=', 'categories.id')
    ->orderBy('categories.category_name')
    ->orderBy('woods.nama_kayu')
    ->get();
}


  public function headings(): array
{
    return [
        'Kode Kayu',
        'Nama Kayu',
        'Supplier',
        'Nama Kategori',
        'ID Kategori', // ← ini dipakai saat import
    ];
}

}
