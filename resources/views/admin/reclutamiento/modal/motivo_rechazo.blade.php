<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Rechazar candidato </h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_rechazo"]) !!}
    {!! Form::hidden("candidato_req",$candidato->req_candidato,["id"=>"candidato_req_fr"]) !!}

    <p>
        Llene el formulario con las razones por las cuales va a rechazar el candidato  <strong>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</strong>.
    </p>

    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Motivo Rechazo</label>
        <div class="col-sm-8">
            {!! Form::select("motivo_rechazo_id",$motivos,null,["class"=>"form-control"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_rechazo_id",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"> Observaciones Rechazo</label>
        <div class="col-sm-8">
            {!! Form::textarea("observaciones",null,["class"=>"form-control"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>

    {!! Form::close() !!}


    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

    <button type="button" class="btn btn-success" id="rechazar_candidato" >Confirmar</button>

</div>
