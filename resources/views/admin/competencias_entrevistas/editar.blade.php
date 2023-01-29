@extends("admin.layout.master")
@section("contenedor")
<div class="col-md-8 col-md-offset-2">
    {!! Form::model($registro,["id"=>"fr_competencias_entrevistas","route"=>"admin.competencias_entrevistas.actualizar","method"=>"POST"]) !!}
    {!! Form::hidden("id") !!}

    <h3>Editar Competencias Entrevistas</h3>
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
    <label for="inputEmail3" class="col-sm-2 control-label">nombre:</label>
    <div class="col-sm-10">
        {!! Form::text("nombre",null,["class"=>"form-control","placeholder"=>"nombre" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    
</div>

    </div>
    <div class="clearfix" ></div>
    
    {!! FuncionesGlobales::valida_boton_req("admin.competencias_entrevistas.actualizar","Actualizar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>
@stop