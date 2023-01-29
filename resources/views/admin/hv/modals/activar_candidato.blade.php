<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Activar Candidato</h4>
</div>
<div class="modal-body">
    {!! Form::model(Request::all(),["id"=>"fr_activar_candidato"]) !!}
    {!! Form::hidden("hv_id",null) !!}
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">Nombre Candidato:</label>
        <div class="col-sm-12">
            {{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">Observaciones:</label>
        <div class="col-sm-12">
            {!! Form::textarea("observaciones",null,["class"=>"form-control","placeholder"=>"Observaciones" ]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>
    {!! Form::close() !!}
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-warning" id="activar_usuario" >Activar</button>
</div>