@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicador indice cancelaciones</h3>
<hr/>

{!! Form::model(Request::all(),["route"=>"admin.reporte.indicador_indice_cancelaciones","method"=>"GET","accept-charset"=>"UTF-8"]) !!}

{!! Form::hidden("busqueda","true") !!}
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

     <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Tipo cancelación:</label>
        <div class="col-sm-10">
            {!! Form::select("tipo_cancelacion",[""=>"Seleccionar",1=>"Por el cliente",2=>"Por selección"],null,["class"=>"form-control","id"=>"tipo_cancelacion" ]); !!}
            
        </div>
         
    </div>

    <div class="clearfix"></div>
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
    <div class="row text-center">
         <button type="submit" class="btn btn-success" >Generar</button>
    </div>
   

    <div class="clearfix"></div>
    <br>
        
    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
{!! Form::close() !!}
   <div class="clearfix"></div>

    <div class="container-fluyd">

         @if(isset($busqueda))
   
         <div class="row">
        <div class="col-md-6">
           <table class="table table-bordered">
                <thead>
                    <tr>
                        
                        <th class="text-center"># Vacantes solicitadas</th>
                        <th class="text-center"># Vacantes canceladas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">{{$vacantes_totales}}</td>
                        <td class="text-center">{{$vacantes_canceladas}}</td>
                    </tr>
                   
                </tbody>
            </table>

            <div>
                <h3 class="text-center">Detalle cancelaciones</h3>
            </div>
             <table class="table table-bordered">
                <thead>
                    <tr>
                        
                        <th class="text-center">Motivo</th>
                        <th class="text-center">#vacantes</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($detalle_motivo as $clave=>$valor)
                        <tr>
                           <td>{{$clave}}</td>
                           <td>{{$valor['total']}}</td>
                        </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
            <div class="col-md-6">
                 <div id="pos_graph5">       
                </div>
                {!! \Lava::render($tipo_chart, $report_cance, 'pos_graph5') !!}
            </div>
    </div>
    <h3 class="text-center">Detalle por agencias</h3>
    <div class="row">

        <div class="col-sm-12">
             <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        
                        <th class="">Motivo/Agencia</th>
                        @foreach($agencias as $agencia)
                            <th class="" style="font-size: .6em;">{{$agencia->descripcion}}</th>
                        @endforeach

                         <th style="font-weight: bold;">Total</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($detalle_motivo as $clave=>$valor)
                        <tr>
                           <td>{{$clave}}</td>
                           @foreach($valor["agencias"] as $age)
                                <td class="text-center">{{$age}}</td>
                            @endforeach
                           <td style="font-weight: bold;background: silver;">{{$valor['total']}}</td>
                        </tr>
                   @endforeach
                </tbody>
            </table>

        </div>
        
    </div>
    
        @endif
     
    </div>


   
  

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