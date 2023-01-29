@extends("admin.layout.master")
@section("contenedor")
    <style>
        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .autocomplete-suggestions{
            background-color: white;
            border: solid 1px;
            border-top: none;
            border-radius: 1px;
        }

        .autocomplete-suggestion{
            border-bottom: solid 1px #f1f1f1;
            cursor: pointer;
            padding: 0.3rem;
        }
    </style>

    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
           <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get("mensaje_success") }}
           </div>
        </div>
    @endif

    @if(Session::has("mensaje_danger"))
        <div class="col-md-12" id="mensaje-resultado">
           <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get("mensaje_danger") }}
           </div>
        </div>
    @endif

    {!! Form::open(["id" => "frm_datos_cliente", "route" => "admin.guardar_cliente", "method" => "POST", "files" => true, "autocomplete" => "off"]) !!}
        <div class="col-md-12 mb-3">
            <h3>Crear Cliente</h3>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12  form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Nombre:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-sm-9">
                        {!! Form::text("nombre", null, ["class" => "form-control", "placeholder" => "Nombre"]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre", $errors) !!}</p>
                </div>

                <div class="col-md-12  form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">
                        @if(route('home') == "https://gpc.t3rsc.co") RUC @else Nit @endif:<span class='text-danger sm-text-label'>*</span>
                    </label>

                    <div class="col-sm-9">
                        {!! Form::number("nit", null, ["class" => "form-control solo-numero", "placeholder" => "", "pattern" => "[0-9]{5,16}"]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nit", $errors) !!}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12  form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Dirección:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-sm-9">
                        {!! Form::text("direccion", null, ["class" => "form-control","placeholder" => "Dirección" ]) !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("direccion", $errors) !!}</p>
                </div>

                <div class="col-md-12  form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Teléfono:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-sm-9">
                        {!! Form::text("telefono", null, ["class" => "form-control", "placeholder" => "Teléfono" ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono", $errors) !!}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12  form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Página Web</label>
                    <div class="col-sm-9">
                        {!! Form::text("pag_web", null, ["class" => "form-control", "placeholder" => "Pagina Web" ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("pag_web", $errors) !!}</p>
                </div>

                <div class="col-md-12  form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Fax</label>
                    <div class="col-sm-9">
                        {!! Form::text("fax", null, ["class" => "form-control", "placeholder" => "Teléfono" ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fax", $errors) !!}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12  form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Contacto:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-sm-9">
                        {!! Form::text("contacto", null, ["class" => "input-letras form-control", "placeholder" => "Escribe el nombre del contacto" ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("contacto", $errors) !!}</p>
                </div>

                <div class="col-md-12  form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Correo <span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-sm-9">
                        {!! Form::text("correo", null, ["class" => "form-control", "placeholder" => "" ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("correo", $errors) !!}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12  form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Cargo</label>
                    <div class="col-sm-9">
                        {!! Form::text("cargo", null, ["class" => "form-control", "placeholder" => "" ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo", $errors) !!}</p>
                </div>

                <div class="col-md-12  form-group">
                    <label for="inputEmaciudad_idil3" class="col-sm-3 control-label">Ciudad de trabajo</label>

                    <div class="col-sm-9">
                        {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                        {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                        {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                        
                        {!! Form::text("txt_ubicacion", null, [
                            "class" => "form-control",
                            "id" => "ciudad_autocomplete",
                            "placeholder" => "Selecciona la ciudad"
                        ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_id", $errors) !!}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12  form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Logo cliente</label>
                    <div class="col-sm-9">
                        {!! Form::file("archivo_logo_cliente", ["class" => "form-control"]); !!}         
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo", $errors) !!}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h4>
                <label>
                    {!! Form::radio("seleccion_user", 1, false, ["class" => "check_user"]) !!} Usuarios Sistema
                </label> 
                <small>Asociar usuario existente al nuevo cliente </small>
            </h4>

            <div id="seleccionar_user" style="display:none;">
                <div class="col-md-12 form-group">
                    <label for="usuario_autocomplete" class="control-label">
                        Seleccionar usuario <span class='text-danger sm-text-label'>*</span> :
                    </label>
                    
                    {!! Form::hidden("user_exits", null, ["class"=>"form-control", "id"=>"user_id"]) !!}
                    {!! Form::text("txt_ubicacion", null, [
                        "class" => "form-control",
                        "id" => "usuario_autocomplete",
                        "placeholder" => "Selecciona el usuario"
                    ]); !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_exits", $errors) !!}</p>
                </div>
            </div>
            
            <h4 hidden>
                <label>{!! Form::radio("seleccion_user", 2, false, ["class" => "check_user"]) !!} Crear Nuevo Usuario </label> 
                <small> crear nuevo usuario para el cliente</small>
            </h4>

            <div class="clearfix"></div>

            <div id="crear_usuario" style="display:none;">
                <div class="col-md-12 form-group">
                    <label for="" class="col-sm-3 control-label">Nombre:</label>
                    <div class="col-sm-9">
                        {!! Form::text("name", null, ["class" => "form-control", "placeholder" => "Nombre" ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("name", $errors) !!}</p>
                </div>

                <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Email <span class='text-danger sm-text-label'>*</span> :</label>
                    <div class="col-sm-9">
                        {!! Form::text("email", null, ["class" => "form-control", "placeholder" => "Correo", "autocomplete" => "off"]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email", $errors) !!}</p>
                </div>

                <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Contraseña:</label>
                    <div class="col-sm-9">
                        {!! Form::password("password", ["class" => "form-control", "placeholder" => "", "autocomplete" => "off"]);!!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("password", $errors) !!}</p>
                </div>

                <div class="col-md-12 form-group">
                    <div class="form-group">
                        <label for="ciudad_id" class="col-md-5 control-label">
                            Ciudad de trabajo <span class='text-danger sm-text-label'>*</span>:
                        </label>

                        <div class="col-md-7">
                            {!! Form::hidden("pais_id_u",null,["class"=>"form-control","id"=>"pais_id_u"]) !!}
                            {!! Form::hidden("ciudad_id_u",null,["class"=>"form-control","id"=>"ciudad_id_u"]) !!}
                            {!! Form::hidden("departamento_id_u",null,["class"=>"form-control","id"=>"departamento_id_u"]) !!}
                            
                            {!! Form::text("ciudad_autocomplete_u", null, [
                                "class" => "form-control",
                                "id" => "ciudad_autocomplete_u",
                                "placheholder" => "Digita cuidad",
                                "value" => ""
                            ]) !!}
                        </div>
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("pais_id_u", $errors) !!}</p>
                </div>

                <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-6 control-label">Recibir notificaciones al crear una requisición:</label>

                    <div class="col-sm-6">
                        {!!Form::checkbox("notificacion_requisicion", "1", null, ["class" => "form-control checkbox-preferencias" ]);!!}
                    </div>

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("notificacion_requisicion", $errors) !!}
                    </p>
                </div>

                <div class="clearfix"></div>

                <h3>Permisos</h3>

                <div class="checkbox">
                    <label>
                        {!! Form::checkbox("seleccionar_todos", null, false, ["id" => "seleccionar_todos"]) !!} Seleccionar todos
                    </label>
                </div>

                <ol>
                    @foreach($permisos as $permiso)
                        <li>
                            {!! Form::checkbox("permiso[]", $permiso->slug, false, ["class" => "padre", "data-id" => $permiso->id]) !!} {{$permiso->descripcion}}

                            <?php $menu_nivel2 = $permiso->menu_hijo1(); ?>
                            @if($menu_nivel2->count() > 0)
                                <ol>
                                    @foreach($permiso->menu_hijo1() as $nivel_2)
                                        <li>
                                            {!! Form::checkbox("permiso[]", $nivel_2->slug, false, [
                                                "class" => "padre".$nivel_2->padre_id
                                            ]) !!} {{$nivel_2->descripcion}}
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-5 control-label">Asignar usuarios a clientes de roles:</label>
                <div class="col-sm-7">
                    {!! Form::select("roles[]",$roles,null,["class"=>"form-control selectpicker", "id"=>"roles", "data-live-search" => "true", "multiple" => "true"]) !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("roles",$errors) !!}</p>    
            </div>
        </div>

        <div class="clearfix" ></div>

        <div class="col-md-12 text-right">
            {!! FuncionesGlobales::valida_boton_req("admin.guardar_cliente", "Guardar", "submit", "btn btn-success") !!}
        </div>
    {!! Form::close() !!}

    <script>
        $(function () {
            $("#seleccionar_todos").on("change", function () {
                var obj = $(this);
                $("input[name='permiso[]']").prop("checked", obj.prop("checked"))
            });

            $(".padre").on("change", function () {
                var obj = $(this);

                $(".padre" + obj.data("id") + "").prop("checked", obj.prop("checked"))
            });

            $('#ciudad_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_id").val(suggestion.cod_pais)
                    $("#departamento_id").val(suggestion.cod_departamento)
                    $("#ciudad_id").val(suggestion.cod_ciudad)
                }
            })

            //Autocomplete Ciudad
            $('#usuario_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_usuarios") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#user_id").val(suggestion.id)
                }
            })

            $('#ciudad_autocomplete_u').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_id_u").val(suggestion.cod_pais)
                    $("#departamento_id_u").val(suggestion.cod_departamento)
                    $("#ciudad_id_u").val(suggestion.cod_ciudad)
                }
            })

            $(".check_user").on("click", function () {
                var obj = $(this);
                
                if(obj.is(":checked")) {
                    if(obj.val() == '1') {
                        $("#seleccionar_user").show()
                        $("#crear_usuario").hide()
                    }else {
                        $("#crear_usuario").show()
                        $("#seleccionar_user").hide()
                    }
                }
            })
        });
    </script>
@stop