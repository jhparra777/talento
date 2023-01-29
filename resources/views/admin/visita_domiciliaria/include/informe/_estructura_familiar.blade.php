<section>
    <h4>ESTRUCTURA FAMILIAR</h4>

    @if($familiares=json_decode($visita->familiares))
    
    <table>
    	<thead>
    		<tr>
	    		<th>Nombres y apellidos</th>
	    		<th>Edad</th>
	    		<th>estado civil</th>
	    		<th>Parentesco</th>
	    		<th>Ocupación</th>
	    		<th>Convive con el</th>
	    		<th>Depend.Econ</th>
	    		<th>No.Contacto</th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($familiares as $fam)
    			<tr>
    				<td>{{$fam->nombres}} {{$fam->primer_apellido_fam}} {{$fam->segundo_apellido_fam}}</td>
                    <td>{{$fam->edad_fam}}</td>
                    <td>{{$estadoCivil[$fam->estado_civil_id]}}</td>
                    <td>{{$parentescos[$fam->parentesco_id]}}</td>
                    <td>{{$fam->ocupacion_fam}}</td>
                    <td>{{$fam->convive_con_el}}</td>
                    <td>{{$fam->depend_econ_fam}}</td>
                    <td>{{$fam->numero_contacto_familiar}}</td>
    	       </tr>
            @endforeach
            
    		
    	</tbody>
    </table>
    @else
    <p style="text-align: center;">No hay registros</p>
    @endif

</section>