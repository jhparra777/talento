<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Retirar candidato</h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_quitar_candidato"]) !!}
    {!! Form::hidden("candidato_req",$candidato->candidato_req) !!}
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Nombre</label>
        <div class="col-sm-10">
            {{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}
        </div>
    </div>
    <div class="col-md-12 form-group">
        <label for="motivo_descarte_id" class="col-sm-2 control-label">Motivo</label>
        <div class="col-sm-10">
            {!! Form::select("motivo_descarte_id",$motivos,null,["class"=>"form-control", "id"=>"motivo_descarte_id", "required"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_descarte_id",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Observaciones</label>

        <div class="col-sm-12">
            {!! Form::textarea("observaciones",null,["class"=>"form-control", "required"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>
    {!! Form::close() !!}
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="quitar_candidato_fr" >Quitar</button>
</div>