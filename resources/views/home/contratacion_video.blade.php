<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="{{csrf_token()}}" name="token"/>
        <title>
            @if(isset($sitio->nombre))
                @if($sitio->nombre != "")
                    {{ $sitio->nombre }} - Video contrato
                @else
                    Desarrollo | Video contrato
                @endif
            @else
                Desarrollo | Video-contrato
            @endif
        </title>
         @if($sitio->favicon)
            @if($sitio->favicon != "")
                <link href="{{ url('configuracion_sitio')}}/{{$sitio->favicon }}" rel="shortcut icon">
            @else
                <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
            @endif
        @else
            <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
        @endif
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css?family=Tomorrow&display=swap" rel="stylesheet">

        <style>
            body{ background-color: #f1f1f1; }

            .card-header { background-color: transparent; border-bottom: none;}

            #dispositivosDeAudio, #dispositivosDeVideo, #voiceSpeech, #btnDetenerGrabacion{ display: none; }

            #video{ border: solid 2px; border-color: {{ FuncionesGlobales::sitio()->color }}; }

            #duracion{ font-family: 'Tomorrow', sans-serif; }

            .swal2-title{ font-size: 1em !important; }
            .swal2-textarea{ font-size: 1em !important; }
        </style>
    </head>
<body>
    <section>
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
                                    <h4>Video confirmación de firma de contrato</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6>
                                - {{ $candidato->nombres }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido }}
                            </h6>

                            <div class="alert alert-info" role="alert">                                
                                A continuación el sistema te va a solicitar que permitas <b>activar la cámara y el micrófono</b> porque te vamos a grabar.
                                Te realizaremos {{$cantidad_preguntas}} @if($cantidad_preguntas > 1) preguntas las cuales @else pregunta la cual @endif deberás contestar con la frase <b>(Si, Acepto)</b> en el caso en que estés de acuerdo, si por el contrario <b>NO estás de acuerdo</b>, por favor haz clic en el botón <b>"Cancelar contratación"</b> y diligencia el cuadro con la razón por la cual no aceptas.
                            </div>

                            <div class="alert alert-info" role="alert">
                                Para iniciar el video da clic en el botón "<b>Comenzar</b>", una vez terminado el video lo guardas dando clic en el botón "<b>Aceptar y continuar</b>".
                            </div>

                            @if(!$sitio->esProcesoEnSitio($reqId))
                                <div class="row">
                                    <div class="col-md-12 mb-2 text-center">
                                        <h6>Si no cuenta con cámara o micrófono hacer click en este enlace: <a href="{{route('home.confirmar-sin-video',["user_id"=>$user_id,"contrato_id"=>$contrato_id])}}" id="confir-manual"> Confirmación manual </a></h6>
                                    </div>
                                </div>
                            @endif

                            {!! Form::open(['id' => 'signin', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                {!! Form::hidden("contrato_id", $contratoId) !!}
                                {!! Form::hidden("user_id", $user->id) !!}
                                {!! Form::hidden("pregunta_id", $question->idPregunta) !!}
                                
                                <div class="text-center">
                                    <h3>
                                        <span class="badge badge-dark">
                                            {{ $question->orden }}
                                        </span>
                                    </h3>
                                </div>

                                <select name="dispositivosDeAudio" id="dispositivosDeAudio"></select>
                                <select name="dispositivosDeVideo" id="dispositivosDeVideo"></select>
                                <select name="voiceSpeech" id="voiceSpeech"></select>

                                <div class="row">
                                  <div class="col-md-3"></div>
                                  <video class="col-md-6" muted="muted" id="video"></video>
                                </div>

                                <p class="mt-2 mb-2 text-center" id="duracion"></p>

                                <div class="col-md-12 @if(!$sitio->esProcesoEnSitio($reqId)) text-center @else text-justify @endif">
                                    <div class="alert alert-light mt-2" role="alert">
                                        <b>{!! $question->archivo !!}</b>

                                        <audio src="{{ asset('contratos/src/audios/'.$question->audio) }}" id="audioBox"></audio>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" id="btnComenzarGrabacion">Comenzar</button>
                                    <button type="button" class="btn btn-danger" id="btnDetenerGrabacion">Terminar</button>

                                    <button type="button" class="btn btn-success" id="btnGuardarGrabacion" disabled>Aceptar y continuar</button>
                                </div>

                                <div class="text-center mt-4">
                                  <button type="button" class="btn btn-danger" id="btnCancelarContrato">Cancelar contratación</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <footer class="mt-3">
                <hr>
                <p class="text-muted text-center">T3RS Copyright © 2020</p>
            </footer>
        </div>
    </section>

    <div class="modal fade" id="observeModal" tabindex="-1" role="dialog" aria-labelledby="observeModalContract" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="observeModalContract">Cancelar contrato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="frmCancelacion">
                                <div class="form-group">
                                    <label for="observacion_cancelacion">Describe la razon por la que quieres cancelar el contrato</label>
                                    <textarea class="form-control" id="observacion_cancelacion" rows="3"></textarea>
                                    <div class="invalid-feedback">
                                        Debes completar el campo.
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnSendCancel">Enviar y cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        let routeSave = '{{ route('guardar_confirmacion_contratacion') }}';
        let questionContent = '{{ $question->archivo }}';

        @if($sitio->esProcesoEnSitio($reqId) && $modulo != 'modulo_cv')
            let dashboardRedir = '{{ route('admin.gestion_requerimiento', ['req_id' => $reqId]) }}';
        @else
            let dashboardRedir = '{{ route('dashboard') }}';
        @endif

        let cantidadPreguntas = parseInt('{{ $cantidad_preguntas }}');
        let nroPregunta = parseInt('{{ $question->orden }}');
        let tiempoMaxResp = parseInt('{{ $question->tiempo_max_resp }}');
        let tiempoBotonAceptar = parseInt('{{ $question->tiempo_boton_aceptar }}');

        let routeCancel = '{{ route('cancelar_contratacion_candidato') }}';
        let contratoId  = {{ $contratoId }};
        let userId  = {{ $userId }};
        let reqId  = {{ $reqId }};
    </script>

    {{-- JavaScript Exclusivo de la vista --}}
    <script type="text/javascript" src="{{ url('assets/home/js/contratacion-video-script.js') }}"></script>
</body>
</html>