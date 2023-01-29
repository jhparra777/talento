<div class="panel panel-default item">
        <div class="panel-heading">
            <h3>Observaciones generales de la visita</h3>
        </div>
        <div class="panel-body">
            
            <br>
            <form id="form-11" data-smk-icon="glyphicon-remove-sign" name="form-11" class="formulario">
                <div class="row">

                    <div class="row">
                        
                             

                            <div class="col-md-12 form-group">
                                <label class="col-sm-12 pull-left" for="inputEmail3">
                                    Concepto <span></span> 
                                </label>
                                <div class="col-sm-12">
                                    {!! Form::textarea("concepto_general_visita",$candidatos->concepto_general_visita,["class"=>"form-control selectcategory","id"=>"concepto_general_visita","required"=>true]) !!}
                                </div>
                                <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                            </div>

            
                        
                    </div>
                   
        
                   
                
                </div>
            </form>
        </div>

</div>


