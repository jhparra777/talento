<!DOCTYPE html>
<html>
<head>
	<title>Notificación Visita Domiciliaria</title>
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
			<p>De manera atenta me permito informarle que ha sido programada la visita domiciliaria en la dirección <strong> {{ $direccion }} </strong> en la fecha <strong> {{ strtoupper($fecha)." : ".strtoupper($hora) }} </strong>. En caso de que la dirección de su domicilio esté mal por favor notificarlo al correo {{ $observaciones }}.</p>
			</br>
			<p>Cordial Saludo,</p>
			<p>GRUPO T3RS</p>
		</div>
	</div>
</body>
</html>