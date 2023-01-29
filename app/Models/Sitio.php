<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Requerimiento;

class Sitio extends Model
{
    protected $table    = 'sitio';
    protected $fillable = [
    	'id', 
    	'nombre', 
    	'celular', 
    	'telefono', 
    	'email', 
    	'logo', 
    	'favicon', 
    	'web_corporativa', 
    	'quienes_somos', 
    	'vision', 
    	'mision',
        'audio', 
    	'social_facebook', 
    	'social_twitter', 
    	'social_youtube', 
    	'social_whatsapp',
        'color',
        'social_instagram',
        'social_linkedin',
        'politicas',
        'precontrata',
        'color',
        'prueba_bryg',
        'id_proceso_sitio',
        'token_api'
    ];

    public function esProcesoEnSitio($req_id)
    {
        $proceso_en_sitio = false;

        $requerimiento = Requerimiento::where('id', $req_id)->select('tipo_proceso_id')->first();

        if ($requerimiento != null) {
            if ($this->id_proceso_sitio == $requerimiento->tipo_proceso_id) {
                $proceso_en_sitio = true;
            }
        }

        return $proceso_en_sitio;
    }

    //No tabular ya que el mensaje para Whatsapp sale tal como este escrito aqui
    public function mensajePruebasWhatsapp($candidato, $prueba, $ruta) {
        return "Hola $candidato, has sido enviado/a en tu proceso de selección a realizar nuestra *$prueba*🧾📖.

Por favor haz clic en el enlace $ruta 🔗 y sigue las instrucciones que te brindará la plataforma.

¡Muchos éxitos!";
    }
    //No tabular ya que el mensaje para Whatsapp sale tal como este escrito aqui
}
