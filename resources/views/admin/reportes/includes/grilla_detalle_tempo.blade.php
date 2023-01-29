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
                {{-- {{ dd($data->all()) }} --}}
                @foreach( $data as $field )
                <tr>
    
                    <td>
                        {{$field->requerimiento_id}}
                    </td>

                    <td>
                          {{$field->estado_req}} 
                    </td>
                    <td>
                        {{$field->fecha_creacion}}
                    </td>
                    <td>
                        {{$field->fecha_tentativa}}
                    </td>
                    <td>
                        {{$field->cant_enviados_contratacion}}
                        
                    </td>
                     <td>
                        {{$field->vacantes_solicitadas}}
                    </td>


                     @if($field->tiempoEntregaEfectiva()==1)

                       <td>
                          {{$field->tiempoEntregaEfectiva()}} día
                       </td>
                       @elseif($field->tiempoEntregaEfectiva()!=0)
                          <td>
                              {{$field->tiempoEntregaEfectiva()}} días
                          </td>
                       @else
                       
                       <td style="background-color: #fff9ae;" >
                           No se ha finalizado el requerimiento 
                       </td>   
                     @endif
                    <td>
                        {{$field->numeroCandidatosEnviados()}}
                    </td>
                    

                    <td>
                      
                   {{$field->numeroCandidatosAsistieron()}} 
                    </td>
                    <td>
                         {{$field->entrevistaReqApto()}}
                    </td>
                     <td>
                       
                      {{$field->numeroCandidatosNoAsistieron()}} 
                     </td>
                    

                   @if($field->tiempoEnvioCliente() != 0)
                   <td>
                     {{$field->tiempoEnvioCliente()}} días

                    </td>

                    @else
                    <td  style="background-color: #fff9ae;">
                      Esperando respuesta del cliente
                    </td>
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
