<!DOCTYPE html>
<html>
<head>
	<title>Contrato ppdf</title>

<style type="text/css">
	#imagen_firma div{
		float: left;
	}
</style>
</head>
<body>

@include("home.include.contrato")

<div id="imagen_firma">
	<div style="width: 30%;margin: 4em;">

		<img src="{{$firma}}" style="width: 100%;">
		<hr>
		Persona contratada
		
	</div>
	<div style="width: 30%;margin: 7em;">
		<hr>
		Persona que contrata
	</div>
	
</div>

</body>
</html>