@extends("admin.layout.master")
@section("contenedor")
<div class="col-md-8">
    {!! Form::open(["id"=>"fr_entidades_eps","route"=>"admin.entidades_eps.guardar","method"=>"POST"]) !!}

    <h3>Nuevo   Entidades Eps</h3>
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
    <label for="inputEmail3" class="col-sm-4 control-label">descripcion:</label>
    <div class="col-sm-10">
        {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
</div><div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-4 control-label">active:</label>
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
                <label>
                    {!! Form::checkbox("seleccionar_todos_agencias",null,false,["id"=>"seleccionar_todos_agencias"]) !!} Seleccionar todas
                </label>
            </div>

            <ol class="lista-permisos">
             @foreach($agencias as $agencia)
               <li>
                {!! Form::checkbox("agencia[]",$agencia->id,null,["class"=>"padre","data-id"=>$agencia->id]) !!} {{$agencia->descripcion}}
               </li>
             @endforeach
            </ol>
         </div>
        @endif
    
    {!! FuncionesGlobales::valida_boton_req("admin.entidades_eps.guardar","Guardar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>
<script>
    $(function () {

        $("#seleccionar_todos_agencias").on("change", function () {
            var obj = $(this);
            $("input[name='agencia[]']").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos").on("change", function () {
            var obj = $(this);
            $("input[name='permiso[]']").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos_admin").on("change", function () {
            var obj = $(this);
            var stat = obj.prop("checked");
            console.log(stat);
            if(stat){
              $(".check_func").prop("checked", true);
            }else{
              $(".check_func").prop("checked", false);
            }
        });

        $(".padre, .padre0").on("change", function () {
           var obj = $(this);
            console.log(obj.data("id"));
           $(".padre" + obj.data("id") + "").prop("checked", obj.prop("checked"));
        });


    });
</script>
@stop