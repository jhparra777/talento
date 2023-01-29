            
<div class="panel panel-default">
        <div class="panel-heading">
            <h3>Referencia vecinal</h3>
        </div>
        <div class="panel-body">
                
            <form id="form-10" data-smk-icon="glyphicon-remove-sign" name="form-10" class="formulario">
            <h5>Referencia vecinal #1</h5>
            <div class="row" style="box-shadow: 3px 3px 5px gray;width: 98%;margin: auto;">
                
                
                    
                
                <div class="col-md-6 form-group">
                    <label class="col-sm-12 pull-left" for="inputEmail3">
                        Nombres y apellidos <span>*</span> 
                    </label>
                    <div class="col-sm-12">
                        {!! Form::text("nombres_apellidos_vecino",$candidatos->nombres_apellidos_vecino,["required","class"=>"
                        form-control","id"=>"nombres_apellidos_vecino"]) !!}
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>

                <div class="col-md-6 form-group">
                    <label class="col-sm-12 pull-left" for="inputEmail3">
                        Parentesco <span>*</span> 
                    </label>
                    <div class="col-sm-12">
                        {!! Form::text("parentesco_vecino",$candidatos->parentesco_vecino,["class"=>"form-control","id"=>"parentesco_vecino","required"=>true]) !!}
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>
                <div class="col-md-6 form-group">
                    <label class="col-sm-12 pull-left" for="inputEmail3">
                        Teléfono fijo o celular <span>*</span> 
                    </label>
                    <div class="col-sm-12">
                        {!! Form::text("telefono_vecino",$candidatos->telefono_vecino,["required","class"=>"
                        form-control solo_numeros","id"=>"telefono_vecino"]) !!}
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>
                <div class="col-md-6 form-group">
                    <label class="col-sm-12 pull-left" for="inputEmail3">
                        Tiempo de conocerlo <span>*</span> 
                    </label>
                    <div class="col-sm-12">
                        {!! Form::text("tiempo_vecino",$candidatos->tiempo_vecino,["required","class"=>"
                        form-control","id"=>"tiempo_vecino"]) !!}
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>

              
            </div>
            <br>
            <br>
            <br>
            <br>
            <h5>Referencia vecinal #2 (Opcional)</h5>
            <div class="row" style="box-shadow: 3px 3px 5px gray;width: 98%;margin: auto;">
                
                <div class="col-md-6 form-group">
                    <label class="col-sm-12 pull-left" for="inputEmail3">
                        Nombres y apellidos <span></span> 
                    </label>
                    <div class="col-sm-12">
                        {!! Form::text("nombres_apellidos_vecino_2",$candidatos->nombres_apellidos_vecino_2,["class"=>"
                        form-control","id"=>"nombres_apellidos_vecino_2"]) !!}
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>

                <div class="col-md-6 form-group">
                    <label class="col-sm-12 pull-left" for="inputEmail3">
                        Parentesco <span></span> 
                    </label>
                    <div class="col-sm-12">
                        {!! Form::text("parentesco_vecino_2",$candidatos->parentesco_vecino_2,["class"=>"form-control","id"=>"parentesco_vecino_2"]) !!}
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>
                <div class="col-md-6 form-group">
                    <label class="col-sm-12 pull-left" for="inputEmail3">
                        Teléfono fijo o celular <span></span> 
                    </label>
                    <div class="col-sm-12">
                        {!! Form::text("telefono_vecino_2",$candidatos->telefono_vecino_2,["class"=>"
                        form-control solo_numeros","id"=>"telefono_vecino_2"]) !!}
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>
                <div class="col-md-6 form-group">
                    <label class="col-sm-12 pull-left" for="inputEmail3">
                        Tiempo de conocerlo <span></span> 
                    </label>
                    <div class="col-sm-12">
                        {!! Form::text("tiempo_vecino_2",$candidatos->tiempo_vecino_2,["class"=>"
                        form-control","id"=>"tiempo_vecino_2"]) !!}
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>

              
            </div>
                
            </form>
        </div>
</div>
