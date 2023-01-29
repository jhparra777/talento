<section id="recreacion">
    <h4>RECREACIÓN Y USO DEL TIEMPO FAMILIAR</h4>

    <table>
        <thead>
            <tr>
                <th>ACTIVIDAD</th>
                <th>SI</th>
                <th>NO</th>
            </tr>
        </thead>
    	
    	<tr>
	    	<th>Ir al cine</th>
	    	<td>@if($visita->ir_cine) X @endif</td>
	    	<td>@if(!$visita->ir_cine) X @endif</td>
    	</tr>
    	<tr>
	    	<th>Visitar centros comerciales</th>
	    	<td>@if($visita->ir_centros_comerciales) X @endif</td>
	    	<td>@if(!$visita->ir_centros_comerciales) X @endif</td>
    	</tr>
    	<tr>
	    	<th>Salir al parque</th>
	    	<td>@if($visita->salir_parque) X @endif</td>
	    	<td>@if(!$visita->salir_parque) X @endif</td>
    	</tr>

    	<tr>
	    	<th>Ver televisión</th>
	    	<td>@if($visita->ver_tv) X @endif</td>
	    	<td>@if(!$visita->ver_tv) X @endif</td>
    	</tr>

    	<tr>
	    	<th>Dormir hasta tarde</th>
	    	<td>@if($visita->dormir_hasta_tarde) X @endif</td>
	    	<td>@if(!$visita->dormir_hasta_tarde) X @endif</td>
    	</tr>

    	<tr>
	    	<th>Ver películas en familia</th>
	    	<td>@if($visita->ver_peliculas) X @endif</td>
	    	<td>@if(!$visita->ver_peliculas) X @endif</td>
    	</tr>
    	
    	 
    </table>

    <table>
    	<tr>
	    	<th>¿Comparte con amigos?</th>
	    	<td>@if($visita->ver_peliculas) SI @else NO @endif</td>
	    	<th>¿Cada cuanto comparten y qué actividades realizan? </th>
	    	<td>{{$visita->cuanto_comparte_amigos}}</td>
	    	
    	</tr>
    	<tr>
	    	<th>¿Realiza quehaceres del hogar?</th>
	    	<td>@if($visita->realiza_quehaceres) SI @else NO @endif</td>
	    	<th>¿Tiene algún oficio en específico? </th>
	    	<td>{{$visita->oficio_especifico}}</td>
	    	
    	</tr>
    </table>
    <ul>
            <li>
                <span class="negrita">¿Practica algún deporte?</span>
                <div class="respuesta">
                    {{$visita->practica_deporte}}
                </div>
            </li>
            <li>
                <span class="negrita">¿Cual es su hobby?</span>
                <div class="respuesta">
                    {{$visita->tiene_hobby}}
                </div>
            </li>

            <li>
                <span class="negrita">¿Cada cuánto visita a sus demás familiares?</span>
                <div class="respuesta">
                    {{$visita->demas_familiares}}
                </div>
            </li>

            <li>
                <span class="negrita">¿Qué activiades realiza el evaluado(a) con su familia en su tiempo libre?</span>
                <div class="respuesta">
                    {{$visita->actividades_familiares_tiempo_libre}}
                </div>
            </li>
    </ul>

 
</section>