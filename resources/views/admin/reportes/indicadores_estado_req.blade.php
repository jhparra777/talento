@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicador de Estado</h3>
<hr/>

{!! Form::model(Request::all(),["route"=>"admin.reporte.indicadores_estado_req","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
   
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
      <label for="inputEmail3" class="col-sm-2 control-label">Cliente:</label>
       <div class="col-sm-10">
        {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control","id"=>"cliente_id" ]); !!}
       </div>
    </div>

    <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Cargo Especifico:</label>
       <div class="col-sm-10">
        <select id="cargos_esp" class="col-sm-4 form-control" name="cargo_especifico_id"></select>
       </div>
    </div>

    <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Estado req:</label>
       <div class="col-sm-10">
        {!! Form::select("estado_id",$estados_requerimiento,null,["class"=>"form-control"]); !!}
       </div>
    </div>

    <div class="col-md-6 form-group">
     <label class="col-sm-2 control-label" for="inputEmail3">
      Ciudad:</label>
     <div class="col-sm-10">
      {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
      {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
      {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
      {!! Form::text("sitio_trabajo",null,["placeholder"=>"Seleccionar una opción de la lista desplegable ","class"=>"form-control","id"=>"ciudad_autocomplete"]); !!}
      </div>
    </div>

    <button type="submit" class="btn btn-success">Generar</button>

    <div class="clearfix"></div>
        
    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
{!! Form::close() !!}
@if(!empty($mostrar))
<br>
   <div class="container-fluyd col-md-offset-2">
    <div class="row">
     <div class=" col-md-5">
        <h4>Estados de Requerimiento</h4>
      <table class="table table-bordered">
       <thead>
        <tr>
         <th style="text-align: center;">ESTADO</th>
         <th style="text-align: center;">REQUERIMIENTOS</th>
        </tr>
       </thead>
       <tbody>
      @foreach($indicador as $item)
        <tr>
         <td style=""> 
          {{$item->estadoRequerimiento_req()}}
         </td>
         <td style="">{{$item->filas}} </td>
        </tr>
      @endforeach
      <td><label>TOTAL:</label></td><td>{{$indicador->sum('filas')}}</td>
       </tbody>
     </table>
   </div>

<br>
     <div class="col-md-6">
        <h5>.</h5>
      <div id="stock-div"></div>
      {!! \Lava::render($tipo_chart,$report_cierre_temp,'stock-div') !!}
     </div>
    </div>
   </div>

   <br>
   <div class="container-fluyd col-md-offset-2">
    <div class="row">
     <div class=" col-md-5">
        <h4>Procesos Candidatos</h4>
      <table class="table table-bordered">
       <thead>
        <tr>
         <th style="text-align: center;">PROCESO</th>
         <th style="text-align: center;">CANDIDATOS</th>
        </tr>
       </thead>
       <tbody>
      @foreach($indicador_c as $item)
       @if(!is_null($item->proceso) && $item->proceso !='ASIGNADO_REQUERIMIENTO')
        <tr>
         <td style=""> 
          {{$item->proceso}}
         </td>
         <td style="">{{$item->filas}} </td>
        </tr>
       @endif
      @endforeach
      <td><label>TOTAL:</label></td><td>{{$indicador_c->sum('filas')}}</td>
       </tbody>
     </table>
   </div>


<br>
     <div class="col-md-6">
        <h5>.</h5>
      <div id="indicador-candidatos"></div>
      {!! \Lava::render($tipo_chart,$reporte_estado_cand,'indicador-candidatos') !!}
     </div>
    </div>
   </div>

  @endif

<script>
    $(function () {
      $("#fecha_inicio, #fecha_final,#fecha_inicio_tentativa,#fecha_final_tentativa").datepicker(confDatepicker);

      $('#ciudad_autocomplete').autocomplete({
        serviceUrl: '{{route("autocomplete_cuidades")}}',
        autoSelectFirst: true,
        onSelect: function (suggestion) {
          console.log(suggestion);
         $("#pais_id").val(suggestion.cod_pais);
         $("#departamento_id").val(suggestion.cod_departamento);
         $("#ciudad_id").val(suggestion.cod_ciudad);
        }
      });
      
    });
        
//cargos segun cliente
     $('#cliente_id').on("change", function (e) {
          var id = $(this).val();
          console.log(id);
            //id_cliente = $("#cliente_id").val();
            $.ajax({
                url: "{{ route('admin.cargos_dependiendo_cliente') }}",
                type: 'GET',
                data: {clt_codigo: id}
                
            })
            .done(function (response) {
              $('#cargos_esp').html('');

               $('#cargos_esp').append("<option value=''>....Seleccione </option>");

              $.each(response,function(index, el) {

                $('#cargos_esp').append("<option value='"+index+"'>"+el+" </option>")
                
              });
            });
     });
    
 </script>
 @stop