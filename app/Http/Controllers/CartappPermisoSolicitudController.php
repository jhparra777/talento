<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use \DB;
use triPostmaster;

use App\Models\CartappAuditoria;
use App\Models\CartappPermisoSolicitud;
use App\Models\DatosBasicos;
use App\Models\ReqCandidato;
use App\Models\Sitio;

class CartappPermisoSolicitudController extends Controller
{
    public function listado_permisos_cartapp() {
        $tipos_restricciones = ['' => 'Seleccionar'] + collect(DB::table('cartapp_motivo_termino')->where('active', 1)->get())->pluck("descripcion", "id")->toArray();

        //dd($tipos_restricciones);

        $datos_lista_permiso = CartappPermisoSolicitud::leftjoin('cartapp_motivo_termino', 'cartapp_motivo_termino.id', '=', 'cartapp_permiso_solicitud.motivo_termino_id')
            ->leftjoin('datos_basicos', 'datos_basicos.numero_id', '=', 'cartapp_permiso_solicitud.numero_id')
            ->select(
                'cartapp_motivo_termino.descripcion',
                'cartapp_permiso_solicitud.fecha_fin_contrato',
                'cartapp_permiso_solicitud.motivo_termino_id',
                'cartapp_permiso_solicitud.numero_id',
                'cartapp_permiso_solicitud.observacion_otro_motivo',
                'cartapp_permiso_solicitud.permiso_solicitud',
                'datos_basicos.nombres',
                'datos_basicos.primer_apellido'
            )
        ->get();

        return view('admin.cartapp.candidatos_permiso_cartapp')->with(
            [
            'tipos_restricciones' => $tipos_restricciones,
            'datos_lista_permiso' => $datos_lista_permiso
            ]
        );
    }

    public function agregar_cedula_adelanto_nomina(Request $data)
    {
        $editar = true;
        $permiso_solicitud = CartappPermisoSolicitud::where('numero_id', $data->cedula)->first();

        if ($permiso_solicitud == null) {
            $permiso_solicitud = new CartappPermisoSolicitud();
            $editar = false;
        } else {
            $permiso_antes = $permiso_solicitud->permiso_solicitud;
        }

        $fecha_fin_contrato = null;
        $otro_motivo = null;
        $motivo_termino_id = $data->motivo_termino_id;
        if ($data->permiso == '1') {
            $motivo_termino_id = null;
        }

        if ($motivo_termino_id == '1') {
            $fecha_fin_contrato = $data->fecha_fin_contrato;
        } elseif ($motivo_termino_id == '2') {
            $otro_motivo = $data->otro_motivo;
        }

        $permiso_solicitud->numero_id               = $data->cedula;
        $permiso_solicitud->permiso_solicitud       = $data->permiso;
        $permiso_solicitud->motivo_termino_id       = $motivo_termino_id;
        $permiso_solicitud->fecha_fin_contrato      = $fecha_fin_contrato;
        $permiso_solicitud->observacion_otro_motivo = $otro_motivo;
        $permiso_solicitud->gestiono                = $this->user->id;
        $response = $permiso_solicitud->save();

        $observacion = 'Se ha habilitado para hacer solicitud de adelanto de nómina.';
        if (!is_null($motivo_termino_id)) {
            $restriccion = DB::table('cartapp_motivo_termino')->select('descripcion', 'id')->find($data->motivo_termino_id);
            if (!is_null($restriccion)) {
                $observacion = 'Se ha inahabilitado el permiso para hacer solicitud de adelanto de nómina debido a <b>' . $restriccion->descripcion . '</b>';
                if (!is_null($fecha_fin_contrato)) {
                    $observacion .= " el <b>$fecha_fin_contrato</b>.";
                } elseif (!is_null($otro_motivo)) {
                    $observacion .= ": <b>$otro_motivo</b>.";
                }
            }
        }

        if ($data->permiso != '1') {
            $datos_basicos = DatosBasicos::leftjoin('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
                ->where('numero_id', $data->cedula)
                ->select(
                    'datos_basicos.nombres',
                    'datos_basicos.primer_apellido',
                    'datos_basicos.tipo_id',
                    'tipo_identificacion.descripcion as tipo_doc_desc'
                )
            ->first();

            $nombre_contratado = null;
            $desc_doc = '';
            if (!is_null($datos_basicos)) {
                $nombre_contratado = $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido;
                $desc_doc = $datos_basicos->tipo_doc_desc;
            }

            $gestiona = DatosBasicos::where('user_id', $this->user->id)
                ->select(
                    'datos_basicos.nombres',
                    'datos_basicos.primer_apellido',
                    'datos_basicos.email',
                    'datos_basicos.user_id'
                )
            ->first();

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Inactivación para solicitud de adelantos de nómina"; //Titulo o tema del correo

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = 'Hola, te confirmamos que el usuario <b>' . $gestiona->nombres . ' ' . $gestiona->primer_apellido . '</b> ha realizado la inactivación para solicitar adelantos de nómina del contratado con la siguiente información:<br><br><br>';
            if($nombre_contratado != null ) {
                $mailBody .= "<b>Nombre contratado:</b> $nombre_contratado <br><br>";
            }
            $mailBody .= "<b>Documento de identidad:</b> $desc_doc $data->cedula <br><br>";
            $mailBody .= "<b>Motivo:</b> $restriccion->descripcion <br><br>";
            $mailBody .= "<b>Observación:</b> $observacion";

            //Arreglo para el botón
            $mailButton = [];

            $mailUser = $gestiona->user_id; //Id del usuario al que se le envía el correo

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            $email = $gestiona->email;
            $asunto = "Inactivación para solicitud de adelantos de nómina";

            if($email != null && $email != ""){
                $sitio = Sitio::first();

                if ($sitio->email_instancia_cartapp != null) {
                    Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $sitio, $asunto) {
                        $message->to([$email], 'T3RS')
                        ->subject($asunto)
                        ->cc(['jandres8585@gmail.com', $sitio->email_instancia_cartapp])
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                } else {
                    Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $sitio, $asunto) {
                        $message->to([$email], 'T3RS')
                        ->subject($asunto)
                        ->cc('jandres8585@gmail.com')
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                }
            }
        }

        if ($editar) {
            $auditoria                  = new CartappAuditoria();
            $auditoria->observaciones   = str_replace("</b>", "", str_replace("<b>", "", $observacion));
            $auditoria->valor_antes     = json_encode(["permiso_solicitud" => $permiso_antes]);
            $auditoria->valor_despues   = json_encode(["permiso_solicitud" => $data->permiso]);
            $auditoria->numero_id       = $data->cedula;
            $auditoria->gestiona        = $this->user->id;
            $auditoria->permiso_id      = $permiso_solicitud->id;
            $auditoria->tipo            = 'ACTUALIZAR';
            $auditoria->save();
        }

        if (!is_null($fecha_fin_contrato)) {
            $req_candidato = ReqCandidato::join('datos_basicos', 'datos_basicos.user_id', '=', 'requerimiento_cantidato.candidato_id')
                ->where('datos_basicos.numero_id', $data->cedula)
                ->orderBy('requerimiento_cantidato.id', 'desc')
            ->first();

            if (!is_null($req_candidato)) {
                $fecha_anterior = $req_candidato->fecha_terminacion_contrato;
                $req_candidato->fecha_terminacion_contrato = $fecha_fin_contrato;
                $req_candidato->save();
            }
        }

        return response()->json(['rs' => $response]);
    }

    public function agregar_cedula_adelanto_nomina_masivo(Request $data) {
        $rules = [
            'archivo' => 'required',
            'permiso' => 'required'
        ];
        $permisos_solicitud = CartappPermisoSolicitud::get();

        $valida = Validator::make($data->all(), $rules);
        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida)->withInput();
        }

        $reader = Excel::selectSheetsByIndex(0)->load($data->file("archivo"))->get();

        $errores_global      = [];
        $registrosInsertados = 0;

        $motivo_termino_id = null;
        $otro_motivo = null;

        if ($data->permiso != '1') {
            $motivo_termino_id = 2; //otro motivo
            $otro_motivo = $data->otro_motivo;
        }

        foreach ($reader as $key => $value) {
            $errores = [];
            $datos   = [
                'cedula'    => $value->cedula
            ];

            $guardar = true;

            $cedula = Validator::make($datos, ["cedula" => "required"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "El campo cédula es obligatorio.");
            }

            $cedula = Validator::make($datos, ["cedula" => "numeric"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "La cédula debe ser numérico.");
            }

            /*
            $cedula = Validator::make($datos, ["cedula" => "unique:lista_negra,cedula"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "Este número de cédula $value->cedula ya ha sido cargado.");
            }

            $restriccion = Validator::make($datos, ["restriccion" => "required"]);
            if ($restriccion->fails()) {
                $guardar = false;
                array_push($errores, "El campo restricción es obligatorio.");
            }
            */

            if ($guardar) {
                $editar = true;
                $permiso_solicitud = CartappPermisoSolicitud::where('numero_id', $datos['cedula'])->first();

                if ($permiso_solicitud == null) {
                    $permiso_solicitud = new CartappPermisoSolicitud();
                    $editar = false;
                } else {
                    $permiso_antes = $permiso_solicitud->permiso_solicitud;
                }

                $data_procesada[] = $datos['cedula'];

                $permiso_solicitud->numero_id               = $datos['cedula'];
                $permiso_solicitud->permiso_solicitud       = $data->permiso;
                $permiso_solicitud->motivo_termino_id       = $motivo_termino_id;
                $permiso_solicitud->fecha_fin_contrato      = null;
                $permiso_solicitud->observacion_otro_motivo = $otro_motivo;
                $permiso_solicitud->gestiono                = $this->user->id;
                $permiso_solicitud->save();

                if ($editar && $permiso_antes != $data->permiso) {
                    $observacion = 'Se ha habilitado para hacer solicitud de adelanto de nómina.';
                    if (!is_null($motivo_termino_id)) {
                        $observacion = 'Se ha inahabilitado el permiso para hacer solicitud de adelanto de nómina debido a <b>otro motivo</b>';
                        if (!is_null($otro_motivo)) {
                            $observacion .= ": <b>$otro_motivo</b>.";
                        }
                    }

                    $auditoria                  = new CartappAuditoria();
                    $auditoria->observaciones   = str_replace("</b>", "", str_replace("<b>", "", $observacion));
                    $auditoria->valor_antes     = json_encode(["permiso_solicitud" => $permiso_antes]);
                    $auditoria->valor_despues   = json_encode(["permiso_solicitud" => $data->permiso]);
                    $auditoria->numero_id       = $datos['cedula'];
                    $auditoria->gestiona        = $this->user->id;
                    $auditoria->permiso_id      = $permiso_solicitud->id;
                    $auditoria->tipo            = 'ACTUALIZAR';
                    $auditoria->save();
                }

                $registrosInsertados++;
            } else {
                $errores_global[$key] = $errores;
            }
        }

        if ($data->permiso == '1') {
            $otro_motivo = 'Base de datos actualizada por Dayana Ayala (Administracion ATC) al 09 de mayo de 2022';
            foreach ($permisos_solicitud as $key => $permiso_user) {
                if (!in_array($permiso_user->numero_id, $data_procesada) && $permiso_user->permiso_solicitud == 1) {
                    $permiso_user->permiso_solicitud       = '0';
                    $permiso_user->motivo_termino_id       = 2;
                    $permiso_user->fecha_fin_contrato      = null;
                    $permiso_user->observacion_otro_motivo = $otro_motivo;
                    $permiso_user->gestiono                = $this->user->id;
                    $permiso_user->save();

                    $observacion = 'Se ha inahabilitado el permiso para hacer solicitud de adelanto de nómina debido a <b>otro motivo</b>' . ": <b>$otro_motivo</b>.";

                    $auditoria                  = new CartappAuditoria();
                    $auditoria->observaciones   = str_replace("</b>", "", str_replace("<b>", "", $observacion));
                    $auditoria->valor_antes     = json_encode(["permiso_solicitud" => 1]);
                    $auditoria->valor_despues   = json_encode(["permiso_solicitud" => 0]);
                    $auditoria->numero_id       = $permiso_user->numero_id;
                    $auditoria->gestiona        = $this->user->id;
                    $auditoria->permiso_id      = $permiso_user->id;
                    $auditoria->tipo            = 'ACTUALIZAR';
                    $auditoria->save();
                }
            }
        }

        return redirect()->route("admin.lista_adelanto_nomina")->with("mensaje_success", "Se han cargado <b>$registrosInsertados</b> registros con éxito.")->with("errores_global", $errores_global);
    }

    public function reporte_permisos_adelanto_nomina_excel(Request $request) {
        $user_sesion = $this->user;
        $sitio = Sitio::first();

        $nombre_sitio = $sitio->nombre;

        $formato = $request->formato;

        $permiso = null;
        if($request->permiso_excel != ""){
            $permiso = $request->permiso_excel;
        }

        $permisos = CartappPermisoSolicitud::leftjoin('datos_basicos', 'datos_basicos.numero_id', '=', 'cartapp_permiso_solicitud.numero_id')
            ->where(function ($where) use ($permiso) {
                if ($permiso != null) {
                    $where->where("cartapp_permiso_solicitud.permiso_solicitud", $permiso);
                }
            })
            ->select(
                'cartapp_permiso_solicitud.permiso_solicitud',
                'cartapp_permiso_solicitud.numero_id',
                'datos_basicos.email',
                'datos_basicos.estado_reclutamiento',
                'datos_basicos.nombres',
                'datos_basicos.primer_apellido',
                'datos_basicos.segundo_apellido',
                'datos_basicos.telefono_movil',
                'datos_basicos.user_id'
            )
            ->orderBy('cartapp_permiso_solicitud.created_at', 'DESC')
        ->get();

        Excel::create('reporte-permisos-adelanto-nomina', function ($excel) use ($permisos, $formato, $nombre_sitio) {
            $excel->setTitle('Permisos adelanto nómina');
            $excel->setCreator($nombre_sitio);
            $excel->setCompany($nombre_sitio);
            $excel->setDescription('Permisos adelanto nómina');
            $excel->sheet('Permisos adelanto nómina', function ($sheet) use ($permisos, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.cartapp._grilla_permisos_adelanto_nomina', [
                    'permisos'  => $permisos,
                    'formato'   => $formato,
                ]);
            });
        })->export($formato);
    }
}
