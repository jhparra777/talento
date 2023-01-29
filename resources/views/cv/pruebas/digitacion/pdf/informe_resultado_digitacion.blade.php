<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
	<title>Informe de prueba digitación</title>
	<style>
        @page {
            margin: 0cm 0cm;
            font-family: 'Roboto', sans-serif;
        }

        body {
            margin: 1cm 2cm 2cm;
            font-family: 'Roboto', sans-serif;
        }

        .text-center{ text-align: center; }
        .text-left{ text-align: left; }
        .text-right{ text-align: right; }
        .text-justify{ text-align: justify; }

        .table{ border-collapse:separate; }

        .font-size-10{ font-size: 10pt; }
        .font-size-11{ font-size: 11pt; }
        .font-size-12{ font-size: 12pt; }
        .font-size-14{ font-size: 14pt; }

        .m-0{ margin: 0; }
        .m-1{ margin: 1rem; }
        .m-2{ margin: 2rem; }
        .m-3{ margin: 3rem; }
        .m-4{ margin: 4rem; }

        .ml-0{ margin-left: 0; }
        .ml-1{ margin-left: 1rem; }
        .ml-2{ margin-left: 2rem; }
        .ml-3{ margin-left: 3rem; }
        .ml-4{ margin-left: 4rem; }

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

        .m-auto{ margin: auto; }

        .pd-0{ padding: 0; }
        .pd-05{ padding: 0.5rem; }
        .pd-1{ padding: 1rem; }
        .pd-2{ padding: 2rem; }
        .pd-3{ padding: 3rem; }
        .pd-4{ padding: 4rem; }

        .no-list{ list-style: none; }

        .table-result{
		  	background-color: #f1f1f1;
		  	border-radius: 5px;
		  	padding: 0.5rem;
		  	font-family: 'Roboto', sans-serif;
		  	box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2), 0 4px 8px 0 rgba(0, 0, 0, 0.19);
		}

		.bg-gray{ background-color: #a6a6a6; color: white; }

		.color-blue{ color: #2E2D66; }
		.color-red{ color: #D92428; }
		.color-yellow{ color: #E4E42A; }
		.color-green{ color: #00A954; }

		.br-05{ border-radius: 5px; }

		.fw-600{ font-weight: 600; }
		.fw-700{ font-weight: 700; }

		.page-break{ page-break-after: always; }

		.profile-picture{
			padding: .25rem;
			width: 100px;
			background-color: #fff;
			border: 1px solid #dee2e6;
			border-radius: .25rem;
			max-width: 100%;
		}

		.divider{ width: 44.5%; background-color: #a6a6a6; color: #a6a6a6; border: 0; height: 1px; }
		.divider-th{ width: 90%; background-color: #a6a6a6; color: #a6a6a6; border: 0; height: 1px; }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            /*background-color: #2a0927;*/
            color: #d6d6d6;
            text-align: center;
            line-height: 20px;
        }
    </style>
</head>
<body>
	<main>
		{{-- Logos T3RS y cliente --}}
		<section>
			<table width="100%">
				<tr>
					<td class="text-left">
						<img src="https://img-t3rsc.s3.amazonaws.com/t3rs-src/t3rs-without-bg.png" alt="T3RS" width="100">
					</td>
					<td></td>
					<td class="text-right">
						@if(!triRoute::validateOR('local'))
							<img src="{{ asset("configuracion_sitio/$sitio_informacion->logo") }}" alt="T3RS" width="100" height="60">
						@else
							<img src="https://picsum.photos/120/60" alt="T3RS" width="120">
						@endif
					</td>
				</tr>
			</table>
		</section>

		{{-- Titulo del documento --}}
		<h4 class="text-center">Informe de prueba digitación</h4>
		{{-- <div class="text-center mb-2">
			<img src="https://desarrollo.t3rsc.co/assets/admin/tests/bryg/src/bryg-aumented-name.png" alt="BRYG" width="90">
		</div> --}}

		{{-- Foto de perfil del candidato (si posee) --}}
		<section>
			<div class="text-center">
				@if(!triRoute::validateOR('local'))
					@if(!empty($candidato_digitacion->foto_perfil))
						<img 
							src="{{ url("recursos_datosbasicos/$candidato_digitacion->foto_perfil") }}" 
							alt="Foto de perfil" 
							class="profile-picture" 
							width="100"
						>
					@else
						<img 
							src="{{ url("img/personaDefectoG.jpg") }}" 
							alt="Foto de perfil" 
							class="profile-picture" 
							width="100"
						>
					@endif
				@else
					<img class="profile-picture" src="https://picsum.photos/500" alt="Foto de perfil">
				@endif
			</div>
		</section>

		{{-- Datos del usuario --}}
		<section>
			<div class="font-size-11 text-center">
				<ul class="no-list pd-0 mt-1">
					<li><b>{{ $candidato_digitacion->nombre_completo }}</b></li>
					<li>C.C {{ $candidato_digitacion->cedula }}</li>
					<li>{{ $candidato_edad }} años</li>
					<li>{{ $candidato_digitacion->celular }}</li>
					<li>{{ $candidato_digitacion->correo }}</li>
				</ul>
			</div>
		</section>

		{{-- Datos del requerimiento --}}
		<section>
			<div class="mt-1">
				<table width="100%">
					<tr>
						<th class="text-left" width="50%">
							<p class="m-0">
								Cargo en el que se evalúa
								<hr align="right" class="divider-th">
							</p>
							<p class="ml-2" style="margin-top: -5px; font-weight: initial;">{{ ucfirst(mb_strtolower($requerimiento_detalle->cargo_req())) }}</p>
						</th>

						<th class="text-left" width="50%">
							<p class="m-0">
								Requerimiento
								<hr align="right" class="divider-th">
							</p>
							<p class="ml-2" style="margin-top: -5px; font-weight: initial;">{{ $requerimiento_detalle->id }}</p>
						</th>
					</tr>
				</table>

				<table width="100%">
					<tr>
						<th class="text-left" width="50%">
							<p class="m-0">
								<b>Cliente</b>
								<hr align="right" class="divider-th">
							</p>
							<p class="ml-2" style="margin-top: -5px; font-weight: initial;">{{ ucfirst($requerimiento_detalle->nombre_cliente_req()) }}</p>
						</th>

						<th class="text-left" width="50%">
							<p class="m-0">
								<b>Fecha solicitud de prueba</b>
								<hr align="right" class="divider-th">
							</p>
							<p class="ml-2" style="margin-top: -5px; font-weight: initial;">{{ $fecha_evaluacion_letra }}</p>
						</th>
					</tr>
				</table>
			</div>
		</section>

		{{-- Introducción al documento --}}
		<section>
			<div class="text-justify">
				<p>
					Bienvenido, en {{ ucfirst($requerimiento_detalle->nombre_cliente_req()) }} hemos preparado un informe personalizado referente a la prueba de digitación realizada a {{ $candidato_digitacion->nombres }}, quien es uno de los participantes en el proceso.
				</p>
			</div>
		</section>

		{{-- Resultado mini tabla BRYG --}}
		<section>
			<div class="mt-2 mb-3">
				<p class="text-center">
					<b>
						RESULTADOS
					</b>
				</p>

				<table class="table-result m-auto">
				  	<tr>
					    <th class="bg-gray pd-05 br-05">PPM</th>
					    <th class="bg-gray pd-05 br-05">PULSACIONES</th>
					    <th class="bg-gray pd-05 br-05">PRECISIÓN</th>
					    <th class="bg-gray pd-05 br-05">CORRECTAS</th>
					    <th class="bg-gray pd-05 br-05">INCORRECTAS</th>
				  	</tr>

				    <tr class="text-center fw-700">
				      	<td class="pd-05">{{ $candidato_digitacion->ppm }}</td>
				      	<td class="pd-05">{{ $candidato_digitacion->pulsaciones }}</td>
				      	<td class="pd-05">{{ $candidato_digitacion->precision_user }}</td>
				      	<td class="pd-05">{{ $candidato_digitacion->correctas }}</td>
				      	<td class="pd-05">{{ $candidato_digitacion->incorrectas }}</td>
				    </tr>
				</table>
			</div>
		</section>

		<div class="page-break"></div>

		{{-- Introducción al documento --}}
		<section>
			<div class="text-center">
				<h4>Fotos tomadas durante el proceso de la prueba</h4>

				@forelse($digitacion_fotos as $foto)
	                @if(!triRoute::validateOR('local'))
	                	<img 
	                        class="m-1" 
	                        src="{{ asset("recursos_prueba_digitacion/prueba_digitacion_$candidato_digitacion->user_id_$candidato_digitacion->req_id_$candidato_digitacion->id/$foto->descripcion") }}" 
	                        alt="Foto candidato prueba"
	                        width="220">
					@else
						<img class="m-1" src="https://picsum.photos/640/420" alt="T3RS" width="220">
					@endif
				@empty
					<p class="text-justify">No existe registro fotográfico ya que el candidato no contaba con cámara fotográfica al momento de realizar la prueba.</p>
	            @endforelse
			</div>
		</section>

		{{-- <section>
			<div class="mt-2 mb-3">
				<p class="text-center">
					<b>
						COMPARATIVA
					</b>
				</p>

				<table class="table-result m-auto">
				  	<tr>
					    <th class="bg-gray pd-05 br-05">PPM</th>
					    <th class="bg-gray pd-05 br-05">PRECISIÓN</th>
				  	</tr>

				    <tr class="text-center fw-700">
				      	<td class="pd-05">{{ $candidato_digitacion->ppm }}</td>
				      	<td class="pd-05">{{ $candidato_digitacion->precision_user }}</td>
				    </tr>
				</table>
			</div>
		</section> --}}

		{{-- Separar contenido a nueva hoja --}}
		<div class="page-break"></div>

		@if(!empty($concepto))
			{{-- Concepto final de la prueba --}}
			<section>
				<p class="text-center">
					<b>
						Concepto final sobre la prueba realizada por nuestro especialista en selección de personal.
					</b>
				</p>
			</section>

			{{-- Contenido del concepto --}}
			<section>
				<div class="text-justify mt-1 mb-1">
					<p>
						{!! ucfirst($concepto->concepto) !!}
					</p>
				</div>
			</section>
		@endif

		{{-- Información final --}}
		<section>
			<div class="text-justify">
				<p>
					Prueba realizada el {{ $fecha_realizacion_letra }} - solicitada por {{ $candidato_digitacion->solicitadaPor()->nombres }} {{ $candidato_digitacion->solicitadaPor()->primer_apellido }} {{ $candidato_digitacion->solicitadaPor()->segundo_apellido }} @if(!empty($concepto)) y evaluada por nuestro analista de selección {{ $concepto->gestionConceptoNombre->fullname() }} @endif.
				</p>
			</div>
		</section>
	</main>

	<footer>
	    <h5>T3RS</h5>
	</footer>
</body>
</html>