@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicadores de Oportunidad</h3>
<hr/>
<div class="container">
  <div class="jumbotron" style="background: #f5f5f5;">
    <h3>Información:</h3>
    <p>Este indicador mostrará la efectividad en la presentación al cliente y contratación de candidatos de todas las vacantes que coincidan con los filtros especificados.</p>
</div>
</div>
{!! Form::model(Request::all(),["route"=>"admin.reporte.indicadores_oportunidad","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-4 control-label">Rango Fecha Creación:</label>
    <div class="col-sm-8">
        
        {!! Form::text("fecha_inicio",null,["class"=>"range form-control","placeholder"=>"Fecha creación de requerimientos","id"=>"fecha_inicio","autocomplete"=>"off"]); !!}
    </div>
</div>

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-4 control-label">Rango Fecha Cierre:</label>
    <div class="col-sm-8">
        
        {!! Form::text("fecha_inicio_tentativa",null,["class"=>"range form-control","placeholder"=>"Fecha tentativa de cierre","id"=>"fecha_inicio_tentativa","autocomplete"=>"off"]); !!}
    </div>
</div>

<div class="col-md-6 form-group">
   <label for="inputEmail3" class="col-sm-4 control-label">Cliente:</label>
   <div class="col-sm-8">
     {!! Form::select("cliente_id[]",$clientes,null,["class"=>"selectpicker form-control","multiple"=>true,"data-actions-box"=>true]); !!}
 </div>
</div>

<div class="col-md-6 form-group">
   <label for="inputEmail3" class="col-sm-4 control-label">Usuarios:</label>
   <div class="col-sm-8">
     {!! Form::select("user_id[]",$usuarios_gestionan,null,["class"=>"selectpicker form-control","multiple"=>true,"data-actions-box"=>true ]); !!}
 </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-12  text-center">
    <button type="submit" class="btn btn-success">Generar</button>
     @if(!isset($no_search))
        <a class="btn btn-info" href="{{route("admin.reporte.indicadores_oportunidad")}}">Limpiar</a>
    @else
      <button type="reset" class="btn btn-info" id="reset">Limpiar</button>
   @endif
</div>





    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
        <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
        {!! Form::close() !!}
    </br>
    <div class="container">
        <div class="row">
            
            @if(!isset($no_search))
            <legend>Resultados de la búsqueda</legend>

            <p>Mostrando datos de <strong>{{$contador}} requerimientos({{$vacantes}} vacantes)</p>
            {{--<div class="row">
                <div class=" col-md-6">
                    @if(isset($report_name4))
                    <div id="perf_div1">       
                    </div>
                    {!! \Lava::render('ComboChart', $report_name4, 'perf_div1') !!}
                    @endif
                </div>
                
            </div>--}}
            <br><br>
            
            <br><br>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <table class="table table-bordered table-striped">
                        <caption class="text-center"> Datos de presentación al cliente</caption>
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Cantidad de Candidatos</th>
                                <th class="text-center">% Oportunidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Presentados oportunamente</td>
                                <td class="text-center">{{ $data01['total_presentados_op'] }}</td>
                                <td class="text-center">{{ $data01['avg_iop'] }}%</td>
                            </tr>
                            <tr>
                                <td>Presentados inoportunamente</td>
                                <td class="text-center">{{ $data01['total_presentados_iop'] }}</td>
                                <td class="text-center">{{ $data01['avg_iop_ino'] }}%</td>
                            </tr>
                            <tr>
                                <td>No presentados</td>
                                <td class="text-center">{{ $data01['total_no_presentados'] }}</td>
                                <td class="text-center">{{ $data01['avg_no_presentados'] }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-8 col-md-offset-2">
                    @if(isset($report_name))
                    <div id="pos_graph">       
                    </div>
                    {!! \Lava::render($tipo_chart, $report_name, 'pos_graph') !!}
                    @endif
                </div>
                
            </div>
            <br><br>
            @if(route("home")!="https://gpc.t3rsc.co")
            <div class="row">
               <div class="col-md-8 col-md-offset-2">
                <table class="table table-bordered table-striped">
                    <caption class="text-center"> Datos de contratación</caption>
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">Cantidad de Candidatos</th>
                            <th class="text-center">% Oportunidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Contratados oportunamente</td>
                            <td class="text-center">{{ $data02['total_contratados_op'] }}</td>
                            <td class="text-center">{{ $data02['avg_ioc'] }}%</td>
                        </tr>
                        <tr>
                            <td>Contratados inoportunamente</td>
                            <td class="text-center">{{ $data02['total_contratados_iop'] }}</td>
                            <td class="text-center">{{ $data02['avg_ioc_ino'] }}%</td>
                        </tr>
                        <tr>
                            <td>No contratados</td>
                            <td class="text-center">{{ $data02['total_no_contratados'] }}</td>
                            <td class="text-center">{{ $data02['avg_no_contratados'] }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-8 col-md-offset-2">
                @if(isset($report_name2))
                <div id="pos_graph2">       
                </div>
                {!! \Lava::render($tipo_chart, $report_name2, 'pos_graph2') !!}
                @endif
            </div>
            
        </div>
        @endif
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

        

        @endif
    </div> 
</div>

<script>
    $(function(){


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

    });
</script>

@stop