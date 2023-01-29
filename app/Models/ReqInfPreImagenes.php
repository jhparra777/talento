<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReqInfPreImagenes extends Model
{
    protected $table    = 'req_inf_pre_imagenes';
    protected $fillable = [
        'req_id',
        'tipo',
        'image'
    ];
}
