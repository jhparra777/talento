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

                  <th class="active"><div class="">
                    {!! Form::checkbox("seleccionar_todos",null,false,["id"=>"seleccionar_todos"]) !!} Seleccionar </div>
                  </th>

                    @foreach( $headerss as $key => $value )
                      <th class="active">
                        {{ $value }}
                      </th>
                    @endforeach
                </tr>

                @foreach( $data as $field )
                    <tr>
                      <td>
                       {!! Form::checkbox("user_id[]",$field->user_id,null,["style"=>'text-align: center;']) !!}
                        <p class="text-danger">{!! FuncionesGlobales::getErrorData("candidato",$errors) !!}</p>
                      </td>
                      
                        <td>
                             @if(strlen($field->cedula)>10)
                                {{(string)"\t"."PEP".$field->cedula."\t"}}
                            @else
                                {{$field->cedula}}
                            @endif
                        </td>

                        <td>{{ strtoupper($field->nombres ." ".$field->primer_apellido." ".$field->segundo_apellido) }}</td>

                        <td>
                            {{$field->edad}}
                        </td>
                           
                        <td>
                            {{$field->fecha_actualizacion}}
                        </td>

                        <td>
                            {{$field->ciudad}}
                        </td>

                        <td>
                            {{$field->celular}}
                        </td>

                        @if (route("home") == "http://nases.t3rsc.co" || route("home") == "https://nases.t3rsc.co" ||
                                route("home") == "http://localhost:8000")
                            <td>
                                {{$field->fijo}}
                            </td>

                            <td>
                                {{$field->eps_cand}}
                            </td>
                        @endif

                        <td>
                            {{$field->email}}
                        </td>

                        @if (route("home") == "http://nases.t3rsc.co" || route("home") == "https://nases.t3rsc.co" ||
                                route("home") == "http://localhost:8000")
                            <td>
                                {{$field->fuente_reclu}}
                            </td>
                        @endif
                          
                        <?php 
                            $experiencias           = 0;
                            $estudios               = 0;
                            $grupos_familiares      = 0;
                            $referencias_personales = 0;
                               
                            if ($field->experiencias >=1) {
                                $experiencias = 100; 
                            }
                               
                            if ($field->estudios >=1) {
                                $estudios = 100; 
                            }
                            
                            if ($field->grupos_familiares >=1) {
                                $grupos_familiares = 100; 
                            }

                            if ($field->referencias_personales >=1) {
                                $referencias_personales = 100; 
                            }

                        ?>

                        <td>
                            {{round(($field->hv_count) + (($experiencias + $estudios + $grupos_familiares + $referencias_personales)/4)*0.6)}}%
                        </td>

                        <td>
                            {{$field->estado_candidato}}
                        </td>

                        <td>
                            {{$field->fecha_nacimiento}}
                        </td>

                        <td>
                            {{strtoupper($field->cargo)}}
                        </td>

                        <td>
                            <a type="button" class="btn btn-sm btn-info" href="{{route("admin.hv_pdf",["ref_id"=>$field->user_id])}}" target="_blank">HV PDF</a> 
                            
                            @if($user_sesion->hasAccess("boton_ws"))
                              <a target="_blank" href="https://api.whatsapp.com/send?phone=57{{$field->celular}}&text=Hola!%20{{$field->nombres}} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}},%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección." class="btn  btn-block  btn-success aplicar_oferta"><span class="fa fa-whatsapp fa-lg" aria-hidden="true"></span></a>
                            @endif

                        </td>
                       
                        <td style="display:none;" >
                            {!! $field->funciones !!}
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