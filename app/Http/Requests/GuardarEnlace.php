<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarEnlace extends FormRequest
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
            'url' => 'bail|required|string|max:200',
            'titulo' => 'bail|required|string|max:100'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Campo requerido',
            'string' => 'Solo se aceptan strings',
            'max' => 'Campo no puede exceder los :max carácteres'
        ];
    }
}
