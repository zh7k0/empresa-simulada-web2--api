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
            'razon_social'  => 'string|max:200',
            'descripcion'   => 'nullable|string|max:200',
            'url_stream'    => 'nullable|string|max:200',
            'logo'          => 'file|max:2048',
            'instagram'     => 'nullable|string|max:200',
            'facebook'      => 'nullable|string|max:200',
            'youtube'       => 'nullable|string|max:200',
            'categoria'     => 'string|max:100'
        ];
    }
}
