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
                        <th>
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>

                @foreach($data as $field)
                    <tr>
                        <td>{{ $field->numero_id }}</td>
                        <td>{{ $field->nombres . ' ' . $field->primer_apellido . ' ' . $field->segundo_apellido }}</td>
                        <td></td>
                        <td></td>
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
  
  