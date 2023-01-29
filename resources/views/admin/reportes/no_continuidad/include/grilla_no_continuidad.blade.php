<div class="container">
    <div class="row">
        @if(method_exists($data, 'total'))
            <h4>
                Total de Registros :
                <span>
                    {{ $data->total() }}
                </span>
            </h4>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    @foreach($headers as $header)
                        <th class="active" >
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>

                @foreach($data as $field)
                    <?php
                        $bloque_proceso = '';
                        $procesos = [];
                        $bloque_proceso = explode(', ', $field->bloque_proceso);
                        for ($i=0; $i < count($bloque_proceso); $i++) {
                            $procesos[] = explode(' | ', $bloque_proceso[$i]);
                        }
                        $field->procesos_candidato = $procesos;
                    ?>
                    <tr>
                        <td>{{ dar_formato_fecha($field->fecha_creacion_req, 'corta') }}</td>
                        <td>{{ dar_formato_fecha($field->fecha_ingreso, 'corta') }}</td>
                        <td>{{ $field->req_id }}</td>
                        <td>{{ $field->nombre_cliente }}</td>
                        <td>{{ $field->ciudad_req() }}</td>
                        <td>{{ $field->cargo_req() }}</td>
                        <td>{{ $field->nombres . ' ' . $field->primer_apellido . ' ' . $field->segundo_apellido }}</td>
                        <td>{{ $field->cedula }}</td>
                        <td>{{ $field->telefono_movil }}</td>
                        <td>{{ $field->email }}</td>
                        @foreach($columnas_procesos as $proc)
                            <td>
                            <?php
                                if(count($field->procesos_candidato) > 0) {
                                    $fue_enviado = false;
                                    foreach($field->procesos_candidato as $proceso_candidato) {
                                        if ($proceso_candidato[1] == $proc->nombre_trazabilidad) {
                                            $fue_enviado = true;
                                            switch ($proceso_candidato[0]) {
                                                case 0:
                                                case 2:
                                                    $apto = 'No Apto';
                                                    break;
                                                case 1:
                                                    $apto = 'Apto';
                                                    break;
                                                case 3:
                                                    $apto = 'Pendiente';
                                                    break;
                                                case 4:
                                                    $apto = 'No evaluado';
                                                    break;
                                            }
                                            if ($formato == 'xlsx' && ($apto == 'No Apto' || $apto == 'Apto')) {
                                                echo $apto . '<br>' . $proceso_candidato[2] . '<br>' . $proceso_candidato[3];
                                            } else {
                                                echo $apto . '<br>' . $proceso_candidato[2];
                                            }
                                            break;
                                        }
                                    }
                                    if (!$fue_enviado) {
                                        echo 'No aplica';
                                    }
                                } else {
                                    echo 'No aplica';
                                }
                            ?>
                            </td>
                        @endforeach
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