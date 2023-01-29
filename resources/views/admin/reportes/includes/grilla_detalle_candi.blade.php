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
                        @if(strlen($field->cedula)>10)
                            {{(string)"\t"."PEP".$field->cedula."\t"}}
                        @else
                            {{$field->cedula}}
                        @endif
                  </td>

                     <td>
                     {{ strtoupper($field->nombres ." ".$field->primer_apellido." ".$field->segundo_apellido) }}
                    </td>

                    <td> 
                      <?php $porcentaje = FuncionesGlobales::porcentaje_hv($field->usersss_id); ?>
                        @if($porcentaje != null && isset($porcentaje["total"]) )
                            {{$porcentaje['total'] }}%
                        @else
                            5%
                        @endif
                    </td>

                    <td>
                     {{$field->genero}}
                    </td>

                    <td>
                      {{$field->edad}}
                    </td>

                    <td>
                     {{(($field->escolaridad)?$field->escolaridad:'No posee')}} 
                    </td>

                    <td>
                     {{$field->estado_civil}}
                    </td>

                    <td>
                     {{$field->celular}}
                    </td>

                    <td>
                     {{$field->email}}
                    </td>

                    <td>
                     {{$field->direccion}}
                    </td>

                    <td>
                      {{$field->ciudad}}
                    </td>

                    <td>{{($field->entidades_eps_des)?$field->entidades_eps_des:'No registra'}}</td>

                    <td>{{($field->entidades_afp_des)?$field->entidades_afp_des:'No registra'}}</td>

                    <td>{{$field->estado_cand}}</td>
                    <td>{{(strlen($field->cargado) >0)?$field->cargado:'Registro'}}</td>
                    
                    <td>
                      
                      <a type="button" class="btn btn-sm btn-info" href="{{route("admin.hv_pdf",["ref_id"=>$field->usersss_id])}}" target="_blank">HV PDF</a> 
                            
                       <a target="_blank" href="https://api.whatsapp.com/send?phone=57{{$field->celular}}&text=Hola!%20{{$field->nombres}} %20te%20hablamos%20del%20equipo%20de%20selección%20de,%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección." class="btn btn-block btn-success aplicar_oferta"><span class="fa fa-whatsapp fa-lg" aria-hidden="true"></span></a>

                       <a href="{{route("renviar_email_asignacion",["requerimiento_id"=>$field->requerimiento_id,"usuario"=>$field->usersss_id])}}" class="btn  btn-sm btn-primary aplicar_oferta">

                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                       </a>

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
