	<div class="container">
    <div class="row">
        @if($busqueda)
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
                   <td>{{$field->nombres}}</td>
                    <td>{{$field->fecha_nacimiento}}</td>
                     <td>{{$field->email}}</td>
                      <td>{{$field->telefono_movil}}</td>
                       <td>{{$field->genero}}</td>
                        <td>{{$field->cargo}}</td>
                        <td>universitario</td>
               </tr>
                @endforeach
            </table>
        </div>
        <div>
            @if(method_exists($data, 'appends'))
             {!! $data->appends(Request::all())->render() !!}
             @endif
        </div>

        @endif
    </div>
</div>
