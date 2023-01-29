
<!-- Inicio contenido principal -->
<div class="col-right-item-container">
    <div class="container-fluid">
        <div id="container_referencia">
            {!! Form::open(["class"=>"form-horizontal form-datos-basicos" ,"role"=>"form","id"=>"fr_referencias_personales"]) !!}
            <div class="row">
                <h3 class="header-section-form">Referencias Personales <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span></h3>
                <div class="col-md-12">
                    <p class="text-primary set-general-font-bold">
                        Por favor relacione todas sus referencias personales.
                        Para incluir otra referencia; llene los campos y haga clic en el botón "Guardar".
                    </p>
                    <p class="direction-botones-left">
                        <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Referencias</a>
                    </p>
                </div>

                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="ref_nombres" class="col-md-4 control-label">Nombres:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">

                            {!! Form::text("nombres",null,["class"=>"form-control","placeholder"=>"Nombres"]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="ref_apellido1" class="col-md-4 control-label">Primer Apellido:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::text("primer_apellido",null,["class"=>"form-control" , "placeholder"=>"Primer Apellido" ]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="ref_apellido2" class="col-md-4 control-label">Segundo Apellido:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::text("segundo_apellido",null,["class"=>"form-control" ,"placeholder"=>"Segundo Apellido"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="tipo_relacion" class="col-md-4 control-label">Tipo relación:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-6">
                            {!! Form::select("tipo_relacion_id",$tipoRelaciones,null,["class"=>"form-control" ,"id"=>"tipo_relacion"]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="telefono_movil" class="col-md-4 control-label">Teléfono Móvil:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">

                            {!! Form::text("telefono_movil",null,["class"=>"form-control" , "placeholder"=>"Teléfono Móvil" ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="telefono_fijo" class="col-md-4 control-label">Teléfono Fijo:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::text("telefono_fijo",null,["class"=>"form-control", "placeholder"=>"Teléfono Fijo" ]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="ref_ciudad" class="col-md-4 control-label">Ciudad:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::hidden("codigo_pais",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                            {!! Form::hidden("codigo_ciudad",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                            {!! Form::hidden("codigo_departamento",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                            {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita cuidad"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="ocupacion" class="col-md-4 control-label">Ocupación:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::select("ocupacion",[""=>"Seleccionar","empleado"=>"Empleado","desempleado"=>"Desempleado"],null,["class"=>"form-control" ]) !!}

                        </div>
                    </div>
                </div>
            </div><!-- fin row -->

            <div class="col-md-12 separador"></div>
            <p class="direction-botones-center set-margin-top">
                <button class="btn btn-primario btn-gra" type="button" id="guardar_referencia" ><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
            </p>
            {!!  Form::close() !!}<!-- /.fin form -->
        </div>
        <div class="row">
            <div class="col-md-12">

                {!! Form::open(["id"=>"grilla-datos"]) !!}
                <p class="direction-botones-left">
                    <button type="button" class="btn btn-primario btn-peq" id="editar_referencia"><i class="fa fa-pen"></i>&nbsp;Editar</button>
                    <button type="button" class="btn btn-danger-t3 btn-peq" id="eliminar_referencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>
                </p>
                <div class="grid-container table-responsive">
                    <table class="table table-striped" id="table_referencias">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Teléfono Móvil</th>
                                <th>Teléfono Fijo</th>
                                <th>Tipo Relación</th>
                                <th>Ciudad</th>
                            </tr>
                        </thead>
                        <tbody>
                              @if($referencias->count() == 0)
                              <tr id="registro_nulo">
                                <td colspan="7">No  hay registros</td>
                            </tr>
                            @endif
                            @foreach($referencias as $referencia)
                            <tr id="tr_{{$referencia->id}}">
                                <td scope="row"><input type="radio" name="id" value="{{$referencia->id}}" /></td>
                                <td>{{$referencia->nombres}}</td>
                                <td>{{ $referencia->primer_apellido." ".$referencia->segundo_apellido }}</td>
                                <td>{{$referencia->telefono_movil}}</td>
                                <td>{{$referencia->telefono_fijo}}</td>
                                <td>{{$referencia->relacion}}</td>
                                <td>{{$referencia->ciudad_seleccionada}}</td>
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
        $(document).on("click", "input[name=id]", function () {
            $("#table_referencias tbody tr").removeClass("oferta_aplicada");
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
        $(document).on("click", "#guardar_referencia", function () {
            $(this).prop("disabled", true);
            $.ajax({
                type: "POST",
                data: $("#fr_referencias_personales").serialize(),
                url: "{{ route('guardar_referencia') }}",
                success: function (response) {
                    if (response.success) {
                        var data = response.referencia;
                        var relacion = response.relacionTipo;
                        var ciudad = response.ciudad;
                        var fila = $("<tr id='tr_" + data.id + "' ></tr>");
                        fila.append($("<td></td>").append($("<input />", {name: "id", value: data.id, type: "radio"})));
                        fila.append($("<td></td>", {text: data.nombres}));
                        fila.append($("<td></td>", {text: data.primer_apellido + " " + data.segundo_apellido}));
                        fila.append($("<td></td>", {text: data.telefono_movil}));
                        fila.append($("<td></td>", {text: data.telefono_fijo}));
                        fila.append($("<td></td>", {text: relacion.descripcion}));
                        fila.append($("<td></td>", {text: ciudad.ciudad_seleccionada}));
                        $("#table_referencias tbody").append(fila);
                        $("#registro_nulo").remove();
                        mensaje_success(response.mensaje_success);
                    }

                    $("#container_referencia").html(response.view);
                }
            });
        });
        $("#eliminar_referencia").on("click", function () {
            if (seleccionarLista("") && confirm("Desea eliminar este registro?") ) {
                $.ajax({
                    type: "POST",
                    data: $("#grilla-datos").serialize(),
                    url: "{{ route('eliminar_referencia') }}",
                    success: function (response) {
                        $("#tr_" + response.id).remove();
                        alert("Se ha eliminado la referencia sin errores.");
                    }
                });
            }
        });
        $(document).on("click", "#editar_referencia", function () {
            $("#eliminar_referencia").prop("disabled", true);
            if (seleccionarLista("")) {
                $.ajax({
                    type: "POST",
                    data: $("#grilla-datos").serialize(),
                    url: "{{ route('editar_referencia') }}",
                    success: function (response) {
                        $("#container_referencia").html(response.view);
                        $(document).scrollTop(0);
                    }
                });
            }

        });
        $(document).on("click", "#cancelar_referencia", function () {
            $("#eliminar_referencia").prop("disabled", false);
            $.ajax({
                type: "POST",
                data: $("#grilla-datos").serialize(),
                url: "{{ route('cancelar_referencia') }}",
                success: function (response) {
                    $("#container_referencia").html(response.view);
                }
            });
        });
        $(document).on("click", "#actualizar_referencia", function () {
            $("#eliminar_referencia").prop("disabled", false);
            $.ajax({
                type: "POST",
                data: $("#fr_referencias_personales").serialize(),
                url: "{{ route('actualizar_referencia')}}",
                success: function (response) {
                    if (response.success) {
                        var data = response.referencia;
                        var relacion = response.relacionTipo;
                        var ciudad = response.ciudad;
                        var fila = $("#tr_" + data.id + " td");
                        fila.eq(0).html(($("<input />", {name: "id", value: data.id, type: "radio"})));
                        fila.eq(1).html(data.nombres);
                        fila.eq(2).html(data.primer_apellido + " " + data.segundo_apellido);
                        fila.eq(3).html(data.telefono_movil);
                        fila.eq(4).html(data.telefono_fijo);
                        fila.eq(5).html(relacion.descripcion);
                        fila.eq(6).html(ciudad.ciudad_seleccionada);
                        $(document).scrollTop(0);
                        mensaje_success(response.mensaje_success);
                    }
                    $("#container_referencia").html(response.view);
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
