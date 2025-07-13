<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WoodUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kode_Kayu'    => 'required|max:15|min:3',
            'nama_kayu'    => 'required|max:60|min:3',
            'bentuk_kayu'   => 'required|in:Balok, Papan, Stick, Utuh, Blandar, Usuk, Reng',
            'supplier'     => 'required|string|max:100',
            'category_id'  => 'required|exists:categories,id',
        ];
    }

    public function attributes()
    {
        return [
            'kode_Kayu'   => 'Kode Kayu',
            'nama_kayu'   => 'Nama Kayu',
            'bentuk_kayu'  => 'bentuk Kayu',
            'supplier'    => 'Supplier',
            'category_id' => 'Kategori',
        ];
    }
}
