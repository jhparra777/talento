<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    <h4 class="modal-title">
    @if(count($candidatos) > 0)
        @if(count($candidatos) > 1)
            <h5><strong>¿Enviar a {{ $configuracion_sst->titulo_prueba }} a estos {{ count($candidatos) }} candidatos?</strong></h5> 
        @else
            <h5><strong>¿Enviar a {{ $configuracion_sst->titulo_prueba }} a este candidato?</strong></h5>
        @endif
        @foreach ($candidatos as $key => $candidato)
            <strong>{{ $candidato->numero_id." ".$candidato->nombres." ".$candidato->primer_apellido }}</strong>
            @if($key%2)
                <br>
            @else
                 ,
            @endif
        @endforeach
    @endif
    </h4>
</div>

<div class="modal-body">
    @if(count($candidatos) > 0)
        {!! Form::model(Request::all(), ["id" => "fr_evaluacion_sst_masivo"]) !!}
            {!! Form::hidden("candidato_req", $req_can_ids, ["id" => "candidato_req"]) !!}
        {!! Form::close() !!}
    @endif
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    @if(count($candidatos) > 0)
        <button type="button" class="btn btn-success" id="confirmar_evaluacion_sst_masivo" >Enviar</button>
    @endif
</div>