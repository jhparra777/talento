<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Solicitud Adelanto Nómina</title>
        <script type="text/javascript" src="{{ asset('js/no-back-button.js') }}"></script>
    </head>

    <style>

        body{
            font-family: Verdana, arial, sans-serif;
            font-size: 11px;
        }

        .otra tr td{
            font-size: 12px;
            padding-left: 50px;
            padding-top: 13px;
        }

        .tabla1, .tabla3{
            border-collapse: collapse;
            width: 100%;
        }

        .tabla2{
            border-collapse: collapse;
            width: 100%;
        }
      
        .tabla1, .tabla1 th, .tabla1 td,.tabla3 th, .tabla3 td {
            border: none;
            padding: 0;
            margin: 0;
        }

        .tabla2 td {
            padding: 0;
            margin: 0;
        }

        .tabla2 th {
            background-color: #fdf099;
            font-size: 14px;
            font-weight: bold;
            padding: 0;
            margin: 0;
            text-align: center;
            /*text-transform: capitalize;*/
        }

        @page { margin: 50px 50px; }

        .page-break {
            page-break-after: always;
        }

        .imagen{
            height: 150px
        }

        .titulo{
            background-color: #333131;
            padding: 10px 0px;
            color: #FFFFFF;
            text-align: center;
            font-size: 16px;
        }

        .tabla1 tr th{
            background-color: #fdf099;
            font-weight: bold;
            padding: 5px 10px;
            text-align: left;
            width: 180px;
            font-size: 14px;
        }

        .tabla2 tr th{
            background-color: #fdf099;
            font-weight: bold;
            padding: 5px 10px;
            text-align: left;
            font-size: 14px;
        }

        .tabla1 tr td{
            padding: 5px 10px;
            font-size: 14px;
            width: 100%;
        }

        .tabla2 tr td{
            padding: 5px 10px;
            font-size: 14px;
        }

        .fz-17{
            font-size: 17px;
        }

        .col-center{
            float: none;
            margin-left: auto;
            margin-right: auto;
        }

        .logo_derecha{      
            position: absolute;
            right: 0;
        }

        .text-center{ text-align: center; }
        .text-left { text-align: left; }

        .m-0{ margin: 0; }
        .m-1{ margin: 1rem; }
        .m-2{ margin: 2rem; }
        .m-3{ margin: 3rem; }
        .m-4{ margin: 4rem; }
    </style>

    <body onload="nobackbutton();">
        <table width="97%">
            <tr>
                <th class="text-left">
                    @if($logo != "")
                        <img style="margin-top: 10px;" alt="Logo" src="{{url('configuracion_sitio')}}/{!!$logo!!}" width="150">
                    @elseif(isset($sitio->logo))
                        @if($sitio->logo != "")
                            <img style="margin-top: 10px;" alt="Logo" src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="150">
                        @else
                            <img style="margin-top: 10px;" alt="Logo" src="{{ asset('img/logo.png')}}" width="150">
                        @endif
                    @else
                        <img style="margin-top: 10px;" alt="Logo" src="{{url('img/logo.png')}}" width="150">
                    @endif
                </th>
            </tr>
        </table>
        <br><br>
        <?php
            $nombre_completo = "$candidato->nombres $candidato->primer_apellido";
            $nombre_completo .= ($candidato->segundo_apellido != null && $candidato->segundo_apellido != '' ? " $candidato->segundo_apellido" : '');
            $domicilio = $candidato->getCiudadDomicilio();
            $lugar_expedicion_doc = $candidato->getCiudadExpedicion();
            $nombre_empresa = $solicitud->requerimiento->empresa_logo()->nombre_empresa;
        ?>
        <table class="tabla1" style="width:100%;">
            <tr>
                <td align="justify">
                    <p>
                    Yo {{ $nombre_completo }}, mayor de edad,@if($domicilio != '') con domicilio en la ciudad de {{ $domicilio }},@endif identificado/a con {{ $candidato->tipo_id_desc }} No. {{ $candidato->numero_id }} @if(lugar_expedicion_doc != '') expedida en la ciudad de {{ $lugar_expedicion_doc }},@else , @endif por medio del presente escrito presento solicitud de <b>adelanto de salario u honorarios</b>, documento electrónico que reposará en mi historial laboral, a fin de solventar necesidades familiares o personales que me impiden esperar hasta la próxima fecha en que recibiré la remuneración correspondiente a los servicios prestados o a las labores desempeñadas en la empresa {{ $nombre_empresa }}.
                    </p>
                </td>
            </tr>
            <tr>
                <td align="justify">
                    <p>
                    <?php $monto_maximo_quincena = number_format($monto_maximo_quincena, 0, ',', '.'); ?>
                    En razón a lo anterior, <b>conozco</b> que, por concepto de gastos administrativos de cada adelanto que me sea aprobado (el cual será por máximo ${{$monto_maximo_quincena}} pesos por quincena), se me descontará de mi próximo salario la suma de <b>seis mil quinientos pesos m-cte ($6.500)</b>, valor que <b>autorizo</b> sea debitado de mi salario, honorarios, vacaciones, liquidación y/o prestaciones sociales, a fin de solventar los gastos operativos, técnicos, financieros y administrativos asumidos en pro de la presente solicitud.
                    </p>
                </td>
            </tr>
            <tr>
                <td align="justify">
                    <p>
                        <?php $monto_pesos = number_format($solicitud->valor, 0, ',', '.'); ?>
                        <b>- Monto solicitado en adelanto:  {{ valor_a_texto($solicitud->valor) }} <span class="fz-17">{{ '($'.$monto_pesos.')' }}</span>.</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td align="justify">
                    <p>
                    Conforme a lo anterior, <b>autorizo</b> de forma libre y espontánea a la empresa <b>T3RS DIGITAL</b> para que adelante todos los trámites necesarios ante mi empleador o contratante tendientes a radicar la solicitud para adelanto de nómina; tramitar la misma ante la empresa {{ $nombre_empresa }}, verificar con el área de talento humano la disponibilidad del salario, honorarios, vacaciones, liquidación y/o prestaciones sociales a fin de conceder el adelanto citado y notificar a mi empleador o contratante para que éste descuente el valor adelantado de la próxima nómina quincenal o mensual, o sobre mi liquidación y/o prestaciones sociales que me será entregada.
                    </p>
                </td>
            </tr>
            <tr>
                <td align="justify">
                    <p>
                    De igual modo, <b>autorizo</b> para que el valor solicitado pueda ser adelantado y descontado de las vacaciones pendientes por disfrutar, así como de las licencias remuneradas obtenidas. Así mismo, en caso de dar por terminado mi contrato, <b>autorizo</b> para que el valor solicitado por adelantado, pueda descontarse de la liquidación y/o prestaciones sociales adeudada con ocasión a la terminación de la relación laboral o contractual.
                    </p>
                </td>
            </tr>
            <tr>
                <td align="justify">
                    <p>
                    <b>Autorizo</b> a la empresa <b>T3RS DIGITAL</b>, para que por cualquier medio que sea expedito, me notifique respecto  a la aprobación o negación de la solicitud y, para que, me notifique respecto al estado de la consignación del valor adelantado de nómina a la siguiente cuenta digital:
                    </p>
                </td>
            </tr>
            <tr>
                <td align="justify">
                    <p>
                    <b>{{ $solicitud->banco_nomina->descripcion }}<br>
                    @if ($solicitud->banco_nomina->tipo_manejo == 'cuenta')Cuenta de {{ $solicitud->tipo_cuenta_banco()->descripcion }} No. {{ $solicitud->numero_cuenta }},@else No. {{ $solicitud->telefono }},@endif</b> la cual certifico que está bajo mi titularidad y/o dominio, también manifiesto que me hago totalmente responsable de los datos que aquí consigno, los cuales he verificado y corresponden a la cuenta en donde quiero me sea consignado el valor del adelanto de nómina.
                    </p>
                </td>
            </tr>
            <tr>
                <td align="justify">
                    <p>
                    De otro lado, <b>declaro que conozco que la solicitud de adelanto de nómina</b> es un trámite que adelanta <b>T3RS DIGITAL</b> ante mi empleador y/o contratista, razón por la cual, cualquier reclamación, queja, sugerencia y demás peticiones relacionadas de forma exclusiva con <b>la presente solicitud</b>, deberán ser gestionadas ante <b>T3RS DIGITAL</b>, en su calidad de Responsable ante el correo {{$correo_responsable}}.
                    </p>
                </td>
            </tr>
            <tr>
                <td align="justify">
                    <p>
                    Finalmente, declaro que conozco y he leído la Política de Tratamiento de Datos Personales disponible en el sitio web {{ url() }}, de este modo, tomando en consideración la autorización otorgada y dado que, la presente solicitud cumple con las finalidades para las cuales he autorizado el tratamiento de mis datos personales, manifiesto que conozco mis derechos y que mis datos serán tratados y protegidos conforme a la Ley 1581 del año 2012, así como de acuerdo a las normas reglamentarias y complementarias.
                    </p>
                </td>
            </tr>
        </table>
        <br><br>
        <table class="tabla2 m-1">
            <tr>
                <td style="width: 55%;">
                    <p><img src="{{ $solicitud->firma }}" width="180" style="margin:0; padding:0;"> <br>___________________________________</p>
                    <p>Nombre: {{ $candidato->nombres.' '.$candidato->primer_apellido.' '.$candidato->segundo_apellido }} </p>
                    <p>
                        {{ $candidato->tipo_id_desc }}: {{ $candidato->numero_id }}
                    </p>
                    <p>Fecha: {{ dar_formato_fecha($solicitud->created_at) }}</p>
                </td>
            </tr>
        </table>
        <br><br>
        <?php
            $fotos = $solicitud->getFotosArray();
            $ruta = 'recursos_adelanto_nomina_fotos/solicitud_'.$solicitud->user_id.'_'.$solicitud->requerimiento_id.'/solicitud_'.$solicitud->id;
        ?>
        <section>
            <div class="text-center">
                <h4>Fotos tomadas durante el proceso de la solicitud</h4>

                @forelse($fotos as $foto)
                    @if(!triRoute::validateOR('local') && $foto != null && $foto != '')
                        <img 
                            class="m-1" 
                            src="{{ asset("$ruta/$foto") }}" 
                            alt="Foto candidato nomina"
                            width="220">
                    @elseif(!triRoute::validateOR('local'))
                        <img class="m-1" src="https://picsum.photos/640/420" alt="T3RS" width="220">
                    @endif
                @empty
                    <br>
                    <p>
                        No se presenta evidencia fotográfica debido a que el candidato no autorizó el uso de cámara durante el proceso de la solicitud.
                    </p>
                @endforelse
            </div>
        </section>
    </body>
</html>
