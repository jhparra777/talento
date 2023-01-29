@extends("admin.layout.master")
@section("contenedor")
{!! Form::model($usuario,["route"=>"admin.actualizar_usuario_cliente","id"=>"frm_usuarios","method"=>"POST","autocomplete"=>"off"]) !!}

{!! Form::hidden("id") !!}
<div class="col-md-6">
    <h3>Editar Usuario</h3>

    <div class="clearfix"></div>
        @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get("mensaje_success")}}
            </div>
        </div>
        @endif
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Nombre:</label>
            <div class="col-sm-10">
                {!! Form::text("name",null,["class"=>"form-control","placeholder"=>"Nombre" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Email:</label>
            <div class="col-sm-10">
                {!! Form::text("email",null,["class"=>"form-control","placeholder"=>"Correo" ,"readonly"=>true]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Contraseña</label>
            <div class="col-sm-10">
                {!! Form::password("pass",["class"=>"form-control","placeholder"=>""]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Estado:</label>
            <div class="col-sm-10">
                {!! Form::select("estado",[""=>"Seleccionar","1"=>"Activo","0"=>"Inactivo"],$activado,["class"=>"form-control" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("password",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <div class="form-group">
                <label for="ciudad_id" class="col-md-5 control-label">Ciudad de trabajo:<span class='text-danger sm-text-label'>*</span></label>
                <div class="col-md-7">
                    {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                    {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                    {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                    {!! Form::text("ciudad_autocomplete",(($ubicacion!= null)?$ubicacion->ciudad:null),["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita cuidad"]) !!}

                </div>
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_id",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <div class="form-group">
                <label for="ciudad_id" class="col-md-5 control-label">Unidad de Trabajo:<span class='text-danger sm-text-label'>*</span></label>
                <div class="col-md-7">
                    {!! Form::select("unidad_trabajo",$unidad_trabajo,null,["class"=>"form-control","id"=>"unidad_trabajo"]) !!}
                </div>
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_id",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-6 control-label">Recibir notificaciones al crear una requisición:</label>
            <div class="col-sm-6">
                {!! Form::checkbox("notificacion_requisicion","1",(($usuario->notificacion_requisicion == 1)?true:false),["class"=>"form-control checkbox-preferencias" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("password",$errors) !!}</p>
        </div>

       <!--  <div class="clearfix"></div> -->

        <!-- <h3>Permisos</h3>
        <div class="checkbox">
            <label>
                {!! Form::checkbox("seleccionar_todos",null,false,["id"=>"seleccionar_todos"]) !!} Seleccionar todos
            </label>
        </div>

                <ol class="lista-permisos">
                    @foreach($permisos as $permiso)
                    <li>
                        {!! Form::checkbox("permiso[]",$permiso->slug,$usuario->hasAccess($permiso->slug),["class"=>"padre","data-id"=>$permiso->id]) !!} {{$permiso->descripcion}}
                        <?php
                        $menu_nivel2 = $permiso->menu_hijo1();
                        ?>
                        @if($menu_nivel2->count() > 0)
                        <ol>
                            @foreach($permiso->menu_hijo1() as $nivel_2)
                            <li>
                                {!! Form::checkbox("permiso[]",$nivel_2->slug,$usuario->hasAccess($nivel_2->slug),["class"=>"padre".$nivel_2->padre_id]) !!} {{$nivel_2->descripcion}}

                            </li>
                            @endforeach
                        </ol>
                        @endif
                    </li>
                    @endforeach
                </ol> -->


    <a href="{{route("admin.usuarios_clientes")}}" class="btn btn-warning">Volver</a>
    <button class="btn btn-success">Actualizar</button>
</div>
    <h3>Clientes</h3>
    <div class="table-responsive">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" name="seleccionar_todos2" id="seleccionar_todos2">
                    </th>
                    <th>Seleccionar todos</th>
                    <!--<th>Ciudad</th>-->
                    <!--<th>Teléfono</th>-->
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                <tr>
                    <td>
                        {!! Form::checkbox("clientes[]",$cliente->id,((in_array($cliente->id,$clientes_user))?true:false))  !!}
                    </td>
                    <td>{{$cliente->nombre}}</td>
                </tr>

                @endforeach
             

            </tbody>
        </table>
<!-- {!! $clientes->appends(Request::all())->render() !!} -->
    </div>

{!! Form::close() !!}
<script>
    $(function () {

        $('#autocomplete_cliente').autocomplete({
                serviceUrl: '{{ route("autocomplete_cliente") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#cliente_id").val(suggestion.id);
                }
            });

        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });
        $("#seleccionar_todos").on("change", function () {
            var obj = $(this);
            $("input[name='permiso[]']").prop("checked", obj.prop("checked"));
        });
        $(".padre").on("change", function () {
            var obj = $(this);

            $(".padre" + obj.data("id") + "").prop("checked", obj.prop("checked"));
        });
        $("#seleccionar_todos2").on("change", function () {
            var obj = $(this);
            $("input[name='clientes[]']").prop("checked", obj.prop("checked"));
        });
    });
</script>

@stop
