
<!-- Inicio contenido principal -->
<div class="col-right-item-container">
    <div class="container-fluid">
        <div id="fr_container_experiencia">
            {!! Form::open(["class"=>"form-horizontal form-datos-basicos", "role"=>"form", "id"=>"fr_experiencias"]) !!}

            <div class="row">
                <h3 class="header-section-form">Experiencias <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span></h3>
                <div class="col-md-12">
                    <p class="text-primary set-general-font-bold">
                        Por favor relacione todas sus experiencias laborales, empezando por su trabajo más reciente.
                        Para incluir otra experiencia laboral; llene los campos y haga clic en el botón "Guardar".
                    </p>
                    <p class="direction-botones-left">
                        <a href="#grilla" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Experiencias</a>
                    </p>
                </div>

                <!--<div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="trabajo-empresa-temporal" class="col-md-8 control-label">Trabajó por medio de una temporal:</label>
                        <div class="col-md-4">
                            {!! Form::checkbox("trabajo_temporal",1,null,["class"=>"checkbox-preferencias" ]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="nombre_empresa_temporal" class="col-md-5 control-label">Nombre Temporal: </label>
                        <div class="col-md-7">
                            {!! Form::text("nombre_temporal",null,["class"=>"form-control"]) !!}

                        </div>
                    </div>
                </div>-->
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="numero_id" class="col-md-5 control-label">Nombre Empresa:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-7">
                            {!! Form::text("nombre_empresa",null,["class"=>"form-control","placeholder"=>"Nombre Empresa"]) !!}

                        </div>
                        <p class="error text-danger direction-botones-center"></p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="numero_id" class="col-md-5 control-label">Teléfono empresa: </label>
                        <div class="col-md-7">
                            {!! Form::text("telefono_temporal",null,["class"=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="ciudad" class="col-md-5 control-label">Ciudad:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-7">
                            {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                            {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                            {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                            {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita cuidad"]) !!}
                        </div>
                        <p class="error text-danger direction-botones-center"></p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="tipo_id" class="col-md-5 control-label">Cargo Desempeñado:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-7">
                            {!! Form::select("cargo_desempenado",$cargoGenerico,null,["class"=>"form-control"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="nombres_jefe" class="col-md-5 control-label">Nombres Jefe:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-7">
                            {!! Form::text("nombres_jefe",null,["class"=>"form-control", "id"=>"nombres_jefe","placeholder"=>"Nombres Jefe Inmediato"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="cargo_jefe" class="col-md-5 control-label">Cargo Jefe:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-7">
                            {!! Form::text("cargo_jefe",null,["class"=>"form-control","id"=>"cargo_jefe", "placeholder"=>"Cargo Jefe Inmediato" ]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="telefono_movil_jefe" class="col-md-5 control-label">Teléfono móvil jefe:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-7">
                            {!! Form::text("movil_jefe",null,["class"=>"form-control", "placeholder"=>"Movil Jefe Inmediato","id"=>"telefono_movil_jefe"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="telefono_jefe" class="col-md-5 control-label">Teléfono Fijo Jefe:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-4">
                            {!! Form::text("fijo_jefe",null,["class"=>"form-control", "id"=>"telefono_jefe", "placeholder"=>"Teléfono Jefe Inmediato"]) !!}

                        </div>
                        <div class="col-md-3">
                            {!! Form::text("ext_jefe",null,["class"=>"form-control", "id"=>"ext_jefe", "placeholder"=>"Extension Fijo"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="trabajo-empresa-temporal" class="col-md-5 control-label">Trabajo Actual:</label>
                        <div class="col-md-7">
                            {!! Form::checkbox("empleo_actual",1,null,["class"=>"checkbox-preferencias" ]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="fecha_inicio" class="col-md-5 control-label">Fecha Inicio:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-7">
                            {!! Form::text("fecha_inicio",null,["class"=>"form-control", "id"=>"fecha_inicio" ,"placeholder"=>"Fecha Inicio"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="fecha_terminacion" class="col-md-5 control-label">Fecha Terminación:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-7">
                            {!! Form::text("fecha_final",null,["class"=>"form-control", "id"=>"fecha_terminacion" ,"placeholder"=>"Fecha Terminación"]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="salario_devengado" class="col-md-5 control-label">Salario Devengado:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-7">
                            {!! Form::select("salario_devengado",$aspiracionSalarial,null,["class"=>"form-control" ,"id"=>"salario_devengado"]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="motivo_retiro" class="col-md-5 control-label">Motivo Retiro:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-7">
                            {!! Form::select("motivo_retiro",$motivos,null,["class"=>"form-control","id"=>"motivo_retiro"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="funcionesylogros" class="col-md-3 control-label">Funciones y Logros: <span class='text-danger sm-text-label'></span></label>
                        <div class="col-md-9">
                            {!! Form::textarea("funciones_logros",null,["class"=>"form-control", "rows"=>"3", "name"=>"funcionesylogros", "id"=>"funcionesylogros"]) !!}

                        </div>
                        <p class="error text-danger direction-botones-center"></p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        
                        <div class="col-md-3">
                            {!! Form::hidden("autoriza_solicitar_referencias",1,null,["class"=>"checkbox-preferencias" ,"data-state"=>"false" , "id"=>"autorizo_referencia"]) !!}

                        </div>
                    </div>
                </div>

            </div><!-- fin row -->

            <div class="col-md-12 separador"></div>
            <p class="direction-botones-center set-margin-top">
                <button class="btn btn-primario btn-gra" type="button" id="btn_experiencias" ><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
            </p>
            {!! Form::close() !!}<!-- /.fin form -->
        </div>
        <div class="row">
            <div class="col-md-12">

                {!! Form::open(["id"=>"grilla"]) !!}
                <p class="direction-botones-left">
                    <button type="button" class="btn btn-primario btn-peq" id="editar_experiencia"><i class="fa fa-pen"></i>&nbsp;Editar</button>
                    <button type="button" class="btn btn-danger-t3 btn-peq" id="eliminar_experiencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>
                </p>
                <div class="grid-container table-responsive">
                    <table class="table table-striped" id="tbl_experiencias">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Empresa</th>
                                <th>Teléfono Empresa</th>
                                <th>Nombres Jefe Inmediato</th>
                                <th>Teléfono Fijo</th>
                                <th>Teléfono Móvil</th>
                                <th>Cargo</th>
                                <th>Fecha Ingreso</th>
                                <th>Fecha Salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($experiencias->count() == 0)
                            <tr id="registro_nulo">
                                <td colspan="6">No hay registros</td>
                            </tr>
                            @endif
                            @foreach($experiencias as $experiencia)
                            <tr id="tr_{{$experiencia->id}}">
                                <td>{!! Form::radio("id",$experiencia->id,null,["class"=>"item_experiencia"]) !!}</td>
                                <td>{{$experiencia->nombre_empresa}}</td>
                                <td>{{$experiencia->telefono_temporal}}</td>
                                <td>{{$experiencia->nombres_jefe}}</td>
                                <td>{{$experiencia->fijo_jefe}}</td>
                                <td>{{$experiencia->movil_jefe}}</td>
                                <td>{{$experiencia->cargo_jefe}}</td>
                                <td>{{$experiencia->fecha_inicio}}</td>
                                <td>{{$experiencia->fecha_final}}</td>
                            </tr>
                            @endforeach

                        </tbody>                                
                    </table>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div><!-- /.container -->
</div>
<!-- Fin contenido principal -->
<script>
    $(function () {
        //$("#fecha_inicio, #fecha_terminacion").datepicker(confDatepicker);
        rangoCalendarios("fecha_inicio","fecha_terminacion");
        $(document).on("change", 'form:input,select', function () {
            $("#btn_experiencias_actualizar").removeAttr("disabled");
        });

        $(document).on("click", "input[name=id]", function () {
            $("#tbl_experiencias tbody tr").removeClass("oferta_aplicada");
            if ($(this).prop("checked")) {
                $(this).parents("tr").addClass("oferta_aplicada");
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

        $(document).on("click", "#btn_experiencias", function () {
            $(this).prop("disabled", true);
            $(this).html("<i class='fa fa-floppy-o'></i> Guardando..")
            $.ajax({
                type: "POST",
                data: $("#fr_experiencias").serialize(),
                url: "{{ route('guardar_experiencia') }}",
                success: function (response) {
                    if (response.success) {
                        var campos = response.rs;
                        var tr = $("<tr id='tr_"+campos.id+"'></tr>");
                        tr.append($("<td></td>").append($("<input >", {type: "radio", name: "id", value: campos.id, class: "item_experiencia"})));
                        tr.append($("<td></td>", {text: campos.nombre_empresa}));
                        tr.append($("<td></td>", {text: campos.telefono_temporal}));
                        tr.append($("<td></td>", {text: campos.nombres_jefe}));
                        tr.append($("<td></td>", {text: campos.movil_jefe}));
                        tr.append($("<td></td>", {text: campos.fijo_jefe}));
                        tr.append($("<td></td>", {text: campos.cargo_jefe}));
                        tr.append($("<td></td>", {text: campos.fecha_inicio}));
                        tr.append($("<td></td>", {text: campos.fecha_final}));

                        $("#tbl_experiencias tbody").append(tr);
                        $("#registro_nulo").remove();
                        
                        $("#btn_experiencias").removeAttr("disabled");
                        $(document).scrollTop(0);
                     
                         $("#btn_experiencias").prop("disabled", true);
                         mensaje_success(response.mensaje_success);
                    } else {

                    }
                    $("#fr_container_experiencia").html(response.view);

                }
            })
        });
        $(document).on("click", "#btn_experiencias_actualizar", function () {
            $(this).prop("disabled", true);
            $("#eliminar_experiencia").prop("disabled", false);
            $.ajax({
                type: "POST",
                data: $("#fr_experiencias").serialize(),
                url: "{{ route('actualizar_experiencia') }}",
                success: function (response) {
                    if (response.success) {
                        var campos = response.rs;
                        var tr = $("#tr_" + campos.id).find("td");
                        tr.eq(0).html($("<td></td>").append($("<input >", {name: "id", type: "radio", value: campos.id, class: "item_experiencia"})));
                        tr.eq(1).html($("<td></td>", {text: campos.nombre_empresa}));
                        tr.eq(2).html($("<td></td>", {text: campos.nombres_jefe}));
                        tr.eq(3).html($("<td></td>", {text: campos.movil_jefe}));
                        tr.eq(4).html($("<td></td>", {text: campos.fijo_jefe}));
                        tr.eq(5).html($("<td></td>", {text: campos.cargo_jefe}));

                        $("#tr_" + campos.id).html(tr);
                        $("#btn_experiencias_actualizar").removeAttr("disabled");
                        mensaje_success(response.mensaje_success);
                        $(document).scrollTop(0);

                    } else {

                    }
                    $("#fr_container_experiencia").html(response.view);
                }
            })
        });
        $("#editar_experiencia").on("click", function () {
            $("#eliminar_experiencia").prop("disabled", true);
            if (seleccionarLista("id")) {
                $.ajax({
                    type: "POST",
                    data: $("#grilla").serialize(),
                    url: "{{ route('editar_experiencia') }}",
                    success: function (response) {
                        $("#fr_container_experiencia").html(response);
                        $(document).scrollTop(0);
                    }
                });
            }
        });
        $("#eliminar_experiencia").on("click", function () {
            
            if (seleccionarLista("id") && confirm("Desea eliminar este registro?")) {
                $.ajax({
                    type: "POST",
                    data: $("#grilla").serialize(),
                    url: "{{ route('eliminar_experiencia') }}",
                    success: function (response) {
                        alert("Registro eliminado");
                        $("#tr_" + response.id).remove();
                    }
                });
            }
        });
        $(document).on("click", "#btn_cancelar_experiencia", function () {
            $("#eliminar_experiencia").prop("disabled", false);
            $.ajax({
                type: "POST",
                data: $("#grilla").serialize(),
                url: "{{ route('cancelar_experiencia') }}",
                success: function (response) {
                    $("#fr_container_experiencia").html(response);
                    $(document).scrollTop(0);
                }
            });
        });

        function seleccionarLista(campo) {
            var campos = $("[type=radio]");
            var checkBox = 0;

            $.each(campos, function (key, value) {
                if ($(value).prop("checked")) {
                    checkBox++;
                }
            });
            if (checkBox > 0) {

                return true;
            } else {
                alert("Debe seleccionar un item de la tabla");
                return false;
            }

        }
    });
</script>
