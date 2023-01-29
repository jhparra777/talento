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
                @if($data==null)
                    
                @else
                     @foreach( $data as $field )
                <tr>
                    <td>
                        {{$field->numero_requerimiento}}
                    </td>
                    <td>
                        {{$field->cargo}}
                       
                    </td>
                    <td>
                       {{$field->cliente}}
                    </td>
                    <td>
                         {{$field->ciudad_req}}
                    </td>

                    <td>
                         {{$field->agencia}}
                    </td>
                    </td>
                    <td>
                        @if($field->usuario_req!=null)
                            {!! strtoupper(FuncionesGlobales::datosUser($field->usuario_req)->name )!!}
                        @endif
                    </td>
                    <td>
                         {{$field->fecha_requerimiento}}
                    </td>
                    <td>
                        {{$field->estado_req}}
                    </td>
                    <td>
                       {{$field->vacantes}}
                    </td>
                    <td>
                       {{$field->candidatos_asociados}}
                    </td>
                    <td>
                         @if(strlen($field->numero_id)>10)
                            {{(string)"\t"."PEP".$field->numero_id."\t"}}
                        @else
                            {{$field->numero_id}}
                        @endif
                    </td>
                    <td>
                         {{$field->nombres}}
                    </td>
                    <td>
                         {{$field->primer_apellido}}
                    </td>

                    <td>
                         {{$field->email}}
                    </td>

                    <td>
                        {{$field->fecha_nacimiento}}
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        {{$field->genero}}
                    </td>
                    <td>
                        {{$field->fecha_registro}}
                    </td>
                    <td>
                        {{$field->fecha_actualizacion}}
                    </td>
                    <td>
                        @if($field->usuario_cargo!=null)
                            Carga masiva
                        @else

                        Portal de reclutamiento

                         @w
                    </td>
                      <td>
                        @if($field->usuario_cargo!=null)
                            {!! strtoupper(FuncionesGlobales::datosUser($field->usuario_cargo)->name )!!}
                        @endif
                    </td>
                    
                   
                   
                </tr>
                @endforeach
                @endif
               
            </table>


        </div>
        <div>
            @if(method_exists($data, 'appends'))
             {!! $data->appends(Request::all())->render() !!}
             @endif
        </div>
    </div>
</div>
