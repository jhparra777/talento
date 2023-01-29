<div class="modal-header">
  	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
   	<h4 class="modal-title">{{ $configuracion_sst->titulo_modal }}</h4>
</div>
<div class="modal-body">
  	{!! Form::open(["id"=>"fr_evaluacion"]) !!}
  		{!! Form::hidden("candidato_req",$candidato->req_candidato,["id"=>"candidato_req_fr"]) !!}
    	{!! $configuracion_sst->texto_modal !!}
  	{!! Form::close() !!}
</div>
<div class="modal-footer">
  	<button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
  	<button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_envio_evaluacion_sst" >Confirmar</button>
</div>