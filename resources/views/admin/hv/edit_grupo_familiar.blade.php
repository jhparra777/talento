<!-- Inicio contenido principal -->
<div class="col-right-item-container">
    <div class="container-fluid">
        <div id="grupo_container">
            {!! Form::open(["class"=>"form-horizontal form-datos-basicos" ,"role"=>"form","id"=>"fr_grupo"]) !!}
            <div class="row">
                <h3 class="header-section-form">Grupo Familiar <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span></h3>
                <div class="col-md-12">
                    <h4 class="text-primary set-general-font-bold ">
                        Por favor relacione todas sus beneficiario / <strong>Personas a cargo.</strong>
                        Para incluir otra persona; llene los campos y haga clic en el botón "Guardar".
                    </h4>
                    <p class="direction-botones-left">
                        <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Familiares</a>
                    </p>
                </div>

                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="tipo_documento" class="col-md-4 control-label">Tipo Documento:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-6">
                            {!! Form::select("tipo_documento",$selectores->tipoDocumento,null,["class"=>"form-control"])!!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="documento_identidad" class="col-md-4 control-label"># Documento:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::text("documento_identidad",null,["class"=>"form-control solo_numeros"]) !!}


                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="lugar_expedicion" class="col-md-4 control-label">Lugar Expedición:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::hidden("codigo_pais_expedicion",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                            {!! Form::hidden("codigo_ciudad_expedicion",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                            {!! Form::hidden("codigo_departamento_expedicion",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                            {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placeholder"=>"Digita cuidad"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="nombres" class="col-md-4 control-label">Nombres:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::text("nombres",null,["class"=>"form-control","placeholder"=>"Nombres" ]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="ref_apellido1" class="col-md-4 control-label">Primer Apellido:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::text("primer_apellido",null,["class"=>"form-control","placeholder"=>"Primer Apellido" ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="ref_apellido2" class="col-md-4 control-label">Segundo Apellido:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::text("segundo_apellido",null,["class"=>"form-control","placeholder"=>"Segundo Apellido" ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="escolaridad" class="col-md-4 control-label">Escolaridad:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-6">
                            {!!  Form::select("escolaridad_id",$selectores->escolaridad,null,["class"=>"form-control"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="parentesco" class="col-md-4 control-label">Parentesco:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-6">
                            {!!  Form::select("parentesco_id",$selectores->parentesco,null,["class"=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="genero" class="col-md-4 control-label">Género:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-6">
                            {!! Form::select("genero",$selectores->genero,null,["class"=>"form-control"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="fecha_nacimiento" class="col-md-4 control-label">Fecha Nacimiento:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">

                            {!! Form::text("fecha_nacimiento",null,["class"=>"form-control" ,"id"=>"fecha_nacimiento", "placeholder"=>"Fecha Nacimiento" ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="ciudad_nacimiento" class="col-md-4 control-label">Ciudad Nacimiento:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-6">
                            {!! Form::hidden("codigo_pais_nacimiento",null,["class"=>"form-control","id"=>"pais_id2"]) !!}
                            {!! Form::hidden("codigo_ciudad_nacimiento",null,["class"=>"form-control","id"=>"ciudad_id2"]) !!}
                            {!! Form::hidden("codigo_departamento_nacimiento",null,["class"=>"form-control","id"=>"departamento_id2"]) !!}
                            {!! Form::text("ciudad_autocomplete2",null,["class"=>"form-control","id"=>"ciudad_autocomplete2","placeholder"=>"Digita cuidad"]) !!}

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12">
                    <div class="form-group">
                        <label for="profesion" class="col-md-4 control-label">Profesión:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-6">
                            {!! Form::select("profesion_id",$selectores->profesion,null,["class"=>"form-control"]) !!}

                        </div>
                    </div>
                </div>
            </div><!-- fin row -->

            <div class="col-md-12 separador"></div>
            <p class="direction-botones-center set-margin-top">

                <button class="btn btn-primario btn-gra" type="button" id="guardar_grupo"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>

            </p>
            {!! Form::close() !!}<!-- /.fin form -->
        </div>
        <div class="row">
            <div class="col-md-12">

                {!! Form::open(["id"=>"grilla-datos"]) !!}
                <p class="direction-botones-left">
                    <button type="button" class="btn btn-primario btn-peq" id="editar_familiar"><i class="fa fa-pen"></i>&nbsp;Editar</button>
                    <button type="button" class="btn btn-danger-t3 btn-peq" id="eliminar_familiar" ><i class="fa fa-trash"></i>&nbsp;Eliminar</button>
                </p>
                <div class="grid-container table-responsive">
                    <table class="table table-striped" id="tbl_familia">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th># Identidad</th>
                                <th>Género</th>
                                <th>Fecha Nacimiento</th>
                                <th>Ciudad Nacimiento</th>
                                <th>Escolaridad</th>
                            </tr>
                        </thead>
                        <tbody>
                              @if($familiares->count() == 0)
                              <tr id="no_registros">
                                <td colspan="8">No  registros</td>
                            </tr>
                            @endif
                            @foreach($familiares as $familiar)
                            <tr id="tr_{{$familiar->id}}">
                                <td scope="row"><input type="radio" value="{{$familiar->id}}" name="id" /></td>
                                <td>{{$familiar->nombres}}</td>
                                <td>{{$familiar->primer_apellido." ".$familiar->segundo_apellido}}</td>
                                <td>{{$familiar->documento_identidad}}</td>
                                <td>{{$familiar->genero}}</td>
                                <td>{{$familiar->fecha_nacimiento}}</td>
                                <td>{{$familiar->getLugarNacimiento()->ciudad}}</td>
                                <td>{{$familiar->escolaridad}}</td>
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
            $("#tbl_familia tbody tr").removeClass("oferta_aplicada");
            if ($(this).prop("checked")) {
                $(this).parents("tr").addClass("oferta_aplicada");
            }
        });
        $("#fecha_nacimiento").datepicker(confDatepicker);
        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });
        $('#ciudad_autocomplete2').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id2").val(suggestion.cod_pais);
                $("#departamento_id2").val(suggestion.cod_departamento);
                $("#ciudad_id2").val(suggestion.cod_ciudad);
            }
        });

        $(document).on("click", "#guardar_grupo", function () {
            $(this).prop("disabled",true);
            $.ajax({
                type: "POST",
                data: $("#fr_grupo").serialize(),
                url: "{{ route('guardar_familia') }}",
                success: function (response) {
                    if (response.success) {
                        var campos = response.registro;
                        var ciudad = response.lugarNacimiento;
                        $("#no_registros").remove();
                        var tr = $("<tr id='tr_" + campos.id + "'></tr>");
                        tr.append($("<td></td>").append($("<input />", {type: "radio", name: "id", value: campos.id})));
                        tr.append($("<td></td>", {text: campos.nombres}));
                        tr.append($("<td></td>", {text: campos.primer_apellido + " " + campos.segundo_apellido}));
                        tr.append($("<td></td>", {text: campos.documento_identidad}));
                        tr.append($("<td></td>", {text: campos.genero}));
                        tr.append($("<td></td>", {text: campos.fecha_nacimiento}));
                        tr.append($("<td></td>", {text: ciudad.ciudad}));
                        tr.append($("<td></td>", {text: campos.escolaridad}));
                        $("#tbl_familia").append(tr);
                        mensaje_success(response.mensaje_success);
                        $(document).scrollTop(0);
                    }
                    $("#grupo_container").html(response.view);
                   $("#guardar_grupo").removeAttr("disabled");
                }
            });
        });
        $("#editar_familiar").on("click", function () {
        $("#eliminar_familiar").prop("disabled",true);
            if (seleccionarLista() ) {


                $.ajax({
                    type: "POST",
                    data: $("#grilla-datos").serialize(),
                    url: "{{ route('editar_familiar') }}",
                    success: function (response) {
                        $("#grupo_container").html(response.view);
                    }
                });
            }
        });
        $(document).on("click", "#actualizar_familiar", function () {
            $("#eliminar_familiar").prop("disabled",false);
            $.ajax({
                type: "POST",
                data: $("#fr_grupo").serialize(),
                url: "{{ route('actualizar_familiar') }}",
                success: function (response) {
                    $("#grupo_container").html(response.view);
                    if (response.success) {
                        var campos = response.registro;
                        var ciudad = response.lugarNacimiento;
                        var tr = $("#tr_" + campos.id + " td");
                        tr.eq(0).html($("<input />", {type: "radio", name: "id", value: campos.id}));
                        tr.eq(1).html(campos.nombres);
                        tr.eq(2).html(campos.primer_apellido + " " + campos.segundo_apellido);
                        tr.eq(3).html(campos.documento_identidad);
                        tr.eq(4).html(campos.genero);
                        tr.eq(5).html(campos.fecha_nacimiento);
                        tr.eq(6).html(ciudad);
                        tr.eq(7).html(campos.escolaridad);
                        mensaje_success(response.mensaje_success);
                        $(document).scrollTop(0);
                    }
                }

            });
        });
        $(document).on("click", "#eliminar_familiar", function () {
            if (seleccionarLista() && confirm("Desea eliminar este registro?")) {
                $.ajax({
                    type: "POST",
                    data: $("#grilla-datos").serialize(),
                    url: "{{ route('eliminar_familiar') }}",
                    success: function (response) {
                        $("#tr_" + response.id).remove();
                        alert("El registro familiar se ha eliminado.");
                    }
                });
            }
        });
        $(document).on("click","#cancelar_familiar", function () {
            $("#eliminar_familiar").prop("disabled",false);
            $.ajax({
                type: "POST",
                data: $("#grilla-datos").serialize(),
                url: "{{ route('cancelar_familiar') }}",
                success: function (response) {
                    $("#grupo_container").html(response.view);
                }
            });

        });
    });
</script>

