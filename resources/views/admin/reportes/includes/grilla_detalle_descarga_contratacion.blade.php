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
                        {{$field->cliente_id}}
                        
                    </td>
                    <td>
                        C
                    </td>
                    <td>
                         @if(strlen($field->cedula)>10)
                            {{(string)"\t"."PEP".$field->cedula."\t"}}
                        @else
                            {{$field->cedula}}
                        @endif
                    </td>
                     <td>
                        {{$field->dpto_exp}}
                    </td>
                     <td>
                        170
                    </td>
                     <td>
                           {{$field->ciudad_exp}}
                    </td>
                     <td>
                        
                    </td>

                   <td>
                        {{$field->primer_apellido}}  {{$field->segundo_apellido}}
                    </td>
                   <td>
                       {{$field->primer_nombre}} {{$field->segundo_nombre}}
                    </td>
                    <td>
                       C
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        @if($field->genero==1)
                            M
                        @elseif($field->genero==2)
                            F

                        @endif
                        
                    </td>
                    <td>
                       {{$field->clase_libreta}}
                    </td>
                    <td>
                        {{$field->libreta}}
                    </td>
                    <td>
                        {{$field->distrito_militar}}
                    </td>
                    <td>
                        {{$field->pais}}
                    </td>
                    <td>
                        {{$field->departamento}}
                    </td>
                    <td>{{$field->ciudad}}</td>
                    <td> {{$field->fecha_nacimiento}}</td>
                    <td>170</td>
                    <td>{{$field->departamento_resi}}</td>
                    <td>{{$field->ciudad_resi}}</td>
                    <td>{{$field->direccion}}</td>
                    <td>{{$field->barrio}}</td>
                    <td></td>
                    <td>{{$field->telefono_fijo}}</td>
                    <td>{{$field->estado_civil}}</td>
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
