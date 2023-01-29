@extends("admin.layout.master")
@section("contenedor")
<div class="col-md-8 col-md-offset-2">
    {!! Form::open(["id"=>"fr_generos","route"=>"admin.generos.guardar","method"=>"POST"]) !!}


    <h3>Nuevo   Generos</h3>
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
    <label for="inputEmail3" class="col-sm-2 control-label">descripcion:</label>
    <div class="col-sm-10">
        {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
</div><div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">codigo:</label>
    <div class="col-sm-10">
        {!! Form::text("codigo",null,["class"=>"form-control","placeholder"=>"codigo" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("codigo",$errors) !!}</p>    
</div><div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">active:</label>
    <div class="col-sm-10">
        {!! Form::text("active",null,["class"=>"form-control","placeholder"=>"active" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("active",$errors) !!}</p>    
</div>

    </div>
    <div class="clearfix" ></div>
    
    {!! FuncionesGlobales::valida_boton_req("admin.generos.guardar","Guardar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>
@stop