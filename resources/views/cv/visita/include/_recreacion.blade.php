<div class="panel panel-default item">
        <div class="panel-heading">
            <h3>Recreación y uso del tiempo familiar</h3>
        </div>
        <div class="panel-body">
            
            <br>
            <form id="form-9" data-smk-icon="glyphicon-remove-sign" name="form-9" class="formulario">
                <div class="row">

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                                Ir al cine <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("ir_cine",1,$candidatos->ir_cine,["class"=>"si_no","id"=>"ir_cine"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                                Visitar centros comerciales <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("ir_centros_comerciales",1,$candidatos->ir_centros_comerciales,["class"=>"si_no","id"=>"ir_centros_comerciales"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                                Salir al parque <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("salir_parque",1,$candidatos->salir_parque,["class"=>"si_no","id"=>"salir_parque"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                               Ver televisión <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("ver_tv",1,$candidatos->ver_tv,["class"=>"si_no","id"=>"ver_tv"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                               Dormir hasta tarde <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("dormir_hasta_tarde",1,$candidatos->dormir_hasta_tarde,["class"=>"si_no","id"=>"dormir_hasta_tarde"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                               Ver películas en familia <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("ver_peliculas",1,$candidatos->ver_peliculas,["class"=>"si_no","id"=>"ver_peliculas"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                               Compartir con amigos <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("comparte_amigos",1,$candidatos->comparte_amigos,["class"=>"si_no","id"=>"comparte_amigos"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        
                    </div>

                    <div class="row" id="depen_amigos">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                    ¿Cada cuánto comparten y qué actividades realizan? <span></span> 
                             </label>
                            <div class="col-sm-12">
                                    {!! Form::textarea("cuanto_comparte_amigos",$candidatos->cuanto_comparte_amigos,["class"=>"form-control selectcategory" ,"id"=>"cuanto_comparte_amigos","placeholder"=>"Registrar cada cuanto comparte con sus amigos y que actividades realizan ","rows"=>5]) !!}
                             </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                               Realizar los quehaceres del hogar <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("realiza_quehaceres",1,$candidatos->realiza_quehaceres,["class"=>"si_no","id"=>"realiza_quehaceres"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                        
                    </div>

                    <div class="row" id="depen_quehaceres">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                    ¿Tiene algún oficio en específico? <span></span> 
                             </label>
                            <div class="col-sm-12">
                                    {!! Form::textarea("oficio_especifico",$candidatos->oficio_especifico,["class"=>"form-control selectcategory" ,"id"=>"oficio_especifico","placeholder"=>"Registrar quien se encarga de los oficios de la casa, si se distribuyen las labores de manera equitativa y/o si tienen algún oficio definido. ","rows"=>5]) !!}
                             </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>
                   
                    
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                    ¿Practica algún deporte? <span></span> 
                             </label>
                            <div class="col-sm-12">
                                    {!! Form::textarea("practica_deporte",$candidatos->practica_deporte,["class"=>"form-control selectcategory" ,"id"=>"practica_deporte","required"=>true,"placeholder"=>"Registrar que deporte practica y/o si no practica ninguno","rows"=>5]) !!}
                             </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                    ¿Cual es su hobby? <span></span> 
                             </label>
                            <div class="col-sm-12">
                                    {!! Form::textarea("tiene_hobby",$candidatos->tiene_hobby,["class"=>"form-control selectcategory" ,"id"=>"practica_deporte","required"=>true,"placeholder"=>"Registrar cuales son sus hobbies","rows"=>5]) !!}
                             </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                    ¿Cada cuánto visita a sus demás familiares? <span></span> 
                             </label>
                            <div class="col-sm-12">
                                    {!! Form::textarea("demas_familiares",$candidatos->demas_familiares,["class"=>"form-control selectcategory" ,"id"=>"demas_familiares","required"=>true,"placeholder"=>"Registrar con qué frecuencia visita a sus familiares, especificar a quienes visita y cada cuanto tiempo","rows"=>5]) !!}
                             </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                    ¿Qué actividades realiza con su familia en su tiempo libre? <span></span> 
                             </label>
                            <div class="col-sm-12">
                                    {!! Form::textarea("actividades_familiares_tiempo_libre",$candidatos->actividades_familiares_tiempo_libre,["class"=>"form-control selectcategory" ,"id"=>"actividades_familiares_tiempo_libre","required"=>true,"placeholder"=>"En este espacio queremos conocer como pasa su tiempo libre, que actividades realiza con su familia cuando descansa entre semana y/o los fines de semana","rows"=>5]) !!}
                             </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
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
    $(function(){
        $("#depen_amigos").hide();
        $("#depen_quehaceres").hide();
        if( $("#comparte_amigos").prop('checked') ) {
             $("#depen_amigos").show();
        }
        if( $("#realiza_quehaceres").prop('checked') ) {
             $("#depen_quehaceres").show();
        }
        $("#comparte_amigos").on("change", function () {
            $("#depen_amigos").toggle('slow');
        });

        $("#realiza_quehaceres").on("change", function () {
            $("#depen_quehaceres").toggle('slow');
        });

        
    });
</script>