<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Asignar Analista </h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_asig"]) !!}
    {!! Form::select('psicologo_id',$psicologos,null, ["class"=>"form-control"]) !!}
    {!! Form::hidden('req_id',$req_id) !!}
    {!! Form::hidden('cliente_id',$cliente_id) !!}
    
    {!! Form::close() !!}


    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" id="guardar_asignacion" >Asignar Analista</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>

