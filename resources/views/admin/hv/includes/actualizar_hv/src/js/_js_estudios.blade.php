<script>
    $(function () {
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
        $("#fecha_finalizacion").datepicker(confDatepicker);

        $('#ciudad_autocomplete_estu').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#error_ciudad").hide();
                $(this).css("border-color","rgb(210,210,210)");
                $("#pais_estudio").val(suggestion.cod_pais);
                $("#departamento_estudio").val(suggestion.cod_departamento);
                $("#ciudad_estudio").val(suggestion.cod_ciudad);
            }
        });

        //Guardar estudio nuevo
        $(document).on("click","#guardar_estudios", function () {

            if( $("#tiene_estudio").is(":checked") ){

                $("#institucion").removeAttr('required')
                $("#titulo_obtenido").removeAttr('required')
                $("#ciudad_autocomplete_estu").removeAttr('required')
                $("#nivel_estudio_id").removeAttr('required')

            }else{

                $("#institucion").attr('required', true)
                $("#titulo_obtenido").attr('required', true)
                $("#ciudad_autocomplete_estu").attr('required', true)
                $("#nivel_estudio_id").attr('required', true)
            }

            if ($('#fr_estudios').smkValidate()) {
                $("#guardar_estudios").prop('disabled','disabled');

                $.ajax({
                    type: "POST",
                    data: $("#fr_estudios").serialize(),
                    url: "{{ route('admin.ajax_guardar_estudios') }}",
                    success: function (response) {
                        $("#guardar_estudios").prop('disabled',false);

                        if(response.success) {
                            /*var nivel = response.pr;
                            var campos = response.rs;

                            var tr = $("<tr id='tr_" + campos.id + "'></tr>");

                            tr.append($("<td></td>", {text: campos.titulo_obtenido}));
                            tr.append($("<td></td>", {text: campos.institucion}));
                            tr.append($("<td></td>", {text: nivel.descripcion_nivel }));
                            
                            @if(route('home') != "https://gpc.t3rsc.co")
                                tr.append($("<td></td>", {text: ((campos.estudio_actual == 1) ? "SI" : "NO")}));
                            @endif

                            tr.append($("<td></td>", {text: campos.fecha_finalizacion}));

                            @if(route('home') == "https://gpc.t3rsc.co")
                                tr.append($("<td></td>", {text: campos.estatus_academico}));
                            @endif

                            tr.append($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_estudio_p disabled_estudio"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_estudio_p disabled_estudio"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));

                            $("#tbl_estudios tbody").append(tr);
                            $("#registro_nulo").remove();*/

                            mensaje_success("Estudio guardado correctamente.");

                            //Limpiar campos del formulario
                            $("#fr_estudios")[0].reset();

                            setTimeout(() => {
                                location.reload(true)
                            }, 1500)
                        }else {
                            /*if(response.errors) {
                                //Busca todos los input y lo pone a su color original
                                $(document).ready(function() {
                                    $("input").css({"border": "1px solid #ccc"});
                                    $("select").css({"border": "1px solid #ccc"});
                                });

                                //Recorrer el errors y cambiar de color a los input reqeuridos
                                $.each(response.errors,function(key,value) {
                                    //Cambiar color del borde a color rojo
                                    document.getElementById(key).style.border = 'solid red';
                                });
                            }*/

                            mensaje_danger("Ha ocurrido un error, intenta nuevamente");
                        }
                    }
                })
            }
        })

        //Editar estudio
        $(document).on("click",".editar_estudio_p", function() {
            //Mostar botones Cancelar Guardar
            document.getElementById('cancelar_estudios').style.display = 'initial';
            document.getElementById('actualizar_estudios').style.display = 'initial';

            //Ocultar botón Guardar
            document.getElementById('guardar_estudios').style.display = 'none';

            //Desactivar botones editar + eliminar.
            $(".disabled_estudio").prop("disabled", true);

            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if(id) {
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{ route('admin.ajax_editar_estudio') }}",
                    success: function (response) {
                        $("#pais_estudio").val(response.data.pais_estudio);
                        $("#departamento_estudio").val(response.data.departamento_estudio);
                        $("#ciudad_estudio").val(response.data.ciudad_estudio);

                        $("#ciudad_autocomplete_estu").val(response.ciudad_estudio);

                        $("#institucion").val(response.data.institucion);
                        $("#nivel_estudio_id").val(response.data.nivel_estudio_id);
                        $("#titulo_obtenido").val(response.data.titulo_obtenido);
                        $("#periodicidad").val(response.data.periodicidad);
                        $("#fecha_finalizacion").val(response.data.fecha_finalizacion);
                        $("#acta").val(response.data.acta);
                        $("#folio").val(response.data.folio);
                                               
                        @if(route('home') != "https://gpc.t3rsc.co")
                            $("#semestres_cursados").val(response.data.semestres_cursados);
                        @else
                            $("#estatus_academico").val(response.data.estatus_academico);
                        @endif

                        $(".id_modificar_datos").val(response.data.id);
                        
                        if(response.data.termino_estudios == true) {
                          $("#termino_estudios").prop("checked", true);
                        }else {
                          $("#termino_estudios").prop("checked", false);
                        }

                        if(response.data.estudio_actual == true) {
                          $("#estudio_actual").prop("checked", true);
                        }else {
                          $("#estudio_actual").prop("checked", false);
                        }
                    }
                });
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente");
            }
        })

        //Eliminar estudio
        $(document).on("click",".eliminar_estudio_p", function() {
            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if(id) {
                $.smkConfirm({
                    text:'¿Eliminar estudio?',
                    accept:'Eliminar',
                    cancel:'Cancelar'
                },function(res){
                    if (res) {
                        $(".disabled_estudio").prop("disabled", true)

                        $.ajax({
                            type: "POST",
                            data: {"id": id},
                            url: "{{ route('admin.ajax_eliminar_estudio') }}",
                            success: function (response) {
                                $("#tr_" + response.id).remove();
                                mensaje_success("Estudio eliminado correctamente.");
                                $(".disabled_estudio").prop("disabled", false);
                            }
                        })
                    }
                })
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente");
            }
        });

        //Cancelar estudio
        $("#cancelar_estudios").on("click", function () {
            //Ocultar botones Cancelar Guardar
            document.getElementById('cancelar_estudios').style.display = 'none';
            document.getElementById('actualizar_estudios').style.display = 'none';

            //Mostrar botón Guardar
            document.getElementById('guardar_estudios').style.display = 'initial';

            //Activar botones editar + eliminar
            $(".disabled_estudio").prop("disabled", false);

            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_datos").val();

            if (id) {
                $("#fr_estudios")[0].reset();
            }else {
                mensaje_danger("Ha ocurrido un error, intenta nuevamente");
            }
        });

        //Actualizar estudio
        $(document).on("click","#actualizar_estudios", function() {
            if ($('#fr_estudios').smkValidate()) {
                //Ocultar Botones Cancelar Guardar.
                document.getElementById('cancelar_estudios').style.display = 'none';
                document.getElementById('actualizar_estudios').style.display = 'none';

                //Mostrar botn Guardar
                document.getElementById('guardar_estudios').style.display = 'block';

                var objButton = $(this);
                id = objButton.parents("form").find(".id_modificar_datos").val();

                if (id) {
                    $.ajax({
                        type: "POST",
                        data: $("#fr_estudios").serialize(),
                        url: "{{ route('admin.ajax_actualizar_estudio') }}",
                        success: function (response) {
                            if (response.success) {
                                mensaje_success("Estudio actualizado correctamente.");

                                $("#fr_estudios")[0].reset();

                                $(".disabled_estudio").prop("disabled", false);

                                /*var campos = response.estudios;
                                $("#tr_" + campos.id + "").removeClass("oferta_aplicada");
                                var tr = $("#tr_" + campos.id + "").find("td");

                                tr.eq(0).html(campos.titulo_obtenido);
                                tr.eq(1).html(campos.institucion);
                                tr.eq(2).html(campos.nivelEstudios.descripcion);
                                tr.eq(3).html(((campos.estudio_actual == 1) ? "SI" : "NO"));
                                tr.eq(4).html(campos.fecha_finalizacion);
                                tr.eq(5).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_estudio_p disabled_estudio"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_estudio_p disabled_estudio"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));*/

                                setTimeout(() => {
                                    location.reload(true)
                                }, 1500)
                            }
                        }
                    });
                }else {
                    mensaje_danger("Ha ocurrido un error, intenta nuevamente");

                    $(".disabled_estudio").prop("disabled", false);
                }
            }
        })


        $(".certificados_estudios").on("click", function () {
            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if(id) {
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{ route('certificados_estudios') }}",
                    success: function (response) {
                        $("#modalTriSmall").find(".modal-content").html(response);
                        $("#modalTriSmall").modal("show");
                    }
                });
            }else{
                mensaje_danger("No se pueden ver los documentos, favor intentar nuevamente.");
            }
        });

        $(document).on("change", "#estudio_actual", function () {
          estudio_actual();
        });

        //se oculta acta, folio y fecha finalización
        function estudio_actual() {
            if($('#estudio_actual').val() == "0") {
                $('#fecha_finalizacion').parent('div').parent('div').show();
                $('#acta').parent('div').parent('div').show();
                $('#folio').parent('div').parent('div').show();
            }else {
                $('#fecha_finalizacion').val('');
                $('#acta').val('');
                $('#folio').val('');
                $('#fecha_finalizacion').parent('div').parent('div').hide();
                $('#acta').parent('div').parent('div').hide();
                $('#folio').parent('div').parent('div').hide();
            }
        }

    })
</script>