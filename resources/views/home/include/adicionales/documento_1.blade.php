<div>
	<div>
		<p>Ciudad y Fecha : {{$requerimiento->ciudad}} {{date('d-m-Y')}}</p>
		
		<p style="text-transform: uppercase;">{{$user->name}}</p>
		
		<p>Identificado con ccedula Ciudadania: {{$user->numero_id}}</p>
	</div>
	<br>
	<br>
	<div>
		<h4 style="font-weight: bold;text-align: center;">INFORMACIÓN IMPORTANTE</h4>
	</div>
	<br>
	<br>
	<br>
	<br>

	<div>
		<p style="text-align: justify;padding-bottom: 3em;line-height: 2em;">Se le informa al trabajador contratado que para darle cumplimiento a lo ordenado en el articulo 57 Numerial 7 de C.S.T, al finalizar
			la relacion contractual que lo une a la empresa, puede solicitar la práctica del examen médico de egreso dentro de los cinco (5) días
			siguientes a la conclusión de la misma, para lo cual deberá presentarse en la sede de la compañia a fin de reclamar la orden
			correspondiente para asistir ante el médico que ésta designe. Vencido dicho término, se entenderá su renuncia a este derecho, o si
		entregada la ordén Usted no concurre a la práctica del referido examen</p>
	</div>

	<div>
		<p>Firma del trabajador enterado:@if(isset($firma))<img src="{{$firma}}" style="width: 30%;">

		@else ________________________ @endif</p>
		<p> Cedula Ciudadania: {{$user->numero_id}}</p>
	</div>
</div>