@extends("admin.layout.master")
@section('contenedor')
    <h3><i aria-hidden="true" class="fa fa-file-text-o"></i> Reportes Ministerio-Oferta </h3>

    <hr/>
    
    {!! Form::model(Request::all(),["route"=>"admin.reportes_oferta","method"=>"GET","accept-charset"=>"UTF-8"]) !!}

        <div class="col-md-6 form-group">
          <label class="col-sm-2 control-label" for="inputEmail3">Fecha Inicio:</label>

            <div class="col-sm-10">
             {!! Form::text("fecha_inicio",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio" ]); !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">Fecha Final:</label>

            <div class="col-sm-10">
                {!! Form::text("fecha_final",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_final" ]); !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
         <label class="col-sm-2 control-label" for="inputEmail3">Cliente:</label>

          <div class="col-sm-10">
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

        <div class="clearfix"></div>

        <input id="formato" name="formato" type="hidden" value="html"/>
        
        <button class="btn btn-success" type="submit">Generar</button>

        <a class="btn btn-success" href="#" id="export_excel_btn" role="button">
            <i aria-hidden="true" class="fa fa-file-excel-o"></i>Excel
        </a>
        
        <!--
            <a class="btn btn-danger" href="#" id="export_pdf_btn" role="button">
                <i aria-hidden="true" class="fa fa-file-pdf-o"></i>PDF
            </a>
        -->
    {!! Form::close() !!}

    @if(isset($data))
        @include('admin.reportes.includes.grilla_detalle_oferta')
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

                $(this).prop("href","{{ route('admin.reportes_detalles_oferta_excel') }}?"+$data_form+"&formato=xlsx&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
            });

            $('#export_pdf_btn').click(function(e){
                $data_form = $('#filter_form').serialize();
                $fecha_inicio = $("#fecha_inicio").val();
                $fecha_final = $("#fecha_final").val();
                $cliente_id = $("#cliente_id").val();
                $criterio = $("#criterio").val();

                $(this).prop("href","{{ route('admin.reportes_detalles_oferta_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
            });
        })
    </script>
@stop
