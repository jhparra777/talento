<style>
  @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co" || route("home") == "http://localhost:8000")

  .table>tbody>tr.active>td, .table>tbody>tr.active>th, .table>tbody>tr>td.active, .table>tbody>tr>th.active, .table>tfoot>tr.active>td, .table>tfoot>tr.active>th, .table>tfoot>tr>td.active, .table>tfoot>tr>th.active, .table>thead>tr.active>td, .table>thead>tr.active>th, .table>thead>tr>td.active, .table>thead>tr>th.active {
    background-color: #f5f5f5;
    /* column-width: 50px; */
    min-width: 166px;
  }
  
  @endif
</style>

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
            <?php $suma=0; $calidad=0;?>
            <table class="table table-bordered">
              <tr>
                    @foreach( $headers as $key => $value )
                    <th class="active" >
                        {{$value}}
                    </th>
                    @endforeach
              </tr>
                

           

                 @foreach( $data as $field )
                    <tr>
                        <td >
                            {{$field->requerimiento_id}}
                        </td>
                        <td >
                            {{$field->tipo_proceso_req()}}
                        </td>
                        <td >
                            {{$field->agencia_req()}}
                        </td>
                        <td >
                            {{$field->ciudad_req()}}
                        </td>
                       {{--}} <td >
                            {{$field->departamento_req()}}
                        </td>
                        <td >
                            {{$field->pais_req()}}
                        </td>--}}
                        <td >
                            {{$field->nombre_cliente_req()}}
                        </td>
                        <td >
                            {{$field->cargo_req()}}
                        </td>
                        <td >
                            {{$field->cargo_cliente}}
                        </td>
                        
                         <td  class="{{ $field->semaforo }}">
                            {{$field->estado_req}}
                        </td>

                        <td>
                          {{$field->mes_creacion}}
                        </td>
                        <td >
                            {{$field->num_vacantes}}
                        </td>
                        {{--<td >
                            {{$field->numeroCandidatosEnviados()}}
                        </td>
                        <td >
                            {{$field->numeroCandidatosEnviadoscontratar()}}
                        </td>
                        <td >
                            {{$field->numeroCandidatosEnviadoscontratar()}}
                        </td>--}}
                        <td >
                            {{$field->fecha_inicio_vacante}}
                        </td>
                        <td >
                            @if(!is_null($field->fecha_primer_envio))
                            {{$field->fecha_primer_envio}}
                            @else
                              -
                            @endif
                        </td>
                        
                           
                       
                        <td>
                          <?php
                          $g=0;
                          ?>
                          @if(is_null($field->fecha_primer_envio))
                          -
                          @else
                             <?php
                             
                             $m = 'Carbon\Carbon';

                              $date1= date('Y-m-d',strtotime($field->fecha_inicio_vacante));
                              $date2= date('Y-m-d',strtotime($field->fecha_primer_envio));
                             //$diff = $fecha1->diff($fecha2);
                             $g = $m::parse($date1)->diffInWeekdays($date2);
                            ?>
                            {{$g}}
                          @endif
                        </td>
                        <td>
                          @if(!is_null($field->fecha_primer_envio))
                            @if($g<=3)
                              100%
                            @elseif($g<=6)
                              80%
                            @elseif($g<=9)
                              60%
                            @elseif($g<=12)
                              40%;
                            @else
                             0%
                            @endif
                          

                          @endif
                        </td>
                        <td >
                          {{$field->num_vacantes}}
                        </td>
                        <td>
                          {{$field->cantidad_enviados}}
                        </td>
                        <td>
                          {{$field->cantidad_enviados_aprobados}}
                        </td>
                        <td>
                          {{$field->cantidad_enviados_no_aprobados}}
                        </td>
                        <td>
                          @if($field->cantidad_enviados>0)
                            {{$field->cantidad_enviados_aprobados/$field->cantidad_enviados*100}}%
                          @else
                          -
                          @endif
                        </td>
                        
                    </tr>
                    @endforeach
            

           
            </table>
        </div>
        {{--MOver a indicadores--}}      
        <div>
         @if(method_exists($data, 'appends'))
          {!! $data->appends(Request::all())->render() !!}
         @endif
        </div>
    </div>
</div>

