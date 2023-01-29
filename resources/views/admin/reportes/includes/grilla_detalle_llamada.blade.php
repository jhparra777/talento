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
            <table class="table ">
                <tr>
                    @foreach($headerss as $key => $value)
                        <th class="active">
                            {{ $value }}
                        </th>
                    @endforeach
                </tr>

                @foreach( $data as $field )
                    <tr>
                        <td>
                            {{ $field->req_id }}
                        </td>

                        <td>
                            {{ $field->nombre_cliente }}
                        </td>

                        <td>
                            {{ $field->cargo }}
                        </td>
                        
                        <td>
                            {{ $field->estado_req }}
                        </td>

                        <td>
                            {{ $field->fecha_llamada }}
                        </td>

                        <td>
                             @if(strlen($field->cedula)>10)
                                {{(string)"\t"."PEP".$field->cedula."\t"}}
                            @else
                                {{$field->cedula}}
                            @endif
                        </td>
                   
                        <td>
                            {{ strtoupper($field->nombres ." ".$field->primer_apellido." ".$field->segundo_apellido) }}
                        </td>
                        
                        <td>
                            {{ $field->celular }}
                        </td>

                        <td>
                            {{ $field->email }}
                        </td>
                        
                        <td>
                            {{ $field->ciudad }}
                        </td>

                        <td>
                            {{ $field->estado_candidato }}
                        </td>

                        <td>
                            {{ $field->usuario_cargo_req }}
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
