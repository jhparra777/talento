<script>
    $(function() {
        $('.ocultar').show();

        @if(route('home') == "https://gpc.t3rsc.co")
            $('#actual_show').hide();
        @endif

        $('.empleo_actual').change(function() {
            if($(this).val() == 1) {
                $('.ocultar').hide();
                $('#actual_show').show();

                $('#motivo_r').hide();

                document.querySelector('#motivo_retiro').removeAttribute('required')
                document.querySelector('#fecha_final').removeAttribute('required')
            }else {
                $('.ocultar').show();
                $('#actual_show').hide();
                
                $('#motivo_r').show();

                document.querySelector('#motivo_retiro').setAttribute('required', true)
                document.querySelector('#fecha_final').setAttribute('required', true)
            }
        });

        var confDatepicker = {
            altFormat: "yy-mm-dd",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            buttonImage: "img/gifs/018.gif",
            buttonImageOnly: true,
            autoSize: true,
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            maxDate: '+0d',
            yearRange: "1930:2050"
        };

        //Formato fecha
        $("#fecha_inicio, #fecha_final").datepicker(confDatepicker);

        function validar_fecha() {
            actual = $('#empleo_actual').val();
            if (actual == "2") {
                fecha_inicio = $('#fecha_inicio').val();
                fecha_final = $('#fecha_final').val();

                if(fecha_final < fecha_inicio) {
                    $('#fecha_final').val('');
                    $.smkAlert({
                        text: 'Fecha de terminación no puede ser mayor a la de inicio',
                        type: 'danger',
                        time: 5
                    });
                }
            }  
        }
        
        //Guardar experiencia
        $("#guardar_experiencias").on("click", function () {
            validar_fecha();
            if( $("#tiene_experiencia").is(":checked") ){

                $("#nombre_empresa").removeAttr('required')
                $("#telefono_temporal").removeAttr('required')
                $("#autocompletado_residencia").removeAttr('required')
                $("#cargo_especifico").removeAttr('required')
                $("#cargo_desempenado").removeAttr('required')
                $("#nombres_jefe").removeAttr('required')
                $("#cargo_jefe").removeAttr('required')
                $("#telefono_movil_jefe").removeAttr('required')
                $("#fecha_inicio").removeAttr('required')
                $("#salario_devengado").removeAttr('required')

                if( $(".empleo_actual").val() == 2 ) {
                    document.querySelector('#motivo_retiro').removeAttribute('required')
                    document.querySelector('#fecha_final').removeAttribute('required')
                }
            
            }else{

                $("#nombre_empresa").attr('required', true)
                $("#telefono_temporal").attr('required', true)
                $("#autocompletado_residencia").attr('required', true)
                $("#cargo_especifico").attr('required', true)
                $("#cargo_desempenado").attr('required', true)
                $("#nombres_jefe").attr('required', true)
                $("#cargo_jefe").attr('required', true)
                $("#telefono_movil_jefe").attr('required', true)
                $("#fecha_inicio").attr('required', true)
                $("#salario_devengado").attr('required', true)

                if( $(".empleo_actual").val() == 2 ) {

                    document.querySelector('#motivo_retiro').setAttribute('required', true)
                    document.querySelector('#fecha_final').setAttribute('required', true)
                
                }

            }

            if ($('#fr_datos_experiencia').smkValidate()) {
                $.ajax({
                    type: "POST",
                    data: $("#fr_datos_experiencia").serialize(),
                    url: "{{ route('admin.ajax_guardar_experiencia') }}",
                    success: function (response) {
                        //$('#registro_nulo').remove();

                        if(response.success) {
                            /*var campos = response.rs;
                            var tr = $("<tr id='tr_" + campos.id + "'></tr>");

                            tr.append($("<td></td>", {text: campos.nombre_empresa}));
                            
                            @if(route('home') != "https://gpc.t3rsc.co")
                                tr.append($("<td></td>", {text: campos.telefono_temporal}));
                            @endif

                            tr.append($("<td></td>", {text: campos.nombres_jefe}));
                            tr.append($("<td></td>", {text: campos.movil_jefe}));
                            tr.append($("<td></td>", {text: campos.fijo_jefe}));
                            tr.append($("<td></td>", {text: campos.cargo_jefe}));

                            tr.append($("<td></td>", {text: campos.fecha_inicio}));
                            tr.append($("<td></td>", {text: campos.fecha_final}));
                            tr.append($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_experiencia disabled_experiencia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_experiencia disabled_experiencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));

                            $("#tbl_experiencias tbody").append(tr);
                            $("#registro_nulo").remove();*/

                            //Limpiar campos del formulario
                            $("#fr_datos_experiencia")[0].reset();
                            mensaje_success("Experiencia guardada correctamente.");

                            setTimeout(() => {
                                location.reload(true)
                            }, 1500)
                        }else {
                            mensaje_danger("Ha ocurrido un error, intenta nuevamente.");
                        }
                    }
                })
            }
        })

        //Editar experiencia
        $(document).on("click",".editar_experiencia", function() {
            //Mostar Botones Cancelar Guardar.
            document.getElementById('cancelar_experiencia').style.display = 'initial';
            document.getElementById('actualizar_experiencia').style.display = 'initial';

            //Ocultar Boton Guardar
            document.getElementById('guardar_experiencias').style.display = 'none';

            //Desactivar botones Editar + Eliminar
            $(".disabled_experiencia").prop("disabled", true);

            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if(id) {
                $.ajax({
                    type: "POST",
                    data: {"id": id},
                    url: "{{ route('admin.ajax_editar_experiencia') }}",
                    success: function (response) {
                        $("#nombre_empresa").val(response.data.nombre_empresa);
                        $("#telefono_temporal").val(response.data.telefono_temporal);
                        $("#cargo_desempenado").val(response.data.cargo_desempenado);
                        $("#cargo_especifico").val(response.data.cargo_especifico);

                        $("#nombres_jefe").val(response.data.nombres_jefe);
                        $("#cargo_jefe").val(response.data.cargo_jefe);
                        $("#telefono_movil_jefe").val(response.data.movil_jefe);
                        $("#telefono_jefe").val(response.data.fijo_jefe);
                        $("#ext_jefe").val(response.data.ext_jefe);

                        $("#fecha_final").val(response.data.fecha_final);
                        $("#fecha_inicio").val(response.data.fecha_inicio);
                        $("#salario_devengado").val(response.data.salario_devengado);
                        $("#motivo_retiro").val(response.data.motivo_retiro);

                        $("#funciones_logros").val(response.data.funciones_logros);

                        $(".id_modificar_experiencia").val(response.data.id);

                        if (response.data.empleo_actual == true) {
                            $("#empleo_actual").prop("checked", true)
                        }else {
                            $("#empleo_actual").prop("checked", false);
                        }

                        //Ciudad-Residencia
                        $("#autocompletado_residencia").val(response.ciudad);
                        $("#pais_id_res").val(response.data.pais_id);
                        $("#departamento_id_res").val(response.data.departamento_id);
                        $("#ciudad_id_res").val(response.data.ciudad_id);

                        //Cargo Desepeño
                        $("#cargo_desempenado_autocomplete").val(response.cargo);
                    }
                });
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente.");
            }
        });

        //Eliminar experiencia
        $(document).on("click",".eliminar_experiencia", function() {
            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if (id) {
                $.smkConfirm({
                    text:'¿Eliminar experiencia?',
                    accept:'Eliminar',
                    cancel:'Cancelar'
                },function(res){
                    if (res) {
                        $(".disabled_experiencia").prop("disabled", true)

                        $.ajax({
                            type: "POST",
                            data: {"id": id},
                            url: "{{ route('admin.ajax_eliminar_experiencia') }}",
                            success: function (response) {
                                $("#tr_" + response.id).remove();
                                $(".disabled_experiencia").prop("disabled", false);
                                mensaje_success("Experiencia eliminada correctamente.");
                            }
                        })
                    }
                })
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
            }
        })

        //Cancelar experiencia
        $("#cancelar_experiencia").on("click", function () {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_experiencia').style.display = 'none';
            document.getElementById('actualizar_experiencia').style.display = 'none';

            //Mostrar Boton Guardar
            document.getElementById('guardar_experiencias').style.display = 'initial';

            //Activar botones Editar + Eliminar
            $(".disabled_experiencia").prop("disabled", false);

            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_experiencia").val();

            if (id) {
                $("#fr_datos_experiencia")[0].reset();
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
            }
        });

        //Actualizar experiencia
        $(document).on("click","#actualizar_experiencia", function() {
            if ($('#fr_datos_experiencia').smkValidate()) {
                //Ocultar Botones Cancelar Guardar.
                document.getElementById('cancelar_experiencia').style.display = 'none';
                document.getElementById('actualizar_experiencia').style.display = 'none';

                //Mostrar Boton Guardar
                document.getElementById('guardar_experiencias').style.display = 'block';
                var objButton = $(this);
                id = objButton.parents("form").find(".id_modificar_experiencia").val();

                if (id) {
                    $.ajax({
                        type: "POST",
                        data: $("#fr_datos_experiencia").serialize(),
                        url: "{{ route('admin.ajax_actualizar_experiencia') }}",
                        success: function (response) {
                            if(response.success) {
                                mensaje_success("Experiencia actualizada correctamente.")

                                $("#fr_datos_experiencia")[0].reset()
                                $(".disabled_experiencia").prop("disabled", false)

                                setTimeout(() => {
                                    location.reload(true)
                                }, 1500)

                                /*var campos = response.rs;
                                $("#tr_" + campos.id).html(tr);
                                var tr = $("#tr_" + campos.id + "").find("td");

                                tr.eq(0).html(campos.nombre_empresa);
                                tr.eq(1).html(campos.telefono_temporal);
                                @if(route("home") != "http://tiempos.t3rsc.co" && route("home") != "https://tiempos.t3rsc.co")
                                tr.eq(2).html(campos.nombres_jefe);
                                tr.eq(3).html(campos.movil_jefe);
                                tr.eq(4).html(campos.fijo_jefe);
                                tr.eq(5).html(campos.cargo_jefe);
                                @endif
                                tr.eq(6).html(campos.fecha_inicio);
                                tr.eq(7).html(campos.fecha_final);
                                tr.eq(8).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_experiencia disabled_experiencia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_experiencia disabled_experiencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));*/
                            }
                        }
                    });
                }else {
                    mensaje_danger("Ha ocurrido un error, intenta nuevamente.")
                    $(".disabled_experiencia").prop("disabled", false)
                }

            }
        })

        //Autocomplete Ciudad Residencia
        $('#autocompletado_residencia').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_res").val(suggestion.cod_pais);
                $("#departamento_id_res").val(suggestion.cod_departamento);
                $("#ciudad_id_res").val(suggestion.cod_ciudad);
            }
        });

        //Autocomplete Cargo
        $('#cargo_desempenado_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cargo_desempenado") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#cargo_desempenado").val(suggestion.id);
            }
        });

        $(".certificados_experiencias").on("click", function () {
            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if(id) {
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{ route('certificados_experiencias') }}",
                    success: function (response) {
                        $("#modalTriSmall").find(".modal-content").html(response);
                        $("#modalTriSmall").modal("show");
                    }
                });
            }else{
                mensaje_danger("No se pueden ver los documentos, favor intentar nuevamente.");
            }
        });
    });
</script>