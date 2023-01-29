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
                        @if(strlen($field->numero_id)>10)
                            {{(string)"\t"."PEP".$field->numero_id."\t"}}
                        @else
                            {{$field->numero_id}}
                        @endif
                    </td>
                    {{--<td>
                        {{$field->primer_apellido}}
                    </td>
                    <td>
                        {{$field->segundo_apellido}}
                    </td>
                    <td>
                        {{$field->nombres}}
                    </td>--}}
                    <td>
                        {{$field->grupo_sanguineo}}{{ ($field->rh == 'positivo' ? '+' : '-') }}
                    </td>
                    <td>
                        {{$field->fecha_altura}}
                    </td>
                    <td>
                        {{$field->nombre_acudiente}}
                    </td>
                    <td>
                        {{$field->telefono_acudiente}}
                    </td>
                    <td>
                        {{$field->parentesco_acudiente}}
                    </td>
                    <td>
                        {{$field->tipo_vivienda}}
                    </td>
                    <td>
                        {{ implode(',', json_decode($field->servicios_publicos)) }}
                    </td>
                    <td>
                        {{ implode(',', json_decode($field->actividades_libres)) }}
                    </td>
                    <td>
                        {{$field->fecha_examen_med}}
                    </td>
                    <td>
                        {{$field->cantidad_personas}}
                    </td>
                    <td>
                        {{$field->aporte_economico}}
                    </td>
                    <td>
                        {{ implode(',', json_decode($field->productos_financieros)) }}
                    </td>
                    <td>
                        {{$field->destina_monto_ahorro}}
                    </td>
                    <td>
                        {{ implode(',', json_decode($field->forma_ahorro)) }}
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
