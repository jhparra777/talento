<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Firma de contrato</title>

    <style>
        html{
            font-family: 'Arial';
        }

        body{
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 11pt;
            line-height: 1.2;
            color: black;
            background-color: #fff;
        }

        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .text-center{ text-align: center;  }
        .text-left{ text-align: left;  }
        .text-right{ text-align: right;  }
        .text-light{ font-weight: lighter; }

        .center{ margin: auto; }

        .table{
            border-collapse:separate; 
            /*border-spacing: 6px;*/
        }
    </style>
</head>
<body>
    <div class="center" style="width: 95%;">
        <div class="text-left">
            @if(isset($empresa_contrata))
                @if (!empty($empresa_contrata->logo))
                    <img src="{{ asset("configuracion_sitio/$empresa_contrata->logo") }}" width="100">
                @else
                    <img src="{{ asset("configuracion_sitio/$sitio->logo") }}" width="100">
                @endif
            @else
                <img src="{{ asset("configuracion_sitio/$sitio->logo") }}" width="100">
            @endif
        </div>

        <div class="mt-2" style="text-align: justify;">
            @include('admin.clausulas.include.cuerpo_documento', ["cuerpo_documento" => $nuevo_cuerpo])
        </div>
    </div>

    <?php
        $identificacion = $datos->getTipoIdentificacion;
        $descripcion_identificacion = 'Nro. documento';
        if (!empty($identificacion)) {
            $descripcion_identificacion = $identificacion->descripcion;
        }
    ?>
    <table class="table">
        <tr>
            @if ($opcion_firma == "firma_a")
                {{-- Solo mostrar firma empleador --}}
                <td>
                    <div style="width: 100%; margin: 4em;">
                        @if( isset($empresa_contrata) && $empresa_contrata->firma != null )
                            <img src="{{ asset('contratos/'.$empresa_contrata->firma) }}" width="180">
                        @else
                            <img src="{{ asset('contratos/default.jpg') }}" width="180">
                        @endif
                        <p>__________________________</p>
                        EMPLEADOR: <br>
                        {{ isset($empresa_contrata) ? $empresa_contrata->nombre_representante : "Nombre Empleador" }} <br>
                        {{ isset($empresa_contrata) ? $empresa_contrata->cedula_representante : "Cargo." }}
                        <br>
                    </div>
                </td>
                <td width="20%"></td>
            @elseif ($opcion_firma == "firma_b")
                {{-- Solo mostrar firma empleado --}}
                <td>
                    <div style="width: 100%; margin: 4em;">
                        @if(isset($firma_default))
                            <img src="{{ $firma_default }}" width="180">

                            <p>__________________________</p>
                            EMPLEADO:<br>
                            {{ $datos->fullname() }}
                            <br>
                            {{ $descripcion_identificacion }}: {{ $datos->numero_id }}
                        @else
                            <img src="{{ $firma }}" width="180">

                            <p>__________________________</p>
                            EMPLEADO:<br>
                            {{ mb_strtoupper($candidato->nombres) }} {{ mb_strtoupper($candidato->primer_apellido)}} {{ mb_strtoupper($candidato->segundo_apellido)}}
                            <br>
                            {{ $descripcion_identificacion }}: {{ $candidato->numero_id }}
                        @endif
                    </div>
                </td>
                <td width="20%"></td>
            @elseif ($opcion_firma == "firma_c")
                {{-- Mostrar dos firmas --}}
                <td>
                    <div style="width: 100%; margin: 4em;">
                        @if( isset($empresa_contrata) && $empresa_contrata->firma != null )
                            <img src="{{ asset('contratos/'.$empresa_contrata->firma) }}" width="180">
                        @else
                            <img src="{{ asset('contratos/default.jpg') }}" width="180">
                        @endif
                        <p>__________________________</p>
                        EMPLEADOR: <br>
                        {{ isset($empresa_contrata) ? $empresa_contrata->nombre_representante : "Nombre Empleador" }} <br>
                        {{ isset($empresa_contrata) ? $empresa_contrata->cedula_representante : "Cargo." }}
                        <br>
                    </div>
                </td>
                <td width="20%"></td>
                <td>
                    <div style="width: 100%; margin: 4em;">
                        @if(isset($firma_default))
                            <img src="{{ $firma_default }}" width="180">

                            <p>__________________________</p>
                            EMPLEADO:<br>
                            {{ $datos->fullname() }}
                            <br>
                            {{ $descripcion_identificacion }}: {{ $datos->numero_id }}
                        @else
                            <img src="{{ $firma }}" width="180">

                            <p>__________________________</p>
                            EMPLEADO:<br>
                            {{ mb_strtoupper($candidato->nombres) }} {{ mb_strtoupper($candidato->primer_apellido)}} {{ mb_strtoupper($candidato->segundo_apellido)}}
                            <br>
                            {{ $descripcion_identificacion }}: {{ $candidato->numero_id }}
                        @endif
                    </div>
                </td>
                <td width="20%"></td>
            @endif
        </tr>
    </table>
</body>
</html>