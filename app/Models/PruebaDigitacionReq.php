<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaDigitacionReq extends Model
{
    protected $table = 'prueba_digitacion_configs_reqs';
    protected $fillable = [
    	'req_id',
    	'ppm_esperada',
    	'precision_esperada'
    ];
}
