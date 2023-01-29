@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicadores</h3>
<hr/>
{!! Form::model(Request::all(),["route"=>"admin.reporte.indicadores_eficacia_tiempos","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
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
    </div>
    @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Tipo Proceso:</label>
            <div class="col-sm-10">
               {!! Form::select("proceso_id",$tipo_solicitud,null,["class"=>"form-control" ]); !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Usuarios:</label>
            <div class="col-sm-10">
               {!! Form::select("user_id",$usuarios_gestionan,null,["class"=>"form-control" ]); !!}
            </div>
        </div>
    @endif
    
    <button type="submit" class="btn btn-success">Generar</button>

    <div class="clearfix"></div>
        
    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
{!! Form::close() !!}
</br>
<div class="container">
       
    <div class="row">
        <div class=" col-md-6">
            @if(isset($report_efi))
            <div id="pos_graph4">       
            </div>
            {!! \Lava::render($tipo_chart, $report_efi, 'pos_graph4') !!}
            @endif
        </div>
        <div class=" col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center;"> Promedio total de días contrato</th>
                        <th style="text-align: center;">Promedio días contratos extemporaneos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                        @if($eficacia1['promedio_dias'] == 1 and $eficacia1['promedio_dias_demora'] ==1 )
                        <td style="background-color: yellow;text-align: center;">No hay requerimientos </td>
                        <td style="background-color: yellow;text-align: center;">No hay requerimientos </td>

                             
                             @else
                             <td style="text-align: center;">{{ $eficacia1['promedio_dias'] }}</td>
                              <td style="text-align: center;">{{ $eficacia1['promedio_dias_demora'] }}</td>
                        @endif
                        
                       
                    </tr>
                    
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center;"> Promedio dias contratos oportunos</th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                        @if($eficacia1['promedio_dias'] == 1 and $eficacia1['promedio_dias_oportuno'] ==1 )
                       
                        <td style="background-color: yellow;text-align: center;">No hay requerimientos </td>

                             
                             @else
                             
                              <td style="text-align: center;">{{ $eficacia1['promedio_dias_oportuno'] }}</td>
                        @endif
                        
                       
                    </tr>
                    
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center;"> # Contratos oportunos</th>
                        <th style="text-align: center;"># Contratos extemporaneos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                                 @if($eficacia1['contratos_oportunos']==1)
                                     <td style="text-align: center;">0</td>
                                @else
                                    <td style="text-align: center;">{{ $eficacia1['contratos_oportunos'] }}</td>
                                @endif
                                @if($eficacia1['contratos_destiempo']==1)
                                      <td style="text-align: center;">0</td>
                                @else
                       
                              <td style="text-align: center;">{{ $eficacia1['contratos_destiempo'] }}</td>
                                @endif
                        
                       
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
    
   
  
     
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