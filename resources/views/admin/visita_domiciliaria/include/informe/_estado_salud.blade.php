<section>
    <h4>ESTADO DE SALUD</h4>

    {{--<table>
    	<tr>
    		<th>SERVICIOS MÉDICOS Y/O EPS DEL EVALUADO</th>
    		<td>{{$visita->eps_evaluado}}</td>
    	</tr>
    	<tr>
    		<th>FRECUENCIA CON LA QUE ASISTE AL MÉDICO</th>
    		<td>{{$visita->frecuencia}}</td>
    	</tr>
    	<tr>
    		<th>INTERVENCIONES QUIRURGICAS Y/O HOSPITALIZACIONES</th>
    		<td>{{$visita->interveciones}}</td>
    	</tr>
    	<tr>
    		<th>QUE ENFERMEDADES EXISTEN EN LA FAMILIA</th>
    		<td>{{$visita->enfermedades_familia}}</td>
    	</tr>
    </table>--}}

    <div>
        <p class="negrita">Servicio médicos y/o EPS del evaluado: <span class="valor">{{$visita->eps_evaluado}}</span></p>
       
    </div>

    <div>
            
        <p class="negrita">Frecuencuencia con la que asiste al médico: <span class="valor">{{$visita->frecuencia}}</span></p>
        
    </div>

    <div>
        <p class="negrita">Intervenciones quirurgicas y/o hospitalizaciones:<span class="valor">{{$visita->interveciones}}</span></p>
       
    </div>

    
        <h5>Enfermedades en la familia:</h5>
             <table class="table table-bordered table-striped enfermedades">
                        <thead>
                            <tr>
                                <th>Enfermedad</th>
                                <th>Quién la padece</th>
                            </tr>
                               
                               
                        </thead>
                        <tbody>
                                @
                                <tr>
                                    <td>Alergias</td>
                                    <td>{{$parentescos[$enfermedades['alergias']]}}</td>
                                </tr>
                                <tr>
                                    <td>Alzheimer</td>
                                    <td>{{$parentescos[$enfermedades['alzheimer']]}}</td>
                                </tr>
                                <tr>
                                    <td>Cancer</td>
                                    <td>{{$parentescos[$enfermedades['cancer']]}}</td>
                                </tr>
                                <tr>
                                    <td>Diabetes</td>
                                    <td>{{$parentescos[$enfermedades['diabetes']]}}</td>
                                </tr>
                                <tr>
                                    <td>Epilepsia</td>
                                    <td>{{$parentescos[$enfermedades['epilepsia']]}}</td>
                                </tr>
                                <tr>
                                    <td>Hipertensión</td>
                                    <td>{{$parentescos[$enfermedades['hipertension']]}}</td>
                                </tr>
                                <tr>
                                    <td>Asma</td>
                                    <td>{{$parentescos[$enfermedades['asma']]}}</td>
                                </tr>
                                <tr>
                                    <td>EPOC</td>
                                    <td>{{$parentescos[$enfermedades['epoc']]}}</td>
                                </tr>
                                <tr>
                                    <td>Otras enfermedades:</td>
                                    <td>{{$visita->otra_enfermedad_familiar}}</td>
                                </tr>
                                
                               
                        </tbody>
            </table>
    





</section>