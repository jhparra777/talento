
<div>
	<div class="encabezado">
		{{--<p>Ciudad y Fecha : {{$requerimiento->ciudad}} {{$fecha}}</p>
		
		<p style="text-transform: uppercase;">{{$user->name}}</p>
		
		<p>Identificado con CÉDULA CIUDADANÍA :{{$user->numero_id}}</p>--}}

		<table style="width: 100%;border: 1px solid black;padding: 1em;border-collapse: collapse;text-align: center;">
			<tr>
				<td rowspan="2" style="width: 100px;border: 1px solid black">
					@if($requerimiento->logo!=null)
						<img style="max-width: 100px" src='{{ asset("configuracion_sitio/$requerimiento->logo") }}'>
					@else
					@if(isset(FuncionesGlobales::sitio()->logo))
                                        @if(FuncionesGlobales::sitio()->logo != "")
                                      
                                            <img 
                                                class="img-fluid"
                                                width="75"
                                                height="75" 
                                                src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}"
                                                
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
				<td style="font-weight: bold;padding: .5em;border: 1px solid black">PROCESO: SEGURIDAD Y SALUD EN EL TRABAJO</td>
				<td style=";border: 1px solid black">Código: FO-SST-08</td>
			</tr>
			<tr>
				<td style="font-weight: bold;padding: .5em">CONSENTIMIENTO INFORMADO</td>
				<td style=";border: 1px solid black">Página 1 de 1</td>
			</tr>
		</table>
	</div>
	<br>
	<br>
	<div>
		<h4 style="font-weight: bold;text-align: center;font-size: 1.6em;">AUTORIZACIÓN PARA CONOCIMIENTO DE HISTORIA CLÍNICA Y
SEGUIMIENTO</h4>
	</div>
	
<br>
<br>

	<div>
	

<p style="text-align: justify;"> Yo <span id ="nombre" style="text-transform: uppercase;">{{$user->name}}</span>, identificado con documento de identidad número {{$user->numero_id}} de @if($lugarexpedicion!=null) {{$lugarexpedicion->value}} @endif. Soportado en el artículo 34 de la ley 23 de 1981, en concordancia con la Resolución Número 2346 De 2007 Y Resolución Numero 1918
De 2009 ambas del Ministerio de la protección Social (hoy Ministerio del trabajo)
autorizo expresamente al departamento médico de {{$requerimiento->nombre_empresa}}, para tener acceso,
obtener y conservar copia total o parcial de mi historia clínica y a todos aquellos datos
que en ella se registran o lleguen a ser registrados, tanto por conocimiento directo,
como por cualquier otro documento que la conforme.</p>


<p style="text-align: justify;">Los médicos especialistas en medicina del trabajo o salud ocupacional de que formen
parte de los servicios médicos de {{$requerimiento->nombre_empresa}}, tendrán la guarda y custodia de la
historia clínica ocupacional y son responsables de garantizar su confidencialidad,
conforme lo establece el ARTICULO 16 de la Resolución 2346 de 2007 y las demás
normas que lo modifiquen adicionen o sustituyan.</p>

<p style="text-align: justify;">Autorizo al departamento medico de {{$requerimiento->nombre_empresa}}, en caso de ser nece sario, a hacer
entrega de los anteriores documentos, a aquellas entidades que puedan definir
controversias en relación con la profesionalidad del evento, seguimientos clínicos y sus
secuelas y al porcentaje de pérdida de capacidad laboral generadas por las misma.</p>
<br>

<p>Se firma en {{$requerimiento->ciudad}} el <?php setlocale(LC_TIME, 'es_ES.UTF-8'); echo strftime(" %d de %B de %Y") ?>. </p>

<br>

<p style="font-weight: bold;">Cordialmente,</p>
		
	</div>


	<div>
		<p style="font-weight: bold;">Firma:@if(isset($firma))<img src="{{$firma}}" style="width: 30%;">

		@else ________________________ @endif</p>

		<p style="font-weight: bold;"> Cedula de Ciudadania:{{$user->numero_id}}</p>
	</div>
</div>