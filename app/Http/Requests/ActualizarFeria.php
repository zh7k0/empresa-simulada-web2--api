<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarFeria extends FormRequest
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
            'categorias' => 'required|array',
            'categorias.*' => 'string|distinct:ignore_case',
            'tipo_evento' => 'string|max:50',
            'fecha_realizacion' => 'required|date',
            'esta_habilitado' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'categorias.required' => 'Debe ingresar al menos una categoría',
            'categorias.*.distinct' => 'Una de las categorías está duplicada',
            'fecha_realizacion.required' => 'Ingrese una fecha',
            'date' => 'Fecha no posee formato válido'
        ];
    }
}
