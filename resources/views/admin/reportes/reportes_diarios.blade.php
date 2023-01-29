@extends("admin.layout.master")
@section('contenedor')
  <h3>
   <i aria-hidden="true" class="fa fa-file-text-o"></i>
    Reportes Diarios
  </h3>
  
  <hr/>

  {!! Form::model(Request::all(),["route"=>"admin.reportes_reporte_indicador","method"=>"GET","accept-charset"=>"UTF-8","id"=>"reportes"]) !!}
  <div class="container">
    <div class="row">
 
  </div>
  <div class="row">
    <div class="col-md-6 form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Cliente:</label>
            <div class="col-sm-10">
             {!! Form::select("cliente_id",$clientes ,null, ["class" => "form-control" ]); !!}
            </div>
    </div>

    {{--<div class="col-md-6 form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Agencia:</label>
            <div class="col-sm-10">
             {!! Form::select("agencia_id",[] ,null, ["class" => "form-control" ]); !!}
            </div>
    </div>--}}
    
  </div>
     

  
  </div>
  
  
      
    <div class="clearfix"></div>

    {{--<input id="formato" name="formato" type="hidden" value="html"/>

    <button class="btn btn-success" type="submit">Generar</button>

    <a class="btn btn-success" href="#" id="export_excel_btn" role="button">
      <i aria-hidden="true" class="fa fa-file-excel-o"></i>
      Excel
    </a>--}}
    
    <!--
      <a class="btn btn-danger" href="#" id="export_pdf_btn" role="button">
        <i aria-hidden="true" class="fa fa-file-pdf-o"></i>
        PDF
      </a>
    -->
  {!! Form::close() !!}

  {{--@if(!empty($data))
    @include('admin.reportes.includes.grilla_reporte_indicador')
  @endif--}}
<div class="contariner" style="margin-top: 3em;">
  <div class="row">
  <div class="col-sm-3">
    <a class="btn btn-success export_excel_btn" href="#"  role="button" data-param=1 data-report="seleccion">
      <i aria-hidden="true" class="fa fa-file-excel-o" ></i>
      Diario selección
    </a>
  </div>

  <div class="col-sm-3">
    <a class="btn btn-success export_excel_btn" href="#"  role="button" data-param=2 data-report="contratacion">
      <i aria-hidden="true" class="fa fa-file-excel-o" ></i>
      Diario contratación
    </a>
  </div>
  
</div>
</div>


  <script>
      $(function () {

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


        $("#fecha_inicio, #fecha_final").datepicker(confDatepicker);

        $('.export_excel_btn').click(function(e){

                //  e.preventDefault();
            var param=$(this).data("param");
            var report=$(this).data("report");
            var data_form = $('#reportes').serialize();
            var num_req = $("#num_req").val();
            var cedula = $("#cedula").val();
            var fecha_inicio = $("#fecha_inicio").val();
            var fecha_final = $("#fecha_final").val();
            //$cliente_id = $("#cliente_id").val();
            
            $(this).prop("href","{{route('admin.reportes_diarios_excel')}}?"+data_form+"&formato=xlsx&fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&cedula="+cedula+"&num_req="+num_req+"&param="+param+"&report="+report);
             // $("#reportes").submit();
               //$data_form.submit();
        });
        
        $('#export_pdf_btn').click(function(e){
            $data_form = $('#filter_form').serialize();
            $fecha_inicio = $("#fecha_inicio").val();
            $fecha_final = $("#fecha_final").val();
            $cliente_id = $("#cliente_id").val();
            $criterio = $("#criterio").val();

            $(this).prop("href","{{ route('admin.reportes_reporte_indicador_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
        });
      })
  </script>
@stop
