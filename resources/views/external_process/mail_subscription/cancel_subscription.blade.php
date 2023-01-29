@extends("cv.layouts.master_out")
@section('content')
	<style type="text/css">
		html, body{ background-color: #f1f1f1; }

		.mt-0{ margin-top: 0; }
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .mb-0{ margin-bottom: 0; }
        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .btn-default{
        	color: white;
        	background-color: {{ $sitio_informacion->color }};
			border-color: {{ $sitio_informacion->color }};
        }

        .btn-default:hover{
        	color: white;
        	background-color: {{ $sitio_informacion->color }};
			border-color: {{ $sitio_informacion->color }};
        }
	</style>

	<div class="container">
		<div class="row">
			<div class="col-md-12 mt-3 text-center">
				<img src="{{ asset("configuracion_sitio/$sitio_informacion->logo") }}" alt="Logotipo" width="120">
			</div>

			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default mt-4">
				  	<div class="panel-body">
				    	<div class="col-md-12 text-center mt-1 mb-3">
				    		<h3>Suscripción a correos electrónicos</h3>
				    	</div>

				    	@if(!Session::has('suscripcion_cancelada'))
				    		<form class="form-horizontal" action="{{ route("cancelar_suscripcion_post") }}" method="post">
					    		{{ csrf_field() }}

					    		<input type="hidden" name="email_data" value="{{ $user_id }}">
				    			<div class="form-group">
								    <label for="correo" class="col-sm-2 control-label">Correo:</label>
								    <div class="col-sm-10">
								    	<input type="email" name="correo" class="form-control" id="correo" placeholder="Correo electrónico" value="{{ $usuario_informacion->email }}" disabled>
								    </div>
								</div>

								<div class="col-md-12 text-center mt-3 mb-3">
					    			<button type="submit" class="btn btn-default btn-lg">Cancelar suscripción</button>
					    		</div>
				    		</form>
				    	@else
				    		<div class="col-md-12">
				    			<div class="alert alert-success" role="alert">
					    			<i class="fa fa-check"></i> Suscripción cancelada correctamente (puedes cerrar esta pestaña). 
					    			<a href="#" class="alert-link" onclick="window.close()">Cerrar pestaña</a>
					    		</div>
				    		</div>
					    @endif
				  	</div>
				</div>
			</div>
		</div>
	</div>
@stop