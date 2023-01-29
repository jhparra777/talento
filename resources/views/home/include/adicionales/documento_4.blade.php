<div>
	<br>
	<div>
	  <h2 style="font-weight: bold;text-align: center;">DECLARACIÓN ESTADO DE SALUD.</h2>
	</div>
	<br>

	<div>
		<p style="text-align: justify;padding-bottom: 1em;line-height: 2em;"> <span id ="nombre" style="text-transform: uppercase;">{{$user->name}}</span> identificado con cédula de ciudadanía No.  {{$user->numero_id}} de @if($lugarexpedicion!=null) {{$lugarexpedicion->value}} @endif, de forma voluntaria y libre, se permite rendir declaración respecto a su estado de salud a {{$requerimiento->nombre_cliente}} con NIT {{$requerimiento->nit_cliente}}.</p>
        
     <h2 style="font-weight: bold;text-align: center;"> CONSIDERACIONES </h2>

    <p style="text-align: justify;padding-bottom: 1em;line-height: 2em;"> Se le ha comunicado, se le ha leído y hecho saber que, es obligación “Suministrar información clara, veraz y completa sobre el estado de salud” numeral 2 del artículo 10 del Decreto 1443 de 2010 y numeral 2 articulo 2.2.4.6.10 del Decreto 1072 de 2015. Entendiendo lo anterior, <b> {{$user->name}} </b> reconoce y acepta que la información que suministrará constituye Dato Sensible, por lo cual autoriza ser tratados por ({{$requerimiento->nombre_cliente}}).</p>
    
    <p> Por lo anterior, manifiesta y declara:</p><br>
       
       <p style="text-align: justify;padding-bottom: 1em;line-height: 2em;">
       
       <b style="font-weight: bold;">Primero: </b> Declaro que conozco y acepto la obligación de “Suministrar información clara, veraz y completa 
       sobre mi estado de salud”, numeral 2 articulo 2.2.4.6.10 del Decreto 1072 de 2015. </p>
       
       <p style="text-align: justify;padding-bottom: 1em;line-height: 2em;">
        
       <b style="font-weight: bold;">Segundo: </b> Declaro que al momento de la suscripción del contrato de trabajo con {{$requerimiento->nombre_cliente}}, no poseo enfermedad, diagnostico, patología o condición médica que me impidan ejecutar y/o desempeñar el cargo de {{$requerimiento->cargo}}. </p>
      
       <p style="text-align: justify;padding-bottom: 1em;line-height: 2em;">

        <b style="font-weight: bold;">Tercero: </b> Declaro de forma expresa, voluntaria y libre que en aras de que mi EMPLEADOR ejerza las acciones de prevención y promoción propias de SG-SST, no poseo enfermedad, diagnostico, patología o condición médica tales como: </p>
        
      <ul>
        <li> Enfermedades mentales, psiquiátricas o del comportamiento. </li><br>
        <li> Enfermedades del sistema nervioso.</li><br>
        <li> Enfermedades del sistema respiratorio. </li><br>
        <li> Enfermedades del corazón y sistema circulatorio. </li><br>
        <li> Enfermedades del sistema digestivo. </li><br>
        <li> Enfermedades ginecológicas y mamas. </li><br>
        <li> Enfermedades renales o del sistema genitourinario </li><br>
        <li> Enfermedades reumatológicas o del sistema osteomuscular </li><br>
        <li> Enfermedades de la sangre o del sistema hematopoyético. </li><br>
        <li> Enfermedades endocrinas, nutricionales y metabólicas </li><br>
        <li> Malformaciones y/o enfermedades congénitas </li><br>
        <li> Tumores y/o enfermedades oncológicas </li><br>
        <li> Enfermedades de la piel y del tejido subcutáneo </li><br>
        <li> Enfermedades de oído, nariz y garganta </li><br>
        <li> Enfermedades oculares </li><br>
        <li> Enfermedades infecciosas y parasitarias </li><br>
        <li> Enfermedades de embarazo, parto o puerperio </li><br>
        <li> Traumatismos, accidentes y quemaduras </li><br>
        <li> Prótesis, ortesis </li><br>
        <li> Otras </li><br>
      </ul>

     <br>
    
    <p style="text-align: justify;padding-bottom: 1em;line-height: 2em;">
     <b style="font-weight: bold;"> Cuarto:</b> Declaro que no he rendido información falsa, equivoca, engañosa respecto a mi estado de salud; así mismo, declaro no haber omitido información sobre mi estado de salud durante el proceso de selección y contratación para obtener la vinculación con mi EMPLEADOR.
    </p>

     <p style="text-align: justify;padding-bottom: 1em;line-height: 2em;"> 
      <b style="font-weight: bold;"> Quinto: </b> Conozco y acepto que de conformidad al Reglamento Interno de Trabajo y Código Sustantivo del Trabajo rendir información falsa, equivoca y/o engañosa es falta grave y constituye justa causa para dar por terminado el contrato de trabajo.</p>
      
      <p> En constancia se firma a los ({{date('d')}}) días del mes de <?php setlocale(LC_TIME, 'es_ES.UTF-8'); echo strftime("%B de %Y") ?> </p>
	
    </div>

	<div>
		<p>@if(isset($firma))<img src="{{$firma}}" style="width: 30%;">

		@else ________________________ @endif</p>
		<p><b style="font-weight: bold;">Nombre:</b> {{$user->name}}</p>
    <p><b style="font-weight: bold;">Cedula Ciudadania:</b> {{$user->numero_id}}</p>
	</div>
</div>