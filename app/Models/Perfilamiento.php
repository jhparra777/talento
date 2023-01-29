<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfilamiento extends Model
{

    protected $table    = 'perfilamiento';
    protected $fillable = ['user_id', "cargo_generico_id"];

}
