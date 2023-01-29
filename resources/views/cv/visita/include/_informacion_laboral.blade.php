<div class="panel panel-default item">
        <div class="panel-heading">
             <h3>Información laboral</h3>
        </div>
        <div class="panel-body">
           
            <br>
            <form id="form-8" data-smk-icon="glyphicon-remove-sign" name="form-8" class="formulario">
                <div class="row">

                    <div class="row">
                        
                           <div class="col-md-6 form-group">
                                <label class="col-sm-12 pull-left" for="inputEmail3">
                                    Hace cuanto tiempo labora en la compañía <span>*</span> 
                                </label>
                                <div class="col-sm-12">
                                    {!! Form::text("tiempo_compania",$candidatos->tiempo_compania,["class"=>"form-control solo_numero" ,"id"=>"tiempo_compania","required"=>true,"placeholder"=>"Registrar el numero de años "]) !!}
                                </div>
                                <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="col-sm-12 pull-left" for="inputEmail3">
                                    ¿Con que cargo ingresó a la compañía? <span>*</span> 
                                </label>
                                <div class="col-sm-12">
                                    {!! Form::text("cargo_compania",$candidatos->cargo_compania,["class"=>"form-control solo_numero" ,"id"=>"cargo_compania","required"=>true,"placeholder"=>"Registrar el cargo con el cual ingreso por primera vez a la compañía. "]) !!}
                                </div>
                                <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                            </div>

                            <div class="col-md-12 form-group">
	                            <label class="col-sm-6 pull-left" for="inputEmail3">
	                                ¿Ha tenido algún ascenso durante su permanencia en la compañía? <span></span> 
	                            </label>
	                            <div class="col-sm-6">
	                                 <label class="switchBtn">
	                                    {!! Form::checkbox("ascenso_compania",1,($candidatos->observaciones_ascenso!=null)?1:0,["class"=>"si_no","id"=>"ascenso_compania"]) !!}
	                                    <div class="slide"></div>
	                                </label>
	                            </div>
	                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        	</div>

                        	<div class="row" id="depen_ascenso">
		                        <div class="col-md-12 form-group">
		                            <label class="col-sm-12 pull-left" for="inputEmail3">
		                                    Observaciones ascenso <span></span> 
		                             </label>
		                            <div class="col-sm-12">
		                                    {!! Form::textarea("observaciones_ascenso",$candidatos->observaciones_ascenso,["class"=>"form-control selectcategory" ,"id"=>"observaciones_ascenso","placeholder"=>"Explique detalles sobre su ascenso ","rows"=>5]) !!}
		                             </div>
		                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
		                        </div>
		                    </div>


                        	<div class="col-md-12 form-group">
	                            <label class="col-sm-6 pull-left" for="inputEmail3">
	                                ¿Ha tenido algún encargo durante su permanencia en la compañía? <span></span> 
	                            </label>
	                            <div class="col-sm-6">
	                                 <label class="switchBtn">
	                                    {!! Form::checkbox("encargo_compania",1,($candidatos->observaciones_encargo!=null)?1:0,["class"=>"si_no","id"=>"encargo_compania"]) !!}
	                                    <div class="slide"></div>
	                                </label>
	                            </div>
	                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        	</div>

                        	<div class="row" id="depen_encargo">
		                        <div class="col-md-12 form-group">
		                            <label class="col-sm-12 pull-left" for="inputEmail3">
		                                    Observaciones encargo <span></span> 
		                             </label>
		                            <div class="col-sm-12">
		                                    {!! Form::textarea("observaciones_encargo",$candidatos->observaciones_encargo,["class"=>"form-control selectcategory" ,"id"=>"observaciones_encargo","placeholder"=>"Si le han delegado algunas funciones o cargo temporal sin ratificar por algún periodo de tiempo. Especifique la labor y el tiempo","rows"=>5]) !!}
		                             </div>
		                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
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
	$(function(){
		$("#depen_ascenso").hide();

        $("#depen_encargo").hide();

        if( $("#ascenso_compania").prop('checked') ) {
             $("#depen_ascenso").show();
        }

        $("#ascenso_compania").on("change", function () {
            $("#depen_ascenso").toggle('slow');
        });

         if( $("#encargo_compania").prop('checked') ) {
             $("#depen_encargo").show();
        }

        $("#encargo_compania").on("change", function () {
            $("#depen_encargo").toggle('slow');
        });

	});
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