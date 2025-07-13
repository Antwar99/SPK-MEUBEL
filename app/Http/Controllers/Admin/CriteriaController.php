<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CriteriaStoreRequest;
use App\Http\Requests\Admin\CriteriaUpdateRequest;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PriorityValue;
use App\Models\Alternative;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CriteriaExport;
use App\Imports\CriteriaImport; 


class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
{
   
     DB::listen(function ($query) {
        logger('QUERY: ' . $query->sql);
        logger('BINDINGS: ' . json_encode($query->bindings));
    });
    $criterias = Criteria::all();

    // Inject nilai prioritas ke properti bobot (sementara, tidak menyimpan di DB)
    foreach ($criterias as $criteria) {
        $priority = PriorityValue::where('criteria_id', $criteria->id)->first();
        if ($priority) {
            $criteria->bobot = $priority ? $priority->value:0 ;
        }
    }

    return view('pages.admin.kriteria.data', [
        'title'     => 'Data Kriteria',
        'criterias' => $criterias
    ]);
}

    public function create()
    {
        return view('pages.admin.kriteria.create', [
            'title' => 'Buat Kriteria Baru',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(CriteriaStoreRequest $request)
{
    $validatedData = $request->validated();

    $validatedData['slug'] = Str::slug($validatedData['name'], '-');

    Criteria::create($validatedData);

    return redirect('/dashboard/kriteria')
        ->with('success', 'Kriteria baru telah ditambahkan!');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kriterium = Criteria::FindOrFail($id);

        return view('pages.admin.kriteria.edit', [
            'title' => "Edit kriteria $kriterium->name",
            'criteria' => $kriterium,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

 public function update(CriteriaUpdateRequest $request, $id)
{
    $data = $request->validated();
    $data['slug'] = Str::slug($data['name'], '-');

    // Pastikan tidak ada field 'bobot' dalam array jika tidak dikirim
    unset($data['bobot']);
\Log::info('Data update kriteria: ' . json_encode($data));


    Criteria::findOrFail($id)->update($data);

    return redirect('/dashboard/kriteria')
        ->with('success', 'Kriteria yang dipilih telah diperbarui!');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kriterium = Criteria::findOrFail($id);
        $kriterium->delete();

        return redirect('/dashboard/kriteria')
            ->with('success', 'Kriteria yang dipilih telah dihapus!');
    }
   public function destroyAll()
{
    Alternative::query()->delete();
    Criteria::query()->delete();

    return redirect()->route('kriteria.index')->with('success', 'Semua data kriteria berhasil dihapus.');
}

public function export()
{
    return Excel::download(new CriteriaExport, 'data_kriteria.xlsx');
}
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xls,xlsx'
    ]);

    try {
        Excel::import(new CriteriaImport, $request->file('file'));
        return redirect()->route('kriteria.index')->with('success', 'Data kriteria berhasil diimpor.');
    } catch (\Exception $e) {
        return back()->withError('Gagal impor: ' . $e->getMessage());
    }
}

}
