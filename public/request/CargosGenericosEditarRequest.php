<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CargosGenericosEditarRequest extends Request
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
        'descripcion' => 'required',
'codigo_1' => 'required',
'codigo_2' => 'required',
'estado' => 'required',
'update_at' => 'required',
'tipo_cargo_id' => 'required',

        ];
    }
}
