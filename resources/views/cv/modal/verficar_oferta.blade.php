<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Confirmación</h4>
</div>
<div class="modal-body">
    @if($ofertaAplicada->count() > 0)
    <p class="set-general-font">
        <strong>Ya!</strong> aplicaste para esta oferta.
    </p>
    @else
    {!! Form::open(["id"=>"fr_oferta_modal"]) !!}
    {!! Form::hidden("id",$id) !!}
    <div class="modal-header">
        <p class="set-general-font">
            Desea aplicar a la oferta?
        </p>
        {!! Form::close() !!}
    </div>
    @endif


    <div class="modal-footer">
        @if($ofertaAplicada->count() == 0)
        <button type="button" class="btn btn-danger-t3" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primario" id="aplica_oferta_modal">Aplicar</button>
        @else
        <button type="button" class="btn btn-danger-t3" data-dismiss="modal">Cerrar</button>
        @endif
    </div>