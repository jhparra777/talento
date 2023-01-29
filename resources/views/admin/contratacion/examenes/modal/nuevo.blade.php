<div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Datos del Examen</h4>

</div>

<div class="modal-body">
    {!! Form::model(Request::all(),["route"=>(!empty($datos["id"]))?"admin.actualizar_candidato_fuente":"admin.guardar_candidato_fuente","id"=>"fr_nuevo_examen"]) !!}
                    {{csrf_field()}}
        
        
        
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Nombre</label>

                <div class="col-sm-10">
                 {!! Form::text("nombre",null,["class"=>"form-control" ]); !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>
            </div>
    
        

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Descripción</label>
                
                <div class="col-sm-10">
                   {!! Form::textarea("descripcion",null,["class"=>"form-control","id"=>"textarea","rows"=>"1"]); !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>
            </div>

            

            
        {!! Form::close() !!}
    <div class="clearfix"></div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_examen" >Guardar</button>
</div>