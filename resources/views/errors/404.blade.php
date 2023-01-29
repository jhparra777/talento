<!DOCTYPE html>
<html>
<head>
    <title>Página no encontrada</title>

    <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}" type="text/css">    
    <link rel="stylesheet" href="{{ url('assets/css/jasny-bootstrap.min.css') }}" type="text/css">  
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap-select.min.css') }}" type="text/css">  
    <!-- Material CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/material-kit.css') }}" type="text/css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ url('assets/fonts/font-awesome.min.css') }}" type="text/css"> 
    <link rel="stylesheet" href="{{ url('assets/fonts/themify-icons.css') }}"> 

    <!-- Main Styles -->
    <!-- Responsive CSS Styles -->
    <link rel="stylesheet" href="{{ url('assets/css/responsive.css') }}" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ route('generar_css_home') }}"/>
    
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);
        
        body {
            font-family: 'Open Sans';
            padding: 0;
            margin: 0;
        }

        a, a:visited {
            color: #fff;
            outline: none;
            text-decoration: none;
        }

        a:hover, a:focus, a:visited:hover {
            color: #fff;
            text-decoration: none;
        }

        * {
            padding: 0;
            margin: 0;
        }

        #oopss {
            background: #222;
            text-align: center;
            margin-bottom: 50px;
            font-weight: 400;
            font-size: 20px;
            position: fixed;
            width: 100%;
            height: 100%;
            line-height: 1.5em;
            z-index: 9999;
            left: 0px;
        }

        #error-text {
            top: 13%;
            position: relative;
            font-size: 20px;
            color: #eee;
        }

        #error-text a {
            color: #eee;
        }

        #error-text a:hover {
            color: #fff;
        }

        #error-text p {
            color: #eee;
            margin: 70px 0 0 0;
        }

        #error-text i {
            margin-left: 10px;
        }

        #error-text p.hmpg {
            margin: 40px 0 0 0;
        }

        #error-text span {
            position: relative;
            background: #193e95;
            color: #fff;
            font-size: 300%;
            padding: 0 20px;
            border-radius: 5px;
            font-weight: bolder;
            transition: all .5s;
            cursor: pointer;
            margin: 0 0 40px 0;
        }

        #error-text span:hover {
            background: #00000052;
            color: #fff;
            -webkit-animation: jelly .5s;
            -moz-animation: jelly .5s;
            -ms-animation: jelly .5s;
            -o-animation: jelly .5s;
            animation: jelly .5s;
        }

        #error-text span:after {
            top: 100%;
            left: 50%;
            border: solid transparent;
            content: '';
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-color: rgba(136, 183, 213, 0);
            border-top-color: #193e95;
            border-width: 7px;
            margin-left: -7px;
        }

        @-webkit-keyframes jelly {
            from, to {
                -webkit-transform: scale(1, 1);
                transform: scale(1, 1);
            }
            25% {
                -webkit-transform: scale(.9, 1.1);
                transform: scale(.9, 1.1);
            }
            50% {
                -webkit-transform: scale(1.1, .9);
                transform: scale(1.1, .9);
            }
            75% {
                -webkit-transform: scale(.95, 1.05);
                transform: scale(.95, 1.05);
            }
        }

        @keyframes jelly {
            from, to {
                -webkit-transform: scale(1, 1);
                transform: scale(1, 1);
            }
            25% {
                -webkit-transform: scale(.9, 1.1);
                transform: scale(.9, 1.1);
            }
            50% {
                -webkit-transform: scale(1.1, .9);
                transform: scale(1.1, .9);
            }
            75% {
                -webkit-transform: scale(.95, 1.05);
                transform: scale(.95, 1.05);
            }
        }
        
        /* CSS Error Page Responsive */
        @media only screen and (max-width:640px) {
            #error-text span {
                font-size: 200%;
            }

            #error-text a:hover {
                color: #fff;
            }
        }

        .back:active {
            -webkit-transform: scale(0.95);
            -moz-transform: scale(0.95);
            transform: scale(0.95);
            background: #f53b3b;
            color: #fff;
        }

        .back:hover {
            background: #4c4c4c;
            color: #fff;
        }

        .back {
            text-decoration: none;
            background: #193e95;
            color: #fff;
            padding: 10px 20px;
            font-size: 20px;
            font-weight: 700;
            line-height: normal;
            text-transform: uppercase;
            border-radius: 3px;
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            transform: scale(1);
            transition: all 0.5s ease-out;
        }

        .opciones{
            margin-top: 1em;
            list-style: none;
        }

        .opciones li{
            display: inline-block;
        }

        .btn-common:hover, .btn-common:focus{
            background: #10151c;
        }
   </style>
</head>
<body>
    <header>
        <div style="margin: 1rem;">
            @if(isset(FuncionesGlobales::sitio()->logo))
                @if(FuncionesGlobales::sitio()->logo != "")
                    <img alt="Logo T3RS" class="izquierda" height="auto" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}" width="110">
                @else
                    <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="110">
                @endif
            @else
                <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="110">
            @endif
        </div>
    </header>

    <div id='oopss'>
        <div id='error-text'>
            <img src="{{ url('img/404-image.png') }}">
            <h5>La página que estas buscando no existe.</h5>

            <ul class="opciones">
                <li>
                    <a href='{{ route('home') }}' class="btn btn-common btn-rm">IR A INICIO</a>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>