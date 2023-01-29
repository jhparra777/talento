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
               <th class="">
                {{$value}}
               </th>
              @endforeach
                    
             </tr>
                @foreach($data as $field)
                <tr>
                  <td>
                   {{$field->req_id}}
                  </td>
    
                  <td>
                        @if(strlen($field->cedula)>10)
                            {{(string)"\t"."PEP".$field->cedula."\t"}}
                        @else
                            {{$field->cedula}}
                        @endif
                  </td>

                  <td>
                   {{strtoupper($field->nombres ." ".$field->primer_apellido." ".$field->segundo_apellido) }}</td>

                    <td>
                     {{$field->edad}}
                    </td>
                    <td>
                      {{$field->ciudad}}
                    </td>
                    <td>
                      {{$field->celular}}
                    </td>
                    <td>
                      {{$field->email}}
                    </td>
                    <td>
                      {{$field->estado_candidato}}
                    </td>
                    <td>
                      {{$field->fecha_nacimiento}}
                    </td>
                    <td>
                     {{$field->fuente_reclu}}
                    </td>
                    <td style="width: auto;">
                      {{substr($field->descripcion,0,100)}}
                    </td>
                    <td> </td>
                
                </tr>
                @endforeach
            </table>
        </div>
        <div>
            @if(method_exists($data,'appends'))
             {!! $data->appends(Request::all())->render() !!}
             @endif
        </div>
    </div>
</div>
