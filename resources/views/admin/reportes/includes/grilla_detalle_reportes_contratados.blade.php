<div class="col-md-12 mt-2">
    <div class="panel panel-default">
        <div class="panel-body container_grilla">
            @if(method_exists($data, 'total'))
            <h4 class="box-title">Total de Registros: <span>{{$data->total()}}</span>
            </h4>
            @endif
            <div class="tabla table-responsive">
                <table class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            @foreach( $headersr as $key => $value )
                            <th>
                                {{ $value }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $data as $field )
                        <tr>
                            <td>
                                {{$field->empresa_contratante}}
                            </td>

                            <td>
                                {{$field->nit_empresa_contratante}}
                            </td>

                            <td>
                                {{$field->cliente_nombre}}
                            </td>

                            <td>
                                {{$field->req_id}}
                            </td>

                            <td>
                                {{$field->tipo_proceso_desc}}
                            </td>

                            <td>
                                {{$field->agencia}}
                            </td>

                            <td>
                                {{$field->fecha_req}}
                            </td>

                            <td>
                                {{$field->fecha_envio_contratacion}}
                            </td>

                            <td>
                                {{ $field->fecha_firma_contrato }}
                            </td>

                            <td>
                                {{-- Estado de contrato --}}
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
                                {{$field->dec_tipo_doc}}
                            </td>

                            <td>
                                {{$field->cedula}}
                            </td>

                            <td>
                                {{$field->primer_nombre}} {{$field->segundo_nombre}}
                            </td>

                            <td>
                                {{$field->primer_apellido}} {{$field->segundo_apellido}}
                            </td>

                            <td>
                                {{$field->cargo}}
                            </td>

                            <td>
                                {{$field->cargo_generico}}
                            </td>

                            <td>
                                {{$field->nombre_ciudad}}
                            </td>

                            <td>
                                {{ $field->centro_costo }}
                            </td>

                            <td>
                                {{ $field->nivel_riesgo }}
                            </td>

                            <td>
                                {{$field->tipo_salario_desc}}
                            </td>

                            <td>
                                $ {{ number_format($field->salario) }}
                            </td>

                            <td>
                                <?php 
                                        $formatterES = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
                                    ?>
                                {{ $formatterES->format($field->salario) }}
                            </td>

                            <td>
                                {{ $field->adicionales_salariales }}
                            </td>

                            <td>
                                {{ $field->auxilio_transporte }}
                            </td>

                            <td>
                                {{$field->fecha_ingreso}}
                            </td>

                            <td>
                                {{$field->direccion}}
                            </td>

                            <td>
                                {{$field->barrio}}
                            </td>
                            
                            <td>
                                {{$field->ciudad_residencia}}
                            </td>

                            <td>
                                {{$field->telefono_movil}}
                            </td>

                            <td>
                                {{$field->correo}}
                            </td>

                            <td>
                                {{$field->estado_civil_desc}}
                            </td>

                            <td>
                                {{$field->genero_desc}}
                            </td>

                            <td>
                                {{$field->grupo_sanguineo}}
                                @if( $field->rh == 'positivo' )
                                +
                                @elseif($field->rh == 'negativo')
                                -
                                @endif
                            </td>

                            <td>
                                {{$field->fecha_nacimiento}}
                            </td>

                            <td>
                                {{$field->ciudad_nacimiento}}
                            </td>

                            <td>
                                {{$field->fecha_expedicion}}
                            </td>

                            <td>
                                {{ $field->nivel_educativo }}
                            </td>

                            <td>
                                {{ $field->numero_hijos }}
                            </td>

                            <td>
                                {{ $field->talla_zapatos }}
                            </td>

                            <td>
                                {{ $field->talla_camisa }}
                            </td>

                            <td>
                                {{ $field->talla_pantalon }}
                            </td>

                            <td>
                                {{$field->entidad_eps}}
                            </td>

                            <td>
                                {{$field->entidad_afp}}
                            </td>

                            <td>
                                {{$field->fondo_cesantia}}
                            </td>

                            <td>
                                {{$field->caja_compensacion_desc}}
                            </td>

                            <td>
                                {{$field->banco}}
                            </td>

                            <td>
                                {{$field->tipo_cuenta}}
                            </td>

                            <td>
                                {{$field->numero_cuenta}}
                            </td>

                            <td>
                                {{$field->usuario_envio}}
                            </td>

                            <td>
                                {{$field->metodo_carga}}
                            </td>

                            <td>
                                {{$field->observaciones}}
                            </td>

                            <td>
                                {{$field->usuario_autorizacion}}
                            </td>

                            <td>
                                {{ $field->estado_requerimiento }}
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                @if(method_exists($data, 'appends'))
                 {!! $data->appends(Request::all())->render() !!}
                 @endif
            </div>
        </div>
    </div>
</div>
    
    
    
    
    

