@extends("req.layout.master")
@section('contenedor')

	{{-- Header --}}
	<?php
		$cargo=$requerimiento->cargo_especifico()->descripcion;
	?>
	@include('req.layout.includes._section_header_breadcrumb', ['page_header' => "$datos_candidato->nombres  $datos_candidato->primer_apellido  $datos_candidato->segundo_apellido",'more_info' => "<b>Requerimiento</b> $requerimiento->id | <b>Cargo</b> $cargo"])
	
	<div class="row pt-2">
		<div class="col-xs-6">
			<div
				class="small-box bg-aqua | tri-small-box tri-shadow-light @if($porcentaje_seleccion == 0) tri-bl-red @elseif($porcentaje_seleccion == 100) tri-bl-green @else tri-bl-yellow @endif tri-transition-300 tri-bg-white">
				<a class="tri-py-2" href={{route('req.documentos_seleccion', ["candidato"=> $candidato, "req" => $req,
					"req_can" => $candi_req->id])}}>
					<div class="inner">
						<div class="row">
							<div class="col-sm-1" style="height: 110px;">
								<span
									class="@if($porcentaje_seleccion == 0) tri-red @elseif($porcentaje_seleccion == 100) tri-green @else tri-yellow @endif text-white tri-px-05">{{$porcentaje_seleccion}}%</span>
							</div>
							<div class="col-sm-11">
								<p class="tri-fs-30 tri-py-4 text-center" style="color: gray;">Documentos selección</p>
								<p class="tri-txt-gray-600"></p>
							</div>
						</div>
					</div>
				</a>
				{{-- @if($candi_req->bloqueo_carpeta)
                    <div class="icon">
	                    <i class="fas fa-lock"></i>
	                </div>
                @endif --}}
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
					@if(!$candi_req->bloqueo_carpeta)
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-default" id="btn-cerrar-carpeta"
							data-folder=1>
							{{-- <i class="fas fa-lock"></i> --}}
							&nbsp
						</button>
					</div>
					@endif
				</div>
			</div>
		</div>

		<div class="col-xs-6">
			<div
				class="small-box bg-aqua | tri-small-box tri-shadow-light @if($porcentaje_contratacion == 0) tri-bl-red @elseif($porcentaje_contratacion == 100) tri-bl-green @else tri-bl-yellow @endif tri-transition-300 tri-bg-white">
				<a class="tri-py-2" href={{ route('req.documentos_contratacion', ["candidato"=> $candidato, "req" => $req])
					}}>
					<div class="inner">
						<div class="row">
							<div class="col-sm-1" style="height: 110px;">
								<span
									class="@if($porcentaje_contratacion == 0) tri-red @elseif($porcentaje_contratacion == 100) tri-green @else tri-yellow @endif text-white tri-px-05">{{$porcentaje_contratacion}}%</span>
							</div>
							<div class="col-sm-11">
								<p class="tri-fs-30 tri-py-4 text-center" style="color: gray;">Documentos contratación</p>
								<p class="tri-txt-gray-600"></p>
							</div>
						</div>
					</div>
		
				</a>
				<div class="btn-group btn-group-justified" role="group" aria-label="...">
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-default">
							&nbsp
						</button>
					</div>
				</div>
			</div>
		</div>	
	</div>

	<div class="row">
		<div class="col-sm-12 text-right">
			<a class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" href="{{ route('req.mis_contratados') }}" title="Volver">Volver</a>
        </div>
	</div>
@stop