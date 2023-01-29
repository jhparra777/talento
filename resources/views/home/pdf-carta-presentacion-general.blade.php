<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Carta de presentación</title>

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

        #footer {
            position: fixed; left: 0px;
            bottom: -10px;
            right: 0px;
            height: 110px;
            margin: auto;
            text-align: center;
            font-size: 7pt;
        }

        .text-center{ text-align: center;  }
        .text-left{ text-align: left;  }
        .text-right{ text-align: right;  }
        .text-light{ font-weight: lighter; }

        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }
        .mt-6{ margin-top: 6rem; }

        .pd-1{ padding: 1rem; }

        .center{ margin: auto; }

        .table{
            border-collapse:separate; 
            /*border-spacing: 6px;*/
        }

        .justify{ text-align: justify; }

        .list{ list-style: none; }

        .space{ line-height: 18px; }

        hr{
            page-break-after: always;
            border: none;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <table class="mt-6 center" width="90%">
        <tr>
            <td style="width: 30%">
                @if(isset($requerimiento->logo))
                    @if($logo != "")
                        <img style="max-width: 200px" src="{{ url('configuracion_sitio/'.$logo) }}">
                    @endif
                @endif
            </td> 
        </tr>
    </table>
    <table class="center table justify mt-6" width="75%">
        <tr class="pd-1">
            <th class="text-left" width="100%">
                <b>Ciudad y Fecha : {{ ($ciudad_req != null ? $ciudad_req->nombre : '') }} {{ $fecha_firma_replace }}</b>
            </th>
        </tr>
        <tr>
            <th class="text-left" width="100%">
                <b>Señores : {{ ($requerimiento != null ? $requerimiento->nombre_cliente : '') }}</b>
            </th>
        </tr>
        <tr>
            <th class="text-left" width="100%">
                <b>Att : {{ $fechasContrato->atte_carta_presentacion }}</b>
            </th>
        </tr>

        <tr>
            <th class="text-left" width="100%">
                <b>Dirección : {{ $fechasContrato->direccion_carta_presentacion }}</b>
            </th>
        </tr>

        <tr>
            <th class="text-left" width="100%">
                <b>Area:.</b>
            </th>
        </tr>
    </table>
    <table class="mt-2" width="75%"></table>
    <table class="center table justify mt-4" width="75%">
        <tr>
            <td>
                <p><b>Apreciados señores:</b></p><br>

                De acuerdo a la solicitud de servicio efectuada por ustedes, nos complace
                informarles que hemos seleccionado a: {{ mb_strtoupper($candidato->nombres . ' ' . $candidato->primer_apellido . ' ' . $candidato->segundo_apellido, 'UTF-8') }} identificado(a) con la {{ mb_strtoupper($candidato->dec_tipo_doc, 'UTF-8') }} No. {{ $candidato->numero_id }} @if($ciudadexpedicion != null)
                expedida en: {{ $ciudadexpedicion->nombre }} @endif para ejecutar la labor de: {{ $reqcandidato->nombre_cargo_especifico }}
                <br><br>
                Firma contrato a partir del {{ $fecha_firma_replace }}
                <br><br><br>
                Hora cita : {{ date("g:i a",strtotime($fechasContrato->hora_ingreso)) }}
                <br><br>
                Les agradecemos nos informen sobre cualquier sugerencia o inconveniente que
                se les presente, para solucionarlo inmediatamente.
                <br><br><br>
                Muchas gracias por utilizar nuestros servicios
                <br><br><br><br><br>
                Cordialmente
                <br><br><br><br>
                <img style="max-width: 200px" src="{{ url('recursos_carta_presentacion/firma_lida_peraza_01.png') }}">
                <br>Talent Supply Chain Department
            </td>
        </tr>

        @if($qrcode)
        <tr>
            <td class="text-center">
                <br>
                <img style="width:40%;height:135px;" alt="codigo QR" src="data:image/png;base64,{!!$qrcode!!}" />   
            </td>
        </tr>
        @endif
    </table>
    <br><br>
    <div id="footer">
        <b>Cali: Calle 21 Norte #8 n 21 - Bogota: carrera 47 # 100-41 - Barranquilla: Carrera 59 # 75-133 B/Concepción Bucaramanga: Calle 59 # 32-79 -<br>
        Buenaventura: Calle 7 # 3B - 14 Edificio trinidad - Buga: Calle 6 # 11-48 - Buga: Calle 6 # 11 - 48 Of. 12 Centro - Cartagena: Centro<br>
        industrial Ternera Bodega M1 - Duitama: Calle 15 # 17-71 Oficina 603 edificio Carrara - Ibague: Calle 35 # 4-B-38 - Medellin: Carrera 7 A # 47-33<br>
        B/Velodromo - Neiva: Carrera 1 F # 54-08 - Palmira: Calle 31 # 28-13 edificio olmenares of 204 - Pasto: Carrera 25 # 15-62 Centro Comercial San Juan del lago<br>
        Local 315 - Pereira: Avenida 30 de agosto # 38-68 - Santander de quilichao: Calle 6 # 10-67 - Tulua Carrera 25 # 31-20 Villavicencio: Carrera 35 #<br>
        34A-46 B/Barzal Bajo - Yopal: Carrera 28 # 11 -54 - Santa Marta: Km 8 Sector Pasos Colorados<br>
        <br>Afiliados a Acoset - www.listos.com.co</b>
    </div>
</body>
</html>