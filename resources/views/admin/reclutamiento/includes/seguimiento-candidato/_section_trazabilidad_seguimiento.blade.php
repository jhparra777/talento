<div class="panel panel-default" style="border-radius: 0 1rem 1rem 1rem;">
    <div class="panel-body">
        <div class="col-sm-12 col-md-5 mb-2">
            <h4 class="tri-fs-14">TRAZABILIDAD DEL CANDIDATO</h4>
        </div>

        <div class="col-md-12">
            <div class="table-responsive">
                {{-- tusdatos.co --}}
                @if($sitioModulo->consulta_tusdatos == 'enabled')
                    <?php
                        $tusdatosData = FuncionesGlobales::getTusDatos($req_id, $candidato_id);
                    ?>
                @endif

                {{-- tusdatos.co Estudio Virtual de Seguridad --}}
                @if($sitioModulo->consulta_tusdatos_evs == 'enabled')
                    <?php
                        $tusdatosDataEvs = FuncionesGlobales::getTusDatosEvs($req_id, $candidato_id);
                    ?>
                @endif

                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th>Usuario que Solicitó</th>
                            <th>Fecha de Solicitud</th>
                            <th>Proceso</th>

                            @if($user_sesion->hasAccess("entrevista_virtual"))
                                <th>Estado/Puntos</th>
                            @else
                                <th>Estado</th>
                            @endif

                            @if($sitioModulo->consulta_seguridad === 'enabled' || $sitioModulo->consulta_tusdatos == 'enabled' || $sitioModulo->consulta_tusdatos_evs == 'enabled')

                                @if(isset($factor->factor_seguridad) || isset($tusdatosData) || isset($tusdatosDataEvs))
                                    <th>Factor de Seguridad</th>
                                @endif

                            @endif

                            {{-- <th>¿Asistió a la entrevista?</th> --}}
                            <th>Motivo Rechazo</th>
                            <th>Observaciones</th>
                            <th>Usuario que Finalizo Procedimiento</th>
                            <th>Fecha de Finalización Procedimiento</th>

                            {{-- <th>Porcentaje asignado</th> --}}
                            <!--<td>Nota en el Procedimiento</td>-->
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($reqCandidato as $ref)
                            <tr>
                                <td>{{ $ref->usuarioRegistro()->name }}</td>

                                <td>{{ $ref->fecha_inicio }}</td>

                                <td>
                                    @if($ref->proceso == "ENVIO_VALIDACION")
                                        <p>ENVIO VINCULACIÓN</p>
                                    @else
                                        @if(route("home") == "https://komatsu.t3rsc.co")
                                            @if($ref->proceso == 'ENVIO_DOCUMENTOS')
                                                ENV_EST_SEG
                                            @else
                                                {{ ($ref->proceso == 'ENVIO_APROBAR_CLIENTE' || $ref->proceso == 'ENVIO_CONTRATACION_CLIENTE' ) ? 'ENVIO_COORDINADORA_SELECCION' : $ref->proceso }}
                                            @endif
                                        @else
                                            {{ $ref->proceso }}
                                        @endif
                                    @endif
                                </td>

                                @if($ref->proceso === 'ENVIO_ENTREVISTA_VIRTUAL' || $ref->proceso === 'ENVIO_PRUEBA_IDIOMA')
                                    <td>
                                        <?php
                                            switch ($ref->apto) {
                                                case 1:
                                                    echo "<p style='padding:10px' class=' bg-success'>Apto | ({$ref->puntuacion}/5)</p>";
                                                break;
                                                
                                                case 0:
                                                case 2:
                                                    echo "<p style='padding:10px' class=' bg-danger'>No Apto | ({$ref->puntuacion}/5)</p>";
                                                break;
                                                
                                                case 3:
                                                    echo "<p style='padding:10px' class=' bg-warning'>Pendiente | ({$ref->puntuacion}/5)</p>";
                                                break;
                                                
                                                default :
                                                    echo "<p style='padding:10px' class=''>Enviado</p>";
                                                break;
                                            }
                                        ?>
                                    </td>
                                @else
                                    <td>
                                        <?php
                                            switch ($ref->apto) {
                                                case '1':
                                                    echo "<p style='padding:10px' class=' bg-success'>Apto</p>";
                                                break;
                                                
                                                case '0':
                                                case '2':
                                                    echo "<p style='padding:10px' class=' bg-danger'>No Apto</p>";
                                                break;
                                                
                                                case '3':
                                                    echo "<p style='padding:10px' class=' bg-warning'>Pendiente</p>";
                                                break;
                                    
                                                default :
                                                    echo "<p style='padding:10px' class=''>Enviado</p>";
                                                break;
                                            }
                                        ?>
                                    </td>
                                @endif

                                @if($sitioModulo->consulta_seguridad === 'enabled' || $sitioModulo->consulta_tusdatos == 'enabled' || $sitioModulo->consulta_tusdatos_evs == 'enabled')

                                    @if(isset($factor->factor_seguridad) || isset($tusdatosData) || isset($tusdatosDataEvs))
                                        <td>-</td>
                                    @endif
                                @endif

                                @if (route("home") == "https://vym.t3rsc.co" || route("home") == "https://listos.t3rsc.co")
                                    <td>-</td>
                                @endif

                                @if ($ref->proceso == 'CONTRATO_ANULADO')
                                    <td>{{$ref->motivo_anulacion}}</td>
                                @else
                                    @if ($ref->des_motivo_rechazo != '')
                                        <td>{{ $ref->des_motivo_rechazo }}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                @endif

                                @if ($ref->proceso == 'ENVIO_APROBAR_CLIENTE')
                                    @if ($ref->observaciones)
                                        <td>
                                            {{ $ref->observaciones }}

                                            @if($documento_aprobacion != null)
                                                <br>
                                                <a href="{{ url('recursos_documentos_verificados/'.$documento_aprobacion->nombre_archivo) }}" target="_blank" title="Ver documento aprobación cargado"><span class="fa fa-file" aria-hidden="true"></span> Ver archivo</a>
                                            @endif
                                        </td>
                                    @else
                                        <td>
                                            @if($documento_aprobacion != null)
                                                <a href="{{ url('recursos_documentos_verificados/'.$documento_aprobacion->nombre_archivo) }}" target="_blank" title="Ver documento aprobación cargado"><span class="fa fa-file" aria-hidden="true"></span> Ver archivo</a>
                                            @endif
                                        </td>
                                    @endif

                                @elseif($ref->proceso == "ENVIO_CITA_POR_CLIENTE" && $cita)
                                    <td style="width: 25%;word-break: break-all;">
                                        Fecha cita: {{ $cita->fecha_cita }} <br>
                                        Observaciones: {{ $cita->observaciones }} 
                                    </td>

                                @elseif($ref->proceso == "ENVIO_EXCEL_BASICO")
                                    <?php
                                        $resp_user_excel = $ref->respuestaPruebaExcelUser('basico');
                                    ?>

                                    @if ($resp_user_excel != null && $resp_user_excel->respuestas_correctas != null)
                                        <?php
                                            $config_prueba_excel = $resp_user_excel->configuracionReq;
                                        ?>

                                        <td style="width: 25%;word-break: break-all;">
                                            <b>Calificación obtenida</b>: {{ $resp_user_excel->calcularCalificacion() }}% <br>
                                            <b>Calificación minima</b>: {{ $config_prueba_excel->aprobacion_excel_basico }}% <br>
                                            <a href="{{ route('admin.pdf_prueba_excel', ['id_respuesta_user' => $resp_user_excel->id]) }}" target="_blank"><i class="fa fa-file"></i> Ver Respuestas</a>

                                            @if ($resp_user_excel->concepto_final != null && $resp_user_excel->concepto_final != '')
                                                <br> <b>Concepto final</b>: {!! $resp_user_excel->concepto_final !!}
                                            @endif
                                        </td>
                                    @else
                                        <td>-</td>
                                    @endif

                                @elseif($ref->proceso == "ENVIO_EXCEL_INTERMEDIO")
                                    <?php
                                        $resp_user_excel = $ref->respuestaPruebaExcelUser('intermedio');
                                    ?>

                                    @if ($resp_user_excel != null && $resp_user_excel->respuestas_correctas != null)
                                        <?php
                                            $config_prueba_excel = $resp_user_excel->configuracionReq;
                                        ?>

                                        <td style="width: 25%;word-break: break-all;">
                                            <b>Calificación obtenida</b>: {{ $resp_user_excel->calcularCalificacion() }}% <br>
                                            <b>Calificación minima</b>: {{ $config_prueba_excel->aprobacion_excel_intermedio }}% <br>
                                            <a href="{{ route('admin.pdf_prueba_excel', ['id_respuesta_user' => $resp_user_excel->id]) }}" target="_blank"><i class="fa fa-file"></i> Ver Respuestas</a>

                                            @if ($resp_user_excel->concepto_final != null && $resp_user_excel->concepto_final != '')
                                                <br> <b>Concepto final</b>: {!! $resp_user_excel->concepto_final !!}
                                            @endif
                                        </td>
                                    @else
                                        <td>-</td>
                                    @endif

                                @elseif($ref->proceso == "ENVIO_PRUEBA_ETHICAL_VALUES")
                                    <?php
                                        $resp_user_ev = $ref->respuestaPruebaEthicalValue();
                                    ?>

                                    @if ($resp_user_ev != null)
                                        <td style="width: 25%;word-break: break-all;">
                                            <a href="{{ route('admin.pdf_prueba_valores', ['id_respuesta_user' => $resp_user_ev->id]) }}" target="_blank"><i class="fa fa-file"></i> Ver Respuestas</a>
                                            @if ($resp_user_ev->concepto_final != null && $resp_user_ev->concepto_final != '')
                                                <br> <b>Concepto final</b>: {!! $resp_user_ev->concepto_final !!}
                                            @endif
                                        </td>
                                    @else
                                        <td>-</td>
                                    @endif

                                @elseif($ref->proceso == "ENVIO_SST")
                                    @if($sitioModulo->evaluacion_sst === 'enabled')
                                        <?php
                                            $extension = null;
                                            $configuracion_sst = $sitioModulo->configuracionEvaluacionSst();
                                            $extensiones = ['.pdf','.docx','.doc','.png','.jpg','.jpeg'];

                                            foreach ($extensiones as $ext) {
                                                if(file_exists('recursos_evaluacion_sst/evaluacion_sst_'.$candidato_id.'_'.$req_id.$ext)) {
                                                    $extension = $ext;
                                                    break;
                                                }
                                            }

                                            if ($extension == null) {
                                                foreach ($extensiones as $ext) {
                                                    if (file_exists('contratos/evaluacion_sst_'.$candidato_id.$ext)) {
                                                        $extension = $ext;
                                                        break;
                                                    }
                                                }
                                            }
                                        ?>

                                        @if(file_exists('recursos_evaluacion_sst/evaluacion_sst_'.$candidato_id.'_'.$req_id.$extension))
                                            <td>
                                                <a href="{{ asset('recursos_evaluacion_sst/evaluacion_sst_'.$candidato_id.'_'.$req_id.$extension)}}" target="_blank" title="Ver Evaluacion SST"><span class="fa fa-file" aria-hidden="true"></span> Ver archivo</a>
                                            </td>
                                        @elseif(file_exists('contratos/evaluacion_sst_'.$candidato_id.$extension))
                                            <td>
                                                <a href="{{ asset('contratos/evaluacion_sst_'.$candidato_id.$extension)}}" target="_blank" title="Ver Evaluacion SST"><span class="fa fa-file" aria-hidden="true"></span> Ver archivo</a>
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    @endif

                                @elseif($ref->proceso == "CONSENTIMIENTO_PERMISO")
                                    <td>
                                        @if(file_exists("recursos_consentimiento_permiso_adicional/consentimiento_permiso_".$candidato_id."_".$req_id.".pdf"))
                                            <a
                                                href='{{route("view_document_url", encrypt("recursos_consentimiento_permiso_adicional/"."|"."consentimiento_permiso_".$candidato_id."_".$req_id.".pdf"))}}'
                                                title="Ver archivo"
                                                target="_blank"
                                            >
                                                <span class="fa fa-file" aria-hidden="true"></span> Ver archivo
                                            </a>
                                        @endif
                                    </td>

                                @else
                                    @if ($ref->observaciones)
                                        <td>
                                            {!! $ref->observaciones !!}
                                        </td>
                                    @else
                                        <td>-</td>
                                    @endif
                                @endif


                                <td>{{ $ref->usuarioTerminacion()->name }}</td>

                                <td>
                                    @if($ref->usuario_terminacion !== null)
                                        {{ $ref->updated_at }}
                                    @endif
                                </td>

                                {{-- <td style="text-align: center;">86%</td> --}}
                                <!--<td></td>-->
                            </tr>
                        @endforeach

                        {{-- Prueba BRYG --}}
                        @if(!empty(App\Http\Controllers\PruebaPerfilBrygController::brygCandidato($candidato_id, $req_id)))
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <b>RESULTADO BRYG-A</b>
                                </td>
                                <td>-</td>
                                <td>
                                    <a 
                                        href="{{ route('admin.prueba_bryg_informe', [App\Http\Controllers\PruebaPerfilBrygController::brygCandidato($candidato_id, $req_id)->id]) }}" 
                                        target="_blank"
                                    ><i class="fa fa-file"></i> Ver informe BRYG</a>
                                </td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        @endif

                        {{-- Consulta seguridad t3 --}}
                        @if($sitioModulo->consulta_seguridad === 'enabled' && $consulta_seguridad_proceso)
                            @if(isset($factor->factor_seguridad))
                                <tr>
                                    <td> {{ $factor->usuarioRegistro()->name }} </td>
                                    <td> {{ date("Y-m-d",strtotime($factor->created_at)) }} </td>
                                    <td> CONSULTA_SEGURIDAD </td>
                                    <td> <p style='padding:10px'>Enviado</p> </td>

                                    @if($factor->factor_seguridad <= 30)
                                        <td class="text-center bg-danger">{{ $factor->factor_seguridad }} %</td>
                                    @elseif($factor->factor_seguridad > 30 || $factor->factor_seguridad <= 100)
                                        <td class="text-center bg-success">{{ $factor->factor_seguridad }} %</td>
                                    @endif
                                    <td>-</td>
                                    <td class="text-center">
                                        Consulta de seguridad y factor de seguridad

                                        @if($factor->pdf_consulta_file != null)
                                            <br>
                                            <a target="_blank" href="{{ route('view_document_url', encrypt("recursos_pdf_consulta/$factor->pdf_consulta_file")) }}" title="Ver PDF generado">
                                                <span class="fa fa-file" aria-hidden="true"></span> Ver PDF generado
                                            </a>
                                        @endif
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @else
                            @endif
                        @endif

                        {{-- Consulta seguridad t3 --}}
                        @if($sitioModulo->listas_vinculantes === 'enabled' && $listas_vinculantes_proceso)
                            @if(isset($factor_listas_vinculantes->factor_seguridad))
                                <tr>
                                    <td> {{ $factor_listas_vinculantes->usuarioRegistro()->name }} </td>
                                    <td> {{ date("Y-m-d",strtotime($factor_listas_vinculantes->created_at)) }} </td>
                                    <td> Listas Vinculantes </td>
                                    <td> <p style='padding:10px'>Enviado</p> </td>

                                    @if($factor_listas_vinculantes->factor_seguridad <= 30)
                                        <td class="text-center bg-danger">{{ $factor_listas_vinculantes->factor_seguridad }} %</td>
                                    @elseif($factor_listas_vinculantes->factor_seguridad > 30 || $factor_listas_vinculantes->factor_seguridad <= 100)
                                        <td class="text-center bg-success">{{ $factor_listas_vinculantes->factor_seguridad }} %</td>
                                    @endif
                                    <td>-</td>
                                    <td class="text-center">
                                        Listas Vinculantes y factor

                                        @if($factor_listas_vinculantes->pdf_consulta_file != null)
                                            <br><a target="_blank" href='{{ route('view_document_url', encrypt("recursos_listas_vinculantes/$factor_listas_vinculantes->pdf_consulta_file")) }}' title="Ver PDF generado">
                                                <span class="fa fa-file" aria-hidden="true"></span> Ver PDF generado
                                            </a>    
                                        @endif
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @else
                            @endif
                        @endif

                        {{-- Tusdatos.co --}}
                        @if($sitioModulo->consulta_tusdatos == 'enabled')
                            @if (!empty($tusdatosData))
                                <tr class="text-center">
                                    <td>-</td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        Consulta de Seguridad
                                    </td>
                                    <td>
                                        <b>
                                            {{ ucfirst($tusdatosData->status) }}
                                        </b>
                                    </td>
                                    <td>
                                        {{ (isset($tusdatosData->error)) ? $tusdatosData->error : '-' }}
                                    </td>
                                    <td>{{ $tusdatosData->factor }}</td>
                                    <td>
                                        PDF Generado <br>

                                        @if ($tusdatosData->status == 'procesando')
                                            <a href="#" title="Esperando PDF">
                                                <span class="fa fa-file" aria-hidden="true"></span> PDF En Progreso
                                            </a>
                                        @elseif($tusdatosData->status == 'finalizado')
                                            <a 
                                                target="_blank" 
                                                href="{{ route('tusdatos_reporte', ['check' => $tusdatosData->id]) }}" 
                                                title="Ver PDF"
                                            >
                                                <span class="fa fa-file" aria-hidden="true"></span> Ver PDF
                                            </a>
                                        @else
                                            <a href="#" title="Esperando PDF">
                                                <span class="fa fa-file" aria-hidden="true"></span> PDF En Progreso
                                            </a>
                                        @endif
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endif
                        @endif

                        {{-- Tusdatos.co Estudio Virtual de Seguridad--}}
                        @if($sitioModulo->consulta_tusdatos_evs == 'enabled')
                            @if (!empty($tusdatosDataEvs))
                                <tr class="text-center">
                                    <td>-</td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        Consulta de Antecedentes
                                    </td>
                                    <td>
                                        <b>
                                            {{ ucfirst($tusdatosDataEvs->status) }}
                                        </b>
                                    </td>
                                    <td>
                                        {{ (isset($tusdatosDataEvs->error)) ? $tusdatosDataEvs->error : '-' }}
                                    </td>
                                    <td>{{ $tusdatosDataEvs->factor }}</td>
                                    <td>
                                        @if ($tusdatosDataEvs->status == 'procesando')
                                            <a href="#" title="Esperando PDF">
                                                <span class="fa fa-file" aria-hidden="true"></span> PDF En Progreso
                                            </a>
                                        @elseif($tusdatosDataEvs->status == 'finalizado')
                                            PDF Generado <br>
                                            <a 
                                                target="_blank" 
                                                href="{{ route('tusdatos_reporte_evs', ['check' => $tusdatosDataEvs->id]) }}" 
                                                title="Ver PDF"
                                            >
                                                <span class="fa fa-file" aria-hidden="true"></span> Ver PDF
                                            </a>
                                        @else
                                            <a href="#" title="Esperando PDF">
                                                <span class="fa fa-file" aria-hidden="true"></span> PDF En Progreso
                                            </a>
                                        @endif
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endif
                        @endif

                        @if ($sitioModulo->omnisalud == 'enabled')
                            @php
                                $omnisalud = new App\Http\Controllers\Integrations\OmnisaludIntegrationController();
                                $omnisaludEstado = $omnisalud->consultOmnisaludExams($req_id, $candidato_id);
                            @endphp

                            <tr class="text-center">
                                <td>-</td>
                                <td>
                                    {{ $omnisaludEstado['fecha_solicitud'] }}
                                </td>
                                <td>
                                    Solicitud omnisalud
                                </td>
                                <td>
                                    <b>
                                        {{ $omnisaludEstado['estado_solicitud'] }}
                                    </b>
                                </td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>