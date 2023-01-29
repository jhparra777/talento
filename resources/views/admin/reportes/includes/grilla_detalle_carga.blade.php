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
                        <!--cod_empresa-->
                       cod_empresa
                    </td>
                   
                    <td>
                        nombre_empresa
                    </td>
                    <td>
                        tip_identificacion
                    </td>
                    <td>
                        pais_exp
                    </td>
                    <td>
                       ciudad_expedicionn
                    </td>
                    <td>
                        fecha_nacimiento
                    </td>
                    <td>
                        cod_pai
                    </td>
                    <td>
                       cod_dep
                    </td>
                    <td>
                      cod_ciud
                    </td>
                    <td>
                      sex_empleado
                    </td>
                    <td>
                      {{$field->numero_libreta}}
                    </td>
                    <td>
                      {{$field->clase_libreta}}
                    </td>
                    <td>
                       {{$field->distrito_militar}}
                    </td>
                   <td>
                      {{$field->grupo_sanguineo}}
                   </td>
                    <td>
                        {{$field->distrito_militar}}
                    </td>
                    <td>
                        {{$field->grupo_sanguineo}}
                    </td>
                     <td>
                        {{$field->rh}}
                    </td>
                     <td>
                        {{$field->estado_civil}}
                    </td>
                    <td>
                        {{-- Campo nac_emp--}}
                    </td>
                     <td>
                        {{$field->direccion}}
                    </td>
                    <td>
                       {{$field->telefono_fijo}}
                    </td>
                    <td>
                        170
                    </td>
                     <td>
                       {{$field->departamento_residencia}}
                    </td>
                    <td>
                       {{$field->ciudad_residencia}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>


                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>

                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
                    </td>
                   
                    <td>
                        <!-- ide_empleado-->
                       {{$field->cedula}}
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
