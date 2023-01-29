@extends("req.modals._modal_plantilla")

@section("title")
    <h4 class="modal-title"><strong>Rechazar candidato </strong></h4>
    <strong>Candidato</strong> {{ $candidato->nombres." ".$candidato->primer_apellido}} | <strong>{{$candidato->tipo_id_desc}}</strong> {{$candidato->numero_id }}
@stop

@section("body")
    {!! Form::model(Request::all(),["id"=>"fr_rechazar"]) !!}
    {!! Form::hidden("candidato_req",$req_can->id) !!}
    {!! Form::hidden("cliente_id",null) !!}

    <div class="col-md-12 form-group">
            <label for="inputEmail3" class="control-label">Motivo de rechazo</label>
            {!! Form::select ("motivo_rechazo",$motivos_rechazo,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"]); !!}

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_rechazo",$errors) !!}</p>
        </div>

    <div class="col-md-12 form-group">
            <label for="inputEmail3" class="control-label"> Observaciones </label>
            <textarea name="observaciones" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" rows="2">  </textarea>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>
@stop

@section("footer")
    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_rechazo" >Confirmar</button>
@stop
    {!!Form::close()!!}

<script>
    $(function () {
        $("#fecha_fin_contrato, #fecha_inicio_contratos").datepicker(confDatepicker);
    });
</script>