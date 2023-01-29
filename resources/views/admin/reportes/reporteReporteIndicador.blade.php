@extends("admin.layout.master")
@section('contenedor')
  <h3>
   <i aria-hidden="true" class="fa fa-file-text-o"></i>
    Reportes Indicador
  </h3>
  
  <hr/>

  {!! Form::model(Request::all(),["route"=>"admin.reportes_reporte_indicador","method"=>"GET","accept-charset"=>"UTF-8","id"=>"reportes"]) !!}
  
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
          <label for="inputEmail3" class="col-sm-2 control-label">Num Req:</label>
          <div class="col-sm-10">
           {!!Form::text("num_req",null,["class"=>"form-control" ]);!!}
          </div>
        </div>
    
    @endif

  @if(route("home")=="http://tiempos.t3rsc.co" || route("home")=="https://tiempos.t3rsc.co"|| route("home")=="http://vym.t3rsc.co"|| route("home")=="https://vym.t3rsc.co")
    <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">#Negocio:</label>
      <div class="col-sm-10">
        {!! Form::text("negocio_id",null,["class"=>"form-control"]); !!}
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

    @if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co" || route("home") == "http://demo.t3rsc.co")

      <div class="col-md-6 form-group">
        <label class="col-sm-2 control-label" for="inputEmail3">
          Cargo especifico:
        </label>
        <div class="col-sm-10">
          {!! Form::select("cargo_id",[],null,["class"=>"form-control","id"=>"cargos_esp"]); !!}
        </div>
      </div>

      <div class="col-md-6 form-group">
        <label class="col-sm-2 control-label" for="inputEmail3">
          Ciudad:
        </label>
        <div class="col-sm-10">
          {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
          {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
          {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
          {!! Form::text("sitio_trabajo",null,["placeholder"=>"Seleccionar una opción de la lista desplegable ","class"=>"form-control","id"=>"ciudad_autocomplete"]); !!}
        </div>
      </div>

    @endif
    
      <div class="col-md-6 form-group">
        <label class="col-sm-2 control-label" for="inputEmail3">
          Usuario Gestión:
        </label>
        <div class="col-sm-10">
          {!! Form::select("usuario_gestion",$usuarios,null,["class"=>"form-control","id"=>"usuario_gestion"]); !!}
        </div>
      </div>
      <div class="col-md-6 form-group">
        <label class="col-sm-2 control-label" for="inputEmail3">
          Agencia:
        </label>
        <div class="col-sm-10">
          {!! Form::select("agencia",$agencias,null,["class"=>"form-control","id"=>"agencia"]); !!}
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
    @include('admin.reportes.includes.grilla_reporte_indicador')
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
            $cliente_id = $("#cliente_id").val();
            $criterio = $("#criterio").val();
            $usuario_gestion = $("#usuario_gestion").val();
            
            $(this).prop("href","{{route('admin.reportes_reporte_indicador_excel')}}?"+$data_form+"&formato=xlsx&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio+"&usuario_gestion="+$usuario_gestion);
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
