<div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Datos del Proveedor</h4>

</div>

<div class="modal-body">
    {!! Form::model(Request::all(),["route"=>(!empty($datos["id"]))?"admin.actualizar_candidato_fuente":"admin.guardar_candidato_fuente","id"=>"fr_nuevo_proveedor"]) !!}
                    {{csrf_field()}}
        
        
        
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Nombre</label>

            <div class="col-sm-10">
             {!! Form::text("nombre",null,["class"=>"form-control" ]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>
        </div>
    
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Teléfono</label>
            
            <div class="col-sm-10">
              {!! Form::text("telefono",null,["class"=>"form-control solo-numero" ]); !!}
            </div>
            
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono",$errors) !!}</p>    </div>
    
          

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                
                <div class="col-sm-10">
                  {!! Form::text("email",null,["class"=>"form-control" ]); !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
            </div>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Dirección</label>
                
                <div class="col-sm-10">
                   {!! Form::textarea("direccion",null,["class"=>"form-control","id"=>"textarea","rows"=>"1"]); !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("direccion",$errors) !!}</p>
            </div>

            @foreach($tipos as $tipo)
                <div class="col-sm-6 form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">{{$tipo->tipo}}</label>
                    
                    <div class="col-sm-10">
                       <input type="checkbox" name="tipo[]" value="{{$tipo->id}}">

                    </div>
                    
                    
                </div>

            @endforeach

            
        {!! Form::close() !!}
    <div class="clearfix"></div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_proveedor" >Guardar</button>
</div>