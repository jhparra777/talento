<!DOCTYPE html>
<html lang="en">
<head>
	@if(triRoute::validateOR('local'))
		<?php set_time_limit(300); ?>
	@endif
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
	<title>Informe de prueba Psicotécnica virtual Ethical Values</title>

	<script src="https://kit.fontawesome.com/a23970da56.js" crossorigin="anonymous"></script>

	<style>
        @page {
            margin: 0.8cm 0.8cm;
            font-family: 'Roboto', sans-serif;
        }

        body {
            margin: 1cm 2cm 2cm;
            font-family: 'Roboto', sans-serif;
            background-color: #f1f1f1;
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

		.bg-purple{ background-color: #722E87; color: white; }
		.bg-blue{ background-color: #2E2D66; color: white; }
		.bg-dark-blue{ background-color: #2c3e50; color: white; }
		.bg-red{ background-color: #D92428; color: white; }
		.bg-yellow{ background-color: #E4E42A; color: white; }
		.bg-green{ background-color: #00A954; color: white; }

		.color-purple{ color: #722E87; }
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

		.al-vm {
			vertical-align: middle;
		}

		h2, h3 {
			color: #722E87;
		}

		h3 {
			margin-bottom: 5px !important;
		}

		.divider{ width: 44.5%; background-color: #722E87; color: #722E87; border: 0; height: 1px; }
		.divider-th{ width: 90%; background-color: #722E87; color: #722E87; border: 0; height: 1px; }

		.divider-short{ width: 15%; background-color: #722E87; color: #722E87; border: 0; height: 1px; }

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

        main {
        	width: 80%;
			margin: auto;

			padding: 1rem;
			border-radius: 1rem;
			border: solid 1px #ddd;
        	background-color: white;
        }

        @media print {
            main {
                width: 100%;

				padding: 0rem;
				border-radius: 0rem;
				border: none;
				background-color: none;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-bottom: 80px !important;
            }
            .section-descarga {
                display: none;
            }
            body {
            	background-color: transparent !important;
            }
        }

        .mx-100 {
        	margin-left: 100px;
        	margin-right: 100px;
        }

		.btn {
			display: inline-block;
			margin-bottom: 0;
			font-weight: 400;
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;
			-ms-touch-action: manipulation;
			touch-action: manipulation;
			cursor: pointer;
			background-image: none;
			border: 1px solid transparent;
				border-top-color: transparent;
				border-right-color: transparent;
				border-bottom-color: transparent;
				border-left-color: transparent;
			padding: 6px 12px;
			font-size: 14px;
			line-height: 1.42857143;
			border-radius: 4px;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		.btn-default:hover {
			color: #333;
			background-color: #e6e6e6;
			border-color: #adadad;
		}

		.btn:hover {
			text-decoration: none;
		}
    </style>
</head>
<body>
	<div class="section-descarga mx-100" style="border: solid 1px #ddd; width: 80%; background-color: white; padding: 1rem; border-radius: 1rem; margin-bottom: 1rem; margin-top: 1rem;">
		<div class="text-right">
			<button class="btn btn-default" onclick="window.print()">Descargar PDF <i class="fas fa-download"></i></button>
		</div>
	</div>

	<main class="mx-100">
		{{-- Logos T3RS y cliente --}}
		<section>
			<table width="100%">
				<tr>
					<td class="text-left">
						<img src="https://img-t3rsc.s3.amazonaws.com/t3rs-src/tri-new-logo-horizontal-letter.png" alt="T3RS" width="100">
					</td>
					<td></td>
					<td class="text-right">
						@if(!triRoute::validateOR('local'))
							<img src="{{ asset("configuracion_sitio/$sitio_informacion->logo") }}" alt="T3RS" height="60">
						@else
							<img src="https://picsum.photos/120/60" alt="T3RS" height="60">
						@endif
					</td>
				</tr>
			</table>
		</section>

		{{-- Titulo del documento --}}
		<h4 class="text-center">Informe de prueba Psicotécnica virtual Ethical Values</h4>

		{{-- Foto de perfil del candidato (si posee) --}}
		<section>
			<div class="text-center">
				@if(!triRoute::validateOR('local'))
					@if(!empty($candidato_valores->foto_perfil))
						<img 
							src="{{ url("recursos_datosbasicos/$candidato_valores->foto_perfil") }}" 
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
					<li><b>{{ $candidato_valores->nombre_completo }}</b></li>
					<li>C.C {{ $candidato_valores->cedula }}</li>
					<li>{{ $candidato_edad }} años</li>
					<li>{{ $candidato_valores->celular }}</li>
					<li>{{ $candidato_valores->correo }}</li>
				</ul>
			</div>
		</section>

		{{-- Datos del requerimiento --}}
		<section>
			<div class="mt-1">
				<table width="100%">
					<tr>
						<th class="text-left" width="50%">
							<p class="color-purple m-0">
								Cargo en el que se evalúa
								<hr align="left" class="divider-th">
							</p>
							<p class="ml-2" style="margin-top: -5px; font-weight: initial;">{{ ucfirst(mb_strtolower($requerimiento_detalle->cargo_req())) }}</p>
						</th>

						<th class="text-left" width="50%">
							<p class="color-purple m-0">
								Requerimiento
								<hr align="left" class="divider-th">
							</p>
							<p class="ml-2" style="margin-top: -5px; font-weight: initial;">{{ $requerimiento_detalle->id }}</p>
						</th>
					</tr>
				</table>

				<p class="color-purple m-0">
					<b>Cliente</b>
					<hr align="left" class="divider">
				</p>
				<p class="ml-2" style="margin-top: -5px;">{{ ucfirst($requerimiento_detalle->nombre_cliente_req()) }}</p>

				<p class="color-purple m-0">
					<b>Fecha solicitud de prueba</b>
					<hr align="left" class="divider">
				</p>
				<p class="ml-2" style="margin-top: -5px;">{{ $fecha_evaluacion_letra }}</p>
			</div>
		</section>

		{{-- Introducción al documento --}}
		<section>
			<div class="text-justify">
				<p>
					Bienvenido, en {{ ucfirst($requerimiento_detalle->nombre_cliente_req()) }} hemos preparado un informe personalizado referente a la evaluación psicotécnica realizada a {{ $candidato_valores->nombre_completo }}, quien es uno de los participantes en el proceso. Para un mejor entendimiento de los resultados te resaltamos las principales características sobre las cuales nos basamos:
				</p>
			</div>
		</section>

		<section>
			<div class="text-justify">
				<ul>
					<li>
						La metodología en la que basamos la prueba se enfoca en la evaluación del comportamiento de {{ $candidato_valores->nombre_completo }}, no en sus emociones.
					</li>

					<li>
						Nuestra prueba revela factores comportamentales, los cuales no pretenden dictaminar estilos correctos o incorrectos, más bien revelará limitaciones y fortalezas.
					</li>

					<li>
						Se basa en 5 dimensiones de comportamiento y en una orientación a la adaptabilidad al cargo.
					</li>

					<li>
						La prueba evaluó 30 preguntas para determinar el comportamiento predominante en {{ $candidato_valores->nombre_completo }}, por lo cual a continuación mostramos los resultados.
					</li>
				</ul>
			</div>
		</section>

		{{-- Separar contenido a nueva hoja --}}
		<div class="page-break"></div>

		{{-- Resultado mini tabla Ethical Values --}}
		<section>
			<div class="mt-2 mb-3">
				<h2>AJUSTE DEL CANDIDATO AL PERFIL IDEAL</h2>
				<hr class="divider-th">
			</div>
		</section>

		{{-- Gráfico de radar Ethical Values --}}
		<section>
			<table width="100%">
				<tr>
					<td class="text-center" width="60%">
						<img src="https://quickchart.io/chart?c={{ json_encode($grafico_radar_valores) }}" width="460">
					</td>
					<td class="text-center" width="40%">
						<h4>Ajuste del Candidato al Perfil</h4>
						<?php
							$promedio_porc_ideal = round(($valores_ideal_grafico['amor'] + $valores_ideal_grafico['no_violencia'] + $valores_ideal_grafico['paz'] + $valores_ideal_grafico['rectitud'] + $valores_ideal_grafico['verdad']) / 5);
							$promedio_porc = round(($porcentaje_valores_obtenidos['amor'] + $porcentaje_valores_obtenidos['no_violencia'] + $porcentaje_valores_obtenidos['paz'] + $porcentaje_valores_obtenidos['rectitud'] + $porcentaje_valores_obtenidos['verdad']) / 5);

							$dif_porc = $promedio_porc - $promedio_porc_ideal;

							$grafica = $candidato_valores->graficaRadial($promedio_porc)
						?>
						<img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="200">
					<!--	<h4>Factor de desfase</h4>
						@if ($dif_porc >= 0)
							<h4 class="mt-0 mb-0"><p>{{ $dif_porc }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="60"></p></h4>
						@else
							<h4 class="mt-0 mb-0"><p>{{ $dif_porc * -1 }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="60"></p></h4>
						@endif-->
					</td>
				</tr>
			</table>
			<div class="text-center">
				<img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-referencia-puntaje.png" width="300">
			</div>
		</section>

		{{-- Separar contenido a nueva hoja --}}
		<div class="page-break"></div>

		{{-- Explicación gráfico Ethical Values --}}
		<section>
			<h2>RESULTADOS CUANTITATIVOS</h2>
			<hr class="divider-th">
			<br>
		</section>

		<section>
			<h3>AMOR</h3>
			<hr align="left" class="divider-short">
			<div class="text-justify">
				<p>
					Es una virtud que representa todo el afecto, la bondad y la compasión del ser humano. Es la fuerza que nos impulsa para hacer las cosas bien. El amor es un sentimiento moral, pues nos induce a actuar bien en nuestra vida y con la sociedad.<br>
					Este valor tiene las siguientes cualidades asociadas.
				</p>
				<ul>
					<li>
						Bondad. <br>
						Es la tendencia natural a hacer el bien, Se identifica con la característica propia de las buenas personas.
					</li>
					<li>
						Simpatía. <br>
						La capacidad de percibir y sentir directamente, de manera que se experimenta cómo siente las emociones otra persona. La simpatía implica afinidad, inclinación mutua y amabilidad.
					</li>
					<li>
						Devoción. <br>
						Sentimiento de profundo respeto y admiración inspirado por la dignidad, la virtud o los méritos de una persona, una institución, una causa.
					</li>
				</ul>
			</div>

			<table width="100%">
				<tr>
					<td class="text-center">
						<?php $grafica = $candidato_valores->graficaBarras($valores_ideal_grafico['amor'], $porcentaje_valores_obtenidos['amor']) ?>
						<img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="400">
					</td>
					<td class="text-center">
						<h4>Ajuste del Candidato al Perfil</h4>
						<?php $grafica = $candidato_valores->graficaRadial($porcentaje_valores_obtenidos['amor']) ?>
						<img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="200">
						<!--<h4>Factor de desfase</h4>
						@if ($porcentajes_cruzados['amor'] >= 0)
							<h4 class="mt-0 mb-0"><p>{{ $porcentajes_cruzados['amor'] }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="60"></p></h4>
						@else
							<h4 class="mt-0 mb-0"><p>{{ $porcentajes_cruzados['amor'] * -1 }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="60"></p></h4>
						@endif-->
					</td>
				</tr>
			</table>
		</section>

		<section>
			<h3>NO VIOLENCIA</h3>
			<hr align="left" class="divider-short">
			<div class="text-justify">
				<p>
					Es una ideología que rechaza el uso de la violencia y la agresión, se opone al uso de la violencia como un medio (método de protesta, práctica de lucha social, o como respuesta a la misma violencia) y como fin.<br>
					Este valor tiene las siguientes cualidades asociadas.
				</p>
				<ul>
					<li>
						Amor universal. <br>
    					Presupone una escala de valores superior a nuestra espontaneidad. Transforma la convivencia con actitud generosa. Es decir, responde a la maldad, no con sus mismas armas sino con el amor como causa de actuación.
    				</li>
    				<li>
    					Ecología. <br>
    					Nos hace considerar y actuar en favor de la protección del medio ambiente, los recursos naturales y toda forma de vida, incluyendo la propia.
    				</li>
				</ul>
			</div>

			<table width="100%">
				<tr>
					<td class="text-center">
						<?php $grafica = $candidato_valores->graficaBarras($valores_ideal_grafico['no_violencia'], $porcentaje_valores_obtenidos['no_violencia']) ?>
						<img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="400">
					</td>
					<td class="text-center">
						<h4>Ajuste del Candidato al Perfil</h4>
						<?php $grafica = $candidato_valores->graficaRadial($porcentaje_valores_obtenidos['no_violencia']) ?>
						<img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="200">
					<!--	<h4>Factor de desfase</h4>
						@if ($porcentajes_cruzados['no_violencia'] >= 0)
							<h4 class="mt-0 mb-0"><p>{{ $porcentajes_cruzados['no_violencia'] }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="60"></p></h4>
						@else
							<h4 class="mt-0 mb-0"><p>{{ $porcentajes_cruzados['no_violencia'] * -1 }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="60"></p></h4>
						@endif-->
					</td>
				</tr>
			</table>
		</section>

		<section>
			<h3>PAZ</h3>
			<hr align="left" class="divider-short">
			<div class="text-justify">
				<p>
					La paz es un estado de bienestar, tranquilidad, estabilidad y seguridad, que es opuesto a la guerra y tiene una connotación positiva. Es un estado de armonía que está libre de guerras, conflictos y contratiempos, es la capacidad de los seres humanos de vivir en calma, con una sana convivencia social.<br>
					Este valor tiene las siguientes cualidades asociadas. 
				</p>
				<ul>
					<li>
						Autocontrol. <br>
						Se define como aquellos procedimientos que enseñan estrategias para controlar o modificar la conducta, a través de distintas situaciones, con el propósito de alcanzar metas a largo plazo.
					</li>
					<li>
						Paciencia. <br>
						Es la actitud que lleva al ser humano a poder soportar contratiempos y dificultades para conseguir algún bien.
					</li>
					<li>
						Optimismo. <br>
						Es la actitud o tendencia de ver y juzgar las cosas en su aspecto positivo, o más favorable.
					</li>
				</ul>
			</div>

			<table width="100%">
				<tr>
					<td class="text-center">
						<?php $grafica = $candidato_valores->graficaBarras($valores_ideal_grafico['paz'], $porcentaje_valores_obtenidos['paz']) ?>
						<img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="400">
					</td>
					<td class="text-center">
						<h4>Ajuste del Candidato al Perfil</h4>
						<?php $grafica = $candidato_valores->graficaRadial($porcentaje_valores_obtenidos['paz']) ?>
						<img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="200">
						<!--<h4>Factor de desfase</h4>
						@if ($porcentajes_cruzados['paz'] >= 0)
							<h4 class="mt-0 mb-0"><p>{{ $porcentajes_cruzados['paz'] }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="60"></p></h4>
						@else
							<h4 class="mt-0 mb-0"><p>{{ $porcentajes_cruzados['paz'] * -1 }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="60"></p></h4>
						@endif-->
					</td>
				</tr>
			</table>
		</section>

		<section>
			<h3>RECTITUD</h3>
			<hr align="left" class="divider-short">
			<div class="text-justify">
				<p>
					La rectitud es un valor y una cualidad, es una manera de ser y de vivir, marcado por la coherencia con uno mismo; es la solidez del carácter y la estructura de nuestra conciencia.<br>
					Este valor tiene las siguientes cualidades asociadas.
				</p>
				<ul>
					<li>
						Obediencia. <br>
						El término obediencia (con origen en el latín oboedientĭa), está relacionado con el acto de obedecer (es decir, de respetar, acatar y cumplir la voluntad de la autoridad o de quien ejerce el mando). El concepto contempla la subordinación de la voluntad individual a una figura de autoridad, que puede ser tanto un individuo como un grupo o un concepto.
					</li>
					<li>
						Deber. <br>
						El deber supone una obligación, frente a otra parte, que por el contrario, tiene un derecho. 
					</li>
					<li>
						Puntualidad. <br>
						La puntualidad es la cualidad de una persona de tener cuidado y diligencia en realizar las cosas a su debido tiempo.
					</li>
					<li>
						Autoayuda. <br> 
						Es el soporte que una persona se brinda a sí misma, para afrontar una situación difícil o cultivar una sensación de bienestar personal. Se caracteriza por prescindir de la supervisión de terceros Su objetivo es adquirir recursos útiles y desarrollar habilidades aplicables a la vida diaria, principalmente en el área emocional.
					</li>
				</ul>
			</div>

			<table width="100%">
				<tr>
					<td class="text-center">
						<?php $grafica = $candidato_valores->graficaBarras($valores_ideal_grafico['rectitud'], $porcentaje_valores_obtenidos['rectitud']) ?>
						<img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="400">
					</td>
					<td class="text-center">
						<h4>Ajuste del Candidato al Perfil</h4>
						<?php $grafica = $candidato_valores->graficaRadial($porcentaje_valores_obtenidos['rectitud']) ?>
						<img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="200">
						<!--<h4>Factor de desfase</h4>
						@if ($porcentajes_cruzados['rectitud'] >= 0)
							<h4 class="mt-0 mb-0"><p>{{ $porcentajes_cruzados['rectitud'] }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="60"></p></h4>
						@else
							<h4 class="mt-0 mb-0"><p>{{ $porcentajes_cruzados['rectitud'] * -1 }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="60"></p></h4>
						@endif-->
					</td>
				</tr>
			</table>
		</section>

		<section>
			<h3>VERDAD</h3>
			<hr align="left" class="divider-short">
			<div class="text-justify">
				<p>
					La verdad es un valor ético, da sentido al respeto ante los demás hombres, ante una sociedad, ante uno mismo. Es el pilar básico donde se orienta la conciencia moral y abarca la confianza a esa sociedad; donde todos nos necesitamos para vivir en verdad.<br>
					Este valor tiene las siguientes cualidades asociadas. 
				</p>
				<ul>
					<li>
						Veracidad. <br>
						La veracidad es la cualidad de lo que es verdadero o veraz, y está conforme con la verdad y se ajusta a ella. Es un valor moral positivo que busca la verdad.
					</li>
					<li>
						Curiosidad. <br>
						La curiosidad es cualquier comportamiento instintivo natural, evidente por la observación y es el aspecto emocional que engendra la exploración, la investigación, y el aprendizaje.
					</li>
					<li>
						Espíritu de investigación. <br>
						El espíritu científico es una actitud determinada hacia las ideas y la información así como una forma concreta de evaluar las mismas
					</li>
					<li>
						Autoanálisis. <br>
						Es un ejercicio de introspección, autoevaluación y autovaloración que te permitirá lograr un conocimiento más preciso de sí mismo, de tus conocimientos, capacidades, habilidades y destrezas.
					</li>
				</ul>
			</div>

			<table width="100%">
				<tr>
					<td class="text-center">
						<?php $grafica = $candidato_valores->graficaBarras($valores_ideal_grafico['verdad'], $porcentaje_valores_obtenidos['verdad']) ?>
						<img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="400">
					</td>
					<td class="text-center">
						<h4>Ajuste del Candidato al Perfil</h4>
						<?php $grafica = $candidato_valores->graficaRadial($porcentaje_valores_obtenidos['verdad']) ?>
						<img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="200">
					<!--	<h4>Factor de desfase</h4>
						@if ($porcentajes_cruzados['verdad'] >= 0)
							<h4 class="mt-0 mb-0"><p>{{ $porcentajes_cruzados['verdad'] }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="60"></p></h4>
						@else
							<h4 class="mt-0 mb-0"><p>{{ $porcentajes_cruzados['verdad'] * -1 }}% <img class="al-vm" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="60"></p></h4>
						@endif-->
					</td>
				</tr>
			</table>
		</section>


		<section>
			<h2>RESULTADOS CUALITATIVOS</h2>
			<hr class="divider-th">
			<br>
			<div class="text-justify">
				<p>
					{!! $area_mayor !!} {{ $area_menor}}
				</p>
			</div>
			<div class="text-justify">
				<p>
					{{ $textos_cuantitativos['amor']->amor }}
				</p>
			</div>
			<div class="text-justify">
				<p>
					{{ $textos_cuantitativos['no_violencia']->no_violencia }}
				</p>
			</div>
			<div class="text-justify">
				<p>
					{{ $textos_cuantitativos['paz']->paz }}
				</p>
			</div>
			<div class="text-justify">
				<p>
					{{ $textos_cuantitativos['rectitud']->rectitud }}
				</p>
			</div>
			<div class="text-justify">
				<p>
					{{ $textos_cuantitativos['verdad']->verdad }}
				</p>
			</div>
		</section>

		<?php
			$concepto = $candidato_valores->concepto_final;
			$solicitada_por = $proceso->datosBasicosUsuarioEnvio;
		?>

		@if(!empty($concepto))
			{{-- Concepto final de la prueba --}}
			<section>
				<h2>CONCEPTO FINAL DEL ESPECIALISTA DE SELECCIÓN</h2>
				<hr class="divider-th">
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
					Prueba realizada el {{ $fecha_realizacion_letra }} - solicitada por {{ $solicitada_por->fullname() }} @if(!empty($concepto)) y evaluada por nuestro analista de selección {{ $candidato_valores->datosBasicosUsuarioGestionoConcepto->fullname() }} @endif.
				</p>
			</div>
		</section>

		<?php
            $fotos = $candidato_valores->getFotosArray();
            $ruta = 'recursos_prueba_valores_1/prueba_valores_1_'.$candidato_valores->user_id.'_'.$candidato_valores->req_id;
        ?>
        {{-- Separar contenido a nueva hoja --}}
        <div class="page-break"></div>
		<section>
			<h2>EVIDENCIA FOTOGRÁFICA DURANTE EJECUCIÓN</h2>
			<hr class="divider-th">
        	@if(count($fotos) > 0)
		        @foreach($fotos as $foto)
		            @if($foto != null && $foto != '')
		                <div class="row">
		                    <div class="text-center">
		                        <img alt="foto" src="{{url($ruta.'/'.$foto)}}" width="320">
		                    </div>
		                </div>
		            @endif
		        @endforeach
		    @else
		    	<p class="text-justify">No existe registro fotográfico ya que el candidato no contaba con cámara fotográfica al momento de realizar la prueba.</p>
        	@endif
		</section>
	</main>

	<footer>
	    <h5>T3RS</h5>
	</footer>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(function() {
        $('#guardar').click(function() {
            window.print();
        });
    });
</script>
</html>