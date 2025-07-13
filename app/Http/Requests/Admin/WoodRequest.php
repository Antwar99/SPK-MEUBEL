<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WoodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
{
    return [
        'kode_Kayu' => 'required|max:15|min:3|unique:woods,kode_kayu,' . $this->wood->id,
        'nama_kayu'     => 'required|string|max:60|min:3',                   // Nama kayu
        'bentuk_kayu'   => 'required|string|max:50|min:3',                   // Bentuk kayu (misal: Stick, Balok)
        'supplier'      => 'required|string|max:100|min:3',                  // Nama supplier
        'category_id'   => 'required|exists:categories,id',                  // ID kategori yang valid
    ];
}

}
