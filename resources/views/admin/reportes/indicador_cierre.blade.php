@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicadores</h3>
<hr/>
{!! Form::model(Request::all(),["route"=>"admin.reporte.indicador_cierre","method"=>"GET","accept-charset"=>"UTF-8"]) !!}

    <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Fecha Creacion Inicial:</label>
        <div class="col-sm-10">
          {!! Form::text("fecha_carga_ini",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_carga_ini" ]); !!}
        </div>
    </div>

    <div class="col-md-6 form-group">
     <label for="inputEmail3" class="col-sm-2 control-label">Fecha Creacion Final:</label>
        <div class="col-sm-10">
         {!! Form::text("fecha_carga_fin",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_carga_fin" ]); !!}
        </div>
    </div>
    {{--<div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Tentativa Inicial:</label>
        <div class="col-sm-10">
            
            {!! Form::text("fecha_tenta_ini",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_tenta_ini" ]); !!}
        </div>
    </div>

     <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Tentativa Final:</label>
        <div class="col-sm-10">
            {!! Form::text("fecha_tenta_fin",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_tenta_fin" ]); !!}
            
        </div>
    </div>-}}

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Tipo Proceso:</label>
        <div class="col-sm-10">
           {!! Form::select("proceso_id",$tipo_solicitud,null,["class"=>"form-control" ]); !!}
        </div>
    </div>--}}

    {{--<div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Usuarios:</label>
        <div class="col-sm-10">
           {!! Form::select("user_id",$usuarios_gestionan,null,["class"=>"form-control" ]); !!}
        </div>
    </div>
     <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Estado req:</label>
        <div class="col-sm-10">
           {!! Form::select("estado_id",$estados_requerimiento,null,["class"=>"form-control"]); !!}
        </div>
    </div>--}}

    <button type="submit" class="btn btn-success">Generar</button>

 <div class="clearfix"></div>    
{!! Form::close() !!}
</br>
<div class="container">
       
    <div class="row">
      @if($mostrar)

            <div class=" col-md-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="text-align: center;"># Vacantes Abiertos</th>
                    <th style="text-align: center;"># Vacantes en Proceso</th>
                    <th style="text-align: center;"># Vacantes cerrados</th>
                    <th style="text-align: center;"># Vacantes canceladas</th>
                  </tr>
                </thead>
                 <tbody>
                  <tr>
                    <td style="text-align: center;">
                     <table class="table table-bordered">
                      <tr>
                       <th style="text-align: center;">Temp</th>
                       <th style="text-align: center;">Directo</th>
                       <th style="text-align: center;">Total</th>
                      </tr>
                  <tr>
                                    <td>{{$req_abiertos['temp']}}</td>
                                    <td>{{$req_abiertos['fijo']}}</td>
                                    <td>{{$req_abiertos['temp']+$req_abiertos['fijo']}}</td>
                                  </tr>
                                </table>  
                              </td>

                              <td style="text-align: center;">
                                <table class="table table-bordered">
                                  <tr>
                                    <th style="text-align: center;">Temp</th>
                                    <th style="text-align: center;">Directo</th>
                                    <th style="text-align: center;">Total</th>
                                  </tr>
                                  <tr>
                                    <td>{{$req_enproceso['temp']}}</td>
                                    <td>{{$req_enproceso['fijo']}}</td>
                                    <td>{{$req_enproceso['temp'] + $req_enproceso['fijo']}}</td>
                                  </tr>
                                </table>
                              </td>

                              <td style="text-align: center;">
                                <table class="table table-bordered">
                                  <tr>
                                    <th style="text-align: center;">Temp</th>
                                    <th style="text-align: center;">Directo</th>
                                    <th style="text-align: center;">Total</th>
                                  </tr>
                                  <tr>
                                    <td>{{$req_cerrados['temp']}}</td>
                                    <td>{{$req_cerrados['fijo']}}</td>
                                    <td>{{$req_cerrados['temp']+$req_cerrados['fijo']}}</td>
                                  </tr>
                                </table>
                              </td>
                              <td style="text-align: center;">
                                <table class="table table-bordered">
                                  <tr>
                                    <th style="text-align: center;">Temp</th>
                                    <th style="text-align: center;">Directo</th>
                                    <th style="text-align: center;">Total</th>
                                  </tr>
                                  <tr>
                                    <td>{{$req_cancelados['temp']}}</td>
                                    <td>{{$req_cancelados['fijo']}}</td>
                                    <td>{{$req_cancelados['temp']+$req_cancelados['fijo']}}</td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                 </tbody>
              </table>
            </div>

          <div class="row">

          <div class="col-md-12">
          
            <div class=" col-md-4">
              <div id="pos_graph4"></div>
              {!! \Lava::render($tipo_chart, $report_cierre_fijos, 'pos_graph4') !!}
            </div>

            <div class="col-md-4">
             <div id="pos_graph5"></div>
                {!! \Lava::render($tipo_chart, $report_cierre_temp, 'pos_graph5') !!}
            </div>

            <div class="col-md-4">
              <div id="pos_graph6"></div>
                {!! \Lava::render($tipo_chart, $report_cierre_totales, 'pos_graph6') !!}
            </div>
          
          </div>

          </div>
<br><br>

          <div class="row">

          <div class="col-md-12">
            
            <div class="col-md-4">
              
              <div id="pos_graph7"></div>
                <!--Acá va el grafivo de cancelados-->
               {!! \Lava::render($tipo_chart, $report_cierre_cancelados, 'pos_graph7') !!}
            </div>

          {{-- <div class="col-md-4">
              
              <div id="pos_graph8"></div>
               {!! \Lava::render($tipo_chart, $report_cancel_proces, 'pos_graph8') !!}
            </div> --}}

            <div class="col-md-4">
              
              <div id="pos_graph9"></div>
                <!--Acá va el grafivo de cancelados-->
               {!! \Lava::render($tipo_chart, $report_total_cancel_proces, 'pos_graph9') !!}
            </div>

          </div>
        
        </div>

      @endif
    </div>

</div>

<script>
  $(function () {
      $("#fecha_carga_ini, #fecha_carga_fin").datepicker(confDatepicker);
      $("#fecha_tenta_ini, #fecha_tenta_fin").datepicker(confDatepicker);
      
  });
</script>
 @stop