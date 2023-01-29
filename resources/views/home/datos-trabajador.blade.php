<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="{{csrf_token()}}" name="token">
    <title>
        Trabajador
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

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/css/jasny-bootstrap.min.css') }}" type="text/css"> 

    <style>
        html{
            font-family: 'Arial';
        }

        body{
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            background-color: #fff;
        }

        .btn{
            text-decoration: none;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
                border-top-color: transparent;
                border-right-color: transparent;
                border-bottom-color: transparent;
                border-left-color: transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }

        .btn-success{
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-secondary{
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-warning{
            color: #fff;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-danger{
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-secondary:hover{
            color: #fff;
            background-color: #5a6268;
            border-color: #545b62;
        }

        .btn-success:hover{
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn:not(:disabled):not(.disabled){
            cursor: pointer;
        }

        .btn:focus, .btn:hover{
            text-decoration: none;
        }

        .text-center{ text-align: center;  }
        .text-left{ text-align: left;  }
        .text-right{ text-align: right;  }
        .text-light{ font-weight: lighter; }

        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .pd-1{ padding: 1rem; }

        .center{ margin: auto; }

        .mb-2{
            margin-bottom: 2rem;
        }

        .justify{ text-align: justify; }

        .list{ list-style: none; }
        /*.space{ line-height: 22px; }*/
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <table width="100%" class="mt-4">

                    @if($candidato->foto_perfil != null)
                        <tr>
                            <td class="text-center">
                                <img src="{{ asset('recursos_datosbasicos/'.$candidato->foto_perfil) }}" width="100" height="100" style="border-radius: 10px;">
                            </td>
                        </tr>

                    @elseif($candidato->avatar != null)
                        <tr>
                            <td class="text-center">
                                <img src="{{ asset($candidato->avatar) }}" width="100" height="100" style="border-radius: 10px;">
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td class="text-center text-uppercase mt-2">
                            <b>{{$candidato->nombres}} {{$candidato->primer_apellido}} {{$candidato->segundo_apellido}}</b>
                        </td>
                    </tr>
                </table>


            </div>
            <div class="col-md-12">
                
                <table class="mt-2" width="100%">
                    <tr>
                        <th class="text-center">
                            <p>INFORMACION DEL TRABAJADOR</p>
                        </th>
                    </tr>
                </table>

            </div>

            <div class="col-md-8 col-md-offset-2">
                <table class="table mt-4">
                    <tr>
                        <th class="text-left">
                            Nombre y Apellido:
                        </th>
                        
                        <td>
                            {{ $candidato->nombres }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido }}
                        </td>

                    </tr>

                    <tr>

                        <th class="text-left">
                          {{ ucwords(mb_strtolower($candidato->dec_tipo_doc))}}:
                        </th>
                        
                        <td>
                            {{ $candidato->numero_id }}
                        </td>
                    </tr>

                    <tr>
                        <th class="text-left">
                            Fecha de inicio:
                        </th>

                        <td width="25%">
                            {{ $requerimientoContratoCandidato->fecha_ingreso }}
                        </td>
                    </tr>

                    <tr>
                        <th class="text-left">
                            Tipo de contrato:
                        </th>

                        <td>
                            @if( isset($sitio->multiple_empresa_contrato) &&  $sitio->multiple_empresa_contrato) 
                                {{ $req->tipo_contrato }}
                            @else
                                CONTRATO POR OBRA O LABOR
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="text-left">
                            Cargo:
                        </th>

                        <td>
                            {{ $req->cargo }}
                        </td>
                    </tr>

                    <tr>
                        <th class="text-left">
                            Empresa / Cliente:
                        </th>

                        <td>
                            {{$req->nombre_cliente}}
                        </td>
                    </tr>

                    <!--<tr>
                        <th class="text-left">
                            Estado del contrato:
                        </th>

                        <td>
                            
                        </td>
                    </tr>-->

                    <tr>
                        <td colspan="2"></td>
                    </tr>

                </table>
            </div>

        </div>
    </div>
    <script type="text/javascript" src="{{ url('assets/js/bootstrap.min.js') }}"></script> 
</body>
</html>