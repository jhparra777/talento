<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Enviar retroalimentación a: <strong>{{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }}</strong> </h4>
</div>

<div class="modal-body">
    {!! Form::open(["id" => "fr_retroalimentacion"]) !!}
        {!! Form::hidden("candidato_req", $candidato->req_candidato, ["id" => "candidato_req_fr"]) !!}
    {!! Form::close() !!}

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_retroalimentacion_video" >Confirmar</button>
</div>
