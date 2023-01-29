<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        <title> {{ $titulo_prueba }} </title>

        <script src="https://kit.fontawesome.com/a23970da56.js" crossorigin="anonymous"></script>
    </head>
  
    <style>

        body{
            font-family: 'Roboto', sans-serif;
            font-size: 11px;
            background-color: #f1f1f1;
        }

        .text-center{ text-align: center; }
        .text-left{ text-align: left; }
        .text-right{ text-align: right; }
        .text-justify{ text-align: justify; }

        .table{ border-collapse:separate; }

        .font-size-10{ font-size: 10pt; }
        .font-size-11{ font-size: 11pt; }
        .font-size-12{ font-size: 12pt; }
        .font-size-14{ font-size: 14pt; }
        .font-size-16{ font-size: 16pt; }

        .m-0{ margin: 0; }
        .m-1{ margin: 1rem; }
        .m-2{ margin: 2rem; }
        .m-3{ margin: 3rem; }
        .m-4{ margin: 4rem; }

        .ml-0{ margin-left: 0; }
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

        .bg-blue{ background-color: #2E2D66; color: white; }
        .bg-dark-blue{ background-color: #2c3e50; color: white; }
        .bg-red{ background-color: #D92428; color: white; }
        .bg-yellow{ background-color: #E4E42A; color: white; }
        .bg-green{ background-color: #00A954; color: white; }

        .color-blue{ color: #2E2D66; }
        .color-red{ color: #D92428; }
        .color-yellow{ color: #E4E42A; }
        .color-green{ color: #00A954; }

        .otra tr td{
            font-size: 12px;
            padding-left: 50px;
            padding-top: 13px;
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
            border: none;
            padding: 0;
            margin: 0;
        }

        .tabla2 td {
            padding: 0;
            margin: 0;
        }

        .tabla2 th {
            background-color: #fdf099;
            font-size: 14px;
            font-weight: bold;
            padding: 0;
            margin: 0;
            text-align: center;
            /*text-transform: capitalize;*/
        }

        @page {
            margin: 0.8cm 0.8cm;
            font-family: 'Roboto', sans-serif;
        }

        body {
            margin: 1cm 2cm 2cm;
        }

        main {
            width: 80%;
            margin: auto;

            padding: 1rem;
            border-radius: 1rem;
            border: solid 1px #ddd;
            background-color: white;
        }

        .page-break {
            page-break-after: always;
        }

        .profile-picture{
            padding: .25rem;
            width: 100px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            max-width: 100%;
        }

        .divider{ width: 44.5%; background-color: #2E2D66; color: #2E2D66; border: 0; height: 1px; }
        .divider-th{ width: 90%; background-color: #2E2D66; color: #2E2D66; border: 0; height: 1px; }

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
            width: 100%;
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

        .correcto {
            background-color: #b9fd99;
        }

        .opcion-elegida {
            background-color: #fdf099;
        }

        .pregunta {
            text-align: left;
            width: 90%;
            font-weight: bold;
        }

        .cubrir-100-porc {
            width: 100%;
        }

        .pl-45 {
            padding-left: 45px;
        }

        section {
            font-size: 14px;
        }

        @media (max-width: 720px) {
            main {
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .section-descarga {
                margin-left: auto !important;
                margin-right: auto !important;
            }
            footer {
                display: none;
            }
            body {
                margin: 0cm !important;
            }
        }

        @media print {
            main {
                width: 100%;

                padding: 0rem;
                border-radius: 0rem;
                border: none;
                background-color: none;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-bottom: 80px !important;
            }
            .section-descarga {
                display: none;
            }
            body {
                background-color: transparent !important;
            }
        }

        .mx-100 {
            margin-left: 100px;
            margin-right: 100px;
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
    <body>
        <div class="section-descarga mx-100" style="border: solid 1px #ddd; width: 80%; background-color: white; padding: 1rem; border-radius: 1rem; margin-bottom: 1rem; margin-top: 1rem;">
            <div class="text-right">
                <button class="btn btn-default" onclick="window.print()">Descargar PDF <i class="fas fa-download"></i></button>
            </div>
        </div>

        <main class="mx-100">
            {{-- Logos T3RS y cliente --}}
            <section>
                <table width="100%">
                    <tr>
                        <td class="text-left">
                            <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-src/tri-new-logo-horizontal-letter.png" alt="T3RS" width="100">
                        </td>
                        <td></td>
                        <td class="text-right">
                            @if(!triRoute::validateOR('local'))
                                <img src="{{ asset("configuracion_sitio/$sitio_informacion->logo") }}" alt="T3RS" height="60">
                            @else
                                <img src="https://picsum.photos/120/60" alt="T3RS" height="60">
                            @endif
                        </td>
                    </tr>
                </table>
            </section>
            <h3 class="text-center"> {{ $titulo_prueba }} </h3>

            {{-- Foto de perfil del candidato (si posee) --}}
            <section>
                <div class="text-center">
                    @if(!triRoute::validateOR('local'))
                        @if(!empty($respuesta_user->foto_perfil))
                            <img 
                                src="{{ url("recursos_datosbasicos/$respuesta_user->foto_perfil") }}" 
                                alt="Foto de perfil" 
                                class="profile-picture" 
                                width="100"
                            >
                        @else
                            <img 
                                src="{{ url('img/personaDefectoG.jpg') }}" 
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
                        <li><b>{{ $respuesta_user->nombres.' '.$respuesta_user->primer_apellido.' '.$respuesta_user->segundo_apellido }}</b></li>
                        <li>{{ $respuesta_user->tipo_id_desc }} {{ $respuesta_user->numero_id }}</li>
                        <li>{{ $respuesta_user->telefono_movil }}</li>
                        <li>{{ $respuesta_user->email }}</li>
                    </ul>
                </div>
            </section>

            {{-- Datos del requerimiento --}}
            <section>
                <div class="mt-1">
                    <table width="100%">
                        <tr>
                            <th class="text-left" width="50%">
                                <p class="color-blue m-0">
                                    Cargo en el que se evalúa
                                    <hr align="left" class="divider-th">
                                </p>
                                <p class="ml-2" style="margin-top: -5px; font-weight: initial;">{{ ucfirst(mb_strtolower($respuesta_user->requerimiento->cargo_req())) }}</p>
                            </th>

                            <th class="text-left" width="50%">
                                <p class="color-blue m-0">
                                    Requerimiento
                                    <hr align="left" class="divider-th">
                                </p>
                                <p class="ml-2" style="margin-top: -5px; font-weight: initial;">{{ $respuesta_user->requerimiento->id }}</p>
                            </th>
                        </tr>
                    </table>

                    <p class="color-blue m-0">
                        <b>Cliente</b>
                        <hr align="left" class="divider">
                    </p>
                    <p class="ml-2" style="margin-top: -5px;">{{ ucfirst($respuesta_user->requerimiento->nombre_cliente_req()) }}</p>

                    <p class="color-blue m-0">
                        <b>Fecha solicitud de prueba</b>
                        <hr align="left" class="divider">
                    </p>
                    <p class="ml-2" style="margin-top: -5px;">{{ $respuesta_user->formatoFecha($proceso->created_at) }}</p>
                </div>
            </section>

            <section>
                <div class="mt-2">
                    <h4 class="text-center">RESULTADOS</h4>
                    <table class="tabla1 cubrir-100-porc">
                        <?php
                            $respuestas = $respuesta_user->getRespuestasExcel;
                            $letras = ['a)', 'b)', 'c)', 'd)', 'e)', 'f)'];
                        ?>
                        @foreach($respuestas as $key => $resp)
                            <?php
                                $pregunta = $resp->pregunta;
                                $opciones = $resp->opciones;
                            ?>
                            <tr>
                                <td class="pregunta">
                                    {{ $key+1 }}- {{ $pregunta->descripcion }}
                                </td>
                            </tr>
                            @foreach($opciones as $llave => $op)
                                <?php
                                    $class_adicional = '';
                                    if ($op->id == $resp->opcion_id) {
                                        if ($op->correcta) {
                                            $class_adicional .= ' correcto';
                                        } else {
                                            $class_adicional = 'opcion-elegida';
                                        }
                                    } else if ($op->correcta) {
                                        $class_adicional .= ' correcto';
                                    }
                                ?>
                                <tr>
                                    <td class="cubrir-100-porc pl-45 {{ $class_adicional }}">
                                        {{ $letras[$llave] }} {{ $op->descripcion }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                </div>
            </section>

            <section>
                <hr class="divider-th">
                <table width="100%">
                    <tr>
                        <th class="text-left" width="50%">
                            <p>Nombre:  {{ $respuesta_user->nombres.' '.$respuesta_user->primer_apellido.' '.$respuesta_user->segundo_apellido}} </p>
                            <p> {{ $respuesta_user->tipo_id_desc }}: {{ $respuesta_user->numero_id }}</p>
                            <p>Fecha: {{ $respuesta_user->formatoFecha($respuesta_user->fecha_respuesta) }}</p>
                        </th>

                        <th class="text-right" width="50%">
                            <?php
                                $porc = 0;
                                if ($respuesta_user->total_preguntas > 0) {
                                    $porc = $respuesta_user->respuestas_correctas * 100 / $respuesta_user->total_preguntas;
                                }
                            ?>
                            <p class="font-size-16">Respuestas correctas {{ $respuesta_user->respuestas_correctas }}/{{ $respuesta_user->total_preguntas }}</p>
                            <p class="font-size-16">
                                Puntuación <span style="text-align: right; margin-left:20px;">{{ $porc }}%</span>
                            </p>
                        </th>
                    </tr>
                </table>
            </section>

            <?php
                $concepto = $respuesta_user->concepto_final;
                $gestion_concepto = $respuesta_user->datosBasicosUsuarioConcepto;
                $solicitada_por = $proceso->datosBasicosUsuarioEnvio;
            ?>

            @if(!empty($concepto))
                {{-- Concepto final de la prueba --}}
                <section>
                    <p class="text-center">
                        <b>
                            Concepto final sobre la prueba de Excel realizada por nuestro especialista en selección de personal.
                        </b>
                    </p>
                </section>

                {{-- Contenido del concepto --}}
                <section>
                    <div class="text-justify mt-1 mb-1">
                        <p>
                            {!! ucfirst($concepto) !!}
                        </p>
                    </div>
                </section>
            @endif

            {{-- Información final --}}
            <section>
                <div class="text-justify">
                    <p>
                        Prueba realizada el {{ $respuesta_user->formatoFecha($respuesta_user->fecha_respuesta) }} - solicitada por {{ $solicitada_por->nombres }} {{ $solicitada_por->primer_apellido }} {{ $solicitada_por->segundo_apellido }} @if(!empty($concepto)) y evaluada por nuestro analista de selección {{ $gestion_concepto->nombres . ' ' . $gestion_concepto->primer_apellido . ' ' . $gestion_concepto->segundo_apellido }} @endif.
                    </p>
                </div>
            </section>

            <?php
                $fotos = $respuesta_user->getFotosArray();
                if ($respuesta_user->tipo == 'basico') {
                    $ruta = 'recursos_prueba_excel/prueba_excel_basico_'.$respuesta_user->user_id.'_'.$respuesta_user->req_id;
                } else if ($respuesta_user->tipo == 'intermedio') {
                    $ruta = 'recursos_prueba_excel/prueba_excel_intermedio_'.$respuesta_user->user_id.'_'.$respuesta_user->req_id;
                }
            ?>
            {{-- Separar contenido a nueva hoja --}}
            <div class="page-break"></div>

            <table class="text-center">
                <tr>
                    <td><h2> Fotos tomadas al candidato al momento de realizar la prueba </h2></td>
                </tr>
            </table>
            @if(count($fotos) > 0)
                @foreach($fotos as $foto)
                    @if($foto != null && $foto != '')
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img alt="foto" src="{{url($ruta.'/'.$foto)}}" width="320">
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-justify">No existe registro fotográfico ya que el candidato no contaba con cámara fotográfica al momento de realizar la prueba.</p>
                    </div>
                </div>
            @endif
        </main>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(function() {
            $('#guardar').click(function() {
                window.print();
            });
        });
    </script>
</html>
