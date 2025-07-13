<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AlternativeStoreRequest extends FormRequest
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
            'wood_id' => 'required|exists:woods,id', // Ganti student_id dengan wood_id
            'criteria_id' => 'required|array',
            'category_id' => 'required|exists:categories,id', // Ganti kelas_id dengan category_id
            'alternative_value' => 'required|array'
        ];
    }
}
