@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicadores de Oportunidad</h3>
<hr/>

{!! Form::model(Request::all(),["route"=>"admin.reporte.indicadores_oportunidad_2","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Inicio:</label>
        <div class="col-sm-10">
            
            {!! Form::text("fecha_inicio",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio" ]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Final:</label>
        <div class="col-sm-10">
            {!! Form::text("fecha_final",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_final" ]); !!}
            
        </div>
         
    </div>

    {{--<div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Inicio Tentativa:</label>
        <div class="col-sm-10">
            
            {!! Form::text("fecha_inicio_tentativa",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio_tentativa" ]); !!}
        </div>
    </div>
     <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Final Tentativa:</label>
        <div class="col-sm-10">
            
            {!! Form::text("fecha_final_tentativa",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_final_tentativa" ]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Cliente:</label>
        <div class="col-sm-10">
           {!! Form::select("cliente_id",[],null,["class"=>"form-control" ]); !!}
        </div>
    </div>--}}
    <button type="submit" class="btn btn-success">Generar</button>

    <div class="clearfix"></div>
        
    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
{!! Form::close() !!}
    @if($mostrar)

    <div class="container-fluyd">
      <div class="row">
       <div class="col-sm-12 text-center">Directos</div>
        <div class=" col-md-8">
          <table class="table table-bordered">
            <thead>
             <tr>
              <th style="text-align: center;">TIPO DE CARGO</th>
              <th style="text-align: center;">ANS</th>
              <th style="text-align: center;">PROMEDIO(Dias)</th>
              <th style="text-align: center;">%CUMPLIMIENTO</th>
              <th style="text-align: center;"># PROCESOS</th>
             </tr>
            </thead>
            <tbody>
               <tr>
                <td style="text-align: center;">
                    DIRECTIVOS
                </td>
                <td style="text-align: center;">62 </td>
                <td style="text-align: center;">{{$requerimiento_fijos["DIRECTIVOS"]["DIAS"]}}</td>
                <td style="text-align: center;">{{$promedio_fijos["DIRECTIVOS"]}}%</td>
                <td style="text-align: center;">{{$requerimiento_fijos["DIRECTIVOS"]["TOTAL"]}}</td>
               </tr>
               <tr>
                <td style="text-align: center;"> 
                     OPERARIO
                </td>
                <td style="text-align: center;">36 </td>
                <td style="text-align: center;">{{$requerimiento_fijos["OPERARIOS"]["DIAS"]}}</td>
                <td style="text-align: center;">{{$promedio_fijos["OPERARIOS"]}}%</td>
                <td style="text-align: center;">{{$requerimiento_fijos["OPERARIOS"]["TOTAL"]}}</td>
               </tr>
               <tr>
                <td style="text-align: center;"> 
                    ADMINISTRATIVO
                </td>
                <td style="text-align: center;">43</td>
                <td style="text-align: center;">{{$requerimiento_fijos["ADMINISTRATIVOS"]["DIAS"]}}</td>
                <td style="text-align: center;">{{$promedio_fijos["ADMINISTRATIVOS"]}}%</td>
                <td style="text-align: center;">{{$requerimiento_fijos["ADMINISTRATIVOS"]["TOTAL"]}}</td>
               </tr>
               <tr>
                <td style="text-align: center;"> 
                      MANDOS MEDIOS
                </td>
                <td style="text-align: center;">59</td>
                <td style="text-align: center;">{{$requerimiento_fijos["MANDOS MEDIOS"]["DIAS"]}}</td>
                <td style="text-align: center;">{{$promedio_fijos["MANDOS MEDIOS"]}}%</td>
                <td style="text-align: center;">{{$requerimiento_fijos["MANDOS MEDIOS"]["TOTAL"]}}</td>
               </tr>
                            
             </tbody>
                    </table>
                </div>

                <div class="col-md-4">
                 <div id="pos_graph6"></div>
                 {!! \Lava::render($tipo_chart, $report_cierre_temp, 'pos_graph6') !!}

                </div>

                <div class="col-md-6 col-md-offset-2">
                  <div id="pos_graph7">       
                  </div>
                   {!! \Lava::render('ColumnChart', $report_barras, 'pos_graph7')!!}

                </div>

             </div>
             <br>
             <br>
             <div class="row">
                <div class="col-sm-12 text-center">Temporales</div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                       
                        <thead>
                            <tr>
                                <th style="text-align: center;">TIPO DE CARGO</th>
                                <th style="text-align: center;">ANS</th>
                                <th style="text-align: center;">PROMEDIO(Dias)</th>
                                <th style="text-align: center;">%CUMPLIMIENTO</th>
                                <th style="text-align: center;"># PROCESOS</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            <tr>
                                <td style="text-align: center;"> 
                                  DIRECTIVOS
                                </td>
                               <td style="text-align: center;">62 </td>
                                <td style="text-align: center;">{{$requerimiento_temp["DIRECTIVOS"]["DIAS"]}}</td>
                                <td style="text-align: center;">{{$promedio["DIRECTIVOS"]}}%</td>
                                <td style="text-align: center;">{{$requerimiento_temp["DIRECTIVOS"]["TOTAL"]}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"> 
                                  
                                        OPERARIO
                                

                                </td>
                                <td style="text-align: center;">36 </td>
                                <td style="text-align: center;">{{$requerimiento_temp["OPERARIOS"]["DIAS"]}}</td>
                                <td style="text-align: center;">{{$promedio["OPERARIOS"]}}%</td>
                                <td style="text-align: center;">{{$requerimiento_temp["OPERARIOS"]["TOTAL"]}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"> 
                                  
                                        ADMINISTRATIVO
                                

                                </td>
                                <td style="text-align: center;">43 </td>
                                <td style="text-align: center;">{{$requerimiento_temp["ADMINISTRATIVOS"]["DIAS"]}}</td>
                                <td style="text-align: center;">{{$promedio["ADMINISTRATIVOS"]}}%</td>
                                <td style="text-align: center;">{{$requerimiento_temp["ADMINISTRATIVOS"]["TOTAL"]}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"> 
                                       MANDOS MEDIOS
                                </td>
                                <td style="text-align: center;">59 </td>
                                <td style="text-align: center;">{{$requerimiento_temp["MANDOS MEDIOS"]["DIAS"]}}</td>
                                <td style="text-align: center;">{{$promedio["MANDOS MEDIOS"]}}%</td>
                                <td style="text-align: center;">{{$requerimiento_temp["MANDOS MEDIOS"]["TOTAL"]}}</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>


                <div class="col-md-4">
                 <div id="pos_graph5">       
                </div>
                {!! \Lava::render($tipo_chart, $report_cierre, 'pos_graph5') !!}
                </div>
                

                <div class="col-md-6 col-md-offset-2">
                 <div id="pos_graph8">       
                 </div>
                 {!! \Lava::render('ColumnChart', $reporte_barras_temp, 'pos_graph8') !!}

                </div>


        </div>
        </div>


    @endif
            


{{--
{!! Form::model(Request::all(),["route"=>"admin.reporte.indicadores_oportunidad","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Inicio:</label>
        <div class="col-sm-10">
            
            {!! Form::text("fecha_inicio",$fecha_inicio,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio" ]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Final:</label>
        <div class="col-sm-10">
            {!! Form::text("fecha_final",$fecha_final,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_final" ]); !!}
            
        </div>
         
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Inicio Tentativa:</label>
        <div class="col-sm-10">
            
            {!! Form::text("fecha_inicio_tentativa",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio_tentativa" ]); !!}
        </div>
    </div>
     <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Final Tentativa:</label>
        <div class="col-sm-10">
            
            {!! Form::text("fecha_final_tentativa",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_final_tentativa" ]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Cliente:</label>
        <div class="col-sm-10">
           {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control" ]); !!}
        </div>
    </div>
    <button type="submit" class="btn btn-success">Generar</button>

    <div class="clearfix"></div>
        
    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
{!! Form::close() !!}
</br>
<div class="container">
        <div class="row">
        <div class=" col-md-6">
            @if(isset($report_name4))
            <div id="perf_div1">       
            </div>
            {!! \Lava::render('ComboChart', $report_name4, 'perf_div1') !!}
            @endif
        </div>
       
    </div>
    <br><br>
    
    <br><br>
    <div class="row">
        <div class=" col-md-6">
            @if(isset($report_name))
            <div id="pos_graph">       
            </div>
            {!! \Lava::render($tipo_chart, $report_name, 'pos_graph') !!}
            @endif
        </div>
            <div class=" col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th># Presentados</th>
                        <th>% OP. Presentación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Oportunamente</td>
                        <td>{{ $data01['total_presentados_op'] }}</td>
                        <td>{{ $data01['avg_iop'] }}%</td>
                    </tr>
                    <tr>
                        <td>InOportunamente</td>
                        <td>{{ $data01['total_presentados_iop'] }}</td>
                        <td>{{ $data01['avg_iop_ino'] }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class=" col-md-6">
            @if(isset($report_name2))
            <div id="pos_graph2">       
            </div>
            {!! \Lava::render($tipo_chart, $report_name2, 'pos_graph2') !!}
            @endif
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
                
                <thead>
                    <tr>
                        <th></th>
                        <th># Contratados</th>
                        <th>% OP. Contratación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Oportunamente</td>
                        <td>{{ $data02['total_contratados_op'] }}</td>
                        <td>{{ $data02['avg_ioc'] }}%</td>
                    </tr>
                    <tr>
                        <td>InOportunamente</td>
                        <td>{{ $data02['total_contratados_iop'] }}</td>
                        <td>{{ $data02['avg_ioc_ino'] }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
   {{--  <div class="row">
        <div class=" col-md-6">
            @if(isset($report_name3))
            <div id="pos_graph3">       
            </div>
            {!! \Lava::render($tipo_chart, $report_name3, 'pos_graph3') !!}
            @endif
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th># Contratados Presentados</th>
                        <th>% Calidad Presentación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Oportunamente</td>
                        <td>{{ $data03['total_calidad_op'] }}</td>
                        <td>{{ $data03['avg_ioca'] }}%</td>
                    </tr>
                    <tr>
                        <td>InOportunamente</td>
                        <td>{{ $data03['total_calidad_iop'] }}</td>
                        <td>{{ $data03['avg_ioca_ino'] }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> --}}    
    </div>
    --}}
<script>
    $(function () {
      $("#fecha_inicio, #fecha_final,#fecha_inicio_tentativa,#fecha_final_tentativa").datepicker(confDatepicker);
      
      /*$('#export_excel_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $(this).prop("href","{{ route('admin.reportes.reporte-excel-indicadores') }}?"+$data_form+"&formato=xlsx" );
      });*/
      /*$('#export_pdf_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $(this).prop("href","{{ route('admin.reportes.reporte-excel-indicadores') }}?"+$data_form+"&formato=pdf" );
      });*/
    });
    
 </script>
 @stop