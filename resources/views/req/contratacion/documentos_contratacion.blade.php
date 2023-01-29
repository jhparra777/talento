@extends("admin.layout.master")
@section('contenedor')
	@if ($firmaContrato != null)
		@if ($firmaContrato->estado == 1 || $firmaContrato->estado === 1)
			@if($firmaContrato->terminado != null && $firmaContrato->terminado == 1 || $firmaContrato->terminado == 3)
				<div class="row">
					<div class="col-sm-12" style="text-align: right;">
	
					  @if(file_exists('contratos/contrato_sin_video_'.$firmaContrato->id.'.pdf'))
					    <a type="button" class="btn btn-info" ref='{{route("view_document_url", encrypt("contratos/"."|contrato_sin_video_".$firmaContrato->id.".pdf"))}}'  target="_blank"> Aceptación preguntas </a>
					 @else
						@if ($firmaContrato->terminado == 1)
						  @if(count($getVideoQuestion) >= 1)
						    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#videoModal"> Videos contrato </button>
						  @endif
						@endif
					 @endif
						@if ($firmaContrato->contrato !== null || $firmaContrato->contrato !== '')
							<a type="button" class="btn btn-info" href='{{route("view_document_url", encrypt("contratos/"."|".$firmaContrato->contrato))}}' target="_blank">
								Contrato
							</a>
						@endif
					</div>
				</div>
			@endif
		@else
			@if($anuladoContrato != null || $anuladoContrato != '')
				<div class="row">
					<div class="col-sm-12" style="text-align: right;">
						@if ($anuladoContrato->documento !== null || $anuladoContrato->documento !== '')
							<a type="button" class="btn btn-info" href="{{route("view_document_url", encrypt("contratos_anulados/"."|".$anuladoContrato->documento))}}" target="_blank">
								Contrato anulado
							</a>
						@endif
					</div>
				</div>
			@endif
		@endif
	@endif

	<div class="row">
		<div class="col-sm-6">
			<h2>Documentos contratación</h2>
	
			<h4>{{ $datos_candidato->nombres }} {{ $datos_candidato->primer_apellido }} {{ $datos_candidato->segundo_apellido }}</h4>
			<h4><b>#Req:</b> {{ $req }}</h4>
			<h4><b>#T. Proceso:</b> {{ $requerimiento->tipo_proceso }}</h4>
			<h4><b>Cargo:</b> {{ $requerimiento->cargo()->descripcion }}</h4>
		</div>
	</div>

	<div class="col-right-item-container">
    	<div class="container-fluid">
       		
       		{{--{!! Form::model($datos_basicos,["id"=>"fr_datos_basicos","role"=>"form","method"=>"POST","files"=>true]) !!}--}}
      
           	<div class="col-md-12 col-sm-12 col-xs-12">
                <div id="submit_listing_box">
                    <h3>
                        {{--Documentos para contratación Req#{{$candidatos->req_id}}
                        <span class="pull-right">{{$porcentaje}}%<sub>Completado</sub></span>
                        <p><strong>Cargo</strong>:{{$candidatos->cargo}}</p>--}}
                    </h3>

                    <div class="form-alt">
                        <div class="row">

                        	<div class="tabla table-responsive">
					            <table class="table table-bordered table-hover ">
					                <thead>
					                    <tr>
					                        <th class="">Documento</th>
					                        <th class="">Status</th>
					                    </tr>
					                </thead>

					                <tbody style="text-transform: uppercase;">
										@if($tipo_documento->count() != 0)
									    	@foreach($tipo_documento as $tipo)
									    		<tr>
									        		<td>{{ $tipo->descripcion }}</td>
									    			
									        		<td>
									        			@if ($tipo->descripcion == 'CONTRATO')
															@if ($firmaContrato != null)
																@if($firmaContrato->estado == 1 || $firmaContrato->estado === 1)
																	@if($firmaContrato->terminado != null && $firmaContrato->terminado == 1 ||
																		$firmaContrato->terminado == 3)

																		@if ($firmaContrato->contrato !== null || $firmaContrato->contrato !== '')
																			<i class="fa fa-check" aria-hidden="true" style="color:green;"></i>

																			<a
																				href='{{route("view_document_url", encrypt("contratos/"."|".$firmaContrato->contrato))}}'
																				target="_blank"
																			>
																				<i class="fa fa-file-text-o" aria-hidden="true"></i>
																			</a>

																			<a
																				href='{{ route('admin.descargar_recurso', ['contratos', $firmaContrato->contrato]) }}'
																				target="_blank"
																				title="Descargar archivo"
																			>
																				<i class="fa fa-download" aria-hidden="true"></i>
																			</a>
																		@elseif(count($tipo->documentos) > 0)
												            				<i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
																			@foreach($tipo->documentos as $doc)
																				<a href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$doc->nombre."|".$tipo->id))}}' target="_blank">
																					<i class="fa fa-file-text-o" aria-hidden="true"></i>
																				</a>

																				<a href='{{ route('admin.descargar_recurso', ['recursos_documentos_verificados', $doc->nombre]) }}'
																					target="_blank"
																					title="Descargar archivo"
																					style="margin-right: 6px;"
																				>
																					<i class="fa fa-download" aria-hidden="true"></i>
																				</a>
																			@endforeach
												            		 	@else
												            		   		<i class="fa fa-times" aria-hidden="true" style="color:red;">
												            		  	@endif

																	@elseif($firmaContrato->terminado != null && $firmaContrato->terminado == 2)
																		<i class="fa fa-check" aria-hidden="true" style="color:green;"></i>

																		@if($contrato_manual != null)
																			<a
																				href='{{ route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$contrato_manual->nombre_archivo))}}' 
																				target="_blank"
																			>
																				<i class="fa fa-file-text-o" aria-hidden="true"></i>
																			</a>

																			<a
																				href='{{ route('admin.descargar_recurso', ['recursos_documentos_verificados', $contrato_manual->nombre_archivo]) }}'
																				target="_blank"
																				title="Descargar archivo"
																			>
																				<i class="fa fa-download" aria-hidden="true"></i>
																			</a>
																		@endif

																	@else
																		<i class="fa fa-times" aria-hidden="true" style="color:red;">
																	@endif

																@else
																	
																	@if($anuladoContrato != null || $anuladoContrato != '')
																		@if ($anuladoContrato->documento !== null || $anuladoContrato->documento !== '')
																			<i class="fa fa-check" aria-hidden="true" style="color:green;"></i>

																			<a
																				href='{{ route("view_document_url", encrypt("contratos_anulados/"."|".$anuladoContrato->documento)) }}'
																				target="_blank"
																			>
																				<i class="fa fa-file-text-o" aria-hidden="true"></i>
																			</a>

																			<a
																				href='{{ route('admin.descargar_recurso', ['contratos_anulados', $anuladoContrato->documento]) }}'
																				target="_blank"
																				title="Descargar archivo"
																			>
																				<i class="fa fa-download" aria-hidden="true"></i>
																			</a>
																		@endif
																	@endif

																@endif
															@else

																@if( count($tipo->documentos) > 0)
										            				<i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
																	@foreach($tipo->documentos as $doc)
																		<a href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$doc->nombre."|".$tipo->id))}}' target="_blank">
																			<i class="fa fa-file-text-o" aria-hidden="true"></i>
																		</a>

																		<a href='{{ route('admin.descargar_recurso', ['recursos_documentos_verificados', $doc->nombre]) }}'
																			target="_blank"
																			title="Descargar archivo"
																			style="margin-right: 6px;"
																		>
																			<i class="fa fa-download" aria-hidden="true"></i>
																		</a>
																	@endforeach
										            		 	@else
										            		   		<i class="fa fa-times" aria-hidden="true" style="color:red;">
										            		  	@endif

															@endif

														@elseif($tipo->descripcion == 'ORDEN DE CONTRATACIÓN')
															<i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
															
															<a
																href="{{ route('admin.paquete_contratacion_pdf', ['id' => $req_cand->id]) }}" 
																target="_blank"
															>
																<i class="fa fa-file-text-o" aria-hidden="true"></i>
															</a>
									        			@else
									        				@if(count($tipo->documentos) > 0)
									            				<i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
																@foreach($tipo->documentos as $doc)
																	<a href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$doc->nombre."|".$tipo->id))}}' target="_blank">
																		<i class="fa fa-file-text-o" aria-hidden="true"></i>
																	</a>

																	<a href='{{ route('admin.descargar_recurso', ['recursos_documentos_verificados', $doc->nombre]) }}'
																		target="_blank"
																		title="Descargar archivo"
																		style="margin-right: 6px;"
																	>
																		<i class="fa fa-download" aria-hidden="true"></i>
																	</a>
																@endforeach
									            		 	@else
									            		   		<i class="fa fa-times" aria-hidden="true" style="color:red;">
									            		  	@endif

									        			@endif
													</td>
									    		</tr>
									    	@endforeach
									    @else
									    	<p>No hay documentos para este cargo</p>
										@endif
					              	</tbody>
				            	</table>
							</div>
							
							<div style="text-align: center;">
						        <button class="btn btn-warning" onclick="window.history.back();" title="Volver">Volver</button>
			                </div>

                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("foto",$errors) !!}
                            </p>

						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog">
    	<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
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
		    								{{ $video->desc_pregunta }}
		    							</div>

		    							<div class="col-md-3">
		    								<button
		    									type="button"
		    									class="btn btn-success pull-right"
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
        			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="modal fade" id="videoShowModal" tabindex="-1" role="dialog">
    	<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
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
	 	$(function(){
	    	$("#cargarDocumentoContrat").on("click", function(){
	      		$.ajax({
	        		url: "{{ route('admin.cargarDocumentoAdminContratacion') }}",
	        		data: {
	        			user_id:{{ $candidato_id }},
	        			req:{{$req}}
	        		},
	        		type: "POST",
	        		beforeSend: function(){
	        		},
	        		success: function(response) {
	          			$("#modal_gr").find(".modal-content").html(response);
	          			$("#modal_gr").modal("show");
	        		}
	      		});
	    	});

	    	$('#videoShowModal').on('hidden.bs.modal', function () {
	    		$('#videoBox').trigger('pause');
			});
	  	});

	  	function verVideo(videoName, questionDesc){
	  		$("#videoBox").attr("src", videoName);
	  		$("#questionDesc").html('<p>'+questionDesc+'</p>');
	  		$('#videoShowModal').modal('show');
	  	}

		$(document).on("click", "#orden_contra", function() {
			var req = {{ $req }};

			window.open("{{ route('orden_contratacion', ['req'=>$req_cand->id]) }}",'_blank');

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