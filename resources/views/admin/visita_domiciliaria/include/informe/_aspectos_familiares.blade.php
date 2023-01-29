<section id="aspectos-familiares">
    <h4>ASPECTOS FAMILIARES</h4>
    <br>
    <br>
    <div>
        <ul>
            <li>
                <span class="negrita">Dinámica familiar</span>
                <div class="respuesta">
                    {{$visita->dinamica_familiar}}
                </div>
            </li>
            <li>
                <p class="negrita">¿Con qué frecuencia conversan como familia?</p>
                <div class="respuesta">
                    {{$visita->frecuencia_conversacion_familia}}
                </div>
            </li>
            <li>
                <p class="negrita">¿Cómo es la comunicación con su núcleo familiar en general?</p>
                <div class="respuesta">
                    {{$visita->comunicacion_nucleo_familiar}}
                </div>
            </li>
            <li>
                <p class="negrita">¿Cada cuanto comparte con sus padres o hermanos que actividades realizan?</p>
                <div class="respuesta">
                    {{$visita->cada_cuanto_nucleo_familiar}}
                </div>
            </li>
            <li>
                <p class="negrita">¿Considera usted que tiene una buena armonía con sus (padres, hermanos, pareja e hijos)?</p>
                <div class="respuesta">
                    {{$visita->buena_armonia_nucleo_familiar}}
                </div>
            </li>
            <li>
                <p class="negrita">¿Cuántas veces al día se comunica con su núcleo familiar y con qué fin?</p>
                <div class="respuesta"> 
                    {{$visita->cuantas_comunica_nucleo}}
                </div>
            </li>

            <li>
                <p class="negrita">¿Hace cuánto convive con su pareja y/o esposa?</p>
                <div class="respuesta">
                    {{$visita->hace_cuanto_vive_pareja}}
                </div>
            </li>

            <li>
                <p class="negrita">¿En qué valores ha cimentado su relación de pareja durante el tiempo que llevan conviviendo?</p>
                <div class="respuesta">
                    {{$visita->cimiento_pareja}}
                </div>
            </li>

            <li>
                <p class="negrita">¿En que valores orientan la educación de sus hijos y que esfuerzos realizan como padres para logar que tengan una buena calidad de vida?</p>
                <div class="respuesta">
                    {{$visita->educacion_hijos}}
                </div>
            </li>

            <li>
                <p class="negrita">¿Aceptan los defectos de cada uno y saben sobrellevarlos?</p>
                <div class="respuesta">
                    {{$visita->aceptar_defectos}}
                </div>
            </li>
            <li>
                <p class="negrita">¿Con qué frecuencia comparten sus preocupaciones en familia?</p>
                <div class="respuesta">
                    {{$visita->preocupaciones_familia}}
                </div>
            </li>
            <li>
                <p class="negrita">Cualidades del evaluado</p>
                <div class="respuesta">
                    {{$visita->cualidades_evaluado}}
                </div>
            </li>

            <li>
                <p class="negrita">Aspectos por mejorar</p>
                <div class="respuesta">
                    {{$visita->aspectos_mejorar}}
                </div>
            </li>

            <li>
                <p class="negrita">Autodescripción a nivel personal</p>
                <div class="respuesta">
                    {{$visita->autodescripcion_personal}}
                </div>
            </li>
            <li>
                <p class="negrita">Autodescripción a nivel laboral</p>
                <div class="respuesta">
                    {{$visita->autodescripcion_laboral}}
                </div>
            </li>

            <li>
                <p class="negrita">¿Quién ejerce la autoridad dentro del núcleo familiar?</p>
                <div class="respuesta">
                    {{$visita->ejerce_autoridad}}
                </div>
            </li>

            <li>
                <p class="negrita">¿Cómo se ejerce la disciplina en el hogar y/o con sus hijos?</p>
                <div class="respuesta">
                    {{$visita->como_ejerce_autoridad}}
                </div>
            </li>
            <li>
                <p class="negrita">¿Existen límites o reglas dentro del núcleo familiar?</p>
                <div class="respuesta">
                    {{$visita->reglas_familiares}}
                </div>
            </li>
            <li>
                <p class="negrita">¿Cómo expresa su amor u afecto hacia su núcleo familiar?</p>
                <div class="respuesta">
                    {{$visita->amor_familiar}}
                </div>
            </li>

            <li>
                <p class="negrita">Caracteristicas o cualidades del núcleo familiar</p>
                <div class="respuesta">
                    {{$visita->cualidades_nucleo_familiar}}
                </div>
            </li>
            
            

            
            

            
            
            
            
            
            
        </ul>
    </div>
   

   
    <h5>PROYECCIÓN PERSONAL</h5>

    <table>
        <tr>
            <th>METAS A CORTO PLAZO</th>
            <td>{{$visita->metas_corto_plazo}}</td>
            
        </tr>
        <tr>
            <th>METAS A LARGO PLAZO:</th>
            <td>{{$visita->metas_largo_plazo}}</td>
            
        </tr>
        
    </table>
</section>