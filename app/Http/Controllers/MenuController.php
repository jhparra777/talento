<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function submenu(Request $data)
    {
        $menu    = Menu::where("padre_id", $data->get("padre_id"))->where("submenu", 1)->get();
        $usuario = Sentinel::getUser();

        $arrayMenu = [];
        foreach ($menu as $key => $value) {
            if ($usuario->hasAccess($value->slug)) {
                $value->ruta = route($value->slug);
                array_push($arrayMenu, $value);
            }
        }

        return response()->json($arrayMenu);
    }

}
