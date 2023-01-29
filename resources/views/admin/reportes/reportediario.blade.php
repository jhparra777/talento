@extends("admin.layout.master")
@section('contenedor')
  <h3>
      <i aria-hidden="true" class="fa fa-file-text-o"></i>
      Reportes Diario
  </h3>
  
  <hr/>

  {!! Form::model(Request::all(),["route"=>"admin.reportes_diario","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
  
    <div class="col-md-6 form-group">
      <label class="col-sm-2 control-label" for="inputEmail3">
          Fecha Inicio:
      </label>
      
      <div class="col-sm-10">
        {!! Form::text("fecha_inicio",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio" ]); !!}
      </div>
    </div>

    <div class="col-md-6 form-group">
      <label class="col-sm-2 control-label" for="inputEmail3">
        Fecha Final:
      </label>
      <div class="col-sm-10">
        {!! Form::text("fecha_final",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_final" ]); !!}
      </div>
    </div>
    
    <!-- MOSTRAR AREA SOLO PARA KOMATSU-->
    @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co")
        <div class="col-md-6 form-group">
                <label class="col-sm-2 control-label" for="inputEmail3">
                    Area trabajo
                </label>
                <div class="col-sm-10">
                    {!! Form::select("area_id", $areas, null,["class"=>"form-control","id"=>"area_id"]) !!}
                </div>
        </div>
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">@if(route('home')=="https://gpc.t3rsc.co") Nombre del Proceso @else Num Req @endif:</label>
            <div class="col-sm-10">
                {!! Form::text("num_req",null,["class"=>"form-control" ]); !!}
            </div>
        </div>
    @endif

    @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
    @else
      <div class="col-md-6 form-group">
        <label class="col-sm-2 control-label" for="inputEmail3">
          Cliente:
        </label>
        <div class="col-sm-10">
          {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control","id"=>"cliente_id"]); !!}
        </div>
      </div>

      <div class="col-md-6 form-group">
        <label class="col-sm-2 control-label" for="inputEmail3">
          Criterio:
        </label>
        <div class="col-sm-10">
          {!! Form::select("criterio",$criterios,null,["class"=>"form-control","id"=>"criterio" ]); !!}
        </div>
      </div>
    @endif

    <div class="clearfix"></div>

    <input id="formato" name="formato" type="hidden" value="html"/>

    <button class="btn btn-success" type="submit">Generar</button>

    <a class="btn btn-success" href="#" id="export_excel_btn" role="button">
      <i aria-hidden="true" class="fa fa-file-excel-o"></i>
      Excel
    </a>
    
    <!--
      <a class="btn btn-danger" href="#" id="export_pdf_btn" role="button">
        <i aria-hidden="true" class="fa fa-file-pdf-o"></i>
        PDF
      </a>
    -->
  {!! Form::close() !!}

  @if(isset($data))
    @include('admin.reportes.includes.grilla_detalle')
  @endif

  <script>
      $(function () {

        $("#fecha_inicio, #fecha_final").datepicker(confDatepicker);

        $('#export_excel_btn').click(function(e){
            $data_form = $('#filter_form').serialize();
            $fecha_inicio = $("#fecha_inicio").val();
            $fecha_final = $("#fecha_final").val();
            $cliente_id = $("#cliente_id").val();
            $criterio = $("#criterio").val();
            
            $(this).prop("href","{{ route('admin.reportes.reportes_diario_excel') }}?"+$data_form+"&formato=xlsx&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
        });
        $('#export_pdf_btn').click(function(e){
            $data_form = $('#filter_form').serialize();
            $fecha_inicio = $("#fecha_inicio").val();
            $fecha_final = $("#fecha_final").val();
            $cliente_id = $("#cliente_id").val();
            $criterio = $("#criterio").val();

            $(this).prop("href","{{ route('admin.reportes.reportes_diario_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
        });
      })
  </script>
@stop
