<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Editar Pregunta</h4>
</div>

<div class="modal-body">
    {!! Form::model(Request::all(),["id"=>"fr_editar_pregunta_prueba"]) !!}
        
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <p>Aquí podrá editar la pregunta seleccionada</p>
            </div>
        </div>
       
        <h3 style="text-align: center;">Pregunta</h3>
        <br>
        <div class="clearfix"></div> 

        <div class="col-md-12 form-group">
            <div class="col-sm-8">
                {!! Form::text("descripcion",$pregunta_prueba->descripcion,["class"=>"form-control","id"=>"descripcion","placeholder"=>"Escriba su pregunta"]); !!}
                {!! Form::hidden("pregu_id",$pregunta_prueba->id) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::select("tiempo",["45"=>"Tiempo estimado de respuesta","20"=>"20 s.","30"=>"30 s.","40"=>"40 s.","50"=>"50 s.","60"=>"60 s."],$pregunta_prueba->tiempo,["class"=>"form-control","id"=>"tiempo"]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>
        </div>
        
        <div class="clearfix"></div>
        <br><br>

        <div class="clearfix"></div>

    {!! Form::close() !!}
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="actualizar_pregunta_idioma" >Guardar</button>
</div>
