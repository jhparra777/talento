<script>
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
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal({ backdrop: 'static', keyboard: false });
                }
            });
        }

        $(function () {
            $("#otro").on("click", function() {

            if($(this).is(':checked')){
                $('#NuevoRecurso').removeClass('hidden');
            }else{
                $('#NuevoRecurso').addClass('hidden');
                $('#NuevoRecurso').val('');
            }
        });

        $('#idioma_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocompletar_idiomas") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#id_idioma").val(suggestion.id);
                $("#idioma_autocomplete").val(suggestion.value);
            }
        });

        $('#cargo_especifico_id').change(function(e){
            //alert('modificar cargos alerta');
        })

        $("#tipo_contrato_id").change(function(){
            if($(this).val()==7){
                $("#tiempo_contrato").attr("readonly",false);
                  $("#tiempo_contrato").attr("placeholder","Ingrese tiempo del contrato");
                  $("#tiempo_contrato").focus();
            }
            else{
                 $("#tiempo_contrato").attr("readonly","readonly");
                 $("#tiempo_contrato").val("");
            }
        })

        /**
         * Al seleccionar el area de trabajo traer el subarea relacionado
         **/
        $("#area_id").change(function(){
            var valor = $(this).val();
            $.ajax({
                url: "{{ route('admin.selctAreaTrabajo') }}",
                type: 'POST',
                data: {id: valor},
                success: function(response){
                    var data = response.subarea;
                    $('#subarea_id').empty();
                     $('#subarea_id').append("<option value=''>Seleccionar</option>");
                    $.each(data, function(key, element) {
                        $('#subarea_id').append("<option value='" + key + "'>" + element + "</option>");
                    });

                    $('#centro_beneficio_id').empty();
                    $('#centro_beneficio_id').append("<option value=''>Seleccionar</option>");

                    $('#centro_costo_id').empty();
                    $('#centro_costo_id').append("<option value=''>Seleccionar</option>");
                }
            });
        });

        /**
         * Al seleccionar el subarea traer los beneficios relacionados
         **/
        $("#subarea_id").change(function(){
            var valor = $(this).val();
            $.ajax({
                url: "{{ route('admin.selctSubArea') }}",
                type: 'POST',
                data: {id: valor},
                success: function(response){
                    var data = response.subarea;
                    $('#centro_beneficio_id').empty();
                    $('#centro_beneficio_id').append("<option value=''>Seleccionar</option>");
                    $.each(data, function(key, element) {
                        $('#centro_beneficio_id').append("<option value='" + key + "'>" + element + "</option>");
                    });

                    $('#centro_costo_id').empty();
                    $('#centro_costo_id').append("<option value=''>Seleccionar</option>");
                }
            });
        });

        /**
         * Al seleccionar el benficio traer los costos relacionados
         **/
        $("#centro_beneficio_id").change(function(){
            var valor = $(this).val();
            $.ajax({
                url: "{{ route('admin.selctCosto') }}",
                type: 'POST',
                data: {id: valor},
                success: function(response){
                    var data = response.subarea;
                    $('#centro_costo_id').empty();
                    $('#centro_costo_id').append("<option value=''>Seleccionar</option>");
                    $.each(data, function(key, element) {
                        $('#centro_costo_id').append("<option value='" + key + "'>" + element + "</option>");
                    });
                }
            });
        });

@if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") //cambiar *********************//
  
  $("#salario").on('input', function(){
    var valActual = $(this).val();
    var nuevoValor = conComas(valActual);
  //   console.log(valActual);
       $(this).val(nuevoValor);
  });

  function conComas(valor){
      var nums = new Array();
      var simb = "."; //Éste es el separador
      valor = valor.toString();
      valor = valor.replace(/\D/g, "");   //Ésta expresión regular solo permitira ingresar números
      nums = valor.split(""); //Se vacia el valor en un arreglo
      var long = nums.length - 1; // Se saca la longitud del arreglo
      var patron = 3; //Indica cada cuanto se ponen las comas
      var prox = 2; // Indica en que lugar se debe insertar la siguiente coma
      var res = "";
   
      while (long > prox) {
          nums.splice((long - prox),0,simb); //Se agrega la coma
          prox += patron; //Se incrementa la posición próxima para colocar la coma
      }
   
      for (var i = 0; i <= nums.length-1; i++) {
          res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
      }
   
      return res;
  }

@endif

        //Esta configuracion no debe ser usada en otro campo de fecha
        var calendarOptionChange = {
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

        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
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