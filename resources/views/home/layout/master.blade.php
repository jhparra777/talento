<?php
    if(!isset($menu)){
        $menu = FuncionesGlobales::menu_home();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="token" content="{{ csrf_token() }}"/>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta http-equiv="content-type" content="text/html; charset=utf-8">

    {{-- Boostrap CSS --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

    {{-- Boostrap theme --}}
    <link rel="stylesheet" href="{{ asset("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css")}}" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

    {{-- Font --}}
    <link href='https://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900' rel='stylesheet' type='text/css'>

    {{-- Style --}}
    <link rel="stylesheet" href="{{ asset("css/style_home.min.css") }}">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    
    {{-- JQuery UI css --}}
    <link href="{{ url("css/jquery-ui.min.css") }}" rel="stylesheet">

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/css/jasny-bootstrap.min.css') }}" type="text/css"> 
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap-select.min.css') }}" type="text/css">

    {{-- Material CSS --}}
    <link rel="stylesheet" href="{{ url('assets/css/material-kit.css') }}" type="text/css">

    {{-- Font Awesome CSS --}}
    <link rel="stylesheet" href="{{ url('assets/fonts/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/fonts/themify-icons.min.css') }}">

    {{-- Animate CSS --}}
    <link rel="stylesheet" href="{{ url('assets/extras/animate.min.css') }}" type="text/css">

    {{-- Owl Carousel --}}
    <link rel="stylesheet" href="{{ url('assets/extras/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/extras/owl.theme.min.css') }}" type="text/css">

    {{-- Rev Slider CSS --}}
    <link rel="stylesheet" href="{{ url('assets/extras/settings.min.css') }}" type="text/css"> 

    {{-- Slicknav js --}}
    <link rel="stylesheet" href="{{ url('assets/css/slicknav.min.css') }}" type="text/css">

    {{-- Responsive CSS Styles --}}
    <link rel="stylesheet" href="{{ url('assets/css/responsive.min.css') }}" type="text/css">
    
    <link rel="stylesheet" type="text/css" href="{{ route('generar_css_home') }}"/>

    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset("https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js")}}"></script>

    <script src="https://apis.google.com/js/platform.js" async defer></script>
        
    <title>
        @if(isset($sitio->nombre))
            @if($sitio->nombre != "")
                {{$sitio->nombre }} - Inicio
            @else
                Desarrollo | Inicio
            @endif
        @else
            Desarrollo | Inicio
        @endif
    </title>

    {{-- Favicon --}}
    @if(isset($sitio->favicon))
        @if($sitio->favicon != "")
            <link href="{{ url('configuracion_sitio') }}/{{ $sitio->favicon }}" rel="shortcut icon">
        @else
            <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
        @endif
    @else
        <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
    @endif
</head>
<body> 
    <div class="modal" id="modal_success_view">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal fade" id="modal_peq" >
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    
    <div class="modal" id="modal_success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"><span class="fa fa-check-circle "></span> Confirmación</h4>
                </div>
                <div class="modal-body" id="texto"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
  
    <div class="modal fade" id="modal_gr" tabindex="-1" role="dialog" aria-labelledby="answerModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
    
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

    {{-- Menu ("header") --}}
    @include('header')

    {{-- Contenido ("content") --}}
    @yield("content")

    {{-- Pie de pagina ("Footer") --}}
    <footer>
        @include('footer')
    </footer>

    {{-- Main JS  --}}
    <script src="{{ url('https://www.google.com/recaptcha/api.js') }}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ url('assets/js/bootstrap.min.js') }}"></script>    
    <script type="text/javascript" src="{{ url('assets/js/material.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/material-kit.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jquery.parallax.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jquery.slicknav.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jquery.counterup.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/waypoints.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jasny-bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/form-validator.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/contact-form-script.js') }}"></script> 
    <script type="text/javascript" src="{{ url('js/jquery-ui.min.js') }}" ></script>
    <!--<script src="{{asset('js/jQuery-Autocomplete-master/src/jquery.autocomplete.min.js')}}"></script>-->
    <script src="{{ asset("js/jQuery-Autocomplete-master/src/jquery.autocomplete.js") }}"></script>

</body>
</html>