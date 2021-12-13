<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearFeria extends FormRequest
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
            'categorias.*' => 'required|string|distinct',
            'tipo_evento' => 'string|max:50',
            'fecha_realizacion' => 'required|date',
            'esta_habilitado' => 'boolean',
            'link_evento' => 'required|string|max:200|starts_with:https://,http://',
        ];
    }

    public function messages()
    {
        return [
            'categorias.required' => 'Debe ingresar al menos una categoría',
            'categorias.*.distinct' => 'Una de las categorías está duplicada',
            'categorias.*.required' => 'No puede dejar categorías vacías',
            'fecha_realizacion.required' => 'Ingrese una fecha',
            'date' => 'Fecha no posee formato válido',
            'max' => 'Límite de carácteres excedido. Máximo: :max',
            'link_evento.required' => 'Ingrese un enlace',
            'starts_with' => 'Formato de enlace inválido'
        ];
    }
}
