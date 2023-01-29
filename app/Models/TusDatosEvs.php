<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TusDatosEvs extends Model
{
    //
    protected $table    = 'tusdatos_evs';
    protected $fillable = [
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
