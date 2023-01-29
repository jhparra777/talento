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
                        {{$field->metodo_carga}}
                    </td>
                    <td>
                        @if($field->metodo_carga_id == 3)
                            {{$field->descripcion_fuente}}
                        @endif
                    </td>
                    <td>
                        @if(strlen($field->numero_id)>10)
                            {{(string)"\t"."PEP".$field->numero_id."\t"}}
                        @else
                            {{$field->numero_id}}
                        @endif
                    <td>
                        {{$field->nombres}}
                    </td>
                    <td>
                        {{$field->primer_apellido}} {{$field->segundo_apellido}}
                    </td>
                    <td>
                       {{$field->ciudad_residencia}}
                    </td>
                    <td> 
                        {{$field->requerimiento}}
                    </td>
                    <td>
                        {{$field->fecha_carga}}
                    </td>
                    <td>
                        {{$field->usuario_carga}}
                    </td>

                    <td>
                      <?php $porcentaje = FuncionesGlobales::porcentaje_hv($field->user_id); ?>
                        @if($porcentaje != null && isset($porcentaje["total"]) )
                            {{$porcentaje['total'] }}%
                        @else
                            5%
                        @endif
                    </td>
                        
                    <td>
                        @if($field->estado_candidato!=null && $field->estado_candidato!="")
                            {{$field->estado_candidato}}
                        @else
                            {{$field->estado_reclutamiento}}
                        @endif
                    </td>
                    
                    <td>
                         <a type="button" class="btn btn-sm btn-info" href="{{route("admin.hv_pdf",["user_id"=>$field->user_id])}}" target="_blank">HV PDF</a> 
                            <a target="_blank" href="https://api.whatsapp.com/send?phone={!! env('INDICATIVO','57') !!}{{ $field->telefono_movil}}&text=Hola!%20{{$field->nombres}} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}},%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección." class="btn  btn-block  btn-success aplicar_oferta"><span class="fa fa-whatsapp fa-lg" aria-hidden="true"></span></a>
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
