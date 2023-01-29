<script type="text/javascript">
    //muestra los campos relacionados con libreta militar y licencia
    //Si no tiene, los mantiene ocultos
    $( document ).ready(function() {
        var libreta_valor = document.getElementById('tiene_libreta').value;
        var licencia_valor = document.getElementById('tiene_licencia').value;

        if (libreta_valor == 1) {
            $("#depend-libreta").show();
            $("#numero_libreta,#clase_libreta").attr("required","required");
        } else {
            $("#depend-libreta").hide('slow');
            $("#numero_libreta,#clase_libreta").removeAttr("required");
        }

        if (licencia_valor == 1) {
            $("#depend-licencia").show();
            $("#numero_licencia,#clase_licencia").attr("required","required");
        } else {
            $("#depend-licencia").hide('slow');
            $("#numero_licencia,#clase_licencia").removeAttr("required");
        }
    });

    $('#ciudad_exp_autocomplete').keypress(function(){
        $(this).css("border-color","red");
        $("#error_ciudad_expedicion").show();
        $("#ciudad_expedicion_id").val("");
    });

    $('#ciudad_exp_autocomplete').autocomplete({
        serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
        autoSelectFirst: true,
        onSelect: function (suggestion){
            // $(this).css("border-color","rgb(210,210,210)");
            $("#error_ciudad_expedicion").hide();
            $(this).css("border-color","rgb(210,210,210)");
            $("#pais_id").val(suggestion.cod_pais);
            $("#departamento_expedicion_id").val(suggestion.cod_departamento);
            $("#ciudad_expedicion_id").val(suggestion.cod_ciudad);
        }
    });

    $('#ciudad_nac_autocomplete').keypress(function(){
        $(this).css("border-color","red");
        $("#error_ciudad_nacimiento").show();
        $("#ciudad_nacimiento").val("");
    });

    $('#ciudad_nac_autocomplete').autocomplete({
        serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
        autoSelectFirst: true,
        onSelect: function (suggestion){
            $("#error_ciudad_nacimiento").hide();
            $(this).css("border-color","rgb(210,210,210)");
            $("#pais_nacimiento").val(suggestion.cod_pais);
            $("#departamento_nacimiento").val(suggestion.cod_departamento);
            $("#ciudad_nacimiento").val(suggestion.cod_ciudad);
            console.log(suggestion.cod_pais)
        }
    });

    $('#ciudad_res_autocomplete').keypress(function(){
        $(this).css("border-color","red");
        $("#error_ciudad_residencia").show();
        $("#ciudad_residencia").val("");
    });
    
    $('#ciudad_res_autocomplete').autocomplete({
        serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
        autoSelectFirst: true,
        onSelect: function (suggestion){
            $("#error_ciudad_residencia").hide();
            $(this).css("border-color","rgb(210,210,210)");
            $("#pais_residencia").val(suggestion.cod_pais);
            $("#departamento_residencia").val(suggestion.cod_departamento);
            $("#ciudad_residencia").val(suggestion.cod_ciudad);
            console.log(suggestion.cod_pais)
        }
    });

    $(function(){
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

        $("#fecha_nacimiento,#fecha_expedicion").datepicker(confDatepicker);

        $("#tiene_libreta").on("change", function () {
            if($(this).val()==1){
                $("#depend-libreta").toggle('slow');
                $("#numero_libreta,#clase_libreta").attr("required","required");     
            }
            else{
                $("#depend-libreta").hide('slow');
                $("#numero_libreta,#clase_libreta").removeAttr("required");
                $("#numero_libreta").val('');
                $("#clase_libreta").prop('selectedIndex',0);
            }
        });

        $("#tiene_licencia").on("change", function () {
            if($(this).val()==1){
                $("#depend-licencia").toggle('slow');
                $("#numero_licencia,#clase_licencia").attr("required","required");
            }
            else{
                $("#depend-licencia").hide('slow');
                $("#numero_licencia,#clase_licencia").removeAttr("required");
                $("#numero_licencia").val('');
                $("#clase_licencia").prop('selectedIndex',0);
            }
        });
    });

</script>