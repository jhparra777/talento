<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">reabrir proceso :<strong>{{$proceso}}</strong>. {{$candidato}}</h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_reabrir_proceso"]) !!}
    {!! Form::hidden("proceso_id",$proceso_id,["id"=>"user_id"]) !!}
    
    ¿Desea reabrir este proceso?
    {!! Form::close() !!}


    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_reabrir_proceso" >Confirmar</button>
</div>

<script type="text/javascript">
    

</script>