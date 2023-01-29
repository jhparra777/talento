<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ficha en PDF</title>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    </head>
    <style>
        @page { margin: 30px 30px;font-size: 0.9em; }
        .page-break {
            page-break-after: always;
            
        }
        table {
            border-collapse: collapse;
            width: 100%;
            padding: 5px;
            margin: 0;

        }
        table.bordeada{
            border:1px solid #cacaca;
        }
        table.bordeada td{
            border-bottom: 1px solid #cacaca;
            border-right:1px solid #cacaca;
            padding: 5px;
        }
        h3.titulo{
            font-size: 1.2em;
            border-bottom: 1px solid #FAFAFA;
            padding:5px;
        }
        .td_titulo{
            background: #FAFAFA;
        }
        .logo_ficha{
            max-width: 200px;
        }
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 1em;
        }
        footer{
            position: fixed;
            bottom: 0;
        }
    </style>
    <body>
        <table>
            <tr>
                <td>
                    @if(isset(FuncionesGlobales::sitio()->logo))
                        @if(FuncionesGlobales::sitio()->logo != "")
                            <img class="logo_ficha" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}">
                        @else
                            <img class="logo_ficha" src="{{url('img/logo.png')}}">
                        @endif
                    @else
                        <img class="logo_ficha" src="{{url('img/logo.png')}}">
                    @endif
                </td>
                <td>Ficha Perfil</td>
                <td>Generado {{ date("Y/m/d H:i:s",time())}}</td>
            </tr>
        </table>
        <h1 class="titulo">No hay ficha asociado al requerimiento.</h1>
    </body>
</html>