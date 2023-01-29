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
        {{-- <meta content="{{ csrf_token() }}" name="token"> --}}

        <title>
            @if(isset($sitio->nombre))
                @if($sitio->nombre != "")
                    {{ $sitio->nombre }} - Firma contrato
                @else
                    Desarrollo | Firma contrato
                @endif
            @else
                Desarrollo | Firma-contrato
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

        <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
        
        {{-- drawingboard CSS 
        <link rel="stylesheet" type="text/css" href="{{ asset('js/drawingboard/drawingboard.min.css') }}">--}}

        {{-- drawingboard JS 
        <script src="{{ asset('js/drawingboard/drawingboard.min.js') }}" type="text/javascript"></script>--}}

        {{-- Sweet alert 1.1.3 
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>--}}

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/css/responsive_style.css') }}" rel="stylesheet" type="text/css"/>

        {{-- Webcam JS - Pictures --}}
        <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>

        <script src="{{ asset('js/admin/proceso-firmas-scripts/proceso-firma.js') }}"></script>

        <style>
            body{ background-color: #f1f1f1 !important; }

            .text-light{ font-weight: lighter; }
            .justify{ text-align: justify; }

            .m-auto { margin: auto; }
            .mt-0{ margin-top: 0 !important; }
            .mt-1{ margin-top: 1rem !important; }
            .mt-2{ margin-top: 2rem !important; }
            .mt-3{ margin-top: 3rem !important; }
            .mt-4{ margin-top: 4rem !important; }

            .mb-0{ margin-bottom: 0 !important; }
            .mb-1{ margin-bottom: 1rem !important; }
            .mb-2{ margin-bottom: 2rem !important; }
            .mb-3{ margin-bottom: 3rem !important; }
            .mb-4{ margin-bottom: 4rem !important; }

            .pd-1{ padding: 1rem; }

            .swal2-popup {
                font-size: 1.6rem !important;
            }
        </style>
    </head>
    <body>
        @yield('content')

        <script src="{{ asset('js/admin/proceso-firmas-scripts/proceso-firma-webcam.js') }}"></script>
        <script src="{{ asset('public/js/bootstrap.min.js') }}" type="text/javascript"></script>

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