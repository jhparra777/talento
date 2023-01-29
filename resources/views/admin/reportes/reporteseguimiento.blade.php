@extends("admin.layout.master")
@section('contenedor')
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Reporte Seguimiento 1 a 1"])

    {!! Form::model(Request::all(),["class"=>"not","route"=>"admin.seguimiento_1","method"=>"GET","accept-charset"=>"UTF-8","id"=>"form_1"]) !!}
  
        <div class="col-md-6 form-group">
            <label class="control-label" for="rango_fecha">
                Rango fecha:
            </label>
            {!! Form::text("rango_fecha",null,["class"=>"form-control range","id"=>"rango_fecha" ]); !!}
        </div>
        <!--
        <div class="col-md-6 form-group">
            <label class="control-label" for="rango_fecha">
                Salario:
            </label>
            {!! Form::number("salario",null,["class"=>"form-control","id"=>"salario" ]); !!}
        </div>
        -->
        <!-- MOSTRAR AREA SOLO PARA KOMATSU-->
        @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co")
            <div class="col-md-6 form-group">
                <label class="control-label" for="area_id">
                    Area trabajo
                </label>
                {!! Form::select("area_id", $areas, null,["class"=>"form-control","id"=>"area_id"]) !!}
            </div>
            <div class="col-md-6 form-group">
                <label for="num_req" class="control-label">Num Req:</label>
                {!! Form::text("num_req",null,["class"=>"form-control", "id"=>"num_req"]); !!}
            </div>
        @else
            @if(route("home") != "https://gpc.t3rsc.co")
                <div class="col-md-6 form-group">
                    <label class="control-label" for="criterio">
                        Criterio:
                    </label>
                    {!! Form::select("criterio",$criterios,null,["class"=>"form-control","id"=>"criterio" ]); !!}
                </div>
            @endif
            <div class="col-md-6 form-group">
                <label class="control-label" for="cliente_id">
                    Cliente:
                </label>
                {!! Form::select("cliente_id[]",$clientes,null,["class"=>"form-control","id"=>"cliente_id","multiple"=>"multiple"]); !!}
                <span style="font-size: .8em;">Selecciona múltiple usando la tecla Ctrl</span>
            </div>
        @endif

        <div class="col-md-6 form-group">
            <label class="control-label" for="usuario_gestion">
                Usuario Gestión:
            </label>
            {!! Form::select("usuario_gestion[]",$usuarios,null,["class"=>"form-control","id"=>"usuario_gestion","multiple"=>"multiple"]); !!}
            <span style="font-size: .8em;">Selecciona múltiple usando la tecla Ctrl</span>
        </div>
        @if($sitio->agencias)
            <div class="col-md-6 form-group">
                <label class="control-label" for="agencia">
                    Agencia:
                </label>
                {!! Form::select("agencia[]",$agencias,null,["class"=>"form-control","id"=>"agencia","multiple"=>"multiple"]); !!}
                <span style="font-size: .8em;">Selecciona múltiple usando la tecla Ctrl</span>
            </div>
        @endif
        @if($sitio->multiple_empresa_contrato)
            <div class="col-md-6 form-group">
                <label class="control-label" for="empresa_contrata">
                    Empresa Contrata:
                </label>
                {!! Form::select("empresa_contrata[]",$empresas,null,["class"=>"form-control","id"=>"empresa_contrata","multiple"=>"multiple"]); !!}
                <span style="font-size: .8em;">Selecciona múltiple usando la tecla Ctrl</span>
            </div>
        @endif

        <div class="clearfix"></div>

        <input id="formato" name="formato" type="hidden" value="html"/>

        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-default | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-green">
                Generar <i aria-hidden="true" class="fa fa-search"></i>
            </button>

            <a class="btn btn-success | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-green" href="#" id="export_excel_btn" role="button">
                Excel <i aria-hidden="true" class="fa fa-file-excel-o"></i>
            </a>

            <a class="btn btn-default | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-red" href="{{ route('admin.seguimiento_1') }}">
                Limpiar
            </a>
        </div>
    {!! Form::close() !!}

    @if(!empty($data))
        @include('admin.reportes.includes.grilla_seguimiento')
    @endif

<script>
    $(function () {

        $('#export_excel_btn').click(function(e){
           
          $("#form_1").prop('action',"{{ route('admin.reportes.reportes_seguimiento_excel') }}");
          //$("#form_1").attr('target',"_blank" );
          
          $("#formato").val('xlsx');
          
            $data_form = $('#filter_form').serialize();
            $rango_fecha = $("#rango_fecha").val();
            $salario = $("#salario").val();
            $cliente_id = $("#cliente_id").val();
            $criterio = $("#criterio").val();
            $agencia = $("#agencia").val();
            $usuario_gestion=$("#usuario_gestion").val();
            $empresa_contrata = $("#empresa_contrata").val();
            
            $("#form_1").submit();
          
          // setTimeout(function(){ location.reload();}, 5000);
          //  $(this).prop("href","{{ route('admin.reportes.reportes_seguimiento_excel') }}?"+$data_form+"&formato=xlsx&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id[]="+$cliente_id+"&criterio="+$criterio+"&agencia[]="+$agencia+"&usuario_gestion[]="+$usuario_gestion);
        });
        
        $('#export_pdf_btn').click(function(e){

            $data_form = $('#filter_form').serialize();
            $rango_fecha = $("#rango_fecha").val();
            $cliente_id = $("#cliente_id").val();
            $criterio = $("#criterio").val();
            $agencia = $("#agencia").val();
            $empresa_contrata = $("#empresa_contrata").val();

            //$(this).prop("href","{{ route('admin.reportes.reportes_seguimiento_excel') }}?"+$data_form+"&formato=pdf&rango_fecha="+$rango_fecha+"&salario="$salario+"&cliente_id="+$cliente_id+"&criterio="+$criterio+"&agencia[]="+$agencia);
        });
      })
  </script>

  <script type="text/javascript">
     //$('#agencia').multiselect();

  </script>
@stop
