<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserClientes extends Model
{

    protected $table    = 'users_x_clientes';
    protected $fillable = ['user_id', "cliente_id", "id"];

}
