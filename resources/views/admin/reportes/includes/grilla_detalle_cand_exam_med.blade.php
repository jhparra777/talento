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
                        {{$field->nombres}} {{$field->primer_apellido}} {{$field->segundo_apellido}}
                    </td>
                    <td>
                        {{$field->requerimiento}}
                    </td>
                    <td>
                        {{$field->cliente}}
                    </td>
                    <td>
                        {{$field->nit}}
                    </td>
                    <td>
                        {{$field->centro_costo}}
                    </td>
                    <td>
                        <ol style="padding-inline-start: 15px;">
                        @foreach($field['examenes_medicos'] as $exam_med)
                            <li>
                                {{$exam_med['fecha_realizacion']}}
                            </li>
                        @endforeach
                        </ol>
                    </td>
                    <td>
                        <ol style="padding-inline-start: 15px;">
                        @foreach($field['examenes_medicos'] as $exam_med)
                            <li>
                                @if($exam_med['resultado'] == 1)
                                    Apto para el cargo
                                @elseif($exam_med['resultado'] == 2)
                                    Aplazado
                                @elseif($exam_med['resultado'] == 3)
                                    Apto con recomendaciones
                                @elseif($exam_med['resultado'] == 4)
                                    Apto con restricciones
                                @elseif($exam_med['resultado'] == 9)
                                    No apto
                                @endif
                            </li>
                        @endforeach
                        </ol>
                    </td>
                    <td>
                        {{$field->usuario_envio}}
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
