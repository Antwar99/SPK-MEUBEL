<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CriteriaUpdateRequest extends FormRequest
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
    $id = $this->route('kriterium'); // ini yang penting, cocokkan dengan nama param di route

    return [
        'kode' => ['required', 'unique:criterias,kode,' . $id],
        'name' => ['required', 'string'],
        'kategori' => ['required', 'string'],
        'keterangan' => ['nullable', 'string'],
    ];
}

}
