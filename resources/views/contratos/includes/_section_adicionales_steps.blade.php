<ul class="step-list" style="user-select: none;">
	@if(isset($firmaContrato))
        @if($firmaContrato->firma != null || $firmaContrato->firma != '')
            @if($firmaContrato->video == null)
                <li class="step-list__item step-item-success step-active--success">
					Contrato
					<br>
					<small style="color: gray;">Firmado</small>
				</li>
            @endif
        @else
        	<li class="step-list__item">Contrato</li>
        @endif
    @else
    	<li class="step-list__item step-item-success step-active--success">
			Contrato
			<br>
			<small style="color: gray;">Firmado</small>
		</li>
    @endif

    <?php $key = 0; ?>
	@for($i = 0; $i < count($documentoAsociados); $i++)
		<?php $key = $i + 1; ?>

		@if($documentoAsociados[$i]->estado == 1)
			<li class="step-list__item step-item-success step-active--success">
				Adicional #{{ $key }}
				<br>
				<small style="color: gray;">Firmado</small>
			</li>
		@else
			<li class="step-list__item">Adicional #{{ $key }}</li>
		@endif
	@endfor

	@if ($sitioModulo->clausula_medica == 'enabled')
		@if($adicional_medico)
			<?php $key++; ?>
			@if($especificaciones == null)
				<li class="step-list__item step-item-success step-active--success">
					Adicional #{{ $key }}
					<br>
					<small style="color: gray;">Firmado</small>
				</li>
			@else
				<li class="step-list__item">Adicional #{{ $key }}</li>
			@endif
		@endif
	@endif
</ul>

<style>
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
		color: {{ $sitio->color }};
		font-weight: bold;
	}

	.step-list__item--active::after, .step-list__item--active::before {
		font-weight: normal;
		color: #FFF;
		background-color: {{ $sitio->color }} !important;
		border-color: {{ $sitio->color }} !important;
	}

	.step-active--fail::after, .step-active--fail::before {
		font-weight: normal;
		color: #FFF;
		background-color: #e53935 !important;
		border-color: #e53935 !important;

		outline: none;
	    border-color: #c92e2a;
	    box-shadow: 0 0 3px #c92e2a;
	}

	.step-active--success::after, .step-active--success::before {
		font-weight: normal;
		color: #FFF;
		background-color: #00b248 !important;
		border-color: #00b248 !important;

		outline: none;
	    border-color: #00ad46;
	    box-shadow: 0 0 3px #00ad46;
	}
</style>