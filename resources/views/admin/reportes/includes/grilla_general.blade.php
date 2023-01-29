
<div class="container">
    <div class="row">
        @if(method_exists($data, 'total'))
        <h4>Total de Registros : 
            <span>

                {{$data->total()}}

            </span> 
        </h4>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    @foreach( $headers as $key => $value )
                    <th>{{ $value }}</th>
                    @endforeach
                </tr>
                @foreach( $data as $field )
                <tr>
                    @foreach($campos as $key => $value )
                    <td>{{ strtoupper($field->$value) }}</td>
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


    