@extends("req.layout.master")
@section("contenedor")

<style>
    .pagination{ margin: 0 !important; }

    .mb-1{ margin-bottom: 1rem; }
    .mb-2{ margin-bottom: 2rem; }
    .mb-3{ margin-bottom: 3rem; }
    .mb-4{ margin-bottom: 4rem; }
</style>

        {{-- Header --}}
        @include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Editar información"])

<div class="row">
    @if(Session::has("mensaje_success"))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alerta!</h4>
            {{Session::get("mensaje_success")}}
        </div>
    @endif

    {!! Form::model($cliente,["id"=>"frm_datos_empesa","route"=>"req.actualizar_datos","method"=>"POST"]) !!}
    {!! Form::hidden("id") !!}

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label">Nombre:</label>
            {!! Form::text("nombre",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Nombre" ,"readonly"=>"true"]); !!}
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label">Nit</label>
            {!! Form::text("nit",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Nit" ,"readonly"=>"true"]); !!}  
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label">Dirección</label>
            {!! Form::text("direccion",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Dirección" ]); !!}   
    </div>
    
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label">Teléfono</label>
            {!! Form::text("telefono",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Teléfono" ]); !!}
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label">Pagina Web</label>
        {!! Form::text("pag_web",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Pagina Web" ]); !!}
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label">Fax</label>
        {!! Form::text("fax",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Teléfono" ]); !!}
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label">Contacto</label>
            {!! Form::text("contacto",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"" ]); !!}
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label">Correo</label>
        {!! Form::text("correo",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"" ]); !!}
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Cargo</label>
        {!! Form::text("cargo",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"" ]); !!}
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label">Ubicación</label>
        {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
        {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
        {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
        {!! Form::text("txt_ubicacion",$txtUbicacion,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"ciudad_autocomplete","placeholder"=>"Selecciona la ciudad" ]); !!} 
    </div>

    <div class="col-md-12 text-right mb-2">
        {!! FuncionesGlobales::valida_boton_req("req.actualizar_datos","Guardar","submit","btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-green") !!}
        <a href="#" class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-300" onclick="window.history.back()">Volver Listado</a>
    </div>

    {!! Form::close() !!}   
</div>







{{-- {!! Form::model($cliente,["id"=>"frm_datos_empesa","route"=>"req.actualizar_datos","method"=>"POST"]) !!}
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
            {!! Form::text("nombre",null,["class"=>"form-control","placeholder"=>"Nombre" ,"readonly"=>"true"]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Nit</label>
        <div class="col-sm-10">
            {!! Form::text("nit",null,["class"=>"form-control","placeholder"=>"Nit" ,"readonly"=>"true"]); !!}
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
<div class="clearfix" ></div>
{!! FuncionesGlobales::valida_boton_req("req.actualizar_datos","Guardar","submit","btn btn-success") !!}

<a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
{!! Form::close() !!} --}}
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