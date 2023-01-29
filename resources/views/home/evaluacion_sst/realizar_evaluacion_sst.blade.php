<?php
    $sitio = FuncionesGlobales::sitio();
?>
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

    <title>{{ $configuracion_sst->titulo_prueba }}</title>

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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('js/drawingboard/drawingboard.min.css') }}">

    {{-- <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script> --}}

    {{-- drawingboard JS --}}
    <script src="{{ asset('js/drawingboard/drawingboard.min.js') }}" type="text/javascript"></script>

    {{-- Webcam JS - Pictures --}}
    <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>

    {{-- SmokeJS - CSS --}}
    <link rel="stylesheet" href="{{ asset("js/smoke/css/smoke.min.css") }}">

    <script>
        $(function () {
            @if(empty($candidatos))
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

            <table width="100%" style="margin-left: -37px;">
                <tr>
                    <th class="col-md-12 text-left">
                        @if($logo != "")
                            <img style="margin-top: 10px;" alt="Logo" class="izquierda" height="auto" src="{{url('configuracion_sitio')}}/{!!$logo!!}" width="150">
                        @elseif(isset($sitio->logo))
                            @if($sitio->logo != "")
                                <img style="margin-top: 10px;" alt="Logo T3RS" class="izquierda" height="auto" src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="150">
                            @else
                                <img style="margin-top: 10px;" alt="Logo T3RS" class="izquierda" height="auto" src="{{ asset('img/logo.png')}}" width="150">
                            @endif
                        @else
                            <img style="margin-top: 10px;" alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                        @endif
                    </th>
                </tr>
            </table>

            <div class="col-md-12 text-center">
                <h2>{{ $configuracion_sst->titulo_prueba }}</h2>
            </div>

            @if($configuracion_sst->instrucciones_prueba != '' && $configuracion_sst->instrucciones_prueba != null)
                <div class="col-md-12" id="instrucciones_prueba" hidden>
                    <div class="alert alert-info" style="font-size: 18px; margin-top: 1rem;">
                        {!! $configuracion_sst->instrucciones_prueba !!}
                    </div>
                </div>
            @endif

            <div class="row" id="informacion-inicial">
                <div class="col-md-12 text-justify">
                    <div class="page-header title-bryg">
                        <h3>Instrucciones para realizar la prueba <small class="text-danger"><b class="title-helper">LEE ATENTAMENTE</b></small></h3>
                    </div>

                    <p>
                        Hola <b>{{ $candidatos->nombres . ' ' . $candidatos->primer_apellido }}</b>, te damos la bienvenida a la realización de la prueba de {{ $configuracion_sst->titulo_prueba }} que el equipo de selección de <b>{{ $sitio->nombre }}</b> ha preparado para ti.
                    </p>

                    <p>
                        A continuación te vamos a hacer una serie de preguntas, las cuales nos servirán para medir tu conocimiento. Las instrucciones son las siguientes:
                    </p>

                    <p>
                        <span><b>1.</b></span> Vas a encontrar <b>{{ count($sst_questions) }} preguntas</b> pueden ser respuesta única, respuesta múltiple y abiertas.
                    </p>

                    <p>
                        <span><b>2.</b></span> No tendrás tiempo límite para responder la prueba @if ($configuracion_sst->minimo_aprobacion != null), pero sí deberás obtener un puntaje mínimo de aprobación del {{ $configuracion_sst->minimo_aprobacion }}%. @else . @endif
                    </p>

                    <p>
                        <span><b>3.</b></span> Se solicitará permiso para acceder a tu cámara, ya que te tomaremos fotos mientras respondes la prueba para mantener el registro de quien respondió la misma.
                    </p>

                    <blockquote class="mt-2" style="font-size: 15.5px;">
                        <p>
                            Te sugerimos que estés concentrado respondiendo la prueba para no afectar los resultados. <br>¡Muchos éxitos!
                        </p>
                    </blockquote>
                </div>

                @if (count($material_consulta) > 0)
                    <div class="col-md-12" id="material_consulta">
                        <h4>Material de consulta</h4>
                        <div class="col-md-12">
                            <ul>
                                @foreach($material_consulta as $mat)
                                    <li><a href="{{ $mat->enlace }}" target="_blank" title="{{ $mat->descripcion }}">{{ $mat->titulo }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="col-md-12 mt-2 text-center">
                    <button class="btn btn-success" type="button" id="btn_comenzar">Comenzar</button>
                </div>
            </div>

            {!! Form::open(["id" => "fr_evaluacion", "hidden"]) !!}
                {!! Form::hidden("candidato_req", $candidatos->req_can_id, ["id" => "candidato_req_fr"]) !!}
                
                <?php 
                    $nro_preg = 0;
                ?>
                @foreach ($sst_questions as $question)
                    <?php 
                        $opciones = $question->getOptionActive;
                        $nro_preg++;
                        $nro_opcion = 0;
                    ?>
                    <div class="row col-md-12">
                        <h3 id="titulo_preg_id_{{ $question->id }}">{{ $nro_preg }}) {!! $question->descripcion !!}</h3>

                        <div id="preg_id_{{ $question->id }}" class="{{ $question->tipo }} preguntas">
                            @if($question->tipo == 'seleccion_multiple' || $question->tipo == 'seleccion_simple')
                                @foreach ($opciones as $opcion)
                                    @if($question->tipo == 'seleccion_multiple')
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <div class="form-check">
                                                <label class="form-check-label pointer" for="op{{ $opcion->id }}">
                                                    <input class="form-check-input m-checkbox preg_id_{{ $question->id }}" name="preg_id_{{ $opcion->id_pregunta }}[]" type="checkbox" value="{{ $opcion->id }}" id="op{{ $opcion->id }}">
                                                    {{ $letras[$nro_opcion] }} {!! $opcion->descripcion !!}
                                                </label>
                                            </div>
                                        </div>
                                    @elseif($question->tipo == 'seleccion_simple')
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <div class="form-check">
                                                <label class="form-check-label pointer" for="op{{ $opcion->id }}">
                                                    <input class="form-check-input preg_id_{{ $question->id }}" name="preg_id_{{ $opcion->id_pregunta }}" type="radio" value="{{ $opcion->id }}" id="op{{ $opcion->id }}">
                                                    {{ $letras[$nro_opcion] }} {!! $opcion->descripcion !!}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    <?php $nro_opcion++; ?>
                                @endforeach
                            @elseif($question->tipo == 'respuesta_abierta')
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <textarea class="form-control" name="preg_id_{{ $question->id }}" rows="3"></textarea>
                                </div>
                            @endif
                        </div>
                        <br><br>
                    </div>
                @endforeach

                <div class="row col-md-12 mb-2 mt-2">
                    <button class="btn-quote" id="guardar_evaluacion" type="submit">
                        <i class="fa fa-floppy-o"></i> Guardar
                    </button>
                    <br>
                </div>
            {!! Form::close() !!}
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Firma</h3>
                    </div>

                    <div class="modal-body" style="overflow:auto;">
                        <div id="texto">
                            <p>Por favor dibuja tu firma en el panel blanco usando tu mouse o usa tu dedo si estás desde un dispositivo móvil</p>

                            {!! Form::hidden("id", null, ["id" => "fr_id"]) !!}

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

        <div class="row" id="rowCam" style="background-color: #fff;">
            <div class="col-md-12">
                <div class="col-md-12 text-center" style="z-index: -1;">
                    <video id="webcam" autoplay playsinline width="640" height="420"></video>
                    <canvas id="canvas" class="d-none" hidden></canvas>
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

        <script>
            const induccionPictures = []

            let tiempo_foto = null
            let pictureCount = 1;
            //let firstPicture = true

            const webcamElement = document.getElementById('webcam');
            const canvasElement = document.getElementById('canvas');
            const webcam = new Webcam(webcamElement, 'user', canvasElement);

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

                $('input').click(function(){
                    let _attr_id = $(this).parent().parent().parent().parent().attr('id');
                    $('#titulo_' + _attr_id).removeClass('preg-faltante');
                    $('#' + _attr_id).removeClass('preg-faltante');
                });

                $('textarea').on('keyup', function(){
                    let _attr_id = $(this).parent().parent().attr('id');
                    $('#titulo_' + _attr_id).removeClass('preg-faltante');
                    $('#' + _attr_id).removeClass('preg-faltante');
                });

                $(document).on("click", "#btn_comenzar", function() {
                    $.smkProgressBar({
                        element:'body',
                        status:'start',
                        bgColor: '#000',
                        barColor: '#fff',
                        content: `
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3><b>Se solicitarán los permisos para acceder a su cámara. <br> Por favor presione "Permitir".</b></h3>
                                    </div>
                                </div>
                            `
                    });
                    webcam.start()
                       .then(result =>{
                            console.log("webcam started");

                            setTimeout(() => {
                                let foto = webcam.snap();
                                webcam.stop();
                                $('#rowCam').addClass('d-none');

                                induccionPictures.push({
                                    'name': `induccion-foto-${pictureCount}`,
                                    'picture': foto
                                })

                                pictureCount++;

                                tiempo_foto = setInterval(function(){
                                    tomarFoto();
                                }, 60000)
                            }, 2500)

                            $.smkProgressBar({
                                status:'end'
                            });

                            $('#informacion-inicial').hide();
                            $('#instrucciones_prueba').show();
                            $('#fr_evaluacion').show();
                            $("html, body").animate({ scrollTop: 0 }, 200);
                        })
                        .catch(err => {
                            console.log(err);

                            $.smkProgressBar({
                                status:'end'
                            });

                            $('#informacion-inicial').hide();
                            $('#instrucciones_prueba').show();
                            $('#fr_evaluacion').show();
                        });

                });

                function tomarFoto() {
                    let foto = null;
                    webcam.start()
                       .then(result =>{
                            console.log("webcam iniciada tomarFoto");
                        })
                        .catch(err => {
                            console.log(err);
                        });
                    setTimeout(() => {
                        $('#rowCam').removeClass('d-none');
                        foto = webcam.snap();
                        webcam.stop();
                        $('#rowCam').addClass('d-none');

                        induccionPictures.push({
                            'name': `induccion-foto-${pictureCount}`,
                            'picture': foto
                        })

                        pictureCount++
                        if (pictureCount > 7){
                            clearInterval(tiempo_foto);
                        }
                    }, 3500)
                }

                $(document).on("click", ".guardarFirma", function() {
                    $('.drawing-board-canvas').attr('id', 'canvas');

                    var canvas1 = document.getElementById('canvas');
                    var canvas = canvas1.toDataURL();

                    var cand_id = $("#fr_id").val();
                    var token = ('_token', '{{ csrf_token() }}');
           
                    $.ajax({
                        type: 'POST',
                        data: {
                            id_evaluacion : $("#fr_id").val(),
                            _token : token,
                            firma : canvas
                        },
                        url: "{{ route('save_firma_evaluacion_sst') }}",
                        beforeSend: function(response) {
                            document.querySelector(".guardarFirma").setAttribute('disabled', 'disabled')
                            $.smkAlert({
                                text: 'Guardando su firma, por favor espere',
                                type: 'info'
                            });
                        },
                        success: function(response) {
                            if (response.success) {
                                clearInterval(tiempo_foto)
                                //stopWebcam()

                                document.querySelector(".guardarFirma").removeAttribute('disabled')

                                //
                                let rutaRedir = response.ruta

                                let rutaDashboard = "{{ route('datos_basicos') }}";

                                //Guardar fotos
                                let induccionImagenes = JSON.stringify(induccionPictures);

                                $.ajax({
                                    type: 'POST',
                                    data: {
                                        evaluacionId: $("#fr_id").val(),
                                        _token : token,
                                        induccionImagenes: induccionImagenes
                                    },
                                    url: "{{ route('save_fotos_sst') }}",
                                    beforeSend: function(response) {
                                        document.querySelector(".guardarFirma").setAttribute('disabled', 'disabled')
                                    },
                                    success: function(response) {
                                        swal("Felicitaciones", "Haz finalizado tu evaluación de inducción, el profesional de selección que está llevando tu proceso se contactará contigo para indicarte el paso a seguir.", "success", {
                                            buttons: {
                                                finalizar: {text: "Continuar", className:'btn btn-success'}
                                            },
                                            closeOnClickOutside: false,
                                            closeOnEsc: false,
                                            allowOutsideClick: false,
                                        }).then((value) => {
                                            switch (value) {
                                                case "finalizar":
                                                    window.open(rutaRedir, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=600")
                                                    window.location.href = rutaDashboard;
                                                break;
                                            }
                                        });
                                    }
                                });
                            }else{
                                document.querySelector(".guardarFirma").removeAttribute('disabled')
                            }
                        }
                    });
                });

                $(document).on("click", "#guardar_evaluacion", function (e) {
                    e.preventDefault();

                    guardar = true;
                    preguntas = [];

                    $('.preguntas').each(function (index, item){
                        if ($('#' + item.id).hasClass('seleccion_simple') || $('#' + item.id).hasClass('seleccion_multiple')) {
                            respta = false;
                            $('#' + item.id + ' input').each(function (_index, input) {
                                if (input.checked) {
                                    respta = true;
                                    $('#titulo_' + item.id).removeClass('preg-faltante');
                                    $('#' + item.id).removeClass('preg-faltante');
                                }
                            });
                            if (!respta) {
                                $('#titulo_' + item.id).addClass('preg-faltante');
                                $('#' + item.id).addClass('preg-faltante');
                                preguntas.push(parseInt(index)+1);
                                guardar = false;
                            }
                        } else {
                            if ($('#' + item.id + ' textarea').val() == '' || $('#' + item.id + ' textarea').val() == undefined || $('#' + item.id + ' textarea').val() == null) {
                                preguntas.push(parseInt(index)+1);
                                $('#titulo_' + item.id).addClass('preg-faltante');
                                $('#' + item.id).addClass('preg-faltante');
                                guardar = false;
                            } else {
                                $('#titulo_' + item.id).removeClass('preg-faltante');
                                $('#' + item.id).removeClass('preg-faltante');
                            }
                        }
                    });

                    if (!guardar) {
                        mensaje = 'Debes responder todas las preguntas. Verifica la ';
                        preguntas.forEach(element => mensaje += ' pregunta ' + element + ', ');
                        $.smkAlert({
                            text: mensaje,
                            type: 'danger'
                        });
                    }

                    if (guardar) {
                        $('#guardar_evaluacion').attr('disabled', true);
                        var formData = new FormData(document.getElementById("fr_evaluacion"));
                        clearInterval(tiempo_foto);
                        $.smkAlert({
                            text: 'Guardando sus respuestas, por favor espere',
                            type: 'info'
                        });

                        $.ajax({
                            url: "{{ route('save_evaluacion_sst') }}",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false
                        }).done(function (res) {
                            var res = $.parseJSON(res);
                            var id_c = res.id;

                            if(res.success) {
                                if(res.paso == 1){ //prueba definitiva 6gh
                                    swal("Felicitaciones", res.mensaje, "success", {
                                        buttons: {
                                            cancelar: {text: "Firmar", className:'btn btn-success'}
                                        },
                                        closeOnClickOutside: false,
                                        closeOnEsc: false,
                                        allowOutsideClick: false,
                                    }).then((value) => {
                                        switch (value) {
                                            case "cancelar":
                                                $("#myModal").modal({
                                                    backdrop: 'static',
                                                    keyboard: false
                                                });
                                                $("#fr_id").val(id_c);
                                            break;
                                        }
                                    });
                                }else {
                                    clearInterval(tiempo_foto)
                                    //stopWebcam()

                                    swal("Debes repetir la evaluación", res.mensaje, {
                                        buttons: {
                                            cancelar: {text: "Reintentar Evaluación", className:'btn btn-success'}
                                        },
                                        icon: "warning",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false,
                                        allowOutsideClick: false,
                                    }).then((value) => {
                                        switch (value) {
                                            case "cancelar":
                                                location.reload(true)
                                            break;
                                        }
                                    });
                                }
                            } else {
                                $("#modal_peq").find(".modal-content").html(res.view);
                            }
                        });
                    }

                    return false;
                });
            });
        </script>
    </body>
</html>