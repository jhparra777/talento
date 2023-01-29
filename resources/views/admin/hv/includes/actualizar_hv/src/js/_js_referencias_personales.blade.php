<script>
    $(function () {
        //Guardar referencia personal
        $("#guardar_referencia_personal").on("click", function () {
            if ($('#fr_datos_referencia').smkValidate()) {
                $.ajax({
                    type: "POST",
                    data: $("#fr_datos_referencia").serialize(),
                    url: "{{ route('admin.ajax_guardar_referencia') }}",
                    beforeSend: function() {
                        $("#guardar_referencia_personal").prop('disabled','disabled');
                    },
                    success: function (response) {
                        $("#guardar_referencia_personal").prop('disabled', false);

                        if (response.success) {
                            /*var data = response.referencia;
                            var relacion = response.relacionTipo;
                            var ciudad = response.ciudad;
                            var fila = $("<tr id='tr_" + data.id + "' ></tr>");
                            fila.append($("<td></td>", {text: data.nombres}));
                            fila.append($("<td></td>", {text: data.primer_apellido + " " + data.segundo_apellido}));
                            fila.append($("<td></td>", {text: data.telefono_movil}));
                            fila.append($("<td></td>", {text: data.telefono_fijo}));
                            fila.append($("<td></td>", {text: relacion.descripcion}));
                            fila.append($("<td></td>", {text: ciudad.ciudad_seleccionada}));
                            fila.append($("<td></td>", {html: '<input type="hidden" name="id" value="'+data.id+'"><button type="button" class="btn btn-primary btn-peq editar_referencia disabled_referencia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_referencia disabled_referencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));

                            $("#table_referencias tbody").append(fila);
                            $("#registro_nulo").remove();*/

                            mensaje_success("Referencia guardada correctamente.");

                            //Limpiar campos del formulario
                            $("#fr_datos_referencia")[0].reset();

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

        //Editar referencia
        $(document).on("click", ".editar_referencia", function() {
            //Mostar Botones Cancelar Guardar.
            document.getElementById('cancelar_referencia').style.display = 'initial';
            document.getElementById('actualizar_referencia').style.display = 'initial';

            //Ocultar Boton Guardar
            document.getElementById('guardar_referencia_personal').style.display = 'none';

            //Desactivar botones Editar + Eliminar
            $(".disabled_referencia").prop("disabled", true);

            var objButton = $(this);
            id = objButton.parent().find("input").val();
            
            if(id) {
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{ route('admin.ajax_editar_referencia') }}",
                    success: function (response) {
                        $("#nombre_referencia").val(response.data.nombres);
                        $("#primer_apellido_referencia").val(response.data.primer_apellido);
                        $("#segundo_apellido_referencia").val(response.data.segundo_apellido);
                        $("#tipo_relacion_referencia").val(response.data.tipo_relacion_id);
                        $("#telefono_movil_referencia").val(response.data.telefono_movil);
                        $("#telefono_fijo_referencia").val(response.data.telefono_fijo);
                        $("#ocupacion_referencia").val(response.data.ocupacion);
                        $(".id_modificar_referencia").val(response.data.id);

                        $("#ciudad_autocomplete_referencia").val(response.data.ciudad_autocomplete);
                        $("#pais_id_ref").val(response.data.codigo_pais);
                        $("#departamento_id_ref").val(response.data.codigo_departamento);
                        $("#ciudad_id_ref").val(response.data.codigo_ciudad);
                    }
                })
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
            }
        })

        //Eliminar experiencia
        $(document).on("click",".eliminar_referencia", function() {
            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if (id) {
                $.smkConfirm({
                    text:'¿Eliminar referencia?',
                    accept:'Eliminar',
                    cancel:'Cancelar'
                },function(res) {
                    if (res) {
                        $(".disabled_referencia").prop("disabled", true)

                        $.ajax({
                            type: "POST",
                            data: {"id": id},
                            url: "{{ route('admin.ajax_eliminar_referencia') }}",
                            success: function (response) {
                                $("#tr_" + response.id).remove();
                                mensaje_success("Referencia eliminada correctamente.");
                                $(".disabled_referencia").prop("disabled", false);
                            }
                        })
                    }
                })
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
            }
        })

        //Cancelar experiencia
        $("#cancelar_referencia").on("click", function () {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_referencia').style.display = 'none';
            document.getElementById('actualizar_referencia').style.display = 'none';

            //Mostrar Boton Guardar
            document.getElementById('guardar_referencia_personal').style.display = 'initial';

            //Activar botones Editar + Eliminar
            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_referencia").val();

            if (id) {
                $("#fr_datos_referencia")[0].reset()
                $(".disabled_referencia").prop("disabled", false)
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
            }
        })

        //Actualizar experiencia
        $(document).on("click","#actualizar_referencia", function() {
            if ($('#fr_datos_referencia').smkValidate()) {
                //Ocultar Botones Cancelar Guardar.
                document.getElementById('cancelar_referencia').style.display = 'none';
                document.getElementById('actualizar_referencia').style.display = 'none';

                //Mostrar Boton Guardar
                document.getElementById('guardar_referencia_personal').style.display = 'block';
                var objButton = $(this);
                id = objButton.parents("form").find(".id_modificar_referencia").val()

                if (id) {
                    $.ajax({
                        type: "POST",
                        data: $("#fr_datos_referencia").serialize(),
                        url: "{{ route('admin.ajax_actualizar_referencia') }}",
                        success: function (response) {
                            if (response.success) {
                                $(".disabled_referencia").prop("disabled", false)
                                $("#fr_datos_referencia")[0].reset()

                                mensaje_success("Referencia actualizada correctamente.")

                                setTimeout(() => {
                                    location.reload(true)
                                }, 1500)

                                /*var data = response.referencia;
                                var relacion = response.relacionTipo;
                                var ciudad = response.ciudad;
                                var fila = $("#tr_" + data.id + " td");
                                fila.eq(0).html(data.nombres);
                                fila.eq(1).html(data.primer_apellido + " " + data.segundo_apellido);
                                fila.eq(2).html(data.telefono_movil);
                                fila.eq(3).html(data.telefono_fijo);
                                fila.eq(4).html(relacion.descripcion);
                                fila.eq(5).html(ciudad.ciudad_seleccionada);
                                fila.eq(6).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_referencia disabled_referencia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_referencia disabled_referencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));*/
                            }
                        }
                    });
                }else {
                    mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
                    $(".disabled_referencia").prop("disabled", false)
                }
            }
        })

        //Autocomplete Ciudad Referencia Personal
        $('#ciudad_autocomplete_referencia').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_ref").val(suggestion.cod_pais);
                $("#departamento_id_ref").val(suggestion.cod_departamento);
                $("#ciudad_id_ref").val(suggestion.cod_ciudad);
            }
        });
    });
</script>