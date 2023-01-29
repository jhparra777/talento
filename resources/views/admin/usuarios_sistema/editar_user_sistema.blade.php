@extends("admin.layout.master")
@section('contenedor')


{!! Form::model($usuario,["route"=>"admin.actualizar_usuario_sistema","id"=>"frm_usuarios","method"=>"POST","autocomplete"=>"off"]) !!}

{!! Form::hidden("id") !!}

<div class="clearfix"></div>
<div class="">
    <br>
    @if(Session::has("mensaje_success"))
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get("mensaje_success")}}
        </div>
    </div>
    @endif
    <div class="col-md-6">
        <h3>Editar Usuario</h3>
        <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Primer Nombre:</label>
                    <div class="col-sm-10">
                        {!! Form::text("primer_nombre",$usuario->getDatosBasicos()->primer_nombre,["class"=>"form-control","placeholder"=>"Primer Nombre" ]); !!}
                    </div>
        
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_nombre",$errors) !!}</p>
                </div>

                 <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Segundo Nombre:</label>
                    <div class="col-sm-10">
                        {!! Form::text("segundo_nombre",$usuario->getDatosBasicos()->segundo_nombre,["class"=>"form-control","placeholder"=>"Segundo Nombre" ]); !!}
                    </div>
        
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_nombre",$errors) !!}</p>
                </div>

                <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Primer Apellido:*</label>
                    <div class="col-sm-10">
                        {!! Form::text("primer_apellido",$usuario->getDatosBasicos()->primer_apellido,["class"=>"form-control","placeholder"=>"Primer Apellido" ]); !!}
                    </div>
        
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
                </div>

                 <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Segundo Apellido:</label>
                    <div class="col-sm-10">
                        {!! Form::text("segundo_apellido",$usuario->getDatosBasicos()->segundo_apellido,["class"=>"form-control","placeholder"=>"Segundo Apellido" ]); !!}
                    </div>
        
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
                </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Nick:</label>
            <div class="col-sm-10">
                {!! Form::text("username",null,["class"=>"form-control","placeholder"=>"Username" ]+(($usuario->username != "")?["readonly"=>true]:[])); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("username",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Numero de documento:</label>
            <div class="col-sm-10">
                {!! Form::text("numero_id",null,["class"=>"form-control","placeholder"=>"Numero Id"]+(($usuario->numero_id != "")?[]:[])); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("username",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Email:</label>
            <div class="col-sm-10">
                {!! Form::text("email",null,["class"=>"form-control","placeholder"=>"Correo"]+(($usuario->email != "")?[]:[])); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Correo Corporativo:</label>
            <div class="col-sm-10">
                {!! Form::text("correo_corporativo",null,["class"=>"form-control","placeholder"=>"Correo" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("correo_corporativo",$errors) !!}</p>
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
            <label for="inputEmail3" class="col-sm-6 control-label">Recibir notificaciones al crear una requisición:</label>
            <div class="col-sm-6">
                {!! Form::checkbox("notificacion_requisicion","1",(($usuario->notificacion_requisicion == 1)?true:false),["class"=>"form-control checkbox-preferencias" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("password",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-6 control-label">Módulo hoja de vida:</label>
            <div class="col-sm-6">
                {!! Form::checkbox("habilitar_hv","hv",(($usuario->inRole("hv"))?true:false),["class"=>"form-control checkbox-preferencias" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("password",$errors) !!}</p>
        </div>
        
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-6 control-label">Módulo Requisiciones:</label>
            <div class="col-sm-6">
                {!! Form::checkbox("habilitar_req","req",(($usuario->inRole("req"))?true:false),["class"=>"form-control checkbox-preferencias" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("password",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-6 control-label">Módulo Administrativo:</label>
            <div class="col-sm-6">
                {!! Form::checkbox("habilitar_admin","admin",(($usuario->inRole("admin"))?true:false),["class"=>"form-control checkbox-preferencias" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("password",$errors) !!}</p>
        </div>

    </div>
    <div class="col-md-6">
        <h3>Roles</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Rol</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($roles->count() == 0)
                <tr>
                    <th colspan="3">No se encontraron roles disponibles</th>
                </tr>
                @endif
                
                @foreach($roles as $rol)
                <tr>
                    <td>
                        {!! Form::checkbox("roles[]",$rol->id,null) !!}
                        <!-- Form::radio("roles",$rol->id,null) -->

                    </td>
                    <td>{{$rol->name}}</td>
                    <td>
                        <button type="button" data-id="{{$rol->id}}" class="ver_permisos btn btn-warning btn-xs">Ver permisos</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="clearfix"></div>
    <div class="col-md-6">
        <h3>Permisos Requisición</h3>
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
        </ol>
        @if($sitio->agencias)
            <div style="background-color: #ecf0f5;">
             <h3>Agencias</h3>

              <div class="checkbox">
                <label>
                    {!! Form::checkbox("seleccionar_todos_agencias",null,false,["id"=>"seleccionar_todos_agencias"]) !!} Seleccionar todas
                </label>
            </div>

            <ol class="lista-permisos">
             @foreach($agencias as $agencia)
               <li>
                {!! Form::checkbox("agencia[]",$agencia->id,in_array($agencia->id,$usuario->agencias2->pluck('id')->toArray()),["class"=>"padre","data-id"=>$agencia->id]) !!} {{$agencia->descripcion}}
               </li>
             @endforeach
            </ol>
         </div>
        @endif
        <a href="{{route("admin.usuarios_clientes")}}" class="btn btn-warning">Volver</a>
        <button class="btn btn-success">Actualizar</button>
    </div>
    
    <div class="col-md-6">
      <h3>Permisos Administración</h3>
        <div class="checkbox">
         <label>
          {!! Form::checkbox("seleccionar_todos_admin",null,false,["id"=>"seleccionar_todos_admin"]) !!} Seleccionar todos</label>
        </div>
      {!! FuncionesGlobales::getPermisosAdmin(0,$usuario->permissions) !!}
    </div>


</div>
{!!Form::close()!!}

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

        $(document).on("click", ".ver_permisos", function () {
            var id = $(this).data("id");
            $.ajax({
                type: "POST",
                data: {rol_id: id},
                url: "{{ route('admin.detalle_rol') }}",
                success: function (response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            })
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


    });
</script>
@stop