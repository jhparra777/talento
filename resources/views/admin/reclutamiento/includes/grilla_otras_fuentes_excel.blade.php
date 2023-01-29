<div class="container">
    <div class="row">
       
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    @foreach( $headers as $key => $value )
                    <th class="active">
                        {{ $value }}
                    </th>
                    @endforeach
                </tr>
                
                   @foreach($data as $field)
                    <tr>
                        <td>
                           {{$field->observaciones}}
                        </td>

                        <td>
                             @if($field->nombres != "")
                                {{$field->nombres }}
                        @else
                                {{ ucwords(mb_strtolower($field->nombreIdentificacion())) }}
                        @endif
                        </td>
                       
                        <td>
                           {{$field->celular}}
                        </td>
                        <td>
                             {{$field->email}}
                        </td>
                        <td>
                             {{$field->empresa}}
                        </td>
                        <td>
                             {{$field->cargo}}
                        </td>
                         <td>
                             {{$field->motivo}}
                        </td>
                        <td>
                             {{$field->trayectoria}}
                        </td>
                        <td>
                            {{$field->reporta}}
                        </td>
                         <td>
                            {{$field->reportan}}
                        </td>
                         <td>
                            {{$field->salario}}
                        </td>
                         <td>
                            {{$field->beneficios}}
                        </td>
                         <td>
                            {{$field->aspiracion}}
                        </td>
                         <td>
                             {{$field->fecha_nacimiento}}
                        </td>
                        
                        <td>
                            {{$field->estado_civil}}
                        </td>
                        <td>
                             {{$field->estudios}}
                        </td>
                         <td>
                             {{$field->idiomas}}
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
