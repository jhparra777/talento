<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        
        <title> Entrevista Múltiple Req # {{$entrevista->req_id}} - T3RS </title>
        
        <style type="text/css">
            @page { margin: 50px 70px; }

            .page-break {
                page-break-after: always;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                padding: 0;
                margin: 0;
            }

            .table1 {
                border-collapse: collapse;
                width: 100%;
                padding: 0;
                margin: 0;
            }

            .table1, th, td {
                /*border: 1px solid #cacaca;*/
                padding: 5px;
            }

            #g-tr{
                margin-bottom: 90px;
                padding-bottom: 90px;
            }

            body {
                font-family: 'Bank Gothic', Bank, serif;
                font-size: 16px;
                background-color: #FFFFFF;
            }

            hr.style2 {
                border: 0;
                height: 1px;
                background: #377cfc;
                background-image: -webkit-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                background-image: -moz-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                background-image: -ms-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                background-image: -o-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                width: 50%;
                color: #377cfc;

            }

            hr.style3 {
                border-top: 3px double;
                color: #377cfc;
                width: 50%;
            }

            h2,.blue {
                color: #377cfc;
            }

            .colum1 tr td:nth-child(1),.colum1 tr th{
                background-color: #fafafa;
                font-weight: bold;
            }

            .titulo-center {
                text-align: center;
            }

            footer{
                position: fixed;
                bottom: 0;
            }

            /* Justificar parrafo */
            p{
                text-align: justify;
            }
            
            .subtitulo {
                padding-left: 50px;
            }

            .parrafo{
                padding-left: 65px
            }

            .logo_derecha{
              
              position: absolute;
              right: 0;
            }

            .textCenter{
                text-align: center;
            }

            .breakAlways{
                page-break-after: always;
            }

            .primer_td {
                padding: 10px;
                margin: 20px 0;
                border: 1px solid #aba6a6;
                border-right: none;
                border-left-width: 5px;
                background-color: #ecf0f5;
                font-size: 14px;
                border-left-color: #377cfc;
                color: #377cfc;
            }
            .final_td {
                padding: 10px;
                margin: 20px 0;
                border: 1px solid #aba6a6;
                border-right: none;
                border-left-width: 5px;
                background-color: #ecf0f5;
                font-size: 13px;
                border-left-color: #377cfc;
            }
            .td {
                padding: 10px;
                margin: 20px 0;
                border: 1px solid #aba6a6;
                border-right: none;
                border-left: none;
                background-color: #ecf0f5;
                font-size: 12px;
            }
            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            :after, :before {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
        </style>
    </head>
    <body>
        <table width="100%">
            <!-- FL-1 -->
            <tr id="g-tr">
                <!-- Col-3 -->
                <td colspan="3" width="25%">      
                    @if($entrevista->requerimiento->empresa_logo() != null && $entrevista->requerimiento->empresa_logo()->logo != null)
                        <?php $logo_empresa = $entrevista->requerimiento->empresa_logo()->logo; ?>
                        <img style="max-width: 200px" src='{{ asset("configuracion_sitio/$logo_empresa")}}'>
                    @else
                        <img style="max-width: 200px" src="{{url('img/logo.png')}}">
                    @endif
                </td>
                <!-- Col-6 -->
                <td colspan="6" width="50%">
                    <address class="textCenter">
                        <strong>
                            Informe Entrevista Múltiple - Req. # {{ $entrevista->req_id }} <br>
                            {{ $entrevista->requerimiento->nombre_cliente_req() . ' - ' . $entrevista->requerimiento->cargo_req() }} <br>
                            {{ $entrevista->titulo }} <br>
                        </strong>
                    </address>
                </td>
                <!-- Col-3 -->
                <td colspan="3" width="25%">
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td colspan="1" width="10%"></td>
                <td colspan="10" width="80%">
                    <address>
                        <p>{{ $entrevista->descripcion }}</p>
                    </address>
                </td>
                <td colspan="1" width="10%"></td>
            </tr>
        </table>
        <br>
        <?php $entrevistas = $entrevista->entrevista_multiple_detalles()->whereNotNull('concepto')->orderBy('apto')->orderBy('calificacion', 'desc')->get(); ?>
        @foreach ($entrevistas as $key => $detalles)
            <table width="100%" class="table1">
                    <tr>
                        <td colspan="2" width="19%" class="primer_td">
                            {{$key+1}} - {{ $detalles->datos_basicos->nombres . ' ' . $detalles->datos_basicos->primer_apellido . ' ' . $detalles->datos_basicos->segundo_apellido }}<br>
                            Nro. doc.: {{ $detalles->datos_basicos->numero_id }}
                        </td>
                        <td colspan="2" width="17%" class="td textCenter">
                            @if($detalles->user->foto_perfil != null && file_exists('recursos_datosbasicos/'.$detalles->user->foto_perfil))
                                <img alt="user photo" style="max-width: 100%" src="{{ url('recursos_datosbasicos/'.$detalles->user->foto_perfil) }}">
                            @else
                                <img alt="user photo" style="max-width: 100%" src="{{ url('img/personaDefectoG.jpg') }}">
                            @endif
                        </td>
                        <td colspan="5" width="41%" class="td">
                            <b>Concepto:</b> {{ $detalles->concepto }}
                        </td>
                        <td colspan="3" width="23%" class="td">
                            @if ($detalles->apto != 2)
                                <b>Calificación:</b>
                                @if ($detalles->calificacion > 0)
                                    <br>
                                    @for($i = 0; $detalles->calificacion > $i; $i++)
                                        <img alt="estrella" style="max-width: 20px; padding-top: 5px;" src="{{ url('img/star_gold.png') }}">
                                    @endfor
                                @else
                                    {{ $detalles->calificacion }}
                                @endif
                                <br>
                            @endif
                            <strong>{{ $detalles->apto == 1 ? 'El candidato es apto' : ($detalles->apto == 2 ? 'El candidato es no apto' : '') }}</strong><br>
                        </td>
                    </tr>
                    @if ($detalles->concepto != null && $detalles->concepto != '')
                        <tr>
                            <td colspan="12" width="100%" class="final_td">
                                <b>Psicólogo que realiza entrevista:</b> {{ $detalles->nombre_usuario_gestiono() }}<br>
                                <b>Fecha de realización entrevista:</b> {{ \App\Models\DatosBasicos::convertirFecha($detalles->updated_at) }}
                            </td>
                        </tr>
                    @endif
            </table>
            <br>
        @endforeach
        <hr align="right" class="style2">
        
        @if ($entrevista->concepto_general != null)              
            <p class="subtitulo">
                <strong>
                    Concepto general
                </strong>
            </p>

            <p class="parrafo">
                {{strip_tags($entrevista->concepto_general)}}
            </p>
        @endif

        <br>
        <br>
 

        <!--  PIE -->
        <footer>
            <div style="position: relative;">
                <img alt="Logo T3RS" class="izquierda" height="25" src="{{url('img/t3.png')}}" width="20"> www.t3rsc.co

                {{--@if(!is_null($reqcandidato->logo_empresa) && $reqcandidato->logo_empresa != "")
                    <img class="logo_derecha" alt="Logo empresa"  height="50" width="95" src='{{ asset("configuracion_sitio/$reqcandidato->logo_empresa")}}'>
                @elseif($logo!="")
                    <img class="logo_derecha" alt="Logo empresa"  height="50" width="95" src="{{ url('configuracion_sitio/'.$logo)}}">
                @else
                    <img class="logo_derecha" alt="Logo empresa"  height="50" width="95" src="{{url('img/logo.png')}}">
                @endif--}}
            </div>
        </footer>
    </body>
</html>