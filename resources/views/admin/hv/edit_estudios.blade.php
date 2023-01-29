
<!-- Inicio contenido principal -->
<div class="col-right-item-container">
    <div class="container-fluid">
        <div id="container_estudios">
            {!! Form::open(["id"=>"fr_estudios","class"=>"form-horizontal form-datos-basicos", "role"=>"form"]) !!}
            <div class="row">
                <h3 class="header-section-form">Estudios <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span></h3>
                <div class="col-md-12">
                    <p class="text-primary set-general-font-bold">
                        Por favor relacione todos los estudios realizados, empezando por el más reciente.
                        Para incluir otro estudio; llene los campos y haga clic en el botón "Guardar".
                    </p>
                    <p class="direction-botones-left">
                        <a href="#grilla_datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Estudios</a>
                    </p>
                </div>

                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="tipo_id" class="col-md-4 control-label">Nivel Estudios:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-6">
                            {!! Form::select("nivel_estudio_id",$nivelEstudios,null,["class"=>"form-control"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="nombre_empresa_temporal" class="col-md-4 control-label">Institución:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">

                            {!! Form::text("institucion",null,["class"=>"form-control","placeholder"=>"Institución" ]) !!}
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="termino_estudios" class="col-md-4 control-label">Terminó Estudios:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::checkbox("termino_estudios",1,null,["class"=>"checkbox-preferencias"]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="titulo_obtenido" class="col-md-4 control-label">Titulo Obtenido: </label>
                        <div class="col-md-6">
                            {!! Form::text("titulo_obtenido",null,["class"=>"form-control", "id"=>"titulo_obtenido" ,"placeholder"=>"Titulo Obtenido" ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="fecha_finalizacion" class="col-md-4 control-label">Fecha Finalización: </label>
                        <div class="col-md-6">
                            {!! Form::text("fecha_finalizacion",null,["class"=>"form-control","placeholder"=>"Fecha Finalización","id"=>"fecha_finalizacion" ]) !!}


                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="trabajo-empresa-temporal" class="col-md-4 control-label">¿Estudia actualmente?</label>
                        <div class="col-md-6">
                            {!! Form::checkbox("estudio_actual",1,null,["class"=>"checkbox-preferencias"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="semestres_cursados" class="col-md-4 control-label">Semestres Cursados:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-6">
                            {!! Form::select("semestres_cursados",[""=>"Seleccionar",1,2,3,4,5,6,7,9,10],null,["class"=>"form-control"]) !!}

                        </div>
                    </div>
                </div>

            </div><!-- fin row -->

            <div class="col-md-12 separador"></div>
            <p class="direction-botones-center set-margin-top">
                <button class="btn btn-primario btn-gra" type="button" id="guardar_estudio"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
            </p>
            {!! Form::close() !!}
        </div>
        <div class="row">
            <div class="col-md-12">

                {!! Form::open(["id"=>"grilla_datos"]) !!}

                <div class="grid-container table-responsive">
                    <table class="table table-striped table-bordered" id="tbl_estudios">
                        <thead>
                            <tr>

                                <th>Titulo Obtenido</th>
                                <th>Institución</th>
                                <th>Nivel Estudio</th>
                                <th>Estudio Actual</th>
                                <th>Fecha Finalización</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($estudios->count() == 0)
                            <tr id="registro_nulo">
                                <td colspan="6">No  hay registros</td>
                            </tr>
                            @endif
                            @foreach($estudios as $estudio)
                            <tr id="tr_{{$estudio->id}}" >

                                <td>{{ $estudio->titulo_obtenido }}</td>
                                <td>{{$estudio->institucion}}</td>
                                <td>{{$estudio->descripcion_nivel}}</td>
                                <td>{{ (($estudio->estudio_actual==1)?"SI":"NO") }}</td>
                                <td>{{$estudio->fecha_finalizacion}}</td>
                                <td>
                                    <div class="direction-botones-left">
                                        <button type="button" class="btn btn-primario btn-peq" id="editar_estudio"><i class="fa fa-pen"></i>&nbsp;Editar</button>
                                        <button type="button" class="btn btn-danger-t3 btn-peq" id="eliminar_estudio"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>
                                    </div>
                                </td>
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
            $("#tbl_estudios tbody tr").removeClass("oferta_aplicada");
            if ($(this).prop("checked")) {
                $(this).parents("tr").addClass("oferta_aplicada");
            }
        });
        $("#fecha_finalizacion").datepicker(confDatepicker);
        $(document).on("click", "#guardar_estudio", function () {
            $(this).prop("disabled", true);
            $.ajax({
                type: "POST",
                data: $("#fr_estudios").serialize(),
                url: "{{ route('admin.guardar_estudios') }}",
                success: function (response) {
                    if (response.success) {
                        var campos = response.rs;
                        var tr = $("<tr id='tr_" + campos.id + "'></tr>");

                        tr.append($("<td></td>").append($("<input />", {name: "id", value: campos.id, type: "radio"})));
                        tr.append($("<td></td>", {text: campos.titulo_obtenido}));
                        tr.append($("<td></td>", {text: campos.institucion}));
                        tr.append($("<td></td>", {text: response.estudio}));
                        tr.append($("<td></td>", {text: ((campos.estudio_actual == 1) ? "SI" : "NO")}));
                        tr.append($("<td></td>", {text: campos.fecha_finalizacion}));
                        $("#tbl_estudios tbody").append(tr);
                        $("#registro_nulo").remove();
                        mensaje_success(response.mensaje_success);
                    }
                    $("#container_estudios").html(response.view);
                    $("#guardar_estudio").removeAttr("disabled");
                    $(document).scrollTop(0);
                }
            });
        });
        $("#eliminar_estudio").on("click", function () {
        
            if (seleccionarLista("id") && confirm("Desea eliminar este registro?")) {
                $.ajax({
                    type: "POST",
                    data: $("#grilla_datos").serialize(),
                    url: " {{ route('eliminar_estudio') }} ",
                    success: function (response) {

                        $("#tr_" + response.id).remove();
                        alert("Registro eliminado");
                    }
                });
            }
        });
        $(document).on("click", "#cancelar_estudio", function () {
            $("#eliminar_estudio").prop("disabled", false);
            if (seleccionarLista("id")) {
                $.ajax({
                    type: "POST",
                    data: $("#grilla_datos").serialize(),
                    url: " {{ route('cancelar_estudio') }} ",
                    success: function (response) {

                        $("#container_estudios").html(response);
                    }
                });
            }
        });

        $(document).on("click", "#editar_estudio", function () {
            $("#eliminar_estudio").prop("disabled", true);
            if (seleccionarLista("id")) {
                $.ajax({
                    type: "POST",
                    data: $("#grilla_datos").serialize(),
                    url: "{{ route('editar_estudio') }}",
                    success: function (response) {

                        $("#container_estudios").html(response);
                        $(document).scrollTop(0);
                    }
                });
            }
        });

        $(document).on("click", "#actualizar_estudio", function () {
            $("#eliminar_estudio").prop("disabled", false);
            $.ajax({
                type: "POST",
                data: $("#fr_estudios").serialize(),
                url: "{{ route('actualizar_estudios') }}",
                success: function (response) {
                    if (response.success) {
                        var campos = response.estudios;
                        $("#tr_" + campos.id + "").removeClass("oferta_aplicada");
                        var tr = $("#tr_" + campos.id + "").find("td");

                        tr.eq(0).html($("<input />", {name: "id", value: campos.id, type: "radio"}));
                        tr.eq(1).html(campos.titulo_obtenido);
                        tr.eq(2).html(campos.institucion);
                        tr.eq(3).html(response.nivelEstudios.descripcion);
                        tr.eq(4).html(((campos.estudio_actual == 1) ? "SI" : "NO"));
                        tr.eq(5).html(campos.fecha_finalizacion);

                        mensaje_success(response.mensaje_success);
                    }
                    $("#container_estudios").html(response.view);
                    $(document).scrollTop(0);
                }
            })
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
