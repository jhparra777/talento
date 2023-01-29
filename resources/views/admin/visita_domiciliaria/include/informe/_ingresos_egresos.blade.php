<section id="ingresos_egresos">
    <h4>Ingresos y egresos económicos del núcleo familiar</h4>
    <h5>Ingresos</h5>
    <table>
    	<tr>
    		<th>INGRESOS MENSUALES:</th>
    		<td>{{$visita->ingresos_mensuales}}</td>
    		<th>PROCEDENCIA:</th>
    		<td>{{$visita->procedencia_ingresos_candidato}}</td>
    	</tr>
    	<tr>
    		<th>INGRESOS MENSUALES DEL CONYUGE:</th>
    		<td>{{$visita->ingresos_mensuales_conyugue}}</td>
    		<th>PROCEDENCIA:</th>
    		<td>{{$visita->procedencia_ingresos_conyugue}}</td>
    	</tr>
    	<tr>
    		<th>OTROS INGRESOS MENSUALES:</th>
    		<td>{{$visita->otros_ingresos_candidato}}</td>
    		<th>PROCEDENCIA:</th>
    		<td>{{$visita->procedencia_otros_ingresos}}</td>
    	</tr>
    	<tr>
    		<th colspan="1">OBSERVACIONES</th>
    		<td colspan="3">{{$visita->observaciones_ingresos}}</td>

    	</tr>
    </table>

    <h5>Egresos</h5>
    <table>
    	<tr>
    		<th>Egresos mensuales:</th>
    		<td>{{$visita->egresos_mensuales}}</td>
    		<th>DESTINO:</th>
    		<td>{{$visita->procedencia_egresos_candidato}}</td>
    	</tr>
    	<tr>
    		<th colspan="1">OBSERVACIONES:</th>
    		<td colspan="3">{{$visita->observaciones_egresos}}</td>
    	</tr>
    </table>
    <h5>Información crediticia del evaluado</h5>
    <h5>CRÉDITOS BANCARIOS</h5>
    @if($creditos=json_decode($visita->creditos_bancarios))
        <table>
        	<thead>
        		<tr>
    	    		<th>BANCO</th>
    	    		<th>TIPO CRÉDITO</th>
    	    		<th>VALOR TOTAL A LA FECHA</th>
    	    		<th>CUOTA MENSUAL</th>
        		</tr>
        	</thead>
        	<tbody>
        		
        			@foreach($creditos as $cre)
        			<tr>
        				<td>{{$bancos[$cre->banco]}}</td>
        				<td>{{$tipos_credito[$cre->tipo_credito]}}</td>
        				<td>{{$cre->total}}</td>
        				<td>{{$cre->cuota}}</td>
        			</tr>
        			@endforeach
        		
        	</tbody>
        </table>
    @else
        <p class="no-data">No registra créditos bancarios</p>
    @endif


    <h5>Tarjetas de crédito</h5>
    @if($tarjetas=json_decode($visita->tarjetas_credito))
        <table>
        	<thead>
        		<tr>
    	    		<th>BANCO</th>
    	    		<th>TIPO</th>
    	    		<th>VALOR TOTAL A LA FECHA</th>
    	    		<th>CUOTA MENSUAL</th>
        		</tr>
        	</thead>
        	<tbody>
        		
        			@foreach($tarjetas as $tar)
        			<tr>
        				<td>{{$bancos[$tar->banco]}}</td>
        				<td>{{$tar->tipo}}</td>
        				<td>{{$tar->total}}</td>
        				<td>{{$tar->cuota}}</td>
        			</tr>
        			@endforeach
        		
        	</tbody>
        </table>
    @else
        <p class="no-data">No registra tarjetas de crédito</p>
    @endif

    <h5>Reportes en centrales de riesgo</h5>
    @if($reportes=json_decode($visita->reportes_central))
        <table>
        	<thead>
        		<tr>
    	    		<th>BANCO</th>
    	    		<th>TIPO CRÉDITO</th>
    	    		<th>DIAS/MORA</th>
    	    		<th>ACUERDO DE PAGO</th>
        		</tr>
        	</thead>
        	<tbody>
        		
        			@foreach($reportes as $re)
        			<tr>
        				<td>{{$bancos[$re->banco]}}</td>
        				<td>{{$tipos_credito[$re->tipo_credito]}}</td>
        				<td>{{$re->dias_mora}}</td>
        				<td>
                            {{($re->acuerdo_pago)? 'Si':'No'}}
                        </td>
        			</tr>
        			@endforeach
        		
        	</tbody>
        </table>
    @esle
        <p class="no-data">No registra reportes</p>
    @endif
    <div>
    	<p>OBSERVACIONES: {{$visita->observaciones_ingresos_egresos}}</p>
    </div>

    <h5>Resumen total de ingresos y egresos</h5>
    <table>
        <tr>
            <th>Total ingresos:</th>
            <td>{{$visita->total_ingresos}}</td>
            
        </tr>
        <tr>
            <th>Total egresos:</th>
            <td>{{$visita->total_egresos}}</td>
            
        </tr>
        <tr>
            <th>Ingreso neto:</th>
            <td>{{$visita->ingreso_neto}}</td>
            
        </tr>
       
    </table>
</section>