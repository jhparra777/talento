<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contratación</title>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    </head>
  
    <style>
            body{
                font-size: 12px;
            }
            .tabla1,.tabla3{
                border-collapse: collapse;
                width: 100%;
            }

            .tabla1, .tabla1 th, .tabla1 td,.tabla3 th, .tabla3 td {
                border: 1px solid black;
                padding: 0;
                margin: 0;
            }
            .tabla2{
                border-collapse: collapse;
                width: 100%;

            }

            .tabla2 td {
                border-right: 1px solid black;    
                padding: 10px;
                margin: 0;
                text-align: center;

            }
            .tabla3 td{
                padding: 5px;
            }

            @page { margin: 50px 50px; }
            .page-break {
                page-break-after: always;
            }

            /*            .titulos_tabla tr td:nth-child(1),.titulos_tabla  tr td:nth-child(3){
                        background-color: #fafafa;
                        font-weight: bold;
                    }*/
            .imagen{

                height: 150px

            }
            body{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
            }
            .titulo{
                background-color: #cacaca;
                padding: 10px 0px;
                text-align: center;
                font-size: 12px;

            }
            .tabla3 tr th{
                background-color: #fafafa;
                font-weight: bold;
            }



            span {
                width: 72% !important;
                padding: 5px 0px 5px 0px;
                /*padding-bottom: 9px;*/
                /*border: 1px solid Black;*/
            }
            span.table {
                /*border-collapse: collapse;*/
                /*display: table;*/
            }
            span .td {
                border: none !important;
                background: White !important;
                /*  display: table-cell;*/
                padding-left: 10px;
                font-size: 16px;
                margin-bottom: 30px;
                border:none !important;
            }
            span .tr {
                /* display: table-row;*/
                border: 1px solid Black;
                padding: 2px 2px 2px 5px;
                background-color: #f5f5f5;
            }
            span .th {
                text-align: left;
                font-weight: bold;
            }

        </style>
       

    <body>
        <!-- Validar si el usuario es rol ADMIn para poder ver si el candidato tiene problemas de seguridad -->
        @if(Sentinel::check()->inRole("admin"))
            <!-- Validamos si el candidato esta con estado 5 que hace referencia a problemas de seguridad -->
            @if($datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD'))
                <div class="classname">!!</div>
            @endif
        @endif
        <table class="tabla1" >
            <tr>
                <td style="width: 30%">
                    @if(isset(FuncionesGlobales::sitio()->logo))
                        @if(FuncionesGlobales::sitio()->logo != "")
                            <img style="max-width: 200px" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}">
                        @else
                            <img style="max-width: 200px" src="{{url('img/logo.png')}}" >
                        @endif
                    @else
                        <img style="max-width: 200px" src="{{url('img/logo.png')}}">
                    @endif
                </td>

                @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
                <td>
                    

                        <table class="tabla2">
                            <tr>
                                <td colspan="3">REMISION A CONTRATACIÓN</td>
                            </tr>
                           
                            <tr>
                                <td>Código: SEFM15</td>
                                <td>Versión:2.0</td>
                                <td>
                                 {!!Form::label('password', 'Contraseña')!!}   
                                </td>
                            </tr>
                           
                        </table>

                </td>
                @else
                    <td colspan="3" style="text-align: center;">REMISION A CONTRATACIÓN</td>
                @endif


            </tr>
        </table>
        <br>
        @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
         <h3 class="titulo" >INFORMACIÓN GENERAL DE LA SOLICITUD</h3>

        <table class="tabla1">
            <tr>
                <td>Tipo de Solicitud</td>
                <td>{{$requerimiento->getTipoProceso()}}</td>
                <td>Sitio de trabajo</td>
                <td>{{$reqcandidato->sitio_trabajo}}</td>
            </tr>
            <tr>
                <td>Cliente</td>
                <td>{{$reqcandidato->cliente_nombre}}</td>
                <td>N° Requerimiento</td>
                <td>{{$reqcandidato->requerimiento_id}}</td>
            </tr>
           
        </table>
        <br>
        <h3 class="titulo" >ESPECIFICACIONES DEL REQUERIMIENTO</h3>

        <table class="tabla1">
            <tr>
                <td>Cargo Cliente</td>
                <td>{{strtoupper($requerimiento->getCargoEspecifico()->descripcion)}}</td>
                <td>Centro de Trabajo</td>
                <td>{{ $requerimiento->getCentroTrabajo()->nombre_ctra }}</td>
            </tr>
            <tr>
                <td>Jornada Laboral</td>
                <td>{{($requerimiento->jornada())?$requerimiento->jornada()->descripcion:''}}</td>
                <td>Tipo Liquidación</td>
                <td>{{($requerimiento->getTipoLiquidacion())?$requerimiento->getTipoLiquidacion()->descripcion:''}}</td>
            </tr>
            <tr>
                <td>No. Horas Laborales</td>
                <td>{{$requerimiento->jornada()->procentaje_horas}}</td>
                <td>Tipo Salario</td>
                <td>{{$requerimiento->getTipoSalario()->descripcion}}</td>
            </tr>
            <tr>
                <td>Tipo Nómina</td>
                <td>{{($requerimiento->getTipoNomina())?$requerimiento->getTipoNomina()->descripcion:''}}</td>
                <td>Concepto Pago</td>
                <td>{{$requerimiento->getConceptoPagos()->descripcion}}</td>
            </tr>
            <tr>
                <td>Salario</td>
                <td>{{number_format($requerimiento->salario, 2)}}</td>
                <td>Tipo Contrato</td>
                <td>{{$requerimiento->getTipoContrato()->descripcion}}</td>
            </tr>
            <tr>
                <td>Motivo Requerimiento</td>
                <td>{{$requerimiento->getMotivoRequerimiento()->descripcion}}</td>
                <td></td>
                <td></td>
            </tr>
        </table>

          <table class="tabla1">
           <tr>
            <td>Observaciones</td>
           </tr>
           <tr>
            <td>{{$requerimiento->observaciones}}</td>
           </tr>            
          </table>

        @else
            <h3 class="titulo" >INFORMACIÓN GENERAL DE LA SOLICITUD</h3>

             <table class="tabla1">
                <tr>
                  <td>Cargo</td>
                  <td>{{$requerimiento->cargo_req()}}</td>
                  <td>N° Requerimiento</td>
                  <td>{{$reqcandidato->requerimiento_id}}</td>
                </tr>
                <tr>
                  <td>Sede</td>
                  <td> @if($solicitud->sede) {{$solicitud->sede->descripcion}} @endif</td>
                  <td>Area</td>
                  <td>{{$solicitud->area->descripcion}}</td>
                </tr>
                <tr>
                  <td>Sub-area</td>
                  <td>{{$solicitud->subarea->descripcion}}</td>
                  <td>Jefe Inmediato</td>
                  <td>@if($solicitud->jefeInmediato())
                    {{$solicitud->jefeInmediato()->nombre }}
                      @endif</td>
                </tr>
                 <tr>
                  <td>Email Jefe Inmediato</td>
                  <td>@if($solicitud->jefeInmediato())
                    {{$solicitud->jefeInmediato()->email }}
                      @endif</td>
                  <td>Centro beneficio</td>
                  <td>{{$solicitud->centrobeneficio->descripcion}}</td>
                </tr>
                <tr>
                  <td>Centro costo</td>
                  <td>{{$solicitud->centrocosto->descripcion}}</td>
                    <td>Recursos</td>
                    <td>
                     @if($solicitud->recursosNecesarios)
                      @foreach($solicitud->recursosNecesarios as $recurso)
                        {{$recurso->recurso_necesario}},
                      @endforeach
                    @endif 
                   </td>
                </tr>
                <tr>
                   <td>Salario</td>
                   <td>{{$solicitud->salario}}</td>
                   <td>Documento Adjunto</td>
                   <td><a href="{{ route('home') }}/documentos_solicitud/{{ $solicitud->documento }}" target="_black">
                    Ver documentos</a>
                   </td>
                </tr>
                <tr>
                  <td>Motivo contrato</td>
                  <td>@if($solicitud->motivo_requerimiento_id!=20)
                    @if(!empty($solicitud->motivoRequerimiento()))
                      {{$solicitud->motivoRequerimiento()->descripcion}}
                    @endif
                    @else
                    <strong>{{$solicitud->motivoRequerimiento()->descripcion}}</strong>:{{$solicitud->desc_motivo}}
                    @endif
                  </td>
                  <td>Descripcion Motivo</td>
                  <td>{{$solicitud->desc_motivo}}</td>
                </tr>
                <tr>
                  <td>Tipo Contrato</td>
                  <td>{{$solicitud->tipoContrato()->descripcion}}</td>
                  <td>Tiempo contrato</td>
                  <td>{{$solicitud->tiempo_contrato}}</td>
                </tr>
                <tr>
                <td>Justificación</td>
                <td colspan="3">{{$solicitud->funciones_realizar}}</td>
                </tr>
                <tr>
                <td>Observaciones</td>
                <td colspan="3">{{$solicitud->observaciones}}</td>
                </tr>
            </table>
            <br>

        @endif

        <h3 class="titulo" >INFORMACIÓN DEL ENVIO DE CONTRATACIÓN</h3>

        <table class="tabla1">
            <tr>
                <td>Fecha de Ingreso</td>
                <td>{{$proceso_candidato_contra->fecha_inicio_contrato}}</td>
                @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
                    <td>Fecha de Retiro</td>

                    @if($proceso_candidato_contra->fecha_fin == true)
                       <td>{{$proceso_candidato_contra->fecha_fin}}</td>
                     @else
                       <td colspan="2">No se colocó</td>
                    @endif

                @endif
                
            </tr>
            <tr>
              <td>Observaciones</td>
              <td>{{$proceso_candidato_contra->observaciones}}</td>
              <td colspan="3"></td>
            </tr>
           
        </table>

        <h3 class="titulo" >DATOS CANDIDATO</h3>

        <table class="tabla1">
            <tr>
                <td>Tipo ID</td>
                <td>{{$datos_basicos->dec_tipo_doc}}</td>
                <td>Número ID</td>
                <td>{{$datos_basicos->numero_id}}</td>
            </tr>
            <tr>
                <td>Ciudad ID</td>
                <td>{{ (($lugarexpedicion != null)? $lugarexpedicion->value:"")}}</td>
                <td>Fecha Expedición</td>
                <td>{{$datos_basicos->fecha_expedicion}}</td>
            </tr>
            <tr>
                <td>Nombres</td>
                <td>{{$datos_basicos->nombres}}</td>
                <td>Primer Apellido</td>
                <td>{{$datos_basicos->primer_apellido}}</td>
            </tr>
            <tr>
                <td>Segundo Apellido</td>
                <td>{{$datos_basicos->segundo_apellido}}</td>
                <td>Fecha Nacimiento</td>
                <td>{{ $datos_basicos->fecha_nacimiento}} </td>
            </tr>
            <tr>
                <td>Lugar Nacimiento</td>
                <td>{{ (($lugarnacimiento!=null)?$lugarnacimiento->value :"")}}</td>
                <td>Género</td>
                <td>{{ $datos_basicos->genero_desc }}</td>
            </tr>
            <tr>
                <td>Estado Civil</td>
                <td>{{ $datos_basicos->estado_civil_des }}</td>
                <td>Teléfono Móvil</td>
                <td>{{ $datos_basicos->telefono_movil}}</td>
            </tr>
            <tr>
                <td>Teléfono Fijo</td>
                <td>{{ $datos_basicos->telefono_fijo}}</td>
                <td>Correo Electrónico</td>
                <td>{{ $datos_basicos->email}}</td>
            </tr>
            <tr>
                <td>Aspiración Salarial</td>
                <td>{{ $datos_basicos->aspiracion_salarial_des }}</td>

                <td>Dirección</td>
                <td>{{ $datos_basicos->direccion}}</td>
               
            </tr>

            <tr>
               @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
                <td>Situación Militar Definida</td>
                <td>{{ (($datos_basicos->situacion_militar_definida == 1)?"SI":"NO") }}</td>
               @endif

               @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co")
                <td>Tiene Licencia</td>
                <td>{{((!empty($datos_basicos->categorias_licencias_des))?"SI":"NO")  }}</td>
               @endif
                <td>Categoría Licencia</td>
                <td>{{ $datos_basicos->categorias_licencias_des }}</td>
            </tr>
            @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
            <tr>
                <td>No. Libreta</td>
                <td>{{ $datos_basicos->numero_libreta}}</td>
                <td>Clase Libreta</td>
                <td>{{ $datos_basicos->clases_libretas_des }}</td>
            </tr>
            <tr>
                <td> Distrito Militar</td>
                <td>{{ $datos_basicos->distrito_militar}}</td>
                <td>Tiene Venículo</td>
                <td>{{ (($datos_basicos->tiene_vehiculo==1)?"si":"no") }}</td>
            </tr>
            <tr>
                <td>Tipo Venículo</td>
                <td>{{ $datos_basicos->tipos_vehiculos_des }}</td>
                <td> Licencia</td>
                <td>{{ $datos_basicos->numero_licencia}}</td>
            </tr>
            @endif
              @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
                <tr>
                  <td>Entidad(EPS)</td>
                  <td>{{ $datos_basicos->entidades_eps_des}}</td>
                  <td>Entidad(AFP)</td>
                  <td>{{ $datos_basicos->entidades_afp_des }}</td>
                  <td colspan="2"></td>
                </tr>
              @endif

            <tr>
              <td>Tiene Comflicto de Intereses</td>
              <td>{{(($datos_basicos->descripcion_conflicto)?"Si":"No") }}</td>
              <td> Descripcion de conflicto</td>
              <td>{{ $datos_basicos->descripcion_conflicto}}</td>
            </tr>
          

            @if(route("home")=="http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
            <tr>
             <td>Trabajo anteriormente en komatsu?</td>
             <td>{{(($datos_basicos->trabaja == 1)?"Si":"No") }}</td>
             <td></td>
             <td></td>
            </tr>
            @endif

        </table>
        <br>
        @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
            <h3 class="titulo" >EXPERIENCIA </h3>
            @foreach($experiencias as $key => $experiencia)
            <table class="tabla1" >

                <tr>
                    @if($key==0)
                    <th colspan="4">EXPERIENCIA ACTUAL O ÚLTIMA EXPERIENCIA</th>
                    @else
                    <th colspan="4">EXPERIENCIA ANTERIOR</th>
                    @endif
                </tr>

                <tr>
                    <td>Trabajó por medio de una temporal:</td>
                    <td colspan="3">{{(($experiencia->trabajo_temporal==1)?"Si":"No")}}</td>
                </tr>
                <tr>
                    <td>Nombre Temporal:</td>
                    <td colspan="3"> {{ $experiencia->nombre_temporal}}</td>
                </tr>
                <tr>
                    <td>Teléfono Temporal:</td>
                    <td colspan="3" >{{ $experiencia->telefono_temporal}}</td>
                </tr>
                <tr>
                    <td>Nombre Empresa:</td>
                    <td colspan="3" >{{ $experiencia->nombre_empresa}}</td>
                </tr>
                <tr>
                    <td>Ciudad:</td>

                    <td colspan="3" > {{ $experiencia->ciudades}} </td>
                </tr>
                <tr>

                    <td>Cargo Desempeñado:</td>
                    <td colspan="3" >{{ $experiencia->desc_cargo}}</td>
                </tr>
                <tr>
                    <td>Nombres Jefe:</td>
                    <td colspan="3" >{{ $experiencia->nombres_jefe}}</td>
                </tr>
                <tr>
                    <td>Cargo Jefe:</td>
                    <td colspan="3" >{{ $experiencia->cargo_jefe}}</td>
                </tr>
                <tr>
                    <td>Móvil Jefe:</td>
                    <td colspan="3" >{{ $experiencia->movil_jefe}}</td>
                </tr>
                <tr>
                    <td>Teléfono Fijo Jefe:</td>
                    <td>{{ $experiencia->fijo_jefe}}</td>

                    <th>Extensión:</th>
                    <td>{{ $experiencia->ext_jefe}}</td>
                </tr>
                <tr>
                 <td>Trabajo Actual:</td>
                 <td colspan="3" >{{ (($experiencia->empleo_actual == 1)?"Si":"No")}}</td>
                </tr>
                <tr>
                 <td>Fecha Inicio:</td>
                 <td colspan="3" >{{ $experiencia->fecha_inicio}}</td>
                </tr>
                @if(route("home")=="https://demo.t3rsc.co" )
                <tr>
                 <td>Fecha Terminación:</td>
                 <td colspan="3" >{{ $experiencia->fecha_final}}</td>
                </tr>
                @endif
                <tr>
                 <td>Salario Devengado:</td>
                 <td colspan="3" >{{ $experiencia->salario}}</td>
                </tr>
                <tr>
                 <td>Motivo Retiro:</td>
                 <td colspan="3" >{{ $experiencia->desc_motivo}}</td>
                </tr>
                <tr>
                 <td>Funciones y Logros:</td>
                 <td colspan="3">{{$experiencia->funciones_logros}}</td>
                </tr>

            </table>
            @endforeach
            <br>
            <h3 class="titulo" >ESTUDIOS </h3>
            @foreach($estudios as $estudio)
             <table class="tabla1">
                <tr>
                    <th colspan="2">Institución: {{$estudio->institucion}}</th>
                </tr>
                <tr>
                    <td>Nivel Estudio</td>
                    <td>{{$estudio->desc_nivel}}</td>
                </tr>
                <tr>
                    <td>Terminó Estudio</td>
                    <td>{{  (($estudio->termino_estudios==1)?"Si":"No") }}</td>
                </tr>
                <tr>
                    <td>Titulo Obtenido</td>
                    <td>{{  $estudio->titulo_obtenido}}</td>
                </tr>
                <tr>
                    <td>Estudio Actual</td>
                    <td>{{  $estudio->estudio_actual}}</td>
                </tr>
                <tr>
                    <td>Semestres Cursados</td>
                    <td>{{  $estudio->estudio_actual}}</td>
                </tr>
                <tr>
                    <td>Fecha Finalización</td>
                    <td>{{  $estudio->fecha_finalizacion}}</td>
                </tr>
             </table>
            @endforeach
            <br>
            <h3 class="titulo" >REFERENCIAS  PERSONALES</h3>
            @foreach($referencias as $key => $referencia)
            <table>
                <tr>
                    <th colspan="2">Referencia #{{++$key}}</th>
                </tr>
                <tr>
                    <td>Nombres:</td>
                    <td>{{ $referencia->nombres }}</td>
                </tr>
                <tr>
                    <td>Primer Apellido:</td>
                    <td>{{ $referencia->primer_apellido }}</td>
                </tr>
                <tr>
                    <td>Segundo Apellido:</td>
                    <td>{{ $referencia->segundo_apellido }}</td>
                </tr>
                <tr>
                    <td>Tipo relación:</td>
                    <td>{{ $referencia->desc_tipo }}</td>
                </tr>
                <tr>
                    <td>Teléfono Móvil:</td>
                    <td>{{ $referencia->telefono_movil }}</td>
                </tr>
                <tr>
                    <td>Teléfono Fijo:</td>
                    <td>{{ $referencia->telefono_fijo }}</td>
                </tr>
                <tr>
                    <td>Ciudad:</td>
                    <td> {{ $referencia->ciudades}} </td>
                </tr>
                <tr>
                    <td>Ocupación:</td>
                    <td>{{ $referencia->ocupacion }}</td>
                </tr>

            </table>
            @endforeach
            <br>
            <h3 class="titulo" >Grupo Familiar</h3>
            @foreach($familiares as $key => $familiar)
            <table class="colum1">
                <tr>
                    <td colspan="4">Referencia # {{++$key}} </td>
                </tr>
                <tr>
                    <td>Tipo Documento</td>
                    <td>{{$familiar->tipo_documento}}</td>

                    <th># Identidad/Registro Civil</th>
                    <td>{{ $familiar->documento_identidad}}</td>
                </tr>
    
                <tr>
                    <td>Nombres</td>
                    <td colspan="3">{{ $familiar->nombres}}</td>
                </tr>
                <tr>
                    <td>Primer Apellido</td>
                    <td colspan="3">{{ $familiar->primer_apellido}}</td>
                </tr>
                <tr>
                    <td>Segundo Apellido</td>
                    <td colspan="3">{{ $familiar->segundo_apellido}}</td>
                </tr>
                <tr>
                    <td>Escolaridad</td>
                    <td colspan="3">{{$familiar->escolaridad}}</td>
                </tr>
                <tr>
                    <td>Parentesco</td>
                    <td colspan="3">{{$familiar->parentesco}}</td>
                </tr>
                <tr>
                    <td>Género</td>
                    <td colspan="3">{{$familiar->genero}}</td>
                </tr>
                <tr>
                    <td>Fecha Nacimiento</td>
                    <td colspan="3">{{ $familiar->fecha_nacimiento}}</td>
                </tr>
                {{-- <tr>
                    <td>Ciudad Nacimiento</td>
                    <td colspan="3">
                        {{$familiar->getLugarNacimiento()->ciudad}}
                    </td>
                </tr> --}}
                <tr>
                    <td>Profesión</td>
                    <td colspan="3">{{ $familiar->profesion }}</td>
                </tr>
            </table>
            @endforeach
        @else
        <h3 class="titulo" >EXAMENES MEDICOS </h3>
        @if(isset($document_med_est_seguridad["examenes"]))
                <a href="{{url('recursos_documentos_verificados/'.$document_med_est_seguridad["examenes"]->nombre_archivo)}}" target="_blank">ver archivo</a>
        @else
        No se cargaron archivos de examenes médicos
        @endif
        <br>
         <br>

         <h3 class="titulo">ESTUDIOS DE SEGURIDAD</h3>
            @if(isset($document_med_est_seguridad["estudio"]))
                <a href="{{url('recursos_documentos_verificados/'.$document_med_est_seguridad["estudio"]->nombre_archivo)}}" target="_blank">ver archivo</a>
             @else
                 No se cargaron archivos de examenes médicos
            @endif
        @endif

         @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co" ||route("home")=="http://localhost:8000")
             <h3 class="titulo">INFORME SELECCIÓN</h3>
        <a type="button" style="width: 100%;text-decoration:none;" class="btn btn-sm btn-info" href="{{route("admin.informe_seleccion",["user_id"=>$id])}}" target="_blank">
                                    Ver informe aquí
                                </a>

         @endif

        
    </body>

     <script>
    $(function () {
  
  var now = moment();
  
  $.datepicker.setDefaults($.datepicker.regional["es"]);
  
  $("#datepicker").datepicker({
    dateFormat: 'dd/mm/yy'
  });
  
  $("#datepicker").datepicker('setDate', now.format('DD/MM/YYYY'));
  
});
</script>
</html>
