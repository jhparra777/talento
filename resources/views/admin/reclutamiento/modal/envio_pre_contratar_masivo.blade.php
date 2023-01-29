<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    <h4 class="modal-title">
    @if(count($candidatos) > 0)
        @if(count($candidatos) > 1)
            <h5><strong>¿Enviar a pre-contratar a estos {{ count($candidatos) }} candidatos?</strong></h5> 
        @else
            <h5><strong>¿Enviar a pre-contratar a este candidato?</strong></h5>
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
        {!! Form::model(Request::all(), ["id" => "fr_pre_contratar_masivo"]) !!}
            {!! Form::hidden("candidato_req", $req_can_id_j, ["id" => "candidato_req"]) !!}
        {!! Form::close() !!}
    @endif

    @if(count($candi_no_cumplen) > 0)
        <p>Los siguientes candidatos debe tener <b>completos</b> los datos para su envío a pre-contratar.</p>
        <ul>
            @foreach ($candi_no_cumplen as $key => $candidato)
                <li>
                    <strong>{{ $candidato->numero_id." ".$candidato->nombres." ".$candidato->primer_apellido }}</strong>
                </li>
            @endforeach
        </ul>
        <br>
        <p>Ingresa a su hoja de vida y actualiza sus datos básicos como:</p>
        <p>
            Tipo de documento,
            Dirección,
            Eps,
            Afp,
            Fecha de expedición documento,
            Fecha de nacimiento,
            Lugar de residencia,
            Teléfono,
            Lugar expedición
        </p>
    @endif
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    @if(count($candidatos) > 0)
        <button type="button" class="btn btn-success" id="confirmar_pre_contratar_masivo" >Enviar</button>
    @endif
</div>