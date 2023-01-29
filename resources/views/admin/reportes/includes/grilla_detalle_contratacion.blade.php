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
                    <td>
                        {{$field->nombres}}
                    </td>
                    <td>
                        {{$field->primer_apellido}}
                    </td>
                    <td>
                        {{$field->numero_requerimiento}}
                    </td>

                    <td>
                        {{$field->fecha_requerimiento}}
                    </td>
                    <td>
                        {{$field->cliente}}
                    </td>
                    <td>
                         {{$field->cargo}}
                    </td>
                    <td>
                        {{$field->fecha_asociacion}}
                    </td>
                    <td>
                        @if(!is_null($field->fecha_contratacion))
                            {{$field->fecha_contratacion}}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                         @if(!is_null($field->usuario_envio_contratacion))
                        {!! strtoupper(FuncionesGlobales::datosUser($field->usuario_envio_contratacion)->name )!!}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        {{$field->usuario_gestiono_req}}
                    </td>
                     @if($field->fuentes != '' )

                        <td>
                            {{ $field->fuentes }}
                        </td>
                        @else
                    <td>
                       TRABAJECONNOSOTROS.COM.CO
                    </td>
                        @endif  
                    <td>
                        {{$field->estado_candidato}}
                    </td>
                    <td>
                        {{$field->estado_req}}
                    </td>
                    <td>
                        {{$field->fecha_recepcion}}
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
