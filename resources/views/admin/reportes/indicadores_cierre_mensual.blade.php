@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicadores</h3>
<hr/>
<p>Cierre mensual</p>
{{--}}
{!! Form::model(Request::all(),["route"=>"admin.reporte.indicadores_eficacia","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
 {!! Form::hidden("cierre","",["id"=>"cierre"]) !!}

    <div class="col-sm-12 form-group">
       <button type="submit" class="btn btn-info pull-right" id="cerrar_mes">Cerrar mes</button>
    </div>
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
</br>
<div class="container">
       
    <div class="row">
        
         @if(isset($eficacia1))
            @if($datos)
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
                                <th style="text-align: center;"># Vacantes Solicitadas</th>
                                <th style="text-align: center;"># Vacantes Contratadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                               
                                    @if($eficacia1['total_vacantes'] == 1)
                                    <td style="background-color: yellow;text-align: center;">No hay requerimientos en este rango de fechas</td>
                                         
                                         @else
                                         <td style="text-align: center;">{{ $eficacia1['total_vacantes'] }}</td>
                                    @endif

                                
                                <td style="text-align: center;">{{ $eficacia1['total_contratados'] }}</td>
                                
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            @else
               <table class="table table-bordered">
                    <tr>
                         <td style="background-color: yellow;text-align: center;">No hay resultados con los paremtros descritos anteriormente</td>
                    </tr>
               </table>
            @endif
         @endif
    </div>
    
   
  
     
    </div>--}}
<script>
    $(function () {
      $("#fecha_carga_ini, #fecha_carga_fin").datepicker(confDatepicker);
      $("#fecha_tenta_ini, #fecha_tenta_fin").datepicker(confDatepicker);

      
     
    });
    
 </script>
 @stop