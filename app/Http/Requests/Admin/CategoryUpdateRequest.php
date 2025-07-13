<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
        $id = $this->route('kelas'); // Mengambil id kelas dari route

        return [
            'wood_name' => 'required|max:30|unique:woods,wood_name,' . $id, // Ganti kelas_name menjadi wood_name
            'category_id' => 'required|exists:categories,id', // Ganti kelas_id menjadi category_id
        ];
    }
}
