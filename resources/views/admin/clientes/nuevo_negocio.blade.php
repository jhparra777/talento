@extends("admin.layout.master")
@section("contenedor")

{!! Form::open(["id"=>"frm_datos_empesa","route"=>"admin.guardar_negocio","method"=>"POST"]) !!}


<div class="clearfix"></div>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif

<div class="col-md-12">
    <h5 class="titulo1" >Datos Negocio</h5>
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-3  control-label">Clientes:</label>
            <div class="col-sm-9 ">
                {!! Form::select("cliente_id",$cliente,null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cliente_id",$errors) !!}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-3  control-label">Número Negocio:</label>
            <div class="col-sm-9 ">
                {!! Form::text("num_negocio",null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("num_negocio",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-3  control-label">Tipo Contrato:</label>
            <div class="col-sm-9 ">
                {!! Form::select("tipo_contrato_id",$tipo_contrato,null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_contrato_id",$errors) !!}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-3  control-label">Tipo Proceso:</label>
            <div class="col-sm-9 ">
                {!! Form::select("tipo_proceso_id",$tipo_proceso,null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_proceso_id",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-3  control-label">Tipo Jornada:</label>
            <div class="col-sm-9 ">
                {!! Form::select("tipo_jornada_id",$tipo_jornada,null,["class"=>"form-control"]); !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_jornada_id",$errors) !!}</p>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-3  control-label">Tipo Liquidación:</label>
            <div class="col-sm-9 ">
                {!! Form::select("tipo_liquidacion_id",$tipo_liquidacion,null,["class"=>"form-control"]); !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_liquidacion_id",$errors) !!}</p>
        <div class="col-md-12 form-group">
            <label for="tipo_salario" class="col-sm-3  control-label">Tipo Salario:</label>
            <div class="col-sm-9 ">
                {!! Form::select("tipo_salario_id",$tipo_salario,null,["class"=>"form-control"]); !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_salario_id",$errors) !!}</p>
    </div>
        <div class="row">
            <div class="col-md-12  form-group">
                <label for="inputEmaciudad_idil3" class="col-sm-3 control-label">Ubicación</label>
                <div class="col-sm-9">
                    {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                    {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                    {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                    {!! Form::text("txt_ubicacion",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placeholder"=>"Selecciona la ciudad" ]); !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_id",$errors) !!}</p>
            </div>
        </div>
</div>

@if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" && route('home') != "http://demo.t3rsc.co")

<div class="col-md-12">
    <h5 class="titulo1" >Matriz ANS</h5>
    <table class="table table-bordered" id="tbl_ans">
        <thead>
            <tr>
                <th>Regla Vacantes</th>
                <th>Num Cand. a Enviar por vacante</th>
             @if(route("home")=="http://tiempos.t3rsc.co" || route("home")=="https://tiempos.t3rsc.co")
                
                <th>Dias de respuesta de Seleccion.</th>
             
             @else
             
                <th>Num Dias ante del cierre del REQ para presentar cand.</th>
            @endif
            <!--<th>Dias Max. Gestión Req</th>-->
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-md-4 clonar">
                 <div class="col-md-4">
                  <input type="number" min="1" name="regla_de[]" class="form-control input_c">
                 </div>
                 <div class="col-md-1">
                  <h4>A</h4>
                 </div>
                 <div class="col-md-4">
                  <input type="number" min="1" name="regla_a[]" class="form-control input_d">
                 </div>
                 <div class="col-md-6 float-right">
                  <p class="error text-danger direction-botones-center">(Ejemplo: 1A4)</p>
                 </div>
                </td>
                <td class="col-md-4">
                    <input type="text" name="num_cand_presentar_vac[]" class="form-control">
                </td>
                <td class="col-md-4">
                    <input type="text" name="dias_presentar_candidatos_antes[]" class="form-control">
                    <input type="hidden" name="cantidad_dias[]" class="form-control" value="0">
                </td>
                <td class="col-md-4"><button class="btn btn-info agregar_fila" type="button" >Agregar</button></td>
            </tr>
        </tbody>
    </table>
</div>
@endif

<div class="clearfix"></div>
{!! FuncionesGlobales::valida_boton_req("admin.actualizar_negocio","Guardar","submit","btn btn-success") !!}

<a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
{!! Form::close() !!}
<script>
    $(function () {
        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });
        $(document).on("click", ".agregar_fila", function () {
            $(this).removeClass("btn-info agregar_fila").addClass("btn-danger eliminar-fila").html("Eliminar");
            //var cantidad_final = $("select[name='cantidad_inicio[]']").last();
            var tr = $("<tr></tr>");

            //var select = $("<select/>", {name: "cantidad_inicio[]", "class": "form-control"});

            /*for (i = 1; i <= 50; i++) {
                select.append("<option value='" + i + "' >" + i + "</option>");

            }*/
            c = $('.clonar:last').clone();
            c.children('div').children('.input_c').val('');
            c.children('div').children('.input_d').val('');

            c.appendTo(tr);
            //$("<td/>").append(select).appendTo(tr);
            //$("<td/>").append($("<input/>", {class: "form-control", name: "regla[]"})).appendTo(tr);
            $("<td/>").append($("<input/>", {class: "form-control", name: "num_cand_presentar_vac[]"})).appendTo(tr);
            $("<td/>").append($("<input/>", {class: "form-control", name: "dias_presentar_candidatos_antes[]"}))
            .append($("<input/>", {type:"hidden",class: "form-control", name: "cantidad_dias[]", value:0})).appendTo(tr);
            
            $("<td/>").append($("<button/>", {class: "btn btn-info agregar_fila ", text: "Agregar", type: "button"})).appendTo(tr);

            $("#tbl_ans tbody").append(tr);
            console.log(cantidad_final.val());
            console.log(tr);

        });
        $(document).on("click", ".eliminar-fila", function () {
            var data_id = $(this).data("id");
            var objtr = $(this).parents("tr");
            if (typeof data_id != "undefined") {
                $.ajax({
                    type: "POST",
                    data: {"ans_id": data_id},
                    url: "{{ route('admin.eliminar_ans') }}",
                    success: function (success) {

                    }
                });
            }

            $(this).parents("tr").remove();
        });
    });
</script>
@stop