<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
	</button>

    <h4 class="modal-title">
	<b>Candidato</b> {{$datos_basicos->nombres}} {{$datos_basicos->primer_apellido}} {{$datos_basicos->segundo_apellido}}
	| <b>{{$datos_basicos->cod_tipo }}</b> {{$datos_basicos->numero_id}}
    </h4>
</div>
<?php
	function existeDocumentoCargo($cargos, $id_tipo) {
		$result = false;
		if ($cargos->where('tipo_documento_id', $id_tipo)->count() > 0) {
			$result = true;
		}
		return $result;
	}
?>

<div class="modal-body" id="print">
	<form action="" id="form_contratacion">
		<input type="hidden" id="total_documentos" value="{{ count($tipo_documento)+count($documento_seleccion) }}">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
        			<div class="panel-body">
						<label class="col-md-12">Documentos que desea adjuntar</label>
			
						<div class="col-md-12">
							<ul style="list-style-type: none;margin: 0;">
								<input type="hidden" name="cand_req" value="{{ $req_cand }}">
								<input type="hidden" name="user_id" value="{{ $user_id }}">
								<!-- dividir en dos listas contratacion y seleccion -->

								<table class="table">
								<tr>
									<td class="text-left">
										<p>CONTRATACIÓN</p>
									@foreach($tipo_documento as $tipo)
										@if($tipo->descripcion == 'Contrato Firmado')
									
										@if($firmaContrato->contrato !== null || $firmaContrato->contrato !== '')
											<input type="hidden" name="contrato" value="{{ $firmaContrato->id }}">
						
												<li>
													<label style="font-weight:initial;">
														<input type="checkbox" name="documentos[]" value="{{ $tipo->id }}">
														Contrato Firmado
													</label>
												</li>
										@endif
							
										@elseif ($tipo->descripcion == 'ORDEN DE CONTRATACIÓN')
											<li>
												<label style="font-weight:initial;">
													<input type="checkbox" name="documentos[]" value="{{ $tipo->id }}">
													ORDEN DE CONTRATACIÓN
												</label>
											</li>
										@else
											@if($tipo->descripcion != null)
												<li>
													<label style="font-weight:initial;">
														<input type="checkbox" name="documentos[]" value="{{ $tipo->id }}">
														{{ $tipo->descripcion }}
													</label>
												</li>
											@endif
										@endif
									@endforeach
									@if($firmaContrato->contrato !== null || $firmaContrato->contrato !== '')
										<li>
											
											<label style="font-weight:initial;">
											<input type="checkbox" id="carnet" name="carnet" value="true">
											CARNET
											</label>
										</li>
									@endif
									</td>
									<td class="text-left">
										<p>SELECCIÓN</p>
									@foreach($documento_seleccion as $tipo2)
										@if($tipo2->descripcion != null && existeDocumentoCargo($documentos_cargo, $tipo2->id))
										<li>
											<label style="font-weight:initial;">
											<input type="checkbox" name="documentos[]" value="{{ $tipo2->id }}">
											{{ $tipo2->descripcion }}
											</label>
										</li>
										@endif
									@endforeach
									</td>
								</tr>
								</table>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 ">
				<div class="panel panel-default">
        			<div class="panel-body">
						<label class="col-md-12">Observación</label>
						<div class="col-md-12">
							<textarea id="observacion_envio_contratacion" name="observacion_envio_contratacion" rows="4" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
        			<div class="panel-body">
						<label class="col-md-12">Seleccione los destinatarios </label>
						<div class="col-md-12">
							<label style="font-weight:initial;">
								<input type="checkbox" name="cliente" value="true"> Cliente
							</label>
							<label class="col-md-4" style="font-weight:initial;">
								<input type="checkbox" name="candidato" value="true"> Candidato
							</label>
						</div>
						<br/>
						<label class="col-md-12 mt-1" for="otro_destinatario">Añadir otros destinatarios (Correo electrónico)</label>
						<div class="col-md-12">
							<input type="text" name="otro_destinatario" id="otro_destinatario" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" placeholder="ejemplo@ejemplo.com,ejemplo22@otro.com">
							<p class="help-block">Ingrese los correos electrónicos separados por comas (,).</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="modal-footer">
	<button class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal" type="button">Cerrar</button>
	<button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="enviar_confirmacion_contratacion_modal">Enviar</button> 
</div>

<script>
	/* Validación de correo */
	let otroDestino = document.querySelector('#otro_destinatario');

	otroDestino.addEventListener('keydown', (e) => {
		if(validar_email(otroDestino.value)){
			otroDestino.style.borderColor = '#d2d6de'
			document.querySelector('#enviar_confirmacion_contratacion_modal').disabled = false
		}else{
			otroDestino.style.borderColor = 'red'
			document.querySelector('#enviar_confirmacion_contratacion_modal').disabled = true
		}

		if(otroDestino.value == '' || otroDestino.value == null)
			otroDestino.style.borderColor = '#d2d6de'
			document.querySelector('#enviar_confirmacion_contratacion_modal').disabled = false
	})
</script>