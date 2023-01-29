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
                    @foreach($headers as $key => $header)
                        <th class="active" >
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>

                @foreach($data as $field)
                    <tr>
                        <td>{{ $field->numero_req }}</td>
                        <td>{{ $field->cedula }}</td>
                        <td>{{ $field->nombre_completo }}</td>
                        <td>{{ $field->fecha_requerimiento }}</td>
                        <td>{{ $field->cliente }}</td>
                        <td>{{ $field->tipo_proceso }}</td>
                        <td>{{ $field->fecha_envio }}</td>
                        <td>{{ $field->nombre_usuario_envio }}</td>
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
  
  