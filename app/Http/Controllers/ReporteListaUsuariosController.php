<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Sitio;
use App\Http\Requests;

use Illuminate\Http\Request;
use App\Jobs\FuncionesGlobales;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReporteListaUsuariosController extends Controller
{
    public function lista_usuarios_excel(Request $request)
    {
        $headers = [
            'Nombre',
            'Email',
            'Módulos',
            'Estado'
        ];

        $consulta = $this->getData($request);

        $sitio = Sitio::first();

        $funciones_globales = new FuncionesGlobales();

        if(isset($funciones_globales->sitio()->nombre)){
            if($funciones_globales->sitio()->nombre != "") {
                $nombre = $funciones_globales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-usuarios', function ($excel) use ($sitio, $consulta, $headers) {
            $excel->setTitle('Lista de Usuarios');
            $excel->setCreator('$nombre')->setCompany('$nombre');
            $excel->setDescription('Lista de Usuarios');
            $excel->sheet('Lista de Usuarios', function ($sheet) use ($sitio, $consulta, $headers) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_lista_usuarios_admin', [
                    'sitio' => $sitio,
                    'consulta'    => $consulta,
                    'headers' => $headers,
                    'formato' => 'xlsx'
                ]);
            });
        })->export('xlsx');
    }

    private function getData(Request $data)
    {
        $roles_filter = ["req", "admin"];

        if ($data->has('admin') || $data->has('req') || $data->has('hv')) {
            $roles_filter = [];

            array_push($roles_filter, $data->get('admin'));
            array_push($roles_filter, $data->get('req'));
            array_push($roles_filter, $data->get('hv'));
        }

        // EloquenUser es User (por alguna razón)
        $usuarios = User::leftJoin("role_users", "role_users.user_id", "=", "users.id")
        ->leftJoin('datos_basicos', 'datos_basicos.user_id', '=', 'users.id')
        ->leftJoin('estados', 'estados.id', '=', 'datos_basicos.estado_reclutamiento')
        ->leftJoin("roles", "roles.id", "=", "role_users.role_id")
        ->join('activations', 'activations.user_id', '=', 'users.id')
        ->where(function ($sql) use ($data, $roles_filter) {
            if ($data->get("email") != "") {
                $sql->where(DB::raw(" lower(users.email) "), "like", "%" . strtolower($data->get("email")) . "%");
                $sql->orWhere("users.name", "like", "%" . strtolower($data->get("email")) . "%");

                if (is_numeric($data->get("email"))) {
                    $sql->orWhere("users.numero_id", "=", $data->get("email"));
                }

                array_push($roles_filter, 'hv');
            }

            if ($data->get('estado') != "") {
                $sql->where('activations.completed', $data->get('estado'));
            }

            $sql->whereIn("roles.slug", $roles_filter);
        });

        $usuarios = $usuarios->select(
            "users.id",
            "users.name",
            "users.email",
            DB::raw("GROUP_CONCAT(role_users.role_id  , ',' ORDER BY role_users.user_id) as roles_text"),
            "activations.completed as activo",
            "estados.descripcion as estado"
        )
        ->groupBy("users.id", "users.name", "users.email")
        ->get();

        return $usuarios;
    }
}
