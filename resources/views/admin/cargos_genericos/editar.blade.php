@extends("admin.layout.master")
@section("contenedor")
<div class="col-md-8 col-md-offset-2">
    {!! Form::model($registro,["id"=>"fr_cargos_genericos","route"=>"admin.cargos_genericos.actualizar","method"=>"POST"]) !!}
    {!! Form::hidden("id") !!}

    <h3>Editar Cargos Genericos</h3>
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

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">descripcion:</label>
            <div class="col-sm-10">
                {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">estado:</label>
            <div class="col-sm-10">
                {!! Form::select("estado",[""=>"Seleccionar","1"=>"Activo","0"=>"Inactivo"],null,["class"=>"form-control" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado",$errors) !!}</p>    
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Categoria:</label>
            <div class="col-sm-10">
                {!! Form::select("tipo_cargo_id",$tiposCargos,null,["class"=>"form-control","placeholder"=>"tipo_cargo_id" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_cargo_id",$errors) !!}</p>    
        </div>

    </div>
    <div class="clearfix" ></div>

    {!! FuncionesGlobales::valida_boton_req("admin.cargos_genericos.actualizar","Actualizar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>
@stop