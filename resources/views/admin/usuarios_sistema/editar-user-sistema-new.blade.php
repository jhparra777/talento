@extends("admin.layout.master")
@section('contenedor')

    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Editar usuario"])

    <style>
        .ancla-permisos-usuario {
            font-weight: bold;
        }

        .ancla-permisos-usuario:hover, .ancla-permisos-usuario:active, .ancla-permisos-usuario:focus {
            outline: none;
            text-decoration: none;
            color: white;
        }
    </style>

    {!! Form::model($usuario,["route" => "admin.actualizar_usuario_sistema", "id" => "frm_usuarios", "method" => "POST", "autocomplete" => "off","data-smk-icon"=>"glyphicon-remove-sign"]) !!}
        <div class="row">
            {!! Form::hidden("id") !!}

            @if(Session::has("mensaje_success"))
                <div class="col-md-12" id="mensaje-resultado">
                    <div class="alert alert-success alert-dismissible | tri-br-1 tri-green tri-border--none" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <i class="fa fa-check-circle" aria-hidden="true"></i> {{ Session::get("mensaje_success") }}
                    </div>
                </div>
            @endif

            {{-- Editar usuario --}}
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body pb-5">
                        <div class="col-md-12 mb-1">
                            <h4>Información básica</h4>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Primer nombre: *</label>
                                {!! Form::text("primer_nombre", $usuario->getDatosBasicos()->primer_nombre, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Primer nombre","required"=>true ]); !!}

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_nombre", $errors) !!}</p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Segundo nombre:</label>
                                {!! Form::text("segundo_nombre", $usuario->getDatosBasicos()->segundo_nombre, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Segundo nombre" ]); !!}

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_nombre", $errors) !!}</p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Primer apellido: *</label>
                                {!! Form::text("primer_apellido", $usuario->getDatosBasicos()->primer_apellido, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Primer apellido","required"=>true ]); !!}

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido", $errors) !!}</p>
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Segundo apellido:</label>
                            {!! Form::text("segundo_apellido", $usuario->getDatosBasicos()->segundo_apellido, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Segundo apellido" ]); !!}

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido", $errors) !!}</p>
                        </div>

                        {{-- <div class="col-md-12 form-group">
                            <label>Nombre:</label>
                            {!! Form::text("name", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Nombre" ]); !!}

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("name", $errors) !!}</p>
                        </div> --}}

                        <div class="col-md-12 form-group">
                            <label>Nick:</label>
                            {!! Form::text("username", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Username" ] + (($usuario->username != "") ? ["readonly" => true] : [])); !!}

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("username", $errors) !!}</p>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Número de documento: *</label>
                                {!! Form::text("numero_id", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Número id","required"=>true] + (($usuario->numero_id != "") ? [] : [])); !!}

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_id", $errors) !!}</p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email: *</label>
                                {!! Form::email("email", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Correo", "required" => "required"] + (($usuario->email != "") ? [] : [])); !!}

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email", $errors) !!}</p>
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label >Correo corporativo:</label>
                            {!! Form::text("correo_corporativo", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Correo" ]); !!}

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("correo_corporativo", $errors) !!}</p>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Contraseña:</label>
                            {!! Form::password("pass", ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => ""]); !!}

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("pass", $errors) !!}</p>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Estado:</label>
                            {!! Form::select("estado", ["" => "Seleccionar", "1" => "Activo", "0" => "Inactivo"], $activado, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado", $errors) !!}</p>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ciudad_id">Ciudad de trabajo: <span class='text-danger sm-text-label'>*</span></label>
                                {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                                {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                                {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}

                                {!! Form::text("ciudad_autocomplete", (($ubicacion != null) ? $ubicacion->ciudad : null), ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "ciudad_autocomplete", "placheholder" => "Digita ciudad","required"=>true]) !!}

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("pais_id", $errors) !!}</p>
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label >Recibir notificaciones al crear una requisición</label> <br>
                            {!! Form::checkbox("notificacion_requisicion", "1", (($usuario->notificacion_requisicion == 1) ? true : false), ["class" => "form-control checkbox-preferencias"]); !!}
                        </div>

                        <div class="col-md-6 form-group">
                            <label >Módulo hoja de vida</label> <br>
                            {!! Form::checkbox("habilitar_hv", "hv", (($usuario->inRole("hv")) ? true : false), ["class" => "form-control checkbox-preferencias" ]); !!}
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="control-label">Módulo requisiciones</label> <br>
                            {!! Form::checkbox("habilitar_req", "req", (($usuario->inRole("req")) ? true : false), ["class" => "form-control checkbox-preferencias" ]); !!}
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Módulo Administrativo</label> <br>
                            {!! Form::checkbox("habilitar_admin", "admin", (($usuario->inRole("admin")) ? true : false), ["class" => "form-control checkbox-preferencias" ]); !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Roles --}}
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body pb-1">
                        <div class="col-md-12 mb-1">
                            <h4>Roles</h4>                    
                        </div>

                        <div class="col-md-12">
                            <table class="table table-striped table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>-</th>
                                        <th>Rol</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>

                                <tbody>                            
                                    @forelse($roles as $rol)
                                        <tr>
                                            <td>
                                                {!! Form::checkbox("roles[]",$rol->id,null) !!}
                                            </td>
                                            <td>{{ $rol->name }}</td>
                                            <td>
                                                <button 
                                                    type="button" 
                                                    data-id="{{ $rol->id }}" 
                                                    class="ver_permisos btn btn-default | tri-br-2 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-200 tri-hover-out-gray">
                                                    Ver permisos
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <th colspan="3">No se encontraron roles disponibles</th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Permisos requisición --}}
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>Permisos Requisición</h4>

                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox("seleccionar_todos", null, false, ["id" => "seleccionar_todos"]) !!} Seleccionar todos
                            </label>
                        </div>

                        <div class="tri-overflow">
                            <ul class="lista-permisos | tri-list--none">
                                @foreach($permisos as $permiso)
                                    <li>
                                        {!! Form::checkbox("permiso[]", $permiso->slug, $usuario->hasAccess($permiso->slug), [
                                            "class" => "padre", "data-id" => $permiso->id
                                        ]) !!} {{ $permiso->descripcion }}
                                        
                                        <?php
                                            $menu_nivel2 = $permiso->menu_hijo1();
                                        ?>

                                        @if($menu_nivel2->count() > 0)
                                            <ul class="tri-list--none">
                                                @foreach($permiso->menu_hijo1() as $nivel_2)
                                                    <li>
                                                        {!! Form::checkbox("permiso[]", $nivel_2->slug, $usuario->hasAccess($nivel_2->slug), [
                                                            "class" => "padre".$nivel_2->padre_id
                                                        ]) !!} {{$nivel_2->descripcion}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Permisos administración --}}
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>Permisos administración</h4>

                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox("seleccionar_todos_admin", null, false, ["id" => "seleccionar_todos_admin"]) !!} Seleccionar todos
                            </label>
                        </div>

                        <div class="tri-overflow">
                            {!! FuncionesGlobales::getPermisosAdminCollapse(0, $usuario->permissions) !!}

                            <!--
                                <table class="table table-striped table-hover" id="data-table-permisos">
                                    <thead>
                                        <tr>
                                            <th>-</th>
                                            <th>Permiso</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        {!! FuncionesGlobales::getPermisosAdmin(0, $usuario->permissions) !!}
                                    </tbody>
                                </table>
                            -->
                        </div>
                    </div>
                </div>
            </div>

            {{-- Permisos agencias --}}
            @if ($sitio->agencias)
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4>Permisos Agencias</h4>

                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox("seleccionar_todos_agencias",null,false,["id"=>"seleccionar_todos_agencias"]) !!} Seleccionar todas
                                </label>
                            </div>

                            <div class="tri-overflow">
                                <ul class="lista-permisos | tri-list--none">
                                    @foreach($agencias as $agencia)
                                        <li>
                                            {!! Form::checkbox("agencia[]", $agencia->id, $usuario->hasAgencia($usuario->id, $agencia->id), [
                                                "class" => "padre",
                                                "data-id" => $agencia->id
                                            ]) !!} {{ $agencia->descripcion }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Botones acción --}}
            <div class="col-md-12 text-right">
                <a class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" href="{{ route("admin.usuarios_sistema") }}">Volver</a>
                <button id="actualizar" type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-green">Actualizar</button>
            </div>
        </div>
    {!! Form::close() !!}

    <script>
        $(function () {
            const permisosTable = $('#data-table-permisos').DataTable({
                "responsive": true,
                "paginate": true,
                "lengthChange": false,
                "filter": true,
                "sort": false,
                "info": false,
                "autoWidth": true,
                "pageLength" : 10000,
                "language": {
                    "url": '{{ url("js/Spain.json") }}'
                }
            })

            const allPagesPermisos = permisosTable.rows().nodes()

            $(document).on("change", "#seleccionar_todos_admin", function () {
                var obj = $(this);
                var stat = obj.prop("checked");

                if(stat) {
                    //$('input[type="checkbox"]', allPagesPermisos).prop('checked', true);
                    $(".check_func").prop("checked", true);
                }else {
                    //$('input[type="checkbox"]', allPagesPermisos).prop('checked', false);
                    $(".check_func").prop("checked", false);
                }
            })

            $("#seleccionar_todos_agencias").on("change", function () {
                var obj = $(this);
                $("input[name='agencia[]']").prop("checked", obj.prop("checked"));
            });

            $("#seleccionar_todos").on("change", function () {
                var obj = $(this);
                $("input[name='permiso[]']").prop("checked", obj.prop("checked"));
            });

            /*$("#seleccionar_todos_admin").on("change", function () {
                var obj = $(this);
                var stat = obj.prop("checked");
                console.log(stat);
                if(stat){
                $(".check_func").prop("checked", true);
                }else{
                $(".check_func").prop("checked", false);
                }
            });*/

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
                        $("#modalTriSmall").find(".modal-content").html(response);
                        $("#modalTriSmall").modal("show");
                    }
                })
            });
            $("#actualizar").click(function(){
                if($("#frm_usuarios").smkValidate()){
                    $("#frm_usuarios").submit();
                }
            });
            $('#ciudad_autocomplete').focus(function(){
                    $("#pais_id").val("");
                    $("#departamento_id").val("");
                    $("#ciudad_id").val("");
                    $(this).val("");
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