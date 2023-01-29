<div class="col-md-12 mt-2">
    <div class="panel panel-default">
        <div class="panel-body container_grilla">
            @if(method_exists($data, 'total'))
                <h4 class="box-title">Total de Registros :<span>{{$data->total()}}</span>
                </h4>
             @endif
            <div class="tabla table-responsive">
                <table class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            @foreach( $headers as $key => $value )
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
                                    {{$field->requerimiento_id}}
                                </td>
                                <td>
                                    {{$field->tipo_requerimiento}}
                                </td>
                                @if (route('home') != 'https://gpc.t3rsc.co')
                                    <td>
                                        {{$field->agencia}}
                                    </td>
                                @endif
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>	
</div>
    
    
    
    
    









{{-- <div class="container">
    <div class="row">
     @if(method_exists($data, 'total'))
      <h4>
       Total de Registros :
        <span>{{$data->total()}}</span>
      </h4>
     @endif
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                 @foreach($headers as $key => $value )
                  <th class="">
                   {{$value}}
                  </th>
                 @endforeach
                </tr>
                @foreach( $data as $field )
                <tr>
                    <td>
                        {{$field->requerimiento_id}}
                    </td>
                    <td>
                        {{$field->tipo_requerimiento}}
                    </td>
                    @if (route('home') != 'https://gpc.t3rsc.co')
                        <td>
                            {{$field->agencia}}
                        </td>
                    @endif
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
            </table>
        </div>
        <div>
            @if(method_exists($data, 'appends'))
             {!! $data->appends(Request::all())->render() !!}
             @endif
        </div>
    </div>
</div> --}}