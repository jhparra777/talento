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

    <link href="{{ url('public/css/responsive_style.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

    <style>
        html{
            font-family: 'Arial';
        }

        body{
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 9pt;
            line-height: 1.2;
            color: black;
            background-color: #fff;
        }

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
            <table width="100%" style="margin-top: 20px; font-weight: bold; font-size: 18px;">
                <tr>
                    <td rowspan="2" width="24%" class="text-left">
                        @if($logo != "")
                            <img style="margin-top: 10px;" alt="Logo" src="{{url('configuracion_sitio')}}/{!!$logo!!}" width="150">
                        @elseif(isset($sitio->logo))
                            @if($sitio->logo != "")
                                <img style="margin-top: 10px;" alt="Logo T3RS" src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="150">
                            @else
                                <img style="margin-top: 10px;" alt="Logo T3RS" src="{{ asset('img/logo.png')}}" width="150">
                            @endif
                        @else
                            <img style="margin-top: 10px;" alt="Logo T3RS" src="{{url('img/logo.png')}}" width="150">
                        @endif
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <p>Fecha: {{date('d-m-Y')}}</p>
            <div class="row col-md-12 mt-4">
                <p style="text-align:justify !important;">
                    Yo, <b>{{$candidato->nombres .' '. $candidato->primer_apellido}}</b> identificado(a) con <b>{{ (!empty($candidato->tipo_id_desc) ? $candidato->tipo_id_desc : 'el documento de indentidad')}}</b> número <b>{{$candidato->numero_id}}</b> como trabajador en misión en la empresa usuaria {{ $empresa_logo->nombre_empresa }} autorizo de forma libre y voluntaria a {{ $empresa_logo->nombre_empresa }} empresa usuaria o al tercero que designe, para que a partir de la fecha y en el momento que así lo requiera, me tome las pruebas de Alcoholemia y/o Toxicología.
                    <br><br><br>
                    Manifiesto que tras haber recibido información verbal, clara y sencilla sobre la TOMA DE MUESTRAS, he podido hacer preguntas y aclarar mis dudas sobre como es, como se hace, para que sirve, que riesgos conlleva y porque es importante en mi caso. Así tras haber comprendido la información recibida, doy libremente mi consentimiento para la realización de dicho procedimiento.
                    <br><br><br><br>
                    <img src="{{$candidato->firma}}" width="240" height="80"><br>
                    Firma trabajador en misión
                </p>
                <br><br>
            </div>
        </div>
    </body>
</html>