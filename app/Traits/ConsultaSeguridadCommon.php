<?php

namespace App\Traits;

use App\Models\SitioModulo;
use App\Models\ConsultaSeguridadRegistro;

trait ConsultaSeguridadCommon {
    protected function guardar_registro_json($json, $user_id, $req_id, $gestion_id)
    {
        ConsultaSeguridadRegistro::create([
            'user_id' => $user_id,
            'req_id' => $req_id,
            'gestion_id' => $gestion_id,
            'json' => json_encode($json)
        ]);
    }

    protected function estado_modulo()
    {
        $sitio_modulo = SitioModulo::first();

        return $sitio_modulo->listas_vinculantes == 'enabled' ? true : false;
    }
}