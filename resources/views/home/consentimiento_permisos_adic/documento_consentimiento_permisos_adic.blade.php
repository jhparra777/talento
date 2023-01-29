<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    ?>
    <meta content="T3RS" name="author">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{csrf_token()}}" name="token">

    <title>{{$consentimientos_config->titulo_documento}}</title>

    @if($sitio->favicon)
        @if($sitio->favicon != "")
          <link href="{{ url('configuracion_sitio')}}/{{$sitio->favicon }}" rel="shortcut icon">
        @else
          <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
        @endif
    @else
        <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
    @endif
   
    <script src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js')}}"></script>
    
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('js/drawingboard/drawingboard.min.css') }}">

    {{-- SmokeJS - CSS --}}
    <link rel="stylesheet" href="{{ asset('js/smoke/css/smoke.min.css') }}">
    {{-- drawingboard JS --}}
    <script src="{{ asset('js/drawingboard/drawingboard.min.js') }}" type="text/javascript"></script>

    <script>
        $(function () {
            @if(empty($candidato))
                window.location.href= '{{ route("datos_basicos") }}';
            @endif
        });
    </script>

    <script>
        $(function () {
            $.ajaxSetup({
                type: "POST",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                }
            });
        });
    </script>

    <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ route('generar_css_cv') }}"/>
    <link href="{{ url('public/css/responsive_style.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

    <style>
        label { display: block; }

        textarea {
            box-sizing: border-box; font: 12px arial;
            height: 200px; margin: 5px 0 15px 0;
            padding: 5px 2px; width: 100%;  
        }

        .borderojo { outline: none; border: solid #f00 !important; }
        .bordegris { border: 1px solid #d4d4d; }

        .swal2-popup {
            font-size: 1.6rem !important;
        }

        .form-check-input{ float: left; }

        .form-check{ text-align: left; }

        .pointer {
            cursor: pointer;
        }

        .mb-2 {
            margin-bottom: 2rem;
        }

        .mt-2 {
            margin-top: 2rem;
        }

        .mt-4 {
            margin-top: 4rem;
        }

        .m-checkbox {
            margin-top: 4px !important;
            margin-right: 10px !important;
            margin-bottom: 15px !important;
        }

        .d-none { display: none !important; }

        .preg-faltante {
            color: #801f1f;
        }

        label{
            font-size: 15px;
            font-weight: 500;
        }

        a {
            text-decoration-thickness: 2px !important;
            color: blue;
        }

        a:hover {
            text-decoration-thickness: 2px !important;
            color: blue !important;
        }

        a:link { 
            text-decoration-thickness: 2px !important;
            color: blue !important;
        }

        a:visited {
            text-decoration-thickness: 2px !important;
            color: blue !important;
        }

        a:active {
            text-decoration-thickness: 2px !important;
            color: blue !important;
        }
    </style>
</head>
<body>
    <div class="col-md-10 col-md-offset-1 col-right-item-container" style="text-align:justify !important;">
        <div class="container-fluid">
            @if(Session::has("mensaje_success"))
                <div class="col-md-12" id="mensaje-resultado">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get("mensaje_success") }}
                    </div>
                </div>
            @endif

            <table width="100%" style="margin-top: 20px; font-weight: bold; font-size: 18px;">
                <tr>
                    <td rowspan="2" width="24%" class="text-left">
                        @if($logo != "")
                            <img style="margin-top: 10px;" alt="Logo" height="auto" src="{{url('configuracion_sitio')}}/{!!$logo!!}" width="150">
                        @elseif(isset($sitio->logo))
                            @if($sitio->logo != "")
                                <img style="margin-top: 10px;" alt="Logo T3RS" height="auto" src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="150">
                            @else
                                <img style="margin-top: 10px;" alt="Logo T3RS" height="auto" src="{{ asset('img/logo.png')}}" width="150">
                            @endif
                        @else
                            <img style="margin-top: 10px;" alt="Logo T3RS" height="auto" src="{{url('img/logo.png')}}" width="150">
                        @endif
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <p>Fecha: {{date('d-m-Y')}}</p>

            {!! Form::open(["id" => "fr_consentimiento_permisos", "method" => "POST", "route" => "guardar_consentimiento_permisos_adic"]) !!}
                {!! Form::hidden("candidato_req", $candidato->req_can_id, ["id" => "candidato_req"]) !!}
                {!! Form::hidden("candidato_id", $candidato->user_id, ["id" => "candidato_id"]) !!}
                {!! Form::hidden("requerimiento_id", $candidato->requerimiento_id, ["id" => "requerimiento_id"]) !!}
                {!! Form::hidden("firma", null, ["id" => "firma"]) !!}

                <div class="row col-md-12 mt-4">
                    <p style="text-align:justify !important;">
                        Yo, <b>{{$candidato->nombres .' '. $candidato->primer_apellido}}</b> identificado(a) con <b>{{ (!empty($candidato->tipo_id_desc) ? $candidato->tipo_id_desc : 'el documento de indentidad')}}</b> número <b>{{$candidato->numero_id}}</b> como trabajador en misión en la empresa usuaria {{ $empresa_logo->nombre_empresa }} autorizo de forma libre y voluntaria a {{ $empresa_logo->nombre_empresa }} empresa usuaria o al tercero que designe, para que a partir de la fecha y en el momento que así lo requiera, me tome las pruebas de Alcoholemia y/o Toxicología.
                        <br><br>
                        Manifiesto que tras haber recibido información verbal, clara y sencilla sobre la TOMA DE MUESTRAS, he podido hacer preguntas y aclarar mis dudas sobre como es, como se hace, para que sirve, que riesgos conlleva y porque es importante en mi caso. Así tras haber comprendido la información recibida, doy libremente mi consentimiento para la realización de dicho procedimiento.
                        <br><br><br>
                        __________________________<br>
                        Firma trabajador en misión
                    </p>
                    <br><br>
                </div>
                <div class="row col-md-12 mt-4 mb-4">
                    <button class="btn-quote" id="guardar_firma" type="button">
                        <i class="fa fa-floppy-o"></i> Firmar
                    </button>
                </div>
            {!! Form::close() !!}

            <div class="modal fade" id="modal-firma" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Firma</h3>
                        </div>

                        <div class="modal-body" style="overflow:auto;">
                            <div id="texto">
                                <p>Por favor dibuja tu firma en el panel blanco usando tu mouse o usa tu dedo si estás desde un dispositivo móvil</p>

                                <table class="col-md-12 col-xs-12 col-sm-12 center table" bgcolor="#f1f1f1">
                                    <tr>
                                        <td width="10%"></td>
                                        <td>
                                            <div>
                                                <div>
                                                    <div id="firmBoard" style="width: 400px; height: 160px; margin: 1rem;"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="text-center">
                                <button type="button" class="btn btn-success guardarFirma" disabled>Firmar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>

        <script src="{{ asset('public/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/js/jquery_custom.js') }}" type="text/javascript"></script>

        {{-- SmokeJS --}}
        <script src="{{ asset("js/smoke/js/smoke.min.js") }}"></script>
        {{-- SmokeJS - Language --}}
        <script src="{{ asset("js/smoke/lang/es.min.js") }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            $(function () {
                let firmBoard = new DrawingBoard.Board('firmBoard', {
                    controls: [
                        { DrawingMode: { filler: false, eraser: false,  } },
                        { Navigation: { forward: false, back: false } }
                        //'Download'
                    ],
                    size: 2,
                    webStorage: 'session',
                    enlargeYourContainer: true
                });

                //listen draw event
                firmBoard.ev.bind('board:stopDrawing', getStopDraw);
                firmBoard.ev.bind('board:reset', getResetDraw);

                function getStopDraw() {
                    $(".guardarFirma").attr("disabled", false);
                }

                function getResetDraw() {
                    $(".guardarFirma").attr("disabled", true);
                }

                $('#guardar_firma').click(function() {
                    $("#modal-firma").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                });

                $(document).on("click", ".guardarFirma", function() {

                    document.querySelector(".guardarFirma").setAttribute('disabled', 'disabled')
                    Toast.fire({
                        icon: 'info',
                        title: 'Validando y guardando ...'
                    });
                    $('.drawing-board-canvas').attr('id', 'canvas-firma');

                    var canvas1 = document.getElementById('canvas-firma');
                    var canvas = canvas1.toDataURL();

                    $("#firma").val(canvas)

                    setTimeout(function(){
                        $("#fr_consentimiento_permisos").submit();
                    }, 3000);
                    //return console.log(JSON.stringify(origen_fondos))

                    var token = ('_token', '{{ csrf_token() }}');
                });

                const $btnFirma = document.querySelector('#firmar');
            });
        </script>
    </body>
</html>