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
                    @foreach( $headers as $key => $value )
                    <th class="active">
                        {{ $value }}
                    </th>
                    @endforeach
                </tr>
                @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
                    @foreach( $data as $field )
                    <tr>
                        <td>
                            {{$field->requerimiento_id}}
                        </td>
                        <td>
                            {{$field->tipo_requerimiento}}
                        </td>
                        <td>
                            {{$field->agencia}}
                        </td>
                        <td>
                            {{$field->ciudad_req}}
                        </td>
                        <td>
                            {{$field->departamento}}
                        </td>
                        <td>
                            {{$field->pais}}
                        </td>
                        <td>
                            {{$field->cliente}}
                        </td>
                        <td>
                            {{$field->cargo_generico}}
                        </td>
                        <td>
                            {{$field->cargo_cliente}}
                        </td>
                        <td>
                            {{$field->vacantes_solicitadas}}
                        </td>
                        <td>
                            {{$field->cant_enviados_examenes}}
                        </td>
                        <td>
                            {{$field->cant_enviados_contratacion}}
                        </td>
                        <td>
                            {{$field->cant_contratados}}
                        </td>
                        <td>
                            {{$field->fecha_inicio_vacante}}
                        </td>
                        <td>
                            {{$field->fecha_tentativa}}
                        </td>
                        
                            @if($field->dias_vencidos< 1 )

                            <td>
                                0
                            </td>
                            @else
                        <td>
                            {{$field->dias_vencidos}}
                        </td>
                            @endif  
                        <td class="{{ $field->semaforo }}">
                            {{$field->estado_req}}
                        </td>

                        <td>
                            {{$field->dias_gestion}}
                        </td>
                        <td>
                            {{$field->fecha_cierre_req}}
                        </td>
                        <td>
                            {{$field->usuario_cargo_req}}
                        </td>
                        <td>
                            {{$field->usuario_gestiono_req}}
                        </td>
                        <td>
                            {{$field->vacantes_reales}}
                        </td>
                        <td>
                            {{$field->ind_oport_presentacion}}%
                        </td>
                        <td>
                            {{$field->ind_oport_contratacion}}%
                        </td>
                        <td>
                            {{$field->ind_calidad_presentacion}}%
                        </td>
                    </tr>
                    @endforeach
                @else
                    @foreach( $data as $field )

                    <tr>
                        <td>
                            {{$field->requerimiento_id}}
                        </td>
                        <td>
                            {{$field->responsable}}
                        </td>
                       <td>
                            {{$field->cargo_cliente}}
                        </td>
                        <td>
                            {{$field->tipo_contrato}}
                        </td>
                        <!--<td>
                            
                        </td>-->
                         <td>
                            {{$field->justificacion}}
                        </td>
                        <td>
                            {{$field->vacantes_solicitadas}}
                        </td>
                        <td>
                            {{$field->sede}}
                        </td>
                        <td>
                            {{$field->solicitante}}
                        </td>
                        <td>
                            {{$field->area}}
                        </td>
                        <td>
                            {{$field->nombre_candidato}} 
                        </td>
                       <!-- <td></td> -->
                        <td>
                            @if($field->listo_entrevista!=0)
                                <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>

                            @else
                                 <i class="fa fa-times" aria-hidden="true" style="color: red;"></i>

                            @endif
                        </td>
                        <td>
                             @if($field->listo_entrevista_tecnica!=0)
                                <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>

                            @else
                                 <i class="fa fa-times" aria-hidden="true" style="color: red;"></i>

                            @endif
                            
                        </td>
                        <td>
                            @if($field->listo_pruebas!=0)
                                <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>

                            @else
                                 <i class="fa fa-times" aria-hidden="true" style="color: red;"></i>

                            @endif
                            
                            
                        </td>
                        <td>
                            @if($field->listo_examenes!=0)
                                <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>

                            @else
                                 <i class="fa fa-times" aria-hidden="true" style="color: red;"></i>

                            @endif
                           
                        </td>
                        <td>
                             @if($field->listo_documentos!=0)
                                <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>

                            @else
                                 <i class="fa fa-times" aria-hidden="true" style="color: red;"></i>

                            @endif
                             
                            
                        </td>
                        {{--<td>
                           
                            {{$field->cant_enviados_contratacion}} 
                        
                        </td>
                        
                        <td>
                            {{$field->vacantes_reales}}  
                        </td>
                        <td></td>
                        <td>
                            {{$field->fecha_solicitud}} 
                        </td>

                        <td>
                            {{$field->fecha_valoracion}}
                        </td>
                        <td>
                            {{$field->fecha_jefe_ok}}
                        </td>
                        <td>
                            {{$field->fecha_gte_ok}}
                        </td>
                        <td>
                            {{$field->fecha_rrhh_ok}}
                        </td>
                        <td>
                            {{$field->fecha_liberacion}}
                        </td>
                        <td>
                             {{$field->postulantes_internos}} 
                        </td>
                        <td>
                            {{$field->postulantes_externos}}
                        </td>
                        <td>
                           {{$field->postulantes_proceso_internos}} 
                        </td>
                        <td>
                            {{$field->postulantes_proceso_externos}}
                        </td>
                        <td>
                            {{$field->fecha_entrevista}}
                        </td>
                        <td>
                            {{$field->fecha_entrevista_tecnica}}
                        </td>
                        <td>
                            {{$field->fecha_primero_pruebas}}           
                        </td>
                        <td>
                            {{$field->fecha_ultimo_entrega_pruebas}} 
                            
                        </td>
                        <td></td>
                        <td>{{$field->fecha_primero_examenes}}</td>
                        <td>{{$field->fecha_ultimo_entrega_examenes}}</td>
                        <td>{{$field->fecha_primero_estudio}}</td>
                        <td>{{$field->fecha_ultimo_entrega_estudio}}</td>
                        <td></td>
                        <td>
                            {{$field->fecha_terminacion}}
                        </td>
                        <td>
                            <!-- TIPO NOVEDAD-->
                        </td>
                        <td>
                            {{$field->ultimo_contratado}}
                            
                        </td>
                        <td>
                            {{$field->fecha_ultima_contratacion}}
                            
                        </td>
                        <td>
                            <!-- FECHA CANCELACION DE PROCESO-->
                        </td>--}}
                        
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
