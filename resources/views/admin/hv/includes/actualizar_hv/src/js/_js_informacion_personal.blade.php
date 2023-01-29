<script>
    $(function () {
        $('#hijos').change(function() {
            if ($(this).val() == 1) {
                $('#numero_hijos').show();
            }else {
              if($(this).val() == 0) {
                $('#numero_hijos').hide();
              }
            }
        })

        $('#conflicto').change(function() {
            if($(this).val() == 1) {
                $('#descripcion_conflicto').show();
            }else {
                if ($(this).val() == 0) {
                    $('#descripcion_conflicto').hide();
                }
            }
        })

        genero();
        licencia();
        situacion_militar();
        vehiculo();
        grupoPoblacional();
        cuenta_bancaria();

        @if(isset($datos_basicos->grupo_poblacional) && $datos_basicos->grupo_poblacional == "Otro")
            $('#otro_grupo').show()
        @endif

        $(document).on("change", "#pertenece_grupo_poblacional", function() {
            grupoPoblacional();
        });

        $(document).on("change", "#select_grupo_poblacional", function() {
            let val = $(this).val();

            if (val == "Otro") {
                $('#otro_grupo').show()
            }else {
                $('#otro_grupo').hide()
            }
        });
        
        $(document).on("change", "#genero", function () {
            genero();
        });

        $(document).on("change", "#tiene_vehiculo", function () {
          $('#tipo_vehiculo').val('');
            vehiculo();
        });

        $(document).on("change", "[name='tiene_licencia']", function () {
            licencia();
            $('[name="categoria_licencia"]').val('');
            $('[name="numero_licencia"]').val('');
        });

        $(document).on("change", "[name='tiene_cuenta_bancaria']", function () {
            cuenta_bancaria();
        });

        function grupoPoblacional() {
            let val = $('#pertenece_grupo_poblacional').val();
                
            $('#otro_grupo').hide()

            if (val == 1) {
                $("#grupo_poblacional").show();
            }else {
                $("#select_grupo_poblacional").val();
                $("#otro_grupo_poblacional").val();
                $("#grupo_poblacional").hide();
            }
        }

        function genero() {
            valu = $('#genero').val();

            if(valu == 1) {
                //str = $("#nombres").val();

                //$("#nombres").show();
                $("#situacion_militar").show();

                document.querySelector('.militar_situacion').setAttribute('required', true)

                //document.querySelector('.required_label').removeAttribute('hidden')
            }else {
                
                $("#situacion_militar").hide();

                document.querySelector('.militar_situacion').removeAttribute('required')
                if(document.querySelector('.required_label')){
                    document.querySelector('.required_label').setAttribute('hidden', true)
                }
                
            }
        }

        function licencia() {
            if($('[name="tiene_licencia"]').val() == 1) {
                $('[name="categoria_licencia"]').parent('div').parent('div').show();
                $('[name="numero_licencia"]').parent('div').parent('div').show();
            }else {
                $('[name="categoria_licencia"]').parent('div').parent('div').hide();
                $('[name="numero_licencia"]').parent('div').parent('div').hide();
            }
        }

        function vehiculo() {
            if($('#tiene_vehiculo').val() == 1) {
                $('#tipo_vehiculo').parent('div').parent('div').show();
                document.getElementById('tipo_vehiculo').setAttribute('required', true)
            }else {
                $('#tipo_vehiculo').parent('div').parent('div').hide();
                document.getElementById('tipo_vehiculo').removeAttribute('required')
            }
        }

        function cuenta_bancaria() {
            if( $("#tiene_cuenta_bancaria").val() == 1 ){

                $(".banco").fadeIn();
                document.getElementById('nombre_banco').setAttribute('required', true)
                document.getElementById('tipo_cuenta').setAttribute('required', true)
                document.getElementById('numero_cuenta').setAttribute('required', true)

            }else{
                $(".banco").fadeOut();
                document.getElementById('nombre_banco').removeAttribute('required')
                document.getElementById('tipo_cuenta').removeAttribute('required')
                document.getElementById('numero_cuenta').removeAttribute('required')
            }
        }

        //Situación militar definida
        $(document).on('change', '.militar_situacion', function(event) {
            situacion_militar();
            $("#numero_libreta").val('');
            $("#clase_libreta").val('');
        })

        function situacion_militar() {
            var value = $('.militar_situacion').val();

            if( value == 1) {
                $('#libreta_militar').show();

                document.querySelector('#numero_libreta').setAttribute('required', true)
                document.querySelector('#clase_libreta').setAttribute('required', true)
                document.querySelector('#distrito_militar').setAttribute('required', true)
            }else {
                $('#libreta_militar').hide();

                document.querySelector('#numero_libreta').removeAttribute('required')
                document.querySelector('#clase_libreta').removeAttribute('required')
                document.querySelector('#distrito_militar').removeAttribute('required')
            }
        }

        var confDatepicker = {
            maxDate: 0,
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
            yearRange: "1930:2050"
        };

        //Formato fecha
        $("#fecha_expedicion, #fecha_nacimiento").datepicker(confDatepicker);

        $('#txt_nacimiento').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_nacimiento").val(suggestion.cod_pais);
                $("#departamento_nacimiento").val(suggestion.cod_departamento);
                $("#ciudad_nacimiento").val(suggestion.cod_ciudad);
            }
        });

        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_exp").val(suggestion.cod_pais);
                $("#departamento_id_exp").val(suggestion.cod_departamento);
                $("#ciudad_id_exp").val(suggestion.cod_ciudad);
            }
        });
        
        $('#txt_residencia').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_residencia").val(suggestion.cod_pais);
                $("#departamento_residencia").val(suggestion.cod_departamento);
                $("#ciudad_residencia").val(suggestion.cod_ciudad);
            }
        });

        $(document).on("change", ".direccion", function () {
            var txtConcat = "";
            var campos = $(".direccion");
            $("#direccion").val("");

            $.each(campos, function (key, value) {
                var campos = $(value);
                var type = campos.attr("type");
                if (type == "checkbox") {
                    if (campos.prop("checked")) {
                        txtConcat += campos.val() + " ";
                    }
                } else {
                    txtConcat += campos.val() + " ";
                }
            })

            $("#direccion").val(txtConcat);
        });

        $(document).on("keyup", ".direccion_txt", function () {
            var txtConcat = "";
            var campos = $(".direccion");
            $("#direccion").val("");

            $.each(campos, function (key, value) {
                var campos = $(value);
                var type = campos.attr("type");
                if (type == "checkbox") {
                    if(campos.prop("checked")) {
                      txtConcat += campos.val() + " ";
                    }
                } else {
                    txtConcat += campos.val() + " ";
                }
            })

            $("#direccion").val(txtConcat);
        });

        function valida_fecha() {
            fecha_nac = $('#fecha_nacimiento').val();
            fecha_exp = $('#fecha_expedicion').val();

            if(fecha_exp < fecha_nac) {
                $('#fecha_expedicion').val('');
                $.smkAlert({
                    text: 'Fecha de expedición no puede ser mayor a la de nacimiento',
                    type: 'danger',
                    time: 5
                });
            }
        }

        //Acción del botón guardar
        $("#guardar_datos_basicos_admin").on("click", function () {
            valida_fecha();
            if ($('#fr_datos_basicos').smkValidate()) {
                $("#guardar_datos_basicos_admin").prop('disabled','disabled');

                var formData = new FormData(document.getElementById("fr_datos_basicos"));

                $.ajax({
                    type: "POST",
                    data: formData,
                    url: "{{ route("admin.ajax_actualizar_datos_basicos",$user_id) }}",
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#guardar_datos_basicos_admin").prop('disabled', false);
                        mensaje_success("Datos básicos guardados correctamente.");
                    },
                    error:function(data) {
                        $("#guardar_datos_basicos_admin").prop('disabled', false);
                        //mensaje_danger("Olvidaste completar algunos datos, ve al principio del formulario y revisa los campos resaltados.");
                    }
                })
            }
        })
    })
</script>

<script type="text/javascript">
        $(function(){
            var pass1 = $('[name=numero_cuenta]');
            var pass2 = $('[name=numero_cuenta_confirmation]');
            var confirmacion = "Las cuentas si coinciden";
            
            //var longitud = "La contraseña debe estar formada entre 6-10 carácteres (ambos inclusive)";
            var negacion = "No coinciden las cuentas";
            var vacio = "El número de cuenta no puede estar vacío";
            //oculto por defecto el elemento span
            var span = $('<span></span>').insertAfter(pass2);
            span.hide();

            //función que comprueba las dos contraseñas
            function coincidePassword(){
                var valor1 = pass1.val();
                var valor2 = pass2.val();
                
                //muestra el span
                span.show().removeClass();
                
                //condiciones dentro de la función
                if(valor1 != valor2){
                    span.text(negacion).addClass('negacion'); 
                }
                
                if(valor1.length==0 || valor1==""){
                    span.text(vacio).addClass('negacion');  
                }

                /*if(valor1.length<6 || valor1.length>10){
                    span.text(longitud).addClass('negacion');
                }*/

                if(valor1.length!=0 && valor1==valor2){
                    span.text(confirmacion).removeClass("negacion").addClass('confirmacion');
                }
            }
            
            //ejecuta la función al soltar la tecla
            pass2.keyup(function(){
                coincidePassword();
            });
        });
</script>