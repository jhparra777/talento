<div class="panel panel-default item">
        <div class="panel-heading">
            <h3>Información tributaria</h3>
        </div>
        <div class="panel-body">
            
            <br>
            <form id="form-6" data-smk-icon="glyphicon-remove-sign" name="form-6" class="formulario">
                <div class="row">

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                                ¿Es declarante de renta? <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("declarante_renta",1,$candidatos->declarante_renta,["class"=>"si_no","id"=>"declarante_renta"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        
                    </div>
                    <div class="row" id="depen_renta">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                                ¿Saldo a favor? <span></span> 
                            </label>
                            <div class="col-sm-6">
                                 <label class="switchBtn">
                                    {!! Form::checkbox("saldo_favor",1,$candidatos->saldo_favor,["class"=>"si_no","id"=>"saldo_favor"]) !!}
                                    <div class="slide"></div>
                                </label>
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                                Periodo declaración de renta: <span></span> 
                            </label>
                            <div class="col-sm-6">
                                {!! Form::text("periodo_declaracion",$candidatos->periodo_declaracion,["class"=>"form-control selectcategory" ,"id"=>"periodo_declaracion","placeholder"=>"Registrar el periodo y/o el año en que presento su última declaración de renta"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                                Pago total renta <span></span> 
                            </label>
                            <div class="col-sm-6">
                                {!! Form::text("pago_total_renta",$candidatos->pago_total_renta,["class"=>"form-control selectcategory solo_numeros pago_total_renta monto" ,"id"=>"pago_total_renta"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                    </div>
                    @if($current_user->inRole('admin'))
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="col-sm-12 pull-left" for="inputEmail3">
                                    Observaciones <span></span> 
                                </label>
                                <div class="col-sm-12">
                                    {!! Form::textarea("observaciones_renta",$candidatos->observaciones_renta,["class"=>"form-control selectcategory" ,"id"=>"observaciones_renta","required"=>true,"rows"=>5]) !!}
                                </div>
                                <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                            </div>
                        </div>
                    @endif
                    
        
                   
                
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
        $("#depen_renta").hide();
        if( $("#declarante_renta").prop('checked') ) {
             $("#depen_renta").show();
        }
        $("#declarante_renta").on("change", function () {
            $("#depen_renta").toggle('slow');
        });

        
    });
</script>