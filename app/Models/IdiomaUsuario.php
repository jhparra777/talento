<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdiomaUsuario extends Model
{
    //
    protected $table    = 'idioma_usuario';
    protected $fillable = ['id_idioma','id_usuario','nivel'];

    public function nombre_idioma()
    {
        return $this->belongsTo("App\Models\Idiomas", "id_idioma", "id");
    }

    public function nivel_idioma()
    {
        return $this->belongsTo("App\Models\NivelIdioma", "nivel", "id");
    }
}
