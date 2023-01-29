@extends("admin.reclutamiento.modal.modal_contratacion_new")

@section("title")
    <h4>
        <strong>
            Editar envío a contratación
        </strong>
    </h4>
    <h5>
        <strong>Candidato</strong> {{ ($candidato) ? $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido : "" }}
        | 
        <strong>{{$candidato->cod_tipo_identificacion}}</strong> {{$candidato->numero_id }}
    </h5>
@stop

@section("body")
    {!! Form::model(Request::all(), ["id" => "fr_informacion_contratacion", "data-smk-icon" => "fa fa-times-circle"]) !!}
        {!! Form::hidden("candidato_req", ($candidato) ? $candidato->req_candidato : '', ["id" => "candidato_req_fr"]) !!}
        {!! Form::hidden("cliente_id", null) !!}
        {!! Form::hidden("user_id", $user_id) !!}
        {!! Form::hidden("req_id", $req_id) !!}

        @include("admin.reclutamiento.includes._form_contratacion", ["is_new" => false])

    {!! Form::close()!!}
@stop

@section("footer")
    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_informacion_contratacion">Actualizar</button>
@stop