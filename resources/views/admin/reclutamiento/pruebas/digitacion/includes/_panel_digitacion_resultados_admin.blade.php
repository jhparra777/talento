<div class="row" id="panelResultadosBox">
	<div class="col-md-6 col-md-offset-3 mb-2">
		<div class="panel panel-info" id="panelResultados">
		  	<div class="panel-heading">
		  		<b>Resultados</b>
		  	</div>
		  	<div class="panel-body text-center p-1 mb-1" style="user-select: none;">
		    	<h1 
		    		id="resultadoPpm" 
		    		style="font-family: 'Montserrat', sans-serif;"
		    	>
		    		<b>{{ $candidato_digitacion->ppm }} PPM</b>
		    	</h1>

		    	<small>(Palabras por minuto)</small>
		  	</div>

		  	<ul class="list-group">
			    <li class="list-group-item">
			    	<span class="badge custom-badge">{{ $candidato_digitacion->pulsaciones }}</span> 
			    	Pulsaciones
			    </li>
			    <li class="list-group-item">
			    	<span class="badge custom-badge">{{ $candidato_digitacion->precision_user }} %</span> 
			    	Precisión
			    </li>
			    <li class="list-group-item">
			    	<span class="badge custom-badge" id="resultadoCorrectas" style="color: #5cb85c !important;">{{ $candidato_digitacion->correctas }}</span> 
			    	Palabras correctas
			    </li>
			    <li class="list-group-item">
			    	<span class="badge custom-badge" id="resultadoIncorrectas" style="color: #d9534f !important;">{{ $candidato_digitacion->incorrectas }}</span> 
			    	Palabras incorrectas
			    </li>
		  	</ul>
		</div>
	</div>
</div>