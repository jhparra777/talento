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
        @if($cliente === null)

        @else
        <table>
            <tr>
                <td>
                    @if( isset(FuncionesGlobales::sitio()->logo) && FuncionesGlobales::sitio()->logo != "" )
                        <img class="logo_ficha" src="configuracion_sitio/{!! ((FuncionesGlobales::sitio()->logo)) !!}"/>
                    @else
                        <img class="logo_ficha" src="{{url("img/logo.png")}}"/>
                    @endif

                </td>
                <td>Ficha Perfil</td>
                <td>Generado {{ date("Y/m/d H:i:s",time())}}</td>
            </tr>
        </table>
        <h3 class="titulo">Datos Generales de la Empresa</h3>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Razón Social</td>
                <td>{{ $cliente->nombre }}</td>
                <td class="td_titulo">NIT</td>
                <td>{{ $cliente->nit }}</td>
            </tr>
            <tr>
                <td class="td_titulo">Ciudad</td>
                <td>{{ $cliente->getUbicacion()->value }}</td>
                <td class="td_titulo">Dirección</td>
                <td>{{ $cliente->direccion }}</td>
            </tr>
            <tr>
                <td class="td_titulo">Teléfono</td>
                <td>{{ $cliente->telefono }}</td>
                <td class="td_titulo"></td>
                <td></td>
            </tr>
        </table>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Cargo Cliente/Especifico</td>
                <td>{{ $cargo_cliente->descripcion }}</td>
                <!--<td> $cargo_cliente->tipoCargoGenerico()->descripcion </td>-->
            </tr>
        </table>
        <h3 class="titulo">Requerimientos de Selección</h3>
        <table>
            <tr>
                <td>Número de Candidatos a presentar por vacantes:</td>
                <td style="text-align:left;">{{ $ficha->cantidad_candidatos_vac}}</td>
            </tr>
        </table>
        
        <table class="bordeada" >
            <tr>
                <td class="td_titulo">Número de Vacantes</td>
                <td class="td_titulo">Tiempo de Respuesta envío Candidatos</td>
            </tr>
            <tr>
                <td class="td_titulo">1 - 5</td>
                <td>{{$ficha->tiempo_respuesta['t15']}}</td>
            </tr>
            <tr>
                <td class="td_titulo">6 - 10</td>
                <td>{{$ficha->tiempo_respuesta['t610']}}</td>
            </tr>
            <tr>
                <td class="td_titulo">Más de 10</td>
                <td>{{$ficha->tiempo_respuesta['tmas10']}}</td>
            </tr>
        </table>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Procedimientos Realizar</td>
                <td>
                    <table class="bordeada">
                        <tr>
                            <td>
                                {{ isset($ficha->procesos['entrevista']) ? $ficha->procesos['entrevista'] : ' ' }}
                            </td>
                            <td>Entrevista</td>
                        </tr>
                        <tr>
                            <td>
                                {{ isset($ficha->procesos['entrevista_cliente']) ? $ficha->procesos['entrevista_cliente'] : ' ' }}
                            </td>
                            <td>Entrevista con el cliente</td>
                        </tr>
                        <tr>
                            <td>
                                {{ isset($ficha->procesos['validacion']) ? $ficha->procesos['validacion'] : ' ' }}
                            </td>
                            <td>Validación
                                
                                <table class="bordeada">
                                    @foreach($documentos as $documento)
                                    <tr>
                                        <td>
                                          {{ in_array($documento->id, $ficha->docs) ? 'x':' ' }}
                                        </td>
                                        <td>{{ $documento->descripcion }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ isset($ficha->procesos['referenciacion']) ? $ficha->procesos['referenciacion'] : ' ' }}
                            </td>
                            <td>Referenciacion</td>
                        </tr>
                        <tr>
                            <td>
                            {{ isset($ficha->procesos['pruebas_psicotecnicas']) ? $ficha->procesos['pruebas_psicotecnicas'] : ' ' }}
                            </td>
                            <td>Pruebas Psicotécnicas</td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top">
                    <table class="bordeada">
                        <tr>
                            <td class="td_titulo">Requiere informe selección</td>
                            <td>{{ ($ficha->req_informe_seleccion=="si")?'x':' ' }}</td>
                            <td>Si</td>
                            <td>{{ ($ficha->req_informe_seleccion=="no")?'x':' ' }}</td>
                            <td>No</td>
                        </tr>
                        <tr>
                            <td class="td_titulo">Estudio de Seguridad</td>
                            <td>{{ ($ficha->req_estudio_seguridad=="si")?'x':' ' }}</td>
                            <td>Si</td>
                            <td>{{ ($ficha->req_estudio_seguridad=="no")?'x':' ' }}</td>
                            <td>No</td>
                        </tr>
                        <tr>
                            <td class="td_titulo">Visita Domiciliaria</td>
                            <td>{{ ($ficha->req_visita_domiciliaria=="si")?'x':' ' }}</td>
                            <td>Si</td>
                            <td>{{ ($ficha->req_visita_domiciliaria=="no")?'x':' ' }}</td>
                            <td>No</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <h3 class="titulo">Condiciones del Perfil</h3>
        <table class="bordeada">
            <tr>
                <td>Documentación Adicional Requerida</td>
                <td>
                    <table class="bordeada">
                        @foreach( $docs_adicionales as $doc )
                        <tr>
                            <td>{{$doc->valor}}</td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                <td style="vertical-align: top">
                    <table class="bordeada">
                        <tr>
                            <td class="td_titulo">Criticidad del Cargo</td>
                            <td>{{ ($ficha->criticidad_cargo=="alta")?'x':' ' }}</td>
                            <td>Alta</td>
                            <td>{{ ($ficha->criticidad_cargo=="media")?'x':' ' }}</td>
                            <td>Media</td>
                            <td>{{ ($ficha->criticidad_cargo=="baja")?'x':' ' }}</td>
                            <td>Baja</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Edad</td>
                <td>Mínima : {{ $ficha->edad_minima }}</td>
                <td>Máxima : {{ $ficha->edad_maxima }}</td>
                <td class="td_titulo">Género</td>
                <td>{{ $ficha->getGeneroDescr()->genero}}</td>
            </tr>
        </table>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Escolaridad</td>
                <td>{{ $ficha->getEscolaridadDescr()->escolaridad }}</td>
                <td>Otro Estudio : {{$ficha->otro_estudio}}</td>
                <td class="td_titulo">Experiencia</td>
                <td>{{ $ficha->getExperienciaDescr()->experiencia }}</td>
            </tr>
        </table>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Area de Desempeño</td>
                <td>{{$ficha->area_desempeno}}</td>
                <td class="td_titulo">Conocimientos Especificos</td>
                 <td>{{$ficha->conocimientos_especificos}}</td>
            </tr>
        </table>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Pruebas Psicotécnicas</td>
                <td>
                    <table class="bordeada">
                        @foreach($pruebas_ficha as $pruebas)
                        <tr>
                            <td>{{ $pruebas }}</td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                <td class="td_titulo">Competencias Requeridas</td>
                 <td>{{$ficha->competencias_requeridas}}</td>
            </tr>
        </table>
        <h3 class="titulo">Condiciones del Cargo</h3>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Horario</td>
                <td>{{ $ficha->getHorarioDescr()->horario }}</td>
                <td class="td_titulo">Observaciones Horarios</td>
                 <td>{{$ficha->observaciones_horario}}</td>
            </tr>
        </table>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Variable</td>
                <td></td>
                <td>Si</td>
                <td>x</td>
                <td>No</td>
                <td>#1000#</td>
            </tr>
            <tr>
                <td class="td_titulo">Comision</td>
                <td></td>
                <td>Si</td>
                <td>x</td>
                <td>No</td>
                <td>##</td>
            </tr>
            <tr>
                <td class="td_titulo">Rodamiento</td>
                <td>x</td>
                <td>Si</td>
                <td></td>
                <td>No</td>
                <td>#2000#</td>
            </tr>
        </table>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Rango Salarial</td>
                <td>{{ $ficha->getAspiracionDescr()->rango_salarial }}</td>
                <td class="td_titulo">Tipo Contrato</td>
                <td>{{ $ficha->getContratoDescr()->tipo_contrato }}</td>
            </tr>
        </table>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Canal al que pertenece</td>
                <td>{{ $ficha->canal_pertenece }}</td>
                <td class="td_titulo">Funciones Básicas</td>
                <td>{{ $ficha->funciones_realizar }}</td>
            </tr>
        </table>
         <h3 class="titulo">Condiciones Físicas</h3>
         <table class="bordeada">
            <tr>
                <td class="td_titulo">Estatura</td>
                <td>Mínima : {{ $ficha->estatura_minima }}</td>
                <td>Máxima : {{ $ficha->estatura_maxima }}</td>
                <td class="td_titulo">Talla Camisa</td>
                <td>{{ $ficha->talla_camisa }}</td>
            </tr>
        </table>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Talla Pantalón</td>
                <td>{{ $ficha->talla_pantalon }}</td>
                <td class="td_titulo">Calzado</td>
                <td>{{ $ficha->calzado }}</td>
            </tr>
        </table>
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Otros</td>
                <td>{{ $ficha->otros_fisicas }}</td>
                <td class="td_titulo">Restricciones</td>
                <td>{{ $ficha->restricciones }}</td>
            </tr>
        </table>
        <h3 class="titulo">Observaciones Generales</h3> 
        <table class="bordeada">
            <tr>
                <td class="td_titulo">Observaciones</td>
                <td>{{ $ficha->observaciones_generales }}</td>
            </tr>
        </table>
        <footer>Powered by T3RS</footer>
    </body>
    @endif
</html>