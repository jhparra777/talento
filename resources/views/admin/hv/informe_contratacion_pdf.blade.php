<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            <title> Informe de Selección - T3RS </title>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    </head>
  
    <style>

        body{
          font-family: Verdana, arial, sans-serif;
          font-size: 15px;
          text-transform: capitalize !important;
        }

        .tabla1, .tabla3{
           border-collapse: collapse;
           width: 100%;
        }

        .tabla2{
         border-collapse: collapse;
         width: 100%;
        }

      
        .tabla1, .tabla1 th, .tabla1 td,.tabla3 th, .tabla3 td {
          border: 1px solid black;
          padding: 0;
          margin: 0;
        }

        .tabla2 td {
          padding: 0;
          margin: 0;
          font-size: 14px;
          border: 1px solid black;
          text-transform: capitalize;
        }

        .tabla2 th {
           background-color: #fdf099;
           font-size: 14px;
           font-weight: bold;
           border: 1px solid black;
           padding: 0;
           margin: 0;
           text-align: center;
           text-transform: capitalize;
        }

        @page { margin: 50px 50px; }

        .page-break {
          page-break-after: always;
        }

        .imagen{
          height: 150px
        }

        .titulo{
          background-color: #333131;
          padding: 10px 0px;
          color: #FFFFFF;
          text-align: center;
          font-size: 16px;
        }

        .tabla1 tr th{
          background-color: #fdf099;
          font-weight: bold;
          padding: 10px 10px;
          text-align: left;
          width: 180px;
          font-size: 14px;
          text-transform: capitalize;
        }

        .tabla2 tr th{
          background-color: #fdf099;
          font-weight: bold;
          padding: 10px 10px;
          text-align: left;
          font-size: 14px;
          text-transform: capitalize;
        }

        .tabla1 tr td{
          padding: 10px 10px;
          font-size: 14px;
          width: 180px;
          text-transform: capitalize;
        }

        .tabla2 tr td{
          padding: 10px 10px;
          font-size: 14px;
          text-transform: capitalize;
        }

        span{
          width: 72% !important;
          padding: 5px 0px 5px 0px;
        }

        span .td {
          border: none !important;
          background: White !important;
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

        .col-center{
           float: none;
           margin-left: auto;
           margin-right: auto;
        }

        .logo_derecha{      
          position: absolute;
          right: 0;
        }

        .titulo-center {
                text-align: center;
        }
           
        .breakAlways{
                page-break-after: always;
        }

    </style>

    <body>
       
        <table class="tabla1" style="margin-left: 4%">
            <tr>
                <td style="width: 40%">
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

            <td>

              <address style="text-align: center;">
                <strong>
                 {{ucwords(mb_strtolower($datos_basicos->nombres))}} {{ucwords(mb_strtolower($datos_basicos->primer_apellido))}} {{ucwords(mb_strtolower($datos_basicos->segundo_apellido))}}
                </strong>
                <br/>

                 @if($user->video_perfil !=null)
                  <br>
                   <a target="_blank" style="text-decoration:none;color:#377cfc;" href='route("view_document_url", encrypt("recursos_videoperfil/|".$user->video_perfil))' >Video Perfil</a>
                   <br>
                 @endif

                 <?php
                  
                  $m = 'Carbon\Carbon';

                  $nacimiento = date('Y-m-d',strtotime($datos_basicos->fecha_nacimiento));
                  $actual = date('Y-m-d'); // para calcular edad a partir de la fecha de nacimiento
                  $anios = $m::parse($actual)->diffInYears($nacimiento); // ña edad
                  ?>
                  {{$anios}} Años.
                  <br/>
                  
                  {{$datos_basicos->telefono_movil}}
                   
                   @if($datos_basicos->telefono_fijo != '')
                    -{{$datos_basicos->telefono_fijo}}
                   @endif
                  <br/>
                   {{$datos_basicos->email}}
                  <br/>
                  
                  @if($txtLugarResidencia != '')
                    
                    {{$txtLugarResidencia}}

                  @endif
                  
                  <br/>

                   @if($datos_basicos->direccion!= '')
                    {{$datos_basicos->direccion}}
                   @endif

                  <br/>
              </address>
            </td>

              <td style="width: 60%">
                @if($user->foto_perfil != "")
                  <img style="max-width: 300px" alt="user photo" src="{{ url('recursos_datosbasicos/'.$user->foto_perfil)}}"/>
                @elseif($user->avatar != "")
                  <img style="max-width: 300px" alt="user photo" src="{{ $user->avatar }}"/>
                @else
                  <img style="max-width: 300px" alt="user photo" src="{{ url('img/personaDefectoG.jpg')}}"/>
                @endif
              </td>

            </tr>
        </table>

      <h3 class="titulo" >DATOS CANDIDATO</h3>

        <table class="tabla2">
          <tr>
           <th> Cédula de identidad </th>
           <td>{{$datos_basicos->numero_id}}</td>
           <th> Ciudad </th>
           <td>{{(($lugarresidencia != null)? $lugarresidencia->value :"")}}</td>                    
          </tr>
          <tr>
           <th>Nombres</th>
           <td>{{$datos_basicos->nombres}}</td>
           <th>Primer Apellido</th>
           <td>{{$datos_basicos->primer_apellido}}</td>

          </tr>
          <tr>
           <th>Fecha Nacimiento</th>
           <td>{{$datos_basicos->fecha_nacimiento}} </td>
           <th>Género</th>
           <td>{{$datos_basicos->genero_desc}}</td>

          </tr>

          <tr>
           <th>Estado Civil</th>
           <td>{{$datos_basicos->estado_civil_des }}</td>
           <th>Teléfono Móvil</th>
           <td>{{$datos_basicos->telefono_movil}}</td>
          </tr>

          <tr>
           <th>Aspiración Salarial</th>
           <td>{{$datos_basicos->aspiracion_salarial_des}}</td>
           <th>Dirección</th>
           <td>{{$datos_basicos->direccion}}</td>
          </tr>

          <tr>
           <th> Tipo Vivienda </th>
           <td>{{$datos_basicos->tipo_vivienda}}</td>
           <th> Tipo Vehiculo </th>
           <td>{{$datos_basicos->tipo_vehiculo_t}}</td>
          </tr>

        </table>
        <br>

        <h3 class="titulo" >EXPERIENCIA </h3>
          @foreach($experiencias as $key => $experiencia)
            <table class="tabla1">
                <tr>
                  @if($key==0)
                    <td colspan="2" style="width: 100% !important;"> EXPERIENCIA ACTUAL O ÚLTIMA EXPERIENCIA </td>
                  @else
                    <td colspan="2" style="width: 100% !important;"> EXPERIENCIA ANTERIOR </td>
                  @endif
                </tr>

                <tr>
                 <th>Nombre Empresa:</th>
                 <td>{{$experiencia->nombre_empresa}}</td>
                </tr>
                <tr>
                 <th>Ciudad:</th>
                 <td>
                  {{$experiencia->ciudades}}
                 </td>
                </tr>
                <tr>
                 <th>Cargo Desempeñado:</th>
                 <td>{{$experiencia->desc_cargo}}</td>
                </tr>
                <tr>
                 <th>Nombres Supervisor:</th>
                 <td>{{$experiencia->nombres_jefe}}</td>
                </tr>
                <tr>
                 <th>Cargo Supervisor:</th>
                 <td>{{$experiencia->cargo_jefe}}</td>
                </tr>
                <tr>
                 <th>Trabajo Actual:</th>
                 <td>{{(($experiencia->empleo_actual == 1)?"Si":"No")}}</td>
                </tr>
                <tr>
                 <th>Fecha Ingreso:</th>
                 <td>{{ $experiencia->fecha_inicio}}</td>
                </tr>
               
                <tr>
                 <th>Fecha Salida:</th>
                 <td>{{ $experiencia->fecha_final}}</td>
                </tr>
                <tr>
                 <th>Motivo Retiro:</th>
                 <td>{{ $experiencia->desc_motivo}}</td>
                </tr>
                <tr>
                 <th>Funciones:</th>
                 <td>{{$experiencia->funciones_logros}}</td>
                </tr>

                <tr>
                 <th>Logros:</th>
                 <td>{{$experiencia->logros}}</td>
                </tr>
            </table>
          @endforeach
            <br>
          @if($estudios->count() >= 1)
            <h3 class="titulo"> FORMACIÓN ACADÉMICA </h3>

            <table class="tabla2">
                <thead>
                    <tr>
                        <th> Año </th>
                        <th> Ciudad/Pais </th>
                        <th> Nivel Estudio </th>
                        <th> Estatus </th>
                        <th> Título Obtenido / A obtener </th>
                        <th> Universidad / Instituto: </th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($estudios as $estudio)
                    <tr>
                     <td> {{date('Y',strtotime($estudio->fecha_finalizacion))}} </td>
                     <td> {{$estudio->ciudades}} </td> 
                     <td> {{$estudio->desc_nivel}} </td>
                     <td> {{$estudio->estatus_academico}} </td>
                     <td> {{$estudio->titulo_obtenido}} </td>
                     <td> {{$estudio->institucion}} </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
            <br>
           @endif

          @if($referencias->count() >= 1)

            <h3 class="titulo"> REFERENCIAS  LABORALES </h3>
            @foreach($referencias as $key => $referencia)
              <table class="tabla2">
                <tr>
                 <th colspan="2">Referencia #{{++$key}}</th>
                </tr>
                <tr>
                  <th> Persona que da Referencias: </th>
                  <td>{{$referencia->nombres}} {{$referencia->primer_apellido}}</td>
                </tr>

                <tr>
                  <th>Tipo Relación Laboral:</th>
                  <td>{{ $referencia->desc_tipo }}</td>
                </tr>
                <tr>
                  <th>Teléfono Móvil:</th>
                  <td>{{ $referencia->telefono_movil }}</td>
                </tr>
                <tr>
                  <th>Correo Electronico:</th>
                  <td>
                   {{$referencia->correo}}
                  </td>
                </tr>
                <tr>
                  <th> Cargo de la Persona :</th>
                  <td>{{$referencia->cargo}}</td>
                </tr>
              </table>
            <br>
            @endforeach
            <br> <br>
          @endif

          @if($familiares->count() >= 1)
            <h3 class="titulo" >Grupo Familiar</h3>
            @foreach($familiares as $key => $familiar)
             <table class="tabla1">
              <tr>
               <th colspan="2">Referencia # {{++$key}} </th>
              </tr> 
              <tr>
               <th> Nombres </th>
               <td>{{ $familiar->nombres}} {{ $familiar->primer_apellido}}</td>
              </tr>
              <tr>
               <th> Parentesco </th>
               <td>{{$familiar->parentesco}}</td>
              </tr>
              <tr>
                <th> Ocupación </th>
                <td>{{ $familiar->profesion }}</td>
              </tr>
            </table>
            @endforeach
           <br>
          @endif

          <h3 class="titulo"> DESCRIPCIÓN DE SUS OBJETIVOS </h3>
          <table class="tabla1">
           <tr>
            <th> Personales: </th>
            <td> {{$datos_basicos->obj_personales}} </td>
           </tr>

              <tr>
               <th> Profesionales: </th>
               <td> {{$datos_basicos->obj_profesionales}} </td>
              </tr>

              <tr>
               <th> Academicos: </th>
               <td> {{$datos_basicos->obj_academicos}} </td>
              </tr>
            </table>
          
          @if(count($autoentrevista)>0)

           <h3 class="titulo"> DESCRIPCIÓN DE SUS INTERESES PERSONALES </h3>
            <table class="tabla1">
              <tr>
                <th> ¿Qué lo motiva para un cambio laboral?: </th>
                <td> {{$autoentrevista->motivo_cambio}} </td>
              </tr>
             
              <tr>
                <th> Áreas de mayor interés en el ámbito laboral: </th>
                <td> {{$autoentrevista->areas_interes}} </td>
              </tr>

                <tr>
                  <th> ¿Qué valora en un ambiente laboral?: </th>
                  <td> {{$autoentrevista->ambiente_laboral}} </td>
                </tr>

                <tr>
                  <th> Actividades de interés en su tiempo libre (hobbies): </th>
                  <td> {{$autoentrevista->hobbies}} </td>
                </tr>
             
                <tr>
                  <th> Membresías Colegios Profesionales, Asociaciones, Clubes, etc: </th>
                  <td> {{$autoentrevista->membresias}} </td>
                </tr>
            </table>

          <h3 class="titulo"> DESCRIPCIÓN DE SU PERFIL PROFESIONAL </h3>
            <table class="tabla1">
                <tr>
                  <th> Años de experiencia en el cargo de aplicación: </th>
                  <td>{{$autoentrevista->tiempo_experiencia}}</td>
                </tr>
             
                <tr>
                 <th> Conocimientos técnicos de mayor dominio: </th>
                 <td> {{$autoentrevista->conoc_tecnico}} </td>
                </tr>

                <tr>
                 <th> Herramientas tecnológicas manejadas: </th>
                 <td> {{$autoentrevista->herr_tecnologicas}} </td>
                </tr>

                <tr>
                 <th> Principales fortalezas que considera tener para el cargo: </th>
                 <td> {{$autoentrevista->fortalezas_cargo}} </td>
                </tr>

                <tr>
                 <th> Áreas a reforzar para un mayor dominio del cargo: </th>
                 <td> {{$autoentrevista->areas_reforzar}} </td>
                </tr>
            </table>

             <h3 class="titulo"> SITUACIÓN SALARIAL Y DE BENEFICIOS ACTUAL </h3>
          <table class="tabla1">
            <tr>
             <th> Sueldo fijo bruto: </th>
             <td> {{$autoentrevista->sueldo_bruto}} </td>
            </tr>
             
                <tr>
                 <th> Ingreso variable mensual (comisiones/bonos): </th>
                 <td> {{$autoentrevista->comision_bonos}} </td>
                </tr>

                <tr>
                 <th> Otros bonos (monto y periodicidad): </th>
                 <td> {{$autoentrevista->otros_bonos }} </td>
                </tr>

                <tr>
                  <th> Total ingreso anual / Total ingreso mensual: </th>
                  <td> {{$autoentrevista->ingreso_anual}} </td>
                </tr>

                <tr>
                  <th> Otros Beneficios: </th>
                  <td> {{$autoentrevista->otros_beneficios}} </td>
                </tr>
            </table>

          @endif
           
           <h3 class="titulo"> DISPONIBILIDAD PARA CONDICIONES DE TRABAJO </h3>
            <table class="tabla1">
             <tr>
              <th> Horarios flexibles: </th>
              <td>{{$datos_basicos->horario_flexible}}</td>
             </tr>

             <tr>
              <th> Viajes regionales: </th>
              <td> {{$datos_basicos->viaje_regional}} </td>
             </tr>
             
             <tr>
              <th> Viajes internacionales: </th>
              <td> {{$datos_basicos->viaje_internacional}} </td>
             </tr>

             <tr>
              <th> Cambio de ciudad: </th>
              <td> {{$datos_basicos->cambio_ciudad}} </td>
             </tr>

             <tr>
              <th> Cambio de país: </th>
              <td> {{$datos_basicos->cambio_pais}} </td>
             </tr>

               <tr>
                 <th> Explique su estado de salud actual o cualquier observación a ser considerada: </th>
                 <td> {{$datos_basicos->estado_salud}} </td>
               </tr>
             
             <tr>
              <th> Carnet Conadis: </th>
              <td> {{$datos_basicos->conadis}} </td>
             </tr>

             <tr>
              <th> Tipo y grado de discapacidad: </th>
              <td> {{$datos_basicos->grado_disca}} </td>
             </tr>

            </table> 


        <div class="breakAlways"></div>

          <h2 class="titulo-center">
           Informe de selección de {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} {{ ucwords(mb_strtolower($datos_basicos->primer_apellido)) }} {{ ucwords(mb_strtolower($datos_basicos->segundo_apellido)) }} referente al cargo {{ ucwords(mb_strtolower($reqcandidato->descripcion)) }} en el requerimiento {{ $reqcandidato->requerimiento_id }} del cliente {{$reqcandidato->cliente_nombre}} </h2>

          @if($entrevistas->count() >= 1)
           <h3 class="titulo"> ENTREVISTAS </h3>
            @foreach($entrevistas as $key => $entrevista)
             <table class="tabla1">
              <tr>
               <th style="width: 100% !important;"> Entrevisa de : </th>
               <td> <strong> {{\App\Models\DatosBasicos::convertirFecha($entrevista->created_at)}} </strong> </td>
              </tr>

              @if($entrevista->aspecto_familiar != "")
                <tr>
                 <th> Aspecto Familiar: </th>
                 <td>{{$entrevista->aspecto_familiar}}</td>
                </tr>
              @endif

             @if($entrevista->aspecto_academico != "")
              <tr>
               <th> Aspecto Academico: </th>
               <td> {{$entrevista->aspecto_academico}}</td>
              </tr>
             @endif

             @if($entrevista->aspectos_experiencia != "")
                <tr>
                 <th> Aspectos Experiencia: </th>
                 <td>{{$entrevista->aspectos_experiencia}}</td>
                </tr>
             @endif

             @if($entrevista->aspectos_personalidad != "")
                <tr>
                 <th> Aspectos de Personalidad :</th>
                 <td>{{$entrevista->aspectos_personalidad}}</td>
                </tr>
             @endif

             @if($entrevista->fortalezas_cargo != "")
                <tr>
                 <th> Fortalezas frente al Cargo :</th>
                 <td>{{$entrevista->fortalezas_cargo}}</td>
                </tr>
             @endif

             @if($entrevista->oportunidad_cargo != "")
               <tr>
                <th> Oportunidades de mejora frente al cargo:</th>
                <td>{{$entrevista->oportunidad_cargo}}</td>
               </tr>
             @endif

              @if($entrevista->concepto_general != "")
                <tr>
                 <th> Concepto General: </th>
                 <td>{{$entrevista->concepto_general}}</td>
                </tr>
              @endif

             @if($entrevista->evaluacion_competencias != "")
              <tr>
               <th> Evaluación de competencias: </th>
               <td>{{$entrevista->evaluacion_competencias}}</td>
              </tr>
             @endif

              <tr>
               <th> Psicologo: </th>
               <td>{{$entrevista->getNamePsicologo()}}</td>
              </tr>
              <tr>
               <th> Fecha de finalización: </th>
               <td>{{ \App\Models\DatosBasicos::convertirFecha($entrevista->updated_at)}}</td>
              </tr>
             </table>
            <br>
            @endforeach
            <br><br>
            <h1>
             __________________
            </h1>
            <!--FIRMAR -->
          @endif

          @if($pruebas->count() >= 1)
           <h3 class="titulo"> EVALUACION PSICOMETRICA </h3>
           @foreach($pruebas as $key => $prueba)
             <table class="tabla2">
                <tr>
                 <th> Prueba Realizada: </th>
                 <td>{{$prueba->prueba_desc}}</td>
                </tr>
                <tr>
                 <th> Estado: </th>
                 <td>
                   @if($prueba->estado == 1)
                     Aprobo
                   @else
                    No aprobo
                   @endif
                 </td>
                </tr>
                <tr>
                 <th> Concepto del analista sobre la prueba: </th>
                 <td>{!!$prueba->resultado!!}</td>
                </tr>
                <tr>
                 <th> Fecha Realización: </th>
                 <td>{{\App\Models\DatosBasicos::convertirFecha($prueba->updated_at)}}
                 </td>
                </tr>
                <tr>
                 <th> Analista quien realizo concepto: </th>
                 <td>{{$prueba->name}}</td>
                </tr>
                <tr>
                 <th> Archivo Adjunto: </th>
                 <td> <a href="{{url('recursos_pruebas/'.$prueba->nombre_archivo)}}" class="enlace">{{ $prueba->nombre_archivo}}</a> </td>
                </tr>
             </table>
            @endforeach
            <br>
          @endif

          @if($examenes_medicos->count() >= 1)
           <h3 class="titulo"> Examenes medicos Realizado </h3>
           @foreach($examenes_medicos as $key => $examen)
             <table class="tabla1">
                <tr>
                 <th> Archivo Adjunto:: </th>
                 <td colspan="3"><a href="{{url('recursos_documentos_verificados/'.$examen->nombre_archivo)}}" class="enlace">{{ $examen->descripcion_archivo}}</a></td>
                </tr>

             </table>
            @endforeach
            <br>
          @endif

          @if($estudio_seguridad->count() >= 1)
           <h3 class="titulo"> Estudio Seguridad </h3>
           @foreach($estudio_seguridad as $key => $seguridad)
             <table class="tabla1">
              <tr>
               <th> Estudio Seguridad: </th>
               <td colspan="3">{{$seguridad->descripcion_archivo}}</td>
              </tr>
              
              <tr>
               <th> Archivo Adjunto: </th>
               <td colspan="3"><a href="{{url('recursos_documentos_verificados/'.$seguridad->nombre_archivo)}}" class="enlace">{{ $seguridad->descripcion_archivo}}</a></td>
              </tr>
                
             </table>
            @endforeach
            <br>
          @endif

          @if($entrevistas_virtuales->count() >= 1)
           <h3 class="titulo"> Entrevista virtual archivo </h3>
           @foreach($entrevistas_virtuales as $key => $entrevista_virtual)
            @if ($entrevista_virtual->respuesta != "")
             <table class="tabla1">
              <tr>
               <th> Pregunta ({{$entrevista_virtual->pregunta}})</th>
              </tr>
              <tr>
               <td>Archivo Adjunto: <a class="enlace" target="_blank" href="{{ asset('recursos_videoRespuesta/'.$entrevista_virtual->respuesta) }}">
                   <span class="fa fa-file" aria-hidden="true"></span> Ver Respuesta </a>
               </td>
              </tr>                
             </table>
            @endif
           @endforeach
            <br>
          @endif

          @if($experiencias_verificadas->count() >= 1)

           <h3 class="titulo"> REFERENCIAS VERIFICADAS </h3>
            @foreach($experiencias_verificadas as $exp)
             <table class="tabla1">
                <tr>
                 <th> Referencia realizada a la experiencia en : </th>
                 <td colspan="3">{{ucwords(mb_strtolower($exp->nombre_empresa))}}</td>
                </tr>

                <tr>
                 <th> Experiencias: </th>
                 <td colspan="3">
                  @if($exp->fecha_retiro > 0)
                   {{ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeñó en el cargo {{mb_strtolower($exp->cargo_especifico)}}, durante {{\App\Models\Experiencias::añosMeses($exp->exp_fecha_inicio, $exp->exp_fechafin)}}, iniciando sus labores el {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_inicio) }} hasta  {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_retiro) }} bajo la supervisión de {{ ucwords(mb_strtolower($exp->nombres_jefe)) }}
                  
                  @if($exp->fijo_jefe > 0)
                    (Tel. {{$exp->fijo_jefe }} / {{ $exp->movil_jefe }})
                  @else
                    (Tel.{{$exp->movil_jefe}})
                  @endif
                   quien ejercía como {{$exp->cargo_jefe}}.
                  @else

                  {{ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeña en el cargo {{ mb_strtolower($exp->cargo_especifico) }}, durante {{ \App\Models\Experiencias::añosMeses($exp->exp_fecha_inicio, $exp->exp_fechafin) }}, 
                  iniciando sus labores el {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_inicio) }} bajo la supervisión de {{ ucwords(mb_strtolower($exp->nombres_jefe)) }}
                  @if($exp->fijo_jefe > 0)
                    (Tel. {{ $exp->fijo_jefe }} / {{ $exp->movil_jefe }})
                  @else
                    (Tel. {{ $exp->movil_jefe }})
                  @endif
                  quien ejercía como {{ $exp->cargo_jefe }}.
                  @endif</td>
                </tr>
                <tr>
                 <th> Realizando el proceso de referenciación se encontró que: </th>
                 <td colspan="3">
                  - La experiencia se referenció con {{ ucwords(mb_strtolower($exp->nombre_referenciante)) }} quien se desempeña como {{ mb_strtolower($exp->cargo_referenciante) }} y de acuerdo con los datos recopilados, <strong>se determina que {{ ucwords(mb_strtolower($datos_basicos->nombres)) }}
                  
                  @if($exp->adecuado)
                    es adecuado.
                  @else
                    no es adecuado.
                  @endif 
                 </strong>
                 </br>
                  - La información suministrada por el referenciante indica que el motivo de retiro obedeció a {{mb_strtolower($exp->name_motivo)}}
                   @if($exp->observaciones)
                     argumentando las siguientes observaciones: {{$exp->observaciones}}.
                   @else
                       .
                   @endif
                 </td>
                </tr>
                <tr>
                 <th> -Cargo desempeñado: </th>
                 <td colspan="3">{{$exp->cargo2}}</td>
                </tr>
                <tr>
                 <th> -Fecha de inicio: </th>
                 <td colspan="3">{{\App\Models\DatosBasicos::convertirFecha($exp->fecha_inicio)}}</td>
                </tr>
                <tr>
                 <th> -Fecha de finalización: </th>
                 <td colspan="3">
                  @if($exp->fecha_retiro > 0)
                   {{\App\Models\DatosBasicos::convertirFecha($exp->fecha_retiro)}}
                  @endif</td>
                </tr>
                <tr>
                 <th> -Anotaciones en la hoja de vida. </th>
                 <td colspan="3"> 
                  @if($exp->anotacion_hv)
                   -La anotación que tiene en la hoja de vida es:
                  @else
                   -No tiene anotaciones en la hoja de vida.
                  @endif

                  @if($exp->cuales_anotacion)
                   {{$exp->cuales_anotacion}}
                  @endif
                 </td>
                </tr>
                <tr>
                 <th> Observaciones Generales de la referenciación </th>
                 <td colspan="3">{{$exp->observaciones_referencias}}</td>
                </tr>

             </table>
            @endforeach
          @endif
            <br>
      <!--  PIE -->
        <footer>
         <div style="position: relative;">
          <img alt="Logo T3RS" class="izquierda" height="25" src="{{url('img/t3.png')}}" width="20"> www.t3rsc.co
          <img class="logo_derecha" alt="Logo T3RS"  height="40" src="{{ url('configuracion_sitio'."/$logo")}}"width="110" alt="logo_empresa">
         </div>
        </footer>
    </body>

</html>