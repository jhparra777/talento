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

    <script src="{{ url("bower_components/jquery-ui/jquery-ui.min.js") }}"></script>
    
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

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url("bower_components/bootstrap/dist/css/bootstrap.min.css") }}">
    <link rel="stylesheet" href="{{ url("bower_components/select2/dist/css/select2.min.css") }}">

    {{-- TRI Custom styles --}}
	<link rel="stylesheet" href="{{ asset('assets/css/tri-custom-styles.css') }}">

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

    {{-- <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ route('generar_css_cv') }}"/> --}}
    <link href="{{ url('public/css/responsive_style.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="{{ asset("css/checkboxs.css") }}" type="text/css" rel="stylesheet">
    <script src="{{ asset('js/jQuery-Autocomplete-master/src/jquery.autocomplete.js') }}"></script>

    <link rel="stylesheet" href="{{ url("bower_components/select2/dist/css/select2.min.css") }}">
    <script src="{{ url("bower_components/select2/dist/js/select2.min.js") }}"></script>
    
    <style>
        .select2.select2-container {
        width: 100% !important;
        }

        .select2.select2-container .select2-selection {
        border: 1px solid #ccc;
        -webkit-border-radius: 1rem;
        -moz-border-radius: 1rem;
        border-radius: 1rem;
        height: 34px;
        margin-bottom: 15px;
        outline: none !important;
        transition: all .15s ease-in-out;
        }

        .select2.select2-container .select2-selection .select2-selection__rendered {
        color: #333;
        line-height: 32px;
        padding-right: 33px;
        }

        .select2.select2-container .select2-selection .select2-selection__arrow {
        
        -webkit-border-radius: 0 3px 3px 0;
        -moz-border-radius: 0 3px 3px 0;
        border-radius: 0 3px 3px 0;
        height: 32px;
        width: 33px;
        }

        .select2.select2-container.select2-container--open .select2-selection.select2-selection--single {
        background: #f8f8f8;
        }

        .select2.select2-container.select2-container--open .select2-selection.select2-selection--single .select2-selection__arrow {
        -webkit-border-radius: 0 3px 0 0;
        -moz-border-radius: 0 3px 0 0;
        border-radius: 0 3px 0 0;
        }

        .select2.select2-container.select2-container--open .select2-selection.select2-selection--multiple {
        border: 1px solid #34495e;
        }
    </style>
    
    <style>
        .panel-heading{
            text-align: center;
        }

        /* CSS styles checkbox*/
        .inputc {
            -webkit-appearance: none;
            appearance: none;
            width: 64px;
            padding-left: 33px;
            margin: 0;
            border-radius: 16px;
            background: radial-gradient(circle 12px, white 100%, transparent calc(100% + 1px)) #ccc -16px;
            transition: 0.3s ease-in-out;
        }
        
        .inputc[type="checkbox"] {                 
           padding-left: 33px;                
         }

        .inputc::before {
            content: "NO";
            font: bold 12px/32px Verdana;
            color: white;
        }

        [type="checkbox"]:checked {
            padding-left: 8px;
            background-color: #742c88;
            background-position: 16px;
        }

        :checked::before {
            content: "SI";
        }

    </style>
    {{-- <style>
        
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
    </style> --}}

    {{-- <link rel="stylesheet" href="{{ url("bower_components/bootstrap/dist/css/bootstrap.min.css") }}"> --}}
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

                    <h2>Visita domiciliaria</h2>
                </div>
            </div>
                
            <div class="container">
                <div class="row">
                    <div class="question-paginate">
                        <div id="" class="question-items">
                        
                            @include("cv.visita.include._datos_basicos_new")
                            @include("cv.visita.include._estructura_familiar_new")
                            @include("cv.visita.include._aspecto_general_vivienda_new")
                            @include("cv.visita.include._ingresos_egresos_new")
                            @include("cv.visita.include._bienes_inmuebles_new")
                            @include("cv.visita.include._formacion_academica_new")
                            @include("cv.visita.include._informacion_laboral_new")
                            @include("cv.visita.include._estado_salud_new")
                            @include("cv.visita.include._informacion_adicional_new")
                            {{-- Se presenta si la visita es periodica = 1 --}}
                            @if($candidatos->clase_visita_id == 1)
                                @include("cv.visita.include._visita_periodica_new")
                            @endif
                            @include("cv.visita.include._registro_fotografico_new")
                            @if($current_user->inRole("admin"))

                                @include("cv.visita.include._observaciones_generales_new")
                                
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
                        </div>
                    </div>
                </div>
            </div>

            <div id="btn-guardar" class="col-md-12 text-center" style="margin-bottom: 2rem;">
                <button class="btn-quote" id="guardar_visita" type="submit" onClick="unhook()">
                    <i class="fa fa-floppy-o"></i> Guardar
                </button>
            </div>
            <br>
           
        </div>

        @include("cv.visita.modal._modal_firma")

        <div class="row" style="background-color: white;" id="webcamBox">
            <div class="col-md-12 text-center" style="z-index: -1;">
                <video id="webcam" autoplay playsinline width="640" height="420"></video>
                <canvas id="canvas" class="d-none" hidden></canvas>
            </div>
        </div>

        @include("cv.visita.include._js_realizar_pre_form_visita")
    </div>
</body>
</html>