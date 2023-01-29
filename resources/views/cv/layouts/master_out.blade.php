{{-- Este layout se creo con el proposito de usar las librerias y demás recursos, sin necesitar de los menú etc ... --}}
<?php
    $sitio = FuncionesGlobales::sitio();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta content="T3RS" name="author">
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{ csrf_token() }}" name="token">

        <title>
            @if(isset($sitio->nombre))
                @if($sitio->nombre != "")
                    {{ $sitio->nombre }} - HV
                @else
                    Desarrollo | HV
                @endif
            @else
                Desarrollo | HV
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

        {{-- Jquery 2.1.4 --}}
        <script src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js')}}"></script>
        
        <link href="{{ asset('public/css/style.css') }}" rel="stylesheet"/>
        
        {{-- Sweet alert 1.1.3 --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/css/animate.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/css/responsive_style.css') }}" rel="stylesheet" type="text/css"/>

        {{-- Animate CSS --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

        {{-- Font awesome --}}
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800%7CMontserrat:400,700" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet"/>

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> 

        {{-- SmokeJS - CSS --}}
	    <link rel="stylesheet" href="{{ asset("js/smoke/css/smoke.min.css") }}">

        {{-- Webcam JS - Pictures --}}
        <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>

        <style>
            .rating-control {
                display: inline-block;
                color: #ccc;
            }

            .rating-control label {
                font-family: "Font Awesome 5 Free";
                font-weight: 900;
                font-size: 0;
                -moz-osx-font-smoothing: grayscale;
                -webkit-font-smoothing: antialiased;
                display: inline-block;
                font-style: normal;
                font-variant: normal;
                text-rendering: auto;
                line-height: 1;
                float: right;
                cursor: pointer;
            }

            .rating-control label:before {
                content: '\f005';
                font-size: 20px;
            }

            .rating-control input {
                display: none;
            }

            .rating-control input:checked ~ label {
                color: orange;
            }
            
            .rating-control:hover label {
                color: #ccc !important;
            }
            
            .rating-control:hover label:hover, .rating-control:hover label:hover ~ label {
                color: orange !important;
            }

            /*Test*/
            .label-start-algo{
                color: gray !important;
            }

            .question-desc{
                display: inline;
                margin-left: 2rem;
            }

            .icon-minus{
                color: #a1a1a1;
                font-size: 10px;
                float: inline-start;
                margin-top: 0.5rem;
                margin-right: 0.5rem;
            }

            .icon-plus{
                color: #a1a1a1;
                font-size: 10px;
                position: absolute;
                margin-top: 0.5rem;
                margin-left: 0.5rem;
            }

            .text-center{ text-align: center; }
            .text-left{ text-align: left; }
            .text-right{ text-align: right; }
            .text-justify{ text-align: justify; }

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

            .line-heigth{
                line-height: 28px;
            }

            .d-inline-block{ display: inline-block; }

            /*Barra de carga*/
            .smk-progressbar-content{ color: white; text-align: center; }

            /*Media queries BRYG*/
            @media (max-width: 600px) {
                .title-bryg { text-align: center; }
                .title-helper{ display: none; }
                .jump-line{ display: initial; }

                .d-inline-block{ display: block; text-align: center; }
                .icon-minus{ position: absolute; margin-left: -1.6rem; }
                .list-group-item{ text-align: center; }

                .smk-alert-content {
                    width: 300px;
                }
            }
        </style>
    </head>
    <body>
        @yield('content')

        <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>

        <script src="{{ asset('public/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/js/jquery_custom.js') }}" type="text/javascript"></script>

        {{-- SmokeJS --}}
        <script src="{{ asset("js/smoke/js/smoke.min.js") }}"></script>
        {{-- SmokeJS - Language --}}
        <script src="{{ asset("js/smoke/lang/es.min.js") }}"></script>

        <script>
            $(function () {
                $.ajaxSetup({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                    },
                    error: function() {
                        /* Act on the event */
                    },
                })

                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
    </body>
</html>
