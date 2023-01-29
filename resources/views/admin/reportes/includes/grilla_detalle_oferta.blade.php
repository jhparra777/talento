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
                            {{$field->user_id}}
                        </td>
                        <td>
                            CC
                        </td>
                        <td>
                            @if(strlen($field->cedula)>10)
                                {{(string)"\t"."PEP".$field->cedula."\t"}}
                            @else
                                {{$field->cedula}}
                            @endif
                        </td>
                       <td>
                            {{$field->primer_apellido}}
                        </td>
                        <td>
                            {{$field->segundo_apellido}}
                        </td>
                        <td>
                            {{$field->primer_nombre}}
                        </td>
                        <td>
                            
                            {{$field->segundo_nombre}}
                        </td>
                        <td>
                            {{$field->fecha_nacimiento}}
                        </td>
                        <td>
                            {{$field->genero}}
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            NO APLICA
                        </td>
                        <td>
                            {{$field->cargo}}
                        </td>
                        <td>{{$field->estado_contrato}}</td>
                        <td>{{$field->fecha_inicio}}</td>
                        <td>{{$field->fecha_fin}}</td>
                        <td>{{$field->salario}}</td>
                        <td>{{$field->nit_cliente}}</td>
                        <td>
                            <?php
                                $date1 = new DateTime($field->fecha_inicio);
                                $date2 = new DateTime($field->fecha_fin);
                                $diff = $date1->diff($date2);
                                // will output 2 days
                                echo $diff->days;
                            ?>
                        </td>
                        <td>Dia(s)</td>
                        <td>
                            {{$field->motivo}}
                        </td>

                        {{--<td>
                                {{$field->numero_requerimiento}}
                            </td>
                            <td>
                                {{$field->fecha_asociacion}}
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
