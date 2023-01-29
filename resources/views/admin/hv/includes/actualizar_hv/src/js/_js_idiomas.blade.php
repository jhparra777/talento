<script>
    $(function () {
        $('#idioma_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocompletar_idiomas") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#id_idioma").val(suggestion.id);
                $("#idioma_autocomplete").val(suggestion.value);
            }
        })

        //Guardar idioma
        $("#guardar_idioma").on("click", function () {
            if ($('#fr_idioma').smkValidate()) {
                $.ajax({
                    type: "POST",
                    data: $("#fr_idioma").serialize(),
                    url: "{{ route('admin.ajax_guardar_idioma') }}",
                    beforeSend: function() {
                        $("#guardar_idioma").prop('disabled','disabled')
                    },
                    success: function (response) {
                        $("#guardar_idioma").prop('disabled',false);

                        if (response.success) {
                            mensaje_success("Idioma creado correctamente.")

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

        //Editar idioma
        $(document).on("click",".editar_idioma", function() {
            //Mostar Botones Cancelar Guardar.
            document.getElementById('cancelar_idioma').style.display = 'block';
            document.getElementById('actualizar_idioma').style.display = 'block';
            
            //Ocultar Boton Guardar
            document.getElementById('guardar_idioma').style.display = 'none';
            
            //Desactivar botones Editar + Eliminar
            $(".disabled_idioma").prop("disabled", true);

            var objButton = $(this);
            id = $(this).data('id');

            if(id) {
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{ route('editar_idioma') }}",
                    success: function (response) {
                        $("#id_idioma").val(response.datos.id_idioma);
                        $("#idioma_autocomplete").val(response.datos.nombre_idioma);
                        $("#nivel").val(response.datos.nivel);

                        $("#e_idioma_id").val(response.datos.id);
                    }
                });
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
            }
        })

        //Cancelar
        $("#cancelar_idioma").on("click", function () {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_idioma').style.display = 'none';
            document.getElementById('actualizar_idioma').style.display = 'none';

            //Mostrar Boton Guardar
            document.getElementById('guardar_idioma').style.display = 'block';
            
            //Activar botones Editar + Eliminar
            $(".disabled_idioma").prop("disabled", false);

            var objButton = $(this);
            id = $("#e_idioma_id").val();

            if(id) {
                $("#fr_idioma")[0].reset();
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
            }
        })

        //Eliminar idioma
        $(document).on("click",".eliminar_idioma", function() {
            $.smkConfirm({
                text:'¿Eliminar idioma?',
                accept:'Eliminar',
                cancel:'Cancelar'
            },function(res){
                if (res) {
                    var objButton = $(this)
                    id = $(this).data('id')

                    $.ajax({
                        type: "POST",
                        data: {"id":id},
                        url: "{{ route('eliminar_idioma') }}",
                        success: function (response) {
                            objButton.parents('td').parents('tr').remove()

                            mensaje_success("Idioma eliminado correctamente.")

                            setTimeout(() => {
                                $("#modal_success").modal("hide")
                            }, 1500)
                        },
                        error: function(response) {
                            mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
                        }
                    })
                }
            })
        })

        //Actualizar idioma
        $(document).on("click","#actualizar_idioma", function() {
            if ($('#fr_idioma').smkValidate()) {
                var objButton = $(this);
                id = objButton.parents("form").find("#e_idioma_id").val();

                if (id) {
                    $.ajax({
                        type: "POST",
                        data: $("#fr_idioma").serialize(),
                        url: "{{ route('actualizar_idioma') }}",
                        beforeSend: function() {
                        },
                        success: function (response) {
                            mensaje_success("Idioma actualizado correctamente.")

                            setTimeout(() => {
                                location.reload(true)
                            }, 1500)
                        },
                        error:function(data) {
                            mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
                        }
                    });
                }else{
                    mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
                    $(".disabled_idioma").prop("disabled", false);
                }
            }
        })
    })
</script>