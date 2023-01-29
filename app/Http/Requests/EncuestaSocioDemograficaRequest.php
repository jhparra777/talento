<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use App\Models\SocioDemograficoPreguntas;

class EncuestaSocioDemograficaRequest extends Request
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
        $sociodemografico_questions = SocioDemograficoPreguntas::select('id')->where('active', 1)->where('pregunta_obligatoria', 'si')->orderBy('id')->get()->pluck('id');
        $rules = [];

        foreach ($sociodemografico_questions as $value) {
            $rules += ["preg_id_$value" => 'required'];
        }

        return $rules;
    }

    public function messages()
    {
        $sociodemografico_questions = SocioDemograficoPreguntas::select('id')->where('active', 1)->where('pregunta_obligatoria', 'si')->orderBy('id')->get()->pluck('id');
        $rules = [];

        foreach ($sociodemografico_questions as $value) {
            $rules += ["preg_id_$value.required" => 'Campo obligatorio'];
        }

        return $rules;
    }
}
