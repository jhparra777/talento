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
            @if($data->count() > 0)

                @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
                    @if(route("home")=="https://gpc.t3rsc.co")
                        @foreach( $data as $field )
                    <tr>
                        <td>
                            {{$field->requerimiento_id}}
                        </td>
                       
                        <td>
                            {{$field->tipo_requerimiento}}
                        </td>

                        {{--<td>
                            {{$field->nombre_agencia}}
                        </td>--}}
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
                        {{--<td>
                            {{$field->cargo_generico}}
                        </td>--}}
                        <td>
                            {{$field->cargo_cliente}}
                        </td>
                        <td>
                            {{$field->vacantes_solicitadas}}
                        </td>
                        <td> 
                            @if($field->preperfilados==null)
                                0
                            @else
                                 {{$field->preperfilados}}
                            @endif
                           

                        </td>
                        <td>{{$field->candidatos_aplicados}}</td>
                        <td>{{$field->candidatos_asociados}}</td>
                        <td>{{$field->cant_citados}}</td>
                        <td>{{$field->cant_enviados_pruebas}}</td>
                        <td>{{$field->cant_enviados_referenciacion}}</td>
                        {{--<td>
                            @if($field->cant_consultas_seguridad!=null)
                                {{$field->cant_consultas_seguridad}}
                            @else
                                0
                            @endif
                            

                        </td>--}}
                        <td>{{$field->cant_enviados_entrevista_virtual}}</td>
                        <td>{{$field->cant_enviados_entrevista}}</td>
                        <td>{{$field->cant_enviados_aprobar_cliente}}</td>
                        {{--<td>{{$field->cant_enviados_examenes}}</td>--}}
                        {{--<td></td>--}}
                         <td>{{$field->cant_enviados_contratacion}} </td>
                        {{--<td>{{$field->cant_contratados}}</td>--}}
                        <td> {{$field->fecha_inicio_vacante}} </td>
                        {{--<td>
                            {{$field->cant_enviados_examenes}}
                        </td>
                        <td>
                            {{$field->cant_enviados_contratacion}}
                        </td>
                        <td>
                            {{$field->cant_contratados}}
                        </td>--}}
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
                             @if(isset($sitio))
                                 @if($sitio->asistente_contratacion==1 && $field->firma_cargo==1)
                                    {{$field->vacantes_reales_asistente}}
                                 @else
                                    {{$field->vacantes_reales}}
                                 @endif
                             @else
                                {{$field->vacantes_reales}}
                             @endif
                        </td>
                       
                         <td style="width: 100%;">
                            
                                <ul style="padding: 0;margin: 0;">
                                    @foreach($field->observaciones_gestion as $item)
                                        <li style="font-size: .9em;"><strong>{{$item->user->name}}({{date('Y-m-d',strtotime($item->created_at))}}): </strong>{{$item->observacion}}</li>
                                    @endforeach
                                </ul>
                           

                        </td>

                        @if(route("home")=="https://nases.t3rsc.co")
                            <td>{{$field->fecha_recepcion}}</td>
                        @endif

                    </tr>
                    @endforeach

                    @else
                    @foreach( $data as $field )
                    <tr>
                        <td>
                            {{$field->requerimiento_id}}
                        </td>
                       
                        <td>
                            {{$field->tipo_requerimiento}}
                        </td>
                        <td>
                            {{$field->motivo_requerimiento}}
                        </td>
                        @if($sitio->agencias)
                            <td>
                                {{$field->nombre_agencia}}
                            </td>
                        @endif
                        @if($sitio->multiple_empresa_contrato)
                            <td>
                                {{$field->nombre_empresa}}
                            </td>
                        @endif
                        <td>
                            {{$field->ciudad_req}}
                        </td>
                        <td>
                            {{$field->salario}}
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
                            @if($field->preperfilados==null)
                                0
                            @else
                                 {{$field->preperfilados}}
                            @endif
                           

                        </td>
                        <td>{{$field->candidatos_aplicados}}</td>
                        <td>{{$field->candidatos_asociados}}</td>
                        <td>{{$field->cant_citados}}</td>
                        <td>{{$field->cant_enviados_pruebas}}</td>
                        <td>{{$field->cant_enviados_referenciacion}}</td>
                        <td>
                            @if($field->cant_consultas_seguridad!=null)
                                {{$field->cant_consultas_seguridad}}
                            @else
                                0
                            @endif
                            

                        </td>
                        <td>{{$field->cant_enviados_entrevista_virtual}}</td>
                        <td>{{$field->cant_enviados_entrevista}}</td>
                        <td>{{$field->cant_enviados_aprobar_cliente}}</td>
                        <td>{{$field->cant_enviados_examenes}}</td>
                        <td></td>
                         <td>{{$field->cant_enviados_contratacion}} </td>
                        <td>{{$field->cant_contratados}}</td>
                        <td>{{ $field->cant_enviados_excel_basico }}</td>
                        <td>{{ $field->cant_enviados_excel_intermedio }}</td>
                        <td>{{ $field->cant_enviados_ethical_values }}</td>
                        <td>{{ $field->cant_enviados_prueba_competencias }}</td>
                        <td>{{ $field->cant_enviados_prueba_digitacion }}</td>
                        <td>{{ $field->cant_enviados_prueba_bryg }}</td>
                        <td> {{$field->fecha_inicio_vacante}} </td>
                        {{--<td>
                            {{$field->cant_enviados_examenes}}
                        </td>
                        <td>
                            {{$field->cant_enviados_contratacion}}
                        </td>
                        <td>
                            {{$field->cant_contratados}}
                        </td>--}}
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
                            @if(isset($sitio))
                                 @if($sitio->asistente_contratacion==1 && $field->firma_cargo==1)
                                    {{$field->vacantes_reales_asistente}}
                                 @else
                                    {{$field->vacantes_reales}}
                                 @endif
                             @else
                                {{$field->vacantes_reales}}
                             @endif
                        </td>
                       
                        <td>
                            {{$field->ind_oport_presentacion}}%
                        </td>

                        
                        

                        {{--@if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co")
                        <td>
                            {{$field->ind_oport_contratacion}}%
                        </td>
                        @endif--}}

                        <td>
                            
                        @if($field->ind_calidad_presentacion > 0)
                          {{$field->ind_calidad_presentacion}}%
                        @else
                          0%
                        @endif
                        </td>
                         <td style="width: 100%;">
                            
                                <ul style="padding: 0;margin: 0;">
                                    @foreach($field->observaciones_gestion as $item)
                                        <li style="font-size: .9em;"><strong>{{$item->user->name}}({{date('Y-m-d',strtotime($item->created_at))}}): </strong>{{$item->observacion}}</li>
                                    @endforeach
                                </ul>
                           

                        </td>

                        @if(route("home")=="https://nases.t3rsc.co")
                            <td>{{$field->fecha_recepcion}}</td>
                        @endif

                    </tr>
                    @endforeach

                    @endif
                    
                @endif

            {{--@if(route('home') == "http://soluciones.t3rsc.co" || route('home') == "https://soluciones.t3rsc.co")

                 @foreach( $data as $field )
                    <tr>
                        <td>
                            {{$field->requerimiento_id}}
                        </td>
                        <td>
                            {{$field->tipo_proceso_req()}}
                        </td>
                        <td>
                            {{$field->agencia}}
                        </td>
                        <td>
                            {{$field->ciudad_req()}}
                        </td>
                        <td>
                            {{$field->departamento_req()}}
                        </td>
                        <td>
                            {{$field->pais_req()}}
                        </td>
                        <td>
                            {{$field->nombre_cliente_req()}}
                        </td>
                        <td>
                            {{$field->cargo_req()}}
                        </td>
                        <td>
                            {{$field->cargo_cliente}}
                        </td>
                        <td>
                            {{$field->num_vacantes}}
                        </td>
                        <td>
                            {{$field->numeroCandidatosEnviados()}}
                        </td>
                        <td>
                            {{$field->numeroCandidatosEnviadoscontratar()}}
                        </td>
                        <td>
                            {{ \App\Models\Requerimiento::countVacantesContratados($field->id) }}
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
                          {{FuncionesGlobales::oport_porcent($field->cand_presentados_puntual, $field->num_vacantes)}}%
                        </td>
                        <td>
                          {{FuncionesGlobales::oport_porcent($field->cand_contratados_puntual, $field->num_vacantes)}}%
                        </td>
                        <td>
                          60%
                        </td>
                        <td style="width: 100%;">
                            
                                <ul style="padding: 0;margin: 0;">
                                    @foreach($field->observaciones_gestion as $item)
                                        <li style="font-size: .9em;"><strong>{{$item->user->name}}({{date('Y-m-d',strtotime($item->created_at))}}): </strong>{{$item->observacion}}</li>
                                    @endforeach
                                </ul>
                           

                        </td>
                    </tr>
                    @endforeach
                @endif
                --}}

            @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co")

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
                            {{$field->gerente_area}} 
                        </td>
                        <td></td>
                        <td>
                            {{$field->cant_enviados_entrevista}} 
                        </td>
                        <td>
                            {{$field->cant_enviados_entrevista_tecnica}} 
                        </td>
                        <td>
                            {{$field->cant_enviados_pruebas}} 
                            
                        </td>
                        <td>
                           {{$field->cant_enviados_examenes}}  
                        </td>
                        <td>
                            {{$field->cant_enviados_estudioSeg}}  
                            
                        </td>
                        <td>
                           
                            {{$field->cant_enviados_contratacion}} 
                        
                        </td>
                        
                        <td>
                            {{$field->vacantes_reales}}  
                        </td>
                        <td>
                            {{$field->ans}}  
                        </td>
                        <td>
                            {{$field->fecha_solicitud}} 
                        </td>
                        <td>
                           <?php
                           $fecha1=new DateTime($field->fecha_solicitud);
                           $fecha2=new DateTime($field->fecha_valoracion);
                           $diff = $fecha1->diff($fecha2);
                           echo $diff->days;
                           ?>
                        </td>
                        <td>
                            {{$field->fecha_valoracion}}
                        </td>
                        <td>
                            <?php
                           $fecha1=new DateTime($field->fecha_valoracion);
                           $fecha2=new DateTime($field->fecha_jefe_ok);
                           $diff = $fecha1->diff($fecha2);
                           echo $diff->days;
                           ?>
                        </td>
                        <td>
                            {{$field->fecha_jefe_ok}}
                        </td>
                        <td>
                            <?php
                           $fecha1=new DateTime($field->fecha_jefe_ok);
                           $fecha2=new DateTime($field->fecha_gte_ok);
                           $diff = $fecha1->diff($fecha2);
                           echo $diff->days;
                           ?>
                        </td>
                        <td>
                            {{$field->fecha_gte_ok}}
                        </td>
                        <td>
                            <?php
                           $fecha1=new DateTime($field->fecha_gte_ok);
                           $fecha2=new DateTime($field->fecha_rrhh_ok);
                           $diff = $fecha1->diff($fecha2);
                           echo $diff->days;
                           ?>
                        </td>
                        <td>
                            {{$field->fecha_rrhh_ok}}
                        </td>
                        <td>
                            {{$field->fecha_liberacion}}
                        </td>
                        <td>
                             <?php
                           $fecha1=new DateTime($field->fecha_solicitud);
                           $fecha2=new DateTime($field->fecha_liberacion);
                           $diff = $fecha1->diff($fecha2);
                           echo $diff->days;
                           ?>
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
                             <?php
                           $fecha1=new DateTime($field->fecha_primero_pruebas);
                           $fecha2=new DateTime($field->fecha_ultimo_entrega_pruebas);
                           $diff = $fecha1->diff($fecha2);
                           echo $diff->days;
                           ?>
                        </td>
                        <td>
                            {{$field->fecha_ultimo_entrega_pruebas}} 
                            
                        </td>
                        <td></td>
                        <td>{{$field->fecha_primero_examenes}}</td>
                        <td>
                            <?php
                           $fecha1=new DateTime($field->fecha_primero_examenes);
                           $fecha2=new DateTime($field->fecha_ultimo_entrega_examenes);
                           $diff = $fecha1->diff($fecha2);
                           echo $diff->days;
                           ?>
                        </td>
                        <td>{{$field->fecha_ultimo_entrega_examenes}}</td>
                        <td>{{$field->fecha_primero_estudio}}</td>
                        <td>
                              <?php
                           $fecha1=new DateTime($field->fecha_primero_estudio);
                           $fecha2=new DateTime($field->fecha_ultimo_entrega_estudio);
                           $diff = $fecha1->diff($fecha2);
                           echo $diff->days;
                           ?>
                        </td>
                        <td>{{$field->fecha_ultimo_entrega_estudio}}</td>
                        <td></td>
                        <td>
                            {{$field->fecha_terminacion}}
                        </td>
                        <td>
                           {{$field->novedad}}
                           
                        </td>
                        <td>
                            {{$field->ultimo_contratado}}
                            
                        </td>
                        <td>
                            {{$field->fecha_ultima_contratacion}}
                            
                        </td>
                        <td>
                            <!-- FECHA CANCELACION DE PROCESO-->
                        </td>
                        
                    </tr>
                    @endforeach
                @endif
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
