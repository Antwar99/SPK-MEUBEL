<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\Wood;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // mengurutkan
        $categories = Category::orderby('category_name')
            ->get();

        return view('pages.admin.wood.category.data', [
            'title'     => 'Data Kategori Kayu',
            'woods' => '',
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.wood.category.create', [
            'title'     => 'Buat Kategori Kayu',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|max:30|unique:categories',
            // 'slug' => 'required|unique:categories',
        ]);

        $request['slug'] = Str::slug($request->category_name, '-');

        Category::create($validatedData);

        return redirect('/dashboard/wood/category')->with('success', "Tambah kategori kayu baru berhasil");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 public function show($slug)
{
    $category = Category::where('slug', $slug)->with('woods')->firstOrFail();

    return view('pages.admin.category.detail', [
        'category' => $category,
        'woods'    => $category->woods,
    ]);
}



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::FindOrFail($id);

        return view('pages.admin.wood.category.edit', [
            'title' => "Edit data $category->category_name",
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'category_name' => 'required|string|max:255',
    ]);

    // Ambil data kategori berdasarkan ID
    $category = Category::findOrFail($id);

    // Ubah nama kategori saja, jangan ID-nya
    $category->category_name = $request->category_name;
    $category->save(); // Simpan perubahan

    // Redirect kembali ke halaman index dengan pesan sukses
    return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()
            ->route('category.index')
            ->with('success', 'Kategori kayu yang dipilih telah dihapus!');
    }

    public function woods(Category $category)
    {
        return view('pages.admin.wood.category.detail', [
            'title' => $category->category_name,
            'woods' => $category->woods,
            'active' => 'category',
            'category' => $category->category_name,
        ]);
    }
}
