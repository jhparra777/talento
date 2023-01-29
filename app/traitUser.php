<?php

namespace App;

trait traitUser {


    
    //protected $fillable = ['name', 'email', 'password', "foto_perfil", "hash_verificacion", "estado", "google_key", "facebook_key","padre_id"];
    public function getCedula() {
        return $this->hasOne("App\Models\DatosBasicos", "user_id")->first();
    }

    public function getDatosBasicos() {
        return $this->hasOne("App\Models\DatosBasicos", "user_id")->first();
    }

    public function getEmpresa() {
        return $this->hasOne("App\Models\UserClientes", "user_id")->join("clientes", "clientes.id", "=", "users_x_clientes.cliente_id")->first();
    }

}
