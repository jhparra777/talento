<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Realizar verificación a : <strong>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</strong> </h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_referencia"]) !!}
    {!! Form::hidden("user_id",$candidato->user_id,["id"=>"user_id"]) !!}
    {!! Form::hidden("candidato_req",$candidato->req_candidato,["id"=>"candidato_req_fr"]) !!}
        @if( isset($es_referencia_estudios) )
            Desea enviar a realizar la verificación de las referencias de estudio del candidato?
        @else
            Desea enviar a realizar la verificación de las referencias del candidato?
        @endif
    {!! Form::close() !!}


    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    @if( isset($es_referencia_estudios) )
        <button type="button" class="btn btn-success" id="confirmar_referencia_estudios" >Confirmar</button>
    @else
        <button type="button" class="btn btn-success" id="confirmar_referenciacion" >Confirmar</button>
    @endif
</div>
