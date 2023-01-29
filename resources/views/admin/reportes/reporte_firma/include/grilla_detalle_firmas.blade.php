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
            <?php $suma = 0; $calidad = 0;?>

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
                        <td>{{ $field->numero_req }}</td> {{-- Num req --}}
                        <td>{{ $field->fecha_creacion_req }}</td>
                        <td>{{ $field->tipo_proceso }}</td> {{-- Tipo de proceso --}}
                        <td>{{ $field->agencia }}</td> {{-- Agencia --}}
                        <td>{{ $field->ciudad_trabajo }}</td> {{-- Ciudad de trabajo --}}
                        <td>{{ $field->cliente }}</td> {{-- Cliente --}}
                        <td>{{ $field->cargo }}</td> {{-- Cargo --}}
                        <td>{{ $field->cargo_generico }}</td>
                        <td>{{$field->tipo_identificacion}}</td>{{--  tipo identificación--}}
                        <td>@if(strlen($field->cedula)>10)
                            {{(string)"\t"."PEP".$field->cedula."\t"}}
                        @else
                            {{$field->cedula}}
                        @endif
                        </td> {{-- Cédula contratado --}}
                        <td>{{ $field->nombre_completo }}</td> {{-- Nombre contratado --}}
                        <td>{{ $field->numero_celular }}</td> {{-- Celular contratado --}}
                        
                        <td>{{ $field->fecha_ingreso }}</td>  {{-- Fecha de ingreso --}}
                        <td>{{ $field->fecha_envio_contrato }}</td> {{-- Fecha de envío a contratación --}}

                        <td> {{-- Fecha de firma de contrato --}}
                            {{ $field->fecha_firma_contrato }}
                               
                            
                        </td>


                        <td> {{-- Estado de contrato --}}
                            @if($field->estado_global == 1)
                                @if ($field->estado_contrato === '0')
                                    Cancelado
                                @elseif($field->estado_contrato == 1)
                                    Firmado
                                @else
                                    Pendiente
                                @endif
                            @else
                                Anulado
                            @endif
                        </td>
                        <td>
                            {{$field->motivo_anulacion}}
                        </td>
                        <td> {{-- ¿Grabó video? --}}
                            @if ($field->estado_contrato == 1)
                                @if(!is_null($field->fecha_grabacion_videos))
                                    Si
                                @else
                                    No
                                @endif
                                
                            @elseif($field->estado_contrato == 2 || $field->estado_contrato == 3)
                                No
                            @else
                                No
                            @endif
                        </td>
                        <td> {{-- Fecha que grabó video --}}
                            @if ($field->cargo_videos == 0 || $field->cargo_videos == null)
                                El cargo no tiene video confirmación
                            @elseif($field->cargo_videos == 1)
                                @if ($field->estado_contrato == 1)
                                    @if(!is_null($field->fecha_grabacion_videos))
                                        {{ $field->fecha_grabacion_videos }}

                                    @endif

                                @endif
                            @else
                                El cargo no tiene video confirmación
                            @endif
                        </td>
                        <td>{{ $field->nombre_completo_gestion }}</td> {{-- Usuario que solicitó contratación --}}

                        <td>
                            @if($field->bloque_confirmacion!="" && $field->bloque_confirmacion!=null)
                                <ul style="padding-left: 15px;">
                                    @foreach(explode(",",$field->bloque_confirmacion) as $conf_contra)
                                    
                                        <li>
                                            {!! $conf_contra !!}
                                        </li>
                                   
                                    @endforeach
                                 </ul>
                            @endif
                        </td>
                        

                        <td>{{ $field->estado_requerimiento }}</td> {{-- Estado del requerimiento --}}
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
  
  