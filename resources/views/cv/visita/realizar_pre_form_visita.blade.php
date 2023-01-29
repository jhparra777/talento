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

    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
    <link href="{{ asset("css/checkboxs.css") }}" type="text/css" rel="stylesheet">

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
        .panel-heading{
            text-align: center;
        }
        h4{
            text-align: center;
            
            font-weight: bold;
            background: #f5f5f5;
            padding: .5em;
        }
         table.enfermedades th{
            background-color: rgb(220,220,220);
            text-align: center;
        }
    </style>

    <link rel="stylesheet" href="{{ url("bower_components/bootstrap/dist/css/bootstrap.min.css") }}">
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
                            <img style="margin-top: 10px;" alt="Logo" class="izquierda" height="auto" src="{{url('configuracion_sitio')}}/{!!$logo!!}" width="80">
                        @elseif(isset($sitio->logo))
                            @if($sitio->logo != "")
                                <img style="margin-top: 10px;" alt="Logo T3RS" class="izquierda" height="auto" src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="80">
                            @else
                                <img style="margin-top: 10px;" alt="Logo T3RS" class="izquierda" height="auto" src="{{ asset('img/logo.png')}}" width="150">
                            @endif
                        @else
                            <img style="margin-top: 10px;" alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                        @endif
                    </th>
                </tr>
            </table>
            <div class="row">
                <div class="col-md-12 text-center">

                    <h2>Visita Domiciliaria</h2>
                </div>
            </div>
            

           
           
                
                <div class="container">
                    <div class="row">
                        <div class="question-paginate">
                            <div id="" class="question-items">

                                
                                @include("cv.visita.include._datos_basicos")
                                @include("cv.visita.include._estructura_familiar")
                                @include("cv.visita.include._aspecto_general_vivienda")
                                @include("cv.visita.include._ingresos_egresos")
                                @include("cv.visita.include._bienes_inmuebles")
                                @include("cv.visita.include._informacion_tributaria")
                                @include("cv.visita.include._estado_salud")
                                @if($candidatos->clase_visita_id!=1)
                                    @include("cv.visita.include._aspectos_familiares")
                                    @include("cv.visita.include._recreacion")
                                    @include("cv.visita.include._referencia_vecinal")
                                @else
                                    @include("cv.visita.include._informacion_laboral")
                                @endif
                                @include("cv.visita.include._registro_fotográfico")
                                @if($current_user->inRole("admin"))

                                    @include("cv.visita.include._observaciones_generales")
                                    
                                @endif



                            </div>
                             <div class="pager mt-3 mb-3" id="paginationButtonBox">
                                <div class="btn-group btn-group-lg" role="group" aria-label="...">
                                    <button type="button" class="previousPage btn btn-default">
                                        <i class="fa fa-chevron-circle-left"></i> Anterior
                                    </button>
                                    <button type="button" class="nextPage btn btn-default">
                                        Siguiente <i class="fa fa-chevron-circle-right"></i>
                                    </button>
                                </div>

                                {{--<div class="question-page-numbers mt-1"></div>--}}
                            </div>
                        </div>
                    </div>
                </div>

               

                    
              
                

                


                <div id="btn-guardar" class="col-md-12 text-center" style="margin-bottom: 2rem;">
                    <button class="btn-quote" id="guardar_visita" type="submit">
                        <i class="fa fa-floppy-o"></i> Guardar
                    </button>
                </div>
                <br>
           
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
                        <button type="button" class="btn btn-success guardarFirma" disabled>Firmar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="background-color: white;" id="webcamBox">
            <div class="col-md-12 text-center" style="z-index: -1;">
                <video id="webcam" autoplay playsinline width="640" height="420"></video>
                <canvas id="canvas" class="d-none" hidden></canvas>
            </div>
        </div>

        <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
    
        <script src="{{ asset('public/js/bootstrap.min.js') }}" type="text/javascript"></script>
          
        {{--<script src="{{ asset('public/js/jquery_custom.js') }}" type="text/javascript"></script>--}}

        <script src="{{ asset('js/cv/evaluacion_sst/evaluacion-sst-webcam.js') }}"></script>

         {{--<script src="https://code.jquery.com/jquery-1.12.0.js" type="text/javascript"></script>--}}
        <script src="{{ url('js/jquery-ui.js') }}" type="text/javascript"></script>

        {{-- SmokeJS --}}
        <script src="{{ asset("js/smoke/js/smoke.min.js") }}"></script>
        {{-- SmokeJS - Language --}}
        <script src="{{ asset("js/smoke/lang/es.min.js") }}"></script>

             {{-- Paginga Js --}}
        <script src="{{ asset('js/cv/paginator-js/visita-paginga.jquery.js') }}"></script>

        {{-- swal --}}
        <!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>-->

        
        <script>

            const validateAnswers = (page) => {
                    
                    let form = $('.form-'+page);
                    if(form.smkValidate()){
                        return true;
                    }
                    else{
                        return false;
                    }
                 
            };

            

            $(document).on("keypress", ".solo_numeros", function (tecla) {
                console.log(tecla.charCode);
                if ((tecla.charCode < 48 || tecla.charCode > 57) && tecla.charCode != 0)
                    return false;
            });

            $(function () {

               
                $("#btn-guardar").hide();

                $( ".formulario" ).each(function(index) {
                    $( this ).addClass( "form-"+(index+1));
                });

                 $(document).on('click', '.add-item', function (e) {
                    fila_person = $(this).parents('.old').find('.item').eq(0).clone();
                    fila_person.find('input').val('');
                    //fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-person">-</button>');
                    fila_person.append('<div class="col-md-12 form-group last-child" style="display: block;text-align:center;"><button type="button" class="btn btn-danger rem-item">-</button></div>');

                    $(this).parents('.old').find('.padre').append(fila_person);
                });

             $(document).on('click', '.rem-item', function (e) {
                    $(this).parents('.item').remove();

                });
                //initWebcam()

                $(".question-paginate").paginga({
                    itemsPerPage: 1,
                    itemsContainer: '.question-items',
                    pageNumbers: '.question-page-numbers'
                });

                

                

                $(document).on('click', '.add-person', function (e) {
                    fila_person = $(this).parents('#nuevo_familiar').find('.grupos_fams').eq(0).clone();
                    fila_person.find('input').val('');
                    fila_person.find('.boton_aqui').append('<button type="button" class="btn btn-danger pull-right rem-person" title="Remover grupo">-</button>');

                    $('#nuevo_familiar').append(fila_person);
                });

                

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
                    _attr_id = $(this).parent().parent().parent().parent().attr('id');
                    $('#titulo_' + _attr_id).removeClass('preg-faltante');
                    $('#' + _attr_id).removeClass('preg-faltante');
                });

                $(document).on("click", ".guardarFirma", function() {
                    $('.drawing-board-canvas').attr('id', 'canvas');

                    var canvas1 = document.getElementById('canvas');
                    var canvas = canvas1.toDataURL();

                    var cand_id = $("#fr_id").val();
                    var token = ('_token', '{{ csrf_token() }}');
           
                    $.ajax({
                        type: 'POST',
                        data: {
                            visita_id : $("#fr_id").val(),
                            _token : token,
                            firma : canvas
                        },
                        url: "{{ route('save_firma_pre_form_visita') }}",
                        beforeSend: function(response) {
                            document.querySelector(".guardarFirma").setAttribute('disabled', 'disabled')
                            $.smkAlert({
                                text: 'Guardando su firma, por favor espere',
                                type: 'info'
                            });
                        },
                        success: function(response) {
                            if (response.success) {
                                let rutaDashboard = "{{ route('dashboard') }}";

                                swal("Felicitaciones", "Proceso de gestión de  formulario previo a la visita completado satisfactoriamente. ", "success", {
                                        buttons: {
                                            cancelar: {text: "Ok", className:'btn btn-success'}
                                        },
                                        closeOnClickOutside: false,
                                        closeOnEsc: false,
                                        allowOutsideClick: false,
                                    }).then((value) => {
                                        switch (value) {
                                            case "cancelar":
                                               window.location.href = rutaDashboard;
                                            break;
                                        }
                                    });
                                

                                
                                /*
                                clearInterval(intervalWebcam)
                                stopWebcam()

                                document.querySelector(".guardarFirma").removeAttribute('disabled')

                                //
                                let rutaRedir = response.ruta

                                let rutaDashboard = "{{ route('dashboard') }}";

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
                            */}else{
                                document.querySelector(".guardarFirma").removeAttribute('disabled')
                            }
                        }
                    });
                });

                $(document).on("click", "#guardar_visita", function (e) {
                    e.preventDefault();

                    guardar = true;
                    preguntas = [];


                        $('#guardar_visita').attr('disabled', true);
                        var formData = $(".question-items .formulario").serialize();
                        //var formData = new FormData(document.getElementsById("#form-1"));

                        
                        
                        //clearInterval(intervalWebcam);
                        $.smkAlert({
                            text: 'Guardando sus respuestas, por favor espere',
                            type: 'info'
                        });

                        $.ajax({
                            url: "{{ route('save_pre_visita') }}",
                            type: "post",
                            //dataType: "html",
                            data: formData,
                            cache: false,
                            //contentType: false,
                            //processData: false
                        }).done(function (res) {
                            //var res = $.parseJSON(res);
                            

                            if(res.success) {
                                    var id_c = res.visita_id;
                                    var formData = new FormData(document.getElementById("form-imagenes"));
                                    $.ajax({
                                       url: "{{ route('save_images_pre_visita') }}",
                                        type: "post",
                                        dataType: "html",
                                        data: formData,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        }).done(function (response) {
                                           
                                           var respuesta=$.parseJSON(response);
                                            
                                            var id_c = respuesta.visita_id;
                                            swal("Felicitaciones", "Ha realizado el formulario con éxito. Para finalizar debe firmar el documento.", "success", {
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

                                            
                                            
                                        
                                    });
                                    
                                    
                                
                            } else {
                                //$("#modal_peq").find(".modal-content").html(res.view);
                            }
                        });
                    

                    //return false;
                });

                
            });
        </script>
        <script>

            var bPreguntar = true;

         

            window.onbeforeunload = preguntarAntesDeSalir;

         

            function preguntarAntesDeSalir () {

                var respuesta;

         

                if ( bPreguntar ) {

                    respuesta = confirm ( '¿Seguro que quieres salir?' );

         

                    if ( respuesta ) {

                        window.onunload = function () {

                            return true;

                        }

                    } else {

                        return false;

                    }

                }

            }

        </script>
    </body>
</html>