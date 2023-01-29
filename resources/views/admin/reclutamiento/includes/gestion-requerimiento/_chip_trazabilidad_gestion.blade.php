<div class="md-chip">
	<div class="md-chip-icon | {{ $bgColor }}">
		<i class="fas {{ $icon }}" aria-hidden="true"></i>
	</div>

	{{-- Ir al proceso --}}
	@if(isset($btnIrProceso))
		@include('admin.reclutamiento.includes.gestion-requerimiento._button_ir_proceso_gestion', ['proceso' => $proceso])
	@else
		{{ $proceso }}
	@endif

	{{-- Botón eliminar proceso --}}
	@if(isset($btnEliminarProceso))
		@include('admin.reclutamiento.includes.gestion-requerimiento._button_eliminar_proceso_gestion')
	@elseif(isset($btnReabrirProceso))
		@include('admin.reclutamiento.includes.gestion-requerimiento._button_reabrir_proceso_gestion')
	@endif

	{{-- @if($requermiento->tipo_proceso_id == $sitio->id_proceso_sitio)
		<a class="btn"
			onclick="comenzarFirmaContrato('{{ route('home.firma-contrato-laboral', [$candidato_req->encriptar($proce->candidato_id), $candidato_req->encriptar($proce->requerimiento_id), $candidato_req->encriptar('modulo_admin')]) }}')">
			<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
			Firmar
		</a>
	@endif --}}
</div>


{{-- <div class="chip | tri-cursor-default tri-br-2 text-white {{ $bgColor }}">	
	
	@if(isset($btnIrProceso))
		@include('admin.reclutamiento.includes.gestion-requerimiento._button_ir_proceso_gestion', ['proceso' => $proceso])
	@else
		<span>{{ $proceso }}</span>
	@endif

	
	@if(isset($btnEliminarProceso))
		@include('admin.reclutamiento.includes.gestion-requerimiento._button_eliminar_proceso_gestion')
	@elseif(isset($btnReabrirProceso))
		@include('admin.reclutamiento.includes.gestion-requerimiento._button_reabrir_proceso_gestion')
	@endif

	
</div> --}}