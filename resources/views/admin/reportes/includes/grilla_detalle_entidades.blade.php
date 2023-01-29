	<div class="container">
    <div class="row">
        @if(method_exists($data, 'total'))
        <h4>
            Total de Registros :
            <span>
                {{$data->total()}}
            </span>
        </h4>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    @foreach( $headersr as $key => $value )
                    <th class="active">
                        {{ $value }}
                    </th>
                    @endforeach
                </tr>

                @foreach( $data as $field )
                <tr>
                    <td>
                        {{$field->id_requerimiento}}
                    </td>
                    <td>
                        {{$field->nit}}
                    </td>
                    <td>
                        {{$field->tipo_id}}
                    </td>
                    <td>
                         @if(strlen($field->numero_id)>10)
                            {{(string)"\t"."PEP".$field->numero_id."\t"}}
                        @else
                            {{$field->numero_id}}
                        @endif
                    </td>
                    <td>
                        {{$field->primer_apellido}}
                    </td>
                    <td>
                        {{$field->segundo_apellido}}
                    </td>
                    <td>
                        {{$field->nombres}}
                    </td>
                    <td>
                        {{$field->fecha_nacimiento}}
                    </td>
                    <td>
                        {{$field->estado_civil}}
                    </td>
                    <td>
                        {{$field->sexo}}
                    </td>
                    <td>
                        {{$field->departamento_resi}}
                    </td>
                    <td>
                        {{$field->ciudad_resi}}
                    </td>
                    <td>
                        {{$field->direccion}}
                    </td>
                    <td>
                        {{$field->barrio}}
                    </td>
                    <td>
                        {{$field->telefono_fijo}}
                    </td>
                    <td>
                        {{$field->telefono_movil}}
                    </td>
                    <td>
                        {{$field->email}}
                    </td>
                    <td>
                        {{$field->tipo_contrato_id}}
                    </td>
                    <td>
                        {{$field->descripcion_cargo}}
                    </td>
                    <td>
                        {{$field->salario}}
                    </td>
                    <td>
                        {{$field->fecha_ingreso_req}}
                    </td>
                    <td>
                        {{$field->fecha_ultimo_contrato}}
                    </td>
                    <td>
                        {{$field->eps}}
                    </td>
                    <td>
                        {{$field->afp}}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div>
            @if(method_exists($data, 'appends'))
             {!! $data->appends(Request::all())->render() !!}
             @endif
        </div>
    </div>
</div>
