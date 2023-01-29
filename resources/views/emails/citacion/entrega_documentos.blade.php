<!DOCTYPE html>
<html>
<head>
	<title>Notificación Entreda de Documentos</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<p>Señor(a) 
				<strong>
					{{
						strtoupper($datos_user->nombres)." ".
						strtoupper($datos_user->primer_apellido)." ".
						strtoupper($datos_user->segundo_apellido)
					}}
				</strong>
			</p>
			<p>
				Debido a que usted se encuentra en proceso de selección con nosotros necesitamos que traiga una documentación faltante. Debe presentarse en la dirección <strong> {{ $direccion }} </strong> en el horario {{ strtoupper($fecha)." : ".strtoupper($hora) }}. </br>
				Traer la siguiente documentación ( {{ $observaciones }} ).
			</p>
			<p>Recuerde ser puntual y tener buena presentación personal.</p>
			</br>
			<p>Cordial Saludo,</p>
			<p>GRUPO T3RS</p>
		</div>
	</div>
</body>
</html>
