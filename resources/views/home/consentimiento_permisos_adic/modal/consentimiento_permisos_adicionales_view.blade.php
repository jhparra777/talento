<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <div class="modal-title">
		<h4>
            <strong>
                {{$consentimientos_config->titulo_modal_envio}}
            </strong>
        </h4>
        <h5>
            <strong>Candidato</strong> {{ $candidato->nombres." ".$candidato->primer_apellido}} | <strong>{{$candidato->cod_tipo_identificacion}}</strong> {{$candidato->numero_id }}
        </h5>
    </div>
</div>

<div class="modal-body">
	{!! Form::model(Request::all(),["id" => "fr_consentimientos_permisos"]) !!}
        {!! Form::hidden("candidato_req", $candidato->req_candidato, ["id" => "candidato_req_fr"]) !!}

    	<p>{!!$consentimientos_config->cuerpo_modal_envio!!}</p>
        
    {!! Form::close()!!}
    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_envio_consentimiento_permisos_adic">Confirmar</button>
</div>