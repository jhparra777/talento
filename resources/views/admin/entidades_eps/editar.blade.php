@extends("admin.layout.master")
@section("contenedor")
<div class="col-md-8 col-md-offset-2">
    {!! Form::model($registro,["id"=>"fr_entidades_eps","route"=>"admin.entidades_eps.actualizar","method"=>"POST"]) !!}
    {!! Form::hidden("id") !!}

    <h3>Editar Entidades Eps</h3>
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
    <label for="inputEmail3" class="col-sm-2 control-label">active:</label>
    <div class="col-sm-10">
        {!! Form::text("active",null,["class"=>"form-control","placeholder"=>"active" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("active",$errors) !!}</p>    
</div>

    </div>
    <div class="clearfix" ></div>

        @if(route("home")=="http://vym.t3rsc.co" || route("home")=="https://vym.t3rsc.co" || route("home")=="http://listos.t3rsc.co" || route("home")=="https://listos.t3rsc.co" || route("home")=="http://localhost:8000")

        <div style="background-color: #ecf0f5;">
           
           <h3>Agencias Validas</h3>

            <div class="checkbox">
             <label>{!! Form::checkbox("seleccionar_todos_agencias",null,false,["id"=>"seleccionar_todos_agencias"]) !!} Seleccionar todas
             </label>
            </div>
            <?php $array = explode(',',$registro->agencias_si); ?>
            
            <ol class="lista-permisos">
             @foreach($agencias as $agencia)
               <li>
               {!! Form::checkbox("agencia[]",$agencia->id,in_array($agencia->id,$array),["class"=>"padre","data-id"=>$agencia->id]) !!} {{$agencia->descripcion}}
               </li>
             @endforeach
            </ol>
        </div>

        @endif
    
    {!! FuncionesGlobales::valida_boton_req("admin.entidades_eps.actualizar","Actualizar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>
@stop