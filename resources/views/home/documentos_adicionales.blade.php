<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="{{csrf_token()}}" name="token"/>
        <title>Video Contrato</title>
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css?family=Tomorrow&display=swap" rel="stylesheet">

        <style>
            body{ background-color: #f1f1f1; }

            .card-header { background-color: transparent; border-bottom: none;}

            #dispositivosDeAudio, #dispositivosDeVideo, #voiceSpeech, #btnDetenerGrabacion{ display: none; }

            #video{ border: solid 2px; border-color: {{ FuncionesGlobales::sitio()->color }}; }

            #duracion{ font-family: 'Tomorrow', sans-serif; }
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
                                    <h4>Video Confirmación</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6>
                                - {{ $candidato->nombres }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido }}
                            </h6>

                            <div class="alert alert-info mt-3" role="alert">
                                Para iniciar el video dar clic en el botón "<b>Comenzar</b>" y una vez terminado el video lo guardas dando clic en el botón "<b>Terminar y Aceptar</b>".
                            </div>

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

                                <video class="col-md-6 offset-3" muted="muted" id="video"></video>

                                <p class="mt-2 mb-2 text-center" id="duracion"></p>

                                <div class="col-md-12 text-center">
                                    <div class="alert alert-light mt-2" role="alert">
                                        {{ $question->archivo }}
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" id="btnComenzarGrabacion">Comenzar</button>
                                    <button type="button" class="btn btn-danger" id="btnDetenerGrabacion">Terminar</button>

                                    <button type="button" class="btn btn-success" id="btnGuardarGrabacion" disabled>Terminar y Aceptar</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <footer class="mt-3">
                <hr>
                <p class="text-muted text-center">T3RS Copyright © 2019</p>
            </footer>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        let routeSave = '{{ route('guardar_confirmacion_contratacion') }}';
        let questionContent = '{{ $question->archivo }}';
        let dashboardRedir = '{{ route('dashboard') }}';
    </script>
    {{-- JavaScript Exclusivo de la vista --}}
    <script type="text/javascript" src="{{ url('assets/home/js/contratacion-video-script.js') }}"></script>
</body>
</html>