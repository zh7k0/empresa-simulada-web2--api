<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearEmpresaFeria extends FormRequest
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
            'descripcion' => 'string|max:200',
            'url_stream' => 'string|max:200',
            'logo' => 'required|file|max:2048',
            'instagram' => 'string|max:200',
            'facebook' => 'string|max:200',
            'youtube' => 'string|max:200',
            'categoria' => 'required|string|max:100'
        ];
    }
}
