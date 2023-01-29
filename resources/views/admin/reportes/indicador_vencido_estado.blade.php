@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicador vencidos</h3>
<hr/>
<div class="container">
  <div class="jumbotron" style="background: #f5f5f5;">
    <h3>Información:</h3>
    <p>Este indicador mostrará un listado de los requerimientos vencidos agrupados por estado del requerimiento, además de un gráfico con el porcentaje total de vencidos y no vencidos.</p>
</div>
</div>
{!! Form::model(Request::all(),["route"=>"admin.reporte.indicador_vencido_estado","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
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


<div class="clearfix"></div>
<div class="col-sm-12  text-center">
    <button type="submit" class="btn btn-success">Generar</button>
     @if(!isset($no_search))
        <a class="btn btn-info" href="{{route("admin.reporte.indicador_vencido_estado")}}">Limpiar</a>
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

            <p>Mostrando datos de <strong>{{$contador}} requerimientos({{$data->count()}} vacantes)</p>
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
                        <caption class="text-center"> Requerimientos por estado</caption>
                        <thead>
                            <tr>
                                
                                <th class="text-center">Estado requerimiento</th>
                                <th class="text-center">Cantidad de requerimientos</th>
                                <th class="text-center">Vencidos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estados_requerimientos as $tipo)
                                <tr>
                                    <td class="text-left">{{$tipo->descripcion}}</td>
                                    <td class="text-center">{{$array_estados[$tipo->id]['cantidad']}}</td>
                                    <td class="text-center">{{$array_estados[$tipo->id]['vencidos']}}</td>
                                </tr>
                            @endforeach
                            {{--<tr>
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
                            </tr>--}}
                        </tbody>
                    </table>
                </div>
                <div class="col-md-8 col-md-offset-2">
                    @if(isset($report_reclu))
                    <div id="pos_graph">       
                    </div>
                    {!! \Lava::render('PieChart', $report_reclu, 'pos_graph') !!}
                    @endif
                </div>
                
            </div>
            <br><br>
            
        <br><br>
        

        

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