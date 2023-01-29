@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicador de eficacia</h3>
<hr/>
<div class="container">
  <div class="jumbotron" style="background: #f5f5f5;">
    <h3>Información:</h3>
    <p>Este indicador mostrará el contraste entre las vacantes creadas y las vacantes que efectivamente se han contratado para ciertos clientes ó períodos de tiempo que se utilicen como filtros de búsqueda.</p>
  </div>
</div>

{!! Form::model(Request::all(),["route"=>"admin.reporte.indicadores_eficacia","method"=>"GET","accept-charset"=>"UTF-8","name"=>"form_eficacia","id"=>"form_eficacia"]) !!}
 {!! Form::hidden("cierre","",["id"=>"cierre"]) !!}

 {{--@if(route("home")!="https://gpc.t3rsc.co")
    <div class="col-sm-12 form-group">
       <button type="submit" class="btn btn-info pull-right" id="cerrar_mes">Cerrar mes</button>
    </div>

 @endif--}}
    

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Rango Fecha Creación:</label>
        <div class="col-sm-8">
            
            {!! Form::text("fecha_carga_ini",null,["class"=>"form-control range","placeholder"=>"Fechas de creación de vacante","id"=>"fecha_carga_ini","autocomplete"=>"off"]); !!}
        </div>
    </div>
    {{--<div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Creacion Final:</label>
        <div class="col-sm-10">
            {!! Form::text("fecha_carga_fin",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_carga_fin" ]); !!}
            
        </div>
    </div>--}}
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Rango Fecha Cierre:</label>
        <div class="col-sm-8">
            {!! Form::text("fecha_tenta_ini",null,["class"=>"form-control range","placeholder"=>"Fechas tentativas de cierre","id"=>"fecha_tenta_ini","autocomplete"=>"off"]); !!}
        </div>
    </div>

     {{--<div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Tentativa Cierre:</label>
        <div class="col-sm-10">
            {!! Form::text("fecha_tenta_fin",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_tenta_fin" ]); !!}
            
        </div>
    </div>--}}

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Proceso:</label>
        <div class="col-sm-8">
           {!! Form::select("proceso_id[]",$tipo_solicitud,null,["class"=>"selectpicker form-control","multiple"=>true,"data-actions-box"=>true]); !!}
        </div>
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Usuarios gestionan:</label>
        <div class="col-sm-8">
           {!! Form::select("user_id",$usuarios_gestionan,null,["class"=>"form-control"]); !!}
        </div>
    </div>
    
     <div class="col-md-6 col-sm-pull-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Cliente:</label>
        <div class="col-sm-8">
           {!! Form::select("cliente_id[]",$clientes,null,["class"=>"selectpicker form-control","multiple"=>true,"data-actions-box"=>true]); !!}
        </div>
    </div>
      <div class="col-md-6 form-group">
       
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-4 col-sm-offset-2"></div>
    <button type="submit" class="btn btn-success">Generar</button>
    
     @if(isset($eficacia1))
        <a class="btn btn-info" href="{{route("admin.reporte.indicadores_eficacia")}}">Limpiar</a>
    @else
      <button type="reset" class="btn btn-info" id="reset">Limpiar</button>
   @endif
    

    <div class="clearfix"></div>
        
    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
{!! Form::close() !!}
</br>
<div class="container resultados">
       
    <div class="row">
        
         @if(isset($eficacia1))
          <div class="row">
              <fieldset>
              <legend>Resultados de la búsqueda</legend>
            @if($datos)
           
            
            <div class=" col-md-6">
                @if(isset($report_efi))
                <div id="pos_graph4">       
                </div>
                {!! \Lava::render($tipo_chart, $report_efi, 'pos_graph4') !!}
                @endif
             </div>
                <div class=" col-md-6">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center;"># Vacantes Solicitadas</th>
                                @if(route("home")=="https://gpc.t3rsc.co")
                                   <th style="text-align: center;"># Vacantes Aprobadas</th>
                                @else
                                   <th style="text-align: center;"># Vacantes Contratadas</th>
                                @endif
                               
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
                         <td style="background-color: yellow;text-align: center;">No hay resultados con los parámetros descritos anteriormente</td>
                    </tr>
               </table>
            @endif
            </fieldset>
              </div>
         @endif
    </div>
    
   
  
     
    </div>
<script>
    $(function () {

      $(".selectpicker").selectpicker()

       $("#reset").click(function(){
         //$("#form_eficacia").reset();
         $(".selectpicker").each(function(){
            $(this).selectpicker("clearSelection");
            $(this).selectpicker('refresh');
          });
         $("#fecha_carga_ini").val("");
         $("#form_eficacia").trigger('reset');

         //$("#form_eficacia")[0].reset();
        // $(".resultados").slideUp();

       });

       

       
      //$("#fecha_carga_ini, #fecha_carga_fin").datepicker(confDatepicker);
      //$("#fecha_tenta_ini, #fecha_tenta_fin").datepicker(confDatepicker);

      $("#cierre").val("");
      $("#cerrar_mes").click(function(){
        $("#cierre").val("cierre");
      })
     
    });
    
 </script>
 @stop