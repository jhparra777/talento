<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
	<title>Informe de prueba competencias</title>
	<style>
        @page {
            margin: 0cm 0cm;
            font-family: 'Roboto', sans-serif;
        }

        body {
            margin: 1cm 1cm 1cm;
            font-family: 'Roboto', sans-serif;
        }

        .text-center{ text-align: center; }
        .text-left{ text-align: left; }
        .text-end{ text-align: end; }
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

        .pt-0{ padding-top: 0; }
        .pt-05{ padding-top: 0.5rem; }
        .pt-1{ padding-top: 1rem; }
        .pt-2{ padding-top: 2rem; }
        .pt-3{ padding-top: 3rem; }
        .pt-4{ padding-top: 4rem; }

        .no-list{ list-style: none; }

		.bg-gray{ background-color: #a6a6a6; color: white; }

		.color{ color: #6F3795; }
		.color-sec{ color: #231F20; }

		.br-05{ border-radius: 5px; }

		.fw-600{ font-weight: 600; }
		.fw-700{ font-weight: 700; }

		.page-break{ page-break-after: always; }

		.profile-picture {
			padding: .25rem;
			width: 100px;
			background-color: #fff;
			border: 1px solid #dee2e6;
			border-radius: .25rem;
			max-width: 100%;
		}

		.evidence-picture {
			padding: .25rem;
			width: 220px;
			background-color: #fff;
			border: 1px solid #dee2e6;
			border-radius: .25rem;
			max-width: 100%;
		}

		.divider-hd{ width: 100%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
		.divider-10{ width: 10%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
		.divider-20{ width: 20%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
		.divider-25{ width: 25%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
		.divider-30{ width: 30%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
		.divider-40{ width: 40%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
		.divider-50{ width: 50%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
		.divider-60{ width: 60%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
		.divider-70{ width: 70%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
		.divider-80{ width: 80%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
		.divider-90{ width: 90%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }

		.text-uppercase { text-transform: uppercase; }

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
						<img src="{{ $img_base64_t3rs_without_bg }}" alt="T3RS" width="120">
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
		<h3 class="text-center color-sec">Informe de competencias</h3>

		{{-- Foto de perfil del candidato (si posee) --}}
		<section>
			<div class="text-center">
				@if(!triRoute::validateOR('local'))
					@if(!empty($candidato_prueba->foto_perfil))
						<img 
							src="{{ url("recursos_datosbasicos/$candidato_prueba->foto_perfil") }}" 
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
					<li><b>{{ $candidato_prueba->nombre_completo }}</b></li>
					<li>C.C {{ $candidato_prueba->cedula }}</li>
					<li>{{ $candidato_edad }} años</li>
					<li>{{ $candidato_prueba->celular }}</li>
					<li>{{ $candidato_prueba->correo }}</li>
				</ul>
			</div>
		</section>

		{{-- Datos del requerimiento --}}
		<section>
			<div class="mt-2 mb-3">
				<table class="m-auto" width="70%">
					<tr>
						<th class="text-uppercase color text-left">
							Cargo en el que se evalúa:
						</th>
						<td>
							{{ ucfirst(mb_strtolower($requerimiento_detalle->cargo_req())) }}
						</td>
					</tr>

					<tr>
						<th class="text-uppercase color text-left">
							Requerimiento:
						</th>
						<td>
							{{ $requerimiento_detalle->id }}
						</td>
					</tr>

					<tr>
						<th class="text-uppercase color text-left">
							Cliente:
						</th>
						<td>
							{{ ucfirst($requerimiento_detalle->nombre_cliente_req()) }}
						</td>
					</tr>

					<tr>
						<th class="text-uppercase color text-left">
							Fecha solicitud de prueba:
						</th>
						<td>
							{{ $fecha_evaluacion_letra }}
						</td>
					</tr>
				</table>
			</div>
		</section>

		{{-- Introducción al documento --}}
		<section>
			<div class="text-justify color-sec">
				<p>
					Bienvenido, en {{ ucfirst($requerimiento_detalle->nombre_cliente_req()) }} hemos preparado un informe personalizado referente a la evaluación psicotécnica realizada a {{ $candidato_prueba->nombres }}, quien es uno de los participantes en el proceso de selección.
				</p>

				<p>
					Nuestra prueba psicotécnica Personal Skills evalúa una serie de competencias asociadas al nivel del cargo en el cual el candidato se encuentra cursando su proceso de selección. A continuación vas a encontrar el ajuste al perfil general del candidato y el ajuste por cada una de las competencias evaluadas, junto con la descripción y sus perspectivas comportamentales.
				</p>
			</div>

			{{-- <div class="text-justify color-sec">
				<ul>
					<li>La metodología en la que basamos la prueba se enfoca en la evaluación del comportamiento de Jorge Andrés, no en sus emociones.</li>
					<li>Nuestra prueba revela factores comportamentales, los cuales no pretenden dictaminar estilos correctos o incorrectos, más bien revelará limitaciones y fortalezas.</li>
					<li>Se basa en 4 dimensiones de comportamiento y en una orientación a la adaptabilidad al cargo.</li>
				</ul>
			</div> --}}
		</section>

		{{-- Separar contenido a nueva hoja --}}
		<div class="page-break"></div>

		<section style="margin-bottom: -2rem;">
			<h2 style="color: #6F3795;">AJUSTE DEL CANDIDATO AL PERFIL IDEAL</h2>
			<hr align="right" class="divider-hd" style="margin-top: -.5rem;">
		</section>

		<section style="height: 280px;" style="margin-top: -5rem;">
			<div class="color-sec" style="float: left; width: 50%; display : inline-block;">
				<div class="text-center mt-3">
				<p style="font-size: 16pt;">Ajuste del <br> candidato al perfil</p>

					<div class="m-auto" style="
						margin-top: -3rem;
				        width: 85px;
				        height: 85px;

				        border-radius: 100%;
				        background-color: #6F3795;
				        color: white;
				        text-align: center;

				        font-size: 30pt;
				        font-weight: 700">
				        <p style="padding: 17px 8px 0px 8px;">{{ round($candidato_prueba->ajuste_global) }}%</p>
				    </div>
				</div>

				<div class="text-center" style="margin-left: 2rem; margin-top: -2.5rem;">
					<p style="font-size: 16pt;">Factor de desfase</p>

					<h1 style="margin-top: -2rem;" class="text-center">
						{{ round($candidato_prueba->factor_desfase_global) }}%

                        <img style="margin-top: 1.2rem; margin-left: -1.2rem" src="{{ $img_base64_negativo_positivo }}" width="85">
					</h1>
				</div>
			</div>	

			<div class="text-center mt-2" style="float: right; width: 50%;">
				<img src="{{ $img_base64_barra_circular }}" width="380">

				{{-- @if($candidato_prueba->ajuste_global < 25)
                    <img src="{{ $url."competencia-barra-circular-01.png" }}" width="380">

                @elseif($candidato_prueba->ajuste_global >= 25 && $candidato_prueba->ajuste_global <= 50)
                    <img src="{{ $url."competencia-barra-circular-00.png" }}" width="380">

                @elseif($candidato_prueba->ajuste_global >= 50 && $candidato_prueba->ajuste_global <= 75)

                    @if($candidato_prueba->ajuste_global > 50 && $candidato_prueba->ajuste_global <= 55)
                        <img src="{{ $url."competencia-barra-circular-02.png" }}" width="380">

                    @elseif($candidato_prueba->ajuste_global > 55 && $candidato_prueba->ajuste_global <= 58)
                        <img src="{{ $url."competencia-barra-circular-03.png" }}" width="380">

                    @elseif($candidato_prueba->ajuste_global > 58 && $candidato_prueba->ajuste_global <= 64)
                        <img src="{{ $url."competencia-barra-circular-04.png" }}" width="380">

                    @elseif($candidato_prueba->ajuste_global > 64 && $candidato_prueba->ajuste_global <= 68)
                        <img src="{{ $url."competencia-barra-circular-05.png" }}" width="380">

                    @elseif($candidato_prueba->ajuste_global > 68 && $candidato_prueba->ajuste_global <= 72)
                        <img src="{{ $url."competencia-barra-circular-06.png" }}" width="380">

                    @elseif($candidato_prueba->ajuste_global > 72 && $candidato_prueba->ajuste_global <= 75)
                        <img src="{{ $url."competencia-barra-circular-07.png" }}" width="380">
                    @endif

                @elseif($candidato_prueba->ajuste_global >= 75 && $candidato_prueba->ajuste_global <= 100)

                    @if($candidato_prueba->ajuste_global > 75 && $candidato_prueba->ajuste_global <= 78)
                        <img src="{{ $url."competencia-barra-circular-08.png" }}" width="380">

                    @elseif($candidato_prueba->ajuste_global > 78 && $candidato_prueba->ajuste_global <= 80)
                        <img src="{{ $url."competencia-barra-circular-09.png" }}" width="380">

                    @elseif($candidato_prueba->ajuste_global > 80 && $candidato_prueba->ajuste_global <= 84)
                        <img src="{{ $url."competencia-barra-circular-10.png" }}" width="380">

                    @elseif($candidato_prueba->ajuste_global > 84 && $candidato_prueba->ajuste_global <= 94)
                        <img src="{{ $url."competencia-barra-circular-11.png" }}" width="380">

                    @elseif($candidato_prueba->ajuste_global > 94 && $candidato_prueba->ajuste_global <= 100)
                        <img src="{{ $url."competencia-barra-circular-12.png" }}" width="380">
                    @endif
                @endif --}}
			</div>
		</section>

		{{-- Referencia puntaje --}}
		<section style="margin-top: -2rem;">
			<div class="text-center">
				<img src="{{ $img_base64_referencia_puntaje }}" width="360">
			</div>
		</section>

		{{-- Competencias observaciones --}}
		<section style="margin-top: -5rem;">
			<table width="100%">
				<tr>
					<td width="50%">
						<h3 style="color: #6F3795;">COMPETENCIAS <br> SOBRESALIENTES</h3>
						<hr align="right" class="divider-90" style="margin-top: -1rem;">
					</td>

					<td width="50%">
						<h3 style="color: #6F3795;">COMPETENCIAS <br> BASE</h3>
						<hr align="right" class="divider-90" style="margin-top: -1rem;">
					</td>
				</tr>

				<tr>
					<td width="50%">
						<p class="color fw-700" style="font-size: 14pt;">{{ $sobresalientesDesc[$sobresalienteA[0]] }}</p>

						<div style="width: 90%;">
							<p class="color-sec text-justify" style="font-size: 10pt;">
								{{ $sobresalientesDefinicion[$sobresalienteA[0]] }}
							</p>
						</div>

						<div>
							<img src="{{ $img_base64_barra_turned_sobresalienteA }}" width="100">

							{{-- @if($sobresalienteA[0] > 0 && $sobresalienteA[0] <= 24)
								<img src="{{ $url."competencias-graf-turned-1.png" }}" width="100">

							@elseif($sobresalienteA[0] >= 25 && $sobresalienteA[0] <= 50)
								<img src="{{ $url."competencias-graf-turned-2.png" }}" width="100">

							@elseif($sobresalienteA[0] > 50 && $sobresalienteA[0] <= 75)
								<img src="{{ $url."competencias-graf-turned-3.png" }}" width="100">

							@elseif($sobresalienteA[0] > 75 && $sobresalienteA[0] <= 100)
								<img src="{{ $url."competencias-graf-turned-4.png" }}" width="100">
							@endif --}}

							<p class="color-sec" style="font-size: 11pt; margin-top: -1.6rem; margin-left: 7rem;">
								<b>{{ substr($sobresalienteA[0], 0, 2) }}%</b>
							</p>
						</div>
					</td>

					<td width="50%">
						<p class="color fw-700" style="font-size: 14pt;">{{ $sobresalientesDesc[$desarrollarA[0]] }}</p>

						<div style="width: 90%;">
							<p class="color-sec text-justify" style="font-size: 10pt;">
								{{ $sobresalientesDefinicion[$desarrollarA[0]] }}
							</p>
						</div>

						<div>
							<img src="{{ $img_base64_barra_turned_desarrollarA }}" width="100">

							{{-- @if($desarrollarA[0] > 0 && $desarrollarA[0] <= 24)
								<img src="{{ $url."competencias-graf-turned-1.png" }}" width="100">

							@elseif($desarrollarA[0] >= 25 && $desarrollarA[0] <= 50)
								<img src="{{ $url."competencias-graf-turned-2.png" }}" width="100">

							@elseif($desarrollarA[0] > 50 && $desarrollarA[0] <= 75)
								<img src="{{ $url."competencias-graf-turned-3.png" }}" width="100">

							@elseif($desarrollarA[0] > 75 && $desarrollarA[0] <= 100)
								<img src="{{ $url."competencias-graf-turned-4.png" }}" width="100">
							@endif --}}

							<p class="color-sec" style="font-size: 11pt; margin-top: -1.6rem; margin-left: 7rem;">
								<b>{{ substr($desarrollarA[0], 0, 2) }}%</b>
							</p>
						</div>
					</td>
				</tr>

				<tr>
					<td width="50%">
						<p class="color fw-700" style="font-size: 14pt;">{{ $sobresalientesDesc[$sobresalienteB[0]] }}</p>

						<div style="width: 90%;">
							<p class="color-sec text-justify" style="font-size: 10pt;">
								{{ $sobresalientesDefinicion[$sobresalienteB[0]] }}
							</p>
						</div>

						<div>
							<img src="{{ $img_base64_barra_turned_sobresalienteB }}" width="100">

							{{-- @if($sobresalienteB[0] > 0 && $sobresalienteB[0] <= 24)
								<img src="{{ $url."competencias-graf-turned-1.png" }}" width="100">

							@elseif($sobresalienteB[0] >= 25 && $sobresalienteB[0] <= 50)
								<img src="{{ $url."competencias-graf-turned-2.png" }}" width="100">

							@elseif($sobresalienteB[0] > 50 && $sobresalienteB[0] <= 75)
								<img src="{{ $url."competencias-graf-turned-3.png" }}" width="100">

							@elseif($sobresalienteB[0] > 75 && $sobresalienteB[0] <= 100)
								<img src="{{ $url."competencias-graf-turned-4.png" }}" width="100">
							@endif --}}

							<p class="color-sec" style="font-size: 11pt; margin-top: -1.6rem; margin-left: 7rem;">
								<b>{{ substr($sobresalienteB[0], 0, 2) }}%</b>
							</p>
						</div>
					</td>

					<td width="50%">
						<p class="color fw-700" style="font-size: 14pt;">{{ $sobresalientesDesc[$desarrollarB[0]] }}</p>

						<div style="width: 90%;">
							<p class="color-sec text-justify" style="font-size: 10pt;">
								{{ $sobresalientesDefinicion[$desarrollarB[0]] }}
							</p>
						</div>

						<div>
							<img src="{{ $img_base64_barra_turned_desarrollarB }}" width="100">

							{{-- @if($desarrollarB[0] > 0 && $desarrollarB[0] <= 24)
								<img src="{{ $url."competencias-graf-turned-1.png" }}" width="100">

							@elseif($desarrollarB[0] >= 25 && $desarrollarB[0] <= 50)
								<img src="{{ $url."competencias-graf-turned-2.png" }}" width="100">

							@elseif($desarrollarB[0] > 50 && $desarrollarB[0] <= 75)
								<img src="{{ $url."competencias-graf-turned-3.png" }}" width="100">

							@elseif($desarrollarB[0] > 75 && $desarrollarB[0] <= 100)
								<img src="{{ $url."competencias-graf-turned-4.png" }}" width="100">
							@endif --}}

							<p class="color-sec" style="font-size: 11pt; margin-top: -1.6rem; margin-left: 7rem;">
								<b>{{ substr($desarrollarB[0], 0, 2) }}%</b>
							</p>
						</div>
					</td>
				</tr>
			</table>
		</section>

		{{-- Separar contenido a nueva hoja --}}
		<div class="page-break"></div>

		{{-- DESCRIPCIÓN DE COMPETENCIAS --}}
		<section>
			<h2 style="color: #6F3795;">DESCRIPCIÓN DE COMPETENCIAS</h2>
			<hr align="right" class="divider-hd" style="margin-top: -.5rem;">
		</section>

		<section class="mt-1">
			<?php
				$competenciasCount = count($totales_prueba);
				$cont = 0;
			?>

			@foreach($totales_prueba as $key => $total)
				<div>
					<p class="color fw-700" style="font-size: 12pt;">{{ $total->descripcion }}</p>
					<hr align="right" class="divider-25" style="margin-top: -.6rem;">
				</div>

				<div class="m-auto color-sec" style="width: 95%;">
					<p class="text-justify">
						{{ $total->definicion }}
					</p>
				</div>

				<table width="100%">
					<tr>
						<td>
							{{-- Puntajes --}}
							<table style="margin-left: 6rem; margin-bottom: 1rem;" width="100%">
								<tr>
									<td width="60%">
										@if($configuracionPrueba[$key]['competencia_id'] == $total->competencia_id)
											{{ $configuracionPrueba[$key]['nivel_esperado'] }}
										@endif
									</td>
									<td>
										{{ round($total->ajuste_perfil) }}
									</td>
								</tr>
							</table>

							{{--Gráficos --}}
							@if($configuracionPrueba[$key]['nivel_esperado'] >= 0 && $configuracionPrueba[$key]['nivel_esperado'] <= 50)
								<img src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-ideal-1.txt') }}" width="25" style="margin-left: 6rem; margin-top: .5rem">

							@elseif($configuracionPrueba[$key]['nivel_esperado'] > 50 && $configuracionPrueba[$key]['nivel_esperado'] <= 75)
								<img src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-ideal-2.txt') }}" width="25" style="margin-left: 6rem; margin-top: .5rem">

							@elseif($configuracionPrueba[$key]['nivel_esperado'] > 75 && $configuracionPrueba[$key]['nivel_esperado'] <= 100)
								<img src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-ideal-3.txt') }}" width="25" style="margin-left: 6rem; margin-top: .5rem">
							@else
								<img src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-ideal-3.txt') }}" width="25" style="margin-left: 6rem; margin-top: .5rem">
							@endif

							@if($total->ajuste_perfil >= 0 && $total->ajuste_perfil <= 50)
								<img src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-obtenido-1.txt') }}" width="25" style="margin-left: 6rem; margin-top: .5rem;">

							@elseif($total->ajuste_perfil > 50 && $total->ajuste_perfil <= 75)
								<img src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-obtenido-2.txt') }}" width="25" style="margin-left: 6rem; margin-top: .5rem;">

							@elseif($total->ajuste_perfil > 75 && $total->ajuste_perfil <= 100)
								<img src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-obtenido-3.txt') }}" width="25" style="margin-left: 6rem; margin-top: .5rem;">
							@else
								<img src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-obtenido-3.txt') }}" width="25" style="margin-left: 6rem; margin-top: .5rem;">
							@endif

							{{-- Labels --}}
							<table style="margin-left: 5.5rem; margin-top: -1rem;" width="100%">
								<tr>
									<td width="50%">
										Ideal
									</td>
									<td>
										Obtenido
									</td>
								</tr>
							</table>
						</td>

						{{-- Ajuste y desfase 
						<td>
							<div class="text-center mt-1" style="margin-right: 0rem;">
								<p style="font-size: 11pt;">Ajuste del <br> candidato al perfil</p>

							    <img style="margin-top: -.8rem; margin-bottom: 2rem;" src="https://ui-avatars.com/api/name={{ round($total->ajuste_perfil) }}&size=58&background=6F3795&color=fff&font-size=0.54&length=3&rounded=true&bold=true" alt="">
							</div>

							<div class="text-center" style="margin-left: 1rem; margin-top: -2.5rem; margin-right: 0rem;">
								<p style="font-size: 11pt;">Factor de desfase</p>

								<h3 style="margin-top: -2rem;" class="text-center">
									@if (round($total->desfase) > 10)
										10%
									@elseif(round($total->desfase) < -10)
										-10%
									@else
										{{ round($total->desfase) }}%
									@endif

									@if($total->desfase < 0)
			                            <img 
			                            	style="margin-top: 1.1rem; margin-left: -1.2rem" 
			                            	src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-negativo.txt') }}" 
			                            	width="60">
			                        @else
			                        	<img 
			                        		style="margin-top: 1.1rem; margin-left: -1.2rem" 
			                        		src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-positivo.txt') }}" 
			                        		width="60">
			                        @endif
								</h3>
							</div>
						</td> --}}

						{{-- Ajuste al perfil básico --}}
						<td>
							<?php
								$ajuste_basico = round($total->ajuste_perfil) * 100;
								$total_basico = $ajuste_basico / $configuracionPrueba[$key]['nivel_esperado'];

								$factor_aprobacion = $total->ajuste_perfil - $configuracionPrueba[$key]['nivel_esperado'];
							?>

							<div class="text-center mt-1" style="margin-right: 4rem;">
								<p style="font-size: 11pt;">Ajuste del <br> candidato al perfil básico</p>

								@if (floor($total_basico) > 100)
									<img style="margin-top: -.8rem; margin-bottom: 2rem;" src="https://ui-avatars.com/api/name={{ '100' }}&size=58&background=6F3795&color=fff&font-size=0.54&length=3&rounded=true&bold=true" alt="">
								@else
									<img style="margin-top: -.8rem; margin-bottom: 2rem;" src="https://ui-avatars.com/api/name={{ floor($total_basico) }}&size=58&background=6F3795&color=fff&font-size=0.54&length=3&rounded=true&bold=true" alt="">
								@endif
							</div>

							<div class="text-center" style="margin-left: 1rem; margin-top: -2.5rem; margin-right: 4rem;">
								<p style="font-size: 11pt;">Factor de aprobación</p>

								<h3 style="margin-top: -2rem;" class="text-center">
									@if(++$cont === $competenciasCount)
										<?php $last = $factor_aprobacion; ?>

										{{ $last }}%
									@else
										@if (round($factor_aprobacion) >= 10)
											> 10%
										@elseif(round($factor_aprobacion) <= -10)
											< -10%
										@else
											{{ $factor_aprobacion }}%
										@endif
									@endif

									@if( (int) $factor_aprobacion < 0)
										<img 
											style="margin-top: 1.1rem; margin-left: -1.2rem" 
											src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-negativo.txt') }}" 
											width="60">
									@else
										<img 
											style="margin-top: 1.1rem; margin-left: -1.2rem" 
											src="{{ file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-positivo.txt') }}" 
											width="60">
									@endif
								</h3>
							</div>
						</td>
					</tr>
				</table>
			@endforeach
		</section>

		{{-- Separar contenido a nueva hoja --}}
		<div class="page-break"></div>

		<section>
			<h2 style="color: #6F3795;">INSIGHTS</h2>
			<hr align="right" class="divider-hd" style="margin-top: -.5rem;">
		</section>

		<section>
			<h3 class="color text-center">Perspectivas comportamentales referentes a <br> las competencias laborales evaluadas</h3>

			<div class="m-auto color-sec" style="width: 95%;">
				<?php
					$insights = [
						'Siempre modifica su comportamiento efectivamente ante necesidades del contexto.',
						'Con frecuencia propone acciones para responder a demandas específicas del contexto.',
						'Algunas veces adapta procesos de forma rápida y eficiente para solucionar problemas repentinos.',

						'Siempre distribuye su tiempo efectivamente para cumplir con los resultados esperados.',
						'Con frecuencia diseña un plan para garantizar el cumplimiento de metas.',
						'Con frecuencia verifica el cumplimiento de cada tarea asignada y la calidad del resultado.',

						'Algunas veces ofrece soluciones proactivamente ante necesidades de mejora.',
						'Algunas veces delega tareas o procesos a miembros del equipo para el cumplimiento de las metas de la organización.',
						'Con frecuencia identifica y exalta los aportes que realizan los miembros del equipo.',

						'Siempre utiliza los protocolos para solucionar necesidades o requerimientos de los usuarios.',
						'Algunas veces anticipa los puntos críticos en el mediano y largo plazo para asegurar la calidad de los procesos.',
						'Siempre mantiene su atención al interactuar con cualquier interlocutor.',

						'Con frecuencia transmite explicaciones de forma precisa.',
						'Algunas veces establece contacto visual con el interlocutor.',
						'Algunas veces transmite explicaciones de forma precisa.',

						'Con frecuencia pide ayuda a otros miembros del equipo para cumplir con los objetivos establecidos.',
						'Algunas veces ayuda a sus compañeros con la consecución de sus objetivos.',
						'Con frecuencia complementa las habilidades del grupo con las propias para cumplir con los objetivos establecidos.'
					];
				?>

				@foreach($totales_prueba as $key => $total)
					<div>
						<p class="color fw-700" style="font-size: 12pt;">{{ $total->descripcion }}</p>
						<hr align="right" class="divider-25" style="margin-top: -.6rem;">
					</div>

					<p class="text-justify">
						{{ $insights[$key] }}
					</p>
				@endforeach
			</div>
		</section>

		@if(!empty($concepto))
			{{-- Separar contenido a nueva hoja --}}
			<div class="page-break"></div>

			<section>
				<h2 style="color: #6F3795;">CONCEPTO FINAL DEL ESPECIALISTA DE SELECCIÓN</h2>
				<hr align="right" class="divider-hd" style="margin-top: -.5rem;">
			</section>

			<section>
				<div class="m-auto" style="width: 95%;">
					<p class="text-justify color-sec">
						{!! ucfirst($concepto->concepto) !!}
					</p>

					<table width="100%" class="mb-1">
						<tr>
							<th class="color text-left">Nombre del especialista:</th>
							<td class="text-left">{{ $concepto->gestionConceptoNombre->fullname() }}</td>

							<th class="color text-left">Fecha:</th>
							<td class="text-left">{{ $fecha_realizacion_letra }}</td>
						</tr>
					</table>
				</div>
			</section>
		@endif

		<div class="page-break"></div>

		<section>
			<h2 style="color: #6F3795;">EVIDENCIA FOTOGRÁFICA DURANTE EJECUCIÓN</h2>
			<hr align="right" class="divider-hd" style="margin-top: -.5rem;">
		</section>

		<section>
			<div class="text-center">
				@forelse($pskills_fotos as $key => $foto)
	                @if(!triRoute::validateOR('local'))
	                	<img 
	                        class="m-1 evidence-picture" 
	                        src="{{ asset("recursos_prueba_ps/prueba_ps_"."$candidato_prueba->user_id"."_"."$candidato_prueba->req_id"."_"."$candidato_prueba->id/$foto->descripcion") }}" 
	                        alt="Foto candidato prueba"
	                        width="220">

						<div style="margin-top: -1rem; font-size: 8pt; color: gray;">{{ $foto->created_at }}</div>
					@else
						<img class="m-1 evidence-picture" src="https://picsum.photos/640/420" alt="T3RS" width="220">
						<div style="margin-top: -1rem; font-size: 8pt; color: gray;">2021-05-16 14:04:06</div>
					@endif

					<?php
						if ($key === 7) {
							break;
						}
					?>
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