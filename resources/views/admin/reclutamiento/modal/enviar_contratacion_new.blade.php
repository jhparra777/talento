@extends("admin.reclutamiento.modal.modal_contratacion_new")

@section("title")
    @if( count($candidato) > 0)
        <h4>
            <strong>
                Envío a contratación
            </strong>
        </h4>
        <h5>
            <strong>Candidato</strong> {{ $candidato->nombres." ".$candidato->primer_apellido}} | <strong>{{$candidato->cod_tipo_identificacion}}</strong> {{$candidato->numero_id }}
        </h5>
    @elseif( count($candi_no_cumplen) > 0 )
        <h4>
            <strong>No se puede enviar a contratar al candidato</strong>
        </h4>
    @endif
@stop

@section("body")
    @if(count($candidato) > 0)
        {!! Form::model(Request::all(),["id" => "fr_contratar", "data-smk-icon" => "fa fa-times-circle"]) !!}
            {!! Form::hidden("candidato_req", $candidato->req_candidato, ["id" => "candidato_req_fr"]) !!}
            {!! Form::hidden("cliente_id",null) !!}

            @include("admin.reclutamiento.includes._form_contratacion", ["is_new" => true])
            
        {!! Form::close()!!}
    @endif

    @if(count($candi_no_cumplen) > 0)
    <div class="row">
        <div class="col-md-12">
            <table id="table_users_no_contratados" class="table table-striped">
                <thead>
                    <th>Documento identidad</th>
                    <th>Nombres y apellido</th>
                    <th>Motivo no se envía a contratar</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $candi_no_cumplen->numero_id }}</td>
                        <td>{{ $candi_no_cumplen->nombres ." ". $candi_no_cumplen->primer_apellido }}</td>
                        <td>
                            {{ $candi_no_cumplen->observacion_no_cumple }}
                            @if($candi_no_cumplen->procesos_inconclusos != null)
                                <br>
                                @foreach($candi_no_cumplen->procesos_inconclusos as $proceso)
                                    {{ $proceso->proceso }}
                                    @if($proceso == end($candi_no_cumplen->procesos_inconclusos))
                                        ,
                                    @else
                                        .
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif
@stop

@section("footer")
    @if(count($candidato) > 0)
        <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_contratacion" >Confirmar</button>
    @endif
@stop