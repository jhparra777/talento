@extends("admin.layout.master")
@section('contenedor')
  <h3>
   <i aria-hidden="true" class="fa fa-file-text-o"></i>
    Reportr exámenes médicos
  </h3>
  
  <hr/>

  {!! Form::model(Request::all(),["route"=>"admin.reportes_examenes_medicos","method"=>"GET","accept-charset"=>"UTF-8","id"=>"reportes"]) !!}
  
    <div class="col-md-6 form-group">
      <label class="col-sm-2 control-label" for="inputEmail3">
        Fecha Inicio:
      </label>
      
      <div class="col-sm-10">
        {!! Form::text("fecha_inicio",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio" ]); !!}
      </div>
    </div>

    <div class="col-md-6 form-group">
      <label class="col-sm-2 control-label" for="inputEmPail3">
        Fecha Final:
      </label>
      <div class="col-sm-10">
        {!! Form::text("fecha_final",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_final" ]); !!}
      </div>
    </div>

     <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">#Req:</label>
      <div class="col-sm-10">
        {!! Form::text("req_id",null,["class"=>"form-control","id"=>"req_id"]); !!}
      </div>
    </div>

    <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">#Orden:</label>
      <div class="col-sm-10">
        {!! Form::text("orden_id",null,["class"=>"form-control","id"=>"orden_id"]); !!}
      </div>
    </div>
   

  
  

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

  @if(!empty($data))
    @include('admin.reportes.includes.grilla_examenes_medicos')
  @endif

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

        $('#export_excel_btn').click(function(e){
                //  e.preventDefault();
            $data_form = $('#reportes').serialize();
            $fecha_inicio = $("#fecha_inicio").val();
            $fecha_final = $("#fecha_final").val();
            $req_id = $("#req_id").val();
            $orden_id = $("#orden_id").val();
            
            
            $(this).prop("href","{{route('admin.reportes.reportes_examenes_medicos_excel')}}?"+$data_form+"&formato=xlsx&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&req_id="+$req_id+"&orden_id="+$orden_id);
             // $("#reportes").submit();
               //$data_form.submit();
        });
        
        $('#export_pdf_btn').click(function(e){
            $data_form = $('#reportes').serialize();
            $fecha_inicio = $("#fecha_inicio").val();
            $fecha_final = $("#fecha_final").val();
            $req_id = $("#req_id").val();
            $orden_id = $("#orden_id").val();

            $(this).prop("href","{{ route('admin.reportes.reportes_examenes_medicos_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&req_id="+$req_id+"&orden_id="+$orden_id);
        });
      })
  </script>
@stop
