<div class="panel panel-default item">
        <div class="panel-heading">
             <h3>Aspectos familiares</h3>
        </div>
        <div class="panel-body">
           
            <br>
            <form id="form-8" data-smk-icon="glyphicon-remove-sign" name="form-8" class="formulario">
                <div class="row">

                    <div class="row">
                        
                           <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    Dinámica familiar <span></span> 
                                    </label>
                                    
                                        {!! Form::textarea("dinamica_familiar",$candidatos->dinamica_familiar,["class"=>"form-control selectcategory" ,"id"=>"dinamina_familiar","required"=>true,"placeholder"=>"En este espacio lo que queremos es conocer si es casado(a), hace cuanto convive con su pareja o cuantos años tienen de matrimonio, como es su relación de pareja y durante el tiempo que llevan conviviendo en que valores han cimentado su relación, como es la comunicación con su núcleo familiar en general (padres, hermanos, pareja e hijos),  como educan a su sus hijos y/o en que valores los forman, si buscan espacios a diario para poder conversar y/o están pendientes en el transcurso del día de comunicarse.  Si es soltero y sin hijos, hable de sus padres y hermanos","rows"=>5]) !!}
                                    
                                </div>
                                
                                
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                        <label class="control-label">
                                        ¿Como es la comunicación con su núcleo familiar en general (padres, hermanos, pareja e hijos)?<span></span> 
                                        </label>
                                   
                                        {!! Form::textarea("comunicacion_nucleo_familiar",$candidatos->comunicacion_nucleo_familiar,["class"=>"form-control selectcategory" ,"id"=>"comunicacion_nucleo_familiar","required"=>true,"rows"=>5]) !!}
                                </div>
                               
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    ¿Cada cuanto comparte con sus padres o hermanos que actividades realizan?<span></span> 
                                    </label>
                                
                                    {!! Form::textarea("cada_cuanto_nucleo_familiar",$candidatos->cada_cuanto_nucleo_familiar,["class"=>"form-control selectcategory" ,"id"=>"cada_cuanto_nucleo_familiar","required"=>true,"rows"=>5]) !!}
                                </div>
                                
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" >
                                    ¿Considera usted que tiene una buena armonía con sus (padres, hermanos, pareja e hijos)?<span></span> 
                                    </label>
                                
                                    {!! Form::textarea("buena_armonia_nucleo_familiar",$candidatos->buena_armonia_nucleo_familiar,["class"=>"form-control selectcategory" ,"id"=>"buena_armonia_nucleo_familiar","required"=>true,"rows"=>5]) !!}
                                </div>
      
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    ¿Cuántas veces al día se comunica con su núcleo familiar y con qué fin?<span></span> 
                                    </label>
                                
                                    {!! Form::textarea("cuantas_comunica_nucleo",$candidatos->cuantas_comunica_nucleo,["class"=>"form-control selectcategory" ,"id"=>"cuantas_comunica_nucleo","required"=>true,"rows"=>5]) !!}
                                </div>
    
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    ¿Hace cuánto convive con su pareja y/o esposa?<span></span> 
                                    </label>
                                
                                    {!! Form::textarea("hace_cuanto_vive_pareja",$candidatos->hace_cuanto_vive_pareja,["class"=>"form-control selectcategory" ,"id"=>"hace_cuanto_vive_pareja","required"=>true,"rows"=>5]) !!}
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    ¿En qué valores ha cimentado su relación de pareja durante el tiempo que llevan conviviendo?<span></span> 
                                    </label>
                                
                                    {!! Form::textarea("cimiento_pareja",$candidatos->cimiento_pareja,["class"=>"form-control selectcategory" ,"id"=>"cimiento_pareja","required"=>true,"rows"=>5]) !!}
                                </div>
     
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    ¿En que valores orientan la educación de sus hijos y que esfuerzos realizan como padres para logar que tengan una buena calidad de vida?.<span></span> 
                                    </label>
                                
                                    {!! Form::textarea("educacion_hijos",$candidatos->educacion_hijos,["class"=>"form-control selectcategory" ,"id"=>"educacion_hijos","required"=>true,"rows"=>5]) !!}
                                </div>
           
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    ¿Con que frecuéncia conversan como familia? <span></span> 
                                    </label>
                                
                                     {!! Form::select("frecuencia_conversacion_familia",[
                                        "Todos los dias"=>"Todos los días",
                                        "Una o dos veces por semana"=>"Una o dos veces por semana",
                                        "Rara vez"=>"Rara vez",
                                        "Nunca"=>"Nunca"
                                     ],$candidatos->frecuencia_conversacion_familia,["class"=>"form-control selectcategory" ,"id"=>"frecuencia_conversacion_familia","required"=>true]) !!}
                                </div>
 
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    ¿Aceptan los defectos de cada uno y saben sobrellevarlos? <span></span> 
                                    </label>
                                
                                     {!! Form::select("aceptar_defectos",[
                                        "Sin ningun problema"=>"Sin ningún problema",
                                        "Medianamente"=>"Medianamente",
                                        "Dificilmente"=>"Difícilmente",
                                        "Imposible"=>"Imposible"
                                     ],$candidatos->aceptar_defectos,["class"=>"form-control selectcategory" ,"id"=>"aceptar_defectos","required"=>true]) !!}
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    ¿Con qué frecuencia comparten sus preocupaciones en familia? <span></span> 
                                    </label>
                                
                                     {!! Form::select("preocupaciones_familia",[
                                        "Todos los dias"=>"Todos los días",
                                        "Una o dos veces por semana"=>"Una o dos veces por semana",
                                        "Rara vez"=>"Rara vez",
                                        "Nunca"=>"Nunca"
                                     ],$candidatos->preocupaciones_familia,["class"=>"form-control selectcategory" ,"id"=>"preocupaciones_familia","required"=>true]) !!}
                                </div>

                            </div>

                           
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    Cualidades del evaluado <span></span> 
                                    </label>
                                
                                    {!! Form::textarea("cualidades_evaluado",$candidatos->cualidades_evaluado,["class"=>"form-control selectcategory","id"=>"cualidades_evaluado","required"=>true,"placeholder"=>"Mencione sus principales cualidades","rows"=>5]) !!}
                                </div>
     
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    Aspectos por mejorar <span></span> 
                                    </label>
                                
                                    {!! Form::textarea("aspectos_mejorar",$candidatos->aspectos_mejorar,["class"=>"form-control selectcategory","id"=>"aspectos_mejorar","required"=>true,"placeholder"=>"Describa sus defectos y/o aspectos por mejorar a nivel personal.","rows"=>5]) !!}
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                     <label class="control-label" >
                                    Autodescripción a nivel personal <span></span> 
                                    </label>
                               
                                    {!! Form::textarea("autodescripcion_personal",$candidatos->autodescripcion_personal,["class"=>"form-control selectcategory","id"=>"autodescripcion_personal","required"=>true,"placeholder"=>"Realice una autodescripción a nivel personal","rows"=>5]) !!}
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    Autodescripción a nivel laboral <span></span> 
                                    </label>
                               
                                    {!! Form::textarea("autodescripcion_laboral",$candidatos->autodescripcion_laboral,["class"=>"form-control selectcategory" ,"id"=>"autodescripcion_laboral","required"=>true,"placeholder"=>"Realice una autodescripción a nivel laboral, que cualidades tiene a nivel laboral, cuáles son sus puntos fuertes y como lo describirían sus jefes inmediatos.","rows"=>5]) !!}
                                </div>
                                
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                   <label class="control-label">
                                    ¿Quién ejerce la autoridad dentro del núcleo familiar? <span></span> 
                                    </label>
                                
                                    {!! Form::textarea("ejerce_autoridad",$candidatos->ejerce_autoridad,["class"=>"form-control selectcategory","id"=>"ejerce_autoridad","required"=>true,"placeholder"=>"En este espacio queremos conocer quien ejerce la autoridad dentro de su núcleo familiar, quien se encarga de las obligaciones económicas, si estas son repartidas equitativamente y/o si recaen sobre un solo miembro de la familia.","rows"=>5]) !!} 
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    ¿Cómo se ejerce la disciplina en el hogar y/o con su hijo? <span></span> 
                                    </label>
                                
                                    {!! Form::textarea("como_ejerce_autoridad",$candidatos->como_ejerce_autoridad,["class"=>"form-control selectcategory","id"=>"como_ejerce_autoridad","required"=>true,"placeholder"=>"En este espacio queremos conocer como ejerce la disciplina con sus hijos, como los corrige cuando cometen alguna falta, que castigos ejerce sobre ellos y cual de los dos padres es más estricto o alcahueta. Si no tiene hijos, enfocamos las preguntas en sí mismo, se considera una persona disciplinada, que hábitos tiene que le ayudan a ser disciplinado y que piensa de la disciplina a nivel personal.  ","rows"=>5]) !!}
                                </div>
            
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    ¿Existen límites o reglas establecidas dentro del núcleo familiar?<span></span> 
                                    </label>
                                
                                    {!! Form::textarea("reglas_familiares",$candidatos->reglas_familiares,["class"=>"form-control selectcategory","id"=>"reglas_familiares","required"=>true,"placeholder"=>"Describa si tienen reglas definidas para una buena convivencia como por ejemplo (horarios definidos para llegar a la casa, almorzar, cenar, ver televisión, uso del celular etc..). ¿Si tiene obligaciones y responsabilidades que deban cumplir dentro del núcleo familiar, cuáles?  y si respetan los espacios de sus demás familiares. ","rows"=>5]) !!}
                                </div>
                                
                            </div>
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    ¿Cómo expresa su amor o afecto hacia su núcleo familiar? <span></span> 
                                    </label>
                               
                                    {!! Form::textarea("amor_familiar",$candidatos->amor_familiar,["class"=>"form-control selectcategory","id"=>"amor_familiar","required"=>true,"placeholder"=>"Cómo expresa su afecto hacia su núcleo familiar, como les da a entender a sus padres, hermanos, pareja e hijos que los quiere, que los ama y que son importantes para él, si se considera una persona efusiva o reservada a la hora de demostrar afecto.","rows"=>5]) !!}
                                </div>
                                
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    Caracteristicas o cualidades del núcleo familiar <span></span> 
                                    </label>
                                
                                    {!! Form::textarea("cualidades_nucleo_familiar",$candidatos->cualidades_nucleo_familiar,["class"=>"form-control selectcategory","id"=>"cualidades_nucleo_familiar","required"=>true,"placeholder"=>"","rows"=>5]) !!}
                                </div>
                                
                            </div>

                            <div class="col-sm-12">
                                <h4>Proyección personal</h4>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    Metas a corto plazo <span></span> 
                                    </label>
                                
                                    {!! Form::textarea("metas_corto_plazo",$candidatos->metas_corto_plazo,["class"=>"form-control selectcategory","id"=>"metas_corto_plazo","required"=>true,"placeholder"=>"Queremos saber que aspiraciones o metas tiene a corto plazo a nivel personal, familiar y laboral.","rows"=>5]) !!}
                                </div>
                                   
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                    Metas a largo plazo <span></span> 
                                    </label>
                                    {!! Form::textarea("metas_largo_plazo",$candidatos->metas_largo_plazo,["class"=>"form-control selectcategory","id"=>"metas_largo_plazo","required"=>true,"placeholder"=>"Queremos saber que aspiraciones o metas tiene a largo plazo a nivel personal, familiar y laboral.","rows"=>5]) !!}
                                </div>
                                
                               
                            </div>
                        

                        
                    </div>
                   
        
                   
                
                </div>
            </form>
        </div>

</div>

<style>
 .checkbox-preferencias + .slide:after {
    position: absolute;
    /*content: "NO" !important;*/
 }

.checkbox-preferencias:checked + .slide:after {
   /*content: "SI"  !important;*/
}
</style>

<script type="text/javascript">
    /*$(function(){
        $("#depen_renta").hide();
        $("#declarante_renta").on("change", function () {
            $("#depen_renta").toggle('slow');
        });

        $(".contable_total_ingreso").change(function(){
            let suma=0;
            let data=$(".contable_total_ingreso");
            $.each(data, function(key, element) {
                        suma+=Number(element.value);
                    });
            $("#total_ingresos").val(suma);
            
        });
    });*/
</script>