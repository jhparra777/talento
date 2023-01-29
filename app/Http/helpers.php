<?php
use Illuminate\Support\Facades\Crypt;
use App\Models\DatosBasicos;
use App\Models\Documentos;
use App\Models\Requerimiento;
use App\Models\Sitio;
use App\Models\User;

use Carbon\Carbon;

use Luecano\NumeroALetras\NumeroALetras;

function encrypt2($value)
{
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    //primeros 2 caracteres ey (asi normalmente comienza el encriptado, es decir, asi se agrega mas dificultad), luego 6 caracteres aleatorios que seran la semilla

	return 'ey'.substr(str_shuffle($permitted_chars), 0, 6).Crypt::encrypt($value);
}

function decrypt2($value)
{
    //Se extraen los primeros 8 caracteres que son la semilla

	return Crypt::decrypt(substr($value, 8));
}

function secciones_pendientes($candidato)
{
	$datosBasicos = DatosBasicos::where("user_id", $candidato)->first();
    $datosBasicos["documentos_count"]=0;
    $datosBasicos["idiomas_count"]=0;

    $idiomas = $datosBasicos->idiomas_c->count();

    $hv_count=0;

    $documentos_seleccion = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
        ->where("user_id", $datosBasicos->user_id)
        ->where("tipos_documentos.categoria", 1)
        ->count();

    if($documentos_seleccion > 0) {
        $datosBasicos["documentos_count"] = 100;
    }

    if($idiomas > 0) {
        $datosBasicos["idiomas_count"] = 100;
    }

    $vals = [];
        
    $modulos_cuenta=DB::table("menu_candidato")->where("check",1)->whereNotNull('relacion_hv')->whereNotIn("ponderacion", [0])->select("relacion_hv", "descripcion")->get();
    
    foreach($modulos_cuenta as $modulo){
        $relacion=$modulo->relacion_hv;
            
        if ( $datosBasicos[$relacion] < 100 ) {
            	
           $vals[]=$modulo->descripcion;
        }
    }

        
        return $vals;
}


function dar_formato_fecha($fecha, $tipo = 'completa', $divisor = '-') {
    setlocale(LC_TIME, 'Spanish');

    try {
        $data = new Carbon($fecha);
    } catch (\Exception $e) {
        $date = substr($fecha, 0, 10);
        try {
            $data = new Carbon($date);
        } catch (\Exception $e) {
            logger("Error al dar formato a la fecha original ($fecha), segundo intento ($date):" .  $e->getMessage(). "\n");
            return '';
        }
    }
    //por defecto devuelve la fecha ´completa´ DIA de MES de AÑO ej: 01 de diciembre de 2000
    $convert_fecha = $data->formatLocalized('%d de %B de %Y');

    if ($tipo == 'corta') {
        //devuelve la fecha 01-12-2000
        $convert_fecha = $data->formatLocalized('%d'.$divisor.'%m'.$divisor.'%Y');
    }

    return $convert_fecha;
}

function valor_a_texto($valor, $decimales = 0, $moneda = 'pesos') {
    $formatter = new NumeroALetras();
    return $formatter->toMoney($valor, $decimales, $moneda);
}

/**
  *  Obtener Correos por Agencia, Cliente y Rol
  *
  *  Parametros: int    $req_id (obligatorio)
  *              array  $roles_id (obligatorio)
  *
  * return Object User (email y name)
*/
function emails_rol_cliente_agencia($req_id, $roles_id = []) {
    $sitio = Sitio::first();
    $emails = [];

    if ($sitio->agencias) {
        $agencia = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("ciudad", function($sql){
                $sql->on("ciudad.cod_ciudad","=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id")
                    ->on("ciudad.cod_pais","=","requerimientos.pais_id");
            })
            ->where("requerimientos.id", $req_id)
            ->select(
                "ciudad.agencia as agencia",
                "negocio.cliente_id"
            )
        ->first();

        $emails = User::select("users.email as email", "users.name")
            ->join("agencia_usuario", "agencia_usuario.id_usuario", "=", "users.id")
            ->join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->join("role_users", "role_users.user_id", "=", "users.id")
            ->whereIn("role_users.role_id", $roles_id)
            ->where("users_x_clientes.cliente_id", $agencia->cliente_id)
            ->where("agencia_usuario.id_agencia", $agencia->agencia)
            ->groupBy("users.id")
        ->get();
    } else {
        $cliente = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("requerimientos.id", $req_id)
            ->select(
                "negocio.cliente_id"
            )
        ->first();

        $emails = User::select("users.email as email", "users.name")
            ->join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->join("role_users", "role_users.user_id", "=", "users.id")
            ->where("users_x_clientes.cliente_id", $cliente->cliente_id)
            ->whereIn("role_users.role_id", $roles_id)
            ->groupBy("users.id")
        ->get();
    }

    return $emails;
}

/**
  *  Obtener Correos por Agencia, Cliente y Codigo Rol
  *
  *  Parametros: int    $req_id (obligatorio)
  *              array  $roles_codigo (obligatorio)
  *
  * return Object User (email y name)
*/
function emails_codigo_rol_cliente_agencia($req_id, $roles_codigo = []) {
    $sitio = Sitio::first();
    $emails = [];

    if ($sitio->agencias) {
        $agencia = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("ciudad", function($sql){
                $sql->on("ciudad.cod_ciudad","=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id")
                    ->on("ciudad.cod_pais","=","requerimientos.pais_id");
            })
            ->where("requerimientos.id", $req_id)
            ->select(
                "ciudad.agencia as agencia",
                "negocio.cliente_id"
            )
        ->first();

        $emails = User::select("users.email as email", "users.name", "clientes.nombre as cliente_nombre", "users.id")
            ->join("agencia_usuario", "agencia_usuario.id_usuario", "=", "users.id")
            ->join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->join('clientes', 'clientes.id', '=', 'users_x_clientes.cliente_id')
            ->join("role_users", "role_users.user_id", "=", "users.id")
            ->join("roles", "roles.id", "=", "role_users.role_id")
            ->whereIn("roles.codigo", $roles_codigo)
            ->where("users_x_clientes.cliente_id", $agencia->cliente_id)
            ->where("agencia_usuario.id_agencia", $agencia->agencia)
            ->groupBy("users.id")
        ->get();
    } else {
        $cliente = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("requerimientos.id", $req_id)
            ->select(
                "negocio.cliente_id"
            )
        ->first();

        $emails = User::select("users.email as email", "users.name", "clientes.nombre as cliente_nombre", "users.id")
            ->join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->join('clientes', 'clientes.id', '=', 'users_x_clientes.cliente_id')
            ->join("role_users", "role_users.user_id", "=", "users.id")
            ->join("roles", "roles.id", "=", "role_users.role_id")
            ->where("users_x_clientes.cliente_id", $cliente->cliente_id)
            ->whereIn("roles.codigo", $roles_codigo)
            ->groupBy("users.id")
        ->get();
    }

    return $emails;
}

//iniciamos todas las funciones helpers con tri_ para diferencias de la funciones propias del framework
function tri_components_message_whatsapp($instancia, $nameTemplate, $data = array())
{   
    $components = array();

    if( !empty($data) ){

        switch ($nameTemplate) {

            case 'envio_codigo_validaciones':

                $components[] = [
                    "type" => "body",
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => $data[0]
                        ],
                        [
                            "type" => "text",
                            "text" => $data[1]
                        ],
                        [
                            "type" => "text",
                            "text" => $data[2]
                        ]   
                    ]
                ];
                break;

            case 'proceso_pruebas_botones':

                $components[] = [
                    "type" => "header",
                    "parameters" => [
                        [
                            "type" => "image",
                            "image" => [
                                "link" => "https://img-t3rsc.s3.amazonaws.com/t3rs-src/img_pruebas_wp.jpg"
                            ]
                        ]  
                    ]
                ];

                $components[] = [
                    "type" => "body",
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => $data[0]
                        ],
                        [
                            "type" => "text",
                            "text" => $data[1]
                        ]   
                    ]
                ];

                $components[] = [
                    "type"  => "button",
                    "index" => 0,
                    "sub_type" => "url",
                    "parameters" => [
                        [
                            "text" => "{$instancia}/{$data[2]}",
                            "type"  => "text"
                        ]
                    ]

                ];

                break;
            
            default:
                
                break;
        }
    }

    return $components;
}