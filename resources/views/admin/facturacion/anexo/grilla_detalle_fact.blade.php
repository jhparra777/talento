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
                @foreach( $data as $field )
                <tr>
                    <td>
                        {{$field->requerimiento_id}}
                    </td>
                    <td>
                        {{$field->fecha_solicitud}}
                    </td>
                    <td>
                        {{$field->nombre}}
                    </td>
                    <td>
                        {{$field->cargo}}
                    </td>
                    <td>
                        {{$field->vacantes}}
                    </td>
                    <td>
                        <strong>${{number_format($field->salario,null,null,".")}}</strong>
                    </td>
                    <td>
                        {{$field->tipo_servicios}}
                    </td>
                    <td>
                        {{$field->consultor}}
                    </td>
                    <td>
                        {{$field->comercial}}
                    </td>
                    <td>
                        {{ $field->fecha_entrega }}
                    </td>
                     
                     @if($field->cand_env_cli !== 0)
                        
                        <?php
                                $cuenta = 6;
                         ?>
                        
                        @foreach($field->candidatosEnviadosCliente() as $key =>$candidato)
                        @if($key%3==0 )
                              <td>

                               <p>{{ $candidato->fecha_contratacion}}</p>

                                </td>
                        <?php
                          $cuenta--;       
                         ?>                    
               @endif

                        @endforeach

                    
                   <td colspan="{{ $cuenta }}"></td>

                    @else
                     <td>
                       NO SE HAN ENVIADO CANDIDATOS AL CLIENTE
                    </td>
                     <td>
                        NO SE HAN ENVIADO CANDIDATOS AL CLIENTE
                    </td>
                     <td>
                       NO SE HAN ENVIADO CANDIDATOS AL CLIENTE
                    </td> 
                      <td>
                       NO SE HAN ENVIADO CANDIDATOS AL CLIENTE
                    </td>
                      <td>
                       NO SE HAN ENVIADO CANDIDATOS AL CLIENTE
                    </td>
                      <td>
                      NO SE HAN ENVIADO CANDIDATOS AL CLIENTE
                    </td>

                     @endif


                   

                    @if($field->cand_env_cli != "")
                        <td>
                        {{ $field->cand_env_cli }}
                    </td>
                    @else
                    <td>0</td>
                    @endif
                     
                     <td>
                        {{$field->estado_req}}
                    </td>
                       @if($field->observaciones !="")

                        <td>
                        {{str_limit($field->observaciones,50)}}  Observación hecha por <b>{{$field->user_obser}}</b>
                    </td>
                   @else
                   <td> NO TIENE OBSERVACIONES</td>
                  

                    @endif

                     @if($field->candidatosContratar()->count() !== 0)

                      <td>
                @foreach($field->candidatosContratar() as $candidato)

                       <p>{{ $candidato->nombre}}</p>

                 @endforeach
                    </td>
                 
                @else
                 <td>NO SE HAN SELECCIONADO CANDIDATOS</td>
                @endif


                    <td>
                        100%
                    </td>
                    <td>
                        <strong>${{ number_format($field->salario,null,null,".") }}</strong>
                    </td>
                   @if($field->esquemas === 1)
                      <td id="30%">
                         <strong>${{ number_format($field->salario*0.30,null,null,".") }}</strong>
                    </td>
                    
                    <td id="70%">
                         <strong>${{ number_format($field->salario*0.70,null,null,".") }}</strong>
                    </td>

                    <td>0</td>
                    <td>0</td>
                    <td>0</td>

                    @elseif($field->esquemas === 2)

                    <td>0</td>
                    <td>0</td>
                     <td id="50%">
                        
                      <strong>${{ number_format($field->salario/2,null,null,".") }}</strong>
                    </td>

                    <td id="50%" >
                         <strong>${{ number_format($field->salario/2,null,null,".") }}</strong>
                    </td>

                    <td>0</td>

                    @elseif($field->esquemas === 3)

                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                       <td id="100%" >
                         <strong>${{ number_format($field->salario,null,null,".") }}</strong>
                    </td>

                   @endif
                    @if($field->esquemas === 1)

                    <td id="30%">
                          <strong>${{ number_format($field->salario*0.30,null,null,".") }}</strong>
                    </td>
                    
                                @if($field->factura_cierre_proceso == 1)
                                <td id="70%">
                                     <strong>${{ number_format($field->salario*0.70,null,null,".") }}</strong>
                                </td>


                                <td>$0</td>
                                @else
                                   <td>0</td>

                                    <td>${{ number_format($field->salario*0.70,null,null,".") }}</td>


                                @endif
                    @elseif($field->esquemas === 2)

                    <td id="50%">
                        
                     <strong>${{ number_format($field->salario/2,null,null,".") }}</strong>
                    </td>

                                    @if($field->factura_cierre_proceso == 1)

                                     <td id="50%">
                                        
                                     <strong>${{ number_format($field->salario/2,null,null,".") }}</strong>
                                    </td>

                                      <td>$0</td>
                                    @else

                                     <td>0</td>

                                        <td>${{ number_format($field->salario/2,null,null,".") }}</td>

                                    @endif

                                   

                    @elseif($field->esquemas === 3)

                    <td id="100%" >
                       <strong>${{ number_format($field->salario,null,null,".") }}</strong>
                    </td>
                                   @if($field->factura_cierre_proceso == 1)
                                     <td id="100%" >
                                          <strong>${{ number_format($field->salario,null,null,".") }}</strong>
                                    </td>

                                    <td>$0</td>

                                    @else

                                    <td>0</td>
                                    <td>${{ number_format($field->salario,null,null,".") }}</td>

                                   @endif
                                   
                   
                    @endif
                    
                     
                    
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
