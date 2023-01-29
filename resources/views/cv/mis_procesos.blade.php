@extends("cv.layouts.master")

<?php
    $porcentaje = FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
?>

@section("menu_candidato")
    @include("cv.includes.menu_candidato")
@endsection

@section('content')
    <style>
        .mt{ margin-top: 4rem; }

        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .grid-container{ overflow-x: hidden !important; }

        .modal-dialog { width: 800px; margin: 30px auto; }

        /*Radio group*/
        .radio-button-group {
            display: flex;
        }
        .radio-button-group .item {
            width: 100%;
        }
        .radio-button-group .radio-button {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
        }
        .radio-button-group .radio-button + label {
            padding: 16px 10px;
            cursor: pointer;
            border: 1px solid #CCC;
            margin-right: -2px;
            color: #555;
            background-color: #ffffff;
            display: block;
            text-align: center;
        }
        .radio-button-group .radio-button + label:hover {
            background-color: #f1f1f1;
        }
        .radio-button-group .item:first-of-type .radio-button + label{
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
        .radio-button-group .item:last-of-type .radio-button + label {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .radio-button-group .radio-button:checked + label {
            background-color: #5cb85c;
            color: #FFF;
        }
        .radio-button-group .radio-button:disabled + label {
            background-color: gray;
            color: #FFF;
            cursor: not-allowed;
        }

        .agendada{ opacity: 0.4; pointer-events: none; }

        .text-align--initial { text-align: initial; }
        .img-width--initial { max-width: initial; }

        .pd-1{ padding-bottom: 1rem; }
        .pd-2{ padding-bottom: 2rem; }

        .c-r {
            color: #d9534f;
        }

        .c-b {
            color: blue;
        }

        .c-g {
            color: green;
        }

        .fa-2 {
            font-size: 2em;
        }

        .step-list { list-style: none; counter-reset: step-counter; white-space: nowrap; }

        .step-list__item {
            white-space: normal;
            vertical-align: top;
            display: inline-block;
            width: 15rem;
            position: relative;
            text-align: center;
            padding-top: 4rem;
            font-size: 1.3rem;
        }

        .step-list__item_in_process {
            white-space: normal;
            vertical-align: top;
            display: inline-block;
            width: 15rem;
            position: relative;
            text-align: center;
            padding-top: 4rem;
            font-size: 1.3rem;
        }

        /* Circles */
        .step-list__item::after {
            /*counter-increment: step-counter;*/
            content: "";
            position: absolute;
            width: 3rem;
            height: 3rem;
            line-height: 2.53rem;
            border-radius: 100%;
            border: solid 0.2rem #B6B6B6;
            background-color: #FFF;
            left: 0;
            right: 0;
            top: 1rem;
            margin: auto;
            text-align: center;
        }

        .step-list__item_in_process::after {
            /*counter-increment: step-counter;*/
            content: "";
            position: absolute;
            width: 3rem;
            height: 3rem;
            line-height: 2.53rem;
            border-radius: 100%;
            border: solid 0.2rem #00b248;
            background-color: #FFF;
            left: 0;
            right: 0;
            top: 1rem;
            margin: auto;
            text-align: center;
        }

        .step-item-fail::after {
            font-family: "FontAwesome";
            content: "\f00d";
            font-size: 1.6rem;
        }

        .step-item-success::after {
            font-family: "FontAwesome";
            content: "\f00c";
            font-size: 1.6rem;
        }

        /* Lines */
        .step-list__item:nth-of-type(n+2)::before {
            content: "";
            position: absolute;
            width: 14rem;
            height: 2px;
            background-color: #CCC;
            right: 50%;
            top: 2.3rem;
        }

        .step-list__item_in_process:nth-of-type(n+2)::before {
            content: "";
            position: absolute;
            width: 14rem;
            height: 2px;
            background-color: #CCC;
            right: 50%;
            top: 2.3rem;
        }

        /* Actives */
        .step-active--fail {
            color: #e53935;
            font-weight: bold;
        }

        .step-active--success {
            color: #00b248;
            font-weight: bold;
        }

        .step-list__item--active {
            color: {{ $instanciaConfiguracion->color }};
            font-weight: bold;
        }

        .step-list__item--active::after, .step-list__item--active::before {
            font-weight: normal;
            color: #FFF;
            background-color: {{ $instanciaConfiguracion->color }} !important;
            border-color: {{ $instanciaConfiguracion->color }} !important;
        }

        .step-active--fail::after, .step-active--fail::before {
            font-weight: normal;
            color: #FFF;
            background-color: #e53935 !important;
            border-color: #e53935 !important;

            outline: none;
            border-color: #c92e2a;
            box-shadow: 0 0 6px #c92e2a;
        }

        .step-active--success::after, .step-active--success::before {
            font-weight: normal;
            color: #FFF;
            background-color: #00b248 !important;
            border-color: #00b248 !important;

            outline: none;
            border-color: #00ad46;
            box-shadow: 0 0 6px #00ad46;
        }
    </style>

    <div class="col-right-item-container">
        <div class="container-fluid">
            <div class="col-md-12 all-categorie-list-title bt_heading_3">
                <h1>Mis Procesos</h1>

                <div class="blind line_1"></div>
                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                <div class="blind line_2"></div>
            </div>

            <div class="row">
                <h3 class="header-section-form"></h3>

                <div class="col-md-12">
                    <p class="text-primary set-general-font-bold">
                        Aquí podrá encontrar los procesos en los que ha participado o está participando actualmente.
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @if ($oferta_candidato != null)
                        <?php
                            $procesoSeleccion = FuncionesGlobales::stepProcesoSeleccion($oferta_candidato->req_id, $user_id);
                            $procesoEvaluacion = FuncionesGlobales::stepEvaluacionCliente($oferta_candidato->req_id, $user_id);
                            $procesoFinalista = FuncionesGlobales::stepFinalista($oferta_candidato->req_id, $user_id);
                            $procesoContratado = FuncionesGlobales::stepContratado($oferta_candidato->req_id, $user_id);
                        ?>
                        <div class="panel panel-default text-align--initial">
                            <div class="panel-body">
                                <div class="col-md-2 mb-2 mt-1">
                                    <img 
                                        class="img-width--initial" 
                                        src="{{ url(((!empty($sitio->logo)) ? "configuracion_sitio/$sitio->logo" : "img/personaDefectoG.jpg")) }}" 
                                        alt="{{ $oferta_candidato->oferta_cargo }}"
                                        width="120" 
                                    >
                                </div>

                                <div class="col-md-8 mb-2 mt-1">
                                    <p>
                                        <b>{{ $oferta_candidato->oferta_cargo }}</b>
                                    </p>
                                    <p>
                                        <small style="color: gray;">
                                            <i class="fa fa-calendar-o" aria-hidden="true"></i> Publicación: {{ date('Y-m-d', strtotime($oferta_candidato->fecha_publicacion)) }} | 
                                            <b><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $oferta_candidato->sitio_trabajo }}</b>
                                        </small>
                                    </p>
                                </div>

                                @if($oferta_candidato->estado_publico == 0)
                                    <div class="col-md-2 mt-1">
                                        <span 
                                            class="label label-danger"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            data-container="body"
                                            title="Se han completado todos lo procesos y la oferta ha sido cerrada."
                                        >
                                            Oferta terminada
                                        </span>
                                    </div>
                                @endif

                                <?php
                                    $meses = [1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic"];

                                    $fecha_aplicacion = date('d-m', strtotime($oferta_candidato->fecha_aplicacion));
                                    $fecha_aplicacion = explode("-", $fecha_aplicacion);

                                    $dia = $fecha_aplicacion[0];
                                    $mes = (int)$fecha_aplicacion[1];

                                    $fecha_aplicacion = "$dia $meses[$mes]";
                                ?>

                                <div class="col-md-12 text-center">
                                    <ul class="step-list" style="overflow-x: auto;">
                                        @if(!empty($procesoAplicacion['proceso'])))
                                            <li class="step-list__item step-item-success step-active--success">
                                                Aplicación
                                                <br>
                                            <small style="color: gray;">{{ $procesoAplicacion['procesoFecha'] }}</small>
                                            </li>
                                        @endif

                                        @if($procesoSeleccion['apto'] == 1)
                                            <li class="step-list__item step-item-success step-active--success">
                                                En proceso selección
                                                <br>
                                                <small style="color: gray;">{{ $procesoSeleccion['procesoFecha'] }}</small>
                                            </li>
                                        @else
                                            <li class="step-list__item step-item-fail step-active--fail">En proceso selección</li>
                                        @endif

                                        @if($procesoEvaluacion['proceso']->apto == 1)
                                            <li class="step-list__item step-item-success step-active--success">
                                                Evaluación del cliente
                                                <br>
                                                <small style="color: gray;">{{ $procesoEvaluacion['procesoFecha'] }}</small>
                                            </li>
                                        @elseif($procesoEvaluacion['proceso']->apto == 2)
                                            <li class="step-list__item step-item-fail step-active--fail">
                                                Evaluación del cliente
                                                <br>
                                                <small style="color: gray;">{{ $procesoEvaluacion['procesoFecha'] }}</small>
                                            </li>
                                        @elseif(!empty($procesoEvaluacion['proceso']))
                                            @if (is_null($procesoEvaluacion['proceso']->apto))
                                                <li class="step-list__item_in_process">Evaluación del cliente</li>
                                            @endif
                                        @elseif(empty($procesoEvaluacion['proceso']))
                                            <li class="step-list__item">Evaluación del cliente</li>
                                        @else
                                            <li class="step-list__item">Evaluación del cliente</li>
                                        @endif

                                        @if($instanciaConfiguracion->precontrata == 1)
                                            @if(empty($procesoFinalista['proceso']))
                                                <li class="step-list__item">Finalista</li>
                                            @elseif($procesoFinalista['proceso']->apto == 1)
                                                <li class="step-list__item step-item-success step-active--success">
                                                    Finalista
                                                    <br>
                                                    <small style="color: gray;">{{ $procesoFinalista['procesoFecha'] }}</small>
                                                </li>
                                            @elseif($procesoFinalista['proceso']->apto == 2)
                                                <li class="step-list__item step-item-fail step-active--fail">
                                                    Finalista
                                                    <br>
                                                    <small style="color: gray;">{{ $procesoFinalista['procesoFecha'] }}</small>
                                                </li>
                                            @elseif(is_null($procesoFinalista['proceso']->apto))
                                                <li class="step-list__item">Finalista</li>
                                            @endif
                                        @else
                                            @if(empty($procesoContratado['apto']))
                                                <li class="step-list__item">Finalista</li>
                                            @elseif($procesoContratado['apto'] == 1)
                                                <li class="step-list__item step-item-success step-active--success">
                                                    Finalista
                                                    <br>
                                                    <small style="color: gray;">{{ $procesoContratado['procesoFecha'] }}</small>
                                                </li>
                                            @elseif($procesoContratado['apto'] == 0)
                                                <li class="step-list__item step-item-fail step-active--fail">
                                                    Finalista
                                                    <br>
                                                    <small style="color: gray;">{{ $procesoContratado['procesoFecha'] }}</small>
                                                </li>
                                            @else
                                                <li class="step-list__item">Finalista</li>
                                            @endif
                                        @endif

                                        @if(empty($procesoContratado))
                                            <li class="step-list__item ">Contratado</li>
                                        @elseif($procesoContratado['apto'] == 1)
                                            <li class="step-list__item step-item-success step-active--success">
                                                Contratado
                                                <br>
                                                <small style="color: gray;">{{ $procesoContratado['procesoFecha'] }}</small>
                                            </li>
                                        @elseif($procesoContratado['apto'] === 0)
                                            <li class="step-list__item step-item-fail step-active--fail">
                                                Contratado
                                                <br>
                                                <small style="color: gray;">{{ $procesoContratado['procesoFecha'] }}</small>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div id="accordion{{$oferta_candidato->req_id}}">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <a data-toggle="collapsed" data-target="#collapse{{$oferta_candidato->req_id}}" aria-expanded="true" aria-controls="collapse{{$oferta_candidato->req_id}}" style="cursor: pointer;">
                                        <h3 class="panel-title text-white">
                                            Procesos
                                        </h3>
                                    </a>
                                </div>
                                <div id="collapse{{$oferta_candidato->req_id}}" class="collapse{{$oferta_candidato->req_id}}" aria-labelledby="headingUno" data-parent="#accordion{{$oferta_candidato->req_id}}">
                                    <div class="panel-body py-0">
                                        <table width="100%">
                                            <tr>
                                                <th>Fecha solicitud</th>
                                                <th>Proceso</th>
                                                <th>Enlace</th>
                                                <th>Estado</th>
                                            </tr>
                                            <tbody>
                                                @forelse($procesos_candidato as $proc)
                                                    <tr>
                                                        <td align="left">{{ $proc->fecha_solicitud }}</td>
                                                        <td align="left">{{ $proc->nombre_visible }}</td>
                                                        @if ($proc->apto == null)
                                                            <td align="left">
                                                                <a class="btn btn-primary btn-xs" href="{{ $proc->ruta($user_id, $oferta_candidato->req_id, $oferta_candidato->ref_id) }}" target="_blank">
                                                                    Ir a Responder
                                                                </a>
                                                            </td>
                                                            <td align="left" class="c-r">
                                                                <i class="fa fa-exclamation-circle fa-2"></i> Pendiente
                                                            </td>
                                                        @else
                                                            <td></td>
                                                            <td align="left" class="c-g">
                                                                <i class="fa fa-check-circle-o fa-2"></i> Resuelta
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4">No hay procesos solicitados</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p>No hay procesos</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                @include('cv.includes.ofertas._section_oferta')
            </div>
        </div>
    </div>

    <div class="modal fade" id="reservarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
@stop