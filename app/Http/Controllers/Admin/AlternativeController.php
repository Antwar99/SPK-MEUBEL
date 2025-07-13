<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AlternativesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AlternativeStoreRequest;
use App\Http\Requests\Admin\AlternativeUpdateRequest;
use App\Imports\AlternativesImport;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Wood;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class AlternativeController extends Controller
{
    protected $limit = 10;

    public function index(Request $request)
    {
        $usedIds = Alternative::select('wood_id')->distinct()->pluck('wood_id')->toArray();

       $alternatives = Wood::join('categories', 'categories.id', '=', 'woods.category_id')
    ->where(function ($query) use ($request) {
        $query->where('woods.nama_kayu', 'LIKE', '%' . $request->search . '%')
              ->orWhere('categories.category_name', 'LIKE', '%' . $request->search . '%');
    })
    ->whereIn('woods.id', $usedIds)
    ->where('woods.created_by', auth()->id()) // <- disini!
    ->orderBy('woods.category_id')
    ->orderBy('woods.nama_kayu')
    ->with('alternatives');


        $woodList = Wood::join('categories', 'categories.id', '=', 'woods.category_id')
            ->whereNotIn('woods.id', $usedIds)
            ->orderBy('categories.id')
            ->orderBy('woods.nama_kayu', 'ASC')
            ->get(['woods.*', 'categories.id as categoryId'])
            ->groupBy('categories.category_name');

        $categories = Category::all();
        $page = $request->query('page', 1);
        $perPageOptions = [5, 10, 15, 20, 25];
        $perPage = $request->query('perPage', $perPageOptions[1]);
        $alternatives = $alternatives->paginate($perPage, ['woods.*'], 'page', $page);

       return view('pages.admin.alternatif.data', [
        'title' => 'Data Alternatif',
        'alternatives' => $alternatives,
        'criterias' => Criteria::with('subcriterias')->get(), // penting!
        'wood_list' => $woodList,
        'perPageOptions' => $perPageOptions,
        'perPage' => $perPage,
        'categories' => $categories,
    ]);
    }

    public function edit($id)
    {
        $wood = Wood::with(['category', 'alternatives.criteria'])->findOrFail($id);
        $criterias = Criteria::all();

        $usedCriteriaIds = $wood->alternatives->pluck('criteria_id')->toArray();
        $newCriterias = Criteria::whereNotIn('id', $usedCriteriaIds)->get();

        return view('pages.admin.alternatif.edit', [
            'title' => 'Edit Alternatif',
            'wood' => $wood,
            'criterias' => $criterias,
            'newCriterias' => $newCriterias,
        ]);
    }

  public function store(Request $request)
{
    $validate = $request->validate([
        'wood_id' => 'required|exists:woods,id',
        'criteria_id' => 'required|array',
        'subcriteria_id' => 'required|array',
       
    ]);

    $wood = Wood::findOrFail($validate['wood_id']);
    $categoryId = $wood->category_id;

    foreach ($validate['criteria_id'] as $key => $criteriaId) {
        $subId = $validate['subcriteria_id'][$key];
        $sub = \App\Models\Subcriteria::find($subId);

        Alternative::create([
            'wood_id' => $validate['wood_id'],
            'category_id' => $categoryId,
            'criteria_id' => $criteriaId,
            'subcriteria_id' => $subId,
            'alternative_value' => $sub->value, // ambil nilai dari subkriteria
        ]);
    }

    return redirect()->route('alternatif.index')->with('success', 'Alternatif Baru telah ditambahkan!');
}

 public function update(AlternativeUpdateRequest $request, $wood_id)
{
    $validate = $request->validated();

    if (!empty($validate['new_criteria_id'])) {
        foreach ($validate['new_criteria_id'] as $key => $newCriteriaId) {
            Alternative::create([
                'wood_id' => $wood_id,
                'criteria_id' => $newCriteriaId,
                'alternative_value' => $validate['new_alternative_value'][$key],
            ]);
        }
    }

    foreach ($validate['criteria_id'] as $key => $criteriaId) {
        Alternative::where('id', $validate['alternative_id'][$key])
            ->update([
                'criteria_id' => $criteriaId,
                'alternative_value' => $validate['alternative_value'][$key],
            ]);
    }

    return redirect()->route('alternatif.index')->with('success', 'Data alternatif telah diperbarui!');
}

  public function destroy($wood_id)
{
    Alternative::where('wood_id', $wood_id)->delete();

    return redirect()->route('alternatif.index')->with('success', 'Semua data alternatif untuk kayu ini telah dihapus!');
}

public function destroyAll()
{
    Alternative::truncate(); // hapus semua record
    return redirect()->route('alternatif.index')->with('success', 'Semua data alternatif berhasil dihapus.');
}


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file')->store('temp');

        try {
            Excel::import(new AlternativesImport, $file);
            return redirect()->route('alternatif.index')->with('success', 'Alternatif berhasil diimpor!');
        } catch (\Exception $e) {
            return redirect()->route('alternatif.index')->with('error', 'Terjadi kesalahan saat mengimpor alternatif: ' . $e->getMessage());
        }
    }

    public function export()
{
    $alternatives = \App\Models\Alternative::with(['wood.category', 'criteria'])->get();
    $export = new \App\Exports\AlternativesExport($alternatives);
    $fileName = 'Data_Alternatif.xlsx';
    \Maatwebsite\Excel\Facades\Excel::store($export, $fileName);
    return \Illuminate\Support\Facades\Response::download(storage_path("app/{$fileName}"))->deleteFileAfterSend();
}


    public function getWoodByCategory($id)
    {
    $woods = Wood::where('category_id', $id)->get(['id', 'nama_kayu']);
    return response()->json($woods);
    }

}
