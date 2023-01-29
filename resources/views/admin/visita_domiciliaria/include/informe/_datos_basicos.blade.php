<section>
    <h4>DATOS DE IDENTIFICACIÓN DEL ASPIRANTE</h4>

    <table>
    	<tr>
    		<th>NOMBRES Y APELLIDOS</th>
    		<td>{{$visita->primer_nombre}} {{$visita->segundo_nombre}} {{$visita->primer_apellido}} {{$visita->segundo_apellido}}</td>
    		<th>IDENTIFICACIÓN</th>
    		<td>{{$visita->numero_id}}</td>
    	</tr>
    	<tr>
    		<th>FECHA NACIMIENTO</th>
    		<td>{{$visita->fecha_nacimiento}} </td>
    		<th>CIUDAD</th>
    		<td>{{$visita->ciudad_nacimiento}}</td>
    	</tr>
    	<tr>
    		<th>FECHA Y LUGAR DE EXPEDICIÓN</th>
    		<td>{{$visita->fecha_expedicion}} </td>
    		<th>TIPO SANGRE</th>
    		<td>{{$visita->grupo_sanguineo}} {{$visita->rh}}</td>
    	</tr>

    	<tr>
    		<th>DIRECCIÓN</th>
    		<td>{{$visita->direccion}} </td>
    		<th>BARRIO</th>
    		<td>{{$visita->barrio}}</td>
    	</tr>

    	<tr>
    		<th>NÚMEROS DE CONTACTO</th>
    		<td>{{$visita->numero_contacto}} </td>
    		<th>ESTADO CIVIL</th>
    		<td>{{$visita->estado_civil_persona}}</td>
    	</tr>
    	<tr>
    		<th>NIVEL DE ESCOLARIDAD</th>
    		<td>{{$visita->nivel}} </td>
    		<th>EMAIL</th>
    		<td>{{$visita->email}}</td>
    	</tr>
    	<tr>
	    	<th>LIBRETA</th>
	    	<td>{{$visita->numero_libreta}} </td>
	    	<th>CATEGORÍA</th>
	    	<td>{{$visita->clase_libreta}}</td>
	    </tr>
    	@if($visita->requerimiento_id)
	    	<tr>
	    		<th>CARGO AL QUE ASPIRA</th>
	    		<td>{{$visita->cargo}} </td>
	    		<th>EMPRESA</th>
	    		<td>{{$visita->empresa}}</td>
	    	</tr>
    	@endif
    </table>

</section>