@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicador Cumplimiento ANS</h3>
<hr/>

{!!Form::model(Request::all(),["route"=>'admin.reporte.indicador_cumplimiento',"method"=>"GET","accept-charset"=>"UTF-8"])!!}
   
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

    <button type="submit" class="btn btn-success">Generar</button>

    <div class="clearfix"></div>
        
    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
{!! Form::close() !!}
    @if($mostrar)
       
          <div class="col-md-6">
           <h5>CUMPLIMIENTO ANS</h5>
           <div id="stock-div"></div>

            {!! \Lava::render('PieChart',$indicador_cumplimiento,'stock-div') !!}
          </div>

         <div class="col-md-6">
           <h5>CALIDAD EN LA PRESENTACION</h5>
           <div id="calidad_pres"></div>

            {!! \Lava::render('PieChart',$indicador_calidad,'calidad_pres') !!}
          </div>
    @endif
<script>

    $(function () {
      $("#fecha_inicio, #fecha_final,#fecha_inicio_tentativa,#fecha_final_tentativa").datepicker(confDatepicker);
      
    });
        
//cargos segun cliente
     $('#cliente_id').on("change", function (e){
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