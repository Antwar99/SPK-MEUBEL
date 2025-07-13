<?php

namespace App\Http\Controllers\Admin;

use App\Exports\WoodsExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Wood;
use Illuminate\Http\Request;
use App\Models\Alternative;
use App\Imports\WoodsImport;
use Maatwebsite\Excel\Facades\Excel;


class WoodController extends Controller

{
    protected $limit = 10;
    protected $fields = ['woods.*'];

public function index(Request $request)
{
    $title = 'Data Kayu';

    // Inisialisasi query + eager load relasi category
    $woodsQuery = Wood::with('category')
        ->orderBy('category_id')
        ->orderBy('nama_kayu');

    // Jika ada pencarian
    if ($request->has('search')) {
        $search = $request->search;

        $woodsQuery->where(function ($query) use ($search) {
            $query->where('nama_kayu', 'LIKE', '%' . $search . '%')
                ->orWhere('kode_kayu', 'LIKE', '%' . $search . '%')
                ->orWhere('supplier', 'LIKE', '%' . $search . '%')
                // Perbaikan di sini: pakai nama relasi `category`, bukan `category_id`
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('category_name', 'LIKE', '%' . $search . '%');
                });
        });
    }

    // Pagination setup
    $page = $request->query('page', 1);
    $perPageOptions = [5, 10, 15, 20, 25];
    $perPage = $request->query('perPage', $perPageOptions[1]);

    // Ambil data dan paginasi
    $woods = $woodsQuery->paginate($perPage, ['*'], 'page', $page);

    // Tampilkan ke view
    return view('pages.admin.wood.data', [
        'title' => $title,
        'woods' => $woods,
        'perPageOptions' => $perPageOptions,
        'perPage' => $perPage
    ]);
}


    public function create()
    {
        $categories = Category::all();

        return view('pages.admin.wood.create', [
            'title' => 'Tambah Data Kayu',
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        // ✅ VALIDASI INPUT
        $validated = $request->validate([
            'kode_kayu' => 'required|string|unique:woods,kode_kayu',
            'nama_kayu' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        // ✅ SIMPAN DATA KE DATABASE
        Wood::create($validated);

        return redirect()->route('wood.index')->with('success', 'Data Kayu berhasil disimpan!');
    }

    public function getKayuByKategori($categoryid)
{
    $dataKayu = Kayu::where('kategori_id', $categoryid)->get();
    return response()->json($dataKayu);
}

    public function edit($id)
    {
        $wood = Wood::findOrFail($id);
        $categories = Category::all();

        return view('pages.admin.wood.edit', [
            'title' => "Edit Data {$wood->nama_kayu}",
            'wood' => $wood,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Wood $wood)
    {
        $validated = $request->validate([
            'kode_kayu' => 'required|string|unique:woods,kode_kayu,' . $wood->id,
            'nama_kayu' => 'required|string|max:255',
         
            'supplier' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        $wood->update($validated);

        return redirect()->route('wood.index')->with('success', 'Data Kayu berhasil diperbarui!');
    }

    public function destroy(Wood $wood)
    {
        $wood->delete();
        return redirect()->route('wood.index')->with('success', 'Data Kayu berhasil dihapus!');
    }
    public function destroyAll()
{
    Alternative::query()->delete();
    Wood::query()->delete();

    return redirect()->route('wood.index')->with('success', 'Semua data kayu berhasil dihapus.');
}



    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $file = $request->file('file');
            Excel::import(new WoodsImport, $file);

            return redirect()->route('wood.index')->with('success', 'Data Kayu berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->withError('Gagal impor: ' . $e->getMessage())->withInput();
        }
    }

    public function export()
    {
        return Excel::download(new WoodsExport(), 'data_kayu.xlsx');
    }
}
