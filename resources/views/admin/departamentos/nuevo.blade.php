@extends("admin.layout.master")
@section("contenedor")
<div class="col-md-10 col-md-offset-1">
    {!! Form::open(["id"=>"fr_departamentos","route"=>"admin.departamentos.guardar","method"=>"POST"]) !!}


    <h3>Nuevo   Departamentos</h3>
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
            <label for="inputEmail3" class="col-sm-5 control-label">Nombre:</label>
            <div class="col-sm-7">
                {!! Form::text("nombre",null,["class"=>"form-control","placeholder"=>"Nombre", "required"=>"required" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    
        </div>

        @if( isset($sitio->integracion_contratacion) && $sitio->integracion_contratacion == 1 )
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-5 control-label">Código Homologación:</label>
                <div class="col-sm-7">
                    {!! Form::text("homologa_id",null,["class"=>"form-control","placeholder"=>"Código","required"=>"required"]); !!}
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("homologa_id",$errors) !!}</p>    
            </div>
        @endif
    </div>

    <div class="row">
        
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-5 control-label">País:</label>
            <div class="col-sm-7">
                {!! Form::select("cod_pais",$paises,null,["class"=>"form-control selectpicker", "id"=>"cod_pais","required"=>"required", "data-live-search" => "true" ]) !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cod_pais",$errors) !!}</p>    
        </div>
    </div>

        

    </div>

    <div class="clearfix" ></div>
    
    {!! FuncionesGlobales::valida_boton_req("admin.departamentos.guardar","Guardar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>
@stop