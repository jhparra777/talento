<!DOCTYPE html>
<html>
<head>
	<title>Notificación Entrega Hoja de Vida</title>
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
			<p>Lo estamos llamando, hay una oportunidad laboral para usted y nos gustaría poder contactarlo. Por favor llamar al número {{ $observaciones }} o dirigirse a la dirección <strong> {{ $direccion }} </strong> si le interesa saber más sobre esta oferta.
			</br>
			Para asistir debe haber registrado su hoja de vida en la página web <a href="https://www.empleosenaccion.com">https://www.empleosenaccion.com</a>, y traer documentos como Hoja de vida, Cedula, diploma y acta de bachiller originales y diploma de estudios superiores.</p>
			</br>
			<p>Cordial Saludo,</p>
			<p>GRUPO T3RS</p>
		</div>
	</div>
</body>
</html>
