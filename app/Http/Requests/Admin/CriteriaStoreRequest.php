<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CriteriaStoreRequest extends FormRequest
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
        'kode' => 'required|string|max:10|unique:criterias,kode',
        'name' => 'required|string|max:255',
        'kategori' => 'required',
        'keterangan' => 'nullable',
    ];
}

}
