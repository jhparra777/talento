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
                        $observacion = '';
                        $obs = explode(' - ', $field->observacion);
                        for ($i=1; $i < count($obs); $i++) { 
                            $observacion .= $obs[$i] . ' ';
                        }
                    ?>
                    <tr>
                        <td>{{ $field->modulo }}</td>
                        <td>{{ $field->motivo_descarte_descripcion }}</td>
                        <td>{{ $field->cedula }}</td>
                        <td>{{ $field->nombres . ' ' . $field->primer_apellido . ' ' . $field->segundo_apellido }}</td>
                        <td>{{ $observacion }}</td>
                        <td>{{ dar_formato_fecha($field->created_at, 'corta') }}</td>
                        <td>{{ $field->req_id }}</td>
                        <td>{{ $field->nombre_usuario_gestion }}</td>
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
  
  