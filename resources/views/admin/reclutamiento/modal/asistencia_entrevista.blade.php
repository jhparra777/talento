<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Asistencia de entrevista de  : <strong>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</strong> </h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_asistencia"]) !!}
    {!! Form::hidden("candidato_req",$candidato->req_candidato,["id"=>"candidato_req_fr"]) !!}
    {!! Form::hidden("req_id",$candidato->req_id) !!}
    {!! Form::hidden("candidato_id",$candidato->candidato_id) !!}
   ¿ El candidato asistió a la entrevista?
    {!! Form::close() !!}


    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" id="realizar_asistencia" >Si</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>

