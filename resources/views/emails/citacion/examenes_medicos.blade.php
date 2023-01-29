<!DOCTYPE html>
<html>
<head>
	<title>Notificación Exámenes Medicos</title>
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
			<p>De manera atenta me permito informarle que usted ha sido citado a exámenes médicos en la
			dirección <strong> {{ $direccion }} </strong> en el horario {{ strtoupper($fecha)." : ".strtoupper($hora) }}. </p>
			<p>Agradecemos su puntualidad.</p>
			</br>
			<p>Cordial Saludo,</p>
			<p>GRUPO T3RS</p>
		</div>
	</div>
</body>
</html>