@extends("admin.layout.master")
@section("contenedor")

{!! Form::model($cliente,["id"=>"frm_datos_empesa","route"=>"admin.actualizar_datos_cliente","method"=>"POST","files"=>true]) !!}
{!! Form::hidden("id") !!}
<h3>Editar información</h3>
<div class="clearfix"></div>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Nombre:</label>
        <div class="col-sm-10">
         {!! Form::text("nombre",null,["class"=>"form-control","placeholder"=>"Nombre" ]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Nit</label>
        <div class="col-sm-10">
         {!! Form::text("nit",null,["class"=>"form-control","placeholder"=>"Nit" ]); !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Dirección</label>
        <div class="col-sm-10">
            {!! Form::text("direccion",null,["class"=>"form-control","placeholder"=>"Dirección" ]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Teléfono</label>
        <div class="col-sm-10">
            {!! Form::text("telefono",null,["class"=>"form-control","placeholder"=>"Teléfono" ]); !!}
        </div>
    </div>
</div>
<div class="row" >
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Pagina Web</label>
        <div class="col-sm-10">
            {!! Form::text("pag_web",null,["class"=>"form-control","placeholder"=>"Pagina Web" ]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fax</label>
        <div class="col-sm-10">
            {!! Form::text("fax",null,["class"=>"form-control","placeholder"=>"Teléfono" ]); !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Contacto</label>
        <div class="col-sm-10">
            {!! Form::text("contacto",null,["class"=>"form-control","placeholder"=>"" ]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Correo</label>
        <div class="col-sm-10">
            {!! Form::text("correo",null,["class"=>"form-control","placeholder"=>"" ]); !!}
        </div>
    </div>
</div>
<div class="row">
     <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Cargo</label>
        <div class="col-sm-10">
            {!! Form::text("cargo",null,["class"=>"form-control","placeholder"=>"" ]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Ubicación</label>
        <div class="col-sm-10">
            {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
            {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
            {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
            {!! Form::text("txt_ubicacion",$txtUbicacion,["class"=>"form-control","id"=>"ciudad_autocomplete","placeholder"=>"Selecciona la ciudad" ]); !!}
        </div>
    </div>
</div>

    <div class="row">

     <div class="col-md-12  form-group">
       <label for="inputEmail3" class="col-sm-3 control-label">Logo cliente</label>
        <div class="col-sm-9">
         {!! Form::file("archivo_logo_cliente",["class"=>"form-control"]); !!}         
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo",$errors) !!}</p>
     </div>
    </div>

<div class="clearfix" ></div>
{!! FuncionesGlobales::valida_boton_req("admin.actualizar_datos_cliente","Guardar","submit","btn btn-success") !!}


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
    });
</script>
@stop