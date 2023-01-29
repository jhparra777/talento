@extends("admin.layout.master")
@section("contenedor")
<div class="col-md-8 col-md-offset-2">
    {!! Form::open(["id"=>"{{nom_tabla}}","route"=>"{{ruta_guardar}}","method"=>"POST"]) !!}


    <h3>Nuevo   {{titulo}}</h3>
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

        {{campos}}

    </div>
    <div class="clearfix" ></div>
    
    {!! FuncionesGlobales::valida_boton_req("{{ruta_guardar}}","Guardar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>
@stop