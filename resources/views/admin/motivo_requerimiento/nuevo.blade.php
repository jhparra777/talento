@extends("admin.layout.master")
@section("contenedor")
<div class="col-md-8 col-md-offset-2">
    {!! Form::open(["id"=>"fr_motivo_requerimiento","route"=>"admin.motivo_requerimiento.guardar","method"=>"POST"]) !!}


    <h3>Nuevo Motivo Requerimiento</h3>
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
            <label for="inputEmail3" class="col-sm-2 control-label">Descripción:</label>       
            {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripción" ]); !!}
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
        </div>

        <div class="col-md-6 form-group" style="padding-top: 30px">
            <label for="active" class="control-label">

                {!! Form::checkbox("active",1,null,["id" => "active"]); !!}
                Activo
            </label>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("active",$errors) !!}</p>    
        </div>

    </div>
    <div class="clearfix" ></div>
    
    {!! FuncionesGlobales::valida_boton_req("admin.motivo_requerimiento.guardar","Guardar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>
@stop