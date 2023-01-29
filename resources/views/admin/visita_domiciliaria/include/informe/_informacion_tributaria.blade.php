<section id="informacion-tributaria">
    <h4>INFORMACIÓN TRIBUTARIA DEL EVALUADO</h4>
    
    <table class="tributaria">
    	<tr>
    		<th>¿Es declarante de renta?</th>
    		<td>@if($visita->declarante_renta)Si @else No @endif</td>
    	</tr>
    	
    
    	<tr>
    		<th>¿Saldo a favor?</th>
    		<td>@if($visita->saldo_favor) Si @else No @endif</td>
    	</tr>
    	
   
    	<tr>
    		<th>Pago total renta</th>
    		<td>{{$visita->pago_total_renta}}$</td>
    		
    	</tr>
    	
   
        <tr>
            <th rowspan="2">Periodo declaración renta</th>
            <td>{{$visita->periodo_declaracion}}</td>
            
        </tr>
        
    </table>
    <div class="clearfix"></div>

   <div>
       <p class="negrita centrado">Observaciones</p>
       <div class="valor">
           {{$visita->observaciones_renta}}
       </div>
   </div>

</section>