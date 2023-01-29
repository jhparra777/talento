<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
   protected $table    = 'asistencia';
    protected $fillable = ['id', "llamada_id", "numero_id","asistencia","created_at","updated_at"];
}
