<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarEmpresaFeria extends FormRequest
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
            'razon_social' => 'required|string|max:200',
            'descripcion' => 'nullable|string|max:200',
            'url_stream' => 'nullable|string|max:200',
            'logo' => 'image|max:900',
            'instagram' => 'nullable|string|max:200',
            'facebook' => 'nullable|string|max:200',
            'youtube' => 'nullable|string|max:200',
            'categoria' => 'required|string|max:100'
        ];
    }

    public function messages()
    {
        return [
            'max' => 'No puede ser mayor a :max carácteres',
            'unique' => 'Empresa ya existe',
            'image' => 'Archivo debe ser una imagen',
            'logo.max' => 'Imagen no puede exceder :maxKB',
            'razon_social.required' => 'Ingrese un nombre para la empresa',
            'logo.required' => 'Seleccione una imagen',
            'categoria.required' => 'Seleccione una categoría'
        ];
    }
}
