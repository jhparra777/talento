<section>
    <h4>REFERENCIA VECINAL</h4>
    <h5>Referencia principal</h5>
    <table>
    	<tr>
    		<th>Nombres y apellidos:</th>
    		<td>{{$visita->nombres_apellidos_vecino}}</td>
    	</tr>
    	<tr>
    		<th>Parentesco:</th>
    		<td>{{$visita->parentesco_vecino}}</td>
    	</tr>

    	<tr>
    		<th>Número contacto:</th>
    		<td>{{$visita->telefono_vecino}}</td>
    	</tr>

    	<tr>
    		<th>Tiempo de conocerlo:</th>
    		<td>{{$visita->tiempo_vecino}}</td>
    	</tr>
    	
    </table>
    @if($visita->nombres_apellidos_vecino_2!=null)
        <h5>Referencia opcional</h5>
        <table>
            <tr>
                <th>Nombres y apellidos:</th>
                <td>{{$visita->nombres_apellidos_vecino_2}}</td>
            </tr>
            <tr>
                <th>Parentesco:</th>
                <td>{{$visita->parentesco_vecino_2}}</td>
            </tr>

            <tr>
                <th>Número contacto:</th>
                <td>{{$visita->telefono_vecino_2}}</td>
            </tr>

            <tr>
                <th>Tiempo de conocerlo:</th>
                <td>{{$visita->tiempo_vecino_2}}</td>
            </tr>
            
        </table>
    @endif

</section>