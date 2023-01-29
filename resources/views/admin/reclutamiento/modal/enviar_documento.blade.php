<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
         <h4 class="modal-title">Realizar validación documentos  : <strong>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</strong> </h4>
    @else
        <h4 class="modal-title">Realizar estudio de seguridad  : <strong>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</strong> </h4>
    @endif
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_pruebas"]) !!}
    {!! Form::hidden("user_id",$candidato->user_id,["id"=>"user_id"]) !!}
    {!! Form::hidden("candidato_req",$candidato->req_candidato,["id"=>"candidato_req_fr"]) !!}
    @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
        Desea enviar a este candidato a validar documentos.
    @else
        Desea enviar a este candidato a estudio de seguridad.
    @endif
    {!! Form::close() !!}


    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_documentos" >Confirmar</button>
</div>
