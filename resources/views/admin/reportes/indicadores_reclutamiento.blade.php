@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicadores de Reclutamiento</h3>
<hr/>
<div class="container">
  <div class="jumbotron" style="background: #f5f5f5;">
    <h3>Información:</h3>
    <p>Este indicador mostrará según el rango de fechas establecido, la cantidad de hojas de vida cargadas en el sistema agrupadas por método de carga.</p>
  </div>
</div>
{!! Form::model(Request::all(),["route"=>"admin.reporte.indicadores_reclutamiento","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
    
    
    {{--<div class="col-md-12 col-lg-12">
    <div class="row">
        <div class="box">
                <div class="box-header with-border">
                <h3 class="box-title">
                    Cifras Globales
                </h3>
                <br><br>
     
               </div>

               <div class="box-body table-responsive no-padding">

                    <table class="table table-bordered" id="tbl_preguntas" >
            <thead>
                <tr>
                    <th style="text-align: center;">Total Hojas de vida</th>
                    <th style="text-align: center;">Total candidatos gestionados</th>
                    <th style="text-align: center;">Total candidatos que asistieron a entrevista</th>
                    <th style="text-align: center;" >Candidatos aptos en la entrevista</th>

                </tr>
            </thead>
            <tbody>
                
                <td style="text-align: center;">{{$total_ingresados}}</td>
                <td style="text-align: center;">{{$total_candi_req}}</td>
                <td style="text-align: center;">{{$total_candi_asis}}</td>
                <td style="text-align: center;">{{$total_candi_aptos}}</td>

            </tbody>
        </table>
                   
                </div>

        </div>   
       
    </div>
</div>
--}}
<div class="container">
       
    <div class="row text-center" style="">
        <div class="col-md-4 col-md-offset-1">
            @if(isset($report_name4))
            <div id="pos_graph4">       
            </div>
            {!! \Lava::render('ComboChart', $report_name4, 'pos_graph4') !!}
            @endif
        </div>
        
    </div>
    
   
  
     
</div>
<br><br><br><br><br>
     

    <div class="col-md-8 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Rango Fecha Carga:</label>
        <div class="col-sm-8">
            
            {!! Form::text("fecha_tenta_ini",null,["class"=>"form-control range-up","placeholder"=>"Fecha de carga hoja de vida","id"=>"fecha_tenta_ini","autocomplete"=>"off"]); !!}
        </div>
    </div>

     {{--<div class="col-md-4 form-group">
        <label for="inputEmail3" class="col-sm-6 control-label">Fecha Tentativa Final:</label>
        <div class="col-sm-6">
            {!! Form::text("fecha_tenta_fin",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_tenta_fin" ]); !!}
            
        </div>
    </div>--}}

    
    <button type="submit" class="btn btn-success">Generar</button>
   <a  href="{{route('admin.reporte.indicadores_reclutamiento')}}" class="btn btn-warning">Limpiar</a>

    <div class="clearfix"></div>
        
    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
{!! Form::close() !!}
<br>
<div class="container">
       
    <div class="row">
        
         @if($search)
          <div class="row">
              <fieldset>
              <legend>Resultados de la búsqueda</legend>
            @if($datos)
           
            
            <div class=" col-md-6">
                @if(isset($report_reclu))
                <div id="pos_graph5">       
                </div>
                {!! \Lava::render('PieChart', $report_reclu, 'pos_graph5') !!}
                @endif
             </div>
                <div class=" col-md-6">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Método carga</th>
                               
                                <th style="text-align: center;"># hojas de vida</th>
                               
                               
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=1;$i<=count($array_metodos);$i++)

                              <tr>
                               
                                  <td style="text-align: left;">{{ $array_metodos[$i]["nombre"] }}</td>
                                  <td style="text-align: center;">{{$array_metodos[$i]["cantidad"]}}</td>
                                
                              </tr>

                            @endfor
                           

                            
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
    $(function(){
          $(".range-up").attr("readonly",true);
         $('.range-up').daterangepicker({
         "autoApply": true,
         "autoUpdateInput": false,
    ranges: {
        'Hoy': [moment(), moment()],
        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 Días': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
        'Mes actual': [moment().startOf('month'), moment().endOf('month')],
        'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    "drops": "up",
    "locale": {
        "format": "YYYY-MM-DD",
        "separator": " | ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Deciembre"
        ],
        "firstDay": 1
    }
      });

        $('.range-up').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('YYYY-MM-DD') + ' | ' + picker.endDate.format('YYYY-MM-DD'));
    });
        

      $('.range-up').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      });

    });

    
    
  </script>

 @stop