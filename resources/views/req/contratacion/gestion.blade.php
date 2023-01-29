@extends("req.layout.master")
@section('contenedor')
	<div>
		<div class="row">
			<div class="col-sm-6">
				<h2>
					{{ $datos_candidato->nombres }} {{ $datos_candidato->primer_apellido }} {{ $datos_candidato->segundo_apellido }}
				</h2>

				<h4><b>#Req:</b> {{ $requerimiento->id }}</h4>
				<h4><b>Cargo:</b> {{ $requerimiento->cargo()->descripcion }}</h4>
			</div>
		</div>
		
		<br>

		<div class="row">
			<a href={{ route('req.documentos_seleccion', ["candidato" => $candidato, "req" => $req, "req_can" => $candi_req->id]) }}>
				<div class="col-md-6">
	            	<div class='small-box @if($porcentaje_seleccion == 0) bg-red @elseif($porcentaje_seleccion == 100) bg-green @else bg-yellow @endif' style="padding: 3em 0;">
	                	<div class="inner">
	                    	<h3 class="text-center"><sup style="font-size: 20px;">Documentos Selección</sup></h3>
	                	</div>

	                 	<div class="icon" style="font-size:  2.5em;">
	                 		<i>{{ $porcentaje_seleccion }}%</i>
                		</div>
	            	</div>
	        	</div>
        	</a>

       		<a href={{ route('req.documentos_contratacion', ["candidato" => $candidato, "req" => $req]) }}>
				<div class="col-md-6">
	            	<div class='small-box @if($porcentaje_contratacion == 0) bg-red @elseif($porcentaje_contratacion == 100) bg-green @else bg-yellow @endif' style="padding: 3em 0;">
	                	<div class="inner">
	                    	<h3 class="text-center"><sup style="font-size: 20px;">Documentos Contratación</sup></h3>
	                	</div>

	                 	<div class="icon" style="font-size:  2.5em;">
	                 		<i>{{ $porcentaje_contratacion }}%</i>
                		</div>
	            	</div>
	        	</div>
        	</a>

        	{{--
	    		<a href={{route('admin.documentos_confidenciales', ["candidato" => $candidato, "req" => $req]) }}>
					<div class="col-sm-4 col-xs-6">
		            	<div class='small-box @if($porcentaje_confidencial == 0) bg-red @elseif($porcentaje_confidencial == 100) bg-green  @else bg-yellow @endif' style="padding: 3em 0;">
		                	<div class="inner">
		                    	<h3 class="text-center"><sup style="font-size: 20px;">Documentos Confidenciales</sup></h3>
		                	</div>
		                 
		                 	<div class="icon" style="font-size:  2.5em;">
		                 		<i>{{$porcentaje_confidencial}}%</i>
	                		</div>
		            	</div>
		        	</div>
	        	</a>
        	--}}
		</div>

		<div class="row">
			<div style="text-align: center;">
				<a class="btn btn-warning" href="{{ route('req.mis_contratados') }}" title="Volver">Volver</a>
        	</div>
		</div>
	</div>
@stop