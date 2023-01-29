<div class="container">
    <div class="row">
        @if(method_exists($data, 'total'))
            <h4>
                Total de Registros :
                <span>{{$data->total()}}</span>
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
                            {{$field->numero_requerimiento}}
                        </td>
                        <td>
                            NI
                        </td>
                        <td>
                            {{$field->nit}}
                        </td>
                       <td>
                            
                        </td>
                        <td>
                            {{$field->departamento}}
                        </td>
                        <td></td>
                        <td>
                            1 Menos de 10 empleados
                        </td>
                        <td>
                            8. Establecimientos financieros, seguros, bienes inmuebles, servicios
                        </td>

                         <td>
                            {{$field->fecha_requerimiento}}
                        </td>
                        <td>
                            {{$field->cargo}}
                        </td>
                         <td>
                            {{$field->vacantes}}
                        </td>
                        <td>
                            {{$field->salario}}
                        </td>
                         <td>
                            {{$field->genero}}
                        </td>
                         <td>
                            {{$field->nivel_estudio}}
                        </td>
                          <td>
                            {{$field->cant_enviados_contratacion}}
                        </td>
                        
                        {{--
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
                        --}}
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
