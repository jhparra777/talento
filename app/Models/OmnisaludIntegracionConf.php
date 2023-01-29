<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmnisaludIntegracionConf extends Model
{
    //
    protected $table = 'omnisalud_config';

    protected $fillable = [
        'id',
        'sandbox',
        'endpoint_prod',
        'endpoint_qa',
        'auth_user',
        'auth_pass'
    ];
}
