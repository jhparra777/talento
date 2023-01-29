@extends("admin.layout.master")
@section('contenedor')
<h3>
  <i aria-hidden="true" class="fa fa-file-text-o"></i>
    Reporte Rendimiento
</h3>
<hr/>
{!! Form::model(Request::all(),["route"=>"admin.reportes_tempo","method"=>"GET","accept-charset"=>"UTF-8"]) !!}


 

<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
       Fecha carga inicial
    </label>
    <div class="col-sm-6">
        {!! Form::text("fecha_carga_ini",null,["class"=>"form-control","placeholder"=>"Fecha carga inicial","id"=>"fecha_carga_ini" ]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_actualizacion_ini",$errors) !!}</p>
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
       Fecha carga Final
    </label>
    <div class="col-sm-6">
        {!! Form::text("fecha_carga_fin",null,["class"=>"form-control","placeholder"=>"Fecha carga final","id"=>"fecha_carga_fin" ]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_tenta_fin",$errors) !!}</p>
    </div>
</div>

<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
       Fecha tentativa inicial
    </label>
    <div class="col-sm-6">
        {!! Form::text("fecha_tenta_ini",null,["class"=>"form-control","placeholder"=>"Fecha tentativa inicial","id"=>"fecha_tenta_ini" ]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_tenta_ini",$errors) !!}</p>
    </div>
</div>

<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
       Fecha tentativa Final
    </label>
    <div class="col-sm-6">
        {!! Form::text("fecha_tenta_fin",null,["class"=>"form-control","placeholder"=>"Fecha tentativa final","id"=>"fecha_tenta_fin" ]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_actualizacion_fin",$errors) !!}</p>
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
        Mes creación:
    </label>
    <div class="col-sm-6">
        {!! Form::select("mes_creacion",array('' => 'Seleccionar  ', '01' => 'ENERO','02' => 'FEBRERO','03'=>'MARZO','04'=>'ABRIL','05'=>'MAYO','06'=>'JUNIO','07'=>'JULIO','08'=>'AGOSTO','09'=>'SEPTIEMBRE','10'=>'OCTUBRE','11'=>'NOVIEMBRE','12'=>'DICIMBRE'),null,["class"=>"form-control","id"=>"mes_creacion"]); !!}
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
     Año creación 
    </label>
    <div class="col-sm-6">
        {!! Form::select("Año_req",$Año_req,null,["class"=>"form-control ","id"=>"Año_req" ]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_mes_tenta",$errors) !!}</p>
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
        Mes tentativo:
    </label>
    <div class="col-sm-6">
        {!! Form::select("mes_tentativo",array('' => 'Seleccionar  ', '01' => 'ENERO','02' => 'FEBRERO','03'=>'MARZO','04'=>'ABRIL','05'=>'MAYO','06'=>'JUNIO','07'=>'JULIO','08'=>'AGOSTO','09'=>'SEPTIEMBRE','10'=>'OCTUBRE','11'=>'NOVIEMBRE','12'=>'DICIMBRE'),null,["class"=>"form-control","id"=>"mes_tentativo"]); !!}
    </div>
</div>

<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
     Año tentativo
    </label>
    <div class="col-sm-6">
        {!! Form::select("Año_tenta_req",$Año_tenta_req,null,["class"=>"form-control ","placeholder"=>"Fecha tentativa final","id"=>"Año_tenta_req" ]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_mes_tenta",$errors) !!}</p>
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
        Cliente:
    </label>
    <div class="col-sm-6">
        {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control","id"=>"cliente_id"]); !!}
    </div>
</div>


<div class="col-md-6 form-group">
  <label class="col-sm-2 control-label" for="inputEmail3">
  Usuario Gestión: </label>
  <div class="col-sm-10">
   {!! Form::select("usuario_gestion",$usuarios,null,["class"=>"form-control","id"=>"usuario_gestion"]); !!}
  </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div class="col-md-6 form-group">
    <h4>Vacantes canceladas satisfactorias :
     <span>{{$numero_req_estado_tempo}}</span>
    </h4>
</div>
<div class="col-md-6 form-group">
    <h4>
          Vacantes canceladas insatisfactorias :
          <span>
            
                {{$numero_req_estado_cliente}}
            </span>
        </h4>
</div>
<div class="col-md-6 form-group">
    <h4>
          Vacantes Solicitadas :
          <span>
            
                {{$numero_vacantes->numero_vac}}
            </span>
        </h4>
</div>
<div class="col-md-6 form-group">
     <h4>
          Vacantes Contratadas :
          <span>
            
                {{$candidatos_contratados}}
            </span>
        </h4>
</div>




<input id="formato" name="formato" type="hidden" value="html"/>
<button class="btn btn-success" type="submit">
    Generar
</button>
<a class="btn btn-success" href="#" id="export_excel_btn" role="button">
    <i aria-hidden="true" class="fa fa-file-excel-o">
    </i>
    Excel
</a>

{!! Form::close() !!}
<br><br>
         
@if(isset($data))
   @include('admin.reportes.includes.grilla_detalle_tempo')
@endif
   
<script>
   $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });

    $(function () {
      $("#fecha_carga_fin").datepicker(confDatepicker);
      $("#fecha_carga_ini").datepicker(confDatepicker);
      $("#fecha_tenta_fin").datepicker(confDatepicker);
      $("#fecha_tenta_ini").datepicker(confDatepicker);
      

      $('#export_excel_btn').click(function(e){
          $data_form =       $('#filter_form').serialize();
          $fecha_carga_ini = $('#fecha_carga_ini').val();
          $fecha_carga_fin = $('#fecha_carga_fin').val();
          $fecha_tenta_ini = $('#fecha_tenta_fin').val();
          $fecha_tenta_fin = $('#fecha_tenta_fin').val();
          $mes_creacion =    $('#mes_creacion').val();
          $mes_tentativo =   $('#mes_tentativo').val();
          $Año_req =         $('#Año_req').val();
          $Año_tenta_req =   $('#Año_tenta_req').val();
          $cliente_id = $("#cliente_id").val();
          


          $(this).prop("href","{{ route('admin.reportes.reportes_detalles_tempo_excel') }}?"+$data_form+"&formato=xlsx&fecha_carga_ini="+$fecha_carga_ini+"&fecha_carga_fin="+$fecha_carga_fin+"&cliente_id="+$cliente_id+"&fecha_tenta_ini="+$fecha_tenta_ini+"&fecha_tenta_fin ="+$fecha_tenta_fin +"&mes_creacion="+$mes_creacion+"&mes_tentativo="+$mes_tentativo+"&Año_req="+$Año_req+"&Año_tenta_req="+$Año_tenta_req);
      });
      $('#export_pdf_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $fecha_inicio = $("#fecha_inicio").val();
          $fecha_final = $("#fecha_final").val();
          $cliente_id = $("#cliente_id").val();
          $criterio = $("#criterio").val();

          $(this).prop("href","{{ route('admin.reportes.reportes_detalles_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
      });
    })
</script>
@stop
