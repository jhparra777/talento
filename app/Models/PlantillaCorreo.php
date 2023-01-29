<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaCorreo extends Model
{
	protected $table = 'plantillas_correos';
	protected $fillable = [
		'id',
		'nombre_plantilla',
		'active'
	];
}
