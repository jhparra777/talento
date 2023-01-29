<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>{{ $sitio->nombre }} - T3RS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    @if(isset($sitio->favicon))
        @if($sitio->favicon != "")
            <link href="{{ url('configuracion_sitio')}}/{{ $sitio->favicon }}" rel="shortcut icon">
        @else
            <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
        @endif
    @else
       <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
    @endif

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- SmokeJS - CSS --}}
    <link rel="stylesheet" href="{{ asset('js/smoke/css/smoke.min.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>

    <style>
        body{ background-color: #f1f1f1; }

        .card-header { background-color: transparent; border-bottom: none;}

        #gum {
            padding: 1px 1px;
            border: #2455e8 2px solid;
            border-radius: 20px;
            max-width: 100%;
        }

        #recorded {
            padding: 1px 1px;
            border: #2455e8 2px solid;
            border-radius: 20px;
            max-width: 100%;
        }

        #video-guardado {
            padding: 1px 1px;
            border: #2455e8 2px solid;
            border-radius: 20px;
        }

        .swal-button--catch {
            background-color: indianred;
        }

        .swal-button--defeat {
            background-color: forestgreen;
        }

        .borde-rojo-2x {
            border: #961212 2px solid !important;
            border-radius: 20px !important;
        }

        #img-grabacion {
            position: absolute;
            margin: 30px;
            margin-top: 20px !important;
            display: none;
            z-index: 1;
            margin-left: 8%;
        }

        #timer-video-descripcion {
            display: none;
        }

        #timer-video-descripcion .timer-container {
            display:table;
            color:#0061f2;
            font-weight:bold;
            text-align:center;
            text-shadow:1px 1px 4px #999;
        }

        #timer-video-descripcion .timer-container div span {
            font-size:40px;
            padding:10px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1 mt-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2">
                                @if(isset(FuncionesGlobales::sitio()->logo))
                                    @if(FuncionesGlobales::sitio()->logo != "")
                                        <img 
                                            class="img-fluid"
                                            width="100"
                                            src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}"
                                        >
                                    @else
                                        <img
                                            class="img-fluid"
                                            width="100"
                                            src="{{ url("img/logo.png")}}"
                                        >
                                    @endif
                                @else
                                    <img
                                        class="img-fluid"
                                        width="100"
                                        src="{{ url("img/logo.png")}}"
                                    >
                                @endif
                            </div>

                            <div class="col-md-8 d-flex justify-content-center align-items-center">
                                <h3>VIDEO ENTREVISTA VIRTUAL</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('img/email/video_entrevista.png') }}" class="img-fluid mt-4">
                            </div>

                            <div class="col-md-6">
                                <div class="list-group mt-4">
                                    @foreach($preguntas_entre as $key => $pregu)
                                        @if(\App\Models\PreguntasEntre::respuestas_candidato_static($user_id, $pregu->id) == 0)
                                            <button
                                                type="button"
                                                class="list-group-item list-group-item-action responder_pregunta"
                                                name="responder"
                                                id="responder"
                                                data-pregunta_id="{{ $pregu->id }}"
                                            >
                                                <i class="fa fa-video-camera" aria-hidden="true"></i> RESPONDER PREGUNTA {{ ++$key }}
                                            </button>
                                        @else
                                            <button
                                                type="button"
                                                class="list-group-item list-group-item-action list-group-item-success"
                                            >
                                                <i class="fa fa-check-circle" aria-hidden="true"></i> Realizada
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-3">
            <hr>
            <p class="text-muted text-center">T3RS Copyright © 2020</p>
        </footer>
    </div>

    <div class="modal fade" id="modal_pregunta" tabindex="-1" role="dialog" aria-labelledby="modal_pregunta" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal" id="modal_success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <h4 class="modal-title">Confirmación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="texto"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal_danger">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert-danger">
                    <h4 class="modal-title">Advertencia</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="texto"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    {{-- SmokeJS --}}
    <script src="{{ asset('js/smoke/js/smoke.min.js') }}"></script>
    {{-- SmokeJS - Language --}}
    <script src="{{ asset('js/smoke/lang/es.min.js') }}"></script>

    <script>
        inicio_grabacion = false;

        $(function () {
            $(".responder_pregunta").on("click", function() {
                var pregu_id = $(this).data("pregunta_id");

                $("#modal_pregunta .modal-content").load(
                    "{{ route('responder_pregunta_entre') }}",
                    "pregu_id="+ pregu_id +"&user_id="+{{ $user_id }},
                    function(response) {
                        $('#modal_pregunta').modal({ backdrop: 'static', keyboard: false });
                    }
                );
            });
        });

        function mensaje_success(mensaje) {
            $("#modal_success #texto").html(mensaje);
            $("#modal_success").modal("show");
        }

        function mensaje_danger(mensaje) {
            $("#modal_danger #texto").html(mensaje);
            $("#modal_danger").modal("show");
        }
    </script>
</body>
</html>