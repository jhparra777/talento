<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gerencia extends Model
{
    protected $table    = 'gerencia';
    protected $fillable = ['id', 'descripcion', 'gerenci_emp_codigo'];

}
