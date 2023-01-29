<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ValidacionReporteMine extends Request
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
        'palabra_clave' => 'required|max:255',
        'fecha_actualizacion_ini' => "date|before:fecha_actualizacion_fin|required",
        'fecha_actualizacion_fin' => "date|after:fecha_actualizacion_ini|required",
        ];
    }
}
