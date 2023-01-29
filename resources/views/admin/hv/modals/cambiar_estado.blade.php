<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Cambiar Estado</h4>
</div>
<div class="modal-body">
    {!! Form::model(Request::all(),["id"=>"fr_cambio_estado"]) !!}
    {!! Form::hidden("hv_id",null) !!}
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label"><strong>Nombre Candidato:</strong></label>
        <div class="col-sm-12">
            {{ strtoupper($candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido) }}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label"><strong>Número Identificación:</strong></label>
        <div class="col-sm-12">
            {{ $candidato->numero_id }}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label"><strong>Seleccionar Estado:</strong></label>
        <div class="col-sm-12">
            {!! Form::select("ESTADO_ID",$estado,null,["class"=>"form-control","id"=>"ESTADO_ID"]) !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_id",$errors) !!}</p>
    </div>
    @if($candidato->getEstado()=="INACTIVO"||$candidato->getEstado()=="QUITAR")
     <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">
            <strong>Observaciones:</strong> 
        </label>
        <div class="col-sm-12">
            {!! Form::textarea("observaciones",null,["class"=>"form-control","placeholder"=>"Observaciones" ]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>
    @else
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">
            <strong>Motivo Rechazo</strong> 
        </label>
        <div class="col-sm-12">
            {!! Form::select("motivo_rechazo_id",$motivos,null,["class"=>"form-control","id"=>"motivo_rechazo_id"]) !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_rechazo_id",$errors) !!}</p>
    </div>
     <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">
            <strong>Observaciones:</strong> 
        </label>
        <div class="col-sm-12">
            {!! Form::textarea("observaciones",null,["class"=>"form-control","placeholder"=>"Observaciones" ]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>
    @endif
    
    

    {!! Form::close() !!}
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-warning" id="guardar_estado" >Guardar</button>
</div>