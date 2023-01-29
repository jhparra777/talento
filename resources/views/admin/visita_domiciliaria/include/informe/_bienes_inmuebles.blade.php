<section>
    <h4>BIENES, INMUEBLES Y VEHICULOS DEL EVALUADO</h4>

    <h5>INMUEBLES</h5>
    <table>
    	<thead>
    		<tr>
	    		<th>TIPO</th>
	    		<th>VALOR</th>
	    		<th>PARTICIPACIÓN</th>
	    		<th>OBSERVACIONES</th>
    		</tr>
    	</thead>
    	<tbody>
    		@if($inmuebles=json_decode($visita->inmuebles))
    			@foreach($inmuebles as $in)
    			<tr>
    				<td>{{$tipos_inmuebles[$in->tipo]}}</td>
    				<td>{{$in->valor}}</td>
    				<td>
                        @if($in->participacion=2)
                            {{$in->porcentaje}}%
                        @elseif($in->participacion=1)
                            {{Único}}
                        @else
                            N/A
                        @endif
                        
                    </td>
    				<td>{{$in->observaciones}}</td>
    			</tr>
    			@endforeach
    		@endif
    	</tbody>
    </table>

    <h5>VEHICULOS</h5>
    <table>
    	<thead>
    		<tr>
	    		<th>TIPO</th>
	    		<th>VALOR</th>
	    		<th>MODELO</th>
	    		<th>PLACAS</th>
	    		<th>PARTICIPACION</th>
	    		<th>OBSERVACIONES</th>
    		</tr>
    	</thead>
    	<tbody>
    		@if($vehiculos=json_decode($visita->vehiculos))
    			@foreach($vehiculos as $in)
    			<tr>
    				<td>{{$tipos_vehiculos[$in->tipo]}}</td>
    				<td>{{$in->valor}}</td>
    				<td>{{$in->modelo}}</td>
    				<td>{{$in->placas}}</td>
    				<td>
                        @if($in->participacion==2)
                            {{$in->porcentaje}}%
                        @elseif($in->participacion==1)
                            {{Único}}
                        @else
                            N/A
                        @endif
                    </td>
    				<td>{{$in->observaciones}}</td>
    			</tr>
    			@endforeach
    		@endif
    	</tbody>
    </table>

</section>