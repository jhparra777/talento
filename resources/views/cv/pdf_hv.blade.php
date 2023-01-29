<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title> Hoja de Vida - T3RS </title>
        <style type="text/css">
            @page { margin: 50px 70px; }
            .page-break {
              page-break-after: always;
            }

            table {
              border-collapse: collapse;
              width: 100%;
              padding: 0;
              margin: 0;
            }

            #g-tr{
              margin-bottom: 90px;
              padding-bottom: 90px;
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

            .parrafo {
             padding-left: 65px
            }
        </style>
    </head>
    <body>
        <!-- Validar si el usuario es rol ADMIn para poder ver si el candidato tiene problemas de seguridad -->
        @if(Sentinel::check()->inRole("admin"))
        <!-- Validamos si el candidato esta con estado 5 que hace referencia a problemas de seguridad -->
          @if($datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD'))
            <div class="classname">
              !!
            </div>
          @endif
        @endif

        <table width="100%">
            <!-- FL-1 -->
            <tr id="g-tr">
                <!-- Col-3 -->
                <td colspan="2" width="20%">
                  @if(!is_null($logo) && $logo != "")
                      <img style="max-width: 200px" src='{{ asset("configuracion_sitio/$logo")}}'>
                  @else
                      <img style="max-width: 200px" src="{{url('configuracion_sitio/logo_cargado.png')}}">
                  @endif
                </td>
                <!-- Col-6 -->
                <td colspan="3" width="20%" >
                  <address style="text-align: center;" >
                  <strong>
                   {{ucwords(mb_strtolower($datos_basicos->nombres))}} {{ucwords(mb_strtolower($datos_basicos->primer_apellido)) }} {{ ucwords(mb_strtolower($datos_basicos->segundo_apellido)) }}
                   
                    @if($user->video_perfil !=null)
                      <br>
                       <a target="_blank" style="text-decoration:none;color:#377cfc;" href='{{ route("view_document_url", encrypt("recursos_videoperfil/|".$user->video_perfil)) }}' >Video Perfil </a>
                    @endif

                      @if(!empty($archivo))
                       <br>
                       <a target="_blank" style="text-decoration:none;color:#377cfc;" href="{{asset('recursos_documentos/'.$archivo->nombre_archivo)}}" > Hoja de Vida </a>
                      @endif          
                  </strong>
                  <br/>
                   {{$edad}} Años
                   <br/>
                      {{$datos_basicos->telefono_movil}}
                     
                     @if($datos_basicos->telefono_fijo != '')
                      -{{$datos_basicos->telefono_fijo}}
                     @endif
                    <br/>
                      {{$datos_basicos->email}}
                      <br/>
                      
                      @if($datos_basicos->ciudad_residencia != '')
                       {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_residencia, $datos_basicos->departamento_residencia, $datos_basicos->ciudad_residencia) }}
                      @endif
                        <br/>

                    @if(route("home")=="http://colpatria.t3rsc.co" || route("home")=="https://colpatria.t3rsc.co")
                      @if($datos_basicos->direccion!= '')
                        {{$datos_basicos->direccion}}
                      @endif
                    @endif
                        <br/>
                  </address>
                </td>
                <!-- Col-3 -->
                <td colspan="3" width="20%">
                  @if($user->foto_perfil != "")
                   <img align="right" style="border-radius: 350%;" alt="user photo" height="109" src="{{url('recursos_datosbasicos/'.$user->foto_perfil)}}" width="109"/>
                  @elseif($user->avatar != "")
                   <img align="right" style="border-radius: 350%;" alt="user photo" height="109" src="{{$user->avatar}}" width="109"/>
                  @else
                   <img align="right" style="border-radius: 350%;" alt="user photo" height="109" src="{{url('img/personaDefectoG.jpg')}}" width="109"/>
                  @endif
                </td>
            </tr>
        </table>
        <!-- FL-2 -->
        @if ($datos_basicos->descrip_profesional != '')
          @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
            <table width="100%">
              <tr>
                <td colspan="12" >
                  <h2> Perfil </h2>
                   <hr align="right" class="style2">
                    <table width="100%">
                     <tr>
                      <td colspan="10" width="95%">
                       <p> {{$datos_basicos->descrip_profesional}} </p>
                      </td>
                     </tr>
                    </table>
                </td>
              </tr>
            </table>
         @endif
        @endif

            <!-- FL-3 -->
        <table width="100%">
          <tr>
            <td colspan="12">
             <h2> Información Personal </h2>
              <hr align="right" class="style2">
                <table width="100%">
                  <tr>
                   <td colspan="2" width="95%">
                     <p>

                       {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se identifica con la {{ mb_strtolower($datos_basicos->dec_tipo_doc) }} número {{ number_format($datos_basicos->numero_id) }} de la ciudad de  {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_id, $datos_basicos->departamento_expedicion_id, $datos_basicos->ciudad_expedicion_id) }},

                        @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
                         cuyo género es {{mb_strtolower($datos_basicos->genero_desc) }}, su estado civil es {{mb_strtolower($datos_basicos->estado_civil_des) }} y
                        @endif

                        tiene una aspiración salarial {{ strtolower($datos_basicos->aspiracion_salarial_des) }}. Reside actualmente en la ciudad de {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_residencia, $datos_basicos->departamento_residencia, $datos_basicos->ciudad_residencia) }}

                        @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
                         , en la dirección {{ mb_strtolower($datos_basicos->direccion) }}
                        @endif .
                      </p>
                                <p>
                                 @if(!empty($datos_basicos->maximoEstudio()))
                                   @if(!empty($datos_basicos->maximoEstudio()->estudio_actual))
                                        
                                    El nivel máximo de estudios registrado es {{ mb_strtolower($datos_basicos->maximoEstudio()->descripcion) }} y el titulo obtenido es {{ mb_strtolower($datos_basicos->maximoEstudio()->titulo_obtenido) }} en {{ ucwords(mb_strtolower($datos_basicos->maximoEstudio()->institucion)) }}, el cual finalizó el {{ \App\Models\DatosBasicos::convertirFecha($datos_basicos->maximoEstudio()->fecha_finalizacion) }} en la ciudad de {{ \App\Models\Ciudad::GetCiudad($datos_basicos->maximoEstudio()->pais_estudio, $datos_basicos->maximoEstudio()->departamento_estudio, $datos_basicos->maximoEstudio()->ciudad_estudio) }}.
                                            
                                   @endif
                                 @endif
                                </p>
                                <p> 
                                    @if($experienciaMayorDuracion)
                                      @if($experienciaMayorDuracion->empleo_actual == 1)
                                       
                                       Su experiencia más extensa fue en la empresa {{ ucwords(mb_strtolower($experienciaMayorDuracion->nombre_empresa)) }}, donde se desempeña como {{ mb_strtolower($experienciaMayorDuracion->cargo_especifico) }} por un periodo de {{ \App\Models\Experiencias::añosMeses($experienciaMayorDuracion->fecha_inicio, $experienciaMayorDuracion->fecha_final) }}. Su experiencia laboral más reciente es en {{ ucwords(mb_strtolower($experienciaActual->nombre_empresa)) }}, desempeñándose como {{ mb_strtolower($experienciaActual->cargo_especifico) }} devengando de {{ mb_strtolower($experienciaActual->salario) }}.
                                       Actualmente se encuentra laborando.
                                      
                                      @else
                                      
                                      Su experiencia más extensa fue en la empresa {{ ucwords(mb_strtolower($experienciaMayorDuracion->nombre_empresa)) }}, donde se desempeñó como {{ mb_strtolower($experienciaMayorDuracion->cargo_especifico) }} por un periodo de {{ \App\Models\Experiencias::añosMeses($experienciaMayorDuracion->fecha_inicio, $experienciaMayorDuracion->fecha_final) }}. Su experiencia laboral más reciente fue en {{ ucwords(mb_strtolower($experienciaActual->nombre_empresa)) }}, desempeñándose como {{ mb_strtolower($experienciaActual->cargo_especifico) }} devengando de {{ mb_strtolower($experienciaActual->salario) }}.
                                      @endif
                                    @endif
                                </p>
                                
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    @if($idiomas->count() >= 1)
      <h2>Idiomas</h2>

      <hr align="right" class="style2">
      @foreach($idiomas as $idioma)
       <p class="parrafo">
        <strong>{{ $idioma->nombre_idioma->descripcion}}</strong>
        <span>@if($idioma->nivel_idioma) 
        {{$idioma->nivel_idioma->descripcion}} @endif </span>
       </p>
      @endforeach

    @endif

    @if(route('home')=="http://komatsu.t3rsc.co")
        <table width="100%">
            <tr>
              <td colspan="12">
                <h2> Información Komatsu </h2>
                    <hr align="right" class="style2">
                    <table width="100%">
                        <tr>
                          <td colspan="2" width="5%">
                          <!-- Para ajustar  el de abajo -->
                          </td>
                         <br><br>
                          <td colspan="10" width="95%">
       
                             @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
                             
                              @if($datos_basicos->hijos ==1)
                               {{ucwords(mb_strtolower($datos_basicos->nombres))}} tiene  {{$datos_basicos->numero_hijos}} hijos,
                              @else
                                {{ucwords(mb_strtolower($datos_basicos->nombres))}} no tiene hijos,   
                              @endif
                             
                             @endif
                             
                             @if($datos_basicos->viaje==1)
                              cuenta disponibilidad para desplazarse de su lugar de residencia,
                             @else
                              no tiene disponibilidad para desplazarse de su lugar de residencia 
                             @endif
                             
                             @if($datos_basicos->conocenos)
                              conoce a Komatsu por "{{$datos_basicos->conocenos}}"
                             @endif
                              
                              @if($datos_basicos->conflicto)
                               posee conflicto de intereses porque "{{$datos_basicos->descripcion_conflicto}}"
                              @else
                               no posee conflicto de intereses.
                              @endif
                              </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    @endif

    <!-- ESTUDIOS -->
    @if($estudios->count() >= 1)
        <div style="page-break-after:always;"></div>
        
        <h2>Estudios</h2>
        
        <hr align="right" class="style2">
        
        @foreach($estudios as $estudio)
            <p class="subtitulo">
                <strong>{{  ucwords(mb_strtolower($estudio->desc_nivel)) }}</strong>
            </p>

            <p class="parrafo">
                @if ($estudio->estudio_actual)
                  {{ucwords(mb_strtolower($datos_basicos->nombres))}} está realizando el {{ mb_strtolower($estudio->desc_nivel) }} en {{ ucwords(mb_strtolower($estudio->institucion)) }} de la ciudad de {{ \App\Models\Ciudad::GetCiudad($estudio->pais_estudio, $estudio->departamento_estudio, $estudio->ciudad_estudio) }}, cursando {{ $estudio->semestres_cursados }} periodos hasta el momento,  el título por obtener es {{ ucwords(mb_strtolower($estudio->titulo_obtenido)) }}.
                @else
                  {{ucwords(mb_strtolower($datos_basicos->nombres))}} realizó sus estudios de {{ mb_strtolower($estudio->desc_nivel) }} en {{ ucwords(mb_strtolower($estudio->institucion)) }} de la ciudad de {{ \App\Models\Ciudad::GetCiudad($estudio->pais_estudio, $estudio->departamento_estudio, $estudio->ciudad_estudio) }}, cursando {{ $estudio->semestres_cursados }} periodos, finalizando sus estudios el {{ $estudio->getFechaFinalizo() }} obteniendo el título de {{ ucwords(mb_strtolower($estudio->titulo_obtenido)) }}.
                @endif
            </p>
            @endforeach
        @endif

        <!-- EXPERIENCIAS -->
        @if($experiencias->count() >= 1)
            <h2>Experiencias</h2>

            <hr align="right" class="style2">

            @foreach($experiencias as $key => $experiencia)
                <p class="subtitulo">
                  <strong>
                  {{ ucwords(mb_strtolower($experiencia->cargo_especifico)) }} de {{ ucwords(mb_strtolower($experiencia->nombre_empresa)) }}
                  </strong>
                </p>

                <p class="parrafo">
                    @if ($experiencia->empleo_actual == 1)
                        {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeña actualmente como {{ ucwords(mb_strtolower($experiencia->cargo_especifico)) }} en la empresa {{ ucwords(mb_strtolower($experiencia->nombre_empresa)) }}, iniciando actividades el {{ $experiencia->getFechaInicia() }} en la ciudad de {{ \App\Models\Ciudad::GetCiudad($experiencia->pais_id, $experiencia->departamento_id, $experiencia->ciudad_id) }}. El salario percibido es de {{ mb_strtolower($experiencia->salario) }}, su jefe inmediato {{ ucwords(mb_strtolower($experiencia->nombres_jefe)) }} se desempeña como {{ ucwords(mb_strtolower($experiencia->cargo_jefe)) }} y  su número de contácto es {{ $experiencia->movil_jefe }}.
                    @else
                        {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeñó como {{ ucwords(mb_strtolower($experiencia->cargo_especifico)) }} en la empresa {{ ucwords(mb_strtolower($experiencia->nombre_empresa)) }}, iniciando actividades el {{ $experiencia->getFechaInicia() }} y finalizando el contrato el {{ $experiencia->getFechaFinal() }}, el cual se configuró como retiro sin justa causa en la ciudad de {{ \App\Models\Ciudad::GetCiudad($experiencia->pais_id, $experiencia->departamento_id, $experiencia->ciudad_id) }}. El salario percibido fue de {{ mb_strtolower($experiencia->salario) }}, su jefe inmediato {{ ucwords(mb_strtolower($experiencia->nombres_jefe)) }} se desempeñó como {{ ucwords(mb_strtolower($experiencia->cargo_jefe)) }} y  su número de contácto es {{ $experiencia->movil_jefe }}.
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
            <h2>Grupo Familiar</h2>

            <hr align="right" class="style2">

            <p class="subtitulo">
                El grupo familiar de {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} está compuesto por:
            </p>
            
            @foreach($familiares as $key => $familiar)
                <p class="subtitulo">
                <strong>{{ ucwords(mb_strtolower($familiar->parentesco)) }}</strong>
                </p>

                <p class="parrafo">
                 {{ ucwords(mb_strtolower($familiar->nombres_familiar)) }}, actualmente tiene {{ $familiar->getEdad() }} años, el nivel de escolaridad es {{ mb_strtolower($familiar->escolaridad) }}, su profesión es {{ ucwords(mb_strtolower($familiar->profesion_id)) }} y nació en {{ \App\Models\Ciudad::GetCiudad($familiar->codigo_pais_nacimiento, $familiar->codigo_departamento_nacimiento, $familiar->codigo_ciudad_nacimiento) }}.
                </p>
            @endforeach
        @endif

        <!-- REFERENCIAS PERSONALESs -->
        @if($referencias->count() >= 1)
            <h2>Referencias Personales</h2>

            <hr align="right" class="style2">
            
            @foreach($referencias as $key => $referencia)
                <p class="subtitulo">
                    <strong>{{ ucwords(mb_strtolower($referencia->desc_tipo)) }}</strong>
                </p>
                
                <p class="parrafo">
                    {{ $referencia->nombres }} {{ $referencia->primer_apellido }} {{ $referencia->segundo_apellido }} ({{ $referencia->ocupacion }}) <br>
                    {{ $referencia->ciudades }} <br>
                    C.C {{ $referencia->numero_id }} <br>
                    {{$referencia->telefono_movil}} - {{$referencia->telefono_fijo }}
                </p>

            @endforeach
        @endif

        <!--  PIE -->
        <footer>
          <img alt="Logo T3RS" class="izquierda" height="25" src="{{url('img/t3.png')}}" width="20"> www.t3rsc.co
        </footer>
    </body>
</html>
