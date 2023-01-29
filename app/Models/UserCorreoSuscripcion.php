<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCorreoSuscripcion extends Model
{
    protected $table      = 'users_correo_suscripcion';
    protected $fillable   = [
        'user_id',
        'suscripcion'
    ];
}
