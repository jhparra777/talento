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

        .main {
            width: 100%;

            padding: 0rem;
            border-radius: 0rem;
            border: none;
            background-color: none;
        }

        footer {
            display: block !important;
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
                                <img src="{{ url('configuracion_sitio/'.$logo) }}" alt="T3RS" height="60">
                            @else
                                <img src="{{ url('img/logo.png') }}" alt="T3RS" height="60">
                            @endif
                        @else
                            <img src="https://picsum.photos/120/60" alt="T3RS" height="60">
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
                            <a  target="_blank" class="colorText"  href="{{asset('archivo_hv/'.$hv->archivo)}}" >Hoja de Vida</a>
                        </li>
                    @endif

                    <li>{{ $edad }} años</li>
                    @if($datos_basicos->datos_contacto == 1)
                        <li>
                            {{$datos_basicos->telefono_movil}}
                            @if($datos_basicos->telefono_fijo != '')
                                - {{ $datos_basicos->telefono_fijo}}
                            @endif
                        </li>
                        <li>
                            {{$datos_basicos->email}}
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
                    {{ucwords(mb_strtolower($datos_basicos->nombres)) }} se identifica con la {{ mb_strtolower($datos_basicos->dec_tipo_doc) }} número {{ number_format($datos_basicos->numero_id) }} @if($datos_basicos->ciudad_expedicion_id) de la ciudad de  {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_id, $datos_basicos->departamento_expedicion_id, $datos_basicos->ciudad_expedicion_id) }}, @endif @if($datos_basicos->genero_desc) cuyo género es {{ mb_strtolower($datos_basicos->genero_desc) }}, @endif @if($datos_basicos->estado_civil_des) su estado civil es {{ mb_strtolower($datos_basicos->estado_civil_des)}} @endif y tiene una aspiración salarial de {{($datos_basicos->aspiracion_salarial_des)? strtolower($datos_basicos->aspiracion_salarial_des):$datos_basicos->aspiracion_salarial}}. @if($datos_basicos->ciudad_residencia) Reside actualmente en la ciudad de {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_residencia, $datos_basicos->departamento_residencia, $datos_basicos->ciudad_residencia) }},@endif  @if($datos_basicos->direccion) en la dirección {{ mb_strtolower($datos_basicos->direccion)}}@endif.
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

        <!-- ESTUDIOS -->
        @if($estudios->count() >= 1)
            <div class="page-break"></div>

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

        @if($reqcandidato != null)
            <div class="page-break"></div>

            <section class="secciones-titulos-2 text-center">
                <h2 style="color: #6F3795; width: 95%;" class="text-uppercase">
                    Informe de selección de {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} {{ ucwords(mb_strtolower($datos_basicos->primer_apellido)) }} {{ ucwords(mb_strtolower($datos_basicos->segundo_apellido)) }} referente al cargo {{ ucwords(mb_strtolower($reqcandidato->descripcion)) }} en el requerimiento {{ $reqcandidato->requerimiento_id }} del cliente {{$reqcandidato->cliente_nombre}}
                </h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
        @endif

        <!-- Entrevista semi -->
        @if($entrevistas->count() >= 1)
            @foreach($entrevistas as $key => $entrevista)
                <section class="secciones-titulos-2">
                    <h2 style="color: #6F3795;" class="text-uppercase">ENTREVISTA {{ \App\Models\DatosBasicos::convertirFecha($entrevista->created_at) }}</h2>
                    <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
                </section>

                <section>
                    @if($entrevista->aspecto_familiar != "")
                        <div class="ml-1">
                            <p class="color fw-700" style="font-size: 12pt;">Aspecto Familiar</p>
                            <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                        </div>

                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                {{strip_tags($entrevista->aspecto_familiar)}}
                            </p>
                        </div>
                    @endif

                    @if ($entrevista->aspecto_academico != "")
                        <div class="ml-1">
                            <p class="color fw-700" style="font-size: 12pt;">Aspectos Académicos</p>
                            <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                        </div>

                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                {{strip_tags($entrevista->aspecto_academico)}}
                            </p>
                        </div>
                    @endif

                    @if ($entrevista->aspectos_experiencia != "")
                        <div class="ml-1">
                            <p class="color fw-700" style="font-size: 12pt;">Aspectos Experiencia</p>
                            <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                        </div>

                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                {{ strip_tags($entrevista->aspectos_experiencia) }}
                            </p>
                        </div>
                    @endif

                    @if($entrevista->aspectos_personalidad != "")
                        <div class="ml-1">
                            <p class="color fw-700" style="font-size: 12pt;">Aspectos de Personalidad</p>
                            <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                        </div>

                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                {{strip_tags($entrevista->aspectos_personalidad)}}
                            </p>
                        </div>
                    @endif

                    @if ($entrevista->fortalezas_cargo != "")
                        <div class="ml-1">
                            <p class="color fw-700" style="font-size: 12pt;">
                                Fortalezas frente al Cargo
                            </p>
                            <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                        </div>

                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                {{ strip_tags($entrevista->fortalezas_cargo) }}
                            </p>
                        </div>
                    @endif

                    @if ($entrevista->oportunidad_cargo != "")
                        <div class="ml-1">
                            <p class="color fw-700" style="font-size: 12pt;">
                                Oportunidades de mejora frente al cargo
                            </p>
                            <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                        </div>

                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                {{ strip_tags($entrevista->oportunidad_cargo) }}
                            </p>
                        </div>
                    @endif

                    @if ($entrevista->concepto_general != "")
                        <div class="ml-1">
                            <p class="color fw-700" style="font-size: 12pt;">
                                Concepto General
                            </p>
                            <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                        </div>

                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                {{ strip_tags($entrevista->concepto_general) }}
                            </p>
                        </div>
                    @endif

                    @if ($entrevista->evaluacion_competencias != "")
                        <div class="ml-1">
                            <p class="color fw-700" style="font-size: 12pt;">
                                Evaluación de competencias
                            </p>
                            <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                        </div>

                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                {{ strip_tags($entrevista->evaluacion_competencias)}}
                            </p>
                        </div>
                    @endif

                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            {{ $entrevista->getNamePsicologo()}}
                        </p>
                        <p class="text-justify color-sec">
                            Fecha de finalización {{ \App\Models\DatosBasicos::convertirFecha($entrevista->updated_at) }}
                        </p>
                    </div>
                </section>
            @endforeach
        @endif

        <!-- Entrevista virtual video -->
        @if($entrevistas_virtuales->count() >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">ENTREVISTA VIRTUAL ARCHIVO</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>

            <section>
                @foreach($entrevistas_virtuales as $key => $entrevista_virtual)
                    @if ($entrevista_virtual->respuesta != "")
                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                <b>Pregunta ({{ $entrevista_virtual->pregunta }})</b>
                            </p>

                            <p class="text-justify color-sec">
                                Archivo Adjunto:
                                <a href='{{route("view_document_url", encrypt("recursos_videoRespuesta/"."|".$entrevista_virtual->respuesta))}}' class="enlace" target="_blank">
                                    Ver Respuesta
                                </a>
                            </p>
                        </div>
                    @endif
                @endforeach
            </section>
        @endif
        <!-- / Entrevista virtual video -->

        <!-- Entrevista Multiple -->
        @if(count($entrevista_multiple) > 0)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;" class="text-uppercase">ENTREVISTA MÚLTIPLE {{ \App\Models\DatosBasicos::convertirFecha($entrevista_multiple->created_at) }}</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>

            <section>
                <div class="m-auto" style="width: 95%;">
                    <p class="text-justify color-sec">
                        <b>
                            Concepto:
                        </b>
                        {{strip_tags($entrevista_multiple->concepto)}}
                    </p>

                    <p class="text-justify color-sec">
                        <b>
                            Calificación:
                        </b>
                        {{$entrevista_multiple->calificacion}}
                        <br>
                        <b>
                            Apto:
                        </b>
                        {{ $entrevista_multiple->apto == 1 ? 'El candidato es apto' : ($entrevista_multiple->apto == 2 ? 'El candidato es no apto' : '') }}
                        <br>
                        <b>
                            Analista que realizó el concepto:
                        </b>
                        {{ $entrevista_multiple->nombre_usuario_gestiono() }}
                        <br>
                        <br>
                        <a href="{{url('entrevista-multiple/'.$entrevista_multiple->entrevista_multiple_id)}}" target="_blank" class="enlace" >Ver Entrevista Múltiple</a>
                    </p>

                    <p class="text-justify color-sec">
                        Fecha de realización {{ \App\Models\DatosBasicos::convertirFecha($entrevista_multiple->updated_at) }}
                    </p>
                </div>
            </section>
        @endif
        <!-- / Entrevista Multiple -->

        <!-- Pruebas de indiomas -->
        @if($pruebas_idiomas->count() >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">PRUEBA IDIOMA ARCHIVO</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>

            <section>
                @foreach($pruebas_idiomas as $key => $prueba_idioma)
                    @if ($prueba_idioma->respuesta != "")
                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                <b>Pregunta ({{ $prueba_idioma->pregunta }})</b>
                            </p>

                            <p class="text-justify color-sec">
                                Archivo Adjunto:
                                <a href='{{route("view_document_url", encrypt("recursos_VideoIdioma/"."|".$prueba_idioma->respuesta))}}' class="enlace" target="_blank">
                                    Ver Respuesta
                                </a>
                            </p>
                        </div>
                    @endif
                @endforeach
            </section>
        @endif
        <!-- fin pruebas idiomas-->

        <!-- Informe preliminar-->
        @if(isset($preliminar))
            @if($preliminar->count() >= 1)
                <section class="secciones-titulos-2">
                    <h2 style="color: #6F3795;">INFORME PRELIMINAR</h2>
                    <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
                </section>
                
                <section>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            <a target="_blank" href="{{route('admin.getinforme_preliminar').'?req_id='.$reqcandidato->requerimiento_id}}" > Ver Informe </a>                         
                        </p>
                    </div>
                </section>

                <br>
                <br>
            @endif
        @endif

        <!-- PRUEBAS PSICOTECNICAS -->
        @if ($resp_ethical_values != null || $resp_personal_skills != null || $resp_bryg != null)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">PRUEBAS PSICOTÉCNICAS</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>

            <section>
                @if ($resp_ethical_values != null || $resp_personal_skills != null)
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
                            <th class="text-center color fw-700" colspan="{{ $columnas }}" style="font-size: 12pt;">
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
                            <td class="text-center" colspan="{{ $columnas }}">
                                <div class="circle c-2">
                                    <div class="text-circle-2">
                                        {{ round($promedio_total) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="{{ $columnas }}">
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
                                    <td width="{{ $width_col }}%" class="text-center">
                                        @if ($columnas > 1)
                                            <h4>Ajuste del candidato a la prueba Personal Skills</h4>
                                            <div class="circle c-1">
                                                <div class="text-circle-1">
                                                    {{ round($resp_personal_skills->ajuste_global) }}%
                                                </div>
                                            </div>
                                        @endif

                                        <div class="text-center" style="margin-top: -0.5rem;">
                                        <!-- <h4>Factor de desfase</h4>

                                            <h4 style="margin-top: -0.5rem;">
                                                {{ round($resp_personal_skills->factor_desfase_global) }}%

                                                @if($resp_personal_skills->factor_desfase_global < 0)
                                                    <img style="margin-top: 0.6rem; margin-left: -0.6rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-negativo.png') }}" width="40">
                                                @else
                                                    <img style="margin-top: 0.6rem; margin-left: -0.6rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-positivo.png') }}" width="40">
                                                @endif
                                            </h4> -->
                                        </div>
                                    </td>
                                @endif
                                @if ($resp_ethical_values != null)
                                    <td class="text-center" width="{{ $width_col }}%">
                                        @if ($columnas > 1)
                                            <h4>Ajuste del candidato a la prueba Ethical Values</h4>
                                            <div class="circle c-1">
                                                <div class="text-circle-1">
                                                    {{ $promedio_porc }}%
                                                </div>
                                            </div>
                                        @endif
                                        <div class="text-center" style="margin-top: -0.5rem;">
                                   <!--         <h4>Factor de desfase</h4>

                                            <h4 style="margin-top: -0.5rem;">
                                                {{ $dif_porc }}%

                                                @if ($dif_porc >= 0)
                                                    <img style="margin-top: 0.6rem; margin-left: -0.6rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-positivo.png') }}" width="40">
                                                @else
                                                    <img style="margin-top: 0.6rem; margin-left: -0.6rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-negativo.png') }}" width="40">
                                                @endif
                                            </h4>  -->
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        </table>
                    </section>

                    <div class="page-break"></div>

                    @if($resp_personal_skills != null)
                        <section>
                            <div class="ml-05">
                                <p class="color fw-700" style="font-size: 12pt;">Prueba Personal Skills</p>
                                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                            </div>
                        </section>

                        <section style="height: 280px;" style="margin-top: -5rem;">
                            <div style="float: left; width: 50%; display : inline-block;">
                                <div class="text-center">
                                    <h4>Ajuste del <br> candidato al perfil</h4>

                                    <div class="circle c-2">
                                        <div class="text-circle-2">{{ round($resp_personal_skills->ajuste_global) }}%</div>
                                    </div>
                                </div>

                                <div class="text-center" style="margin-top: -0.5rem;">
                                 <!--   <h4>Factor de desfase</h4>

                                    <h1 style="margin-top: -2rem;">
                                        {{ round($resp_personal_skills->factor_desfase_global) }}%

                                        @if($resp_personal_skills->factor_desfase_global < 0)
                                            <img style="margin-top: 1.2rem; margin-left: -1.2rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-negativo.png') }}" width="85">
                                        @else
                                            <img style="margin-top: 1.2rem; margin-left: -1.2rem" src="{{ asset('assets/admin/tests/ps-skills/competencias-positivo.png') }}" width="85">
                                        @endif
                                    </h1> -->
                                </div>
                            </div>

                            <div class="text-center" style="float: right; width: 50%;">
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
                            <div class="ml-1">
                                <p class="color fw-700" style="font-size: 12pt;">Perspectivas comportamentales referentes a las competencias laborales evaluadas</p>
                                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                            </div>
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

                            <div class="m-auto" style="width: 95%;">
                                @foreach($totales_personal_skills as $key => $total)
                                    <div>
                                        <p class="text-justify color-sec"><b>{{ $total->descripcion }}:</b></p>
                                    </div>

                                    <p class="text-justify color-sec">
                                        {{ $insights[$key] }}
                                    </p>
                                @endforeach

                                @if($concepto_personal_skills != null && $concepto_personal_skills != '')
                                    <p class="text-justify color-sec">
                                        <b>
                                            Concepto del analista sobre la prueba:
                                        </b>
                                        {{ strip_tags($concepto_personal_skills->concepto) }}
                                    </p>
                                @endif

                                <p class="text-justify color-sec">
                                    <b>
                                        Archivo Adjunto:
                                    </b>
                                    <a href="{{url('admin/prueba-competencias-informe/'.$resp_personal_skills->id)}}" target="_blank" class="enlace" >Ver informe Personal Skills</a>
                                </p>
                            </div>
                        </section>
                        <br>
                    @endif

                    @if($resp_ethical_values != null && $resp_ethical_values->respuestas != null && $resp_ethical_values->respuestas != '')
                        <section>
                            <div class="ml-05">
                                <p class="color fw-700" style="font-size: 12pt;">Prueba Ethical Values</p>
                                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                            </div>
                        </section>

                        {{-- Gráfico de radar Ethical Values --}}
                        <section>
                            <table width="100%">
                                <tr>
                                    <td class="text-center">
                                        <img src="https://quickchart.io/chart?c={{ json_encode($grafico_radar_valores) }}" width="500">
                                    </td>
                                    <td class="text-center">
                                        <h4>Ajuste del Candidato al Perfil</h4>
                                        <img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="200">
                                     <!--   <h4>Factor de desfase</h4>
                                        <h1 style="margin-top: -2rem;">
                                            {{ $dif_porc }}% 

                                            @if ($dif_porc >= 0)
                                                <img  style="margin-top: 1.2rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="85">
                                            @else
                                                <img  style="margin-top: 1.2rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="85">
                                            @endif
                                        </h1> -->
                                    </td>
                                </tr>
                            </table>
                        </section>
                        <br>

                        <section>
                            <div class="ml-1">
                                <p class="color fw-700" style="font-size: 12pt;">
                                    Resultados cualitativos
                                </p>
                                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                            </div>

                            <div class="m-auto" style="width: 95%;">
                                <p class="text-justify color-sec">
                                    {!! $area_mayor !!} {{ $area_menor}}
                                </p>

                                <p class="text-justify color-sec">
                                    {{ $textos_cuantitativos['amor']->amor }}
                                </p>

                                <p class="text-justify color-sec">
                                    {{ $textos_cuantitativos['no_violencia']->no_violencia }}
                                </p>

                                <p class="text-justify color-sec">
                                    {{ $textos_cuantitativos['paz']->paz }}
                                </p>

                                <p class="text-justify color-sec">
                                    {{ $textos_cuantitativos['rectitud']->rectitud }}
                                </p>

                                <p class="text-justify color-sec">
                                    {{ $textos_cuantitativos['verdad']->verdad }}
                                </p>

                                <?php $concepto_final = $resp_ethical_values->concepto_final; ?>

                                @if($concepto_final != null && $concepto_final != '')
                                    <p class="text-justify color-sec">
                                        <b>
                                            Concepto del analista sobre la prueba:
                                        </b>
                                    </p>

                                    <p class="text-justify color-sec">
                                        {{ strip_tags($concepto_final) }}
                                    </p>
                                @endif

                                <p class="text-justify color-sec">
                                    <b>
                                        Archivo Adjunto:
                                    </b>
                                    <a href="{{url('admin/pdf-prueba-ethical-values/'.$resp_ethical_values->id)}}" target="_blank" class="enlace" >Ver informe Ethical Values</a>
                                </p>
                            </div>
                        </section>
                        <br>
                    @endif
                @endif

                @if ($resp_bryg != null)
                    <section>
                        <div class="ml-05">
                            <p class="color fw-700" style="font-size: 12pt;">Prueba BRYG-A</p>
                            <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                        </div>
                    </section>

                    <section>
                        <div class="mt-1 mb-1">
                            <p class="text-center">
                                <b class="color-blue">
                                    Su Perfil es
                                    {{ ucwords(mb_strtolower(App\Http\Controllers\PruebaPerfilBrygController::brygPerfilTipo($bryg_definitive_first[0], $bryg_definitive_second[0]))) }}
                                </b>
                            </p>

                            <table class="table-result m-auto">
                                <tr>
                                    <th class="bg-blue pd-05 br-05">RADICAL</th>
                                    <th class="bg-red pd-05 br-05">GENUINO</th>
                                    <th class="bg-yellow pd-05 br-05">GARANTE</th>
                                    <th class="bg-green pd-05 br-05">BÁSICO</th>
                                </tr>
                                <tr class="text-center fw-700">
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
                        <div class="text-center">
                            <img src="https://quickchart.io/chart?c={{ json_encode($grafico_radar_bryg) }}" width="400">
                        </div>
                    </section>

                    {{-- Explicación gráfico BRYG --}}
                    <section>
                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                Encontramos que {{ $datos_basicos->nombres }} tiene un perfil comportamental orientado principalmente a los factores {{ $bryg_definitive_first[0] }} y {{ $bryg_definitive_second[0] }}, por lo cual su perfil es <b class="color-blue">{{ mb_strtoupper(App\Http\Controllers\PruebaPerfilBrygController::brygPerfilTipo($bryg_definitive_first[0], $bryg_definitive_second[0])) }}</b>.
                            </p>
                        </div>
                    </section>

                    {{-- Imagen del tipo de perfil BRYG --}}
                    <section>
                        <div class="text-center mt-1 mb-1">
                            <img 
                                src="{{ App\Http\Controllers\PruebaPerfilBrygController::brygPerfil($bryg_definitive_first[0], $bryg_definitive_second[0]) }}" 
                                width="450" 
                                alt="Perfil BRYG"
                            >
                        </div>
                    </section>

                    <div class="page-break"></div>

                    {{-- Titulo de la sección aumented --}}
                    <section>
                        <p class="text-center mt-2"><b>Perfil de orientación a la adaptabilidad al cargo.</b></p>
                    </section>

                    {{-- Resultado mini tabla AUMENTED --}}
                    <section>
                        <div class="mt-0 mb-1">
                            <p class="text-center">
                                <b class="color-blue">
                                    Su Estilo es 
                                    {{ ucwords(mb_strtolower($aumented_definitive[0])) }}
                                </b>
                            </p>

                            <table class="table-result m-auto">
                                <tr>
                                    <th class="bg-blue-a pd-05 br-05">ANALIZADOR</th>
                                    <th class="bg-yellow-a pd-05 br-05">PROSPECTIVO</th>
                                    <th class="bg-red-a pd-05 br-05">DEFENSIVO</th>
                                    <th class="bg-green-a pd-05 br-05">REACTIVO</th>
                                </tr>
                                <tr class="text-center fw-700">
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
                        <div class="text-center">
                            <img src="https://quickchart.io/chart?c={{ json_encode($grafico_radar_aumented) }}" width="400">
                        </div>
                    </section>

                    {{-- Introducción al perfil de adaptabilidad --}}
                    <section>
                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                El perfil de orientación de adaptabilidad al cargo, muestra estilo de comportamiento de {{ $datos_basicos->nombres }} frente a determinadas situaciones, en este caso su estilo es <b class="color-blue">{{ mb_strtoupper($aumented_definitive[0]) }}</b>.
                            </p>
                        </div>
                    </section>

                    {{-- Imagen del perfil de adaptabilidad --}}
                    <section>
                        <div class="text-center mt-1 mb-1">
                            <img 
                                src="{{ App\Http\Controllers\PruebaPerfilBrygController::aumentedPerfil($aumented_definitive[0]) }}" 
                                width="400" 
                                alt="Perfil de adaptabilidad"
                            >
                        </div>
                    </section>

                    <section>
                        <?php
                            $concepto_bryg = App\Http\Controllers\PruebaPerfilBrygController::brygCandidatoConcepto($resp_bryg->id);
                        ?>
                        <div class="m-auto" style="width: 95%;">
                            @if(!empty($concepto_bryg))
                                <p class="text-justify color-sec">
                                    <b>
                                        Concepto del analista sobre la prueba:
                                    </b>
                                </p>

                                <p class="text-justify color-sec">
                                    {{ strip_tags($concepto_bryg->concepto) }}
                                </p>
                            @endif

                            <p class="text-justify color-sec">
                                <b>
                                    Archivo adjunto:
                                </b>

                                <a 
                                    href="{{ route('admin.prueba_bryg_informe', [$resp_bryg->id]) }}"
                                    class="enlace" 
                                    target="_blank"
                                >
                                    Ver informe BRYG
                                </a>
                            </p>
                        </div>
                    </section>
                @endif
            </section>
        @endif
        <!-- FIN PRUEBAS PSICOTECNICAS -->

        <!-- PRUEBAS -->
        @if($pruebas->count() >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">EVALUACIÓN PSICOMÉTRICA</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>

            <section>
                @foreach($pruebas as $key => $prueba)
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">
                            Prueba Realizada {{ $prueba->prueba_desc }}
                        </p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            <b>
                                Estado:
                            </b>
                            @if ($prueba->estado == 1)
                                Aprobo
                            @else
                                No aprobo
                            @endif
                        </p>

                        <p class="text-justify color-sec">
                            <b>
                                Concepto del analista sobre la prueba:
                            </b>
                        </p>

                        <p class="text-justify color-sec">
                            {!! strip_tags($prueba->resultado) !!}
                        </p>

                        <p class="text-justify color-sec">
                            <b>
                                Fecha Realización:
                            </b>

                            {{ \App\Models\DatosBasicos::convertirFecha($prueba->updated_at) }}

                            <br>

                            <b>
                                Analista que realizó el concepto:
                            </b>

                            {{ $prueba->name }}<br>

                            <b>
                                Archivo Adjunto:
                            </b>
                            <a href='{{route("view_document_url", encrypt("recursos_pruebas/"."|".$prueba->nombre_archivo))}}' class="enlace" target="_blank">
                                Ver Archivo
                            </a>
                        </p>
                    </div>
                @endforeach
            </section>
        @endif

        <?php
            $resp_digitacion = null;

            if(!empty($reqcandidato)) {
                $resp_digitacion = App\Http\Controllers\PruebaDigitacionController::digitacionCandidato($datos_basicos->user_id, $reqcandidato->requerimiento_id);
            }
        ?>

        <!-- PRUEBAS TECNICAS -->
        @if ($resp_user_excel_basico != null || $resp_user_excel_intermedio != null || $resp_digitacion != null)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">PRUEBAS TÉCNICAS</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>

            <section>
                @if($resp_digitacion != null)
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">
                            Prueba Digitación
                        </p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>

                    <?php
                        $concepto_digitacion = App\Http\Controllers\PruebaDigitacionController::digitacionCandidatoConcepto($resp_digitacion->id);
                    ?>
                    <div class="m-auto" style="width: 95%;">
                        @if(!empty($concepto_digitacion))
                            <p class="text-justify color-sec">
                                <b>
                                    Concepto del analista sobre la prueba:
                                 </b>
                            </p>

                            <p class="text-justify color-sec">
                                {{ strip_tags($concepto_digitacion->concepto) }}
                            </p>
                        @endif

                        <p class="text-justify color-sec">
                            <b>
                                Archivo adjunto:
                            </b>

                            <a 
                                href="{{ route('admin.prueba_digitacion_informe', [$resp_digitacion->id]) }}"
                                class="enlace" 
                                target="_blank"
                            >Ver informe Digitación</a>
                        </p>
                    </div>
                @endif

                @if($resp_user_excel_basico != null)
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">
                            Prueba Excel Básico
                        </p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>

                    <?php $concepto_final = $resp_user_excel_basico->concepto_final; ?>

                    <div class="m-auto" style="width: 95%;">
                        @if($concepto_final != null && $concepto_final != '')
                            <p class="text-justify color-sec">
                                <b>
                                    Concepto del analista sobre la prueba:
                                 </b>
                            </p>

                            <p class="text-justify color-sec">
                                {{ strip_tags($concepto_final) }}
                            </p>
                        @endif

                        <p class="text-justify color-sec">
                            <b>Calificación obtenida: </b>{{ $resp_user_excel_basico->calcularCalificacion() }}%
                            <br>
                            <?php
                                $config_prueba_excel = $resp_user_excel_basico->configuracionReq;
                            ?>
                            <b>Calificación minima: </b>{{ $config_prueba_excel->aprobacion_excel_basico }}%
                            <br>
                            <b> Fecha de realización: </b> {{ \App\Models\DatosBasicos::convertirFecha($resp_user_excel_basico->fecha_respuesta) }}
                            <br>

                            @if($concepto_final != null && $concepto_final != '')
                                <b>
                                    Analista que realizó el concepto:
                                </b>
                                {{ $resp_user_excel_basico->datosBasicosUsuarioConcepto->nombres . ' ' . $resp_user_excel_basico->datosBasicosUsuarioConcepto->primer_apellido . ' ' . $resp_user_excel_basico->datosBasicosUsuarioConcepto->segundo_apellido }}
                                <br>
                            @endif
                            <b>
                                Archivo Adjunto:
                            </b>
                            <a href="{{url('admin/pdf_prueba/'.$resp_user_excel_basico->id)}}" target="_blank" class="enlace" >Ver Respuestas</a>
                        </p>
                    </div>
                @endif

                @if($resp_user_excel_intermedio != null)
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">
                            Prueba Excel Intermedio
                        </p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>

                    <?php $concepto_final = $resp_user_excel_intermedio->concepto_final; ?>

                    <div class="m-auto" style="width: 95%;">
                        @if($concepto_final != null && $concepto_final != '')
                            <p class="text-justify color-sec">
                                <b>
                                    Concepto del analista sobre la prueba:
                                 </b>
                            </p>

                            <p class="text-justify color-sec">
                                {{ strip_tags($concepto_final) }}
                            </p>
                        @endif

                        <p class="text-justify color-sec">
                            <b>
                                Calificación obtenida:
                            </b>
                            {{ $resp_user_excel_intermedio->calcularCalificacion() }}%
                            <br>
                            <?php
                                $config_prueba_excel = $resp_user_excel_intermedio->configuracionReq;
                            ?>
                            <b>Calificación minima: </b>{{ $config_prueba_excel->aprobacion_excel_basico }}%
                            <br>
                            <b>Fecha de realización: </b> {{ \App\Models\DatosBasicos::convertirFecha($resp_user_excel_intermedio->fecha_respuesta) }}
                            <br>

                            @if($concepto_final != null && $concepto_final != '')
                                <b>
                                    Analista que realizó el concepto:
                                </b>
                                {{ $resp_user_excel_intermedio->datosBasicosUsuarioConcepto->nombres . ' ' . $resp_user_excel_intermedio->datosBasicosUsuarioConcepto->primer_apellido . ' ' . $resp_user_excel_intermedio->datosBasicosUsuarioConcepto->segundo_apellido }}
                                <br>
                            @endif
                            <b>
                                Archivo Adjunto:
                            </b>
                            <a href="{{url('admin/pdf_prueba/'.$resp_user_excel_intermedio->id)}}" target="_blank" class="enlace" >Respuestas</a>
                        </p>
                    </div>
                @endif
            </section>
        @endif

        <!-- Examenes Medicos -->
        @if($examenes_medicos->count() >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">EXÁMENES MÉDICOS</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                @foreach($examenes_medicos as $key => $examen)
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            Archivo Adjunto: 
                            <a href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$examen->nombre_archivo))}}' class="enlace" target="_blank">
                                Ver Examen Médico
                            </a>
                        </p>
                    </div>
                @endforeach
            </section>
        @endif

        <!-- Estudio Seguridad -->
        @if($estudio_seguridad->count() >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">ESTUDIO SEGURIDAD</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                @foreach($estudio_seguridad as $key => $seguridad)
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            <b>Estudio Seguridad {{ $seguridad->descripcion_archivo }}</b>
                        </p>
                        <p class="text-justify color-sec">
                            Archivo Adjunto:
                            <a href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$seguridad->nombre_archivo))}}' class="enlace" target="_blank">
                                Ver Estudio de Seguridad
                            </a>
                        </p>
                    </div>
                @endforeach
            </section>
        @endif

        {{-- Tusdatos.co --}}
        @if($sitioModulo->consulta_tusdatos == 'enabled')
            @if(!empty($tusdatosData))
                <section class="secciones-titulos-2">
                    <h2 style="color: #6F3795;">CONSULTA DE SEGURIDAD</h2>
                    <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
                </section>
                <section>
                    @if ($tusdatosData->status == 'procesando')
                        {{-- nada --}}
                    @elseif($tusdatosData->status == 'finalizado')
                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                <b>Archivo adjunto: </b>
                                <a 
                                    class="enlace" 
                                    target="_blank" 
                                    href="{{ route('tusdatos_reporte', ['check' => $tusdatosData->id]) }}"
                                >
                                    Ver PDF
                                </a>
                            </p>
                        </div>
                    @else
                        {{-- nada --}}
                    @endif
                </section>
            @endif
        @endif

        @if($sitioModulo->consulta_seguridad == 'enabled' && $consulta_seguridad_proceso)
            @if($consulta_seg !== null)
                @if($consulta_seg->count() >= 1)
                    <section class="secciones-titulos-2">
                        <h2 style="color: #6F3795;">CONSULTA DE SEGURIDAD</h2>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
                    </section>

                    <section>
                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                <b>Archivo adjunto: </b>
                                <a 
                                    class="enlace" 
                                    target="_blank" 
                                    href='{{route("view_document_url", encrypt("recursos_pdf_consulta/"."|".$consulta_seg->pdf_consulta_file))}}'
                                >
                                    Ver PDF Consulta Seguridad
                                </a>
                            </p>
                        </div>
                    </section>
                @endif
            @endif
        @endif

        @if ($sitioModulo->listas_vinculantes == 'enabled' && $listas_vinculantes_proceso)
            @if (!empty($consulta_lista_vinculante))
                @if($consulta_lista_vinculante->count() >= 1)
                    <section class="secciones-titulos-2">
                        <h2 style="color: #6F3795;">LISTAS VINCULANTES</h2>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
                    </section>

                    <section>
                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                                <b>Archivo adjunto: </b>
                                <a 
                                    class="enlace" 
                                    target="_blank" 
                                    href='{{ route("view_document_url", encrypt("recursos_listas_vinculantes/"."|".$consulta_lista_vinculante->pdf_consulta_file)) }}'
                                >
                                    Ver PDF Listas Vinculantes
                                </a>
                            </p>
                        </div>
                    </section>
                @endif
            @endif
        @endif

        <!-- REFERENCIACION -->
        @if ($experiencias_verificadas->count() >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">REFERENCIACIÓN</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                @foreach ($experiencias_verificadas as $exp)
                    <div class="ml-05">
                        <p class="color fw-700" style="font-size: 12pt;">
                            Referencia realizada a la experiencia en {{ ucwords(mb_strtolower($exp->nombre_empresa)) }}
                        </p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            @if ($exp->fecha_retiro != '0000-00-00' &&  $exp->fecha_retiro != null)
                                {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeñó en el cargo {{ mb_strtolower($exp->cargo_especifico) }}, durante {{ \App\Models\Experiencias::añosMeses($exp->exp_fecha_inicio, $exp->exp_fechafin)}}, 
                                     iniciando sus labores el {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_inicio) }} hasta  {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_retiro) }} bajo la supervisión de {{ ucwords(mb_strtolower($exp->nombres_jefe)) }}
                                @if ($exp->fijo_jefe > 0)
                                    (Tel. {{ $exp->fijo_jefe }} / {{ $exp->movil_jefe }})
                                @else
                                    (Tel. {{ $exp->movil_jefe }})
                                @endif
                                quien ejercía como {{ $exp->cargo_jefe}}.
                            @else
                                {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} se desempeña en el cargo {{ mb_strtolower($exp->cargo_especifico) }}, 
                                iniciando sus labores el {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_inicio) }} bajo la supervisión de {{ ucwords(mb_strtolower($exp->nombres_jefe)) }}
                                @if ($exp->fijo_jefe > 0)
                                    (Tel. {{ $exp->fijo_jefe }} / {{ $exp->movil_jefe }})
                                @else
                                    (Tel. {{ $exp->movil_jefe }})
                                @endif
                                quien ejercía como {{ $exp->cargo_jefe}}.
                            @endif
                        </p>

                        <p class="text-justify color-sec">
                            <b> Realizando el proceso de referenciación se encontró que: </b>
                            <br><br>
                            <ul>
                                <li>
                                    La experiencia se referenció con {{ ucwords(mb_strtolower($exp->nombre_referenciante)) }} quien se desempeña como {{ mb_strtolower($exp->cargo_referenciante) }} @if($exp->adecuado) y de acuerdo con los datos recopilados, <b>se determina que {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} es {{$exp->adecuado}}</b>@endif.
                                </li>

                                @if($exp->name_motivo != '')
                                <li>
                                    La información suministrada por el referenciante indica que el motivo de retiro obedeció a {{mb_strtolower($exp->name_motivo)}}
                                    @if($exp->observaciones)
                                        argumentando las siguientes observaciones: {{$exp->observaciones}}.
                                    @else
                                    .
                                    @endif
                                </li>
                                @endif

                                <li>
                                    {{ ucwords(mb_strtolower($datos_basicos->nombres)) }}
                                    @if($exp->cuantas_personas)
                                      tuvo {{ $exp->cuantas_personas }} personas a cargo,
                                    @else
                                      no tuvo personas a cargo,
                                    @endif

                                    @if($exp->porque_obj != '' && $exp->porque_obj != null)

                                    el referenciante considera que
                                    @if($exp->volver_contratarlo) si @else no @endif
                                    volvería a contratarlo porque {{mb_strtolower($exp->porque_obj)}} 

                                    @endif.
                                </li>
                            </ul>
                        </p>
                    </div>
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">
                            Información suministrada por Recursos Humanos
                        </p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            <ul>
                                <li>
                                    Cargo desempeñado: {{ $exp->cargo2 }}
                                </li>
                                <li>
                                    Fecha de inicio: {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_inicio) }}
                                </li>
                                @if($exp->fecha_retiro > 0)
                                    <li>
                                        Fecha de finalización: {{ \App\Models\DatosBasicos::convertirFecha($exp->fecha_retiro) }}
                                    </li>
                                @endif
                                <li>
                                    @if ($exp->anotacion_hv)
                                        La anotación que tiene en la hoja de vida es:
                                        @if ($exp->cuales_anotacion)
                                            {{ $exp->cuales_anotacion }}
                                        @endif
                                    @else
                                        No tiene anotaciones en la hoja de vida.
                                    @endif
                                </li>
                            </ul>
                        </p>
                        @if($exp->observaciones_referencias)
                            <p class="text-justify color-sec">
                                <b> Observaciones Generales de la referenciación </b>
                            </p>

                            <p class="text-justify color-sec">
                                {{ $exp->observaciones_referencias }}
                            </p>
                            <br><br>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif

        <!-- REFERENCIA ESTUDIOS-->
        @if ($referencias_estudios_verificados->count() >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">REFERENCIACIÓN ACADÉMICA</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                @foreach ($referencias_estudios_verificados as $estudio)
                    <div class="ml-05">
                        <p class="color fw-700" style="font-size: 12pt;">
                            Referencia realizada al estudio {{$estudio->titulo_obtenido}} en {{$estudio->institucion}}
                        </p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} @if( $estudio->estudio_actual ) realiza @else realizó @endif sus estudios como {{$estudio->nivel}} en el 
                            programa de {{$estudio->programa}} en la institución {{$estudio->institucion}}, desde {{$estudio->fecha_inicio}} hasta {{$estudio->fecha_finalizacion}}, @if( $estudio->estudio_actual ) para obtener @else obteniendo @endif el título de {{$estudio->titulo_obtenido}}.
                            <br>
                            @if( $estudio->nombre_referenciante != null )
                                El estudio fue referenciado por {{$estudio->nombre_referenciante}} quien se desempeña como {{$estudio->cargo_referenciante}} en la institución {{$estudio->institucion}}.
                                <br>
                                Las observaciones generales de la referenciación académica son: {{$estudio->observaciones_referenciante}}.
                            @else

                                El estudio fue referenciado por recursos humanos de {{$sitio->nombre}} y las observaciones generales de la referencia son:
                                {!! $estudio->observaciones_referenciante !!}

                            @endif
                        </p>
                    </div>
                @endforeach
            </section>
        @endif

        <!-- REFERENCIACION VERIFICADA -->
        @if(count($rpv)>0)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">REFERENCIACIÓN</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                <div class="m-auto" style="width: 95%;">
                    <p class="text-justify color-sec">
                        <b>Reaccion Ante Dificultades: </b>
                        {{$rpv->dificultades}}
                    </p>
                    <p class="text-justify color-sec">
                        <b>Su Mejor Cualidad: </b>
                        {{$rpv->cualidades}}
                    </p>
                    <p class="text-justify color-sec">
                        <b>Manifiesta Sus Desacuerdos: </b>
                        {{$rpv->desacuerdo}}
                    </p>
                    <p class="text-justify color-sec">
                        <b>Debe Mejorar: </b>
                        {{$rpv->debe_mejorar}}
                    </p>
                    <p class="text-justify color-sec">
                        <b>Sus Relaciones Interpersonales: </b>
                        {{$rpv->relaciones_interpersonales}}
                    </p>
                </div>
            </section>
        @endif

        <!-- Validacion documental -->
        @if (count($validacion_documental) >= 1)
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">VALIDACIÓN DOCUMENTAL</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            <section>
                <div class="m-auto" style="width: 95%;">
                    @foreach ($validacion_documental as $doc)
                        <p class="text-justify color-sec">
                            <b> Tipo de documento: </b>
                            {{$doc->tipo_doc }}
                            <br>
                            <b> Resultado: </b>
                            @if ($doc->resultado == '1')
                                Apto
                            @elseif ($doc->resultado == '2')
                                No apto
                            @endif
                            <br>
                            @if ($doc->fecha_vencimiento != null && $doc->fecha_vencimiento != '0000-00-00')
                                <b> Fecha vencimiento: </b>
                                {{ $doc->fecha_vencimiento }}
                                <br>
                            @endif
                        </p>
                        <p class="text-justify color-sec">
                            <b> Observación: </b>
                            {{ $doc->observacion }}
                            <br>
                            <b> Archivo: </b>
                            <a href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$doc->nombre_archivo))}}' class="enlace" target="_blank">
                                Ver Archivo
                            </a>
                            <br>
                        </p>
                    @endforeach
                </div>
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