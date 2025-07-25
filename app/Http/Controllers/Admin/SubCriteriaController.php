<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCriteria;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubCriteriaExport;
use App\Imports\SubCriteriaImport; 


class SubCriteriaController extends Controller
{
    public function index()
    {
        $subCriterias = SubCriteria::with('criteria')->get();
        return view('pages.admin.kriteria.subcriteria.data', [
            'subCriterias' => $subCriterias,
            'title' => 'Data Sub Kriteria',
        ]);
    }

    public function create()
    {
        $criterias = Criteria::all();
        return view('pages.admin.kriteria.subcriteria.create', [
            'criterias' => $criterias,
            'title' => 'Tambah Sub Kriteria',
        ]);
    }

    public function edit($id)
{
    $subCriteria = SubCriteria::findOrFail($id);
    $criterias = Criteria::all();

    return view('pages.admin.kriteria.subcriteria.edit', [
        'subCriteria' => $subCriteria,
        'criterias' => $criterias,
        'title' => 'Edit Sub Kriteria',
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'criteria_kode' => 'required|exists:criterias,kode',
        'sub_name' => 'required|string|max:255',
        'label' => 'required|string|max:255',
        'value' => 'required|numeric',
    ]);

    $subCriteria = SubCriteria::findOrFail($id);
    $subCriteria->update([
        'criteria_kode' => $request->criteria_kode,
        'name' => $request->sub_name,
        'level' => $request->label,
        'value' => $request->value,
    ]);

    return redirect()->route('sub-criteria.index')->with('success', 'Sub Kriteria berhasil diperbarui!');
}


    public function store(Request $request)
    {
        $request->validate([
            'criteria_kode' => 'required|exists:criterias,kode',
            'sub_name.*' => 'nullable|string|max:255',
            'sub_level.*' => 'nullable|string|max:255',
            'value.*' => 'nullable|numeric',
        ]);

        foreach ($request->sub_name as $index => $name) {
            // Simpan hanya jika semua data tersedia
            if ($name && $request->sub_level[$index] && $request->value[$index] !== null) {
                SubCriteria::create([
                    'criteria_kode' => $request->criteria_kode,
                    'name' => $name,
                    'level' => $request->sub_level[$index],
                    'value' => $request->value[$index],
                ]);
            }
        }

        return redirect()->route('sub-criteria.index')->with('success', 'Sub Kriteria berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $subCriteria = SubCriteria::findOrFail($id);
        $subCriteria->delete();

        return redirect()->route('sub-criteria.index')->with('success', 'Sub kriteria berhasil dihapus.');
    }
     public function destroyAll()
{
    SubCriteria::query()->delete();

    return redirect()->route('sub-criteria.index')->with('success', 'Semua data subkriteria berhasil dihapus.');
}

public function export()
{
    return Excel::download(new SubCriteriaExport, 'data_subkriteria.xlsx');
}
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xls,xlsx'
    ]);

    try {
        Excel::import(new SubCriteriaImport, $request->file('file'));
        return redirect()->route('sub-criteria.index')->with('success', 'Data subkriteria berhasil diimpor.');
    } catch (\Exception $e) {
        return back()->withError('Gagal impor: ' . $e->getMessage());
    }
}

}
