<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruoraKey extends Model
{
    //
    protected $table    = 'truora_keys';
    protected $fillable = [
    	'id',
    	'check_id',
    	'user_id',
    	'cand_id',
        'req_id'
    ];
}
