<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Orden Examen Médico</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    </head>

    <body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 50px 50px; page-break-after: always;">

        @if(Sentinel::check()->inRole("admin"))
            <!-- Validamos si el candidato esta con estado 5 que hace referencia a problemas de seguridad -->
            @if($candidato->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD'))
                <div class="classname">!!</div>
            @endif
        @endif
        <div style="border: solid 1px black;">
            <table width="100%">
                @if(isset($EstudioSeguridad))
                    <caption style="margin-right: 10px; text-align: left;"> <h2>AUTORIZACIÓN ESTUDIO SEGURIDAD DE INGRESO</h2> </caption>
                @else
                    <caption style="margin-right: 10px; text-align: left;"> <h2>AUTORIZACIÓN EXAMEN MÉDICO DE INGRESO</h2> </caption>
                @endif
                <tr>
                    <td>
                        <p style="display: inline-block;">Consecutivo:</p>
                        <div style="display: inline-block; border:solid 1px; padding-left: 24px; padding-right: 24px; border-radius: 6px; letter-spacing: 0.4em; font-weight: 700;">
                        <p>Nº {{ $DataOrder->id }}</p>
                        </div>
                        <br>

                         <p style="display: inline-block;">#Req:</p>
                        <div style="display: inline-block; border:solid 1px; padding-left: 24px; padding-right: 24px; border-radius: 6px; letter-spacing: 0.4em; font-weight: 700;">
                        <p>Nº {{ $DataOrder->req }}</p>
                        </div>

                    </td>

                    <td>
                        @if(isset($candidato->empresa_contrata))
                            @if($empresa != '' && $empresa->logo != null)
                                <img style="max-width: 200px float: right;" src="{{ url('configuracion_sitio')}}/{{ $empresa->logo }}" width="100">
                            @elseif(isset(FuncionesGlobales::sitio()->logo))
                                @if(FuncionesGlobales::sitio()->logo != "")
                                    <img style="max-width: 200px; float: right;" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}" width="100">
                                @else
                                    <img style="max-width: 200px; float: right;" src="{{url('img/logo.png')}}" width="100">
                                @endif
                            @else
                                <img style="max-width: 200px; float: right;" src="{{url('img/logo.png')}}" width="100">
                            @endif
                        @elseif(isset(FuncionesGlobales::sitio()->logo))
                            @if(FuncionesGlobales::sitio()->logo != "")
                                <img style="max-width: 200px; float: right;" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}" width="100">
                            @else
                                <img style="max-width: 200px; float: right;" src="{{url('img/logo.png')}}" width="100">
                            @endif
                        @else
                            <img style="max-width: 200px; float: right;" src="{{url('img/logo.png')}}" width="100">
                        @endif
                    </td>
                </tr>
            </table>
          
            <table style="border: 1px solid black; border-collapse: collapse; padding: 10px;" width="50%">
                <tr>
                    <td style="border-top-left-radius: 50px !important;" style="border: 1px solid black; border-collapse: collapse; padding: 10px;">Fecha</td>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">
                        <?php
                            $date = new DateTime($DataOrder->created_at);
                            echo $date->format('d');
                        ?>
                    </td>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">
                        <?php
                            $date = new DateTime($DataOrder->created_at);
                            echo $date->format('m');
                        ?>
                    </td>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">
                        <?php
                            $date = new DateTime($DataOrder->created_at);
                            echo $date->format('Y');
                        ?>
                    </td>
                </tr>
            </table>
         
            <table style="border: 1px solid black; border-collapse: collapse; padding: 10px;" width="100%">
                <tr>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">Nombre del <br> trabajador: <b>{{ $candidato->nombres }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido }}</b> </td>
                </tr>

                <tr>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">Cédula de <br> ciudadanía: <b>{{ $candidato->numero_id }}</b> </td>
                </tr>
            </table>
              
            <table style="border: 1px solid black; border-collapse: collapse; padding: 10px;" width="100%">
                <tr>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">Cargo del <br> trabajador: <b>{{ $candidato->cargo }}</b> </td>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">Ciudad dónde <br> va a laborar: <b>{{ $candidato->ciudad }}</b> </td>
                </tr>

                <tr>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">Empresa <br> usuaria: <b>{{ $candidato->cliente }}</b> </td>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">Centro <br> médico: <b>{{ $DataOrder->centro_medico }}</b> </td>
                </tr>
            </table>

            <table style="border: 1px solid black; border-collapse: collapse; padding: 10px;" width="100%">
                <tr>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px; text-align:center; font-weight: 800; font-size:1.2rem; background-color: black; color: white;"><p>EXAMEN A PRACTICAR</p></td>
                </tr>
            </table>

            <br>

            <table style="border: 1px solid black; border-collapse: collapse; padding: 10px; margin: auto;" width="70%">
                @foreach ($DataExamenes as $examenes)
                    <tr>
                        <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;"><p style="margin-left: 6px;">{{ $examenes->examen_medico }}</p></td>
                        <td></td>
                    </tr>
                @endforeach
            </table>
          
            <br>

            <table style="border: 1px solid black; border-collapse: collapse; padding: 10px;" width="100%">
                <tr>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">Otros: {{ $DataOrder->otros }}</td>
                </tr>
            </table>
          
            <table style="border: 1px solid black; border-collapse: collapse; padding: 10px;" width="100%">
                <tr>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px; text-align: center;">
                        <br>
                        <p style="text-decoration: underline;">{!! ((FuncionesGlobales::datosUser($DataOrder->user_envio)->name)) !!}</p>
                        <p>Autorizado</p>
                        <br>
                    </td>
                </tr>
            </table>
              
            <!--<table style="border: 1px solid black; border-collapse: collapse; padding: 10px;" width="100%">
                <tr>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">Nombre:</td>
                    <td style="border: 1px solid black; border-collapse: collapse; padding: 10px;">Cargo:</td>
                </tr>
            </table>-->
              
        </div>
    </body>
</html>
