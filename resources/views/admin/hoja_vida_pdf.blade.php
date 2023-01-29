<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hoja de Vida</title>
    </head>
  
    <style>
        body{
            font-family: Verdana, arial, sans-serif;
            font-size: 15px;
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
        }

        .tabla2 th {
            background-color: #fdf099;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid black;
            padding: 0;
            margin: 0;
            text-align: center;
            /*text-transform: capitalize;*/
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
            padding: 5px 10px;
            text-align: left;
            width: 180px;
            font-size: 14px;
        }

        .tabla2 tr th{
            background-color: #fdf099;
            font-weight: bold;
            padding: 5px 10px;
            text-align: left;
            font-size: 14px;
        }

        .tabla1 tr td{
            padding: 5px 10px;
            font-size: 14px;
            width: 180px;
        }

        .tabla2 tr td{
            padding: 5px 10px;
            font-size: 14px;
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

        td{
         text-transform: capitalize;
        }

    </style>

    <body>
        <table width="100%">
            <tr>
                <td width="30%">
                  @if(route("home") != "https://demo.t3rsc.co" && route("home") != "https://desarrollo.t3rsc.co" && route("home") != "https://listos.t3rsc.co")
                     @if(isset(FuncionesGlobales::sitio()->logo))
                       @if(FuncionesGlobales::sitio()->logo != "")
                         <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo))!!}" width="150">
                       @else
                         <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                       @endif
                     @else
                      <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                     @endif
                    @else
                        @if($logo != "")
                         <img style="max-width: 200px" src="{{url('configuracion_sitio')}}/{!!$logo!!}">
                        @else
                            @if(isset(FuncionesGlobales::sitio()->logo))
                                @if(FuncionesGlobales::sitio()->logo != "")
                                    <img alt="Logo T3RS" class="izquierda" height="auto" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}" width="150">
                                @else
                                    <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                                @endif
                            @endif
                        @endif
                    @endif
                </td>

                <td width="30%" style="text-align: right;">
                    @if($user->foto_perfil != "")
                        <img align="right" alt="user photo" height="109" src="{{ url('recursos_datosbasicos/'.$user->foto_perfil)}}" width="109"/>
                    @elseif($user->avatar != "")
                        <img align="right" alt="user photo" height="109" src="{{ $user->avatar }}" width="109"/>
                    @else
                        <img align="right" alt="user photo" height="109" src="{{ url('img/personaDefectoG.jpg')}}" width="109"/>
                    @endif
                </td>
            </tr>
        </table>
      
        @if(isset($reqcandidato))
            <p>
                <br><br>
                <hr style="background-color: #ffff4a; align-content: center; width: 78%;">
                <h3 style="text-align: center;"> TRAYECTORIA PERSONAL Y LABORAL </h3>
                <br>
                <h4> PUESTO DE APLICACIÓN: {{$reqcandidato->descripcion}} </h4>  
            </p>
        
            <p> <h4> FECHA: {{$reqcandidato->created_at}} </h4>  </p>
        @endif
        
        {{--<p style="text-align: justify;">
            <label style="font-weight: bold;"> INSTRUCCIÓN: </label> <span style="font-size: 10px;"> La información que completará debe ser confiable, estrictamente ajustada a la realidad en todos sus
            datos y situación personal. La trayectoria laboral y formación académica será verificada en las instituciones y con las
            empresas validando fechas, cargos y motivos de salida. Las referencias laborales se aplicarán en el avance final del
            proceso, por lo que deben constar los jefes directos, una muestra de colegas y colaboradores, sus nombres serán
            verificados con las empresas previamente. Agradecemos su profesionalismo y colaboración. </span>
        </p>--}}
        
        <h3 class="titulo"> DATOS PERSONALES </h3>

        <table class="tabla1">
            <tr>
                <th colspan="2">Nombres y apellidos </th>
                <td> {{$datos_basicos->nombres}} {{$datos_basicos->primer_apellido}} {{$datos_basicos->segundo_apellido}} </td>
            </tr>

            <tr>
                <th colspan="2"> Pais y ciudad de nacimiento </th>
                <td> {{(($lugarnacimiento!=null)?ucwords(mb_strtolower($lugarnacimiento->value)):"")}} </td>
            </tr>

            <tr>
                <th colspan="2"> Fecha de nacimiento (DD/MM/AA) - Edad </th>
                <td> {{date('d/m/Y',strtotime($datos_basicos->fecha_nacimiento)).'-'.(!empty($anios))?$anios:''}} </td>
            </tr>

            <tr>
              <th colspan="2"> Ciudad - País de residencia </th>     
              <td>
               @if($datos_basicos->ciudad_residencia != '')
                {{\App\Models\Ciudad::GetCiudad($datos_basicos->pais_residencia, $datos_basicos->departamento_residencia, $datos_basicos->ciudad_residencia)}}
               @endif 
              </td>
            </tr>

            <tr>
                <th colspan="2"> Cédula de identidad </th>
                <td>{{$datos_basicos->numero_id}} </td>
            </tr>

            <tr>
                <th colspan="2"> Estado civil </th>
                <td> {{ucwords(mb_strtolower($datos_basicos->estado_civil_des))}} </td>
            </tr>

            @if($conyuge)
                <tr>
                 <th colspan="2"> Nombre cónyuge / pareja </th>
                 <td>{{$conyuge->nombres_familiar}}</td>
                </tr>
         
                <tr>
                    <th colspan="2"> Ocupación cónyuge / pareja </th>
                    <td>{{$conyuge->ocupacion}}</td>
                </tr>
            @endif

            <tr>
                <th colspan="2"> Nº hijos / Edades </th>
                <td> {{((!empty($datos_basicos->numero_hijos))?$datos_basicos->numero_hijos." /".$datos_basicos->edad_hijos:"")}} </td>
            </tr>

            @if($padres)
                @foreach($padres as $padre)
                  @if($padre->parentesco_id == 3)
                    <tr>
                      <th colspan="2"> Padre (nombre) </th>
                      <td> {{$padre->nombres." ".$padre->primer_apellido." ".$padre->segundo_apellido}} </td>
                    </tr>
                        
                    <tr>
                      <th colspan="2"> Ocupación padre </th>
                      <td>{{ucwords(mb_strtolower($padre->ocupacion))}}</td>
                    /tr>
                    @endif

                    @if($padre->parentesco_id == 4)
                        <tr>
                            <th colspan="2"> Madre (nombre) </th>
                            <td> {{$padre->nombres." ".$padre->primer_apellido." ".$padre->segundo_apellido}} </td>
                        </tr>

                        <tr>
                            <th colspan="2"> Ocupación madre </th>
                            <td> {{ucwords(mb_strtolower($padre->ocupacion))}} </td>
                        </tr>
                    @endif
                @endforeach
            @endif

            <tr>
              <th colspan="2"> Vivienda (propia, alquilada, otro) </th>
              <td> {{ucwords(mb_strtolower($datos_basicos->tipo_vivienda))}} </td>
            </tr>

            <tr>
              <th colspan="2"> Dirección de vivienda </th>
              <td> {{ucwords(mb_strtolower($datos_basicos->direccion))}} </td>
            </tr>

            <tr>
              <th colspan="2"> Vehículo (propio, prendado, Otro) </th>
              <td> {{ucwords(mb_strtolower($datos_basicos->tipo_vehiculo_t))}} </td>
            </tr>

            <tr>
              <th colspan="2"> Teléfono fijo </th>
              <td>{{$datos_basicos->telefono_fijo}}</td>
            </tr>

            <tr>
              <th colspan="2"> Teléfono móvil </th>
              <td>{{$datos_basicos->telefono_movil}}</td>
            </tr>

            <tr>
              <th colspan="2"> Otro teléfono de ubicación (familiar o amigo) </th>
              <td>{{$datos_basicos->otro_telefono}}</td>
            </tr>

            <tr>
              <th colspan="2"> Correo electrónico </th>
              <td>{{$datos_basicos->email}}</td>
            </tr>

            <tr>
              <th colspan="2"> Dirección de skype </th>
              <td>{{$datos_basicos->direccion_skype}}</td>
            </tr>
        </table>

        @if($estudios->count() >= 1)
            <h3 class="titulo"> FORMACIÓN ACADÉMICA </h3>

            <table class="tabla2">
                <thead>
                    <tr>
                        <th> Año </th>
                        <th> Pais/Ciudad </th>
                        <th> Nivel estudio </th>
                        <th> Estatus </th>
                        <th> Título obtenido / a obtener </th>
                        <th> Universidad / instituto: </th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($estudios as $estudio)
                    <tr>
                     <td> {{date('Y',strtotime($estudio->fecha_finalizacion))}} </td>
                     <td> {{ucwords(mb_strtolower($estudio->getCiudad()))}} </td> 
                     <td> {{ucwords(mb_strtolower($estudio->desc_nivel))}} </td>
                     <td> {{ucwords(mb_strtolower($estudio->estatus_academico))}} </td>
                     <td> {{ucwords(mb_strtolower($estudio->titulo_obtenido))}} </td>
                     <td> {{ucwords(mb_strtolower($estudio->institucion))}} </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        @endif

        @if($idiomas->count() >= 1)
            <h3 class="titulo"> Idiomas </h3>
            <table class="tabla1">
              <thead>
               <tr>
                <th style="text-align: center;" colspan="4"> Idioma </th>
                <th style="text-align: center;" colspan="4"> Nivel </th>
                <th style="text-align: center;" colspan="4"> Lugar de formación </th>
               </tr>
              </thead>
                <tbody>
                 @foreach($idiomas as $idioma)
                  <tr>
                   <td style="text-align: center;" colspan="4"> {{ucwords(mb_strtolower($idioma->nombre_idioma->descripcion))}} </td>
                   <td style="text-align: center;" colspan="4">
                    @if($idioma->nivel_idioma) 
                     {{ucwords(mb_strtolower($idioma->nivel_idioma->descripcion))}} 
                    @endif
                   </td>
                   <td style="text-align: center;" colspan="4"> {{ucwords(mb_strtolower($idioma->lugar_formacion))}} </td>
                  </tr>
                 @endforeach
                </tbody>
            </table>
        @endif

        @if (route("home") == "https://gpc.t3rsc.co" || route("home") == "http://localhost:8000")
            @if($experiencias_gpc->count() >= 1)
                <h3 class="titulo"> EXPERIENCIA </h3>

                <table class="tabla1" style="table-layout: fixed;">
                    @foreach($experiencias_gpc as $key => $experiencia)
                        <tr>
                          @if($experiencia->empleo_actual == 1)
                           <td colspan="4" style="background-color: khaki; text-align: center;">EXPERIENCIA ACTUAL O ÚLTIMA EXPERIENCIA</td>
                          @else
                           <td colspan="4" style="background-color: khaki; text-align: center;"> EXPERIENCIA ANTERIOR </td>
                          @endif
                        </tr>

                        <tr>
                          <th> Nombre empresa: </th>
                          <td colspan="3">{{ucwords(mb_strtolower($experiencia->nombre_empresa))}}</td>
                        </tr>
                        
                        <tr>
                          <th> Línea de negocio: </th>
                          <td colspan="3"> {{ucwords(mb_strtolower($experiencia->linea_negocio))}}
                          </td>
                        </tr>

                        <tr>
                          <th> Tipo de compañía (nacional, transnacional, multinacional): </th>
                          <td colspan="3">{{ucwords(mb_strtolower($experiencia->tipo_compania))}}</td>
                        </tr>

                        <tr>
                          <th> Ventas anuales de la empresa: </th>
                          <td colspan="3">{{$experiencia->ventas_empresa}}</td>
                        </tr>
                        
                        <tr>
                          <th> Nº de colaboradores de la empresa: </th>
                          <td colspan="3">{{$experiencia->num_colaboradores}}</td>
                        </tr>
                
                        <tr>
                          <th> Cargo actual / Último cargo: </th>
                          <td colspan="3">{{ucwords(mb_strtolower($experiencia->cargo_especifico))}}</td>
                        </tr>

                        <tr>
                          <th> Mes / Año de ingreso: </th>
                          <td colspan="3">{{$experiencia->fecha_inicio}}</td>
                        </tr>
                        
                        <tr>
                          <th> Mes / Año de salida: </th>
                          @if ($experiencia->empleo_actual == 1)
                           <td colspan="3">Empleo Actual</td>
                          @elseif($experiencia->empleo_actual == 2)
                           <td colspan="3">{{$experiencia->fecha_final}}</td>
                          @else
                           <td colspan="3">{{$experiencia->fecha_final}}</td>
                          @endif
                        </tr>
                
                        <tr>
                         <th> Cargo y nombre del supervisor: </th>
                         <td colspan="3">{{ucwords(mb_strtolower($experiencia->nombres_jefe))}}</td>
                        </tr>

                        <tr>
                         <th> Funciones que realiza (al menos 5 funciones específicas): </th>
                         <td colspan="3" style="word-wrap:break-word;">{{$experiencia->funciones_logros}}</td>
                        </tr>

                        <tr>
                         <th> Logros: </th>
                         <td colspan="3" style="word-wrap:break-word;">{{$experiencia->logros}}</td>
                        </tr>

                        @if ($experiencia->empleo_actual == 1)
                        @elseif($experiencia->empleo_actual == 2)
                            <tr>
                              <th> Motivo de salida de la empresa: </th>
                              <td colspan="3">{{$experiencia->desc_motivo}}</td>
                            </tr>
                        @else
                            <tr>
                             <th> Motivo de salida de la empresa: </th>
                             <td colspan="3">{{$experiencia->desc_motivo}}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            @endif
        @else
            @if($experiencias->count() >= 1)
                <h3 class="titulo"> EXPERIENCIA </h3>

                <table class="tabla1" style="table-layout: fixed;">
                    @foreach($experiencias as $key => $experiencia)
                        <tr>
                          @if($key == 0 || $experiencia->empleo_actual == 1)
                           <td colspan="4" style="background-color: khaki; text-align: center;">EXPERIENCIA ACTUAL O ÚLTIMA EXPERIENCIA</td>
                          @else
                           <td colspan="4" style="background-color: khaki; text-align: center;">EXPERIENCIA ANTERIOR</td>
                          @endif
                        </tr>

                        <tr>
                          <th> Nombre empresa: </th>
                          <td colspan="3"> {{$experiencia->nombre_empresa}} </td>
                        </tr>
                        
                        <tr>
                          <th> Línea de negocio: </th>
                          <td colspan="3"> {{$experiencia->linea_negocio}} </td>
                        </tr>

                        <tr>
                            <th> Tipo de compañía (nacional, transnacional, multinacional): </th>
                            <td colspan="3"> {{$experiencia->tipo_compania}} </td>
                        </tr>

                        <tr>
                            <th> Ventas anuales de la empresa: </th>
                            <td colspan="3">{{$experiencia->ventas_empresa}}</td>
                        </tr>
                        
                        <tr>
                            <th> Nº de colaboradores de la empresa: </th>
                            <td colspan="3">{{$experiencia->num_colaboradores}}</td>
                        </tr>
                
                        <tr>
                            <th> Cargo actual / Último cargo: </th>
                            <td colspan="3">{{$experiencia->desc_cargo}}</td>
                        </tr>

                        <tr>
                            <th> Mes / Año de ingreso: </th>
                            <td colspan="3">{{$experiencia->fecha_inicio}}</td>
                        </tr>
                        
                        <tr>
                            <th> Mes / Año de salida: </th>
                            @if ($experiencia->empleo_actual == 1)
                                <td colspan="3">Empleo Actual</td>
                            @elseif($experiencia->empleo_actual == 2)
                                <td colspan="3">{{$experiencia->fecha_final}}</td>
                            @else
                                <td colspan="3">{{$experiencia->fecha_final}}</td>
                            @endif
                        </tr>
                
                        <tr>
                          <th> Cargo y nombre del supervisor: </th>
                          <td colspan="3">{{ $experiencia->nombres_jefe}}</td>
                        </tr>

                        <tr>
                            <th> Funciones que realiza (al menos 5 funciones específicas): </th>
                            <td colspan="3" style="word-wrap:break-word;">{{$experiencia->funciones_logros}}</td>
                        </tr>

                        <tr>
                            <th> Logros: </th>
                            <td colspan="3" style="word-wrap:break-word;">{{$experiencia->logros}}</td>
                        </tr>

                        <tr>
                            <th> Otros cargos desempeñados en la empresa (especificar tiempos): </th>
                            <td colspan="3"> {{$experiencia->otro_cargo}} @if($experiencia->tiempo_cargo != 'NA') {{$experiencia->tiempo_cargo}} @endif </td>
                        </tr>

                        @if ($experiencia->empleo_actual == 1)
                        @elseif($experiencia->empleo_actual == 2)
                            <tr>
                             <th> Motivo de salida de la empresa: </th>
                             <td colspan="3"> {{$experiencia->desc_motivo}} </td>
                            </tr>
                        @else
                            <tr>
                             <th> Motivo de salida de la empresa: </th>
                             <td colspan="3">{{$experiencia->desc_motivo}}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            @endif
        @endif

        @if(route("home") == "https://gpc.t3rsc.co")
          
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
               <th> Académicos: </th>
               <td> {{$datos_basicos->obj_academicos}} </td>
              </tr>
            </table>

        @endif

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
                  <th> Membresías colegios profesionales, asociaciones, clubes, etc: </th>
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


          <h3 class="titulo"> ASPIRACIÓN SALARIAL Y DE BENEFICIOS </h3>
           <table class="tabla1">
             <tr>
              <th> Sueldo fijo bruto: </th>
              <td> {{$datos_basicos->sueldo_bruto}} </td>
             </tr>
             
                <tr>
                 <th> Ingreso variable mensual (comisiones/bonos): </th>
                 <td> {{$datos_basicos->comision_bonos}} </td>
                </tr>

                <tr>
                 <th> Otros bonos (monto y periodicidad): </th>
                 <td> {{$datos_basicos->otros_bonos }} </td>
                </tr>

                <tr>
                 <th> Total ingreso anual / Total ingreso mensual: </th>
                 <td> {{$datos_basicos->ingreso_anual}} </td>
                </tr>

                <tr>
                 <th> Otros beneficios: </th>
                 <td> {{$datos_basicos->otros_beneficios}} </td>
                </tr>
          </table>

        @endif

        @if(route("home") != "https://gpc.t3rsc.co")
         <h3 class="titulo"> SITUACIÓN SALARIAL Y DE BENEFICIOS </h3>
         
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
              <th> Total ingreso anual: </th>
              <td> {{$autoentrevista->ingreso_anual}} </td>
            </tr>

              <tr>
                <th> Total ingreso mensualizado: </th>
                <td> {{$autoentrevista->ciudades}} </td>
              </tr>

              <tr>
                <th> Utilidades (individual y carga): </th>
                <td> {{$autoentrevista->ciudades}} </td>
              </tr>

              <tr>
               <th> Valor actual fondos de reserva: </th>
               <td> {{$autoentrevista->ciudades}} </td>
              </tr>

              <tr>
                <th> Beneficios no monetarios: </th>
                <td> {{$autoentrevista->ciudades}} </td>
              </tr>
          </table>
        
        @endif

        @if($referencias->count() >0)

          <h3 class="titulo"> REFERENCIAS LABORALES (ÚLTIMAS 3 EMPRESAS) </h3>
            @foreach($referencias as $key => $referencia)
              <table class="tabla2">
                <tr>
                 <th colspan="2">Referencia #{{++$key}}</th>
                </tr>
                <tr>
                  <th> Persona que da referencias: </th>
                  <td>{{$referencia->nombres}} {{$referencia->primer_apellido}}</td>
                </tr>

                <tr>
                  <th>Tipo relación laboral:</th>
                  <td>{{ $referencia->desc_tipo }}</td>
                </tr>
                <tr>
                  <th>Teléfono móvil:</th>
                  <td>{{ $referencia->telefono_movil }}</td>
                </tr>
                <tr>
                  <th>Correo electrónico:</th>
                  <td> {{$referencia->correo}} </td>
                </tr>
                <tr>
                  <th> Cargo de la persona :</th>
                  <td>{{$referencia->cargo}}</td>
                </tr>
              </table>
            <br>
            @endforeach
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
              <th> Carnet conadis: </th>
              <td> {{$datos_basicos->conadis}} </td>
             </tr>

             <tr>
              <th> Tipo y grado de discapacidad: </th>
              <td> {{$datos_basicos->grado_disca}} </td>
             </tr>

            </table>
            
        <br><br>
          <div style="text-align: center; font-weight: bold;"> ¡GPC le agradece por su tiempo y le desea muchos éxitos! </div>
    </body>
</html>
