<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearEmpresa extends FormRequest
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
            'razon_social' => 'required|string|max:200|unique:App\Models\Empresa,razon_social',
            'logo' => 'required|image|max:900',
            'url_web' => 'required|string|max:200',
            'categoria_id' => 'required|numeric|min:1'
        ];
    }

    public function messages()
    {
        return [
            'razon_social.required' => 'Ingrese nombre de empresa',
            'unique' => 'Empresa ya existe',
            'string' => 'Solo se acepta texto',
            'max' => 'Valor no debe exceder :max carácteres',
            'logo.max' => 'Imagen no puede exceder :maxKB',
            'logo.required' => 'Seleccione una imagen',
            'image' => 'Archivo debe ser imagen',
            'url_web.required' => 'Debe ingresar un enlace',
            'categoria_id.required' => 'Seleccione una categoría',
            'numeric' => 'Categoría inválida',
            'min' => 'Categoria no existe. Recargue página'
        ];
    }
}
