<div class="col-md-12" id="ofertas_aplicadas">
	<h3 class="mt">Ofertas aplicadas</h3>
</div>

<div class="col-md-12">
	@forelse ($ofertas_aplicadas as $oferta)
		<?php
			$procesoAplicacion = FuncionesGlobales::stepAplicacion($oferta->req_id, $user_id);
		?>

		<div class="panel panel-default text-align--initial">
			<div class="panel-body">
				<div class="col-md-2 mb-2 mt-1">
					<img 
						class="img-width--initial" 
						src="{{ url(((!empty($sitio->logo)) ? "configuracion_sitio/$sitio->logo" : "img/personaDefectoG.jpg")) }}" 
						alt="{{ $oferta->oferta_cargo }}"
						width="120" 
					>
				</div>

				<div class="col-md-8 mb-2 mt-1">
					<p>
						<b>{{ $oferta->oferta_cargo }}</b>
					</p>
					<p>
						<small style="color: gray;">
							<i class="fa fa-calendar-o" aria-hidden="true"></i> Publicación: {{ date('Y-m-d', strtotime($oferta->fecha_publicacion)) }} | 
							<b><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $oferta->sitio_trabajo }}</b>
						</small>
					</p>
				</div>

				@if($oferta->estado_publico == 0)
					<div class="col-md-2 mt-1">
						<span 
							class="label label-danger"
							data-toggle="tooltip"
							data-placement="top"
							data-container="body"
							title="Se han completado todos lo procesos y la oferta ha sido cerrada."
						>
							Oferta terminada
						</span>
					</div>
				@endif

				<div class="col-md-12 text-center">
					<ul class="step-list" style="overflow-x: auto;">
						<li class="step-list__item step-item-success step-active--success">
							Aplicación
							<br>
							<small style="color: gray;">{{ $procesoAplicacion['procesoFecha'] }}</small>
						</li>

						<li class="step-list__item">En proceso selección</li>

						<li class="step-list__item">Evaluación del cliente</li>

						<li class="step-list__item">Finalista</li>

						<li class="step-list__item ">Contratado</li>
					</ul>
				</div>
			</div>
		</div>
	@empty
		<div class="panel panel-default">
			<div class="panel-body">
				<p>No hay ofertas</p>
			</div>
		</div>
	@endforelse

	{!! $ofertas_aplicadas->render() !!}
</div>

<div class="col-md-12" id="ofertas_en_proceso">
	<h3 class="mt">Ofertas en proceso</h3>
</div>

<div class="col-md-12">
	@forelse($ofertasCandidato as $oferta)
		<?php
			$procesoAplicacion = FuncionesGlobales::stepAplicacion($oferta->req_id, $user_id);
			$procesoSeleccion = FuncionesGlobales::stepProcesoSeleccion($oferta->req_id, $user_id);
			$procesoEvaluacion = FuncionesGlobales::stepEvaluacionCliente($oferta->req_id, $user_id);
			$procesoFinalista = FuncionesGlobales::stepFinalista($oferta->req_id, $user_id);
			$procesoContratado = FuncionesGlobales::stepContratado($oferta->req_id, $user_id);
		?>

		<div class="panel panel-default text-align--initial">
			<div class="panel-body">
				<div class="col-md-2 mb-2 mt-1">
					<img 
						class="img-width--initial" 
						src="{{ url(((!empty($sitio->logo)) ? "configuracion_sitio/$sitio->logo" : "img/personaDefectoG.jpg")) }}" 
						alt="{{ $oferta->oferta_cargo }}"
						width="120" 
					>
				</div>

				<div class="col-md-8 mb-2 mt-1">
					<p>
						<b>{{ $oferta->oferta_cargo }}</b>
					</p>
					<p>
						<small style="color: gray;">
							<i class="fa fa-calendar-o" aria-hidden="true"></i> Publicación: {{ date('Y-m-d', strtotime($oferta->fecha_publicacion)) }} | 
							<b><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $oferta->sitio_trabajo }}</b>
						</small>
					</p>
				</div>

				@if($oferta->estado_publico == 0)
					<div class="col-md-2 mt-1">
						<span 
							class="label label-danger"
							data-toggle="tooltip"
							data-placement="top"
							data-container="body"
							title="Se han completado todos lo procesos y la oferta ha sido cerrada."
						>
							Oferta terminada
						</span>
					</div>
				@endif

				<div class="col-md-12 text-center">
					<ul class="step-list" style="overflow-x: auto;">
						@if(!empty($procesoAplicacion['proceso'])))
							<li class="step-list__item step-item-success step-active--success">
								Aplicación
								<br>
							<small style="color: gray;">{{ $procesoAplicacion['procesoFecha'] }}</small>
							</li>
						@endif

						@if($procesoSeleccion['apto'] == 1)
							<li class="step-list__item step-item-success step-active--success">
								En proceso selección
								<br>
								<small style="color: gray;">{{ $procesoSeleccion['procesoFecha'] }}</small>
							</li>
						@else
							<li class="step-list__item step-item-fail step-active--fail">En proceso selección</li>
						@endif

						@if($procesoEvaluacion['proceso']->apto == 1)
							<li class="step-list__item step-item-success step-active--success">
								Evaluación del cliente
								<br>
								<small style="color: gray;">{{ $procesoEvaluacion['procesoFecha'] }}</small>
							</li>
						@elseif($procesoEvaluacion['proceso']->apto == 2)
							<li class="step-list__item step-item-fail step-active--fail">
								Evaluación del cliente
								<br>
								<small style="color: gray;">{{ $procesoEvaluacion['procesoFecha'] }}</small>
							</li>
						@elseif(!empty($procesoEvaluacion['proceso']))
							@if (is_null($procesoEvaluacion['proceso']->apto))
								<li class="step-list__item_in_process">Evaluación del cliente</li>
							@endif
						@elseif(empty($procesoEvaluacion['proceso']))
							<li class="step-list__item">Evaluación del cliente</li>
						@else
							<li class="step-list__item">Evaluación del cliente</li>
						@endif

						@if($instanciaConfiguracion->precontrata == 1)
							@if(empty($procesoFinalista['proceso']))
								<li class="step-list__item">Finalista</li>
							@elseif($procesoFinalista['proceso']->apto == 1)
								<li class="step-list__item step-item-success step-active--success">
									Finalista
									<br>
									<small style="color: gray;">{{ $procesoFinalista['procesoFecha'] }}</small>
								</li>
							@elseif($procesoFinalista['proceso']->apto == 2)
								<li class="step-list__item step-item-fail step-active--fail">
									Finalista
									<br>
									<small style="color: gray;">{{ $procesoFinalista['procesoFecha'] }}</small>
								</li>
							@elseif(is_null($procesoFinalista['proceso']->apto))
								<li class="step-list__item_in_process">Finalista</li>
							@endif
						@else
							@if(empty($procesoContratado['apto']))
								<li class="step-list__item">Finalista</li>
							@elseif($procesoContratado['apto'] == 1)
								<li class="step-list__item step-item-success step-active--success">
									Finalista
									<br>
									<small style="color: gray;">{{ $procesoContratado['procesoFecha'] }}</small>
								</li>
							@elseif($procesoContratado['apto'] == 0)
								<li class="step-list__item step-item-fail step-active--fail">
									Finalista
									<br>
									<small style="color: gray;">{{ $procesoContratado['procesoFecha'] }}</small>
								</li>
							@else
								<li class="step-list__item">Finalista</li>
							@endif
						@endif
						
						@if(empty($procesoContratado))
							<li class="step-list__item ">Contratado</li>
						@elseif($procesoContratado['apto'] == 1)
							<li class="step-list__item step-item-success step-active--success">
								Contratado
								<br>
								<small style="color: gray;">{{ $procesoContratado['procesoFecha'] }}</small>
							</li>
						@elseif($procesoContratado['apto'] === 0)
							<li class="step-list__item step-item-fail step-active--fail">
								Contratado
								<br>
								<small style="color: gray;">{{ $procesoContratado['procesoFecha'] }}</small>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	@empty
		<div class="panel panel-default">
			<div class="panel-body">
				<p>No hay ofertas</p>
			</div>
		</div>
	@endforelse

	{!! $ofertasCandidato->render() !!}
</div>

<style>
	.text-align--initial { text-align: initial; }
	.img-width--initial { max-width: initial; }

	.mb-1{ margin-bottom: 1rem; }
	.mb-2{ margin-bottom: 2rem; }

	.mt-1{ margin-top: 1rem; }
	.mt-2{ margin-top: 2rem; }

	.pd-1{ padding-bottom: 1rem; }
	.pd-2{ padding-bottom: 2rem; }

	.step-list { list-style: none; counter-reset: step-counter; white-space: nowrap; }

	.step-list__item {
		white-space: normal;
		vertical-align: top;
		display: inline-block;
		width: 15rem;
		position: relative;
		text-align: center;
		padding-top: 4rem;
		font-size: 1.3rem;
	}

	/* Circles */
	.step-list__item::after {
		/*counter-increment: step-counter;*/
		content: "";
		position: absolute;
		width: 3rem;
		height: 3rem;
		line-height: 2.53rem;
		border-radius: 100%;
		border: solid 0.2rem #B6B6B6;
		background-color: #FFF;
		left: 0;
		right: 0;
		top: 1rem;
		margin: auto;
		text-align: center;
	}

	.step-item-fail::after {
		font-family: "FontAwesome";
   		content: "\f00d";
   		font-size: 1.6rem;
	}

	.step-item-success::after {
		font-family: "FontAwesome";
   		content: "\f00c";
   		font-size: 1.6rem;
	}

	/* Lines */
	.step-list__item:nth-of-type(n+2)::before {
		content: "";
		position: absolute;
		width: 14rem;
		height: 2px;
		background-color: #CCC;
		right: 50%;
		top: 2.3rem;
	}

	/* Actives */
	.step-active--fail {
		color: #e53935;
		font-weight: bold;
	}

	.step-active--success {
		color: #00b248;
		font-weight: bold;
	}

	.step-list__item--active {
		color: {{ $instanciaConfiguracion->color }};
		font-weight: bold;
	}

	.step-list__item--active::after, .step-list__item--active::before {
		font-weight: normal;
		color: #FFF;
		background-color: {{ $instanciaConfiguracion->color }} !important;
		border-color: {{ $instanciaConfiguracion->color }} !important;
	}

	.step-active--fail::after, .step-active--fail::before {
		font-weight: normal;
		color: #FFF;
		background-color: #e53935 !important;
		border-color: #e53935 !important;

		outline: none;
	    border-color: #c92e2a;
	    box-shadow: 0 0 6px #c92e2a;
	}

	.step-active--success::after, .step-active--success::before {
		font-weight: normal;
		color: #FFF;
		background-color: #00b248 !important;
		border-color: #00b248 !important;

		outline: none;
	    border-color: #00ad46;
	    box-shadow: 0 0 6px #00ad46;
	}
</style>