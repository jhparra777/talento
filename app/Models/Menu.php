<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $table    = 'menu';
    protected $fillable = [
        'id',
        'modulo',
        'tipo',
        'padre_id',
        'boton',
        'tipo_boton',
        'nombre_menu',
        'clases',
        'tag',
        'submenu',
        'slug',
        "name_route",
        "icono",
        "descripcion",
        "active",
        'created_at',
        'updated_at',
    ];

    public function menu_hijo1()
    {
        return $this->hasMany("App\Models\Menu", "padre_id", "id")->select("menu.*")->get();
    }

    public function submenu()
    {
        return $this->hasMany("App\Models\Menu", "padre_id", "id")->where("submenu", "1")->select("menu.*")->get();
    }

    public function menu_hijo2()
    {
        return $this->hasMany("App\Models\Menu", "padre_id", "id");
    }
}
