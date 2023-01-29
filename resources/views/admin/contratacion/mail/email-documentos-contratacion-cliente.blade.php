<?php
$sitio = FuncionesGlobales::sitio();
$color = "#ececec";
$color_azul = "#353e4a";
$color_blanco = "#ffffff";
if($tipo_correo === 'candidato') {
    if(isset($sitio->color)) {
        if($sitio->color != "") {
            $color = $sitio->color;
            $color_azul = $sitio->color;
            $color_blanco = $sitio->color;
        }
    }
}
?>
<div marginheight="0" marginwidth="0" style="background-color:{{$color}}">
<table align="center" bgcolor="{{$color}}" style="width:100%!important;table-layout:fixed">
<tbody>
<tr>
<td>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="m_-7484884227191431181m_-8044308263189181155deviceWidth" style="max-width:600px;margin:auto;background:{{$color_blanco}}">
<tbody>
<tr>
<td style="width:100%;background-color:{{$color_azul}}">
<table align="center" bgcolor="{{$color_azul}}" border="0" cellpadding="0" cellspacing="0" style="background-color:{{$color_azul}}" width="100%">
    <tbody>
        <tr>
            <td align="center" style="padding-top:8px;padding-bottom:8px;text-align:center;background-color:{{$color_azul}}" width="100%">
                <a class="m_-7484884227191431181m_-8044308263189181155fs18" data-saferedirecturl="" href="" style="color:#ffffff;text-decoration:none;font-family:'Arial';font-size:23px" target="_blank" title="Komatsu">
                    <b>
                        <i style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
                            <font color="white">
                                
                            </font>
                        </i>
                    </b>
                </a>
            </td>
        </tr>
    </tbody>
</table>
</td>
</tr>
<tr>
<td>
@if($tipo_correo === 'candidato')
    <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="color:#353e4a;font-family:Arial,sans-serif;font-size:15px;margin:auto" width="75%">
        <tbody>
            @if($empresa != '' && $empresa->logo != null)
                <tr>
                    <td align="center" style="padding: 40px 0 30px 0;">
                        <img align="center" border="0" src="{{ url('configuracion_sitio')}}/{{ $empresa->logo }}" alt="Image" title="Image" style="display: block !important;max-width: 227.5px" width="227.5">
                    </td>
                </tr>
            @elseif(isset($sitio->logo))
                @if($sitio->logo != "")
                <tr>
                    <td align="center" style="padding: 40px 0 30px 0;">
                        <img align="center" border="0" src="{{ url('configuracion_sitio')}}/{!! (($sitio->logo)) !!}" alt="Image" title="Image" style="display: block !important;max-width: 227.5px" width="227.5">
                    </td>
                </tr>
                @else
                <tr>
                    <td align="center" style="padding: 40px 0 30px 0;">
                        <img align="center" border="0" src="{{ url("img/logo.png")}}" alt="Image" title="Image" style="display: block !important;max-width: 227.5px" width="227.5">
                    </td>
                </tr>
                @endif
            @else
            <tr>
                <td align="center" style="padding: 40px 0 30px 0;">
                    <img align="center" border="0" src="{{ url("img/logo.png")}}" alt="Image" title="Image" style="display: block !important;max-width: 227.5px" width="227.5">
                </td>
            </tr>
            @endif
            <tr>
                <td align="center" class="m_-7484884227191431181m_-8044308263189181155title1" style="font-size:20px;padding-top:30px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:center;">
                    <b>
                        🎉 {{ $user->name }}, NOS ENCANTA QUE HAGAS PARTE DE NUESTRA FAMILIA Y AYUDARTE A CUMPLIR TUS SUEÑOS 👏
                    </b>
                </td>
            </tr>
            <tr>
                <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-top:10px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:center;color:#353e4a">
                    <p>
                        ¡Adjunto encontraras los documentos que debes presentar al momento de ingresar a laborar!
                    </p>
                </td>
            </tr>
@else  {{-- Para cliente --}}
    <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="color:#353e4a;font-family:Arial,sans-serif;font-size:15px;margin:auto" width="100%">
        <tbody>
            <tr>
                <td class="m_-7484884227191431181m_-8044308263189181155title1" style="font-size:18px;padding-top:30px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;">
                    <b>
                        Buen día
                    </b>
                </td>
            </tr>
            <tr>
                <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-top:10px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a">
                    <p>
                        Confirmamos contratación del candidat@ <strong>{{ $user->name }}</strong> para el cargo <strong>{{ $requerimiento->cargo }} de acuerdo a requerimiento No. {{ $requerimiento->requerimiento }}</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-top:10px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a">
                    <table style="border: 1px solid black; width: 100%;">
                        <tr>
                            <th style="border: 1px solid black;">NOMBRES Y APELLIDOS</th>
                            <td>{{$candidato->nombres.' '.$candidato->primer_apellido.' '.$candidato->segundo_apellido}}</td>
                        </tr>
                        @if (isset($candidato->dec_tipo_doc) && isset($candidato->numero_id))
                        <tr>
                            <th style="border: 1px solid black;">{{$candidato->dec_tipo_doc}}</th>
                            <td>{{$candidato->numero_id}}</td>
                        </tr>
                        @endif
                        @if (isset($candidato->fecha_inicio_contrato) && $candidato->fecha_inicio_contrato != '')
                        <tr>
                            <th style="border: 1px solid black;">FECHA DE INGRESO</th>
                            <td>{{$candidato->fecha_inicio_contrato}}</td>
                        </tr>
                        @endif
                        @if (isset($requerimiento->cargo) && $requerimiento->cargo != '')
                        <tr>
                            <th style="border: 1px solid black;">CARGO</th>
                            <td>{{$requerimiento->cargo}}</td>
                        </tr>
                        @endif
                        @if (isset($candidato->fecha_nacimiento) && $candidato->fecha_nacimiento != '')
                        <tr>
                            <th style="border: 1px solid black;">FECHA DE NACIMIENTO</th>
                            <td>{{$candidato->fecha_nacimiento }}</td>
                        </tr>
                        @endif
                        @if (isset($candidato->grupo_sanguineo) && $candidato->grupo_sanguineo != '')
                        <tr>
                            <th style="border: 1px solid black;">TIPO DE SANGRE</th>
                            <td>{{($candidato->grupo_sanguineo)?$candidato->grupo_sanguineo.' '.$candidato->rh:''}}</td>
                        </tr>
                        @endif
                        <tr>
                            <th style="border: 1px solid black;">RIESGO</th>
                            <td>{{($requerimiento->ctra_x_clt_codigo)?$requerimiento->getCentroTrabajo()->nombre_ctra:''}}</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black;">SALARIO</th>
                            <td>{{$requerimiento->salario}}</td>
                        </tr>
                        @if (isset($candidato->telefono_movil) && $candidato->telefono_movil != '')
                        <tr>
                            <th style="border: 1px solid black;">MÓVIL</th>
                            <td>{{$candidato->telefono_movil}}</td>
                        </tr>
                        @endif
                        @if (isset($candidato->direccion) && $candidato->direccion != '')
                        <tr>
                            <th style="border: 1px solid black;">DIRECCIÓN</th>
                            <td>{{$candidato->direccion}}</td>
                        </tr>
                        @endif
                        @if (isset($candidato->entidades_eps_des) && $candidato->entidades_eps_des != '')
                        <tr>
                            <th style="border: 1px solid black;">E.P.S.</th>
                            <td>{{$candidato->entidades_eps_des}}</td>
                        </tr>
                        @endif
                        @if (isset($candidato->entidades_afp_des) && $candidato->entidades_afp_des != '')
                        <tr>
                            <th style="border: 1px solid black;">FONDO DE PENSIÓN</th>
                            <td>{{$candidato->entidades_afp_des}}</td>
                        </tr>
                        @endif
                        @if (isset($candidato->caja_compensacion_des) && $candidato->caja_compensacion_des != '')
                        <tr>
                            <th style="border: 1px solid black;">CAJA DE COMPENSACIÓN</th>
                            <td>{{$candidato->caja_compensacion_des}}</td>
                        </tr>
                        @endif
                        @if (isset($requerimiento->nombre_cliente) && $requerimiento->nombre_cliente != '')
                        <tr>
                            <th style="border: 1px solid black;">EMPRESA USUARIA</th>
                            <td>{{$requerimiento->nombre_cliente}}</td>
                        </tr>
                        @endif
                        <tr>
                            <th style="border: 1px solid black;">EMAIL</th>
                            <td>{{$candidato->email}}</td>
                        </tr>
                    </table>

                </td>
            </tr>
            {{-- Final texto correo cliente --}}
        @endif
        <?php
            $total_archivos_contratacion = 0;
            $total_archivos_seleccion = 0;
            if ($archivos != null) {
                $total_archivos_contratacion = count($archivos_contratacion);
                $total_archivos_seleccion = count($archivos_seleccion);
            }
        ?>
        @if($total_archivos_contratacion > 0 || $archivo_documento_contratacion != null)
            <tr>
                <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-top:10px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a">
                    <h4>Documentos de Contratación:</h4>
                </td>
            </tr>

            @if( $archivo_documento_contratacion != null )
                @if(file_exists('contratos/'.$archivo_documento_contratacion->nombre))
                    <tr>
                        <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a">
                         
                           <a href='{{ asset("contratos/".$archivo_documento_contratacion->nombre) }}' target="_blank"> {{ $archivo_documento_contratacion->descripcion }} </a>

                        </td>
                    </tr>
                @endif
            @endif

            {{--@foreach ($archivos_generados as $file)
                <tr>
                    <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-top:10px;padding-right:30px;padding-left:30px;text-align:left;color:#353e4a">
                        @if ($file->descripcion == 'ORDEN DE CONTRATACIÓN')
                            <a href="{{ route('admin.paquete_contratacion_pdf', ['id' => $cand_req]) }}" target="_blank">
                                ORDEN DE CONTRATACIÓN
                            </a>
                        @endif

                        @if ($file->descripcion == 'Contrato Firmado')
                          <a href='{{ asset("contratos/".$contrato->contrato) }}' target="_blank">
                            CONTRATO
                          </a>
                        @endif
                    </td>
                </tr>
            @endforeach--}}

            @foreach($archivos_contratacion as $archivo)
            <!-- dividir en dos listas seleccion y contratacion -->
                @foreach($archivo->documentos as $documento)
                    @if(file_exists('recursos_documentos_verificados/'.$documento->nombre))
                    <tr>
                        <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a">
                         
                           <a href='{{ asset("recursos_documentos_verificados/".$documento->nombre) }}' target="_blank"> {{ $archivo->descripcion }} </a>

                        </td>
                    </tr>
                    @elseif(file_exists('contratos/'.$documento->nombre))
                    <tr>
                        <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a">
                         
                           <a href='{{ asset("contratos/".$documento->nombre) }}' target="_blank"> {{ $archivo->descripcion }} </a>

                        </td>
                    </tr>
                    @endif
                @endforeach
            @endforeach
        @endif

        @if($total_archivos_seleccion > 0)
            <tr>
              <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-top:10px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a">
                 <h4>Documentos de Selección:</h4>
              </td>
            </tr>

            @foreach($archivos_seleccion as $archivo)
            <!-- dividir en dos listas seleccion y contratacion -->
                @if ($archivo->descripcion != 'Contrato firmado virtualmente, sin vídeos.' && $archivo->descripcion != 'Contrato firmado virtualmente')
                    @if(file_exists('recursos_documentos/'.$archivo->nombre))
                    <tr>
                        <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a">
                           
                           <a href='{{ asset("recursos_documentos/".$archivo->nombre) }}' target="_blank"> {{ $archivo->descripcion }} </a>
                        </td>
                    </tr>
                    @endif
                @endif
            @endforeach
        @endif
        @if($observacion != '')
            <tr>
                <td class="m_-7484884227191431181m_-8044308263189181155title1" style="font-size:18px;padding-top:30px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;">
                    <b>Observación: </b>
                </td>
            </tr>
            <tr>
                <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a">
                    <p>
                        {!! $observacion !!}
                    </p>
                </td>
            </tr>
        @endif
        <tr>
            <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-top:10px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a; font-style: italic;">
                <p>Cordialmente</p>
                <p>{{ $quien_confirma->name }}</p>

                @if(isset($sitio->nombre))
                    @if($sitio->nombre != "")
                        {!! (($sitio->nombre)) !!}
                    @else
                        T3RS SAS
                    @endif
                @else
                    T3RS SAS
                @endif
            </td>
        </tr>
    </tbody>
</table>
</td>
</tr>
<tr>
<td align="center" style="padding-top:10px;padding-right:30px;padding-bottom:10px;padding-left:30px">
<table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:auto">
    <tbody>
        <tr>
            <td style="background-color:#ee1e50;font-family:Arial,sans-serif;border-radius:5px;color:#ffffff;text-decoration:none;text-align:center">
            </td>
        </tr>
    </tbody>
</table>
</td>
</tr>
@if($tipo_correo !== 'candidato')
<tr>
<td>
<table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="color:#353e4a;font-family:Arial,sans-serif;font-size:15px;margin:auto" width="100%">
    <tbody>
        <tr>
            <td class="m_-7484884227191431181m_-8044308263189181155fs12" style="font-size:12px;line-height:18px;padding-top:10px;padding-right:30px;padding-bottom:20px;padding-left:30px;text-align:center;color:#808080">
                Gestión de requerimientos
            </td>
        </tr>
    </tbody>
</table>
</td>
</tr>
<tr>
<td style="background-color:#ececec">
<table align="center" border="0" cellpadding="0" cellspacing="0" style="color:#353e4a;font-family:Arial,sans-serif;font-size:14px;margin:auto;padding-bottom:10px" width="100%">
    <tbody>
        <tr>
            <td style="height:15px">
            </td>
        </tr>
    </tbody>
</table>
</td>
</tr>
<tr>
<td>
<a href="#m_-7484884227191431181_m_-8044308263189181155_" style="text-decoration:none">
    <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="color:#353e4a;font-family:Arial,sans-serif;font-size:15px;margin:auto" width="100%">
<tbody>
<tr>
@endif
</tr>
</tbody>
</table>
</a>
</td>
</tr>

</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table align="center" bgcolor="#ececec" style="width:100%!important;table-layout:fixed">
<tbody>
<tr>
<td>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="m_-7484884227191431181m_-8044308263189181155deviceWidth" style="max-width:600px;margin:auto;background:#ffffff">
<tbody>
<tr>
<td style="background-color:#ececec">
<table align="center" border="0" cellpadding="0" cellspacing="0" style="color:#353e4a;font-family:Arial,sans-serif;font-size:14px;margin:auto;padding-bottom:10px" width="100%">
<tbody>
<tr>
<td style="height:15px">
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td>
<table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="color:#353e4a;font-family:Arial,sans-serif;font-size:15px;margin:auto" width="100%">
    <tbody>
        <tr>
            <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:15px;padding-top:10px;padding-right:20px;padding-bottom:5px;padding-left:20px;text-align:center;color:#353e4a">
            </td>
        </tr>
    </tbody>
</table>
</td>
</tr>
<tr>
<td style="background-color:#ececec">
<table align="center" border="0" cellpadding="0" cellspacing="0" style="color:#353e4a;font-family:Arial,sans-serif;font-size:14px;margin:auto;padding-bottom:10px" width="100%">
    <tbody>
        <tr>
            <td style="height:15px">
            </td>
        </tr>
    </tbody>
</table>
</td>
</tr>
<tr>
<td style="background-color:#ececec">
{{--<table align="center" border="0" cellpadding="0" cellspacing="0" style="color:#353e4a;font-family:Arial,sans-serif;font-size:14px;margin:auto;padding-bottom:10px" width="100%">
    <tbody>
        <tr>
            <td class="m_-7484884227191431181m_-8044308263189181155fs10" style="color:#717175;font-size:12px;line-height:17px;padding-top:0px;padding-bottom:10px;text-align:center">
                Este e-mail lo hemos generado automáticamente. Por favor no lo respondas. Si tienes alguna pregunta o necesitas ayuda, haz clic en
                <a data-saferedirecturl="" href="" style="color:#353e4a" target="_blank">
                    Ayuda
                </a>
                .
            </td>
        </tr>
    </tbody>
</table>--}}
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<img class="m_-7484884227191431181m_-8044308263189181155hide-md CToWUd" height="1" src="" style="display:block;min-width:600px;height:1px">
</img>
</div>