<script>
        $("#postulados").delegate('.can_cedula', 'blur', function() {
            var cedula=$(this).val();
            var _this = this;

            if (cedula == '') {
                $(_this).parents('.candidato-postulado').find('.postular-cand').attr('readonly', true)

                $(_this).parents('.candidato-postulado').find('.postular-cand').val('')

                return false;
            }

            $.ajax({
                url: `{{route('ajaxBuscarCandidatoPorCedula')}}`,
                type: 'POST',
                data: {cedula: cedula}
            }).done(function (response) {
                if (response.find) {

                    if (response.se_puede_postular) {
                        $(_this).parents('.candidato-postulado').find('.postular-cand').attr('readonly', false)

                        $(_this).parents('.candidato-postulado').find('.can_nombres').val(response.candidato.nombres)

                        if (response.candidato.segundo_apellido != null && response.candidato.segundo_apellido != '') {
                            $(_this).parents('.candidato-postulado').find('.can_apellido').val(`${response.candidato.primer_apellido} ${response.candidato.segundo_apellido}`)
                        } else {
                            $(_this).parents('.candidato-postulado').find('.can_apellido').val(response.candidato.primer_apellido)
                        }

                        $(_this).parents('.candidato-postulado').find('.can_movil').val(response.candidato.telefono_movil)

                        $(_this).parents('.candidato-postulado').find('.can_email').val(response.candidato.email)
                    } else {
                        $(_this).parents('.candidato-postulado').find('.postular-cand').attr('readonly', true)

                        $(_this).parents('.candidato-postulado').find('.postular-cand').val('')

                        mensaje_danger("El candidato con el número de documento " + cedula +" no se puede postular porque está asociado en otro requerimiento o se encuentra inactivo.")
                    }
                } else {
                    $(_this).parents('.candidato-postulado').find('.postular-cand').attr('readonly', false)

                    $(_this).parents('.candidato-postulado').find('.can_nombres').val('')

                    $(_this).parents('.candidato-postulado').find('.can_apellido').val('')

                    $(_this).parents('.candidato-postulado').find('.can_movil').val('')

                    $(_this).parents('.candidato-postulado').find('.can_email').val('')
                }
            }).error(function(error){
                console.log("error:",error)
            });
        });

        function crearCargo() {
            var cliente_id = $('#cliente_id').val()

            $.ajax({
                data: {
                    cliente_id: cliente_id
                },
                url: "{{ route('admin.crear_cargo_cliente') }}",
                beforeSend: function(){
                    //imagen de carga
                    $.blockUI({
                        message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">', 
                        css: { 
                            border: "0",
                            background: "transparent"
                        },
                        overlayCSS:  { 
                            backgroundColor: "#fff",
                            opacity:         0.6, 
                            cursor:          "wait" 
                        }
                    });
                },
                success: function(response) {
                    $.unblockUI();
                    $("#modalTriLarge").find(".modal-content").html(response);
                    $("#modalTriLarge").modal({ backdrop: 'static', keyboard: false });
                }
            });
        }

        function validarEmail(object) {
            if (/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(object.val())) {
                //alert("La dirección de email " + valor + " es correcta.");
                object.css("background-color", "white");
            } else {
                object.css("background-color", "#fbc2b0");
                alert("La dirección de email '"+object.val()+"' es incorrecta.");
            }
        }

        $(function () {
            $('.email').change(function(){
                validarEmail($(this));
            });

            $('#contratacion-directa').hide();

            $('.js-select-2-basic').select2({
                placeholder: 'Selecciona o busca una ciudad'
            });

            $('div.alert').delay(5000).fadeOut('slow');
            
            $(document).on('click', '.add-person', function (e) {
                fila_person = $(this).parents('#postulados').find('.row').eq(0).clone();
                fila_person.find('input').val('');
                fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-person mt-2 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red">-</button>');

                $('#postulados').append(fila_person);
            });

            $(document).on('click', '.rem-person', function (e) {
                $(this).parents('.candidato-postulado').remove();
            });

            $(document).on('click', '.add-reque', function (e) {
                fila_person = $(this).parents('#multiciudad_req').find('.row').eq(0).clone();
                fila_person.find('select').val();
                fila_person.find('input').val();
                fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-reque mt-2 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red">-</button>');

                $('#multiciudad_req').append(fila_person);
            });

            $(document).on('click', '.rem-reque', function (e) {
                $(this).parents('.campos-multiciudad').remove();
            });

            //Busca ciudad
            $('#sitio_trabajo_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $(this).css("border-color","rgb(210,210,210)");
                    $("#error_ciudad_expedicion").hide();
                     $(this).css("border-color","rgb(210,210,210)");
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });

            $('#sitio_trabajo_autocomplete').keypress(function(){
                $(this).css("border-color","red");
                $("#error_ciudad_expedicion").show();
                $("#select_expedicion_id").val("no");
            });

            //Esta configuracion no debe ser usada en otro campo de fecha
            var calendarOptionChange = {
                minDate: 0,
                dateFormat: "yy-mm-dd",
                dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                onSelect: function () {
                    //No se debe comentar esta linea
                    $(this).change();
                }
            };

            var calendarOption1 = {
                minDate: 0,
                dateFormat: "yy-mm-dd",
                dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
            };

            var calendarOption2 = {
                dateFormat: "yy-mm-dd",
                dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
            };

            var calendarOption3 = {
                dateFormat: "yy-mm-dd",
                dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
            };

            $("#fecha_tentativa_cumplimiento").datepicker(calendarOption1);
            $("#fecha_ingreso")
                .datepicker(calendarOptionChange)
                .on("change", function() {
                    var fecha_ingreso = new Date($(this).val());
                    fecha_ingreso.setFullYear(fecha_ingreso.getFullYear()+1);
                    fecha_ingreso.setDate(fecha_ingreso.getDate() - 1);
                    var fecha_retiro = fecha_ingreso.toISOString().substring(0,10);

                    $('#fecha_retiro').val(fecha_retiro);
                });

            $("#fecha_retiro").datepicker(calendarOption2);

            $('#fecha_recepcion').datepicker(calendarOption2);

            $('.fechas_ingresos').datepicker(calendarOption2);
            $('#fecha_ingreso_contra').datepicker(calendarOption2);

            /* verificar la relacion con tipo contrato */
            {{-- Carga componente del cargo --}}
            $('#cargo_especifico_id').on("change", function (e) {
                var id = $(this).val();
                var negocio_id = '{{$negocio->id }}';

                id_cliente = $("#cliente_id").val();

                $.ajax({
                    url: "{{ route('req.ajaxgetcargoespecificodependientes') }}",
                    type: 'POST',
                    data: {
                        cargo_especifico_id: id,
                        negocio_id: negocio_id,
                        cliente_id: id_cliente,
                        modulo: "admin"
                    }
                })
                .done(function (response) {
                    //$('.here-put-fields-from-ajax').html(response);
                    console.log(response)
                    $("#cargo_generico_id").val(response.cargo_generico_id)
                    $("#ctra_x_clt_codigo").val(response.ctra_x_clt_codigo)
                    if( response.ficha_jornada_laboral != "" ){
                        $("#tipo_jornadas_id").val(response.ficha_jornada_laboral)
                    }
                    if( response.tipo_liquidacion_id != "" ){
                        $("#tipo_liquidacion").val(response.tipo_liquidacion_id)
                    }
                    if( response.tipo_salario_id != "" ){
                        $("#tipo_salario").val(response.tipo_salario_id)
                    }
                    $("#tipo_nomina").val(response.tipo_nomina_id)
                    $("#concepto_pago_id").val(response.concepto_pago_id)
                    $("#salario").val(response.salario)
                    if( response.ficha_tipo_contrato != "" ){
                        $("#tipo_contrato_id").val(response.ficha_tipo_contrato)
                    }
                    $("#adicionalesSalariales").val(response.adicionales_salariales)
                    $("#motivo_requerimiento_id").val(response.motivo_requerimiento_id)
                    $("#num_vacantes").val(response.ficha_numero_vacante)
                    $("#funciones").val(response.ficha_funciones_realizar)
                    $("#observaciones").val(response.observaciones)
                    $("#nivel_estudio").val(response.ficha_nivel_estudio)
                    $("#tipo_experiencia_id").val(response.tipo_experiencia_id)
                    $("#edad_minima").val(response.ficha_edad_minima)
                    $("#edad_maxima").val(response.ficha_edad_maxima)
                    $("#genero_id").val(response.ficha_genero)
                    $("#estado_civil").val(response.estado_civil_selected)

                    $(".enviar_requerimiento_btn").prop("disabled","");
                    if($("#tipo_proceso_id").val() == 6){
                        $('.no_contra').hide('slow');
                    }else{
                        $('.no_contra').show('slow');
                    }
                });

                /*$.ajax({
                    url: "{{ route('listar_clausulas_cargo_post') }}",
                    type: 'POST',
                    data: {
                        cargo_id: id
                    }
                })
                .done(function (response) {
                    $('#adicionalesBox').html(response);
                });
                */
            });
        });

        $(document).on('change', '#select_multi_reque', function () {
            if($(this).val() == 1){
                $('#collapseMulticiudad').collapse('show');
            }else{
                $('#collapseMulticiudad').collapse('hide');
            }
        });

        $("#collapseMulticiudad").on('shown.bs.collapse', function(){
            $("#select_multi_reque").val(1)
        });

        $("#collapseMulticiudad").on('hidden.bs.collapse', function(){
            $("#select_multi_reque").val(0)
        });

        $(document).on('change', '#tipo_proceso_id', function () {
            if($(this).val() == 6 || $("#tipo_proceso_id").val() == 4){
                   //$('#contratacion-directa').show('slow');
                $('#fecha_no').hide('slow');
                $('.no_contra').hide('slow');
                $('#collapsePostulados').collapse('show');
                $('.can_nombres').attr("required", true);
                $('.can_apellido').attr("required", true);
                $('.can_cedula').attr("required", true);
                $('.can_email').attr("required", true);
                $('.can_cedula').attr("required", true);

            }else{
                $('#contratacion-directa').hide('slow');
                $('#contratacion-directa :input').val('');
                $('#fecha_no').show('slow');
                $('.no_contra').show('slow');
                $('#collapsePostulados').collapse('hide');
                $('.can_nombres').removeAttr("required");
                $('.can_apellido').removeAttr("required");
                $('.can_cedula').removeAttr("required");
                $('.can_email').removeAttr("required");

            }
        });
        
        function validaSalario() {
            let salario = $("#salario").val();

            if(salario == 0 ){
                $.smkAlert({
                    text: 'El salario no puede ser cero (0)',
                    type: 'danger',
                    time: 5
                });
                $("#salario").val("")
            } 
        }

        $(document).on('click', '#enviar_requerimiento_btn', function() {
            $(this).prop("disabled",true);
            
            if($('#collapseMulticiudad').is(':visible')){

                $('#ciudad_trabajo_multi').attr('required', true)
                $('#salario_multi').attr('required', true)
                $('#num_vacantes_multi').attr('required', true)

            }else{
                $('#ciudad_trabajo_multi').removeAttr('required')
                $('#salario_multi').removeAttr('required')
                $('#num_vacantes_multi').removeAttr('required')
            }

            if($("#tipo_proceso_id").val() == 4 || $("#tipo_proceso_id").val() == 6){

                $('#collapsePostulados').collapse('show');
            }
            validaSalario();
            if ($('#frm_crearReq').smkValidate()) {
                
                $("#frm_crearReq").submit();
            }

            $("#enviar_requerimiento_btn").removeAttr("disabled");
            
        });

        function calculo_fecha_segun_cargo(){
            var vacantes=$("#num_vacantes").val();
            var motivo=$("#motivo_requerimiento_id").val();
            var ciudad=$("#ciudad_id").val();
            var cargo=$("#cargo_especifico_id").val();
            var departamento=$("#departamento_id").val();

            if(vacantes!="" && motivo!="" && ciudad!="" && cargo!=""){
                $.ajax({
                    type: "POST",
                    data: {
                        "ciudad_id":ciudad,
                        "motivo":motivo,
                        "cargo_especifico_id":cargo,
                        "vacantes":vacantes,
                        "departamento_id":departamento
                    },
                    url: "{{ route('req.ajaxgetfechaSegunCargo') }}",
                    success: function(response) {
                        $("#fecha_ingreso").val(response);
                    }
                });
            }
            else{
            }
        }

        /*$("#frm_crearReq").delegate('#motivo_requerimiento_id', 'change', function(){
            calculo_fecha_segun_cargo();
        });

        $("#frm_crearReq").delegate('#num_vacantes', 'change', function(){
            calculo_fecha_segun_cargo();
        });*/

        $(function(){
            $('#idioma_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocompletar_idiomas") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#id_idioma").val(suggestion.id);
                    $("#idioma_autocomplete").val(suggestion.value);
                }
            });

            $('#salario').on('change invalid', function() {
                var campotexto = $(this).get(0);

                campotexto.setCustomValidity('');

                if (!campotexto.validity.valid) {
                    campotexto.setCustomValidity('El campo salario es obligatorio');  
                }
            });

            $("#salario").change(function(){
                let salario = $("#salario").val();

                if(salario == 0 ){
                    $.smkAlert({
                        text: 'El salario no puede ser cero (0)',
                        type: 'danger',
                        time: 5
                    });
                    $(this).val("")
                }   
            });

            $(".solo-numero").keydown(function(event) {
                if(event.shiftKey){
                    event.preventDefault();
                }
                
                if (event.keyCode == 46 || event.keyCode == 8){
                }
                else{
                    if (event.keyCode < 95) {
                        if(event.keyCode < 48 || event.keyCode > 57) {
                        event.preventDefault();
                        }
                    } 
                    else {
                        if(event.keyCode < 96 || event.keyCode > 105) {
                        event.preventDefault();
                        }
                    }
                }
            });


            $("#edad_maxima").blur(function(event) {

                let edad_maxima = parseInt($(this).val());
                let edad_minima = parseInt($("#edad_minima").val());

                if (edad_maxima < edad_minima) {
                    $(this).val("");
                    mensaje_danger("La edad máxima no puede ser menor que la edad mínima")
                }
            });

            $("#edad_minima").blur(function(event) {

                let edad_minima = parseInt($(this).val());
                let edad_maxima = parseInt($("#edad_maxima").val());

                if (edad_minima > edad_maxima && edad_maxima != "") {
                    $(this).val("");
                    mensaje_danger("La edad mínima no puede ser mayor que la edad máxima")
                }
            });
        });
    </script>