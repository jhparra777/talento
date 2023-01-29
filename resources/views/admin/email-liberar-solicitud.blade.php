<div marginheight="0" marginwidth="0" style="background-color:#ececec">
    <table align="center" bgcolor="#ececec" style="width:100%!important;table-layout:fixed">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="m_-7484884227191431181m_-8044308263189181155deviceWidth" style="max-width:600px;margin:auto;background:#ffffff">
                        <tbody>
                            <tr>
                                <td style="width:100%;background-color:#353e4a">
                                    <table align="center" bgcolor="#353e4a" border="0" cellpadding="0" cellspacing="0" style="background-color:#353e4a" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="center" style="padding-top:8px;padding-bottom:8px;text-align:center;background-color:#353e4a" width="100%">
                                                    <a class="m_-7484884227191431181m_-8044308263189181155fs18" data-saferedirecturl="" href="" style="color:#ffffff;text-decoration:none;font-family:'Arial';font-size:23px" target="_blank" title="Komatsu">
                                                        <b>
                                                            <i style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
                                                                <font color="white">
                                                                    Komatsu
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
                                    <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="color:#353e4a;font-family:Arial,sans-serif;font-size:15px;margin:auto" width="100%">
                                        <tbody>
                                            <tr>
                                                <td class="m_-7484884227191431181m_-8044308263189181155title1" style="font-size:18px;padding-top:30px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;">
                                                    <b>
                                                        Buen día !
                                                    </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-top:10px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a">
                                                    <b>
                                                        Te informamos que tu solicitud ha sido liberada.
                                                       
                                                    </b>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3>
                                                                <strong>
                                                                    Detalle solicitud
                                                                </strong>
                                                            </h3>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Sede trabajo
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $solicitud->sede->descripcion }}
                                                            </div>
                                                        </div>
                                                        @if(isset($solicitud->centrocosto))
                                                            <div class="col-md-6">
                                                                <div class="col-md-6">
                                                                    <strong>
                                                                        Centro costos
                                                                    </strong>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    {{ $solicitud->centrocosto->descripcion }}
                                                                </div>
                                                            </div>
                                                         @endif
                                                        @if(isset($solicitud->centrobeneficio))
                                                        <div class="col-md-6">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Centro beneficios
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $solicitud->centrobeneficio->descripcion }}
                                                            </div>
                                                        </div>
                                                     @endif
                                                        <!-- -->
                                                        <div class="col-md-6">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Area de trabajo
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{$solicitud->area->descripcion}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Subarea
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                               {{$solicitud->subarea->descripcion}}
                                                            </div>
                                                        </div>
                                                        <!-- -->
                                                        <div class="col-md-6">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Nombre solicitante
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $solicitud->user()->name }}
                                                            </div>
                                                        </div>
                                                        <!-- -->
                                                        <div class="col-md-6">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Cargo solicitado
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $solicitud->cargoGenerico()->descripcion }}
                                                            </div>
                                                        </div>
                                                        <!-- -->
                                                        
                                                        {{--<div class="col-md-6">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Jornada laboral
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $solicitud->jornada()->descripcion }}
                                                            </div>
                                                        </div>--}}
                                                        <!-- -->
                                                        <div class="col-md-6">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Tipo contrato
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $solicitud->tipoContrato()->descripcion }}
                                                            </div>
                       @if(!empty($solicitud->tiempo_contrato))
                        <div class="col-md-6">
                        {{ $solicitud->tiempo_contrato}}
                        </div>
                      @endif
                                                        </div>
                                                       <div class="col-md-6">
                      <div class="col-md-6">
                        <strong>Motivo requerimiento</strong>
                      </div>
                        <div class="col-md-6">
                        @if($solicitud->motivo_requerimiento_id!=20)
                            
                           @if(!empty($solicitud->motivoRequerimiento()))
                             {{$solicitud->motivoRequerimiento()->descripcion}}
                           @endif

                        @else

                         <strong>{{$solicitud->motivoRequerimiento()->descripcion}}</strong>:{{$solicitud->desc_motivo}}

                        @endif
                        </div>
                    </div>
                                                        <!-- -->
                                                        <div class="col-md-6">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Número vacantes
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ $solicitud->numero_vacante }}
                                                            </div>
                                                        </div>
                                                        @if ($solicitud->documento != "" || $solicitud->documento != null)
                                                            <div class="col-md-6">
                                                            <div class="col-md-6">
                                                                <strong>
                                                                    Documento adjunto
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <a href="{{ route('home') }}/documentos_solicitud/{{ $solicitud->documento }}" target="_black">
                                                                    Ver documentos
                                                                </a>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        
                                                        <!-- -->
                                                        <div class="col-md-12">
                                                            <div class="col-md-12">
                                                                <strong>
                                                                    Justificación
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-12">
                                                                {{ $solicitud->funciones_realizar }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="col-md-12">
                                                                <strong>
                                                                    Observaciones
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-12">
                                                                {{ $solicitud->observaciones }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="col-md-12">
                                                                <strong>
                                                                    Recursos necesarios
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-12">
                                                                {{ $solicitud->recursos }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="col-md-12">
                                                                <strong>
                                                                    salario
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-12">
                                                                {{ $solicitud->salario }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:20px;padding-top:10px;padding-right:30px;padding-bottom:10px;padding-left:30px;text-align:left;color:#353e4a">
                                                    Haz click en el siguiente botón para ir a tus solicitudes.
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
                                                    <a data-saferedirecturl="" href="{{ route('admin.solicitud',$solicitud->id) }}"  style="color:#ffffff;text-decoration:none;width:250px;display:table-cell;height:50px;vertical-align:middle;font-size:18px" target="_blank">
                                                        <strong>
                                                            Ir a solicitudes
                                                        </strong>
                                                    </a>
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
                                                <td class="m_-7484884227191431181m_-8044308263189181155fs12" style="font-size:12px;line-height:18px;padding-top:10px;padding-right:30px;padding-bottom:20px;padding-left:30px;text-align:center;color:#808080">
                                                    Gestión de solicitudes.
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
<td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;padding-top:20px;padding-right:20px;padding-bottom:5px;padding-left:20px;text-align:left;color:#353e4a">
Si tienes dudas por favor <a data-saferedirecturl="" href="" style="color:#1e82c4;text-decoration:none" target="_blank">
    contáctanos
</a>
                                                    , estamos atentos para ayudarte.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="m_-7484884227191431181m_-8044308263189181155fs13" style="font-size:14px;line-height:22px;padding-top:10px;padding-right:20px;padding-bottom:5px;padding-left:20px;text-align:left;color:#353e4a">
                                                    Te deseamos muchos éxitos en tus procesos de selección de personal.
                                                    <br>
                                                        <b>
                                                            <i>
                                                                El equipo de Komatsu
                                                            </i>
                                                        </b>
                                                    </br>
                                                </td>
                                            </tr>
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
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="color:#353e4a;font-family:Arial,sans-serif;font-size:14px;margin:auto;padding-bottom:10px" width="100%">
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
                                    </table>
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