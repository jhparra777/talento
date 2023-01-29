<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
	<title>Informe de prueba Psicotécnica virtual BRYG-A</title>
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

		.bg-blue{ background-color: #2E2D66; color: white; }
		.bg-dark-blue{ background-color: #2c3e50; color: white; }
		.bg-red{ background-color: #D92428; color: white; }
		.bg-yellow{ background-color: #E4E42A; color: white; }
		.bg-green{ background-color: #00A954; color: white; }

		.color-blue{ color: #2E2D66; }
		.color-red{ color: #D92428; }
		.color-yellow{ color: #E4E42A; }
		.color-green{ color: #00A954; }

		.bg-blue-a{ background-color: #0288d1; color: white; }
        .bg-red-a{ background-color: #f44336; color: white; }
        .bg-yellow-a{ background-color: #fdd835; color: white; }
        .bg-green-a{ background-color: #7cb342; color: white; }

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

		.divider{ width: 44.5%; background-color: #2E2D66; color: #2E2D66; border: 0; height: 1px; }
		.divider-th{ width: 90%; background-color: #2E2D66; color: #2E2D66; border: 0; height: 1px; }

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
		<h4 class="text-center">Informe de prueba Psicotécnica virtual</h4>
		<div class="text-center mb-2">
			<img src="https://desarrollo.t3rsc.co/assets/admin/tests/bryg/src/bryg-aumented-name.png" alt="BRYG" width="90">
		</div>

		{{-- Foto de perfil del candidato (si posee) --}}
		<section>
			<div class="text-center">
				@if(!triRoute::validateOR('local'))
					@if(!empty($candidato_bryg->foto_perfil))
						<img 
							src="{{ url("recursos_datosbasicos/$candidato_bryg->foto_perfil") }}" 
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
					<li><b>{{ $candidato_bryg->nombre_completo }}</b></li>
					<li>C.C {{ $candidato_bryg->cedula }}</li>
					<li>{{ $candidato_edad }} años</li>
					<li>{{ $candidato_bryg->celular }}</li>
					<li>{{ $candidato_bryg->correo }}</li>
				</ul>
			</div>
		</section>

		{{-- Datos del requerimiento --}}
		<section>
			<div class="mt-1">
				<table width="100%">
					<tr>
						<th class="text-left" width="50%">
							<p class="color-blue m-0">
								Cargo en el que se evalúa
								<hr align="right" class="divider-th">
							</p>
							<p class="ml-2" style="margin-top: -5px; font-weight: initial;">{{ ucfirst(mb_strtolower($requerimiento_detalle->cargo_req())) }}</p>
						</th>

						<th class="text-left" width="50%">
							<p class="color-blue m-0">
								Requerimiento
								<hr align="right" class="divider-th">
							</p>
							<p class="ml-2" style="margin-top: -5px; font-weight: initial;">{{ $requerimiento_detalle->id }}</p>
						</th>
					</tr>
				</table>

				<p class="color-blue m-0">
					<b>Cliente</b>
					<hr align="right" class="divider">
				</p>
				<p class="ml-2" style="margin-top: -5px;">{{ ucfirst($requerimiento_detalle->nombre_cliente_req()) }}</p>

				<p class="color-blue m-0">
					<b>Fecha solicitud de prueba</b>
					<hr align="right" class="divider">
				</p>
				<p class="ml-2" style="margin-top: -5px;">{{ $fecha_evaluacion_letra }}</p>
			</div>
		</section>

		{{-- Introducción al documento --}}
		<section>
			<div class="text-justify">
				<p>
					Bienvenido, en {{ ucfirst($requerimiento_detalle->nombre_cliente_req()) }} hemos preparado un informe personalizado referente a la evaluación psicotécnica realizada a {{ $candidato_bryg->nombres }}, quien es uno de los participantes en el proceso. Para un mejor entendimiento de los resultados te resaltamos las principales características sobre las cuales nos basamos:
				</p>
			</div>
		</section>

		<section>
			<div class="text-justify">
				<ul>
					<li>
						La metodología en la que basamos la prueba se enfoca en la evaluación del comportamiento de {{ $candidato_bryg->nombres }}, no en sus emociones.
					</li>

					<li>
						Nuestra prueba revela factores comportamentales, los cuales no pretenden dictaminar estilos correctos o incorrectos, más bien revelará limitaciones y fortalezas.
					</li>

					<li>
						Se basa en 4 dimensiones de comportamiento y en una orientación a la adaptabilidad al cargo.
					</li>

					<li>
						La prueba evaluó 48 posibles combinaciones para determinar el comportamiento predominante en {{ $candidato_bryg->nombres }}, por lo cual a continuación mostramos los resultados.
					</li>
				</ul>
			</div>
		</section>

		{{-- Resultado mini tabla BRYG --}}
		<section>
			<div class="mt-2 mb-3">
				<p class="text-center">
					<b class="color-blue">
						SU PERFIL ES 
						{{ mb_strtoupper(App\Http\Controllers\PruebaPerfilBrygController::brygPerfilTipo($bryg_definitive_first[0], $bryg_definitive_second[0])) }}
					</b>
				</p>

				<table class="table-result m-auto">
				  	<tr>
					    <th class="bg-blue pd-05 br-05">RADICAL</th>
					    <th class="bg-red pd-05 br-05">GENUINO</th>
					    <th class="bg-yellow pd-05 br-05">GARANTE</th>
					    <th class="bg-green pd-05 br-05">BÁSICO</th>
				  	</tr>
				    <tr class="text-center fw-700">
				      	<td class="pd-05">{{ $candidato_bryg->estilo_radical }}</td>
				      	<td class="pd-05">{{ $candidato_bryg->estilo_genuino }}</td>
				      	<td class="pd-05">{{ $candidato_bryg->estilo_garante }}</td>
				      	<td class="pd-05">{{ $candidato_bryg->estilo_basico }}</td>
				    </tr>
				</table>
			</div>
		</section>

		{{-- Gráfico de barra BRYG --}}
		<section>
			<div class="text-center mb-3">
				<img src="https://quickchart.io/chart?c={{ json_encode($grafico_barra_bryg) }}" width="500">
			</div>
		</section>

		{{-- Gráfico de radar BRYG --}}
		<section>
			<div class="text-center">
				<img src="https://quickchart.io/chart?c={{ json_encode($grafico_radar_bryg) }}" width="500">
			</div>
		</section>

		{{-- Separar contenido a nueva hoja --}}
		<div class="page-break"></div>

		{{-- Explicación gráfico BRYG --}}
		<section>
			<div class="text-justify">
				<p>
					Encontramos que {{ $candidato_bryg->nombres }} tiene un perfil comportamental orientado principalmente a los factores {{ $bryg_definitive_first[0] }} y {{ $bryg_definitive_second[0] }}, por lo cual su perfil es <b class="color-blue">{{ mb_strtoupper(App\Http\Controllers\PruebaPerfilBrygController::brygPerfilTipo($bryg_definitive_first[0], $bryg_definitive_second[0])) }}</b>.
				</p>
			</div>
		</section>

		{{-- Imagen del tipo de perfil BRYG --}}
		<section>
			<div class="text-center mt-3 mb-3">
				<img 
					src="{{ App\Http\Controllers\PruebaPerfilBrygController::brygPerfil($bryg_definitive_first[0], $bryg_definitive_second[0]) }}" 
					width="500" 
					alt="Perfil BRYG"
				>
			</div>
		</section>

		{{-- Descripción de los factores de cada cuadrante --}}
		<section>
			<p><b>Sus factores predominantes son...</b></p>
			{{-- Primero se listan los factores del cuadrante más alto --}}
			@foreach(App\Http\Controllers\PruebaPerfilBrygController::brygPrimerCuadranteFactor($bryg_definitive_first[0]) as $primer_factor)
				<p class="color-blue">
					<b>{{ $primer_factor->nombre }}.</b>
				</p>

				<p class="text-justify">
					{{ $primer_factor->descripcion }}
				</p>
			@endforeach

			<p class="mt-2"><b>Sus factores complementarios o alternativos son...</b></p>
			{{-- Se listan los factores del cuadrante secundario --}}
			@foreach(App\Http\Controllers\PruebaPerfilBrygController::brygSegundoCuadranteFactor($bryg_definitive_second[0]) as $segundo_factor)
				<p class="color-blue">
					<b>{{ $segundo_factor->nombre }}.</b>
				</p>

				<p class="text-justify">
					{{ $segundo_factor->descripcion }}
				</p>
			@endforeach
		</section>

		{{-- Separar contenido a nueva hoja --}}
		<div class="page-break"></div>

		{{-- Titulo de la sección aumented --}}
		<section>
			<p class="text-center mt-2"><b>Perfil de orientación a la adaptabilidad al cargo.</b></p>
		</section>

		{{-- Resultado mini tabla AUMENTED --}}
		<section>
			<div class="mt-0 mb-3">
				<p class="text-center">
					<b class="color-blue">
						SU ESTILO ES 
						{{ mb_strtoupper($aumented_definitive[0]) }}
					</b>
				</p>

				<table class="table-result m-auto">
				  	<tr>
					    <th class="bg-blue-a pd-05 br-05">ANALIZADOR</th>
					    <th class="bg-yellow-a pd-05 br-05">PROSPECTIVO</th>
					    <th class="bg-red-a pd-05 br-05">DEFENSIVO</th>
					    <th class="bg-green-a pd-05 br-05">REACTIVO</th>
				  	</tr>
				    <tr class="text-center fw-700">
				      	<td class="pd-05">{{ $candidato_bryg->aumented_a }}</td>
				      	<td class="pd-05">{{ $candidato_bryg->aumented_p }}</td>
				      	<td class="pd-05">{{ $candidato_bryg->aumented_d }}</td>
				      	<td class="pd-05">{{ $candidato_bryg->aumented_r }}</td>
				    </tr>
				</table>
			</div>
		</section>

		{{-- Gráfico de barra AUMENTED --}}
		<section>
			<div class="text-center mb-3">
				<img src="https://quickchart.io/chart?c={{ json_encode($grafico_barra_aumented) }}" width="500">
			</div>
		</section>

		{{-- Gráfico de radar AUMENTED --}}
		<section>
			<div class="text-center">
				<img src="https://quickchart.io/chart?c={{ json_encode($grafico_radar_aumented) }}" width="500">
			</div>
		</section>

		{{-- Separar contenido a nueva hoja --}}
		<div class="page-break"></div>

		{{-- Introducción al perfil de adaptabilidad --}}
		<section>
			<div class="text-justify">
				<p>
					El perfil de orientación de adaptabilidad al cargo, muestra estilo de comportamiento de {{ $candidato_bryg->nombres }} frente a determinadas situaciones, en este caso su estilo es <b class="color-blue">{{ mb_strtoupper($aumented_definitive[0]) }}</b>.
				</p>
			</div>
		</section>

		{{-- Imagen del perfil de adaptabilidad --}}
		<section>
			<div class="text-center mt-3 mb-3">
				<img 
					src="{{ App\Http\Controllers\PruebaPerfilBrygController::aumentedPerfil($aumented_definitive[0]) }}" 
					width="500" 
					alt="Perfil de adaptabilidad"
				>
			</div>
		</section>

		@if(!empty($concepto))
			{{-- Concepto final de la prueba --}}
			<section>
				<p class="text-center">
					<b>
						Concepto final sobre la prueba psicotécnica realizada por nuestro especialista en selección de personal.
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
					Prueba realizada el {{ $fecha_realizacion_letra }} - solicitada por {{ $candidato_bryg->solicitadaPor()->nombres }} {{ $candidato_bryg->solicitadaPor()->primer_apellido }} {{ $candidato_bryg->solicitadaPor()->segundo_apellido }} @if(!empty($concepto)) y evaluada por nuestro analista de selección {{ $concepto->gestionConceptoNombre->fullname() }} @endif.
				</p>
			</div>
		</section>

		<div class="page-break"></div>

		<section>
			<p class="text-center">
				<b>
					EVIDENCIA FOTOGRÁFICA DURANTE EJECUCIÓN
				</b>
			</p>
		</section>

		<section>
			<div class="text-center">
				@forelse($bryg_fotos as $foto)
					@if(!triRoute::validateOR('local'))
						<img 
							class="m-1" 
							src="{{ asset("recursos_prueba_bryg/prueba_bryg_"."$candidato_bryg->user_id"."_"."$candidato_bryg->req_id"."_"."$candidato_bryg->id/$foto->descripcion") }}" 
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
	</main>

	<footer>
	    <h5>T3RS</h5>
	</footer>
</body>
</html>