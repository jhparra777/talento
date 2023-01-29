<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    <h4 class="modal-title">
    @if(count($candidato) > 0)
        <h5>
            <strong>
                {{ "¿Enviar a pre-contratar a ".$candidato->numero_id." ".$candidato->nombres." ".$candidato->primer_apellido."?" }}
            </strong>
        </h5>
    @endif
    </h4>
</div>

<div class="modal-body">
    @if(count($candidato) > 0)
    {!! Form::model(Request::all(), ["id" => "fr_pre_contratar"]) !!}
        {!! Form::hidden("candidato_req", $candidato->req_candidato, ["id" => "candidato_req"]) !!}

        @if($candidato->porcentaje < 100)
            <p>Ups... este candidato aún no ha cargado el <b>100%</b> de los documentos a la plataforma. ¿Deseas enviarlo a pre-contratar de todos modos?</p>
        @else
            <p>¿Enviar a pre-contratar a este candidato/a?</p>
        @endif
    {!! Form::close() !!}
    @endif
    @if(count($candi_no_cumplen) > 0)
        <?php $no_cumple = $candi_no_cumplen->first(); ?>

        @if($no_cumple->observacion_no_cumple['tipo'] == 1)
            <p>El candidato o la candidata <b>{{ $no_cumple->numero_id." ".$no_cumple->nombres." ".$no_cumple->primer_apellido }}</b> debe tener <b>completos</b> los datos para su envío a pre-contratar.</p>
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
        @else
            <p>El candidato o la candidata <b>{{ $no_cumple->numero_id." ".$no_cumple->nombres." ".$no_cumple->primer_apellido }}</b> ya se encuentra en proceso de pre-contratación o contratación y no se puede enviar a pre-contratar</p>
        @endif
    @endif
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
    @if(count($candidato) > 0)
        <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300" id="pre_contratar_enviar" >Enviar</button>
    @endif
</div>