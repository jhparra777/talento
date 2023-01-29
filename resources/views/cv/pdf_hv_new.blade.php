<!DOCTYPE html>
<html lang="en">
<head>
    @if(triRoute::validateOR('local'))
        <?php set_time_limit(420); ?>
    @endif
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Informe de Selección - T3RS</title>

    <script src="https://kit.fontawesome.com/a23970da56.js" crossorigin="anonymous"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

        @page {
            margin: 0.8cm 0.8cm;
            font-family: 'Roboto', sans-serif;
        }

        body {
            font-family: 'Roboto', sans-serif;

            background-color: #f1f1f1;
        }

        .text-center{ text-align: center; }
        .text-left{ text-align: left; }
        .text-right{ text-align: right; }
        .text-justify{ text-align: justify; }

        .table{ border-collapse:separate; }

        .table th {
            border: none;
        }

        .font-size-10{ font-size: 10pt; }
        .font-size-11{ font-size: 11pt; }
        .font-size-12{ font-size: 12pt; }
        .font-size-14{ font-size: 14pt; }

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

        .m-0{ margin: 0; }
        .m-1{ margin: 1rem; }
        .m-2{ margin: 2rem; }
        .m-3{ margin: 3rem; }
        .m-4{ margin: 4rem; }

        .ml-0{ margin-left: 0; }
        .ml-05{ margin-left: 0.5rem; }
        .ml-1{ margin-left: 1rem; }
        .ml-2{ margin-left: 2rem; }
        .ml-3{ margin-left: 3rem; }
        .ml-4{ margin-left: 4rem; }

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

        .m-auto{ margin: auto; }

        .pd-0{ padding: 0; }
        .pd-05{ padding: 0.5rem; }
        .pd-1{ padding: 1rem; }
        .pd-2{ padding: 2rem; }
        .pd-3{ padding: 3rem; }
        .pd-4{ padding: 4rem; }

        .no-list{ list-style: none; }

        .table-result{
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 0.5rem;
            font-family: 'Roboto', sans-serif;
            /*box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2), 0 4px 8px 0 rgba(0, 0, 0, 0.19);*/
        }

        .secciones-titulos {
            margin-bottom: -2rem;
            margin-top: 2rem;
        }

        .secciones-titulos-2 {
            margin-top: 2rem;
        }

        .bg-blue{ background-color: #2E2D66; color: white; }
        .bg-dark-blue{ background-color: #2c3e50; color: white; }
        .bg-red{ background-color: #D92428; color: white; }
        .bg-yellow{ background-color: #E4E42A; color: white; }
        .bg-green{ background-color: #00A954; color: white; }

        .color-blue{ color: #2E2D66; }
        .color-red{ color: #D92428; }
        .color-yellow{ color: #E4E42A; }
        .color-green{ color: #00A954; }

        .color{ color: #6F3795; }
        .color-sec{ color: #231F20; }

        .bg-blue-a{ background-color: #0288d1; color: white; }
        .bg-red-a{ background-color: #f44336; color: white; }
        .bg-yellow-a{ background-color: #fdd835; color: white; }
        .bg-green-a{ background-color: #7cb342; color: white; }

        .br-05{ border-radius: 5px; }

        .fw-600{ font-weight: 600; }
        .fw-700{ font-weight: 700; }

        .page-break{ page-break-after: always; }

        .profile-picture{
            padding: .25rem;
            width: 100px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            max-width: 100%;
        }

        .divider{ width: 44.5%; background-color: #2E2D66; color: #2E2D66; border: 0; height: 1px;}
        .divider-th{ width: 90%; background-color: #2E2D66; color: #2E2D66; border: 0; height: 1px;}
        .divider-hd{ width: 100%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-10{ width: 10%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-20{ width: 20%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-25{ width: 25%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-30{ width: 30%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-40{ width: 40%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-50{ width: 50%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-60{ width: 60%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-70{ width: 70%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-80{ width: 80%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }
        .divider-90{ width: 90%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px;  }


        .text-uppercase { text-transform: uppercase; }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            /*background-color: #2a0927;*/
            color: #d6d6d6;
            text-align: center;
            line-height: 20px;
            display: none;
        }

        .main{
            width: 80%;
            margin: auto;

            padding: 1rem;
            border-radius: 1rem;
            border: solid 1px #ddd;
            background-color: white;
        }

        .btn {
            display: inline-block;
            margin-bottom: 0;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
                border-top-color: transparent;
                border-right-color: transparent;
                border-bottom-color: transparent;
                border-left-color: transparent;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            border-radius: 4px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .btn-default:hover {
            color: #333;
            background-color: #e6e6e6;
            border-color: #adadad;
        }

        .btn:hover {
            text-decoration: none;
        }
    </style>

    <style media="print">
        body {
            margin: 0.5cm 0.5cm;

            background-color: transparent !important;
        }

        footer {
            display: inline-block;
        }

        .main {
            width: 100%;

            padding: 0rem;
            border-radius: 0rem;
            border: none;
            background-color: none;
        }

        .section-descarga {
            display: none;
        }
    </style>
</head>
<body>
    <div class="section-descarga" style="margin: auto; width: 80%; border: solid 1px #ddd; background-color: white; padding: 1rem; border-radius: 1rem; margin-bottom: 1rem; margin-top: 1rem;">
        <div class="text-right">
            <button class="btn btn-default" onclick="window.print()">Descargar PDF <i class="fas fa-download"></i></button>
        </div>
    </div>

    <main class="main">
        {{-- Logos T3RS y cliente --}}
        <section>
            <table width="100%">
                <tr>
                    <td class="text-left">
                        <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-src/tri-new-logo-horizontal-letter.png" alt="T3RS" width="120">
                    </td>
                    <td></td>
                    <td class="text-right">
                        @if(!triRoute::validateOR('local'))
                            @if(!is_null($reqcandidato->logo_empresa) && $reqcandidato->logo_empresa != "")
                                <img src="{{ asset("configuracion_sitio/$reqcandidato->logo_empresa") }}" alt="T3RS" height="60">
                            @elseif($logo!="")
                                <img src="{{ url('configuracion_sitio/'.$logo) }}" alt="T3RS" width="120">
                            @else
                                <img src="{{ url('configuracion_sitio/logo_cargado.png') }}" alt="T3RS" width="120">
                            @endif
                        @else
                            <img src="https://picsum.photos/120/60" alt="T3RS" width="120">
                        @endif
                    </td>
                </tr>
            </table>
        </section>

        {{-- Foto de perfil del candidato (si posee) --}}
        <section>
            <div class="text-center">
                @if(!triRoute::validateOR('local'))
                    @if(!empty($user->foto_perfil))
                        <img 
                            src="{{ url('recursos_datosbasicos/'.$user->foto_perfil) }}" 
                            alt="Foto de perfil" 
                            class="profile-picture" 
                            width="100"
                        >
                    @elseif($user->avatar != "")
                        <img 
                            src="{{ $user->avatar }}" 
                            alt="Foto de perfil" 
                            class="profile-picture" 
                            width="100"
                        >
                    @else
                        <img 
                            src="{{ url("img/personaDefectoG.jpg") }}" 
                            alt="Foto de perfil" 
                            class="profile-picture" 
                            width="100"
                        >
                    @endif
                @else
                    <img class="profile-picture" src="https://picsum.photos/500" alt="Foto de perfil">
                @endif
            </div>
        </section>

        {{-- Datos del usuario --}}
        <section>
            <div class="font-size-11 text-center">
                <ul class="no-list pd-0 mt-1">
                    <li>
                        <b>{{ucwords(mb_strtolower($datos_basicos->nombres)) }} {{ ucwords(mb_strtolower($datos_basicos->primer_apellido)) }} {{ucwords(mb_strtolower($datos_basicos->segundo_apellido)) }}</b>
                    </li>

                    <li>
                        {{ ucwords(mb_strtolower($datos_basicos->dec_tipo_doc)) }}: {{ number_format($datos_basicos->numero_id) }}
                    </li>

                    @if($user->video_perfil !=null)
                        <li>
                            <a class="colorText"  href="{{route('ver_videoperfil',$user->id)}}" target="_blank">Video Perfil</a>

                        </li>
                    @endif

                    @if($hv!=null)
                        <li>
                            <a href='{{route("view_document_url", encrypt("archivo_hv/"."|".$hv->archivo))}}' target="_blank"> Hoja de Vida </a>
                        </li>
                    @elseif(!empty($archivo))
                        <li>
                            <a class="colorText" href='{{route("view_document_url", encrypt("recursos_documentos/"."|".$archivo->nombre_archivo))}}' target="_blank"> Hoja de Vida </a>
                        </li>
                    @endif

                    <li>{{ $edad }} años</li>
                    <li>
                        {{$datos_basicos->telefono_movil}}
                        @if($datos_basicos->telefono_fijo != '')
                            - {{ $datos_basicos->telefono_fijo}}
                        @endif
                    </li>
                    <li>
                        {{$datos_basicos->email}}
                    </li>

                    @if($datos_basicos->ciudad_residencia != '')
                        <li>
                            {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_residencia, $datos_basicos->departamento_residencia, $datos_basicos->ciudad_residencia) }}
                        </li>
                    @endif
                </ul>
            </div>
        </section>

        @if($datos_basicos->descrip_profesional != '')
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">PERFIL</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                <div class="m-auto" style="width: 95%;">
                    <p class="text-justify color-sec">
                        {!! $datos_basicos->descrip_profesional !!}
                    </p>
                </div>
            </section>
        @endif
        <br>

        <section class="secciones-titulos-2">
            <h2 style="color: #6F3795;">INFORMACIÓN PERSONAL</h2>
            <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
        </section>
        <section>
            <div class="m-auto" style="width: 95%;">
                <p class="text-justify color-sec">
                    {{ucwords(mb_strtolower($datos_basicos->nombres)) }} se identifica con la {{ mb_strtolower($datos_basicos->dec_tipo_doc) }} número {{ number_format($datos_basicos->numero_id) }} @if($datos_basicos->ciudad_expedicion_id) de la ciudad de {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_id, $datos_basicos->departamento_expedicion_id, $datos_basicos->ciudad_expedicion_id) }}, @endif @if($datos_basicos->genero_desc) cuyo género es {{ mb_strtolower($datos_basicos->genero_desc) }}, @endif @if($datos_basicos->estado_civil_des) su estado civil es {{ mb_strtolower($datos_basicos->estado_civil_des)}} @endif y tiene una aspiración salarial de {{($datos_basicos->aspiracion_salarial_des)? strtolower($datos_basicos->aspiracion_salarial_des):$datos_basicos->aspiracion_salarial}}. @if($datos_basicos->ciudad_residencia) Reside actualmente en la ciudad de {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_residencia, $datos_basicos->departamento_residencia, $datos_basicos->ciudad_residencia) }},@endif  @if($datos_basicos->direccion) en la dirección {{ mb_strtolower($datos_basicos->direccion)}}@endif.
                </p>

                <?php
                    $maximoEstudio = $datos_basicos->maximoEstudio();
                ?>
                @if($maximoEstudio != null)
                    <p class="text-justify color-sec">
                        @if($maximoEstudio->estudio_actual)
                            El nivel máximo de estudios registrado es {{ mb_strtolower($maximoEstudio->descripcion) }} en {{ ucwords(mb_strtolower($maximoEstudio->institucion)) }} en la ciudad de {{ \App\Models\Ciudad::GetCiudad($maximoEstudio->pais_estudio, $maximoEstudio->departamento_estudio, $maximoEstudio->ciudad_estudio)}}
                        @else
                            El nivel máximo de estudios registrado es {{ mb_strtolower($maximoEstudio->descripcion) }} y el título obtenido es {{mb_strtolower($maximoEstudio->titulo_obtenido)}} en {{ ucwords(mb_strtolower($maximoEstudio->institucion)) }}, el cual finalizó el {{ \App\Models\DatosBasicos::convertirFecha($maximoEstudio->fecha_finalizacion) }} en la ciudad de {{ \App\Models\Ciudad::GetCiudad($maximoEstudio->pais_estudio, $maximoEstudio->departamento_estudio, $maximoEstudio->ciudad_estudio)}}
                        @endif
                    </p>
                @endif
                @if($experienciaMayorDuracion)
                    <p class="text-justify color-sec">
                        @if($experienciaMayorDuracion->empleo_actual == 1)
                            Su experiencia más extensa fue en la empresa {{ucwords(mb_strtolower($experienciaMayorDuracion->nombre_empresa))}}, donde se desempeña como {{mb_strtolower($experienciaMayorDuracion->cargo_especifico)}}. Su experiencia laboral más reciente es en {{ucwords(mb_strtolower($experienciaActual->nombre_empresa))}}, desempeñándose como {{ mb_strtolower($experienciaActual->cargo_especifico) }} devengando de  {{($experienciaActual->salario)? mb_strtolower($experienciaActual->salario):$experienciaActual->salario_devengado}}.
                            Actualmente se encuentra laborando.
                        @else

                            Su experiencia más extensa fue en la empresa {{ucwords(mb_strtolower($experienciaMayorDuracion->nombre_empresa))}}, donde se desempeñó como {{ mb_strtolower($experienciaMayorDuracion->cargo_especifico)}} por un periodo de {{ \App\Models\Experiencias::añosMeses($experienciaMayorDuracion->fecha_inicio, $experienciaMayorDuracion->fecha_final)}}. Su experiencia laboral más reciente fue en {{ ucwords(mb_strtolower($experienciaActual->nombre_empresa)) }}, desempeñándose como {{ mb_strtolower($experienciaActual->cargo_especifico) }} devengando de {{(!is_null($experienciaActual->salario))? mb_strtolower($experienciaActual->salario):$experienciaActual->salario_devengado}}.

                        @endif
                    </p>
                @endif
            </div>
        </section>

        <!-- Idiomas -->
        @if($idiomas->count() >= 1)
            <div class="page-break"></div>
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">IDIOMAS</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                @foreach($idiomas as $idioma)
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">{{ucwords(mb_strtolower($idioma->nombre_idioma->descripcion))}}</p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            @if($idioma->nivel_idioma) 
                                {{$idioma->nivel_idioma->descripcion}}
                            @endif
                        </p>
                    </div>
                @endforeach
            </section>
        @endif

        <!-- ESTUDIOS -->
        @if($estudios->count() >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">ESTUDIOS</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                @foreach($estudios as $estudio)
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">{{ucwords(mb_strtolower($estudio->desc_nivel))}}</p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            @if ($estudio->estudio_actual)
                                {{ ucwords(mb_strtolower($datos_basicos->nombres))}} está realizando el {{ mb_strtolower($estudio->desc_nivel)}} en {{ ucwords(mb_strtolower($estudio->institucion))}} de la ciudad de {{ \App\Models\Ciudad::GetCiudad($estudio->pais_estudio, $estudio->departamento_estudio, $estudio->ciudad_estudio)}}, cursando {{ $estudio->semestres_cursados }} periodos hasta el momento, el título por obtener es {{ ucwords(mb_strtolower($estudio->titulo_obtenido))}}.
                            @else
                                {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} realizó sus estudios de {{ mb_strtolower($estudio->desc_nivel) }} en {{ ucwords(mb_strtolower($estudio->institucion)) }} de la ciudad de {{ \App\Models\Ciudad::GetCiudad($estudio->pais_estudio, $estudio->departamento_estudio, $estudio->ciudad_estudio) }}, cursando {{ $estudio->semestres_cursados }} periodos, finalizando sus estudios el {{ $estudio->getFechaFinalizo() }} obteniendo el título de {{ ucwords(mb_strtolower($estudio->titulo_obtenido))}}.
                            @endif
                        </p>
                    </div>
                @endforeach
            </section>
        @endif

        <!-- EXPERIENCIAS -->
        @if($experiencias->count() >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">EXPERIENCIAS</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                @foreach($experiencias as $key => $experiencia)
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">{{ucwords(mb_strtolower($experiencia->cargo_especifico)) }} de {{ ucwords(mb_strtolower($experiencia->nombre_empresa))}}</p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            @if($experiencia->empleo_actual == 1)
                                {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeña actualmente como {{ ucwords(mb_strtolower($experiencia->cargo_especifico)) }} en la empresa {{ ucwords(mb_strtolower($experiencia->nombre_empresa)) }}, iniciando actividades el {{ $experiencia->getFechaInicia() }} en la ciudad de {{ \App\Models\Ciudad::GetCiudad($experiencia->pais_id, $experiencia->departamento_id, $experiencia->ciudad_id) }} El salario percibido es de {{(!is_null($experiencia->salario))?mb_strtolower($experiencia->salario):$experiencia->salario_devengado}}, su jefe inmediato {{ ucwords(mb_strtolower($experiencia->nombres_jefe)) }} se desempeña como {{ ucwords(mb_strtolower($experiencia->cargo_jefe)) }} y su número de contácto es {{ $experiencia->movil_jefe }}.
                            @else
                                {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeñó como {{ ucwords(mb_strtolower($experiencia->cargo_especifico)) }} en la empresa {{ ucwords(mb_strtolower($experiencia->nombre_empresa)) }}, iniciando actividades el {{ $experiencia->getFechaInicia() }} y finalizando el {{ $experiencia->getFechaFinal() }}, @if($experiencia->desc_motivo) retiro motivo de {{ mb_strtolower($experiencia->desc_motivo)}} @endif en la ciudad de {{ \App\Models\Ciudad::GetCiudad($experiencia->pais_id, $experiencia->departamento_id, $experiencia->ciudad_id)}} @if(!is_null($experiencia->salario)) El salario percibido fue de {{(!is_null($experiencia->salario))?mb_strtolower($experiencia->salario):$experiencia->salario_devengado}}, @endif su jefe inmediato {{ ucwords(mb_strtolower($experiencia->nombres_jefe)) }} se desempeñó como {{ucwords(mb_strtolower($experiencia->cargo_jefe))}} @if($experiencia->movil_jefe) y su número de contácto es {{ $experiencia->movil_jefe }}@endif.
                            @endif
                        </p>
                        @if($experiencia->funciones_logros)
                            <p class="text-justify color-sec">
                                Sus principales funciones fueron {{$experiencia->funciones_logros}}.
                            </p>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif

        <!-- FAMILIARES -->
        @if($familiares->count() >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">GRUPO FAMILIAR</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                <div class="ml-1">
                    <p class="color fw-700" style="font-size: 12pt;">El grupo familiar de {{ucwords(mb_strtolower($datos_basicos->nombres))}} está compuesto por:</p>
                </div>

                @foreach($familiares as $key => $familiar)
                    <div class="m-auto" style="width: 95%;">
                        <p class="color fw-700" style="font-size: 12pt;">{{ucwords(mb_strtolower($familiar->parentesco))}}</p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            {{ ucwords(mb_strtolower($familiar->nombres))}}, @if($familiar->getEdad()) actualmente tiene {{ $familiar->getEdad() }} años,  @endif @if($familiar->escolaridad) el nivel de escolaridad es {{mb_strtolower($familiar->escolaridad)}}, @endif @if($familiar->profesion) su profesión es {{ucwords(mb_strtolower($familiar->profesion))}} @endif @if($familiar->codigo_ciudad_nacimiento) y nació en {{\App\Models\Ciudad::GetCiudad($familiar->codigo_pais_nacimiento, $familiar->codigo_departamento_nacimiento, $familiar->codigo_ciudad_nacimiento)}}@endif.
                        </p>
                    </div>
                @endforeach
            </section>
        @endif

        <!-- EXPERIENCIAS -->
        @if($referencias->count() >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">REFERENCIAS PERSONALES</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                @foreach($referencias as $key => $referencia)
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">{{ ucwords(mb_strtolower($referencia->desc_tipo)) }}</p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            {{ $referencia->nombres }} {{ $referencia->primer_apellido }} {{ $referencia->segundo_apellido }} ({{ $referencia->ocupacion }}) <br>
                            {{ $referencia->ciudades }} <br>
                            C.C {{ $referencia->numero_id }} <br>
                            {{$referencia->telefono_movil}} - {{$referencia->telefono_fijo }}
                        </p>
                    </div>
                @endforeach
            </section>
        @endif
    </main>

    <footer>
        {{-- @include("home.include._firma_footer_tri", ["estilo_personalizado" => true]) --}}
        <div
                style="
                position:fixed !important;
                z-index: -1000;
                bottom: .5cm;
                right: .5cm;
                opacity: .7;
                font-size: 8pt;
                text-align: right;"
        >
            <i><a href="https://www.t3rsc.co" style="text-decoration: none; color:black;">Documento generado con la tecnología de t3rsc.co</a></i>
        </div>
    </footer>
</body>
</html>