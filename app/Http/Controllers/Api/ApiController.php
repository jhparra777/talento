<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DatosBasicos;
use App\Models\Experiencias;
use App\Models\Estudios;
use App\Models\GrupoFamilia;
use App\Models\Perfilamiento;
use App\Models\IdiomaUsuario;
use App\Models\Requerimiento;
use App\Models\ReqCandidato;
use DB;
use App\Models\RegistroProceso;
use App\Models\Clientes;
use App\Models\CentrosCostos;
use App\Models\OfertaUser;

use Sentinel;
//use Validator;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

class ApiController extends Controller
{
    /**
     *  @descripcion: Aplicar a una oferta desde TCN
     *  @metodo : POST
     *  @parámetros: 
     * 
     *  numero_id/cedula: la cedula para conseguir el user_id
     *  oferta_id_instancia: que en tcn es el numero de la oferta 
     *                    en la instancia
     *  nombres : los nombres de la persona
     *  email: el email de la persona
     *  primer_apellido: El primer apellido 
     *  segundo_apellido: El segundo apellido
     *  telefono(opcional): el telefono de la persona
     *  movil: el celular de la persona
     *  contrasena: Es la misma cedula.
     *  acepto_politicas: siempre es 1
     *  
     *  
     */
    public function aplicar_oferta(Request $data)
    {
        $this->validate($data, [
            "numero_id" => "required|numeric",
            "oferta_id_instancia" => "required|numeric",
            "nombres" => "required",
            "primer_apellido" => "required",
            "email" => "required|email",
            "movil" => "required|numeric"
        ],[
            "numero_id.required" => "La cedula del candidato es requerida",
            "numero_id.numeric" => "El código del cliente debe ser númerico",
            "oferta_id_instancia.required" => "El id del requerimiento/oferta es requerido",
            "oferta_id_instancia.numeric" => "El id del requerimiento/oferta debe ser un número",
            "nombres.required" => "El/los nombres del candidato son requeridos",
            "primer_apellido.required" => "Por lo menos el primer apellido lo necesitamos por si hay que registrar al candidato",
            "email.required" => "El email es requerido",
            "email.email" => "El email es inválido",
            "movil.required" => "El número móvil es requerido",
            "movil.numeric" => "El número móvil es inválido"
        ]);

        $numero_id        = $data->input('numero_id'); // requerido
        $requerimiento_id = $data->input('oferta_id_instancia'); // requerido
        $nombres          = $data->input('nombres'); // requerido

        // nota el email lo comparamos con el que traemos de los datos 
        // basico y el que nos envia tcn.
        $primer_apellido  = $data->input('primer_apellido'); // requerido
        $segundo_apellido = $data->input('segundo_apellido'); // no requerido
        $email            = $data->input('email'); // requerido
        $telefono         = $data->input('telefono'); // no requerido
        $movil            = $data->input('movil'); // requerido
        $contrasena       = $numero_id;
        $acepto_politicas = 1;
        $message = "";
        
        // Antes verificamos que no haya aplicado
        // Lo primero es verificar si ya aplico a esa oferta
        $aplico_oferta = OfertaUser::where("cedula", $numero_id)->where("requerimiento_id", $requerimiento_id)
        ->first();

        if($aplico_oferta != null){
            return response()->json([
                "success" => false,
                "error" => true,
                "message" => 'El candidato ya ha aplicado al requerimiento '.$requerimiento_id 
            ], 200);
        }

        // lo primero es verificar si existe el candidato en la base de datos
        $datos_basicos = DatosBasicos::where('numero_id', $numero_id)->first();

        // Si existe solo agregamos los datos donde aplica a la oferta
        if($datos_basicos != null){
            $aplicar = new OfertaUser();
            $aplicar->fill(
                [
                    "user_id"          => $datos_basicos->user_id,
                    "requerimiento_id" => $requerimiento_id,
                    "fecha_aplicacion" => date("Y-m-d H:i:s"),
                    "cedula"           => $datos_basicos->numero_id,
                    "estado"           => 1,
                    "referer"          => 1
                ]);
            if( $aplicar->save() ){
                return response()->json([
                    "success" => true,
                    "error" => false,
                    "message" => 'El usuario aplicó satisfactoriamente al requerimiento '.$requerimiento_id 
                ], 200);
            }else{
                return response()->json([
                    "success" => false,
                    "error" => true,
                    "message" => 'Hubo un error aplicando el usuario al requerimiento '.$requerimiento_id
                ], 200);
            }
        }else{
            // no existe el candidato tenemos que crearlo, y activarlo. y 
            // luego aplicarlo a la oferta por debajo de cuerda que no se entere
            $credentials = [
                'email'    => $email,
                'password' => $numero_id
            ];

            $user = Sentinel::registerAndActivate($credentials);
            $user->name = $nombres.' '.$primer_apellido.' '.$segundo_apellido;
            $user->username = $numero_id;
            $user->numero_id= $numero_id;
            $user->estado   = 1;
            $user->cedula   = $numero_id;
            $user->correo_corporativo = $email;
            $user->telefono = $movil;

            if( $user->save() ){
                $message .= "\nSe registró y se activó el usuario correctamente"; 
                
                // Le asignamos el rol de hv al usuario 
                $role = Sentinel::findRoleBySlug('hv');
                $role->users()->attach($user); 
            }else{
                // Acá no se puede continuar
                return response()->json([
                    "success" => false,
                    "error" => true,
                    "message" => "No se pudo registrar el usuario en el sistema, no se puede continuar :("
                ], 200);
            }

            // Ahora ingresamos los datos basicos requeridos
            $datos_basicos = new DatosBasicos();
            $datos_basicos->numero_id =  $user->numero_id;
            $datos_basicos->user_id   =  $user->id;
            $datos_basicos->nombres   =  $nombres;
            $datos_basicos->primer_apellido  = $primer_apellido;
            $datos_basicos->segundo_apellido = $segundo_apellido;
            $datos_basicos->email   = $user->email;
            $datos_basicos->telefono_movil  = $user->telefono;
            $datos_basicos->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');

            if( $datos_basicos->save() ){
                $message.="\nSe ingresaron los datos básicos necesarios correctamente";
            }else{
                return response()->json([
                    "success" => false,
                    "error" => true,
                    "message" => "Hubo un error registrando los datos básicos"
                ], 200);
            }

            // Ahora si aplicamos a la oferta
            $aplicar = new OfertaUser();
            $aplicar->fill(
                [
                    "user_id"          => $user->id,
                    "requerimiento_id" => $requerimiento_id,
                    "fecha_aplicacion" => date("Y-m-d H:i:s"),
                    "cedula"           => $datos_basicos->numero_id,
                    "estado"           => 1,
                    "referer"          => 1
                ]);
            if( $aplicar->save() ){
                $message .= "\nEl usuario aplicó satisfactoriamente al requerimiento " . $requerimiento_id;
               
                return response()->json([
                    "success" => true,
                    "error" => false,
                    "message" => $message
                ], 200);
            }else{
                return response()->json([
                    "success" => false,
                    "error" => true,
                    "message" => "Hubo un error aplicando al usuario"
                ], 200);
            }
        }   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Bienvenido RESTful HTTP API T3RS'
        ], 200);
    }

    /**
     * Descripción : permite crear un centro de costo
     * Parámetros :
     *            cliente_id(requerido),
     *            codigo(requerido),
     *            descripcion(requerido)
     * Devuelve : un booleano true -> si lo pudo crear ó los mensajes de errores
     *  */
    public function crear_cenco( Request $request ){
        
       $this->validate($request, [
          "cliente_id" => "required|numeric",
          "codigo" => "required",
          "descripcion" => "required|string|min:3|max:100"
       ],[
           "cliente_id.required" => "El código del cliente es requerido",
           "cliente_id.numeric" => "El código del cliente debe ser númerico",
           "codigo.required" => "El código del centro de costo es requerido",
           "descripcion.required" => "La descripción del centro de costo es requerida",
           "descripcion.string" => "La descripcion debe ser caracteres",
           "descripcion.min" => "No es una descripción válida",
           "descripcion.max" => "La descripción debe tener máximo 100 caracteres"
       ]);
       
       $cenco = new CentrosCostos();
       
       return response()->json([
        "success" => true,
        "error" => false,
        "message" => "Centro de Costo creado correctamente"
    ], 200);

    }
    /* 
        Descripción : Permite crear un cliente en la instancia.
        Parametros : 
                    codigo_id(requerido), 
                    nit(requerido), 
                    nombre(requerido), 
                    direccion(Opcional),
                    telefono(requerido),
                    fax(opcional),
                    pag_web(opcional), 
                    contacto(opcional), 
                    cargo(opcional),
                    correo(opcional),
                    departamento_id(dane)(requerido), 
                    ciudad_id(dane)(requerido)

        devuelve : un booleano true -> si lo pudo crear y false si hubo un error
        */
    public function crear_cliente(Request $request){

        $this->validate($request, [
            "codigo_id" => "required|numeric|unique:clientes,id",
            "nit" => "required|numeric", // sin puntos
            "nombre" => "required|alpha_num",
            "direccion" => "alpha_num",
            "telefono" => "required|numeric",
            "fax" => "numeric",
            "pag_web" => "url",
            "correo" => "email",
            "departamento_id" => "integer",
            "ciudad_id" => "integer"
        ],[
            "codigo_id.required" => "El código del cliente es requerido",
            "codigo_id.numeric" => "El código debe ser númerico",
            "codigo_id.unique" => "El código del cliente ya existe en nuestra base de datos",
            "nit.required" => "El nit del cliente es requerido",
            "nit.numeric" => "El nit debe ser un número sin puntos ni nada",
            "nit.numeric" => "El nit debe ser un número sin puntos ni nada",
            "nombre.required" => "El nombre del cliente es requerido",
            "nombre.alpha_num" => "Nombre inválido solo debe contener letras y números",
            "direccion.alpha_num" => "La dirección debe contener letras y números",
            "telefono.required" => "El teléfono es requerido",
            "telefono.numeric" => "El teléfono debe ser un número",
            "fax.numeric" => "El fax debe ser un número",
            "pag_web.url" => "El formato de sitio web debe ser http://www.dominiocliente.com",
            "correo.email" => "Formato de correo inválido",
            "departamento_id.integer" => "El departamento debe ser el código DANE sin cero por delante",
            "ciudad_id.integer" => "La ciudad debe ser el código DANE sin cero por delante"
        ]);

        $cliente = new Clientes();
        $cliente->id            = $request->get('codigo_id');
        $cliente->cliente_id    = $request->get('codigo_id');
        $cliente->nit           = $request->get('nit');
        $cliente->nombre        = strtoupper($request->get('nombre'));
        $cliente->direccion     = $request->get('direccion');
        $cliente->telefono      = $request->get('telefono');
        $cliente->fax           = $request->get('fax');
        $cliente->pag_web       = $request->get('pag_web');
        $cliente->correo                 = $request->get('correo');
        $cliente->departamento_id        = $request->get('departamento_id');
        $cliente->ciudad_id              = $request->get('ciudad_id');
        $cliente->estado                 = "ACT";
        $cliente->contacto               = $request->get('contacto');
        $cliente->cargo                  = $request->get('cargo');
        $cliente->save();

        return response()->json([
            "success" => true,
            "error" => false,
            "message" => "Cliente Creado correctamente"
        ], 200);
        
    }
    //Parametros
    /**
     * estado_contrato = C, AC, R, AR
     * num_contrato
     * fecha_contrato
     * fin_contrato
     * requerimiento
     * observaciones
     * cedula_candidato
     *  */
    public function candidatos_contratados(Request $request){

        $this->validate($request, [
            "estado_contrato" => "required",
            "num_contrato" => "required",
            "fecha_contrato" => "required|date:YY-MM-DD",
            "fin_contrato" => "required|date:YY-MM-DD",
            "requerimiento" => "required|numeric",
            "cedula_candidato" => "required|numeric"
        ],[
            "estado_contrato.required" => "El estado del contrato es requerido",
            "num_contrato.required" => "El número del contrato es requerido",
            "fecha_contrato.required" => "La fecha de inicio del contrato es requerido",
            "fecha_contrato.date" => "La fecha de inicio no es un formato válido. debe ser AAAA-MM-DD",
            "fin_contrato.required" => "La fecha de fin del contrato es requerido",
            "fin_contrato.date" => "La fecha de fin no es un formato válido. debe ser AAAA-MM-DD",
            "requerimiento.required" => "El número de requerimiento es requerido",
            "requerimiento.numeric" => "El número de requerimiento debe ser númerico",
            "cedula_candidato.required" => "El número de cédula del candidato es requerido",
            "cedula_candidato.numeric" => "El número de cédula del candidato debe ser númerico",
        ]);
        
        $estado_contrato = $request->get('estado_contrato');
        $num_contrato = $request->get('num_contrato');
        $fecha_contrato = $request->get('fecha_contrato');
        $fin_contrato = $request->get('fin_contrato');
        $requerimiento = $request->get('requerimiento');
        $cedula_candidato = $request->get('cedula_candidato');
        $observaciones = $request->get('observaciones');

        // miramos el usuario id del candidato de la cedula
        $candidato = DatosBasicos::where("numero_id", $cedula_candidato)
                        ->select("user_id")
                        ->first();
        
        $u_contratacion = RegistroProceso::where("proceso", "ENVIO_CONTRATACION")
                                         ->where("requerimiento_id", $requerimiento)
                                         ->where("candidato_id", $candidato->user_id)
                                         ->update([
                                             "numero_contrato" => $num_contrato,
                                             "fecha_contrato" => $fecha_contrato,
                                             "fecha_inicio_contrato" => $fecha_contrato,
                                             "fecha_fin_contrato" => $fin_contrato,
                                             "estado_contrato" => $estado_contrato,
                                             "cand_contratado" => 1
                                         ]);
        // Ahora agregamos un registro en requerimiento_cantidato
        $requerimiento_cantidato = new ReqCandidato();
        $requerimiento_cantidato->requerimiento_id = $requerimiento;
        $requerimiento_cantidato->candidato_id = $candidato->user_id;
        $requerimiento_cantidato->estado_candidato = config('conf_apliccion.C_CONTRATADO');
        $requerimiento_cantidato->procesado = 1;
        $requerimiento_cantidato->save();

        return response()->json([
            "success" => true,
            "error" => false,
            "message" => "Candidato actualizado correctamente"
        ], 200);
    }

    // Parametros opcionales :
    // cedula => si se consulta un solo candidato
    // fecha inicio y fecha final

    public function candidatos_enviados_contratar(Request $request){
        $data = [];
        $cedula = trim($request->cedula);
        if($request->has('fecha_inicio') and $request->has('fecha_final') ){
           $fecha_inicio = date("Y-m-d", strtotime($request->fecha_inicio));
           $fecha_final = date("Y-m-d", strtotime($request->fecha_final));
           $fecha_inicio_hoy = $fecha_inicio.' 00:00:00';
           $fecha_final_hoy  = $fecha_final.' 23:59:59';
        }else{
            $fecha_hoy = date("Y-m-d", time());
            $fecha_inicio_hoy = $fecha_hoy.' 00:00:00';
            $fecha_final_hoy  = $fecha_hoy.' 23:59:59';
        }

        $enviados_a_contratar = ReqCandidato::from('requerimiento_cantidato as b')
                                ->select(
                                    "b.id",
                                    DB::raw("upper(a.nombres) as nombres"),
                                    DB::raw("upper(a.primer_apellido) as primer_apellido"),
                                    DB::raw("upper(a.segundo_apellido) as segundo_apellido"),
                                    "a.numero_id", 
                                    "b.requerimiento_id",
                                    "b.created_at as fecha_envio"
                                )->join("datos_basicos as a", "a.user_id", "=", "b.candidato_id")
                                ->where("b.procesado", "=", 0)
                                ->where("b.estado_candidato", "=", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'))
                                ->where(function( $sql )use( $cedula, $fecha_inicio_hoy, $fecha_final_hoy ){
                                    if( isset($cedula) and $cedula!="" ){
                                        $sql->where( "a.numero_id", $cedula );
                                    }
                                    if( $fecha_inicio_hoy!="" and $fecha_final_hoy!="" ){
                                        $sql->whereBetween('b.created_at', [$fecha_inicio_hoy, $fecha_final_hoy]);
                                    }
                                })->get();
        if( $enviados_a_contratar->count()>0 ){

            foreach( $enviados_a_contratar->toArray() as $candidato ){
                $data[] = $candidato;
                /* $u_candidato = ReqCandidato::where("id", $candidato['id'])
                ->update(["procesado"=>1]); */
            }
            
            return response()->json($data, 200);
        }else{
            return response()->json([
                'message' => 'No hay datos.'
             ], 200);
        }
        //dd($enviados_a_contratar);
    }
    // Esta funcion nos va a devolver los datos de las hojas de vida segun las fechas consultadas
    // ó una cedula que le pasen.
    // Parametros : una cedula, ó un rango de fecha, una fecha de hoy

    public function cvs(Request $request){

        //Validación TODO

        $data = [];

        $cedula = trim($request->cedula);
        if($request->has('fecha_inicio') and $request->has('fecha_final') ){
           $fecha_inicio = date("Y-m-d", strtotime($request->fecha_inicio));
           $fecha_final = date("Y-m-d", strtotime($request->fecha_final));
           $fecha_inicio_hoy = $fecha_inicio.' 00:00:00';
           $fecha_final_hoy  = $fecha_final.' 23:59:59';
        }else{
            $fecha_hoy = date("Y-m-d", time());
            $fecha_inicio_hoy = $fecha_hoy.' 00:00:00';
            $fecha_final_hoy  = $fecha_hoy.' 23:59:59';
        }
        
        //dd( $fecha_inicio_hoy ." ". $fecha_final_hoy );
        
        $datos_basicos = DatosBasicos::where('procesado', 0)
                         ->where(function($sql)use( $cedula, $fecha_inicio_hoy, $fecha_final_hoy ){
                            if( isset($cedula) and $cedula!="" ){
                                $sql->where( "numero_id", $cedula );
                            }
                            if( $fecha_inicio_hoy!="" and $fecha_final_hoy!="" ){
                                $sql->whereBetween('created_at', [$fecha_inicio_hoy, $fecha_final_hoy]);
                            }
                         })
                         ->get();
        //dd($datos_basicos[0]->id);
        if($datos_basicos->count()>=1){
            foreach( $datos_basicos->toArray() as $key => $value ){
                $data[$key] = $value;
                //dd($data[$key]['id']);
                // Experiencias
                $experiencias = Experiencias::where('user_id', $value['user_id'])->get();
                if($experiencias->count()>0){
                    $data[$key]['experiencias'] = $experiencias->toArray();
                }else{
                    $data[$key]['experiencias'] = null;
                }
                
                // Estudios
                $estudios = Estudios::where('user_id', $value['user_id'])->get();
                if($estudios->count()>0){
                    $data[$key]['estudios'] = $estudios->toArray();
                }else{
                    $data[$key]['estudios'] = null;
                }
                //Grupo familiar
                $grupo_familiar = GrupoFamilia::where('user_id', $value['user_id'])->get();
                if($grupo_familiar->count()>0){
                    $data[$key]['grupo_familiar'] = $grupo_familiar->toArray();
                }else{
                    $data[$key]['grupo_familiar'] = null;
                }

                // Idiomas
                $idiomas = IdiomaUsuario::where("idioma_usuario.id_usuario", $value['user_id'])
                           ->select("idioma_usuario.id_idioma", "idioma_usuario.nivel", "b.descripcion as idioma_text", "c.descripcion as nivel_text")
                           ->join("idiomas as b","idioma_usuario.id_idioma", "=", "b.id")
                           ->join("niveles_idioma as c", "idioma_usuario.nivel", "=", "c.id")
                           ->get();
                if($idiomas->count()>0){
                    $data[$key]['idiomas'] = $idiomas->toArray();
                }else{
                    $data[$key]['idiomas'] = null;
                }
                
            }
            return response()->json($data, 200);
        }else{
            return response()->json([
               'message' => 'No hay datos.'
            ], 200);
        }


    }
    /**
     *  Parametros 
     *  @ cedula : es la cedula del candidato que se proceso.
     *  @ flag : es la bandera que indica si se procesó bien ó no.
     *  
     */
    public function set_procesados( Request $request ){
        
        //dd( count($request->get('cedulas')) ); // 3
       
        /* $this->validate($request, [
            "cedula" => "required|numeric",
            "flag" => "required|numeric"
         ],[
             "cedula.required" => "El número de cédula del candidato es requerida",
             "cedula.numeric" => "El número de cédula es númerico",
             "flag.required" => "La bandera de procesado es requerida 1=>exito 0=>no se pudo procesar",
             "flag.numeric" => "La bandera de procesado debe ser un número 1 ó 0(zero)",
         ]); */
         $cedulas = $request->get('cedulas'); // array
         //$flag = $request->get('flag');

         if( $this->setProcesadoDatosBasicos( $cedulas ) ){
            return response()->json([
                "message" => "registro procesado satisfactoriamente"
            ], 200);
         }else{
            return response()->json([
                "message" => "Hubo un error al realizar el proceso "
            ], 200);
         }
         
    }

    private function setProcesadoDatosBasicos($cedulas){
        // Al final lo marcamos como procesado
        DatosBasicos::whereIn("numero_id", $cedulas )
                           ->update(["procesado" => 1]);
        return true;
        
        
    }

    private function setRequerimientosProcesados($requerimientos){
        // Al final lo marcamos como procesado
        Requerimiento::whereIn("id", $requerimientos )
                           ->update(["procesado" => 1]);
        return true;
    }

    public function set_req_procesados(Request $request){

         $requerimientos = $request->get('requerimientos');

         if( $this->setRequerimientosProcesados( $requerimientos ) ){
            return response()->json([
                "message" => "registro procesado satisfactoriamente"
            ], 200);
         }else{
            return response()->json([
                "message" => "Hubo un error al realizar el proceso "
            ], 200);
         }

    }

    public function requerimientos(Request $request){
        $data = [];
        if($request->has('fecha_inicio') and $request->has('fecha_final') ){
           $fecha_inicio = date("Y-m-d", strtotime($request->fecha_inicio));
           $fecha_final = date("Y-m-d", strtotime($request->fecha_final));
           $fecha_inicio_hoy = $fecha_inicio.' 00:00:00';
           $fecha_final_hoy  = $fecha_final.' 23:59:59';
        }else{
            $fecha_hoy = date("Y-m-d", time());
            $fecha_inicio_hoy = $fecha_hoy.' 00:00:00';
            $fecha_final_hoy  = $fecha_hoy.' 23:59:59';
        }
        
        $requerimientos = Requerimiento::where("procesado", 0)
                          ->where(function($sql)use($fecha_inicio_hoy, $fecha_final_hoy){
                              if( $fecha_inicio_hoy!="" and $fecha_final_hoy!="" ){
                                $sql->whereBetween('created_at', [$fecha_inicio_hoy, $fecha_final_hoy]);
                              }
                          })
                          ->select('*')
                          ->get();
        if( $requerimientos->count()>=1 ){
            foreach( $requerimientos->toArray() as $requerimiento ){
                $data[] = $requerimiento;
            }
            return response()->json($data, 200);
        }else{
            return response()->json([
               'message' => 'No hay requerimientos.'
            ], 200);
        }

    }

    public function login(Request $request){
        // Primero validamos la data que viene
        $rules = [
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ];

        $messages = [
            'email.required'    => 'Correo electrónico es obligatorio.',
            'email.email'       => 'El correo electrónico no es válido',
            'password.required' => 'Contraseña es obligatoria',
            'password.min'      => 'Contraseñas deben contener entre :min caracteres.',
        ];

        $this->validate($request, $rules, $messages);
        
        try {
            if ($user = Sentinel::authenticate($request->all())) {
                if ( Sentinel::inRole('admin') ){
                    $user->generateToken();

                    return response()->json([
                        "error" => false,
                        "name" => $user->name,
                        "email" => $user->email,
                        "api_token" => $user->api_token
                    ], 200);
                } else {
                    return response()->json([
                        'error'   => true,
                        'mensaje' => 'No tienes permisos para acceder a este recurso.',
                    ], 200);
                }
            } else {
                return response()->json([
                    'error'   => true,
                    'mensaje' => 'Credenciales incorrectas',
                ], 200);
            }
        } catch (ThrottlingException $e) {
            return response()->json(['error' => "Bloqueada la dirección IP durante $delay segundos, por 5 intentos de autenticación no correctos."], 400);
        }
    }

}
