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
                @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")

                   @if(route('home') == "https://gpc.t3rsc.co")

                    {{-- GPC--}}
                    @foreach( $data as $field )
                    <tr>
                        <td >
                            {{$field->requerimiento_id}}
                        </td>
                        <td >
                            {{$field->tipo_requerimiento}}
                        </td>
                        {{--<td >
                            {{$field->agencia}}
                        </td>--}}
                        <td >
                            {{$field->ciudad_req}}
                        </td>
                        <td >
                            {{$field->departamento}}
                        </td>
                        <td >
                            {{$field->pais}}
                        </td>
                        <td >
                            {{$field->cliente}}
                        </td>
                        <td >
                            {{$field->cargo_generico}}
                        </td>
                        <td >
                            {{$field->cargo_cliente}}
                        </td>
                        <td >
                            {{$field->vacantes_solicitadas}}
                        </td>
                        {{--<td >
                            {{$field->cant_enviados_examenes}}
                        </td>
                        <td >
                            {{$field->cant_enviados_contratacion}}
                        </td>--}}
                        <td >
                            {{$field->cant_contratados}}
                        </td>
                        <td >
                            {{$field->fecha_inicio_vacante}}
                        </td>
                        <td >
                            {{$field->fecha_tentativa}}
                        </td>
                        <td >
                        
                            @if($field->dias_vencidos< 1 )
                                0
                            @else
                            {{$field->dias_vencidos}}
                            @endif  
                        </td>
                        <td  class="{{ $field->semaforo }}">
                            {{$field->ultimoEstadoRequerimiento()->estado_nombre}}
                        </td>

                        <td >
                            {{$field->dias_gestion}}
                        </td>
                        <td >
                            {{$field->fecha_cierre_req}}
                        </td>
                        <td >
                            {{$field->usuario_cargo_req}}
                        </td>
                        <td >
                            {{$field->usuario_gestiono_req}}
                        </td>
                        <td >
                            {{$field->vacantes_reales}}
                        </td>
                      
                    </tr>
                    @endforeach

                  @else
                    @foreach( $data as $field )
                    <tr>
                        <td >
                            {{$field->requerimiento_id}}
                        </td>
                        <td >
                            {{$field->tipo_requerimiento}}
                        </td>
                        <td >
                            {{$field->nombre_agencia}}
                        </td>
                        <td >
                            {{$field->ciudad_req}}
                        </td>
                        <td >
                            {{$field->departamento}}
                        </td>
                        <td >
                            {{$field->pais}}
                        </td>
                        <td >
                            {{$field->cliente}}
                        </td>
                        <td >
                            {{$field->cargo_generico}}
                        </td>
                        <td >
                            {{$field->cargo_cliente}}
                        </td>
                        <td >
                            {{$field->vacantes_solicitadas}}
                        </td>
                        <td >
                            {{$field->cant_enviados_examenes}}
                        </td>
                        <td >
                            {{$field->cant_enviados_contratacion}}
                        </td>
                        <td >
                            {{$field->cant_contratados}}
                        </td>
                        <td >
                            {{$field->fecha_inicio_vacante}}
                        </td>
                        <td >
                            {{$field->fecha_tentativa}}
                        </td>
                        <td >
                        
                            @if($field->dias_vencidos< 1 )
                                0
                            @else
                            {{$field->dias_vencidos}}
                            @endif  
                        </td>
                        <td  class="{{ $field->semaforo }}">
                            {{$field->ultimoEstadoRequerimiento()->estado_nombre}}
                        </td>

                        <td >
                            {{$field->dias_gestion}}
                        </td>
                        <td >
                            {{$field->fecha_cierre_req}}
                        </td>
                        <td >
                            {{$field->usuario_cargo_req}}
                        </td>
                        <td >
                            {{$field->usuario_gestiono_req}}
                        </td>
                        <td >
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
                        <td >
                          {{--cuando es para tiempos de calcula de forma distinta --}}
                         @if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co")
                             
                             {{$field->ind_cumplimiento_ans()}}%

                            <?php
                            if($field->ind_cumplimiento_ans() != 0){
                              $suma++;
                            }
                            ?>

                         @else
                         
                            {{$field->ind_oport_presentacion}}%
                         @endif

                        </td>
                           {{--cuando es para tiempos de calcula de forma distinta --}}
                          @if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co")
                             {{-- {{$field->ind_contratacion_oportwwuna()}}% --}}
                          @else
                        <td >
                          {{$field->ind_oport_contratacion}}%   
                        </td>
                          @endif

                        <td >
                           {{--cuando es para tiempos de calcula de forma distinta --}}
                         @if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co")
                             
                             {{$field->ind_calidad_presentac()}}%

                            <?php
                            if($field->ind_calidad_presentac() != 0){
                              $calidad++;
                            }
                            ?>
                          @else

                            {{(!$field->ind_calidad_presentacion)?0:$field->ind_calidad_presentacion}}%
                          @endif
                         
                        </td>
                    </tr>
                    @endforeach
                  @endif
                @endif

            @if(route('home') == "http://soluciones.t3rsc.co" || route('home') == "https://soluciones.t3rsc.co")

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
                        <td >
                            {{$field->departamento_req()}}
                        </td>
                        <td >
                            {{$field->pais_req()}}
                        </td>
                        <td >
                            {{$field->nombre_cliente_req()}}
                        </td>
                        <td >
                            {{$field->cargo_req()}}
                        </td>
                        <td >
                            {{$field->cargo_cliente}}
                        </td>
                        <td >
                            {{$field->num_vacantes}}
                        </td>
                        <td >
                            {{$field->numeroCandidatosEnviados()}}
                        </td>
                        <td >
                            {{$field->numeroCandidatosEnviadoscontratar()}}
                        </td>
                        <td >
                            {{$field->numeroCandidatosEnviadoscontratar()}}
                        </td>
                        <td >
                            {{$field->fecha_inicio_vacante}}
                        </td>
                        <td >
                            {{$field->fecha_tentativa}}
                        </td>
                        
                            @if($field->dias_vencidos< 1 )

                            <td >
                                0
                            </td>
                            @else
                        <td >
                            {{$field->dias_vencidos}}
                        </td>
                            @endif  
                        <td  class="{{ $field->semaforo }}">
                            {{$field->estado_req}}
                        </td>

                        <td >
                          {{$field->dias_gestion}}
                        </td>
                        <td >
                          {{$field->fecha_cierre_req}}
                        </td>
                        <td >
                          {{$field->usuario_cargo_req}}
                        </td>
                        <td >
                          {{$field->usuario_gestiono_req}}
                        </td>
                        <td >
                          {{$field->vacantes_reales}}
                        </td>
                        <td >
                          {{FuncionesGlobales::oport_porcent($field->cand_presentados_puntual, $field->num_vacantes)}}%
                        </td>
                        <td >
                          {{FuncionesGlobales::oport_porcent($field->cand_contratados_puntual, $field->num_vacantes)}}%
                        </td>
                        <td >
                          60%
                        </td>
                    </tr>
                    @endforeach
            @endif

           

            @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co")

                @foreach($data as $field)

                    <tr>
                      <td>{{--1--}}
                        {{$field->requerimiento_id}}
                      </td>
                      <td>{{--2--}}
                        {{$field->responsable}}
                      </td>
                      <td>{{--3--}}
                        {{$field->cargo_cliente}}
                      </td>
                      <td>{{--4--}}
                       {{$field->tipo_contrato}}
                      </td>
                      <td>{{--5--}}
                       {{$field->justificacion}}
                      </td>
                      <td>{{--6--}}
                       {{$field->vacantes_solicitadas}}
                      </td>
                      <td>{{--7--}}
                       {{$field->estado_req}}
                      </td>
                        <td>{{--8--}}
                          @if($field->ans==62)
                            DIRECTIVO
                          @elseif($field->ans==36)
                            OPERARIO
                          @elseif($field->ans==43)
                            ADMINISTRATIVO
                          @elseif($field->ans==59)
                            MANDOS MEDIOS
                          @endif
                        </td>
                        <td>{{--9--}}
                          {{$field->sede}}
                        </td>
                        <td>{{--10--}}
                          {{$field->solicitante}}
                        </td>
                        <td>{{--11--}}
                            {{$field->area}}
                        </td>
                        <td>{{--12--}}
                          {{$field->gerente_area}} 
                        </td>
                       {{-- <td></td> --}}
                        <td>{{--13--}}
                          {{$field->cant_enviados_entrevista}} 
                        </td>
                        <td>{{--14--}}
                          {{$field->cant_enviados_entrevista_tecnica}} 
                        </td>
                        <td>
                          {{$field->cant_enviados_pruebas}}  
                        </td>
                        <td>{{--15--}}
                          {{$field->cant_enviados_examenes}}  
                        </td>
                        <td>{{--16--}}
                          {{$field->cant_enviados_estudioSeg}}  
                        </td>
                        <td>{{--17--}}
                          {{$field->cant_enviados_contratacion}}
                        </td>
                        <td>{{--18--}}
                          {{$field->vacantes_reales}}  
                        </td>
                        <td>{{--19--}}
                          {{$field->ans}}  
                        </td>
                        <td>{{--20--}}
                          {{$field->fecha_solicitud}} 
                        </td>
                        <td>{{--21--}}
                         @if(is_null($field->fecha_solicitud))
                            <!-- Dias -->
                            0
                         @else

                          <?php
                           
                           $m = 'Carbon\Carbon';

                            $date1= date('Y-m-d',strtotime($field->fecha_solicitud));
                            $date2= date('Y-m-d',strtotime($field->fecha_valoracion));
                           //$diff = $fecha1->diff($fecha2);
                           $g = $m::parse($date1)->diffInWeekdays($date2);
                          ?>
                          {{$g}}
                         @endif
                        </td>
                        <td>{{--22--}}
                          {{$field->fecha_valoracion}}
                        </td>
                        <td>{{--23--}}

                          <?php

                           $m = 'Carbon\Carbon';
                          
                           $date1 = date('Y-m-d',strtotime($field->fecha_valoracion));

                          if(!is_null($field->fecha_jefe_ok)){

                            $date2 = date('Y-m-d',strtotime($field->fecha_jefe_ok));

                          }elseif(is_null($field->fecha_jefe_ok) && !is_null($field->fecha_gte_ok)){
                           
                            $date2 = date('Y-m-d',strtotime($field->fecha_gte_ok));

                          }elseif(is_null($field->fecha_jefe_ok) && is_null($field->fecha_gte_ok) && !is_null($field->fecha_rrhh_ok)){

                            $date2 = date('Y-m-d',strtotime($field->fecha_rrhh_ok));

                          }elseif(is_null($field->fecha_jefe_ok) && is_null($field->fecha_gte_ok) && is_null($field->fecha_rrhh_ok) && !is_null($field->fecha_liberacion)) {
                            # code...
                           $date2 = date('Y-m-d',strtotime($field->fecha_liberacion));
                          }

                          // $fecha7= date_create($date1);
                          // $fecha8= date_create($date2);
                          // $diff = date_diff($fecha7,$fecha8);

                          if(!empty($date2)){
                           $g = $m::parse($date1)->diffInWeekdays($date2);
                          }else{
                            $g=0;
                          }
                          
                          ?>
                          {{$g}}

                        </td>
                        <td>{{--24--}}
                          {{$field->fecha_jefe_ok}}
                        </td>
                        <td>{{--25--}}

                         <?php

                           $m = 'Carbon\Carbon';

                          if(!is_null($field->fecha_jefe_ok)){

                           $date1 = date('Y-m-d',strtotime($field->fecha_jefe_ok));

                          if(!is_null($field->fecha_gte_ok)){

                            $date2 = date('Y-m-d',strtotime($field->fecha_gte_ok));

                          }elseif(is_null($field->fecha_gte_ok) && !is_null($field->fecha_rrhh_ok)){
                           
                            $date2 = date('Y-m-d',strtotime($field->fecha_rrhh_ok));

                          }elseif(is_null($field->fecha_gte_ok) && is_null($field->fecha_rrhh_ok) && !is_null($field->fecha_liberacion)){

                           $date2 = date('Y-m-d',strtotime($field->fecha_liberacion));

                          }
                          // $fecha7= date_create($date1);
                          // $fecha8= date_create($date2);
                          // $diff = date_diff($fecha7,$fecha8);
                          if($date2){
                           $g = $m::parse($date1)->diffInWeekdays($date2);
                          }else{
                            $g=0;
                          }

                          }else{
                            $g=0;
                          }
                          
                          ?>
                          {{$g}}

                        </td>
                        <td>{{--26--}}
                          {{$field->fecha_gte_ok}}  
                        </td>
                        <td>{{--27--}}
                           <?php

                           $m = 'Carbon\Carbon';
                           $date1 = 0;
                           $date2 = 0;

                          if(!is_null($field->fecha_gte_ok)){
                          
                           $date1 = date('Y-m-d',strtotime($field->fecha_gte_ok));

                          if(!is_null($field->fecha_rrhh_ok)){

                            $date2 = date('Y-m-d',strtotime($field->fecha_rrhh_ok));

                          }elseif(is_null($field->fecha_rrhh_ok) && !is_null($field->fecha_liberacion)){
                           
                           $date2 = date('Y-m-d',strtotime($field->fecha_liberacion));

                          }
                          // $fecha7= date_create($date1);
                          // $fecha8= date_create($date2);
                          // $diff = date_diff($fecha7,$fecha8);
                          if($date2){
                           $g = $m::parse($date1)->diffInWeekdays($date2);
                          }else{
                            $g=0;
                          }

                         }else{

                           $g = 0;
                          }
                          ?>
                          
                           {{$g}}

                        </td>
                        <td>{{--28--}}
                          @if(!is_null($field->fecha_rrhh_ok))
                            {{$field->fecha_rrhh_ok}}
                          @else
                           @if($field->user_libero == 33716)
                            {{$field->fecha_liberacion}}
                           @endif
                          @endif
                        </td>
                        <td>{{--29--}}
                         @if($field->user_libero == 33717)

                          <?php

                           $m = 'Carbon\Carbon';

                          if(!is_null($field->fecha_liberacion)){
                          
                           $date1 = date('Y-m-d',strtotime($field->fecha_liberacion));

                          if(!is_null($field->fecha_rrhh_ok)){

                            $date2 = date('Y-m-d',strtotime($field->fecha_rrhh_ok));

                            $g = $m::parse($date1)->diffInWeekdays($date2);
                          
                          }else{
                           $g = 0;
                          }
                          // $fecha7= date_create($date1);
                          // $fecha8= date_create($date2);
                          // $diff = date_diff($fecha7,$fecha8);
                          }else{
                            $g= 0;
                          }
                          ?>
                          
                           {{$g}}
                         @else
                           0
                         @endif

                        </td>
                        <td>{{--30--}}
                          @if($field->user_libero == 33717)
                           {{$field->fecha_liberacion}}
                          @endif
                        </td>
                        <td>{{--31--}}
                          {{$field->fecha_liberacion}}
                        </td>
                        <td>{{--32--}}
                          @if(is_null($field->fecha_solicitud))
                            <!-- Dias -->
                            0
                          @else
                           <?php
                            
                           $m = 'Carbon\Carbon';

                            $date1 = date('Y-m-d',strtotime($field->fecha_solicitud));

                            $date2 = date('Y-m-d',strtotime($field->fecha_liberacion));

                          //  $fecha11= date_create($date1);
                           // $fecha12= date_create($date2);
                           // $diff = date_diff($fecha11,$fecha12);
                            $g = $m::parse($date1)->diffInWeekdays($date2);
                            ?>
                           {{$g}}

                          @endif
                        </td>
                        <td>{{--33--}}
                          {{$field->postulantes_internos}} 
                        </td>
                        <td>{{--34--}}
                          {{$field->postulantes_externos}}
                        </td>
                        <td>{{--35--}}
                          {{$field->postulantes_proceso_internos}} 
                        </td>
                        <td>{{--36--}}
                          {{$field->postulantes_proceso_externos}}
                        </td>
                        <td>{{--37--}}
                          {{$field->fecha_entrevista}}
                        </td>
                        <td>{{--37--}}
                         @if($field->usuario_entrevisto == 23)
                         
                         @if($field->fecha_entrevista && $field->fecha_fin_entrevista)
                          <?php
                            
                            $m = 'Carbon\Carbon';

                           $date1 = date('Y-m-d',strtotime($field->fecha_entrevista));

                           $date2 = date('Y-m-d',strtotime($field->fecha_fin_entrevista));

                          //  $fecha11= date_create($date1);
                           // $fecha12= date_create($date2);
                           // $diff = date_diff($fecha11,$fecha12);
                             $g = $m::parse($date1)->diffInWeekdays($date2);
                            ?>
                           {{$g}}
                         @else
                           0
                         @endif

                         @else
                           0
                         @endif
                        </td>
                        <td>{{--37--}}
                         @if($field->usuario_entrevisto == 23)
                          {{$field->fecha_fin_entrevista}}
                         @endif
                        </td>
                        <td>{{--38--}}
                          {{$field->fecha_entrevista_tecnica}}
                        </td>
                        <td>{{--38--}}
                        @if($field->usuario_entrevisto != 23)
                         
                         @if($field->fecha_entrevista_tecnica && $field->fecha_fin_entrevista)
                          <?php
                            
                            $m = 'Carbon\Carbon';

                            $date1 = date('Y-m-d',strtotime($field->fecha_entrevista_tecnica));

                            $date2 = date('Y-m-d',strtotime($field->fecha_fin_entrevista));

                          //  $fecha11= date_create($date1);
                           // $fecha12= date_create($date2);
                           // $diff = date_diff($fecha11,$fecha12);
                             $g = $m::parse($date1)->diffInWeekdays($date2);
                            ?>
                           {{$g}}
                         @else
                           0
                         @endif

                         @else
                           0
                         @endif

                        </td>
                        <td>{{--38--}}
                         @if($field->usuario_entrevisto != 23)
                          {{$field->fecha_fin_entrevista}}
                         @endif
                        </td>
                        <td>{{--39--}}
                          {{$field->fecha_primero_pruebas}}           
                        </td>
                        <td>{{--40--}}
                        @if(!is_null($field->fecha_ultimo_entrega_pruebas))

                          <?php
                            
                            $m = 'Carbon\Carbon';

                            $date1 = date('Y-m-d',strtotime($field->fecha_primero_pruebas));

                            $date2 = date('Y-m-d',strtotime($field->fecha_ultimo_entrega_pruebas));

                          //  $fecha11= date_create($date1);
                           // $fecha12= date_create($date2);
                           // $diff = date_diff($fecha11,$fecha12);
                             $g = $m::parse($date1)->diffInWeekdays($date2);
                            ?>
                           {{$g}}

                        @else
                           0
                        @endif
                        </td>
                        <td>{{--41--}}
                          {{$field->fecha_ultimo_entrega_pruebas}}  
                        </td>
                        <td>{{--42--}}
                          {{$field->fecha_envio_aprobar}}  
                        </td>

                        <td>{{--42--}}
                          @if(!is_null($field->fecha_aprobado_candidato))

                           <?php
                            
                            $g = 0;
                            $date1 = "";
                            $date2 ="";
                            $m = 'Carbon\Carbon';

                             $date1 = date('Y-m-d',strtotime($field->fecha_envio_aprobar));

                             $date2 = date('Y-m-d',strtotime($field->fecha_aprobado_candidato));

                             $g = $m::parse($date1)->diffInWeekdays($date2);
                            ?>
                           {{$g}}

                          @else

                           0
                          @endif 
                        </td>

                        <td>{{--42--}}
                          {{$field->fecha_aprobado_candidato}}  
                        </td>
                        {{--43--}}
                        <td>{{$field->fecha_primero_examenes}}</td>
                        <td>

                        @if(!is_null($field->fecha_ultimo_entrega_examenes))

                          <?php
                            
                            $g = 0;
                            $date1 = "";
                            $date2 ="";
                            $m = 'Carbon\Carbon';

                            $date1 = date('Y-m-d',strtotime($field->fecha_primero_examenes));

                            $date2 = date('Y-m-d',strtotime($field->fecha_ultimo_entrega_examenes));

                          //  $fecha11= date_create($date1);
                           // $fecha12= date_create($date2);
                           // $diff = date_diff($fecha11,$fecha12);
                             $g = $m::parse($date1)->diffInWeekdays($date2);
                            ?>
                           {{$g}}

                         @else

                           0
                         @endif

                        </td>
                        <td>{{--44--}}
                          {{$field->fecha_ultimo_entrega_examenes}}
                        </td>
                        <td>{{--45--}}
                         {{$field->fecha_primero_estudio}}
                        </td>
                        <td>{{--46--}}

                         @if(!is_null($field->fecha_ultimo_entrega_estudio))

                          <?php
                            
                            $m = 'Carbon\Carbon';

                            $date1 = date('Y-m-d',strtotime($field->fecha_primero_estudio));

                            $date2 = date('Y-m-d',strtotime($field->fecha_ultimo_entrega_estudio));

                          //  $fecha11= date_create($date1);
                           // $fecha12= date_create($date2);
                           // $diff = date_diff($fecha11,$fecha12);
                             $g = $m::parse($date1)->diffInWeekdays($date2);
                            ?>

                           {{$g}}

                         @else
                         
                           0
                         @endif

                        </td>
                        <td>{{--47--}}
                         {{$field->fecha_ultimo_entrega_estudio}}
                        </td>
                        <td>{{--48--}}
                         {{$field->fecha_terminacion}}
                        </td>
                        <td>{{--49--}}
                        <!-- dias transcurridos des su liberacion-->
                         @if(!is_null($field->fecha_terminacion))

                          <?php
                            
                           $m = 'Carbon\Carbon';

                           $date1 = date('Y-m-d',strtotime($field->fecha_inicio_vacante));

                          $date2 = date('Y-m-d',strtotime($field->fecha_terminacion));

                          //  $fecha11= date_create($date1);
                           // $fecha12= date_create($date2);
                           // $diff = date_diff($fecha11,$fecha12);
                             $g = $m::parse($date1)->diffInWeekdays($date2);
                            ?>
                            
                           {{$g}}

                         @else
                         
                           0
                         @endif

                        </td>
                        <td>{{--50--}}
                         {{$field->ultimo_contratado}}
                        </td>
                        <td>{{--51--}}
                         @if($field->fecha_cierre_req)
                          {{$field->fecha_cierre_req}}
                         @endif
                        </td>
                        <td>{{--52--}}
                         @if($field->fecha_cancelacion_req)
                          {{$field->fecha_cancelacion_req}}
                         @endif
                        </td>
                    </tr>
                    @endforeach
                @endif
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

