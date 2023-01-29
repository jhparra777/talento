<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudUserPasos extends Model
{
    public $table = 'solicitud_user_paso';
    public $fillable = [
    	'user_solicitante',
    	'user_jefe_solicitante',
    	'user_gerente_area',
    	'user_rhh',
    	'user_gg'];
}
