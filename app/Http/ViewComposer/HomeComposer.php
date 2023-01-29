<?php

namespace App\Http\ViewComposer;

use App\Models\CargoGenerico;
use App\Models\Ciudad;
use App\Models\Departamento;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class HomeComposer
{

    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;
    protected $request;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        /*

        //dd($view->name());
        //dd(request());
        $view_except = [
            //'req.emails.notificacion_req'
            '/',
        ];

        $view_name = $view->name();
        if($view_name=="admin.citacion.proceso_recluta.carga_masiva.emais.email_carga_masiva"){

        }
        else{

            
            //dd(route('home'));
            $request = request()->route()->uri();

            if (in_array($request, $view_except)) {
                $camposFiltro   = [];
                $cargo_generico = CargoGenerico::find(Request::get("cargo_generico"));
                $departamento   = Departamento::find(Request::get("departamento"));
                $ciudad         = Ciudad::find(Request::get("ciudad"));

                $cargos = CargoGenerico::join("requerimientos", "requerimientos.cargo_generico_id", "=", "cargos_genericos.id")
                    ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
                    ->whereRaw("requerimientos.descripcion_oferta is not null ")
                    ->select("cargos_genericos.id", "cargos_genericos.descripcion", "cargos_genericos.tipo_cargo_id", DB::raw("count(requerimientos.id) as cantidad_req"))
                    ->groupBy("cargos_genericos.id", "cargos_genericos.descripcion", "cargos_genericos.tipo_cargo_id")
                    ->get();

                $departamentos = Departamento::join("requerimientos", function ($join) {
                    $join->on("requerimientos.departamento_id", "=", "departamentos.cod_departamento")
                        ->on("requerimientos.pais_id", "=", "departamentos.cod_pais");
                })
                    ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
                    ->whereRaw("requerimientos.descripcion_oferta is not null")
                    ->select("departamentos.id", "departamentos.nombre", "requerimientos.departamento_id", DB::raw("count(requerimientos.id) as cantidad_req"))
                    ->groupBy("requerimientos.departamento_id", "departamentos.id", "departamentos.nombre")->get();

                $ciudades = Ciudad::join("requerimientos", function ($join) {
                    $join->on("requerimientos.ciudad_id", "=", "ciudad.cod_ciudad")
                        ->on("requerimientos.pais_id", "=", "ciudad.cod_pais")
                        ->on("requerimientos.departamento_id", "=", "ciudad.cod_departamento");
                })
                    ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
                    ->whereRaw("requerimientos.descripcion_oferta is not null")
                    ->where(function ($sql) use ($departamento) {
                        if (Request::get("departamento") != "") {
                            $sql->where("requerimientos.departamento_id", $departamento->cod_departamento);
                        }
                    })->select("ciudad.id", "ciudad.nombre", DB::raw("count(ciudad.id) as cantidad_req"))
                    ->groupBy("ciudad.id", "ciudad.nombre")->get();

                if ($cargo_generico != null) {
                    $camposFiltro["cargo_generico"] = $cargo_generico->descripcion;
                }
                if ($departamento != null) {
                    $camposFiltro["departamento"] = $departamento->nombre;
                }
                if ($ciudad != null) {
                    $camposFiltro["ciudad"] = $ciudad->nombre;
                }
                $camposFiltro["publicacion_fecha"] = Request::get("publicacion_fecha");
                $camposFiltro["palabra_clave"]     = Request::get("palabra_clave", "");
                $ruta                              = Request::route()->getName();

                $view->with("ciudad", $ciudades)->with("ruta", $ruta)->with('cargos_genericos', $cargos)->with('departamentos', $departamentos)->with('text_filtros', $camposFiltro);
            }
        }
    */}


}
