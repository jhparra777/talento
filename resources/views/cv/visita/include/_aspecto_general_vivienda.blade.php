<div class="panel panel-default item">
        <div class="panel-heading">
            <h3>Aspectos generales de la vivienda</h3>
        </div>
        <div class="panel-body">
            
            <form id="form-3" data-smk-icon="glyphicon-remove-sign" name="form-3" class="formulario">
                <div class="row">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Tipo vivienda <span></span> 
                                </label>
                                
                                    {!! Form::select("tipo_vivienda",$tipoVivienda,$candidatos->tipo_vivienda,["class"=>"form-control selectcategory","id"=>"tipo_vivienda","required"=>true]) !!}
                            
                            
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Propiedad <span></span> 
                                </label>
                                
                                    {!! Form::select("propiedad",$tipoPropiedad,$candidatos->propiedad,["class"=>"form-control selectcategory" ,"id"=>"propiedad","required"=>true]) !!}
                            
                           
                            </div>
                        </div>


                    </div>
                    <div class="row" id="depen_propiedad">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Nombre del arrendador <span>*</span> 
                                </label>
                               
                                    {!! Form::text("nombre_arrendador",$candidatos->nombre_arrendador,["class"=>"form-control selectcategory" ,"id"=>"nombre_arrendador"]) !!}
                               
                                
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Teléfono arrendador <span>*</span> 
                                </label>
                                
                                    {!! Form::text("telefono_arrendador",$candidatos->telefono_arrendador,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"telefono_arrendador"]) !!}
                                
                                
                            </div> 
                         </div>
                    </div>
                     
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Nro de familias que habitan <span>*</span> 
                                </label>
                               
                                    {!! Form::text("nro_familias",$candidatos->nro_familias,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"nro_familias","required"=>true]) !!}
                            
                            
                            </div>  
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Nro de pisos <span>*</span> 
                                </label>
                                
                                    {!! Form::text("nro_pisos",$candidatos->nro_pisos,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"nro_pisos","required"=>true]) !!}
                                
                           
                            </div> 
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Estrato <span>*</span> 
                                </label>
                                
                                    {!! Form::text("estrato",$candidatos->estrato,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"estrato","required"=>true,"data-smk-min"=>"1","data-smk-max"=>"6","data-smk-type"=>"number"]) !!}
                                
                            
                            </div>  
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Nro de personas que habitan <span>*</span> 
                                </label>
                                
                                    {!! Form::text("nro_personas",$candidatos->nro_personas,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"nro_personas","required"=>true]) !!}
                           
                            
                            </div>  
                        </div>


                    </div>
                     <div class="row">
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Localidad <span></span> 
                                </label>
                                
                                    {!! Form::text("localidad_id",$candidatos->localidad_id,["class"=>"form-control " ,"id"=>"localidad_id"]) !!}
                            
                            
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Sector <span>*</span> 
                                </label>
                                
                                    {!! Form::select("sector",$sector,$candidatos->sector,["class"=>"form-control selectcategory" ,"id"=>"sector","required"=>true]) !!}
                            
                            
                            </div>  
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Facilidades de transporte del sector <span>*</span> 
                                </label>
                                
                                    {!! Form::select("facilidades_transporte",["1"=>"Bueno","2"=>"Regular","3"=>"Malo"],$candidatos->facilidades_transporte,["class"=>"form-control selectcategory" ,"id"=>"facilidades_transporte","required"=>true]) !!}
                            
                            
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Tiempo de traslado desde la vivienda hasta el trabajo <span>*</span> 
                                </label>
                                
                                    {!! Form::text("tiempo_trabajo",$candidatos->tiempo_trabajo,["class"=>"form-control selectcategory" ,"id"=>"tiempo_trabajo"]) !!}
                           
                            
                            </div> 
                        </div>
                    </div>
                    
                    <div class="row">
                        

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Medio utilizado para desplazarse hasta el trabajo<span>*</span> 
                                </label>
                                
                                    {!! Form::select("medio_utilizado",$medioTransporte,$candidatos->medio_utilizado,["required","class"=>"form-control selectcategory" ,"id"=>"medio_utilizado"]) !!}
                            
                            
                            </div>  
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Tiempo de residencia en la vivienda <span>*</span> 
                                </label>
                                
                                    {!! Form::text("tiempo_residencia_vivienda",$candidatos->tiempo_residencia_vivienda,["class"=>"form-control selectcategory" ,"id"=>"tiempo_residencia_vivienda"]) !!}
                            
                            
                            </div> 
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-sm-6 control-label" for="inputEmail3">
                                ¿En el sector hay presencia de milicias? <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("hay_milicias",1,$candidatos->hay_milicias,["class"=>"si_no","id"=>"hay_milicias"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 control-label" for="inputEmail3">
                                ¿En el sector hay presencia de pandillas? <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("hay_pandillas",1,$candidatos->hay_pandillas,["class"=>"si_no","id"=>"hay_pandillas"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 control-label" for="inputEmail3">
                                ¿En el sector hay presencia de habitantes de la calle? <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("hay_habitantes_calle",1,$candidatos->hay_habitantes_calle,["class"=>"si_no","id"=>"hay_habitantes_calle"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 control-label" for="inputEmail3">
                                ¿En el sector hay presencia de delincuencia común? <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("hay_delincuencia",1,$candidatos->hay_delincuencia,["class"=>"si_no","id"=>"hay_delincuencia"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                        Observaciones <span>*</span> 
                                </label>
                                
                                        {!! Form::textarea("observaciones_hurto",$candidatos->observaciones_hurto,["class"=>"form-control" ,"id"=>"observaciones_hurto","required"=>true,"placeholder"=>"En este espacio, queremos saber si  ha sido víctima de hurto en el sector donde reside y/o si ha presenciado algún hurto, si cerca a su residencia se encuentra un CAI o estación de policía.","rows"=>3]) !!}
                            
                            
                            </div>  
                        </div>
                        

                        
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Material predominante en la construcción de la vivienda</h4>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Techo<span>*</span> 
                                </label>
                                
                                    {!! Form::select("material_techo",$material_techo,$candidatos->material_techo,["class"=>"form-control selectcategory" ,"id"=>"material_techo","required"=>true]) !!}
                           
                             
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Paredes <span>*</span> 
                                </label>
                               
                                    {!! Form::select("material_paredes",$material_paredes,$candidatos->material_paredes,["class"=>"form-control selectcategory" ,"id"=>"material_paredes","required"=>true]) !!}
                           
                            
                            </div> 
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Piso <span>*</span> 
                                </label>
                                
                                    {!! Form::select("material_piso",$material_piso,$candidatos->material_piso,["class"=>"form-control selectcategory" ,"id"=>"material_piso","required"=>true]) !!}
                                
                            
                            </div> 
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Distribución espacial de la vivienda</h4>
                        </div>
                        
                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Habitaciones <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("habitaciones",($candidatos->gestionado_candidato)?$distribucion_espacial["habitaciones"]:"0",["class"=>"form-control selectcategory solo_numeros" ,"id"=>"habitaciones","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Baños <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("banos",($candidatos->gestionado_candidato)?$distribucion_espacial["banos"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"baños","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Cocina <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("cocina",($candidatos->gestionado_candidato)?$distribucion_espacial["cocina"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"cocina","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                         <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Sala <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("sala",($candidatos->gestionado_candidato)?$distribucion_espacial["sala"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"sala","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Patio <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("patio",($candidatos->gestionado_candidato)?$distribucion_espacial["patio"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"patio","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Comedor <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("comedor",($candidatos->gestionado_candidato)?$distribucion_espacial["comedor"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"comedor","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Garaje <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("garage",($candidatos->gestionado_candidato)?$distribucion_espacial["garage"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"garage","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Estudio <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("estudio",($candidatos->gestionado_candidato)?$distribucion_espacial["estudio"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"estudio","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Mobiliario</h4>
                        </div>
                        
                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Televisor <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("televisor",($candidatos->gestionado_candidato)?$mobiliario["televisor"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"televisor","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Lavadora <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("lavadora",($candidatos->gestionado_candidato)?$mobiliario["lavadora"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"lavadora","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Estéreo <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("estereo",($candidatos->gestionado_candidato)?$mobiliario["estereo"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"estereo","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                         <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Nevera <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("nevera",($candidatos->gestionado_candidato)?$mobiliario["nevera"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"nevera","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                DVD/Teatro en casa <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("dvd",($candidatos->gestionado_candidato)?$mobiliario["dvd"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"dvd","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Video juegos <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("video_juegos",($candidatos->gestionado_candidato)?$mobiliario["video_juegos"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"video_juegos","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Estufa <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("estufa",($candidatos->gestionado_candidato)?$mobiliario["estufa"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"estufa","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Horno microondas <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("microondas",($candidatos->gestionado_candidato)?$mobiliario["microondas"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"microondas","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Computador de escritorio <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("pc",($candidatos->gestionado_candidato)?$mobiliario["pc"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"pc","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Computador portátil <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("portatil",($candidatos->gestionado_candidato)?$mobiliario["portatil"]:0,["class"=>"form-control selectcategory solo_numeros" ,"id"=>"portatil","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                        
                    </div>
                    @if($current_user->inRole('admin'))
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Datos generales</h4>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="col-sm-6 control-label" for="inputEmail3">
                                    Orden y aseo durante la entrevista:  <span>*</span> 
                                </label>
                                <div class="col-sm-6">
                                    {!! Form::select("orden_entrevista",["1"=>"Bueno","2"=>"Regular","3"=>"Malo"],$candidatos->orden_entrevista,["class"=>"form-control selectcategory" ,"id"=>"orden_entrevista","required"=>true]) !!}
                                </div>
                                <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                            </div>

                             <div class="col-md-12 form-group">
                                <label class="col-sm-12 control-label" for="inputEmail3">
                                    Observaciones generales de la vivienda <span>*</span> 
                                </label>
                                <div class="col-sm-12">
                                    {!! Form::textarea("observaciones_generales_vivienda",$candidatos->observaciones_generales_vivienda,["class"=>"form-control" ,"id"=>"observaciones_generales_vivienda","required"=>true,"rows"=>5]) !!}
                                </div>
                                <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                            </div>
                        </div>
                       
                    @endif
                
                </div>
            </form>
        </div>

</div>

<script type="text/javascript">
    $(function(){
        
         $("#depen_propiedad").hide();
        if($("#propiedad").val()==3){
            $("#depen_propiedad").toggle('slow');
            $("#nombre_arrendador,#telefono_arrendador").attr("required","required");
        }
        $("#propiedad").on("change", function () {
            if($(this).val()==3){
               $("#depen_propiedad").toggle('slow');
                $("#nombre_arrendador,#telefono_arrendador").attr("required","required")
            }
            else{
                $("#depen_propiedad").hide();
                $("#nombre_arrendador,#telefono_arrendador").removeAttr("required")
            }

            
        });
    });
</script>