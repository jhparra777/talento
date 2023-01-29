<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{

    public function nuevo_rol(Request $data)
    {
        return view("admin.roles.nuevo_rol");
    }

    public function editar_rol($id, Request $data)
    {
        $rol = Sentinel::getRoleRepository()->findOrFail($id);
        return view("admin.roles.editar_rol", compact("rol"));
    }

    public function guardar_rol(Request $data)
    {
        $valida = Validator::make($data->all(), ["name" => "required"]);

        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida);
        }

        $permisos = [];
        if ($data->has("permiso_admin") && is_array($data->get("permiso_admin"))) {

            foreach ($data->get("permiso_admin") as $key => $value) {
                if ($value != "no") {
                    $permisos[$key] = (($value == "true") ? true : false);
                }
            }
        }

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name'        => $data->get("name"),
            'slug'        => $data->get("name"),
            "permissions" => $permisos,
        ]);

        return redirect()->route("admin.lista_roles")->with("mensaje_success", "Se ha creado el rol con exito");
    }

    public function actualizar_rol(Request $data)
    {
        $valida = Validator::make($data->all(), ["name" => "required"]);

        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida);
        }

        $permisos = [];
        if ($data->has("permiso_admin") && is_array($data->get("permiso_admin"))) {

            foreach ($data->get("permiso_admin") as $key => $value) {
                if ($value != "no") {
                    $permisos[$key] = (($value == "true") ? true : false);
                }
            }
        }

        $role = Sentinel::findRoleById($data->get("id"));
        $role->fill([
            'name'        => $data->get("name"),
            'slug'        => $data->get("name"),
            "permissions" => $permisos,
        ]);
        $role->save();

        return redirect()->route("admin.lista_roles")->with("mensaje_success", "Se ha actualizado el rol correctamente");
    }

    public function lista_roles(Request $data)
    {
        $lista_roles = Sentinel::getRoleRepository()->where(function ($sql) use ($data) {
            if ($data->get("name")) {
                $sql->where("name", "like", "%" . $data->get("name") . "%");
            }
        })->whereNotIn("slug", ["req", "admin", "hv","God"])->paginate(10);
        return view("admin.roles.lista_roles", compact("lista_roles"));
    }

    public function detalle_rol(Request $data)
    {
        $rol = Sentinel::getRoleRepository()->find($data->get("rol_id"));

        return view("admin.usuarios_sistema.modal.detalle-rol-new", compact("rol"));

    }

}
