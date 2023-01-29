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
        
        <!-- Datos Basicos -->
        <div class="table-responsive">
            <table class="table ">
                <tr>
                    @foreach( $headerss as $key => $value )
                        <th class="active">
                            {{ $value }}
                        </th>
                    @endforeach
                </tr>

                @foreach( $data as $field )
                    <tr>
                        <td>
                            {{$field->req_id}}
                        </td>

                        <td>
                            {{$field->nombre_cliente}}
                        </td>

                        <td>
                            {{$field->cargo}}
                        </td>
                        
                        <td>
                            {{$field->estado_req}}
                        </td>

                        @if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co")
                            <td>
                                @if($field->tipo_mensaje == 1)
                                    entrevista
                                @endif
                            
                                @if($field->tipo_mensaje == 2)
                                    entrevista con empresa
                                @endif
                                
                                @if($field->tipo_mensaje == 3)
                                    contratacion
                                @endif
                            </td>
                        @endif

                        <td>
                            {{$field->fecha_llamada}}
                        </td>
                        
                        <td>
                            {{$field->fecha_hora_asistencia}}
                        </td>

                        <td>
                            {{ (($field->asistencia===null)?"NO HA RESPONDIDO": (($field->asistencia==1)?"Si":"No"))  }}
                        </td>

                        <td>
                            @if(strlen($field->cedula)>10)
                                 {{(string)"\t"."P".$field->cedula."\t"}}
                            @else
                                {{$field->cedula}}
                            @endif
                        </td>
                   
                        <td>
                            {{ strtoupper($field->nombres ." ".$field->primer_apellido." ".$field->segundo_apellido) }}
                        </td>

                        <td>
                            {{$field->celular}}
                        </td>

                        <td>
                            {{$field->email}}
                        </td>

                        <td>
                            {{$field->ciudad}}
                        </td>

                        <td>
                            {{$field->estado_candidato}}
                        </td>
                            
                        <td>
                            {{$field->usuario_cargo_req}}
                        </td>

                        <td>
                            {{ $field->contenido_sms }}
                        </td>

                        <td>
                            <a type="button" class="btn btn-sm btn-info" href="{{route("admin.hv_pdf",["user_id"=>$field->user_asistencia_id])}}" target="_blank">HV PDF</a> 
                            <a target="_blank" href="https://api.whatsapp.com/send?phone={!! env('INDICATIVO','57') !!}{{ $field->celular}}&text=Hola!%20{{$field->nombres}} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}},%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección." class="btn  btn-block  btn-success aplicar_oferta"><span class="fa fa-whatsapp fa-lg" aria-hidden="true"></span></a>
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
