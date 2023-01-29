<!DOCTYPE html>
<html>
<head>
	<title>Notificación Contratación</title>
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
			<p>De manera atenta me permito informarle que usted ha sido seleccionado en la vacante a la que aplicó. Por lo tanto, debe presentarse en la dirección <strong> {{ $direccion }} </strong> en la fecha <strong> {{ strtoupper($fecha)." : ".strtoupper($hora) }} </strong> para proceder a la firma de contrato. Agradecemos su puntualidad.</p>
			<p>Recuerde traer los siguientes documentos ( {{ $observaciones }} ).</p>
			</br>
			<p>Cordial Saludo,</p>
			<p>GRUPO T3RS</p>
		</div>
	</div>
</body>
</html>