<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TusDatosKey extends Model
{
    //
    protected $table    = 'tusdatos_keys';
    protected $fillable = [
    	'id',
    	'req_id',
    	'user_id',
    	'gestion_id',
        'job_id',
        'report_id',
        'factor',
        'plan',
        'status',
        'error'
    ];
}
