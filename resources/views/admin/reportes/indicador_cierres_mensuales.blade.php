@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicadores mensuales</h3>
<hr/>

{!! Form::model(Request::all(),["route"=>"admin.reporte.cierres_mensuales","method"=>"GET","accept-charset"=>"UTF-8"]) !!}


 <div class="col-md-4 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Mes:</label>
        <div class="col-sm-10">
           {!! Form::select("mes",$meses,$mes,["class"=>"form-control","required"=>"required" ]); !!}
        </div>
  </div>

<div class="col-sm-4">
  <button type="submit" class="btn btn-success">Buscar</button>
</div>

 

 <div class="col-sm-4" >
  <h2 style="margin:0;">{{$meses[$mes]}} {{$ano_actual}}</h2>
</div>

    <div class="clearfix"></div>
        
    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
{!! Form::close() !!}

<br>
<br>
  {{--
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
    <div class="col-md-6 form-group">
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
    </div>
      <div class="col-md-6 form-group">
       
    </div>
    
    <button type="submit" class="btn btn-success">Generar</button>

    <div class="clearfix"></div>
        
    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
{!! Form::close() !!}
--}}
</br>
<div class="container">



  <div class="row">
    <h2 style="text-align: center;">Indicador Eficacia</h2>
    <div class="col-sm-4">
       <div id="pos_graph4">       
      </div>
    {!! \Lava::render($tipo_chart, $report_efi, 'pos_graph4') !!}
        
    </div>
     <div class="col-sm-8">
       <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;"># Vacantes Solicitadas</th>
                                <th style="text-align: center;"># Vacantes Contratadas</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                            <tr>
                               <td style="text-align: center;">{{$eficacia->total_vacante}}</td>
                                <td style="text-align: center;">{{$eficacia->total_contratados}}</td>
                            </tr>
                            
                        </tbody>
                    </table>
      
    </div>


  </div>

  
<br>
 <div class="row">
    <h2 style="text-align: center;">Indicador cancelaciones</h2>
    <div class="col-sm-5">
       <div id="pos_graph6">       
      </div>
    {!! \Lava::render($tipo_chart, $report_cance, 'pos_graph6') !!}
        
    </div>
     <div class="col-sm-7">
       <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;"># C. Temporizar</th>
                                <th style="text-align: center;"># C. Cliente</th>
                                <th style="text-align: center;"># C. No efectivas</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                            <tr>
                              <td style="text-align: center;">{{$cancelacion->numero_cancelados_cliente}}</td>
                              <td style="text-align: center;">{{$cancelacion->numero_cancelados_temporizar}}</td>
                              <td style="text-align: center;">{{$cancelacion->numero_cancelados_no_efectivo}}</td>
                            </tr>
                            
                        </tbody>
                    </table>
      
    </div>


  </div>

  <div class="row">
    <h2 style="text-align: center;">Indicador Eficacia llamada</h2>
    <div class="col-sm-4">
       <div id="pos_graph7">       
      </div>
    {!! \Lava::render($tipo_chart, $report_eficacia_llamada, 'pos_graph7') !!}
        
    </div>
     <div class="col-sm-8">
       <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;"># Candidatos Asistieron</th>
                                <th style="text-align: center;"># Candidatos Reclutados</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                            <tr>
                               <td style="text-align: center;">{{$eficacia_llamada->numero_asistieron}}</td>
                                <td style="text-align: center;">{{$eficacia_llamada->numero_reclutamiento}}</td>
                            </tr>
                            
                        </tbody>
                    </table>
      
    </div>
  </div>

  
       
   {{-- <div class="row">
        
         
           @if($mostrar)
            <div class=" col-md-6">
                
                <div id="pos_graph4">       
                </div>
                {!! \Lava::render($tipo_chart, $report_cierre, 'pos_graph4') !!}
              
             </div>
              <div class=" col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;"># Requerimientos Abiertos</th>
                                <th style="text-align: center;"># Requerimientos en Proceso</th>
                                <th style="text-align: center;"># Requerimientos cerrados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td style="text-align: center;">
                                <table class="table table-bordered">
                                  <tr>
                                    <th style="text-align: center;">Temp</th>
                                    <th style="text-align: center;">fijo</th>
                                  </tr>
                                  <tr>
                                    <td>{{$req_abiertos['temp']}}</td>
                                    <td>{{$req_abiertos['fijo']}}</td>
                                  </tr>
                                </table>
                               
                                    
                              </td>
                                <td style="text-align: center;">
                                <table class="table table-bordered">
                                  <tr>
                                    <th style="text-align: center;">Temp</th>
                                    <th style="text-align: center;">fijo</th>
                                  </tr>
                                  <tr>
                                    <td>0</td>
                                    <td>0</td>
                                  </tr>
                                </table>
                               
                                    
                              </td>

                                <td style="text-align: center;">
                                <table class="table table-bordered">
                                  <tr>
                                    <th style="text-align: center;">Temp</th>
                                    <th style="text-align: center;">fijo</th>
                                  </tr>
                                  <tr>
                                    <td>{{$req_cerrados['temp']}}</td>
                                    <td>{{$req_cerrados['fijo']}}</td>
                                  </tr>
                                </table>
                               
                                    
                              </td>
                                
                                
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
             <div class=" col-md-6">
                
                <div id="pos_graph4">       
                </div>
                {!! \Lava::render($tipo_chart, $report_cierre_fijo, 'pos_graph4') !!}
              
             </div>

              <div class=" col-md-6">
                
                <div id="pos_graph5">       
                </div>
                {!! \Lava::render($tipo_chart, $report_cierre_temp, 'pos_graph5') !!}
              
             </div>



               
           
              
          @endif
        
    </div>
    --}}
    
   
  
     
    </div>
<script>
    $(function () {
      $("#fecha_carga_ini, #fecha_carga_fin").datepicker(confDatepicker);
      $("#fecha_tenta_ini, #fecha_tenta_fin").datepicker(confDatepicker);
      
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