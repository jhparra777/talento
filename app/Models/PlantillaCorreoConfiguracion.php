<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaCorreoConfiguracion extends Model
{
    protected $table = 'plantillas_correos_configuracion';
	protected $fillable = [
		'id',
		'nombre_configuracion',
		'imagen_header',
		'imagen_fondo_header',
		'imagen_footer',
		'imagen_sub_footer',
		'color_principal',
		'color_secundario',
		'social_facebook',
		'social_twitter',
		'social_linkedin',
		'social_instagram',
		'social_whatsapp'
	];
}
