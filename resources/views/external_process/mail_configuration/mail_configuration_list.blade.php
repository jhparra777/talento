@extends("cv.layouts.master_out")
@section('content')
	<style>
		a.list-group-item:hover{ color: white; background-color: {{ $sitio_informacion->color }}; transition: all 200ms ease; }
	</style>

	@include('external_process.mail_configuration.src.css.mail_configuration_style')

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header">
				  	<h3>Lista de configuraciones</h3>
				</div>
			</div>

			@forelse ($lista_configuraciones as $configuracion)
			    <div class="col-md-6">
					<div class="list-group">
						{{-- data-toggle="tooltip" data-placement="top" title="Administrar configuración" --}}
					  	<a href="{{ route('configuracion_correos_gestionar', $configuracion->id) }}" class="list-group-item">
					  		<b>{{ $configuracion->nombre_configuracion }}</b>
					  	</a>
					</div>
				</div>
			@empty
			    <div class="col-md-12">
			    	<p>
			    		<b>No hay configuraciones definidas 😱️</b>
			    	</p>
			    </div>
			@endforelse
		</div>

		{{-- Botón flotante --}}
		@include('external_process.mail_configuration.includes.mail_configuration_float_button')

		{{-- Modal preview --}}
		<div id="modalPreviewBox"></div>
	</div>

	{{-- Scripts --}}
	@include('external_process.mail_configuration.src.js.mail_configuration_all_script')
@stop