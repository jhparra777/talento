
<div>
	<div class="encabezado">
		{{--<p>Ciudad y Fecha : {{$requerimiento->ciudad}} {{$fecha}}</p>
		
		<p style="text-transform: uppercase;">{{$user->name}}</p>
		
		<p>Identificado con CÉDULA CIUDADANÍA :{{$user->numero_id}}</p>--}}

		<table style="width: 100%;border: 1px solid black;padding: 1em;border-collapse: collapse;text-align: center;">
			<tr>
				<td rowspan="2" style="width: 100px;border: 1px solid black;">
					@if($requerimiento->logo!=null)
						<img style="max-width: 100px" src='{{ asset("configuracion_sitio/$requerimiento->logo") }}'>
					@else

					@if(isset(FuncionesGlobales::sitio()->logo))
                                        @if(FuncionesGlobales::sitio()->logo != "")

                                            <img class="img-fluid" width="75" height="75" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}"
                                                
                                            >
                                        @else
                                            <img 
                                                class="img-fluid"
                                               
                                                src="{{ url("img/logo.png")}}"
                                                 width="75"
                                                height="75" 
                                            >
                                        @endif
                                    @else
                                        <img
                                            class="img-fluid"
                                           
                                            src="{{ url("img/logo.png")}}"
                                             width="75"
                                                height="75" 
                                        >
                       @endif
                    @endif

				</td>
				<td style="font-weight: bold;padding: .5em;border: 1px solid black;">PROCESO: GESTIÓN DE CONTROL Y SEGURIDAD</td>
				<td style=";border: 1px solid black;">Código: FO-GCS-16</td>
			</tr>
			<tr>
				<td style="font-weight: bold;padding: .5em;">DECLARACION JURAMENTADA SARLAFT</td>
				<td style=";border: 1px solid black;">Versión: 01</td>
			</tr>
		</table>
	</div>
	
	<br>
	<div>
		<p style="font-weight: bold;text-align: center;font-size: 1.6em;">Declaración Juramentada trabajador dependiente No participación en actividades relacionadas con Lavado de Activos y Financiación del Terrorismo</p>
	</div>
	

<br>
<br>
<br>
	<div>
		<p style="text-align: justify;">Yo <span id ="nombre" style="text-transform: uppercase;">{{$user->name}}</span>, mayor de edad, identificada(o) con la cedula ciudadania No. {{$user->numero_id}} expedida en @if($lugarexpedicion!=null) {{$lugarexpedicion->value}} @endif , en mi calidad de empleado de la empresa {{$requerimiento->nombre_empresa}}, por medio del presente documento manifiesto bajo la gravedad de juramento que no estoy ni he estado vinculado con actividades relacionadas con LAVADO DE ACTIVOS Y/O FINANCIACION DEL TERRORISMO Y/O SUS DELITOS DERIVADOS.</p>
<br>
<br>
<p>Se firma en {{$requerimiento->ciudad}} el <?php setlocale(LC_TIME, 'es_ES.UTF-8'); echo strftime(" %d de %B de %Y") ?>. .</p>

<br>
<br>
<p style="font-weight: bold;">Cordialmente,</p>
		
	</div>

	<br>
<br>
<br>

	<div>
		<p style="font-weight: bold;">Firma:@if(isset($firma))<img src="{{$firma}}" style="width: 30%;">
		@else ________________________ @endif</p>
		<br>
		<p style="font-weight: bold;"> Cedula Ciudadania: {{$user->numero_id}}</p>
	</div>
</div>