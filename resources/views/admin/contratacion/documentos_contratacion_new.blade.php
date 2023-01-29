@extends("admin.layout.master")
@section('contenedor')
    <?php $cargo = $requerimiento->cargo_especifico()->descripcion ?>
    {{-- HEADER --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Documentos contratación | $datos_candidato->nombres $datos_candidato->primer_apellido $datos_candidato->segundo_apellido", 
                                                                  'more_info' => "<b>Requerimiento</b> $req | <b>Tipo Proceso</b> $requerimiento->tipo_proceso | <b>Cargo</b> $cargo"])

    <style type="text/css">
        .val-m {
            vertical-align: middle !important;
        }
    </style>

    <div class="row">
        <div class="col-12 col-sm-6 col-md-6" style="text-align: left;">
            <div class="btn-group">
                   <button 
                        type="button" 
                        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
                        Documentos de ingreso
                    </button>
                    <button 
                        type="button" 
                        class="btn btn-default dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
                        data-toggle="dropdown"
                        >
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                     </button>
                    <ul class="dropdown-menu">
                        @if ($firmaContrato->contrato !== null || $firmaContrato->contrato !== '')
							<a type="button" class="btn btn-default btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href="{{route('generar_carnet_general',['id'=>$firmaContrato->user_id])}}" target="_blank"> Carnet Candidato </a>
						@endif

                        @if($carta_presentacion != null)
				 			@if(file_exists("recursos_carta_presentacion/$carta_presentacion->nombre"))
					 			<a class="btn btn-default btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_carta_presentacion/"."|".$carta_presentacion->nombre))}}' target="_blank">
									Carta Presentación
								</a>
							@endif
				 		@endif

                        @if($sitioModulo->consentimiento_permisos === 'enabled')
                            <?php
                                $consentimiento_config = $sitioModulo->configuracionConsentimientoPermiso();
                            ?>
                            @if($consentimiento_config->visualiza_documento_contratacion == 'SI')
                                @if(file_exists("recursos_consentimiento_permiso_adicional/consentimiento_permiso_".$datos_candidato->user_id."_".$req.".pdf"))
                                    <a class="btn btn-default btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_consentimiento_permiso_adicional/"."|"."consentimiento_permiso_".$datos_candidato->user_id."_".$req.".pdf"))}}' target="_blank">
                                        {{$consentimiento_config->texto_boton_ver_documento}}
                                    </a>
                                @endif
                            @endif
                        @endif

                        @if($sitioModulo->evaluacion_sst === 'enabled')
							<?php
								$extension = null;
								$extensiones = ['.pdf','.docx','.doc','.png','.jpg','.jpeg'];
								foreach ($extensiones as $ext) {
									if(file_exists('recursos_evaluacion_sst/evaluacion_sst_'.$datos_candidato->user_id.'_'.$req.$ext)) {
										$extension = $ext;
										break;
									}
								}
								if ($extension == null) {
									foreach ($extensiones as $ext) {
										if (file_exists('contratos/evaluacion_sst_'.$datos_candidato->user_id.$ext)) {
											$extension = $ext;
											break;
										}
									}
								}
							?>
							@if(file_exists('recursos_evaluacion_sst/evaluacion_sst_'.$datos_candidato->user_id.'_'.$req.$extension))
								<a type="button" class="btn btn-default btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href="{{ route('view_document_url', encrypt('recursos_evaluacion_sst/'.'|evaluacion_sst_'.$datos_candidato->user_id.'_'.$req.$extension))}}" target="_blank">
											{{ $configuracion_sst->titulo_boton_ver_archivo }} </a>
									
							@elseif(file_exists('contratos/evaluacion_sst_'.$datos_candidato->user_id.$extension))
								<a type="button" class="btn btn-default btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href="{{route('view_document_url', encrypt('contratos/'.'|evaluacion_sst_'.$datos_candidato->user_id.$extension))}}" target="_blank">
											{{ $configuracion_sst->titulo_boton_ver_archivo }} </a>
							@endif
						@endif
                    </ul>
            </div>
        </div>
        @if ($firmaContrato != null)
		    @if ($firmaContrato->estado == 1 || $firmaContrato->estado === 1)
			    @if($firmaContrato->terminado != null && $firmaContrato->terminado == 1 || $firmaContrato->terminado == 3)
                    <div class="col-12 col-sm-6 col-md-6" style="text-align: right;">
                        @if(file_exists('contratos/contrato_sin_video_'.$firmaContrato->id.'.pdf'))
                            <a type="button" class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{route('view_document_url', encrypt('contratos/'.'|contrato_sin_video_'.$firmaContrato->id.'.pdf')) }}" target="_blank"> Aceptación condiciones </a>
                        @else
                            @if ($firmaContrato->terminado == 1)
                                @if(count($getVideoQuestion) >= 1)
                                    <button type="button" class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-toggle="modal" data-target="#videoModal"> Videos contrato </button>
                                @endif
                            @endif
                        @endif

                        @if($firmaContrato->contrato !== null && $firmaContrato->contrato !== '')
                            <a type="button" class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{route('view_document_url', encrypt('contratos/'.'|'.$firmaContrato->contrato))}}" target="_blank">
                                Contrato
                            </a>

                            @if ($clausulasContrato != null || $clausulasContrato != '')
                                <div class="btn-group">
                                    <button 
                                        type="button" 
                                        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
                                        Cláusulas
                                    </button>
                                    <button 
                                        type="button" class="btn btn-default dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-toggle="dropdown"
                                        >
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" style="left: -80px !important; padding: 0 !important;">
                                        @foreach ($clausulasContrato as $index => $clausula)
                                            <a class="btn btn-default btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href="{{route('view_document_url', encrypt('contratos/'.'|'.$clausula->documento_firmado))}}" target="_blank">Cláusula {{ ++$index }}</a>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif
                    </div>
                @endif
            @else
                @if($anuladoContrato != null || $anuladoContrato != '')
                    <div class="col-12 col-sm-6 col-md-6" style="text-align: right;">
                        @if ($anuladoContrato->documento !== null || $anuladoContrato->documento !== '')
                            <a type="button" class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{ route('view_document_url', encrypt('contratos_anulados/'.'|'.$anuladoContrato->documento)) }}" target="_blank">
                                Contrato anulado
                            </a>
                        @endif
                    </div>
                @endif
            @endif
        @endif
    </div>

    <div class="row">
        <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tabla table-responsive">
                        <table class="table table-bordered table-hover" id="data-table">
    	                    <thead>
    	                        <tr>
                                    <th>Documento</th>
                                    <th> Usuario Cargó </th>
                                    <th> Fecha Carga </th>
                                    <th>Status</th>
                                    <th>Acción</th>
    	                        </tr>
    	                    </thead>
                            <tbody style="text-transform: uppercase;">
                                @foreach($tipo_documento as $tipo)
                                    @if ($tipo->descripcion == 'CONTRATO')
                                        @if ($firmaContrato != null)
                                            @if($firmaContrato->estado == 1 || $firmaContrato->estado === 1)
                                                @if($firmaContrato->terminado != null && $firmaContrato->terminado == 1 || $firmaContrato->terminado == 3)

                                                    @if ($firmaContrato->contrato !== null || $firmaContrato->contrato !== '')
                                                        <tr>
                                                            <td class="val-m">{{ $tipo->descripcion }}</td>
                                                            <td>{{ $tipo->usuario_gestiono }}</td>
                    										<td>{{ ($tipo->gestiono != null ? date("d-m-Y",strtotime($tipo->fecha_carga)) : '') }}</td>
                                                            <td class="text-center">
                                                                <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    $contador=1;
                                                                ?>
                                                                <div class="btn-group">
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-info btn-sm btn-block dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                                        data-toggle="dropdown"
                                                                        aria-haspopup="true"
                                                                        aria-expanded="false"
                                                                        >
                                                                        <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">Documento {{$contador}}</span>
                                                                        {{-- <span class="caret"></span> --}}
                                                                    </button>
                                                                    <ul class="dropdown-menu pd-0">
                                                                        <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                                            <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("contratos/"."|".$firmaContrato->contrato))}}' target="_blank">
                                                                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                                                Ver
                                                                            </a>

                                                                            <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{ route("admin.descargar_recurso", ["contratos", $firmaContrato->contrato]) }}' target="_blank" title="Descargar archivo">
                                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                                                Descargar
                                                                            </a>
                                                                            
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    @elseif(count($tipo->documentos) > 0)
                                                        <?php
                                                            $contador=1;
                                                        ?>
                                                        @foreach($tipo->documentos as $doc)
                                                            <tr>
                                                                <td class="val-m">{{ $tipo->descripcion }}</td>
                                                                <td>{{ $doc->usuarioGestiono->name }}</td>
                                                                <td>{{ ($doc->gestiono != null ? date("d-m-Y",strtotime($doc->fecha_carga)) : '') }}</td>
                                                                <td class="text-center">
                                                                    <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <button
                                                                            type="button"
                                                                            class="btn btn-info btn-sm btn-block dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                                            data-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false"
                                                                            >
                                                                            <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">Documento {{$contador}}</span>
                                                                            {{-- Documento {{$contador}}
                                                                            <span class="caret"></span> --}}
                                                                        </button>
                                                                        <ul class="dropdown-menu pd-0">
                                                                            <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                                                <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$doc->nombre."|".$tipo->id))}}' target="_blank">
                                                                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                                                    Ver
                                                                                </a>

                                                                                <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{ route("admin.descargar_recurso", ["recursos_documentos_verificados", $doc->nombre]) }}' target="_blank" title="Descargar archivo">
                                                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                                                    Descargar
                                                                                </a>
                                                                                
                                                                            </div>
                                                                        </ul>
                                                                    </div>
                                                                    <?php
                                                                        $contador++;
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        @endforeach

													@else
                                                        <tr>
                                                            <td class="val-m">{{ $tipo->descripcion }}</td>
                                                            <td>{{ $tipo->usuario_gestiono }}</td>
                                                            <td>{{ ($tipo->gestiono != null ? date("d-m-Y",strtotime($tipo->fecha_carga)) : '') }}</td>
                                                            <td class="text-center">
    											                <i class="fa fa-times" aria-hidden="true" style="color:red;"></i>
                                                            </td>
                                                            <td></td>
                                                        </tr>
											        @endif

												@elseif($firmaContrato->terminado != null && $firmaContrato->terminado == 2)
                                                    <tr>
                                                        <td class="val-m">{{ $tipo->descripcion }}</td>
                                                        <td>{{ $tipo->usuario_gestiono }}</td>
                                                        <td>{{ ($tipo->gestiono != null ? date("d-m-Y",strtotime($tipo->fecha_carga)) : '') }}</td>
                                                        <td class="text-center">
    														<i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                                                        </td>

                                                        <td>
                                                            <?php
                                                                $contador=1;
                                                            ?>
    													    @if($contrato_manual != null)
                                                                <div class="btn-group">
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-info btn-sm btn-block dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                                        data-toggle="dropdown"
                                                                        aria-haspopup="true"
                                                                        aria-expanded="false"
                                                                        >
                                                                        <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">Documento {{$contador}}</span>
                                                                        {{-- Documento {{$contador}}
                                                                        <span class="caret"></span> --}}
                                                                    </button>
                                                                    <ul class="dropdown-menu pd-0">
                                                                        <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                                            <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$contrato_manual->nombre_archivo))}}' target="_blank">
                                                                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                                                Ver
                                                                            </a>

                                                                            <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{ route("admin.descargar_recurso", ["recursos_documentos_verificados", $contrato_manual->nombre_archivo]) }}' target="_blank" title="Descargar archivo">
                                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                                                Descargar
                                                                            </a>
                                                                                
                                                                        </div>
                                                                     </ul>
                                                                </div>
    														@endif
                                                        </td>
                                                    </tr>

												@else
                                                    <tr>
                                                        <td class="val-m">{{ $tipo->descripcion }}</td>
                                                        <td>{{ $tipo->usuario_gestiono }}</td>
                                                        <td>{{ ($tipo->gestiono != null ? date("d-m-Y",strtotime($tipo->fecha_carga)) : '') }}</td>
                                                        <td class="text-center">
    											            <i class="fa fa-times" aria-hidden="true" style="color:red;"></i>
                                                        </td>
                                                        <td></td>
                                                    </tr>
												@endif

											@else

												@if($anuladoContrato != null || $anuladoContrato != '')
													@if ($anuladoContrato->documento !== null || $anuladoContrato->documento !== '')
                                                        <tr>
                                                            <td class="val-m">{{ $tipo->descripcion }}</td>
                                                            <td>{{ $tipo->usuario_gestiono }}</td>
                                                            <td>{{ ($tipo->gestiono != null ? date("d-m-Y",strtotime($tipo->fecha_carga)) : '') }}</td>
                                                            <td class="text-center">
                                                                <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                                                            </td>

                                                            <td>
                                                                <?php
                                                                    $contador=1;
                                                                ?>

                                                                <div class="btn-group">
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-info btn-sm btn-block dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                                        data-toggle="dropdown"
                                                                        aria-haspopup="true"
                                                                        aria-expanded="false"
                                                                        >
                                                                        <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">Documento {{$contador}}</span>
                                                                        {{-- Documento {{$contador}}
                                                                        <span class="caret"></span> --}}
                                                                    </button>
                                                                    <ul class="dropdown-menu pd-0">
                                                                        <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                                            <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("contratos_anulados/"."|".$anuladoContrato->documento)) }}' target="_blank">
                                                                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                                                Ver
                                                                            </a>

                                                                            <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{ route("admin.descargar_recurso", ["contratos_anulados", $anuladoContrato->documento]) }}' target="_blank" title="Descargar archivo">
                                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                                                Descargar
                                                                            </a>
                                                                                
                                                                        </div>
                                                                     </ul>
                                                                </div>

                                                            </td>
                                                        </tr>
													@endif
												@endif

											@endif
										@else

											@if( count($tipo->documentos) > 0)
                                                <?php
                                                    $contador=1;
                                                ?>
                                                @foreach($tipo->documentos as $doc)
                                                    <tr>
                                                        <td class="val-m">{{ $tipo->descripcion }}</td>
                                                        <td>{{ $doc->usuarioGestiono->name }}</td>
                                                        <td>{{ ($doc->gestiono != null ? date("d-m-Y",strtotime($doc->fecha_carga)) : '') }}</td>
                                                        <td class="text-center">
                                                            <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                                                        </td>

                                                        <td>
                                                            <div class="btn-group">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-info btn-sm btn-block dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                                    data-toggle="dropdown"
                                                                    aria-haspopup="true"
                                                                    aria-expanded="false"
                                                                    >
                                                                    <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">Documento {{$contador}}</span>
                                                                    {{-- Documento {{$contador}}
                                                                    <span class="caret"></span> --}}
                                                                </button>
                                                                <ul class="dropdown-menu pd-0">
                                                                    <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                                        <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$doc->nombre."|".$tipo->id))}}' target="_blank">
                                                                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                                            Ver
                                                                        </a>

                                                                        <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{ route("admin.descargar_recurso", ["recursos_documentos_verificados", $doc->nombre]) }}' target="_blank" title="Descargar archivo">
                                                                            <i class="fa fa-download" aria-hidden="true"></i>
                                                                            Descargar
                                                                        </a>    
                                                                    </div>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        $contador++;
                                                    ?>
                                                @endforeach
									        @else
                                                <tr>
                                                    <td class="val-m">{{ $tipo->descripcion }}</td>
                                                    <td>{{ $tipo->usuario_gestiono }}</td>
                                                    <td>{{ ($tipo->gestiono != null ? date("d-m-Y",strtotime($tipo->fecha_carga)) : '') }}</td>
                                                    <td class="text-center">
    									            	<i class="fa fa-times" aria-hidden="true" style="color:red;"></i>
                                                    </td>
                                                    <td></td>
                                                </tr>
									        @endif

										@endif
									@elseif($tipo->descripcion == 'ORDEN DE CONTRATACIÓN')
                                        <tr>
                                            <td class="val-m">{{ $tipo->descripcion }}</td>
                                            <td>{{ $tipo->usuario_gestiono }}</td>
                                            <td>{{ ($tipo->gestiono != null ? date("d-m-Y",strtotime($tipo->fecha_carga)) : '') }}</td>
                                            <td class="text-center">
                                                <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                                            </td>
                                            <td>
                                                <a  class="btn btn-info btn-sm btn-block | tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{ route('admin.paquete_contratacion_pdf', ['id' => $req_cand->id]) }}" target="_blank">
                                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                    Ver
                                                </a>
                                            </td>
                                        </tr>
								    @else
								        @if(count($tipo->documentos) > 0)
                                            <?php
                                                $contador=1;
                                            ?>
                                            @foreach($tipo->documentos as $doc)
                                                <tr>
                                                    <td class="val-m">{{ $tipo->descripcion }}</td>
                                                    <td>{{ $doc->usuarioGestiono->name }}</td>
                                                    <td>{{ ($doc->gestiono != null ? date("d-m-Y",strtotime($doc->fecha_carga)) : '') }}</td>
                                                    <td class="text-center">
                                                        <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                                                    </td>

                                                    <td>
                                                        <div class="btn-group">
                                                            <button
                                                                type="button"
                                                                class="btn btn-info btn-sm btn-block dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                                data-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false"
                                                                >
                                                                <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">Documento {{$contador}}</span>
                                                                {{-- Documento {{$contador}}
                                                                <span class="caret"></span> --}}
                                                            </button>
                                                            <ul class="dropdown-menu pd-0">
                                                                <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                                    <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$doc->nombre."|".$tipo->id))}}' target="_blank">
                                                                        <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                                        Ver
                                                                    </a>

                                                                    <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{ route("admin.descargar_recurso", ["recursos_documentos_verificados", $doc->nombre]) }}' target="_blank" title="Descargar archivo">
                                                                        <i class="fa fa-download" aria-hidden="true"></i>
                                                                        Descargar
                                                                    </a>    
                                                                </div>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                    $contador++;
                                                ?>
                                            @endforeach
								        @else
                                            <tr>
                                                <td class="val-m">{{ $tipo->descripcion }}</td>
                                                <td>{{ $tipo->usuario_gestiono }}</td>
                                                <td>{{ ($tipo->gestiono != null ? date("d-m-Y",strtotime($tipo->fecha_carga)) : '') }}</td>
                                                <td class="text-center">
    									            <i class="fa fa-times" aria-hidden="true" style="color:red;"></i>
                                                </td>
                                                <td></td>
                                            </tr>
								        @endif
                                    @endif  
                                @endforeach
                            </tbody>
                        </table>     
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" id="cargarDocumentoContrat" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-right">
            <button class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" onclick="window.history.back();" title="Volver">Volver</button>
        </div>
    </div>

    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog">
    	<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content | tri-br-1">
    			<div class="modal-header">
				    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
				    	<span aria-hidden="true">×</span>
				    </button>

    				<h4 class="modal-title">Contratación videos confirmación</h4>
				</div>

				<div class="modal-body">
        			<div class="row">
        				<div class="col-md-12">
	        				<?php $i = 0; ?>
        					@foreach ($getVideoQuestion as $video)
        						<?php $i++; ?>

        						<div class="panel panel-default" style="margin-bottom: 10px;">
								  	<div class="panel-body">
								  		<div class="col-md-9">
		    								{!! $video->desc_pregunta !!}
		    							</div>

		    							<div class="col-md-3">
		    								<button
		    									type="button"
		    									class="btn btn-success pull-right | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green"
		    									onclick="verVideo('{{ asset('video_contratos/'.$video->video) }}', '{{ $video->desc_pregunta }}')">
		    									Ver video <i class="fa fa-play-circle" aria-hidden="true"></i>
		    								</button>
		    							</div>
								  	</div>
								</div>
        					@endforeach
	        			</div>
        			</div>
				</div>

				<div class="modal-footer">
        			<button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal">Cerrar</button>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="modal fade" id="videoShowModal" tabindex="-1" role="dialog">
    	<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content | tri-br-1">
    			<div class="modal-header">
				    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
				    	<span aria-hidden="true">×</span>
				    </button>

    				<h4 class="modal-title">Contratación videos confirmación</h4>
				</div>

				<div class="modal-body">
        			<div class="row">
        				<div class="col-md-12" style="margin: auto; text-align: center;">
							<video width="400" height="320" controls id="videoBox" autoplay src=""></video>
	        			</div>

	        			<div class="col-md-12" id="questionDesc">
	        			</div>
        			</div>
				</div>

				<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    			</div>
    		</div>
    	</div>
    </div>

    <script>
        $('#data-table').DataTable({
              "responsive": true,
              "columnDefs": [
                  { responsivePriority: 1, targets: 0 },
                  { responsivePriority: 2, targets: -1 }
              ],
              "paginate": true,
              "lengthChange": true,
              "filter": true,
              "sort": true,
              "info": true,
              initComplete: function() {
              //var div = $('#data-table');
              //$("#filtro").prepend("<label for='idDepartamento'>Cliente:</label><select id='idDepartamento' name='idDepartamento' class='form-control' required><option>Seleccione uno...</option><option value='1'>  FRITURAS</option><option value='2'>REFRESCOS</option></select>");
                  this.api().column(0).each(function() {
                      var column = this;
                      console.log(column.data());
                      $('#estado_id').on('change', function() {
                          var val = $(this).val();
                          column.search(val ? '^' + val + '$' : '', true, false)
                              .draw();
                      });
                  });
              },
              "autoWidth": true,
              "order": [[ 1, "desc" ]],
              "language": {
                  "url": '{{ url("js/Spain.json") }}'
              }
        });

	 	$(function(){
	    	$("#cargarDocumentoContrat").on("click", function(){
	      		$.ajax({
	        		url: "{{ route('admin.cargarDocumentoAdminContratacion') }}",
	        		data: {
	        			user_id: {{ $candidato_id }},
	        			req: {{ $req }}
	        		},
	        		type: "POST",
	        		beforeSend: function(){
	        		},
	        		success: function(response) {
	          			$("#modalTriLarge").find(".modal-content").html(response)
	          			$("#modalTriLarge").modal("show")
	        		}
	      		})
	    	})

	    	$('#videoShowModal').on('hidden.bs.modal', function () {
	    		$('#videoBox').trigger('pause')
			});
	  	});

        function eliminarDocumento(boton) {
            swal({
                title: "¿Está seguro?",
                text: "¿Desea eliminar el documento? Está acción no se puede revertir.",
                icon: "warning",
                buttons: true,
                buttons: ["Cancelar", "Aceptar"]
            })
            .then((respuesta) => {
                if (respuesta) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.eliminar_documento') }}",
                        data: "id_doc="+boton.dataset.id+"&carpeta=contratacion",
                        success: function (response) {
                            if (response.eliminar) {
                                swal({
                                    text: "Documento eliminado correctamente.",
                                    icon: "success"
                                });
                                setTimeout(() => {
                                    location.reload()
                                }, 2000);
                            } else {
                                mensaje_danger("Se ha presentado un error, intenta nuevamente.");
                            }
                        },
                        error: function (response) {
                            mensaje_danger("Se ha presentado un error, intenta nuevamente.");
                        }
                    });
                }
            });
        }

	  	function verVideo(videoName, questionDesc){
	  		$("#videoBox").attr("src", videoName);
	  		$("#questionDesc").html('<p>'+questionDesc+'</p>');
	  		$('#videoShowModal').modal('show');
	  	}

		$(document).on("click", "#orden_contra", function() {
			var req = {{ $req_cand->id }};

			window.open("{{ route('orden_contratacion',['req'=>$req_cand->id]) }}",'_blank');

			$.ajax({
				type: "POST",
				data: "req=" +req,
				url: "{{ route('orden_contratacion',['req'=>$req_cand->id]) }}",
				success: function(response){
					if(response.success){
					}
				}
			})
		});
	</script>
@stop