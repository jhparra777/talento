<div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Datos del examen</h4>

</div>

<div class="modal-body">
    {!! Form::model(Request::all(),["route"=>(!empty($datos["id"]))?"admin.actualizar_candidato_fuente":"admin.guardar_candidato_fuente","id"=>"fr_editar_examen"]) !!}
                    {{csrf_field()}}
        
         {!! Form::hidden("id",$examen->id) !!}
        
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Nombre</label>

            <div class="col-sm-10">
             {!! Form::text("nombre",$examen->nombre,["class"=>"form-control" ]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>
        </div>
    
       
          

        

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Descripcion</label>
                
                <div class="col-sm-10">
                   {!! Form::textarea("descripcion",$examen->descripcion,["class"=>"form-control","id"=>"textarea","rows"=>"1"]); !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>
            </div>

            <div class="clearfix"></div>

             <div class="col-sm-10">
                       Activo<input type="checkbox" name="activo" value="1" @if($examen->status==1) checked="true"  @endif>

            </div>

            {{--@foreach($tipos as $tipo)
                <div class="col-sm-6 form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">{{$tipo->tipo}}</label>
                    
                    <div class="col-sm-10">
                       <input type="checkbox" name="tipo[]" value="{{$tipo->id}}">

                    </div>
                    
                    
                </div>

            @endforeach--}}

            
        {!! Form::close() !!}
    <div class="clearfix"></div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_editar_examen" >Confirmar</button>
</div>