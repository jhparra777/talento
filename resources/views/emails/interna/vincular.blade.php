<!DOCTYPE html>
<html>
<head>
	<title>Notificación Enviado a Vincular</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<p>Cordial Saludo.</p>

			<p>Le informamos que el candidato <strong> {{ strtoupper($datos_usuario->nombres." ".
                    $datos_usuario->primer_apellido." ".$datos_usuario->segundo_apellido) }} </strong> identificado con el número de documento <strong> {{ $datos_usuario->numero_id }} </strong> ha sido enviado a vincular bajo el requerimiento <strong> {{ $datos_usuario->requerimiento_id }} </strong>  con el cliente <strong> FALTA </strong>.</p>
			</br>
			<p>Cordial Saludo,</p>
			<p>GRUPO T3RS</p>
		</div>
	</div>
</body>
</html>