<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Realizar validación de asistencia  : 
    
        @foreach($datos_basicos as $candi)
        <strong><br>{{mb_strtoupper($candi)}}</strong>
        @endforeach 
</h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_asis_masi"]) !!}
    {!! Form::hidden("req_can_id",$req_can_id_j,["id"=>"candidato_req_fr"]) !!}
    {!! Form::hidden("req_id",$req_id) !!}
    ¿Desea enviar a estos candidatos a validar asistencia?
    {!! Form::close() !!}


    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_asistencia_masivo" >Confirmar</button>
</div>