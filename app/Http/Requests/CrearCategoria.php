<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearCategoria extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'bail|required|string|max:100|unique:App\Models\Categoria,nombre'
        ];
    }

    public function messages()
    {
        return [
            'max' => 'Categoría no debe exceder 100 carácteres',
            'unique' => 'Categoría ya existe'
        ];
    }
}
