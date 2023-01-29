<!DOCTYPE html>
<html>
    <head>
        @if(triRoute::validateOR('local'))
            <?php set_time_limit(420); ?>
        @endif
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        
        <title> Informe de Selección - T3RS </title>
        
        <style type="text/css">
            @page { margin: 50px 70px; }

           @if(route('home') != "https://pta.t3rsc.co")
            .page-break {
                page-break-after: always;
            }
           @endif

            table {
                border-collapse: collapse;
                width: 100%;
                padding: 0;
                margin: 0;
            }

            .table1 {
                border-collapse: collapse;
                width: 100%;
                padding: 0;
                margin: 0;
            }

            .table1, th, td {
                border: 1px solid #cacaca;
                padding: 5px;
            }

            #g-tr{
                margin-bottom: 90px;
                padding-bottom: 90px;
            }

            .table th, .table td, .table tr {
                border: none;
            }

            body {
                font-family: 'Bank Gothic', Bank, serif;
                font-size: 16px;
                background-color: #FFFFFF;
            }

            hr.style2 {
                border: 0;
                height: 1px;
                background: #377cfc;
                background-image: -webkit-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                background-image: -moz-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                background-image: -ms-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                background-image: -o-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                width: 50%;
                color: #377cfc;

            }

            hr.style3 {
                border-top: 3px double;
                color: #377cfc;
                width: 50%;
            }

            h2,.blue {
                color: #377cfc;
            }

            .colum1 tr td:nth-child(1),.colum1 tr th{
                background-color: #fafafa;
                font-weight: bold;
            }

            .titulo-center {
                text-align: center;
            }

            footer{
                position: fixed;
                bottom: 0;
            }

            /* Justificar parrafo */
            p{
                text-align: justify;
            }

            /* Pruebas */
            td{
                border: solid 0px;
            }
            
            .subtitulo {
                padding-left: 50px;
            }

            .parrafo{
                padding-left: 65px
            }

            .logo_derecha{
              
              position: absolute;
              right: 0;
            }

            .colorText{
                text-decoration: none; color: #377cfc;
            }

            .imgRadius{
                border-radius: 350%;
            }

            .textCenter{
                text-align: center;
            }

            .textLeft{
                text-align: left;
            }

            .text-justify {
                text-align: justify;
            }

            .circle {
                position: relative;
                background-color: #6F3795;
                margin: 10px auto;
            }

            .c-1 {
                width: 50px;
                height: 50px;
                border-radius: 25px 25px 25px 25px;
            }

            .c-2 {
                width: 86px;
                height: 86px;
                border-radius: 43px 43px 43px 43px;
            }

            .text-circle-1 {
                padding-left: 5px;
                padding-top: 12px;
                color: #fff;
                font-size: 15pt;
                font-weight: 700;
            }

            .text-circle-2 {
                padding-left: 5px;
                padding-top: 18px;
                color: #fff;
                font-size: 30pt;
                font-weight: 700;
            }

            .table-result{
                background-color: #f1f1f1;
                border-radius: 5px;
                padding: 0.5rem;
                font-family: 'Roboto', sans-serif;
                box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2), 0 4px 8px 0 rgba(0, 0, 0, 0.19);
            }

            .mt-0{ margin-top: 0; }
            .mt-1{ margin-top: 1rem; }
            .mt-2{ margin-top: 2rem; }
            .mt-3{ margin-top: 3rem; }
            .mt-4{ margin-top: 4rem; }

            .mb-0{ margin-bottom: 0; }
            .mb-1{ margin-bottom: 1rem; }
            .mb-2{ margin-bottom: 2rem; }
            .mb-3{ margin-bottom: 3rem; }
            .mb-4{ margin-bottom: 4rem; }

            .font-size-10{ font-size: 10pt; }
            .font-size-11{ font-size: 11pt; }
            .font-size-12{ font-size: 12pt; }
            .font-size-14{ font-size: 14pt; }

            .bg-blue{ background-color: #2E2D66; color: white; }
            .bg-dark-blue{ background-color: #2c3e50; color: white; }
            .bg-red{ background-color: #D92428; color: white; }
            .bg-yellow{ background-color: #E4E42A; color: white; }
            .bg-green{ background-color: #00A954; color: white; }

            .color-blue{ color: #2E2D66; }
            .color-red{ color: #D92428; }
            .color-yellow{ color: #E4E42A; }
            .color-green{ color: #00A954; }

            .bg-blue-a{ background-color: #0288d1; color: white; }
            .bg-red-a{ background-color: #f44336; color: white; }
            .bg-yellow-a{ background-color: #fdd835; color: white; }
            .bg-green-a{ background-color: #7cb342; color: white; }

            .pd-05{ padding: 0.5rem; }

            .br-05{ border-radius: 5px 5px 5px 5px; }

            .fw-600{ font-weight: 600; }
            .fw-700{ font-weight: 700; }

           @if(route('home') != "https://pta.t3rsc.co")
           
            .breakAlways{
                page-break-after: always;
            }
           @endif
        </style>

    </head>
    <body>
        
      @if(route('home') !="https://soluciones.t3rsc.co" && route('home') !="http://soluciones.t3rsc.co")
        <!-- Validar si el usuario es rol ADMIn para poder ver si el candidato tiene problemas de seguridad -->
        @if(Sentinel::check()->inRole("admin"))
            <!-- Validamos si el candidato esta con estado 5 que hace referencia a problemas de seguridad -->
            @if($datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD'))
             <div class="classname">
             !!
             </div>
            @endif
        @endif
        
      @endif

        <table class="table" width="100%">
            <!-- FL-1 -->
         <tr id="g-tr">
           <!-- Col-3 -->
          <td colspan="3" width="30%">      
          
                  @if(!is_null($reqcandidato->logo_empresa) && $reqcandidato->logo_empresa != "")
                      <img style="max-width: 200px" src='{{ asset("configuracion_sitio/$reqcandidato->logo_empresa")}}'>
                  @elseif($logo!="")
                      <img style="max-width: 200px" src="{{ url('configuracion_sitio/'.$logo)}}">
                  @else
                      <img style="max-width: 200px" src="{{url('img/logo.png')}}">
                  @endif
                
            </td> {{-- http://poderhumano.t3rsc.co --}}

                <!-- Col-6 -->
                <td colspan="6" width="40%">
                 <address class="textCenter">
                   <strong>
                    {{ucwords(mb_strtolower($datos_basicos->nombres)) }} {{ ucwords(mb_strtolower($datos_basicos->primer_apellido)) }} {{ucwords(mb_strtolower($datos_basicos->segundo_apellido)) }}

                     @if($user->video_perfil !=null)
                      <br>
                       {{--<a style="text-decoration:none;color:#377cfc;"  href="{{asset("recursos_videoperfil/"."$user->video_perfil?".date('His'))}}" target="_blank">Video Perfil</a>--}}
                       <a class="colorText"  href="{{route('ver_videoperfil',$user->id)}}" target="_blank">Video Perfil</a>
                     @endif


                    {{--@if(!empty($archivo))
                     <br>
                      <a  target="_blank" class="colorText"  href="{{asset('recursos_documentos/'.$archivo->nombre_archivo)}}" >Hoja de Vida</a>
                    @endif--}}

                            @if($hv!=null)
                                <br>
                                <a  target="_blank" class="colorText"  href="{{asset('archivo_hv/'.$hv->archivo)}}" >Hoja de Vida</a>
                            @endif

                        </strong>

                        <br/>

                        {{$edad}} Años

                        <br/>

                        @if($datos_basicos->datos_contacto == 1)
                         <div id="datos_contacto" >
                          {{$datos_basicos->telefono_movil}}
                           @if($datos_basicos->telefono_fijo != '')
                            - {{ $datos_basicos->telefono_fijo}}
                           @endif

                           <br/>
                         </div>
                      
                          {{$datos_basicos->email}}
                        @endif
                        <br/>

                        @if ($datos_basicos->ciudad_residencia != '')
                          {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_residencia, $datos_basicos->departamento_residencia, $datos_basicos->ciudad_residencia) }}
                        @endif
                        
                        <br/>

                    </address>
                </td>

                <!-- Col-3 -->
                <td colspan="3" width="30%">
                 @if($user->foto_perfil != "")
                  <img align="right" class="imgRadius" alt="user photo" height="109" src="{{ url('recursos_datosbasicos/'.$user->foto_perfil)}}" width="109"/>
                 @elseif($user->avatar != "")
                  <img align="right" class="imgRadius" alt="user photo" height="109" src="{{ $user->avatar }}" width="109"/>
                 @else
                  <img align="right" class="imgRadius" alt="user photo" height="109" src="{{ url('img/personaDefectoG.jpg')}}" width="109"/>
                 @endif
                </td>
            </tr>
        </table>

        @if(route('home') !="http://poderhumano.t3rsc.co")
            <!-- FL-2 -->
            @if($datos_basicos->descrip_profesional != '')
              <table class="table" width="100%">
                <tr>
                 <td colspan="12">
                  <h2> Perfil </h2>
                            
                    <hr align="left" class="style2">

                            <table class="table" width="100%">
                                <tr>
                                    <td colspan="2" width="5%">
                                    </td>
                                    <td colspan="10" width="95%">
                                        <p>
                                            {{$datos_basicos->descrip_profesional }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            @endif

            <!-- FL-3 -->
            <table class="table" width="100%">
                <tr>
                    <td colspan="12">
                        <h2>
                            Información Personal
                        </h2>
                        <hr align="left" class="style2">
                        <table class="table" width="100%">
                            <tr>
                                <td colspan="2" width="5%">
                                    <!-- Para ajustar  el de abajo -->
                                </td>
                                
                                <td colspan="10" width="95%">
                                 <p>
                                  {{ucwords(mb_strtolower($datos_basicos->nombres)) }} se identifica con la {{ mb_strtolower($datos_basicos->dec_tipo_doc) }} número {{ number_format($datos_basicos->numero_id) }} @if($datos_basicos->ciudad_expedicion_id) de la ciudad de  {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_id, $datos_basicos->departamento_expedicion_id, $datos_basicos->ciudad_expedicion_id) }}, @endif @if($datos_basicos->genero_desc) cuyo género es {{ mb_strtolower($datos_basicos->genero_desc) }}, @endif @if($datos_basicos->estado_civil_des) su estado civil es {{ mb_strtolower($datos_basicos->estado_civil_des)}} @endif y tiene una aspiración salarial de {{($datos_basicos->aspiracion_salarial_des)? strtolower($datos_basicos->aspiracion_salarial_des):$datos_basicos->aspiracion_salarial}}. @if($datos_basicos->ciudad_residencia) Reside actualmente en la ciudad de {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_residencia, $datos_basicos->departamento_residencia, $datos_basicos->ciudad_residencia) }},@endif  @if($datos_basicos->direccion) en la dirección {{ mb_strtolower($datos_basicos->direccion)}} @endif.

                                  </p>
                                
                                   <p>
                                    @if($datos_basicos->maximoEstudio())
                                      @if($datos_basicos->maximoEstudio()->estudio_actual)
                                       El nivel máximo de estudios registrado es {{ mb_strtolower($datos_basicos->maximoEstudio()->descripcion) }} en {{ ucwords(mb_strtolower($datos_basicos->maximoEstudio()->institucion)) }} en la ciudad de {{ \App\Models\Ciudad::GetCiudad($datos_basicos->maximoEstudio()->pais_estudio, $datos_basicos->maximoEstudio()->departamento_estudio, $datos_basicos->maximoEstudio()->ciudad_estudio)}}
                                      @else
                                       
                                       El nivel máximo de estudios registrado es {{ mb_strtolower($datos_basicos->maximoEstudio()->descripcion) }} y el título obtenido es {{mb_strtolower($datos_basicos->maximoEstudio()->titulo_obtenido)}} en {{ ucwords(mb_strtolower($datos_basicos->maximoEstudio()->institucion)) }}, el cual finalizó el {{ \App\Models\DatosBasicos::convertirFecha($datos_basicos->maximoEstudio()->fecha_finalizacion) }} en la ciudad de {{ \App\Models\Ciudad::GetCiudad($datos_basicos->maximoEstudio()->pais_estudio, $datos_basicos->maximoEstudio()->departamento_estudio, $datos_basicos->maximoEstudio()->ciudad_estudio)}}
                                            @endif
                                        @endif
                                    </p>

                                    <p> 
                                     
                                     @if($experienciaMayorDuracion)
                                       
                                       @if($experienciaMayorDuracion->empleo_actual == 1)

                                         Su experiencia más extensa fue en la empresa {{ucwords(mb_strtolower($experienciaMayorDuracion->nombre_empresa))}}, donde se desempeña como {{mb_strtolower($experienciaMayorDuracion->cargo_especifico)}}. Su experiencia laboral más reciente es en {{ucwords(mb_strtolower($experienciaActual->nombre_empresa))}}, desempeñándose como {{ mb_strtolower($experienciaActual->cargo_especifico) }} devengando de  {{($experienciaActual->salario)? mb_strtolower($experienciaActual->salario):$experienciaActual->salario_devengado}}.
                                                Actualmente se encuentra laborando.
                                       @else
                                      
                                         Su experiencia más extensa fue en la empresa {{ucwords(mb_strtolower($experienciaMayorDuracion->nombre_empresa))}}, donde se desempeñó como {{ mb_strtolower($experienciaMayorDuracion->cargo_especifico)}} por un periodo de {{ \App\Models\Experiencias::añosMeses($experienciaMayorDuracion->fecha_inicio, $experienciaMayorDuracion->fecha_final)}}. Su experiencia laboral más reciente fue en {{ ucwords(mb_strtolower($experienciaActual->nombre_empresa)) }}, desempeñándose como {{ mb_strtolower($experienciaActual->cargo_especifico) }} devengando de {{(!is_null($experienciaActual->salario))? mb_strtolower($experienciaActual->salario):$experienciaActual->salario_devengado}}.

                                       @endif

                                     @endif
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            @if(route("home")=="https://desarrollo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" || route("home")=="https://vym.t3rsc.co" || route("home")=="https://listos.t3rsc.co" || route("home")=="https://pruebaslistos.t3rsc.co" || route("home")=="http://localhost:8000")
             
                <h2>Detalle Dotacion</h2>

                <hr align="left" class="style2">
            
                  <span class="subtitulo">
                    <strong>Talla Camisa: </strong>

                     {{($datos_basicos->talla_camisa)?$datos_basicos->talla_camisa:'No Cargo Datos.'}}</span>
                     <br>
                  <span class="subtitulo">
                    <strong>Talla Pantalon: </strong>

                     {{($datos_basicos->talla_pantalon)?$datos_basicos->talla_pantalon:'No Cargo Datos.'}}</span>
                    <br>
                  <span class="subtitulo">
                    <strong>Talla Zapatos: </strong>

                     {{($datos_basicos->talla_zapatos)?$datos_basicos->talla_zapatos:'No Cargo Datos.'}}</span>
     
            @endif

            <!-- ESTUDIOS -->
            @if($estudios->count() >= 1)
             <div class="breakAlways"></div>
              <h2> Estudios </h2>

               <hr align="left" class="style2">

                @foreach($estudios as $estudio)
                  <p class="subtitulo">
                   <strong>
                    {{ucwords(mb_strtolower($estudio->desc_nivel))}}
                   </strong>
                  </p>

                   <p class="parrafo">
                        @if ($estudio->estudio_actual)
                            {{ ucwords(mb_strtolower($datos_basicos->nombres))}} está realizando el {{ mb_strtolower($estudio->desc_nivel) }} en {{ ucwords(mb_strtolower($estudio->institucion)) }} de la ciudad de {{ \App\Models\Ciudad::GetCiudad($estudio->pais_estudio , $estudio->departamento_estudio, $estudio->ciudad_estudio) }}, cursando {{ $estudio->semestres_cursados }} periodos hasta el momento,  el título por obtener es {{ ucwords(mb_strtolower($estudio->titulo_obtenido)) }}.
                        @else
                            {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} realizó sus estudios de {{ mb_strtolower($estudio->desc_nivel) }} en {{ ucwords(mb_strtolower($estudio->institucion)) }} de la ciudad de {{ \App\Models\Ciudad::GetCiudad($estudio->pais_estudio, $estudio->departamento_estudio, $estudio->ciudad_estudio) }} , cursando {{ $estudio->semestres_cursados }} periodos, finalizando sus estudios el {{ $estudio->getFechaFinalizo() }} obteniendo el título de {{ ucwords(mb_strtolower($estudio->titulo_obtenido)) }}.
                        @endif
                    </p>
                @endforeach
            @endif

            <!-- EXPERIENCIAS -->
            @if($experiencias->count() >= 1)
                <h2>
                    Experiencias
                </h2>

                <hr align="left" class="style2">
                
                @foreach($experiencias as $key => $experiencia)
                  <p class="subtitulo">
                   <strong>
                    {{ucwords(mb_strtolower($experiencia->cargo_especifico)) }} de {{ ucwords(mb_strtolower($experiencia->nombre_empresa))}}
                   </strong>
                  </p>
                    
                    <p class="parrafo">
                        @if($experiencia->empleo_actual == 1)
                          
                          {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeña actualmente como {{ ucwords(mb_strtolower($experiencia->cargo_especifico)) }} en la empresa {{ ucwords(mb_strtolower($experiencia->nombre_empresa)) }}, iniciando actividades el {{ $experiencia->getFechaInicia() }} en la ciudad de {{ \App\Models\Ciudad::GetCiudad($experiencia->pais_id, $experiencia->departamento_id, $experiencia->ciudad_id) }} El salario percibido es de {{(!is_null($experiencia->salario))?mb_strtolower($experiencia->salario):$experiencia->salario_devengado}}, su jefe inmediato {{ ucwords(mb_strtolower($experiencia->nombres_jefe)) }} se desempeña como {{ ucwords(mb_strtolower($experiencia->cargo_jefe)) }} y  su número de contácto es {{ $experiencia->movil_jefe }}.
                        @else
                          
                          {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeñó como {{ ucwords(mb_strtolower($experiencia->cargo_especifico)) }} en la empresa {{ ucwords(mb_strtolower($experiencia->nombre_empresa)) }}, iniciando actividades el {{ $experiencia->getFechaInicia() }} y finalizando el {{ $experiencia->getFechaFinal() }}, @if($experiencia->desc_motivo) retiro motivo de {{ mb_strtolower($experiencia->desc_motivo)}} @endif en la ciudad de {{ \App\Models\Ciudad::GetCiudad($experiencia->pais_id, $experiencia->departamento_id, $experiencia->ciudad_id)}} @if(!is_null($experiencia->salario)) El salario percibido fue de {{(!is_null($experiencia->salario))?mb_strtolower($experiencia->salario):$experiencia->salario_devengado}}, @endif su jefe inmediato {{ ucwords(mb_strtolower($experiencia->nombres_jefe)) }} se desempeñó como {{ucwords(mb_strtolower($experiencia->cargo_jefe))}} @if($experiencia->movil_jefe) y  su número de contácto es {{ $experiencia->movil_jefe }} @endif.

                        @endif
                    </p>

                    <p class="parrafo">
                     @if($experiencia->funciones_logros)
                      Sus principales funciones fueron {{$experiencia->funciones_logros}}.
                     @endif
                    </p>

                @endforeach

            @endif

            <!-- FAMILIARES -->
            @if($familiares->count() >= 1)
              
              <h2> Grupo Familiar </h2>
              <hr align="left" class="style2">
                <p class="subtitulo">
                 El grupo familiar de {{ucwords(mb_strtolower($datos_basicos->nombres))}} está compuesto por:
                </p>

                @foreach($familiares as $key => $familiar)
                   <p class="subtitulo">
                    <strong> {{ucwords(mb_strtolower($familiar->parentesco))}} </strong>
                   </p>

                    <p class="parrafo">
                     {{ ucwords(mb_strtolower($familiar->nombres)) }}, @if($familiar->getEdad()) actualmente tiene {{ $familiar->getEdad() }} años,  @endif @if($familiar->escolaridad) el nivel de escolaridad es {{mb_strtolower($familiar->escolaridad)}}, @endif @if($familiar->profesion) su profesión es {{ucwords(mb_strtolower($familiar->profesion))}} @endif @if($familiar->codigo_ciudad_nacimiento) y nació en {{\App\Models\Ciudad::GetCiudad($familiar->codigo_pais_nacimiento, $familiar->codigo_departamento_nacimiento, $familiar->codigo_ciudad_nacimiento)}} @endif.
                    </p>

                @endforeach
            @endif

            @if(route("home")=="https://asuservicio.t3rsc.co")
              @if($documentos_candidato->count() >= 1)
               
               <h2>Documentos anexos</h2>

                <hr align="left" class="style2">

                @foreach($documentos_candidato as $key => $documento)
                    <a target="_blank" style="text-decoration:none;color:#377cfc;" href="{{asset("recursos_documentos/"."$documento->nombre_archivo")}}">{{$documento->descripcion_archivo}}</a>
                    <br>
                @endforeach
              @endif
            @endif
       
            @if($reqcandidato != null)
                <br><br><br>

                <div class="breakAlways"></div>

                <h2 class="titulo-center">
                 Informe de selección de {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} {{ ucwords(mb_strtolower($datos_basicos->primer_apellido)) }} {{ ucwords(mb_strtolower($datos_basicos->segundo_apellido)) }} referente al cargo {{ ucwords(mb_strtolower($reqcandidato->descripcion)) }} en el requerimiento {{ $reqcandidato->requerimiento_id }} del cliente {{$reqcandidato->cliente_nombre}}
                </h2>
            @endif
          
            <!-- Entrevista semi -->
            @if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co" ||
                route('home') == "https://soluciones.t3rsc.co" || route('home') == "http://soluciones.t3rsc.co" ||
                route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co" ||
                route('home') == "https://demo.t3rsc.co" || route('home') == "http://demo.t3rsc.co" ||
                route('home') == "http://localhost:8000")

                <br><br>
                
                @if($entrevistas_semi->count() > 0)
                    @foreach($entrevistas_semi as $key => $entrevista)
                        
                        <h3 class="textCenter">Entrevista Semiestructurada</h3>

                        @if(route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co" ||
                        route('home') == "https://demo.t3rsc.co" || route('home') == "http://demo.t3rsc.co" || 
                        route('home') == "http://localhost:8000")

                            <h3 class="textCenter">I. Datos</h3>

                            <table>
                                <tr>
                                    <th class="textCenter">Fecha Diligenciamiento</th>
                                    <th class="textCenter">Realizó Entrevista</th>
                                    <th class="textCenter">Cargo</th>
                                    <th class="textCenter">Empresa Usuaria</th>
                                </tr>

                                <tr>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $entrevista->fecha_diligenciamiento }}</td>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $entrevista->getNamePsicologo() }}</td>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $reqcandidato->cliente_nombre}}</td>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $reqcandidato->descripcion }}</td>
                                </tr>
                            </table>

                            <h3 class="textCenter">II. Datos generales del candidato</h3>

                            <table>
                                <tr>
                                    <th class="textCenter">Nombre</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">
                                        {{ $datos_basicos->nombres }} {{ $datos_basicos->primer_apellido }} {{ $datos_basicos->segundo_apellido }}
                                    </td>
                                    <th class="textCenter">Documento Identidad</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $datos_basicos->numero_id }}</td>
                                </tr>

                                <tr>
                                    <th class="textCenter">Edad</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $edad }}</td>
                                    <th class="textCenter">Fecha Nacimiento</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $datos_basicos->fecha_nacimiento }}</td>
                                </tr>

                                <tr>
                                    <th class="textCenter">Ciudad Nacimiento</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $txtLugarNacimiento }}</td>
                                    <th class="textCenter">Ciudad Residencia</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $txtLugarResidencia }}</td>
                                </tr>

                                <tr>
                                    <th class="textCenter">Dirección</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $datos_basicos->direccion }}</td>
                                    <th class="textCenter">Localidad</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $datos_basicos->localidad }}</td>
                                </tr>

                                <tr>
                                    <th class="textCenter">Barrio</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $datos_basicos->barrio }}</td>
                                    <th class="textCenter">Celular</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $datos_basicos->telefono_movil }}</td>
                                </tr>

                                <tr>
                                    <th class="textCenter">Teléfono</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $datos_basicos->telefono_fijo }}</td>
                                    <th class="textCenter">Correo</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $datos_basicos->email }}</td>
                                </tr>
                            </table>

                            <h3 class="textCenter">III. Información familiar</h3>

                            <table>
                                <tr>
                                    {{-- <th class="textCenter" >Documento</th> --}}
                                    <th class="textCenter" >Nombre Familiar</th>
                                    <th class="textCenter" >Teléfono</th>
                                    <th class="textCenter" >Convive</th>
                                </tr>

                                @foreach($familiares as $key => $familiar)
                                    <tr>
                                        {{-- <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $familiar->documento_identidad }}</td> --}}
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">
                                            {{ $familiar->nombres }} {{ $familiar->primer_apellido }} {{ $familiar->segundo_apellido }}
                                        </td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $familiar->celular_contacto }}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">
                                            @if($familiar->convive == 1)
                                                Si
                                            @elseif($familiar->convive == 0)
                                                No
                                            @elseif($familiar->convive == null)
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                            @if ($entrevista->observacion_familiar != '')
                                <table>
                                    <tr>
                                        <th class="textCenter">Observaciones del entrevistador (grupo familiar)</th>
                                    </tr>
                                    <tr>
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->observacion_familiar }}</td>
                                    </tr>
                                </table>
                            @endif

                            <h3 class="textCenter">IV. Información de educación e información adicional</h3>

                            <table>
                                <tr>
                                    <th class="textCenter">Último nivel acádemico</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">
                                        @if(isset($estudioReciente->desc_nivel))
                                            {{ $estudioReciente->desc_nivel }}
                                        @endif
                                    </td>
                                    <th class="textCenter">Titulo obtenido</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">
                                        @if(isset($estudioReciente->titulo_obtenido))
                                            {{ $estudioReciente->titulo_obtenido }}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th class="textCenter">Fecha finalización</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">
                                        @if(isset($estudioReciente->fecha_finalizacion))
                                            {{ $estudioReciente->fecha_finalizacion }}
                                        @endif
                                    </td>
                                       
                                </tr>

                                <tr>
                                    <th class="textCenter">Estado civil</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">
                                        {{ App\Models\EstadoCivil::getEstado($datos_basicos->estado_civil) }}
                                    </td>
                                    <th class="textCenter">No. Hijos</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $datos_basicos->numero_hijos }}</td>
                                </tr>

                               @if($entrevista->observacion_hijos != '')
                                 <tr>
                                  <td></td>
                                  <td></td>
                                        <th class="textCenter">Observación Hijos</th>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $entrevista->observacion_hijos }}</td>
                                    </tr>
                               @endif

                               @if($datos_basicos->numero_libreta != '')
                                 <tr>
                                        <th class="textCenter">Número libreta</th>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">
                                            {{ $datos_basicos->numero_libreta }}
                                        </td>
                                        <th class="textCenter">Clase libreta</th>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">
                                            {{ App\Models\ClaseLibreta::getTipo($datos_basicos->clase_libreta) }}
                                        </td>
                                    </tr>
                                @endif

                                @if($entrevista->observacion_libreta != '')
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <th class="textCenter">Observación Situación Militar</th>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $entrevista->observacion_libreta }}</td>
                                    </tr>
                                @endif

                                @if ($datos_basicos->tiene_vehiculo == 1)
                                    <tr>
                                        <th class="textCenter">Tipo de vehículo</th>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">
                                            {{ App\Models\TipoVehiculo::getVehiculo($datos_basicos->tipo_vehiculo) }}
                                        </td>
                                        @if ($datos_basicos->numero_licencia != '')
                                            <th class="textCenter">Número licencia</th>
                                            <td class="textCenter" style="border: solid #e4e4e4 1px">
                                                {{ $datos_basicos->numero_licencia }}
                                            </td>
                                        @endif
                                    </tr>
                                @endif

                                <tr>
                                    @if ($datos_basicos->numero_licencia != '')
                                        <th class="textCenter">Categoría licencia</th>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">
                                            {{ App\Models\CategoriaLicencias::getCategoria($datos_basicos->categoria_licencia) }}
                                        </td>
                                    @endif
                                    <th class="textCenter">Talla camisa</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">
                                        {{ $datos_basicos->talla_camisa }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="textCenter">Talla pantalón</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">
                                        {{ $datos_basicos->talla_pantalon }}
                                    </td>
                                    <th class="textCenter">Talla zapatos</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $datos_basicos->talla_zapatos }}</td>
                                </tr>

                                <tr>
                                    <th class="textCenter">Entidad promotora de salud (EPS)</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">
                                        {{ App\Models\EntidadesEps::getNameEps($datos_basicos->entidad_eps) }}
                                    </td>
                                    <th class="textCenter">Fondo de pensión AFP</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">
                                        {{ App\Models\EntidadesAfp::getNameAfp($datos_basicos->entidad_afp) }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="textCenter">Aspiración salarial del candidato</th>
                                    <td class="textCenter" style="border: solid #e4e4e4 1px">
                                        {{ App\Models\AspiracionSalarial::getAspiracion($datos_basicos->aspiracion_salarial) }}
                                    </td>
                                </tr>
                            </table>

                            @if ($entrevista->observacion_estudios != '')
                                <table>
                                    <tr>
                                        <th class="textCenter">Observaciones del entrevistador (estudios)</th>
                                    </tr>
                                    <tr>
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->observacion_estudios }}</td>
                                    </tr>
                                </table>
                            @endif

                            <h3 class="textCenter">V. Experiencia laboral</h3>

                            <table>
                                @foreach($experiencias as $key => $experiencia)
                                    <tr>
                                        <th class="textCenter" >Empresa</th>
                                        <th class="textCenter" >Teléfono empresa</th>
                                        <th class="textCenter" >Nombre jefe</th>
                                        <th class="textCenter" >Teléfono móvil</th>
                                        <th class="textCenter" >Cargo</th>
                                        <th class="textCenter" >Fecha ingreso</th>
                                        <th class="textCenter" >Fecha salida</th>
                                    </tr>
                                    
                                    <tr>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $experiencia->nombre_empresa }}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $experiencia->telefono_temporal }}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $experiencia->nombres_jefe }}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $experiencia->movil_jefe }}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $experiencia->cargo_especifico }}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $experiencia->fecha_inicio }}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $experiencia->fecha_final }}</td>
                                    </tr>

                                    <tr>
                                        <th colspan="2">Salario</th>
                                        <th>M. Retiro</th>
                                        <th colspan="4">F. Principales</th>
                                    </tr>
                                    
                                    <tr>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px" colspan="2">{{ $experiencia->salario_cand }}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $experiencia->motivo_retiro_cand }}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px" colspan="4">
                                            @if ($experiencia->funciones_logros != '')
                                                {{ $experiencia->funciones_logros }}
                                            @else
                                                <i>El candidato no ingreso datos.</i>
                                            @endif
                                        </td>
                                    </tr>

                                    @if ($experiencia->observacion_experiencia != '')
                                        <tr>
                                            <th colspan="10" class="textCenter">Observaciones</th>
                                        </tr>
                                        <tr>
                                            <td style="border: solid #e4e4e4 1px" colspan="10" rowspan="" headers="">{{ $experiencia->observacion_experiencia }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>

                            @if ($entrevista->observacion_experiencia != '')
                                <table style="margin-top: 1.2rem;">
                                    <tr>
                                        <th class="textCenter">Observaciones del entrevistador (experiencias)</th>
                                    </tr>
                                    <tr>
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->observacion_experiencia }}</td>
                                    </tr>
                                </table>
                            @endif

                            <h3 class="textCenter">VI. Preguntas de validación</h3>

                            <table>
                                <tr>
                                    <th class="textLeft" style="">¿ Cuál ha sido su mayor logro ?</th>
                                    <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->pregunta_validacion_1 }}</td>
                                </tr>

                                <tr>
                                    <th class="textLeft" style="">¿ Qué lo motiva a trabajar ?</th>
                                    <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->pregunta_validacion_2 }}</td>
                                </tr>

                                <tr>
                                    <th class="textLeft" style="">¿ Cuáles son sus metas ?</th>
                                    <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->pregunta_validacion_3 }}</td>
                                </tr>

                                <tr>
                                    <th class="textLeft" style="">¿ Qué actividades hace en su tiempo libre ?</th>
                                    <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->pregunta_validacion_4 }}</td>
                                </tr>

                                <tr>
                                    <th class="textLeft" style="">¿ Tiene tatuajes ?</th>
                                    <td class="textLeft" style="border: solid #e4e4e4 1px">
                                        @if($entrevista->pregunta_validacion_5 == 1)
                                            Si
                                        @else
                                            No
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th class="textLeft" style="">¿ Tiene o necesita gafas ?</th>
                                    <td class="textLeft" style="border: solid #e4e4e4 1px">
                                        @if($entrevista->pregunta_validacion_6 == 1)
                                            Si
                                        @else
                                            No
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th class="textLeft" style="">¿ Disponibilidad para viajar ?</th>
                                    <td class="textLeft" style="border: solid #e4e4e4 1px">
                                        @if($entrevista->pregunta_validacion_7 == 1)
                                            Si
                                        @else
                                            No
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th class="textLeft" style="">¿ Multas o comparendos ?</th>
                                    
                                    @if($entrevista->pregunta_validacion_8 == 1)
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">Si</td>
                                        <th class="textLeft" style="">Valor</th>
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->valor_multa }}</td>
                                    @else
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">No</td>
                                    @endif
                                </tr>

                                <tr>
                                    <th class="textLeft" style="">¿ Reportes en datacredito o centrales de riesgo ?</th>
                                    
                                    @if($entrevista->pregunta_validacion_9 == 1)
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">
                                            Si
                                        </td>
                                        <th class="textLeft" style="">Valor</th>
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->valor_reporte }}</td>
                                    @else
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">No</td>
                                    @endif
                                </tr>

                                <tr>
                                    <th class="textLeft" style="">¿ Ya trabajó en Nases ?</th>
                                    
                                    @if($entrevista->pregunta_validacion_10 == 1)
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">
                                            Si
                                        </td>
                                        <th class="textLeft" style="">¿ Para qué empresa ?</th>
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->empresa_trabajo }}</td>
                                    @else
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">No</td>
                                    @endif
                                </tr>

                            </table>

                            @if ($entrevista->observacion_preguntas != '')
                                <table>
                                    <tr>
                                        <th class="textCenter">Observaciones del entrevistador</th>
                                    </tr>
                                    <tr>
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->observacion_preguntas }}</td>
                                    </tr>
                                </table>
                            @endif

                            <h3 class="textCenter">VII. Concepto final</h3>

                            <table>
                                <tr>
                                    <th class="textLeft" style="">¿ El candidato posee las competencias para ejercer el cargo ?</th>
                                    <td class="textLeft" style="border: solid #e4e4e4 1px">
                                        @if($entrevista->concepto_final_preg_1 == 1)
                                            Si
                                        @else
                                            No
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th class="textLeft" style="">¿ El candidato cuenta con la experiencia necesaria ?</th>
                                    <td class="textLeft" style="border: solid #e4e4e4 1px">
                                        @if($entrevista->concepto_final_preg_2 == 1)
                                            Si
                                        @else
                                            No
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th class="textLeft" style="">¿ El candidato cuenta con algún tipo de reporte o restricción que le impida ejercer el cargo ?</th>
                                    <td class="textLeft" style="border: solid #e4e4e4 1px">
                                        @if($entrevista->concepto_final_preg_3 == 1)
                                            Si
                                        @else
                                            No
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            @if ($entrevista->concepto_final != '')
                                <table>
                                    <tr>
                                        <th class="textCenter">Concepto</th>
                                    </tr>
                                    <tr>
                                        <td class="textLeft" style="border: solid #e4e4e4 1px">{{ $entrevista->concepto_final }}</td>
                                    </tr>
                                </table>
                            @endif

                            <br><br>

                            <table>
                                @if ($entrevista->apto == 1)
                                    <td style="background-color: #f1f1f1; text-align: center; border: solid #e4e4e4 1px">Apto (Si)</td>
                                @else
                                    <td style="background-color: #f1f1f1; text-align: center; border: solid #e4e4e4 1px">Apto (No)</td>
                                @endif
                            </table>

                        @else
                            @if(route('home') == "https://soluciones.t3rsc.co" || route('home') == "http://soluciones.t3rsc.co")
                                <h3 class="textCenter">I. Cliente</h3>
                                
                                <table>
                                    <tr>
                                        <th class="textCenter" >N° Requisicion</th>
                                        <th class="textCenter" >Cliente </th>
                                        <th class="textCenter" >Cargo </th>
                                    </tr>

                                    <tr>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $reqcandidato->requerimiento_id }}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px" >{{$reqcandidato->cliente_nombre}}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px" >{{ $reqcandidato->descripcion }}</td>
                                    </tr>
                                </table>

                                <h3 class="textCenter">II.Información Académica</h3>
                                
                                <table>
                                    @foreach($estudios as $estudio)
                                        <tr>
                                            <td style="border: solid #e4e4e4 1px">{{$estudio->institucion}}-{{$estudio->titulo_obtenido  }}</td>
                                        </tr>
                                    @endforeach
                                </table>

                                <h3 class="textCenter">III.Información Laboral</h3>
                                <table>
                                    <tr>
                                        <th class="textCenter" >Empresa</th>
                                        <th class="textCenter" >Fecha de ingreso</th>
                                        <th class="textCenter" >Fecha de retiro</th>
                                        <th class="textCenter" >Tiempo total</th>
                                        <th class="textCenter" >Cargo desempeñado</th>
                                        <th class="textCenter" >Motivo del retiro</th>
                                    </tr>
                                    @foreach($experiencias as $experiencia)
                                    
                                        <?php
                                            $fecha1 = $experiencia->fecha_inicio;
                                            $fecha_i = new DateTime($fecha1);
                      
                                            $fecha2 = $experiencia->fecha_final;
                                            $fecha_f = new DateTime($fecha2);
                                            $fecha_hoy = $fecha_i->diff($fecha_f);
                                        ?>
                                        
                                        <tr>
                                            <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->nombre_empresa}}</td>
                                            <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->fecha_inicio}}</td>

                                            @if($experiencia->fecha_final != "0000-00-00")
                                                <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->fecha_final}}</td>
                                            @else
                                                <td class="textCenter" style="border: solid #e4e4e4 1px">TRABAJO ACTUAL</td>
                                            @endif

                                            @if($experiencia->fecha_final != "0000-00-00")
                                                @if ($fecha_hoy->y <= 0)
                                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{$fecha_hoy->m}} Meses</td>
                                                @else
                                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{$fecha_hoy->y}} Años {{ $fecha_hoy->m }} Meses</td>
                                                @endif

                                                <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->desc_cargo}}</td>
                                                <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->desc_motivo}}</td>
                                            @else
                                                <td class="textCenter" style="border: solid #e4e4e4 1px">TRABAJO ACTUTAL</td>
                                                <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->desc_cargo}}</td>
                                                
                                                @if($experiencia->desc_motivo)
                                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->desc_motivo}}</td>
                                                @else
                                                    <td class="textCenter" style="border: solid #e4e4e4 1px">NO TIENE</td>
                                                @endif
                                            @endif
                                        </tr>

                                    @endforeach
                                </table>

                                <h3>Otros trabajos</h3>

                                @if(isset($entrevista->otros_trabajos))
                                  <table class="colum1">
                                   <td style="border: solid #e4e4e4 1px">{{ mb_strtolower($entrevista->otros_trabajos)}}</td>
                                    </table>
                                @else
                                    <table class="colum1">
                                        <td style="border: solid #e4e4e4 1px">No ha tenido otros trabajos</td>
                                    </table>
                                @endif
                            @endif

                            @if($entrevista->getCompetencias() != null)
                                <h3 class="textCenter">IV. Evaluación APA</h3>
                                <table class="colum1">
                                    <thead>
                                        <tr>
                                            <th>Nombre de la evaluación</th>
                                            <th>Inferior a lo requerido</th>
                                            <th>Acorde a lo requerido</th>
                                            <th>Superior a lo requerido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Presentación personal <p>(Vestido,aseo y apariencia general)</p></th>
                               
                                            <td style="display:none ;border: solid #e4e4e4 1px" >
                                                @if($entrevista->getCompetencias()[1] == 0)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[1] == 2)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[1] == 3)
                                                    <p>SI</p>
                                                @endif
                                            </td>
                                            
                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[1] == 4)
                                                    <p>SI</p>
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th rowspan="2">
                                                <ul style="position: relative;  top: -1%;" >
                                                    <h4 style="position: relative;  left: -10%;">DESENVOLVIMIENTO</h4>
                                                    <li>Comportamiento verbal <p>(Vocabulario empleado, fluidéz verbal, hilación y coherencias en las ideas.)</p></li>
                                                    <br><br><br>
                                                    <li>Comportamiento no verbal <p>(Contacto visual, gestos, movimientos de las manos y disposición corporal.)</p> </li>
                                                </ul>
                                            </th>

                                            <td style="display:none" >
                                                @if($entrevista->getCompetencias()[2] == 0)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[2] == 2)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[2] == 3)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[2] == 4)
                                                    <p>SI</p>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="display:none" >
                                                @if($entrevista->getCompetencias()[3] == 0)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[3] == 2)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[3] == 3)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[3] == 4)
                                                    <p>SI</p>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Autoestima <p>(Auto-estima, auto concepto, auto eficacia y auto imagen.)</p> </th>
                                            
                                            <td style="display:none" >
                                                @if($entrevista->getCompetencias()[4] == 0)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[4] == 2)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[4] == 3)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[4] == 4)
                                                    <p>SI</p>
                                                @endif
                                            </td>
                                        </tr>
                            
                                        <tr>
                                            <th>Proyección <p>(Establecimiento de las metas personales, laborales, académicas, comportamientos proactivos.)</p> </th>
                                            
                                            <td style="display:none" >
                                                @if($entrevista->getCompetencias()[5] == 0)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[5] == 2)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[5] == 3)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[5] == 4)
                                                    <p>SI</p>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Habilidad de afrontamiento  <p>(Capacidad para adaptarse a nuevas situaciones, empleo de fortalezas, académicas,  comportamientos proactivos para resolución de conflictos y facilidad en la toma de decisiones.)</p></th>
                                            
                                            <td style="display:none" >
                                                @if($entrevista->getCompetencias()[6] == 0)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[6] == 2)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[6] == 3)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[6] == 4)
                                                    <p>SI</p>
                                                @endif
                                            </td style="border: solid #e4e4e4 1px">
                                        </tr>
                         
                                        <tr>
                                            <th>Habilidades sociales <p>(Empatía, amabilidad, iniciativa y facilidad  en la interacción.)</p> </th>
                                            
                                            <td style="display:none" >
                                                @if($entrevista->getCompetencias()[7] == 0)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[7] == 2)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px"> 
                                                @if($entrevista->getCompetencias()[7] == 3)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[7] == 4)
                                                    <p>SI</p>
                                                @endif
                                            </td>
                                        </tr>
                            
                                        <tr>
                                            <th>Motivación <p>(Interés por el cargo, interés en la organización  y dinamismo.)</p> </th>
                                 
                                            <td style="display:none" >
                                                @if($entrevista->getCompetencias()[8] == 0)
                                                    <p>SI</p>
                                                @endif  
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[8] == 2)
                                                    <p>SI</p>
                                                @endif  
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[8] == 3)
                                                    <p>SI</p>
                                                @endif
                                            </td>

                                            <td style="border: solid #e4e4e4 1px">
                                                @if($entrevista->getCompetencias()[8] == 4)
                                                    <p>SI</p>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                            {{-- *********para Soluciones ************** --}}

                            @if(route("home") == "http://soluciones.t3rsc.co" || route("home") == "https://soluciones.t3rsc.co")

                                <h3 class="textCenter">V.Información estado de salud</h3>

                                <table class="colum1">
                                    <tr border=1 class="textLeft" style="">
                                        <th>Enfermedades que ha tenido</th>
                                        <th style="font-weight: normal;background: none;">{{$entrevista->enfermedades}}</th>
                                    </tr>

                                    <tr class="textLeft" style="">
                                        <th>Cirugias que le han practicado</th>
                                        <th style="font-weight: normal;background: none;">{{$entrevista->cirugias}}</th>
                                    </tr>

                                    <tr class="textLeft" style="">
                                        <th>Posee alguna alergia, fobia o consume algún medicamento u otros?</th>
                                        <th style="font-weight: normal;background: none;">{{$entrevista->alergias}}</th>
                                    </tr>
                                </table>
                                
                                <br>

                                <h3 class="textCenter">VI.Detalle de los hijos</h3>                
                      
                                @if($hijos->count()>0)
                                    <table class="colum1">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Edad</th>
                                            <th>Escolaridad</th>
                                        </tr>
                                        @foreach($hijos as $hijo)
                                          <tr>
                                           <td>{{$hijo->nombres}}</td>
                                           <td>{{$hijo->edad}}</td>
                                           <td>{{$hijo->escolaridad}}</td>
                                          </tr>
                                        @endforeach
                                    </table>
                                @else
                                    <p class="textCenter"> No tiene hijos</p>
                                @endif
                  
                                <h3 class="textCenter">VII.Especificaciones para el cargo</h3>

                                <table class="colum1">
                                    <tr border=1 class="textLeft" style="">
                                        <th>Fortalezas</th>
                                        <th style="font-weight: normal;background: none;">{{$entrevista->fortalezas}}</th>
                                    </tr>

                                    <tr class="textLeft" style="">
                                        <th>Oportunidad de mejora</th>
                                        <th style="font-weight: normal;background: none;">{{$entrevista->opor_mejora}}</th>
                                    </tr>
                                    
                                    <tr class="textLeft" style="">
                                        <th>Proyectos y/o expectativas</th>
                                        <th style="font-weight: normal;background: none;">{{$entrevista->proyectos}}</th>
                                    </tr>

                                    <tr class="textLeft" style="">
                                        <th>Valores y/o compromisos</th>
                                        <th style="font-weight: normal;background: none;">{{$entrevista->valores}}</th>
                                    </tr>

                                    <tr class="textLeft" style="">
                                        <th>Por qué es un candidato idóneo para ocupar el cargo?</th>
                                        <th style="font-weight: normal;background: none;">{{$entrevista->candidato_idoneo}}</th>
                                    </tr>
                                </table>

                                <h3 class="textCenter">VIII.Concepto de la entrevista</h3>

                                <div style="width:100%;word-wrap: break-word;border: 1px solid gray;padding: .5em;">
                                    <p>{!!$entrevista->concepto_entre!!}</p>
                                </div>
                                
                                <br><br>
                 
                                <table class="colum1">
                                    <tr>
                                        <th class="textCenter">
                                            Apto({{(($entrevista->apto == 1)?"Si":"No")}})
                                        </th>
                                        
                                        <th class="textCenter">
                                            Aplazado({{(($entrevista->aplazado == 1)?"Si":"No")}})
                                        </th>
                                        <th class="textCenter">
                                            Pendiente({{(($entrevista->pendiente ==1)?"Si":"No")}})
                                        </th>
                                        <th class="textCenter">
                                            No apto({{(($entrevista->apto == 0)?"Si":"No")}})
                                        </th>
                                    </tr>
                                </table>
                                
                                <br>

                                <table class="colum1">
                                    <tr>
                                        <th class="textCenter">
                                            Fecha Realizacion
                                        </th>
                                        <th class="textCenter" style="ackground: none;font-weight: normal;">
                                            {{$entrevista->created_at}}
                                        </th>
                                        <th class="textCenter">
                                            Psicologo realizó entrevista
                                        </th>
                                        <th class="textCenter" style="ackground: none;font-weight: normal;">
                                            {{ $entrevista->getNamePsicologo()}}
                                        </th>
                                    </tr>
                                </table>
                                
                                <br><br>

                            @endif

                            @if(route("home") == "https://komatsu.t3rsc.co" || route("home") == "http://komatsu.t3rsc.co")
                                {{--
                                    <h3 class="textCenter">I. Cliente</h3>
                                    <table>
                                        <tr>
                                            <th class="textCenter" >N° Requisicion</th>
                                            <th class="textCenter" >Cliente </th>
                                            <th class="textCenter" >Cargo </th>
                                        </tr>
                                        <tr>
                                            <td class="textCenter" style="border: solid #e4e4e4 1px">{{ $reqcandidato->requerimiento_id }}</td>
                                            <td class="textCenter" style="border: solid #e4e4e4 1px" >{{$reqcandidato->cliente_nombre}}</td>
                                            <td class="textCenter" style="border: solid #e4e4e4 1px" >{{ $reqcandidato->descripcion }}</td>
                                        </tr>
                                    </table>
                                --}}

                                <h3 class="textCenter">I. Informacion Personal / General</h3>
                  
                                <table>
                                    <tr>
                                        <th class="textCenter" >N° Cédula</th>
                                        <th class="textCenter" >Apellidos y nombres </th>
                                        <th class="textCenter" >Fecha de nacimiento</th>
                                        <th class="textCenter" >Edad</th>
                                        <th class="textCenter" >Dirección</th>
                                        <th class="textCenter" >telefonos</th>
                                    </tr>
                                 
                                    <tr>
                                        <td class="textCenter" style="ext-align: center;border: solid #e4e4e4 1px"> {{$datos_basicos->numero_id}} </td>
                                        <td class="textCenter" style="ext-align: center;border: solid #e4e4e4 1px" >{{$datos_basicos->nombres}} {{$datos_basicos->primer_apellido}} {{ $datos_basicos->segundo_apellido }}</td>
                                        <td class="textCenter" style="ext-align: center;border: solid #e4e4e4 1px" >{{$datos_basicos->fecha_nacimiento}}</td>
                                        <td class="textCenter" style="ext-align: center;border: solid #e4e4e4 1px" >{{ $edad}}</td>
                                        <td class="textCenter" style="ext-align: center;border: solid #e4e4e4 1px" >{{ $datos_basicos->direccion }}</td>
                                        <td class="textCenter" style="ext-align: center;border: solid #e4e4e4 1px" >{{ $datos_basicos->telefono_fijo}}-{{ $datos_basicos->telefono_movil}}</td>
                                    </tr>
                                </table>
                                
                                <table>
                                    <tr>
                                        <th class="textCenter"><h3>Descripción</h3></th>
                                    </tr>
                                    
                                    <tr>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{$entrevista->info_general}}</td>
                                    </tr>
                                </table>
           
                                {{--
                                    <h3 class="textCenter">II.Información Académica</h3>
                                    <table>
                                        @foreach($estudios as $estudio)
                                            <tr>
                                                <td style="border: solid #e4e4e4 1px">{{$estudio->institucion}}-{{$estudio->titulo_obtenido  }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                --}}

                                <br><br>

                                <h3 class="textCenter">II. Información Laboral</h3>

                                <table>
                                    <tr>
                                        <th class="textCenter" >Empresa</th>
                                        <th class="textCenter" >Fecha de ingreso</th>
                                        <th class="textCenter" >Fecha de retiro</th>
                                        <th class="textCenter" >Tiempo total</th>
                                        <th class="textCenter" >Cargo desempeñado</th>
                                        <th class="textCenter" >Motivo del retiro</th>
                                    </tr>
                                    @foreach($experiencias as $experiencia)
                                        <?php
                                            $fecha1 = $experiencia->fecha_inicio;
                                            $fecha_i = new DateTime($fecha1);

                                            $fecha2 = $experiencia->fecha_final;
                                            $fecha_f = new DateTime($fecha2);
                                            $fecha_hoy = $fecha_i->diff($fecha_f);
                                        ?>
           
                                        <tr>
                                            <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->nombre_empresa}}</td>
                                            <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->fecha_inicio}}</td>
                                            @if($experiencia->fecha_final != "0000-00-00")
                                                <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->fecha_final}}</td>
                                            @else
                                                <td class="textCenter" style="border: solid #e4e4e4 1px">TRABAJO ACTUAL</td>
                                            @endif
                                            @if($experiencia->fecha_final != "0000-00-00")
                                                @if ($fecha_hoy->y <= 0)
                                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{$fecha_hoy->m}} Meses</td>
                                                @else
                                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{$fecha_hoy->y}} Años {{ $fecha_hoy->m }} Meses</td>
                                                @endif
                                                <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->desc_cargo}}</td>
                                                <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->desc_motivo}}</td>
                                            @else 
                                                <td class="textCenter" style="border: solid #e4e4e4 1px">TRABAJO ACTUTAL</td>
                                                <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->desc_cargo}}</td>
                                                @if($experiencia->desc_motivo)
                                                    <td class="textCenter" style="border: solid #e4e4e4 1px">{{$experiencia->desc_motivo}}</td>
                                                @else
                                                    <td class="textCenter" style="border: solid #e4e4e4 1px">NO TIENE</td>
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
           
                                {{--
                                    <h3>Otros trabajos</h3>
                                    @if(isset($entrevista->otros_trabajos))
                                        <table class="colum1">
                                            <td style="border: solid #e4e4e4 1px">{{  mb_strtoupper($entrevista->otros_trabajos) }}</td>
                                        </table>
                                    @else
                                        <table class="colum1">
                                            <td style="border: solid #e4e4e4 1px">No ha tenido otros trabajos</td>
                                        </table>
                                    @endif
                                --}}

                                <br><br>

                                <h3 class="textCenter">III. Fortalezas frente al cargo</h3>
                                <div>
                                    <p class="textLeft" style="border: solid #e4e4e4 1px;padding: 1em;">{{$entrevista->fortalezas}}</p>
                                </div>

                                {{-- 
                                    @if($entrevista->getCompetencias() != null)

                                        <h3 class="textCenter">IV. Evaluación APA</h3>
                                            <table class="colum1">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre de la evaluación</th>
                                                        <th>Inferior a lo requerido</th>
                                                        <th>Acorde a lo requerido</th>
                                                        <th>Superior a lo requerido</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                      <tr>
                                                        <th>Presentación personal <p>(Vestido,aseo y apariencia general)</p></th>
                                                       
                                                        <td style="display:none ;border: solid #e4e4e4 1px" >
                                                            @if($entrevista->getCompetencias()[1] == 0)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[1] == 2)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[1] == 3)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[1] == 4)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                       
                                                        
                                                    </tr>
                                                    <tr>
                                                    <th rowspan="2">
                                                          
                                                           <ul style="position: relative;  top: -1%;" >
                                                            <h4 style="position: relative;  left: -10%;">DESENVOLVIMIENTO</h4>
                                                               <li>Comportamiento verbal <p>(Vocabulario empleado, fluidéz verbal, hilación y coherencias en las ideas.)</p></li>
                                                               <br><br><br>
                                                                <li>Comportamiento no verbal <p>(Contacto visual, gestos, movimientos de las manos y disposición corporal.)</p> </li>
                                                           </ul>
                                                           
                                                        
                                                       
                                                         
                                                    </th>
                                                        <td style="display:none" >
                                                            @if($entrevista->getCompetencias()[2] == 0)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[2] == 2)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[2] == 3)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[2] == 4)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                       
                                                        
                                                    </tr>

                                                     <tr>
                                                        <td style="display:none" >
                                                            @if($entrevista->getCompetencias()[3] == 0)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[3] == 2)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[3] == 3)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[3] == 4)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                      
                                                        
                                                    </tr>
                                                   <tr>
                                                        <th>Autoestima <p>(Auto-estima, auto concepto, auto eficacia y auto imagen.)</p> </th>
                                                        <td style="display:none" >
                                                            @if($entrevista->getCompetencias()[4] == 0)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[4] == 2)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[4] == 3)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[4] == 4)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                       
                                                       
                                                    </tr>
                                                    <tr>
                                                        <th>Proyección <p>(Establecimiento de las metas personales, laborales, académicas, comportamientos proactivos.)</p> </th>
                                                        <td style="display:none" >
                                                            @if($entrevista->getCompetencias()[5] == 0)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[5] == 2)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[5] == 3)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[5] == 4)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                      
                                                        
                                                    </tr>
                                                    <tr>
                                                        <th>Habilidad de afrontamiento  <p>(Capacidad para adaptarse a nuevas situaciones, empleo de fortalezas, académicas,  comportamientos proactivos para resolución de conflictos y facilidad en la toma de decisiones.)</p></th>
                                                        <td style="display:none" >
                                                            @if($entrevista->getCompetencias()[6] == 0)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[6] == 2)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[6] == 3)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[6] == 4)
                                                                <p>SI</p>
                                                            @endif
                                                        </td style="border: solid #e4e4e4 1px">
                                                        
                                                        
                                                    </tr>
                                                 <tr>
                                                        <th>Habilidades sociales <p>(Empatía, amabilidad, iniciativa y facilidad  en la interacción.)</p> </th>
                                                        <td style="display:none" >
                                                            @if($entrevista->getCompetencias()[7] == 0)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[7] == 2)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px"> 
                                                            @if($entrevista->getCompetencias()[7] == 3)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[7] == 4)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                       
                                                        
                                                    </tr>
                                                    <tr>
                                                        <th>Motivación <p>(Interés por el cargo, interés en la organización  y dinamismo.)</p> </th>
                                                         <td style="display:none" >
                                                          @if($entrevista->getCompetencias()[8] == 0)
                                                                <p>SI</p>
                                                            @endif  
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                          @if($entrevista->getCompetencias()[8] == 2)
                                                                <p>SI</p>
                                                            @endif  
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[8] == 3)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                        <td style="border: solid #e4e4e4 1px">
                                                            @if($entrevista->getCompetencias()[8] == 4)
                                                                <p>SI</p>
                                                            @endif
                                                        </td>
                                                      
                                                    </tr>
                                                  
                                                </tbody>
                                            </table>
                                            @endif
                                --}}
                                
                                <br><br>

                                <h3 class="textCenter">IV. Oportunidades de mejora frente al cargo</h3>
                                <div>
                                    <p class="textLeft" style="border: solid #e4e4e4 1px;padding: 1em;">{{$entrevista->opor_mejora}}</p>
                                </div>
                                
                                <br>
          
                                <h3 class="textCenter" >V.Otras habilidades / conocimientos</h3>
            
                                <table>
                                    <tr>
                                        <th class="textCenter">Idioma</th>
                                        <th class="textCenter">Nivel</th>
                                    </tr>

                                    <tr>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{$entrevista->idioma_1}}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{$entrevista->nivel_1}}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{$entrevista->idioma_2}}</td>
                                        <td class="textCenter" style="border: solid #e4e4e4 1px">{{$entrevista->nivel_2}}</td>
                                    </tr>
                                </table>

                                <h4 class="textCenter">Herramientas de informática / software</h4>

                                <div>
                                    <p class="textLeft" style="border: solid #e4e4e4 1px;padding: 1em;">{{$entrevista->herramientas}}</p>
                                </div>

                                <h4 class="textCenter">Otras habilidades / herramientas / conocimientos requeridos</h4>
            
                                <div>
                                    <p class="textLeft" style="border: solid #e4e4e4 1px;padding: 1em;">{{$entrevista->otras_herramientas}}</p>
                                </div>

                                <br><br>

                                <h3 class="textCenter" >VI. Expectativas</h3>
                  
                                <h4 class="textCenter"> Motivación para participar en el proceso</h4>
                                <div>
                                  <p class="textLeft" style="border: solid #e4e4e4 1px;padding: 1em;">{{$entrevista->motivacion}}</p>
                                </div>

                                <h4 class="textCenter"> Expectativas para la reubicación laboral</h4>
        
                                <div>
                                    <p class="textLeft" style="border: solid #e4e4e4 1px;padding: 1em;">{{$entrevista->expectativas}}</p>
                                </div>

                                <h3 class="textCenter" >VII. Observaciones adicionales</h3>
                                
                                <h4 class="textCenter"> Conflicto de interes</h4>
        
                                <div>
                                    <h6 class="textCenter"> Conflicto de interes del Entrevistador:</h6>

                                    <p class="textLeft" style="border: solid #e4e4e4 1px;padding: 1em;">{{$entrevista->conflicto}}</p>
                                </div>

                                <div>
                                    <h6 class="textCenter"> Conflicto de interes del Entrevistado:</h6>
                                    <p class="textLeft" style="border: solid #e4e4e4 1px;padding: 1em;">{{$entrevista->conflicto_entrevistador}}</p>
                                </div>

                                <h4 class="textCenter">  Comentarios adicionales del entrevistado</h4>
                                <div>
                                    <p class="textLeft" style="border: solid #e4e4e4 1px;padding: 1em;">{{$entrevista->comentarios_entrevistado}}</p>
                                </div>

                                <h4 class="textCenter">  Comentarios adicionales del entrevistador</h4>
                                <div>
                                    <p class="textLeft" style="border: solid #e4e4e4 1px;padding: 1em;">{{$entrevista->comentarios_entrevistador}}</p>
                                </div>
                                
                                <br><br>
                                
                                <table class="colum1">
                                    <tr>
                                        <th class="textCenter">
                                            {{(($entrevista->apto==1)?"Apto":"")}}
                                        </th>

                                        <th class="textCenter" >
                                            {{(($entrevista->continua==1)?"Continúa proceso":"No continúa")}}
                                        </th>
                        
                                        <th class="textCenter" >
                                            {{(($entrevista->tentativo==1)?"Tentativo ":"No tentativo")}}
                                        </th>
                                    </tr>
                                </table>
                                
                                <br>

                                <h3 class="textCenter">Justificación</h3>

                                <div>
                                    <p class="textLeft" style="border: solid #e4e4e4 1px;padding: 1em;">{{$entrevista->justificacion}}</p>
                                </div>
                                
                                <br><br>

                                <table class="colum1">
                                    <tr>
                                        <th>Fecha de realización de entrevista</th>
                                        <th > {{ $entrevista->created_at }}</th>
                                        <th>Analista que realizó la entrevista</th>
                                        <th>
                                         @if($entrevista->getNamePsicologo() != null)
                                          {{mb_strtoupper($entrevista->getNamePsicologo())}}
                                         @endif
                                        </th>
                                    </tr>
                                </table>
                                <br><br>
                            @endif
                        @endif

                    @endforeach
                @endif

            @endif
            <!-- / Entrevista semi -->
    
            @if($entrevistas->count() >= 1)
                @foreach($entrevistas as $key => $entrevista)
                    <h2> Entrevista {{ \App\Models\DatosBasicos::convertirFecha($entrevista->created_at) }}</h2>
                    
                    @if($entrevista->aspecto_familiar != "")
                        <hr align="left" class="style2">
                            
                            <p class="subtitulo">
                                <strong>
                                @if(route('home') != "https://temporizar.t3rsc.co") Aspecto Familiar @else Validacion personal @endif
                                </strong>
                            </p>

                            <p class="parrafo">
                                {{strip_tags($entrevista->aspecto_familiar)}}
                            </p>
                    @endif
               
                    @if ($entrevista->aspecto_academico != "")
                        <p class="subtitulo">
                            <strong>
                            @if(route('home') == "https://temporizar.t3rsc.co") Validacion Organizacional @else Aspectos Académicos @endif
                            </strong>
                        </p>

                        <p class="parrafo">
                          {{strip_tags($entrevista->aspecto_academico)}}
                        </p>
                    @endif
                
                    @if ($entrevista->aspectos_experiencia != "")
                        <p class="subtitulo">
                            <strong>
                                Aspectos Experiencia
                            </strong>
                        </p>

                        <p class="parrafo">
                            {{ strip_tags($entrevista->aspectos_experiencia) }}
                        </p>
                    @endif
             
                    @if($entrevista->aspectos_personalidad != "")
                        <p class="subtitulo">
                            <strong>
                                Aspectos de Personalidad
                            </strong>
                        </p>
                        <p class="parrafo">
                            {{strip_tags($entrevista->aspectos_personalidad)}}
                        </p>
                    @endif
                
                    @if ($entrevista->fortalezas_cargo != "")
                        <p class="subtitulo">
                            <strong>
                            @if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co") Conflicto Intereses @else Fortalezas frente al Cargo @endif
                            </strong>
                        </p>
                        <p class="parrafo">
                            {{ strip_tags($entrevista->fortalezas_cargo) }}
                        </p>
                    @endif
              
                    @if ($entrevista->oportunidad_cargo != "")
                        <p class="subtitulo">
                            <strong>
                           @if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co") Conflicto Entrevistador @else Oportunidades de mejora frente al cargo @endif
                            </strong>
                        </p>
                        <p class="parrafo">
                            {{ strip_tags($entrevista->oportunidad_cargo) }}
                        </p>
                    @endif
                
                    @if ($entrevista->concepto_general != "")
                        <p class="subtitulo">
                            <strong>
                                Concepto General
                            </strong>
                        </p>
                        
                        <p class="parrafo">
                            {{ strip_tags($entrevista->concepto_general) }}
                        </p>
                    @endif

                    @if ($entrevista->evaluacion_competencias != "")
                        <p class="subtitulo">
                            <strong>
                                Evaluación de competencias
                            </strong>
                        </p>
                        <p class="parrafo">
                            {{ strip_tags($entrevista->evaluacion_competencias)}}
                        </p>
                    @endif

                    <!--FIRMAR -->
                    <h1>
                        __________________
                    </h1>
                    
                    <p>
                        {{ $entrevista->getNamePsicologo()}}
                    </p>
                    
                    <p>
                        Fecha de finalización {{ \App\Models\DatosBasicos::convertirFecha($entrevista->updated_at) }}
                    </p>
                @endforeach
            @endif

            <!-- Entrevista virtual video -->
            @if($entrevistas_virtuales->count() >= 1)
                <h2>Entrevista virtual archivo</h2>

                @foreach($entrevistas_virtuales as $key => $entrevista_virtual)
                    @if ($entrevista_virtual->respuesta != "")
                        <hr align="left" class="style2">

                        <strong>Pregunta ({{ $entrevista_virtual->pregunta }})</strong> Archivo Adjunto:
                        <a class="enlace" target="_blank" href="{{ asset('recursos_videoRespuesta/'.$entrevista_virtual->respuesta) }}">
                            <!--<span class="fa fa-file" aria-hidden="true"></span>--> Ver Respuesta
                        </a>
                    @endif
                @endforeach
            @endif
            <!-- / Entrevista virtual video -->

            <!-- Entrevista Multiple -->
            @if(count($entrevista_multiple) > 0)
              <h2>
                Entrevista Múltiple {{ \App\Models\DatosBasicos::convertirFecha($entrevista_multiple->created_at) }}
              </h2>

              <hr align="left" class="style2">
                        
              <p class="subtitulo">
                <strong>
                  Concepto
                </strong>
              </p>

              <p class="parrafo">
                {{strip_tags($entrevista_multiple->concepto)}}
              </p>
                        
              <p>
                <strong>
                  Calificación:
                </strong>
                {{$entrevista_multiple->calificacion}}
                <br>
                <strong>
                  Apto:
                </strong>
                {{ $entrevista_multiple->apto == 1 ? 'El candidato es apto' : ($entrevista_multiple->apto == 2 ? 'El candidato es no apto' : '') }}
                <br>
                <strong>
                    Analista que realizó el concepto:
                </strong>
                {{ $entrevista_multiple->nombre_usuario_gestiono() }}
                <br>
                <br>
                <a href="{{url('entrevista-multiple/'.$entrevista_multiple->entrevista_multiple_id)}}" target="_blank" class="enlace" >Ver Entrevista Múltiple</a>
              </p>
              
              <p>
                Fecha de realización {{ \App\Models\DatosBasicos::convertirFecha($entrevista_multiple->updated_at) }}
              </p>
            @endif
            <!-- / Entrevista Multiple -->

            <!-- Pruebas de indiomas -->
            @if(count($pruebas_idiomas) >= 1)
                <h2>Prueba idioma archivo</h2>

                @foreach($pruebas_idiomas as $key => $prueba_idioma)
                    @if ($prueba_idioma->respuesta != "")
                        <hr align="left" class="style2">

                        <strong>Pregunta ({{ $prueba_idioma->pregunta }})</strong> Archivo Adjunto:
                        <a class="enlace" target="_blank" href="{{ asset('recursos_VideoIdioma/'.$prueba_idioma->respuesta) }}">
                            <!--<span class="fa fa-file" aria-hidden="true"></span>--> Ver Respuesta
                        </a>
                    @endif
                @endforeach
            @endif

            <!-- fin pruebas idiomas-->


            <!-- Informe preliminar-->
            @if(isset($preliminar))

                @if($preliminar->count() >= 1)
                    <h2>
                        Informe Preliminar
                    </h2>
                    <hr align="left" class="style2">
                    <p class="subtitulo">
                     <a target="_blank" href="{{route('admin.getinforme_preliminar').'?req_id='.$reqcandidato->requerimiento_id}}" > Ver Informe </a>                         
                    </p>
                  <br/>
                  <br/>
                @endif

            @endif

            <!-- PRUEBAS PSICOTECNICAS -->
            @if ($resp_ethical_values != null || $resp_personal_skills != null || $resp_bryg != null)
                <h2>
                    Pruebas Psicotécnicas
                </h2>

                @if ($resp_ethical_values != null || $resp_personal_skills != null)
                    <hr align="left" class="style2">
                    <?php 
                        $columnas = 0;
                        $promedio_total = 0;
                        if ($resp_ethical_values != null) {
                            $columnas++;
                        }
                        if ($resp_personal_skills != null) {
                            $columnas++;
                            $promedio_total = round($resp_personal_skills->ajuste_global);
                        }
                        switch ($columnas) {
                            case 1:
                                $width_col = 100;
                                break;
                            case 2:
                                $width_col = 50;
                                break;
                            case 3:
                                $width_col = 33.3;
                                break;
                            default:
                                break;
                        }
                        if ($resp_ethical_values != null) {
                            $promedio_porc_ideal = round(($valores_ideal_grafico['amor'] + $valores_ideal_grafico['no_violencia'] + $valores_ideal_grafico['paz'] + $valores_ideal_grafico['rectitud'] + $valores_ideal_grafico['verdad']) / 5);

                            $promedio_porc = round(($porcentaje_valores_obtenidos['amor'] + $porcentaje_valores_obtenidos['no_violencia'] + $porcentaje_valores_obtenidos['paz'] + $porcentaje_valores_obtenidos['rectitud'] + $porcentaje_valores_obtenidos['verdad']) / 5);

                            $dif_porc = $promedio_porc - $promedio_porc_ideal;

                            $grafica = $resp_ethical_values->graficaRadial($promedio_porc);

                            $promedio_total += $promedio_porc;
                        }

                        if ($columnas > 0) {
                            $promedio_total = $promedio_total / $columnas;
                        }
                    ?>

                    <table class="table" width="100%">
                        <tr>
                            <th class="textCenter" colspan="{{ $columnas }}">
                                @if ($resp_ethical_values != null && $resp_personal_skills != null)
                                    Ajuste general del candidato al perfil ideal del cargo
                                @elseif ($resp_personal_skills != null)
                                    Ajuste del candidato a la prueba Personal Skills
                                @else
                                    Ajuste del candidato a la prueba Ethical Values
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <td class="textCenter" colspan="{{ $columnas }}">
                                <div class="circle c-2">
                                    <div class="text-circle-2">
                                        {{ round($promedio_total) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="textCenter" colspan="{{ $columnas }}">
                                @if($promedio_total < 25)
                                    <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-01.png') }}" width="320">

                                @elseif($promedio_total >= 25 && $promedio_total <= 50)
                                    <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-00.png') }}" width="320">

                                @elseif($promedio_total >= 50 && $promedio_total <= 75)

                                    @if($promedio_total > 50 && $promedio_total <= 55)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-02.png') }}" width="320">

                                    @elseif($promedio_total > 55 && $promedio_total <= 58)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-03.png') }}" width="320">

                                    @elseif($promedio_total > 58 && $promedio_total <= 64)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-04.png') }}" width="320">

                                    @elseif($promedio_total > 64 && $promedio_total <= 68)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-05.png') }}" width="320">

                                    @elseif($promedio_total > 68 && $promedio_total <= 72)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-06.png') }}" width="320">

                                    @elseif($promedio_total > 72 && $promedio_total <= 75)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-07.png') }}" width="320">
                                    @endif

                                @elseif($promedio_total >= 75 && $promedio_total <= 100)

                                    @if($promedio_total > 75 && $promedio_total <= 78)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-08.png') }}" width="320">

                                    @elseif($promedio_total > 78 && $promedio_total <= 80)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-09.png') }}" width="320">

                                    @elseif($promedio_total > 80 && $promedio_total <= 84)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-10.png') }}" width="320">

                                    @elseif($promedio_total > 84 && $promedio_total <= 94)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-11.png') }}" width="320">

                                    @elseif($promedio_total > 94 && $promedio_total <= 100)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-12.png') }}" width="320">
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                    <section>
                        <table class="table" width="100%">
                            <tr>
                                @if ($resp_personal_skills != null)
                                    <td width="{{ $width_col }}%" class="textCenter">
                                        @if ($columnas > 1)
                                            <h4>Ajuste del candidato a la prueba Personal Skills</h4>
                                            <div class="circle c-1">
                                                <div class="text-circle-1">
                                                    {{ round($resp_personal_skills->ajuste_global) }}%
                                                </div>
                                            </div>
                                        @endif

                                        <div class="textCenter" style="margin-top: -0.5rem;">
                                            <h4>Factor de desfase</h4>

                                            <h4 style="margin-top: -0.5rem;">
                                                {{ round($resp_personal_skills->factor_desfase_global) }}%

                                                @if($resp_personal_skills->factor_desfase_global < 0)
                                                    <img style="margin-top: 0.6rem; margin-left: -0.6rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-negativo.png') }}" width="40">
                                                @else
                                                    <img style="margin-top: 0.6rem; margin-left: -0.6rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-positivo.png') }}" width="40">
                                                @endif
                                            </h4>
                                        </div>
                                    </td>
                                @endif
                                @if ($resp_ethical_values != null)
                                    <td class="textCenter" width="{{ $width_col }}%">
                                        @if ($columnas > 1)
                                            <h4>Ajuste del candidato a la prueba Ethical Values</h4>
                                            <div class="circle c-1">
                                                <div class="text-circle-1">
                                                    {{ $promedio_porc }}%
                                                </div>
                                            </div>
                                        @endif
                                        <div class="textCenter" style="margin-top: -0.5rem;">
                                            <h4>Factor de desfase</h4>

                                            <h4 style="margin-top: -0.5rem;">
                                                {{ $dif_porc }}%

                                                @if ($dif_porc >= 0)
                                                    <img style="margin-top: 0.6rem; margin-left: -0.6rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-positivo.png') }}" width="40">
                                                @else
                                                    <img style="margin-top: 0.6rem; margin-left: -0.6rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-negativo.png') }}" width="40">
                                                @endif
                                            </h4>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        </table>
                    </section>

                    <div class="breakAlways"></div>

                    @if($resp_personal_skills != null)
                        <hr align="left" class="style2">
                        
                        <p class="subtitulo font-size-14">
                            <strong>
                                Prueba Personal Skills
                            </strong>
                        </p>

                        <hr align="left" class="style2">

                        <section style="height: 280px;" style="margin-top: -5rem;">
                            <div style="float: left; width: 50%; display : inline-block;">
                                <div class="textCenter">
                                    <h4>Ajuste del <br> candidato al perfil</h4>

                                    <div class="circle c-2">
                                        <div class="text-circle-2">{{ round($resp_personal_skills->ajuste_global) }}%</div>
                                    </div>
                                </div>

                                <div class="textCenter" style="margin-top: -0.5rem;">
                                    <h4>Factor de desfase</h4>

                                    <h1 style="margin-top: -2rem;">
                                        {{ round($resp_personal_skills->factor_desfase_global) }}%

                                        @if($resp_personal_skills->factor_desfase_global < 0)
                                            <img style="margin-top: 1.2rem; margin-left: -1.2rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-negativo.png') }}" width="85">
                                        @else
                                            <img style="margin-top: 1.2rem; margin-left: -1.2rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-positivo.png') }}" width="85">
                                        @endif
                                    </h1>
                                </div>
                            </div>

                            <div class="textCenter" style="float: right; width: 50%;">
                                @if($resp_personal_skills->ajuste_global < 25)
                                    <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-01.png') }}" width="420">

                                @elseif($resp_personal_skills->ajuste_global >= 25 && $resp_personal_skills->ajuste_global <= 50)
                                    <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-00.png') }}" width="420">

                                @elseif($resp_personal_skills->ajuste_global >= 50 && $resp_personal_skills->ajuste_global <= 75)

                                    @if($resp_personal_skills->ajuste_global > 50 && $resp_personal_skills->ajuste_global <= 55)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-02.png') }}" width="420">

                                    @elseif($resp_personal_skills->ajuste_global > 55 && $resp_personal_skills->ajuste_global <= 58)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-03.png') }}" width="420">

                                    @elseif($resp_personal_skills->ajuste_global > 58 && $resp_personal_skills->ajuste_global <= 64)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-04.png') }}" width="420">

                                    @elseif($resp_personal_skills->ajuste_global > 64 && $resp_personal_skills->ajuste_global <= 68)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-05.png') }}" width="420">

                                    @elseif($resp_personal_skills->ajuste_global > 68 && $resp_personal_skills->ajuste_global <= 72)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-06.png') }}" width="420">

                                    @elseif($resp_personal_skills->ajuste_global > 72 && $resp_personal_skills->ajuste_global <= 75)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-07.png') }}" width="420">
                                    @endif

                                @elseif($resp_personal_skills->ajuste_global >= 75 && $resp_personal_skills->ajuste_global <= 100)

                                    @if($resp_personal_skills->ajuste_global > 75 && $resp_personal_skills->ajuste_global <= 78)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-08.png') }}" width="420">

                                    @elseif($resp_personal_skills->ajuste_global > 78 && $resp_personal_skills->ajuste_global <= 80)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-09.png') }}" width="420">

                                    @elseif($resp_personal_skills->ajuste_global > 80 && $resp_personal_skills->ajuste_global <= 84)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-10.png') }}" width="420">

                                    @elseif($resp_personal_skills->ajuste_global > 84 && $resp_personal_skills->ajuste_global <= 94)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-11.png') }}" width="420">

                                    @elseif($resp_personal_skills->ajuste_global > 94 && $resp_personal_skills->ajuste_global <= 100)
                                        <img src="{{ asset('assets/admin/tests/ps-skills/competencia-barra-circular-12.png') }}" width="420">
                                    @endif
                                @endif
                            </div>
                        </section>

                        <br>
                        <section>
                            <h4>Perspectivas comportamentales referentes a las competencias laborales evaluadas</h4>

                            <div class="m-auto" style="width: 95%;">
                                <?php
                                    $insights = [
                                        'Siempre modifica su comportamiento efectivamente ante necesidades del contexto.',
                                        'Con frecuencia propone acciones para responder a demandas específicas del contexto.',
                                        'Algunas veces adapta procesos de forma rápida y eficiente para solucionar problemas repentinos.',

                                        'Siempre distribuye su tiempo efectivamente para cumplir con los resultados esperados.',
                                        'Con frecuencia diseña un plan para garantizar el cumplimiento de metas.',
                                        'Con frecuencia verifica el cumplimiento de cada tarea asignada y la calidad del resultado.',

                                        'Algunas veces ofrece soluciones proactivamente ante necesidades de mejora.',
                                        'Algunas veces delega tareas o procesos a miembros del equipo para el cumplimiento de las metas de la organización.',
                                        'Con frecuencia identifica y exalta los aportes que realizan los miembros del equipo.',

                                        'Siempre utiliza los protocolos para solucionar necesidades o requerimientos de los usuarios.',
                                        'Algunas veces anticipa los puntos críticos en el mediano y largo plazo para asegurar la calidad de los procesos.',
                                        'Siempre mantiene su atención al interactuar con cualquier interlocutor.',

                                        'Con frecuencia transmite explicaciones de forma precisa.',
                                        'Algunas veces establece contacto visual con el interlocutor.',
                                        'Algunas veces transmite explicaciones de forma precisa.',

                                        'Con frecuencia pide ayuda a otros miembros del equipo para cumplir con los objetivos establecidos.',
                                        'Algunas veces ayuda a sus compañeros con la consecución de sus objetivos.',
                                        'Con frecuencia complementa las habilidades del grupo con las propias para cumplir con los objetivos establecidos.'
                                    ];
                                ?>

                                @foreach($totales_personal_skills as $key => $total)
                                    <div>
                                        <p class="font-size-11"><b>{{ $total->descripcion }}:</b></p>
                                    </div>

                                    <p class="parrafo">
                                        {{ $insights[$key] }}
                                    </p>
                                @endforeach
                            </div>
                        </section>

                        @if($concepto_personal_skills != null && $concepto_personal_skills != '')
                            <p>
                                <strong>
                                    Concepto del analista sobre la prueba:
                                 </strong>
                            </p>

                            <p class="parrafo">
                                {{ strip_tags($concepto_personal_skills->concepto) }}
                            </p>
                        @endif

                        <p>
                            <strong>
                                Archivo Adjunto:
                            </strong>
                            <a href="{{url('admin/prueba-competencias-informe/'.$resp_personal_skills->id)}}" target="_blank" class="enlace" >Ver informe Personal Skills</a>
                        </p>
                        <br>
                        <div class="breakAlways"></div>
                    @endif

                    @if($resp_ethical_values != null && $resp_ethical_values->respuestas != null && $resp_ethical_values->respuestas != '')
                        <hr align="left" class="style2">
                        
                        <p class="subtitulo font-size-14">
                            <strong>
                                Prueba Ethical Values
                            </strong>
                        </p>

                        <hr align="left" class="style2">

                        {{-- Gráfico de radar Ethical Values --}}
                        <section>
                            <table class="table" width="100%">
                                <tr>
                                    <td class="textCenter">
                                        <img src="https://quickchart.io/chart?c={{ json_encode($grafico_radar_valores) }}" width="500">
                                    </td>
                                    <td class="textCenter">
                                        <h4>Ajuste del Candidato al Perfil</h4>
                                        <img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="200">
                                        <h4>Factor de desfase</h4>
                                        <h1 style="margin-top: -2rem;">
                                            {{ $dif_porc }}% 

                                            @if ($dif_porc >= 0)
                                                <img  style="margin-top: 1.2rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="85">
                                            @else
                                                <img  style="margin-top: 1.2rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="85">
                                            @endif
                                        </h1>
                                    </td>
                                </tr>
                            </table>
                        </section>

                        <br>
                        <section>
                            <h4>Resultados cualitativos</h4>
                            <div class="text-justify">
                                <p>
                                    {!! $area_mayor !!} {{ $area_menor}}
                                </p>
                            </div>
                            <div class="text-justify">
                                <p>
                                    {{ $textos_cuantitativos['amor']->amor }}
                                </p>
                            </div>
                            <div class="text-justify">
                                <p>
                                    {{ $textos_cuantitativos['no_violencia']->no_violencia }}
                                </p>
                            </div>
                            <div class="text-justify">
                                <p>
                                    {{ $textos_cuantitativos['paz']->paz }}
                                </p>
                            </div>
                            <div class="text-justify">
                                <p>
                                    {{ $textos_cuantitativos['rectitud']->rectitud }}
                                </p>
                            </div>
                            <div class="text-justify">
                                <p>
                                    {{ $textos_cuantitativos['verdad']->verdad }}
                                </p>
                            </div>
                        </section>

                        <?php $concepto_final = $resp_ethical_values->concepto_final; ?>

                        @if($concepto_final != null && $concepto_final != '')
                            <p>
                                <strong>
                                    Concepto del analista sobre la prueba:
                                 </strong>
                            </p>

                            <p class="parrafo">
                                {{ strip_tags($concepto_final) }}
                            </p>
                        @endif

                        <p>
                            <strong>
                                Archivo Adjunto:
                            </strong>
                            <a href="{{url('admin/pdf-prueba-ethical-values/'.$resp_ethical_values->id)}}" target="_blank" class="enlace" >Ver informe Ethical Values</a>
                        </p>
                        <br>
                        <div class="breakAlways"></div>
                    @endif
                @endif

                @if ($resp_bryg != null)
                    <hr align="left" class="style2">
                    
                    <p class="subtitulo font-size-14">
                        <strong>
                            Prueba BRYG-A
                        </strong>
                    </p>

                    <hr align="left" class="style2">

                    <section>
                        <div class="mt-1 mb-1">
                            <p class="textCenter">
                                <b class="color-blue">
                                    SU PERFIL ES 
                                    {{ mb_strtoupper(App\Http\Controllers\PruebaPerfilBrygController::brygPerfilTipo($bryg_definitive_first[0], $bryg_definitive_second[0])) }}
                                </b>
                            </p>

                            <table class="table-result m-auto">
                                <tr>
                                    <th class="bg-blue pd-05 br-05">RADICAL</th>
                                    <th class="bg-red pd-05 br-05">GENUINO</th>
                                    <th class="bg-yellow pd-05 br-05">GARANTE</th>
                                    <th class="bg-green pd-05 br-05">BÁSICO</th>
                                </tr>
                                <tr class="textCenter fw-700">
                                    <td class="pd-05">{{ $resp_bryg->estilo_radical }}</td>
                                    <td class="pd-05">{{ $resp_bryg->estilo_genuino }}</td>
                                    <td class="pd-05">{{ $resp_bryg->estilo_garante }}</td>
                                    <td class="pd-05">{{ $resp_bryg->estilo_basico }}</td>
                                </tr>
                            </table>
                        </div>
                    </section>

                    {{-- Gráfico de radar BRYG --}}
                    <section>
                        <div class="textCenter">
                            <img src="https://quickchart.io/chart?c={{ json_encode($grafico_radar_bryg) }}" width="400">
                        </div>
                    </section>

                    {{-- Explicación gráfico BRYG --}}
                    <section>
                        <div class="parrafo">
                            <p>
                                Encontramos que {{ $datos_basicos->nombres }} tiene un perfil comportamental orientado principalmente a los factores {{ $bryg_definitive_first[0] }} y {{ $bryg_definitive_second[0] }}, por lo cual su perfil es <b class="color-blue">{{ mb_strtoupper(App\Http\Controllers\PruebaPerfilBrygController::brygPerfilTipo($bryg_definitive_first[0], $bryg_definitive_second[0])) }}</b>.
                            </p>
                        </div>
                    </section>

                    {{-- Imagen del tipo de perfil BRYG --}}
                    <section>
                        <div class="textCenter mt-1 mb-1">
                            <img 
                                src="{{ App\Http\Controllers\PruebaPerfilBrygController::brygPerfil($bryg_definitive_first[0], $bryg_definitive_second[0]) }}" 
                                width="450" 
                                alt="Perfil BRYG"
                            >
                        </div>
                    </section>

                    <div class="breakAlways"></div>

                    {{-- Titulo de la sección aumented --}}
                    <section>
                        <p class="textCenter mt-2"><b>Perfil de orientación a la adaptabilidad al cargo.</b></p>
                    </section>

                    {{-- Resultado mini tabla AUMENTED --}}
                    <section>
                        <div class="mt-0 mb-1">
                            <p class="textCenter">
                                <b class="color-blue">
                                    SU ESTILO ES 
                                    {{ mb_strtoupper($aumented_definitive[0]) }}
                                </b>
                            </p>

                            <table class="table-result m-auto">
                                <tr>
                                    <th class="bg-blue-a pd-05 br-05">ANALIZADOR</th>
                                    <th class="bg-yellow-a pd-05 br-05">PROSPECTIVO</th>
                                    <th class="bg-red-a pd-05 br-05">DEFENSIVO</th>
                                    <th class="bg-green-a pd-05 br-05">REACTIVO</th>
                                </tr>
                                <tr class="textCenter fw-700">
                                    <td class="pd-05">{{ $resp_bryg->aumented_a }}</td>
                                    <td class="pd-05">{{ $resp_bryg->aumented_p }}</td>
                                    <td class="pd-05">{{ $resp_bryg->aumented_d }}</td>
                                    <td class="pd-05">{{ $resp_bryg->aumented_r }}</td>
                                </tr>
                            </table>
                        </div>
                    </section>

                    {{-- Gráfico de radar AUMENTED --}}
                    <section>
                        <div class="textCenter">
                            <img src="https://quickchart.io/chart?c={{ json_encode($grafico_radar_aumented) }}" width="400">
                        </div>
                    </section>

                    {{-- Introducción al perfil de adaptabilidad --}}
                    <section>
                        <div class="parrafo">
                            <p>
                                El perfil de orientación de adaptabilidad al cargo, muestra estilo de comportamiento de {{ $datos_basicos->nombres }} frente a determinadas situaciones, en este caso su estilo es <b class="color-blue">{{ mb_strtoupper($aumented_definitive[0]) }}</b>.
                            </p>
                        </div>
                    </section>

                    {{-- Imagen del perfil de adaptabilidad --}}
                    <section>
                        <div class="textCenter mt-1 mb-1">
                            <img 
                                src="{{ App\Http\Controllers\PruebaPerfilBrygController::aumentedPerfil($aumented_definitive[0]) }}" 
                                width="400" 
                                alt="Perfil de adaptabilidad"
                            >
                        </div>
                    </section>

                    <?php
                        $concepto_bryg = App\Http\Controllers\PruebaPerfilBrygController::brygCandidatoConcepto($resp_bryg->id);
                    ?>

                    @if(!empty($concepto_bryg))
                        <p>
                            <strong>
                                Concepto del analista sobre la prueba:
                             </strong>
                        </p>

                        <p class="parrafo">
                            {{ strip_tags($concepto_bryg->concepto) }}
                        </p>
                    @endif

                    <strong>
                        Archivo adjunto:
                    </strong>

                    <a 
                        href="{{ route('admin.prueba_bryg_informe', [$resp_bryg->id]) }}"
                        class="enlace" 
                        target="_blank"
                    >Ver informe BRYG</a>
                @endif
            @endif

            <!-- PRUEBAS -->
            @if($pruebas->count() >= 1)
                <h2>
                    Evaluación Psicométrica
                </h2>


                @foreach($pruebas as $key => $prueba)
                    
                    <hr align="left" class="style2">
                    
                    <p class="subtitulo">
                        <strong>
                            Prueba Realizada
                        </strong>
                        {{ $prueba->prueba_desc }}
                    </p>

                    <hr align="left" class="style2">

                    <p class="parrafo">
                        <strong>
                            Estado:
                        </strong>
                        @if ($prueba->estado == 1)
                            Aprobo
                        @else
                            No aprobo
                        @endif
                        
                        <br/>
                        <!-- 
                            <strong>
                                Calificación
                            </strong>
                            {$prueba->puntaje }}
                        -->
                    </p>

                    <p>
                        <strong>
                            Concepto del analista sobre la prueba:
                         </strong>
                    </p>

                    <p>
                        {!! strip_tags($prueba->resultado) !!}
                    </p>

                    <p>
                        <strong>
                            Fecha Realización:
                        </strong>

                        {{ \App\Models\DatosBasicos::convertirFecha($prueba->updated_at) }}
                        
                        <br/>

                        <strong>
                            Analista quien realizo concepto:
                        </strong>

                        {{ $prueba->name }}<br/>

                        <strong>
                            Archivo Adjunto:
                        </strong>

                        <a href="{{url('recursos_pruebas/'.$prueba->nombre_archivo)}}" target="_blank" class="enlace" >{{ $prueba->nombre_archivo}}</a>
                    </p>
                @endforeach
            @endif

            <?php
                $resp_digitacion = null;

                if(!empty($reqcandidato)) {
                    $resp_digitacion = App\Http\Controllers\PruebaDigitacionController::digitacionCandidato($datos_basicos->user_id, $reqcandidato->requerimiento_id);
                }
            ?>

            @if ($resp_user_excel_basico != null || $resp_user_excel_intermedio != null || $resp_digitacion != null)
                <h2>
                    Pruebas Técnicas
                </h2>

                @if($resp_digitacion != null)
                    <hr align="left" class="style2">
                    
                    <p class="subtitulo">
                        <strong>
                            Prueba Digitación
                        </strong>
                    </p>

                    <hr align="left" class="style2">

                    <?php
                        $concepto_digitacion = App\Http\Controllers\PruebaDigitacionController::digitacionCandidatoConcepto($resp_digitacion->id);
                    ?>
                    @if(!empty($concepto_digitacion))
                        <p>
                            <strong>
                                Concepto del analista sobre la prueba:
                             </strong>
                        </p>

                        <p class="parrafo">
                            {{ strip_tags($concepto_digitacion->concepto) }}
                        </p>
                    @endif

                    <strong>
                        Archivo adjunto:
                    </strong>

                    <a 
                        href="{{ route('admin.prueba_digitacion_informe', [$resp_digitacion->id]) }}"
                        class="enlace" 
                        target="_blank"
                    >Ver informe Digitación</a>
                @endif

                @if($resp_user_excel_basico != null)
                    <hr align="left" class="style2">
                    
                    <p class="subtitulo">
                        <strong>
                            Prueba Excel Básico
                        </strong>
                    </p>

                    <hr align="left" class="style2">

                    <?php $concepto_final = $resp_user_excel_basico->concepto_final; ?>

                    @if($concepto_final != null && $concepto_final != '')
                        <p>
                            <strong>
                                Concepto del analista sobre la prueba:
                             </strong>
                        </p>

                        <p>
                            {{ strip_tags($concepto_final) }}
                        </p>
                    @endif

                    <p>
                        <strong>Calificación obtenida: </strong>{{ $resp_user_excel_basico->calcularCalificacion() }}%
                        <br>
                        <?php
                            $config_prueba_excel = $resp_user_excel_basico->configuracionReq;
                        ?>
                        <strong>Calificación minima: </strong>{{ $config_prueba_excel->aprobacion_excel_basico }}%
                        <br>
                        <strong> Fecha de realización: </strong> {{ \App\Models\DatosBasicos::convertirFecha($resp_user_excel_basico->fecha_respuesta) }}
                        <br>

                        @if($concepto_final != null && $concepto_final != '')
                            <strong>
                                Analista que realizó el concepto:
                            </strong>
                            {{ $resp_user_excel_basico->datosBasicosUsuarioConcepto->nombres . ' ' . $resp_user_excel_basico->datosBasicosUsuarioConcepto->primer_apellido . ' ' . $resp_user_excel_basico->datosBasicosUsuarioConcepto->segundo_apellido }}
                            <br>
                        @endif
                        <strong>
                            Archivo Adjunto:
                        </strong>
                        <a href="{{url('admin/pdf_prueba/'.$resp_user_excel_basico->id)}}" target="_blank" class="enlace" >Respuestas</a>
                    </p>
                @endif

                @if($resp_user_excel_intermedio != null)
                    <hr align="left" class="style2">
                    
                    <p class="subtitulo">
                        <strong>
                            Prueba Excel Intermedio
                        </strong>
                    </p>

                    <hr align="left" class="style2">

                    <?php $concepto_final = $resp_user_excel_intermedio->concepto_final; ?>

                    @if($concepto_final != null && $concepto_final != '')
                        <p>
                            <strong>
                                Concepto del analista sobre la prueba:
                             </strong>
                        </p>

                        <p>
                            {{ strip_tags($concepto_final) }}
                        </p>
                    @endif

                    <p>
                        <strong>
                            Calificación obtenida:
                        </strong>
                        {{ $resp_user_excel_intermedio->calcularCalificacion() }}%
                        <br>
                        <?php
                            $config_prueba_excel = $resp_user_excel_intermedio->configuracionReq;
                        ?>
                        <strong>Calificación minima: </strong>{{ $config_prueba_excel->aprobacion_excel_basico }}%
                        <br>
                        <strong>Fecha de realización: </strong> {{ \App\Models\DatosBasicos::convertirFecha($resp_user_excel_intermedio->fecha_respuesta) }}
                        <br>

                        @if($concepto_final != null && $concepto_final != '')
                            <strong>
                                Analista que realizó el concepto:
                            </strong>
                            {{ $resp_user_excel_intermedio->datosBasicosUsuarioConcepto->nombres . ' ' . $resp_user_excel_intermedio->datosBasicosUsuarioConcepto->primer_apellido . ' ' . $resp_user_excel_intermedio->datosBasicosUsuarioConcepto->segundo_apellido }}
                            <br>
                        @endif
                        <strong>
                            Archivo Adjunto:
                        </strong>
                        <a href="{{url('admin/pdf_prueba/'.$resp_user_excel_intermedio->id)}}" target="_blank" class="enlace" >Respuestas</a>
                    </p>
                @endif
            @endif
    
            <!-- Examenes Medicos -->
            @if($examenes_medicos->count() >= 1)
                <h2>
                    Examenes Medicos
                </h2>

                @foreach($examenes_medicos as $key => $examen)
                    <hr align="left" class="style2">
                    <p class="subtitulo">
                        <strong>
                            Examenes medicos Realizado
                        </strong>
                    </p>
                    <hr align="left" class="style2">
                        <strong>
                            Archivo Adjunto:
                        </strong>
                        <a href="{{url('recursos_documentos_verificados/'.$examen->nombre_archivo)}}" class="enlace" target="_blank">{{ $examen->descripcion_archivo}}</a>
                    
                @endforeach

            @endif
            
            <br>

            <!-- Examenes Medicos -->
            @if($estudio_seguridad->count() >= 1)
              <h2> Estudio Seguridad </h2>
                
                @foreach($estudio_seguridad as $key => $seguridad)
                    <hr align="left" class="style2">
                    <p class="subtitulo">
                        <strong>
                            Estudio Seguridad
                        </strong>
                        {{ $seguridad->descripcion_archivo }}
                    </p>

                    <hr align="left" class="style2">
                    
                    <strong>
                        Archivo Adjunto:
                    </strong>

                    <a href="{{url('recursos_documentos_verificados/'.$seguridad->nombre_archivo)}}" class="enlace" target="_blank">{{ $seguridad->descripcion_archivo}}</a>
                    
                @endforeach
            @endif

            @if(route('home') == "https://vym.t3rsc.co" || route('home') == "https://listos.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                
                <!-- Documentos Cargados f-->
                @if($documentos->count() >= 1)
                    <h2>
                        Documentos Validados
                    </h2>

                    @foreach($documentos as $documento)
                      <hr align="left" class="style2">
                       <p class="subtitulo">
                        <strong>{{$documento->descripcion}}</strong></p>

                      <hr align="left" class="style2">
                        
                       <strong>Archivo Adjunto:</strong>

                        <a href="{{url('recursos_documentos_verificados/'.$documento->nombre_archivo)}}" class="enlace" target="_blank">{{$documento->nombre_archivo}}</a>
                        
                    @endforeach
                @endif

                @if(route('home') == "https://vym.t3rsc.co" || route('home') == "https://listos.t3rsc.co" || route('home') == "http://localhost:8000")
                    @if($generated_status === 'in_progress')

                    @elseif($generated_status === 'not_started')

                    @elseif($generated_status === 'completed')
                        @if($generated_check != null)
                            <h2>
                                Truora Consulta
                            </h2>

                            <hr align="left" class="style2">

                            <strong>Archivo Adjunto:</strong>
                            <a 
                                class="enlace" 
                                target="_blank" 
                                href="{{ route('ver_pdf_truora', ['truora_generated' => $generated_check]) }}"
                            >
                                <span class="fa fa-file" aria-hidden="true"></span> Ver PDF Truora
                            </a>
                        @endif
                    @elseif($generated_status === 'error')
                        @if($generated_check != null)

                        @endif
                    @else
                    @endif
                @endif
            @endif

            {{-- Tusdatos.co --}}
            @if($sitioModulo->consulta_tusdatos == 'enabled')
                @if(!empty($tusdatosData))
                    <h2>
                        Consulta de Seguridad
                    </h2>

                    <hr align="left" class="style2">

                    @if ($tusdatosData->status == 'procesando')
                        {{-- nada --}}
                    @elseif($tusdatosData->status == 'finalizado')
                        <strong>Archivo adjunto:</strong>
                        <a 
                            class="enlace" 
                            target="_blank" 
                            href="{{ route('tusdatos_reporte', ['check' => $tusdatosData->id]) }}"
                        >
                            <span class="fa fa-file" aria-hidden="true"></span> Ver PDF
                        </a>
                    @else
                        {{-- nada --}}
                    @endif
                @endif
            @endif

            @if($sitioModulo->consulta_seguridad == 'enabled')
                @if($consulta_seg !== null)
                    @if($consulta_seg->count() >= 1)
                        <h2>
                            Consulta de Seguridad
                        </h2>

                        <hr align="left" class="style2">

                        <strong>Archivo Adjunto:</strong>
                        <a class="enlace" target="_blank" href="{{ url('recursos_pdf_consulta/'.$consulta_seg->pdf_consulta_file) }}">
                            <span class="fa fa-file" aria-hidden="true"></span> Ver PDF Consulta Seguridad
                        </a>
                    @endif
                @endif
            @endif

            <!-- REFERENCIACION -->
            @if ($experiencias_verificadas->count() >= 1)
            
                <h2> Referenciación </h2>

                @foreach ($experiencias_verificadas as $exp)
                  <hr align="left" class="style2">
                   <p class="subtitulo">
                    <strong> Referencia realizada a la experiencia en {{ ucwords(mb_strtolower($exp->nombre_empresa)) }} </strong>
                    </p>

                    <hr align="left" class="style2">
                    
                    <p class="parrafo">
                    
                        @if ($exp->fecha_retiro != '0000-00-00' &&  $exp->fecha_retiro != null)

                            {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeñó en el cargo {{ mb_strtolower($exp->cargo2) }}, durante {{ \App\Models\Experiencias::añosMeses($exp->fecha_inicio, $exp->exp_fechafin)}}, 
                                     iniciando sus labores el {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_inicio) }} hasta  {{ \App\Models\DatosBasicos::convertirFecha($exp->exp_fechafin) }} bajo la supervisión de {{ ucwords(mb_strtolower($exp->nombres_jefe)) }}
                                    @if ($exp->fijo_jefe > 0)
                                        (Tel. {{ $exp->fijo_jefe }} / {{ $exp->movil_jefe }})
                                    @elseif( isset($exp->movil_jefe) && $exp->movil_jefe != "" )
                                        (Tel. {{ $exp->movil_jefe }})
                                    @endif
                                    quien ejercía como {{ $exp->cargo_jefe }}.
                        @else

                            {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeña en el cargo {{ mb_strtolower($exp->cargo2) }}, 
                                iniciando sus labores el {{ \App\Models\DatosBasicos::convertirFecha($exp->exp_fecha_inicio) }} bajo la supervisión de {{ ucwords(mb_strtolower($exp->nombres_jefe)) }}
                                @if ($exp->fijo_jefe > 0)
                                        (Tel. {{ $exp->fijo_jefe }} / {{ $exp->movil_jefe }})
                                @elseif( isset($exp->movil_jefe) && $exp->movil_jefe != "" )
                                        (Tel. {{ $exp->movil_jefe }})
                                @endif
                                    quien ejerce como {{ $exp->cargo_jefe }}.
                        @endif

                    </p>

                    <p class="parrafo">
                      <strong> Realizando el proceso de referenciación se encontró que: </strong>
                        <br/><br/>
                        - La experiencia se referenció con {{ ucwords(mb_strtolower($exp->nombre_referenciante)) }} quien se desempeña como {{ mb_strtolower($exp->cargo_referenciante) }}.
                        <br/>
                        @if( isset($exp->vinculo_familiar) && $exp->vinculo_familiar == 'si' )
                            - El referenciante indica que su vínculo familiar con el candidato es: {!! $exp->vinculo_familiar_cual !!}
                        @else
                            - El referenciante indica que no tiene vínculo familiar con el candidato
                        @endif
                        <br/>
                        @if($exp->name_motivo != '')
                            - La información suministrada por el referenciante indica que el motivo de retiro obedeció a {{mb_strtolower($exp->name_motivo)}}
                        @endif

                        @if($exp->observaciones)
                         argumentando las siguientes observaciones: {{$exp->observaciones}}.
                        @else
                        .
                        @endif
                        
                        <br/>

                        @if( isset($exp->anotacion_hv) && $exp->anotacion_hv == 'si' )
                            - Las anotaciones en su hoja de vida son: {{$exp->cuales_anotacion}} 
                        @else
                            - {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} no  @if ($exp->fecha_retiro != '0000-00-00' &&  $exp->fecha_retiro != null) tuvo @else tiene @endif anotaciones en su hoja de vida. 
                        @endif
                        <br/>
                        
                        -{{ ucwords(mb_strtolower($datos_basicos->nombres)) }}
                        @if($exp->cuantas_personas)
                            @if ($exp->fecha_retiro != '0000-00-00' &&  $exp->fecha_retiro != null) tuvo @else tiene @endif {{ $exp->cuantas_personas }} personas a cargo.
                        @else
                          no  @if ($exp->fecha_retiro != '0000-00-00' &&  $exp->fecha_retiro != null) tuvo @else tiene @endif personas a cargo.
                        @endif
                        <br/>


                        - El referenciante considera que @if( isset($exp->adecuado) && $exp->adecuado == 'adecuado' ) si @else no @endif es adecuado para el cargo y que
                            @if($exp->volver_contratarlo) si @else no @endif
                            volvería a contratarlo porque:
                            <br/> 
                            {{mb_strtolower($exp->porque_obj)}}.
                    </p>


                    @if($exp->observaciones_referencias)

                        <p class="parrafo">
                         <strong> Observaciones Generales de la referenciación </strong>
                        </p>
                    
                        <p class="parrafo"> {{ $exp->observaciones_referencias }} </p>
                        
                        <br/><br/>

                    @endif
                    
                @endforeach
            @endif

            <!-- Validacion documental -->
            @if (count($validacion_documental) >= 1)

                <h2> Validación documental </h2>

                @foreach ($validacion_documental as $doc)
                    <hr align="left" class="style2">

                    <p class="parrafo">
                        <strong> Tipo de documento: </strong>
                        {{$doc->tipo_doc }}
                        <br>
                        <strong> Resultado: </strong>
                        @if ($doc->resultado == '1')
                            Apto
                        @elseif ($doc->resultado == '2')
                            No apto
                        @endif
                        <br>
                        @if ($doc->fecha_vencimiento != null && $doc->fecha_vencimiento != '0000-00-00')
                            <strong> Fecha vencimiento: </strong>
                            {{ $doc->fecha_vencimiento }}
                            <br>
                        @endif
                    </p>
                    <p class="parrafo">
                        <strong> Observación: </strong>
                        {{ $doc->observacion }}
                        <br>
                        <strong> Archivo: </strong>
                        <a href="{{url('recursos_documentos_verificados/'.$doc->nombre_archivo)}}" class="enlace" target="_blank">Archivo</a>
                        <br/>
                    </p>
                @endforeach
            @endif

        @else
    
            <!-- //////////////////////////////////////// INFORME DE SELECCION //////////////////////////////////////// -->
            @if($reqcandidato != null)
                <br><br><br>
                <div></div>

                <h3 style="color: #377cfc" class="titulo-center">
                    Informe de selección de {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} {{ ucwords(mb_strtolower($datos_basicos->primer_apellido)) }} {{ ucwords(mb_strtolower($datos_basicos->segundo_apellido)) }} referente al cargo {{ ucwords(mb_strtolower($reqcandidato->descripcion)) }} para el requerimiento {{ $reqcandidato->requerimiento_id }}
                </h3>
            @endif

            @if($entrevistas->count() >= 1)

                @foreach($entrevistas as $key => $entrevista)
                    <h4 style="color: #377cfc" >
                        Entrevista {{ \App\Models\DatosBasicos::convertirFecha($entrevista->created_at) }}
                    </h4>
                
                    @if ($entrevista->apto != "")
                      <hr align="left" class="style2">
                        <p class="subtitulo">
                         <strong> Apto</strong>
                        </p>
                        <p class="parrafo">
                         {{($entrevista->apto == 1)?'Apto':'No Apto'}}
                        </p>
                    @endif

                    @if ($entrevista->aspecto_familiar != "")
                        <hr align="left" class="style2">
                        
                        <p class="subtitulo">
                            <strong>
                                Aspecto Familiar
                            </strong>
                        </p>

                        <p class="parrafo">
                            {{ $entrevista->aspecto_familiar }}
                        </p>
                    @endif
               
                    @if ($entrevista->aspecto_academico != "")
                        <p class="subtitulo">
                            <strong>
                                Aspectos Académicos
                            </strong>
                        </p>
                        
                        <p class="parrafo">
                            {{ $entrevista->aspecto_academico }}
                        </p>
                    @endif
                
                    @if ($entrevista->aspectos_experiencia != "")
                        <p class="subtitulo">
                            <strong>
                                Aspectos Experiencia
                            </strong>
                        </p>
                        <p class="parrafo">
                            {{ $entrevista->aspectos_experiencia }}
                        </p>
                    @endif
             
                    @if ($entrevista->aspectos_personalidad != "")
                        <p class="subtitulo">
                            <strong>
                                Aspectos de Personalidad @if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co") , Fortalezas y Oportunidades de mejoras Frente al Cargo @endif
                            </strong>
                        </p>
                        <p class="parrafo">
                            {{ $entrevista->aspectos_personalidad }}
                        </p>
                    @endif
                
                    @if ($entrevista->fortalezas_cargo != "")
                        <p class="subtitulo">
                            <strong>
                              @if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co") Conflicto Intereses @else  Fortalezas frente al Cargo @endif
                            </strong>
                        </p>
                        <p class="parrafo">
                            {{ $entrevista->fortalezas_cargo }}
                        </p>
                    @endif
              
                    @if ($entrevista->oportunidad_cargo != "")
                        <p class="subtitulo">
                            <strong>
                             @if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co") Conflicto Entrevistador @else Oportunidades de mejora frente al cargo @endif
                            </strong>
                        </p>
                        <p class="parrafo">
                          {{ $entrevista->oportunidad_cargo }}
                        </p>
                    @endif
                
                    @if ($entrevista->concepto_general != "")
                        <p class="subtitulo">
                            <strong>
                                Concepto General
                            </strong>
                        </p>
                        <p class="parrafo">
                            {{ $entrevista->concepto_general }}
                        </p>
                    @endif

                    @if ($entrevista->evaluacion_competencias != "")
                        <p class="subtitulo">
                            <strong>
                                Evaluación de competencias
                            </strong>
                        </p>
                        <p class="parrafo">
                            {{ $entrevista->evaluacion_competencias}}
                        </p>
                    @endif

                    <!--FIRMAR -->
                    <h1>
                        __________________
                    </h1>
                
                    <p>
                        {{ $entrevista->getNamePsicologo()}}
                    </p>
                    <p>
                        Fecha de finalización {{ \App\Models\DatosBasicos::convertirFecha($entrevista->updated_at) }}
                    </p>
                @endforeach
            @endif

            @if($referencias->count() >= 1)
                @foreach($referencias as $key => $referencia)
                    <h4 style="color: #377cfc" >Referencia {{$referencia->id}}</h4>

                    @if($referencia->tipo_relacion != "")
                        <hr align="left" class="style2">
                        <p class="subtitulo">
                            <strong>{{$referencia->nombres}} {{$referencia->primer_apellido}} {{$referencia->segundo_apellido}}</strong>
                        </p>
                        <p class="subtitulo">
                            <strong>{{$referencia->tipo_relacion->descripcion}}</strong>
                        </p>
                        <p class="parrafo">{{$referencia->telefono_movil}}</p>
                    @endif
               
                <!--FIRMAR -->
                @endforeach
            @endif

            <!-- Prueba BRYG -->
            @if(!empty($reqcandidato))
                @if(!empty(App\Http\Controllers\PruebaPerfilBrygController::brygCandidato($datos_basicos->user_id, $reqcandidato->requerimiento_id)))
                    <?php
                        $brygId = App\Http\Controllers\PruebaPerfilBrygController::brygCandidato($datos_basicos->user_id, $reqcandidato->requerimiento_id)->id;
                    ?>

                    <h2>
                        Prueba BRYG-A
                    </h2>

                    <hr align="left" class="style2">

                    @if(!empty(App\Http\Controllers\PruebaPerfilBrygController::brygCandidatoConcepto($brygId)))
                        <p class="parrafo">
                            {!! App\Http\Controllers\PruebaPerfilBrygController::brygCandidatoConcepto($brygId)->concepto !!}
                        </p>
                    @endif

                    <p class="subtitulo">
                        <strong>
                            Informe BRYG-A
                        </strong>
                    </p>

                    <hr align="left" class="style2">

                    <strong>
                        Archivo adjunto:
                    </strong>

                    <a 
                        href="{{ route('admin.prueba_bryg_informe', [App\Http\Controllers\PruebaPerfilBrygController::brygCandidato($datos_basicos->user_id, $reqcandidato->requerimiento_id)->id]) }}"
                        class="enlace" 
                        target="_blank"
                    >Ver informe BRYG</a>
                @endif
            @endif

            {{-- Prueba Digitación --}}
            @if(!empty(App\Http\Controllers\PruebaDigitacionController::digitacionCandidato($datos_basicos->user_id, $reqcandidato->requerimiento_id)))
                <?php
                    $digitacionId = App\Http\Controllers\PruebaDigitacionController::digitacionCandidato($datos_basicos->user_id, $reqcandidato->requerimiento_id)->id;
                ?>

                <h2>
                    Prueba Digitación
                </h2>

                <hr align="left" class="style2">

                @if(!empty(App\Http\Controllers\PruebaDigitacionController::digitacionCandidatoConcepto($digitacionId)))
                    <p class="parrafo">
                        {!! App\Http\Controllers\PruebaDigitacionController::digitacionCandidatoConcepto($digitacionId)->concepto !!}
                    </p>
                @endif

                <p class="subtitulo">
                    <strong>
                        Informe Digitación
                    </strong>
                </p>

                <hr align="left" class="style2">

                <strong>
                    Archivo adjunto:
                </strong>

                <a 
                    href="{{ route('admin.prueba_digitacion_informe', [App\Http\Controllers\PruebaDigitacionController::digitacionCandidato($datos_basicos->user_id, $reqcandidato->requerimiento_id)->id]) }}"
                    class="enlace" 
                    target="_blank"
                >Ver informe Digitación</a>
            @endif

            <!-- PRUEBAS -->
            @if($pruebas->count() >= 1)
                <h4 style="color: #377cfc">
                    Evaluación Psicométrica
                </h4>

                @foreach($pruebas as $key => $prueba)
                    <hr align="left" class="style2">
                    <p class="subtitulo">
                        <strong>
                            Prueba Realizada
                        </strong>
                        {{ $prueba->prueba_desc }}
                    </p>
                
                    <hr align="left" class="style2">

                    <p class="parrafo">
                        <strong>
                            Estado:
                        </strong>
                        
                        @if ($prueba->estado == 1)
                            Aprobo
                        @else
                            No aprobo
                        @endif
                        <br/>
                        <!-- 
                            <strong>
                                Calificación
                            </strong>
                            {$prueba->puntaje }}
                        -->
                    </p>

                    <p class="parrafo">
                        <strong>
                            Concepto del psicólogo sobre la prueba:
                        </strong>
                    </p>

                    <p class="parrafo">
                        {!! $prueba->resultado !!}
                    </p>
                    
                    <p class="parrafo">
                        <strong>
                            Fecha Realización:
                        </strong>
                        {{ \App\Models\DatosBasicos::convertirFecha($prueba->updated_at) }}
                        <br/>
                        <strong>
                            Psicologo quien realizo concepto:
                        </strong>
                        {{ $prueba->name }}
                    </p>
                @endforeach
            @endif

            <!-- REFERENCIACION -->
            @if ($experiencias_verificadas->count() >= 1)
                <h4 style="color: #377cfc">
                    Referenciación
                </h4>

                @foreach ($experiencias_verificadas as $exp)
                    <hr align="left" class="style2">
                    <p class="subtitulo">
                        <strong>
                            Referencia realizada a la experiencia en {{ ucwords(mb_strtolower($exp->nombre_empresa)) }}
                        </strong>
                    </p>

                    <hr align="left" class="style2">

                    <p class="parrafo">
                        @if ($exp->empleo_actual != 1)
                            {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeñó en el cargo {{ mb_strtolower($exp->cargo_especifico) }}, durante {{ \App\Models\Experiencias::añosMeses($exp->exp_fecha_inicio, $exp->exp_fechafin) }}, 
                                 iniciando sus labores el {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_inicio) }} hasta  {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_retiro) }} bajo la supervisión de {{ ucwords(mb_strtolower($exp->nombres_jefe)) }}
                            @if ($exp->fijo_jefe > 0)
                                (Tel. {{ $exp->fijo_jefe }} / {{ $exp->movil_jefe }})
                            @else
                                (Tel. {{ $exp->movil_jefe }})
                            @endif
                            quien ejercía como {{ $exp->cargo_jefe }}.
                        @else
                            {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeña en el cargo {{ mb_strtolower($exp->cargo_especifico) }}, durante {{ \App\Models\Experiencias::añosMeses($exp->exp_fecha_inicio, $exp->exp_fechafin) }}, 
                                iniciando sus labores el {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_inicio) }} bajo la supervisión de {{ ucwords(mb_strtolower($exp->nombres_jefe)) }}
                            @if ($exp->fijo_jefe > 0)
                                (Tel. {{ $exp->fijo_jefe }} / {{ $exp->movil_jefe }})
                            @else
                                (Tel. {{ $exp->movil_jefe }})
                            @endif
                                quien ejercía como {{ $exp->cargo_jefe }}.
                        @endif
                    </p>

                    <p class="parrafo">
                        <strong>
                            Realizando el proceso de referenciación se encontró qué:
                        </strong>

                        <br/><br/>

                        - La experiencia se referenció con {{ ucwords(mb_strtolower($exp->nombre_referenciante)) }} quien se desempeña como {{ mb_strtolower($exp->cargo_referenciante) }} y de acuerdo con los datos recopilados, <strong>se determina que {{ ucwords(mb_strtolower($datos_basicos->nombres)) }}
                        @if ($exp->adecuado)
                            es adecuado.
                        @else
                            no es adecuado.
                        @endif </strong>
                        <br/>
                       @if($exp->name_motivo != '')
                        - La información suministrada por el referenciante indica que el motivo de retiro obedeció a {{ mb_strtolower($exp->name_motivo) }}
                       @endif

                        @if($exp->observaciones)
                         argumentando las siguientes observaciones; {{ $exp->observaciones }}.
                        @else .

                        @endif
                        <br/>
                        - {{ ucwords(mb_strtolower($datos_basicos->nombres)) }}
                        @if ($exp->cuantas_personas)
                            tuvo {{ $exp->cuantas_personas }} personas a cargo,
                        @else
                            no tuvo personas a cargo,
                        @endif
                        el referenciante considera que

                        @if($exp->volver_contratarlo)
                            si
                        @else
                            no
                        @endif
                        volvería a contratarlo porque {{ mb_strtolower($exp->porque_obj) }}.
                    </p>

                    <p class="parrafo">
                      <strong> Información suministrada por Recursos Humanos </strong>
                    </p>

                    <p class="parrafo">
                      <strong> -Cargo desempeñado: </strong>
                        {{$exp->cargo2}}
                        <br/>
                        <strong> -Fecha de inicio: </strong>
                         {{\App\Models\DatosBasicos::convertirFecha($exp->fecha_inicio) }}
                        <br/>
                        @if($exp->fecha_retiro > 0)
                            <strong>
                                -Fecha de finalización:
                            </strong>
                            {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_retiro) }}
                            <br/>
                        @endif
                        <strong>
                          @if ($exp->anotacion_hv)
                           -La anotación que tiene en la hoja de vida es:
                          @else
                           -No tiene anotaciones en la hoja de vida.
                          @endif
                        </strong>
                        @if($exp->cuales_anotacion)
                          {{ $exp->cuales_anotacion }}
                        @endif
                    </p>

                  @if($exp->observaciones_referencias)
                    <p class="parrafo">
                      <strong> Observaciones Generales de la referenciación </strong>
                    </p>

                    <p class="parrafo">
                     {{$exp->observaciones_referencias }}
                    </p>
                    <br/><br/>

                  @endif
                @endforeach
            @endif

            <!-- Validacion documental -->
            @if (count($validacion_documental) >= 1)

                <h2> Validación documental </h2>

                @foreach ($validacion_documental as $doc)
                    <hr align="left" class="style2">

                    <p class="parrafo">
                        <strong> Tipo de documento: </strong>
                        {{$doc->tipo_doc }}
                        <br>
                        <strong> Resultado: </strong>
                        @if ($doc->resultado == '1')
                            Apto
                        @elseif ($doc->resultado == '2')
                            No apto
                        @endif
                        <br>
                        @if ($doc->fecha_vencimiento != null && $doc->fecha_vencimiento != '0000-00-00')
                            <strong> Fecha vencimiento: </strong>
                            {{ $doc->fecha_vencimiento }}
                            <br>
                        @endif
                    </p>
                    <p class="parrafo">
                        <strong> Observación: </strong>
                        {{ $doc->observacion }}
                        <br>
                        <strong> Archivo: </strong>
                        <a href="{{url('recursos_documentos_verificados/'.$doc->nombre_archivo)}}" class="enlace" target="_blank">Archivo</a>
                        <br/>
                    </p>
                @endforeach
            @endif

        @endif  
        
        <!-- REFERENCIA ESTUDIOS-->
            @if ($referencias_estudios_verificados->count() >= 1)
                <h2>
                    Referenciación académica
                </h2>

                @foreach ($referencias_estudios_verificados as $estudio)
                    <hr align="left" class="style2">
                    <p class="subtitulo">
                        <strong>
                            Referencia realizada como {{$estudio->titulo_obtenido}} en {{$estudio->institucion}}
                        </strong>
                    </p>

                    <hr align="left" class="style2">

                    <p class="parrafo">
                        Lorena @if( $estudio->estudio_actual ) realiza @else realizó @endif sus estudios como {{$estudio->nivel}} en el 
                        programa de {{$estudio->programa}} en la institución {{$estudio->institucion}}, desde {{$estudio->fecha_inicio}} 
                        hasta {{$estudio->fecha_finalizacion}}, @if( $estudio->estudio_actual ) para obtener @else obteniendo @endif 
                        el título de {{$estudio->titulo_obtenido}}.
                        <br/>
                        @if( $estudio->nombre_referenciante != null )
                            El estudio fue referenciado por {{$estudio->nombre_referenciante}} quien se desempeña como 
                            {{$estudio->cargo_referenciante}} en la institución {{$estudio->institucion}}.
                            <br/>
                            Las observaciones generales de la referenciación académica son: {{$estudio->observaciones_referenciante}}.
                        @else

                            El estudio fue referenciado por recursos humanos de {{$sitio->nombre}} y las observaciones generales de la referencia son:
                            {!! $estudio->observaciones_referenciante !!}

                        @endif
                    </p>
                @endforeach
            @endif
        

        <!-- REFERENCIACION VERIFICADA -->
        @if(count($rpv)>0)
          <h4 style="color: #377cfc"> Referenciación </h4>
            
            <table class="table">
                
                <tr class="textLeft" style="">
                    <td>Encuestado</td>
                    <td>{{--{{$rpv->encuestado}}--}}</td>
                </tr>

                <tr class="textLeft" style="">
                    <td><strong>Reaccion Ante Dificultades</strong></td>
                    <td>{{$rpv->dificultades}}</td>
                </tr>

                <tr class="textLeft" style="">
                    <td><strong>Su Mejor Cualidad</strong></td>
                    <td>{{$rpv->cualidades}}</td>
                </tr>

                <tr class="textLeft" style="">
                    <td><strong>Manifiesta Sus Desacuerdos</strong></td>
                    <td>{{$rpv->desacuerdo}}</td>
                </tr>

                <tr class="textLeft" style="">
                    <td><strong>Debe Mejorar</strong></td>
                    <td>{{$rpv->debe_mejorar}}</td>
                </tr>

                <tr class="textLeft" style="">
                    <td><strong>Sus Relaciones Interpersonales</strong></td>
                    <td>{{$rpv->relaciones_interpersonales}}</td>
                </tr>
            </table>
        @endif 

        <!--  PIE -->
        <footer>
         <div style="position: relative;">
           <img alt="Logo T3RS" class="izquierda" height="25" src="{{url('img/t3.png')}}" width="20"> www.t3rsc.co

           {{--@if(!is_null($reqcandidato->logo_empresa) && $reqcandidato->logo_empresa != "")
                  <img class="logo_derecha" alt="Logo empresa"  height="50" width="95" src='{{ asset("configuracion_sitio/$reqcandidato->logo_empresa")}}'>
           @elseif($logo!="")
                  <img class="logo_derecha" alt="Logo empresa"  height="50" width="95" src="{{ url('configuracion_sitio/'.$logo)}}">
            @else
                  <img class="logo_derecha" alt="Logo empresa"  height="50" width="95" src="{{url('img/logo.png')}}">
            @endif--}}

                
         </div>
        </footer>
        
    </body>
</html>