<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sociedad extends Model
{
    protected $table    = 'sociedades';
    protected $fillable = ['id', "division_empresa_codigo", "division_geren_codigo", "division_codigo", "division_nombre"];
}
