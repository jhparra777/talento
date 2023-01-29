<script>
    $(function () {
        $("#fecha_nacimiento_familiar").datepicker(confDatepicker);

        //Guardar familia
        $("#guardar_familia").on("click", function () {
            if ($('#fr_grupo').smkValidate()) {
                $.ajax({
                    type: "POST",
                    data: $("#fr_grupo").serialize(),
                    url: "{{ route('admin.ajax_guardar_familia') }}",
                    beforeSend: function() {
                        $("#guardar_familia").prop('disabled','disabled')
                    },
                    success: function (response) {
                        $("#guardar_familia").prop('disabled',false)

                        if(response.success) {
                            /*var campos = response.registro;
                            var ciudad = response.lugarNacimiento;
                            var tr = $("<tr id='tr_" + campos.id + "'></tr>");
                            tr.append($("<td></td>", {text: campos.nombres}));
                            tr.append($("<td></td>", {text: campos.primer_apellido + " " + campos.segundo_apellido}));

                            tr.append($("<td></td>", {text: campos.documento_identidad}));

                            tr.append($("<td></td>", {text: campos.genero}));

                            tr.append($("<td></td>", {text: campos.fecha_nacimiento}));
                            tr.append($("<td></td>", {text: ciudad.ciudad}));
                            tr.append($("<td></td>", {text: campos.escolaridad}));

                            tr.append($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_familiar disabled_familia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_familia disabled_familia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));
                            $("#tbl_familia tbody").append(tr);*/

                            mensaje_success("Familiar creado correctamente.")

                            //Limpiar campos del formulario
                            $("#fr_grupo")[0].reset();

                            setTimeout(() => {
                                location.reload(true)
                            }, 1500)
                        }else {
                            mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
                        }
                    }
                })
            }
        })

        //Editar Familia
        $(document).on("click",".editar_familiar", function() {
            //Mostar Botones Cancelar Guardar.
            document.getElementById('cancelar_familiar').style.display = 'initial';
            document.getElementById('actualizar_familiar').style.display = 'initial';

            //Ocultar Boton Guardar
            document.getElementById('guardar_familia').style.display = 'none';

            //Desactivar botones Eliminar + Editar
            $(".disabled_familia").prop("disabled", true);

            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if(id) {
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{ route('admin.ajax_editar_familiar') }}",
                    success: function (response) {
                        $("#tipo_documento_familiar").val(response.data.tipo_documento);
                        $("#documento_identidad_familiar").val(response.data.documento_identidad);
                        $("#nombres_familiar").val(response.data.nombres);
                        $("#primer_apellido_familiar").val(response.data.primer_apellido);
                        $("#segundo_apellido_familiar").val(response.data.segundo_apellido);
                        $("#escolaridad_id_familiar").val(response.data.escolaridad_id);
                        $("#parentesco_id_familiar").val(response.data.parentesco_id);
                        $("#genero_familiar").val(response.data.genero);
                        $("#fecha_nacimiento_familiar").val(response.data.fecha_nacimiento);
                        $(".id_modificar_familiar").val(response.data.id);

                        //Ciudad-Expedicion
                        $("#ciudad_autocomplete_familia_expedicion").val(response.data.ciudad_autocomplete);
                        $("#pais_id_familia_ex").val(response.data.codigo_pais_expedicion);
                        $("#ciudad_id_familia_ex").val(response.data.codigo_ciudad_expedicion);
                        $("#departamento_id_familia_ex").val(response.data.codigo_departamento_expedicion);

                        //Ciudad-Nacimiento
                        $("#ciudad_autocomplete_familia_nacimiento").val(response.data.ciudad_autocomplete2);
                        $("#pais_id_familia_nac").val(response.data.codigo_pais_nacimiento);
                        $("#ciudad_id_familia_nac").val(response.data.codigo_ciudad_nacimiento);
                        $("#departamento_id_familia_nac").val(response.data.codigo_departamento_nacimiento);

                        //Cargo Profesion
                        $("#cargo_profesion_autocomplete").val(response.cargo);
                        $("#profesion_id").val(response.data.profesion_id);
                    }
                })
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente.") 
            }
        })

        //Eliminar Familia
        $(document).on("click",".eliminar_familia", function() {
            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if (id) {
                $.smkConfirm({
                    text:'¿Eliminar familiar?',
                    accept:'Eliminar',
                    cancel:'Cancelar'
                },function(res){
                    if (res) {
                        $(".disabled_familia").prop("disabled", true)

                        $.ajax({
                            type: "POST",
                            data: {"id": id},
                            url: "{{ route('admin.ajax_eliminar_familia') }}",
                            success: function (response) {
                                $("#tr_" + response.id).remove();
                                mensaje_success("Familiar eliminado correctamente.")
                            }
                        })
                    }
                })
            }else {
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
            }
        })

        //Cancelar familia
        $("#cancelar_familiar").on("click", function () {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_familiar').style.display = 'none';
            document.getElementById('actualizar_familiar').style.display = 'none';

            //Mostrar Boton Guardar
            document.getElementById('guardar_familia').style.display = 'initial';

            //botones desactivados editar eliminar
            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_familiar").val();

            if (id) {
                $("#fr_grupo")[0].reset();
                $(".disabled_familia").prop("disabled", false);
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
            }
        })

        //Actualizar familia
        $(document).on("click","#actualizar_familiar", function() {
            if ($('#fr_grupo').smkValidate()) {
                //Ocultar Botones Cancelar Guardar.
                document.getElementById('cancelar_familiar').style.display = 'none';
                document.getElementById('actualizar_familiar').style.display = 'none';

                //Mostrar Boton Guardar
                document.getElementById('guardar_familia').style.display = 'block';
                var objButton = $(this);
                id = objButton.parents("form").find(".id_modificar_familiar").val();

                if (id) {
                    $.ajax({
                        type: "POST",
                        data: $("#fr_grupo").serialize(),
                        url: "{{ route('admin.ajax_actualizar_familia') }}",
                        success: function (response) {
                            if (response.success) {
                                $("#fr_grupo")[0].reset()
                                $(".disabled_familia").prop("disabled", false)
                                mensaje_success("Familiar actualizado correctamente.")

                                setTimeout(() => {
                                    location.reload(true)
                                }, 1500)

                                /*var campos = response.registro;
                                var ciudad = response.lugarNacimiento;
                                var tr = $("#tr_" + campos.id + " td");
                                tr.eq(0).html(campos.nombres);
                                tr.eq(1).html(campos.primer_apellido + " " + campos.segundo_apellido);
                                tr.eq(2).html(campos.documento_identidad);
                                tr.eq(3).html(campos.genero);
                                tr.eq(4).html(campos.fecha_nacimiento);
                                tr.eq(5).html(ciudad);
                                tr.eq(6).html(campos.escolaridad);
                                tr.eq(7).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_familiar disabled_familia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_familia disabled_familia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));*/
                            }
                        }
                    });
                }else {
                    mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
                    $(".disabled_familia").prop("disabled", false);
                }
            }
        })

        //Autocomplete Profesion
        $('#cargo_profesion_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cargo_desempenado") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#profesion_id").val(suggestion.id);
            }
        })

        //Autocomplete Ciudad Expedicion
        $('#ciudad_autocomplete_familia_expedicion').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_familia_ex").val(suggestion.cod_pais);
                $("#departamento_id_familia_ex").val(suggestion.cod_departamento);
                $("#ciudad_id_familia_ex").val(suggestion.cod_ciudad);
            }
        })

        $('#ciudad_autocomplete_familia_nacimiento').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_familia_nac").val(suggestion.cod_pais);
                $("#departamento_id_familia_nac").val(suggestion.cod_departamento);
                $("#ciudad_id_familia_nac").val(suggestion.cod_ciudad);
            }
        })
    })
</script>