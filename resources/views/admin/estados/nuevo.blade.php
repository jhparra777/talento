@extends("admin.layout.master")
@section("contenedor")
<div class="col-md-8 col-md-offset-2">
    {!! Form::open(["id"=>"fr_estados","route"=>"admin.estados.guardar","method"=>"POST"]) !!}


    <h3>Nuevo   Estados</h3>
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
    <label for="inputEmail3" class="col-sm-2 control-label">tipo:</label>
    <div class="col-sm-10">
        {!! Form::text("tipo",null,["class"=>"form-control","placeholder"=>"tipo" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo",$errors) !!}</p>    
</div><div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">cod_estado:</label>
    <div class="col-sm-10">
        {!! Form::text("cod_estado",null,["class"=>"form-control","placeholder"=>"cod_estado" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cod_estado",$errors) !!}</p>    
</div><div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">observaciones:</label>
    <div class="col-sm-10">
        {!! Form::text("observaciones",null,["class"=>"form-control","placeholder"=>"observaciones" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>    
</div>

    </div>
    <div class="clearfix" ></div>
    
    {!! FuncionesGlobales::valida_boton_req("admin.estados.guardar","Guardar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>
@stop