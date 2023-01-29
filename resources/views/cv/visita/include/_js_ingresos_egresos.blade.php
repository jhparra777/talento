<script>

    function formatNumber (n) {
        n = String(n).replace(/\D/g, "");
        return n === '' ? n : Number(n).toLocaleString('de-DE');
    }

    function ingresoNeto(ingresos,egresos){
        var i=Number(String(ingresos).replace(/\D/g, ""));
        var e=Number(String(egresos).replace(/\D/g, ""));
        return Number(i-e).toLocaleString();
    }
    $( document ).ready(function() {
        //intento 3490 de validar campos menores
        $('.panel-body').delegate('.validar_menor', 'change', function(){

            var ingreso_personal = Number($(this).parents('.valida').find('.validar_mayor').eq(0).val().replaceAll('.', '').replaceAll(',', ''));
            var aporte = Number($(this).val().replaceAll('.', ''));
            if(aporte > ingreso_personal ){
                $.smkAlert({
                    text: 'El aporte no puede ser mayor al ingreso personal',
                    type: 'danger',
                    time: 10
                });
                $(this).val("")
            }
        });
    });
    
    $(function(){
        $('.panel-body').delegate( '.monto', 'keyup', function(){
        
            //const element=$(this);
            const value = $(this).val();
            $(this).val(formatNumber(value));
        });

        //suma los valores de los ingresos
        $(".contable_total_ingreso").change(function(){
            let suma=0;
            let data=$(".contable_total_ingreso");
            $.each(data, function(key, element) {
                suma+=Number(String(element.value).replace(/\D/g, ""));
            });
            $(".total_ingresos").val(Number(suma).toLocaleString());

            @if($current_user->inRole('admin'))
                $("#ingreso_neto").val(ingresoNeto($(".total_ingresos").val(),$(".total_egresos").val()));
            @endif
            
        });

        //suma los valores de los ingresos aportados
        $(".contable_total_aporte_ingreso").change(function(){
            let suma=0;
            let data=$(".contable_total_aporte_ingreso");
            $.each(data, function(key, element) {
                suma+=Number(String(element.value).replace(/\D/g, ""));
            });
            $(".total_aporte_ingresos").val(Number(suma).toLocaleString());

            @if($current_user->inRole('admin'))
                $("#ingreso_neto").val(ingresoNeto($(".total_ingresos").val(),$(".total_egresos").val()));
            @endif
            
        });

        //Agrega nuevo ingreso
        $(".add-ingreso").click(function () {
            var cloned = $(this).closest('.padre_ingreso').clone(true);        
            cloned.appendTo("#panel_ingreso").find('input').val('');
            //Se cuenta cuantos divs usan esa clase, si tiene mas de dos, no se coloca boton
            var numItems = $('div.last-child-ingreso').length;
            if (numItems <= 2) {
                cloned.find('div.last-child-ingreso').append('<button type="button" class="btn btn-danger rem-ingreso mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>');
            }
        });

        //Elimina nvo ingreso
        $(document).on('click', '.rem-ingreso', function (e) {
            $(this).parents("#panel_ingreso .row").remove();

            let suma=0;
            let data=$(".contable_total_ingreso");
            $.each(data, function(key, element) {
                suma+=Number(String(element.value).replace(/\D/g, ""));
                
            });
            $(".total_ingresos").val(Number(suma).toLocaleString());

            @if($current_user->inRole('admin'))
                $("#ingreso_neto").val(ingresoNeto($(".total_ingresos").val(),$(".total_egresos").val()));
            @endif
        });

        //suma los valores de los egresos
        $('.panel-body').delegate( '.contable_total_egreso', 'change', function(){
        
            let suma=0;
            let data=$(".contable_total_egreso");
            $.each(data, function(key, element) {
                        suma+=Number(String(element.value).replace(/\D/g, ""));
                        
                    });
            $(".total_egresos").val(Number(suma).toLocaleString());

            @if($current_user->inRole('admin'))
                $("#ingreso_neto").val(ingresoNeto($(".total_ingresos").val(),$(".total_egresos").val()));
            @endif
            
        });

        $(document).on('click', '.add-reporte', function (e) {

            fila_person = $(this).parents('#reportes-centrales').find('.row').eq(0).clone();
            fila_person.find('input').val('');
            fila_person.find(':selected').removeAttr('selected')
            fila_person.find('div.last-child-riesgo').append('<button type="button" class="btn btn-danger rem-reporte mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>');

            $('#reportes-centrales').append(fila_person);
        });

        $(document).on('click', '.rem-reporte', function (e) {
            
            $(this).parents('#reportes-centrales .row').remove();
        });

        // { Manejo de seccion de reporte central }
        $("#section-reportes").hide();

        if( $("#tiene_reportes_centrales_").prop('checked') ) {
             $("#section-reportes").show();
        }

        // verfica si esta en check y agrega prop required
        $("#tiene_reportes_centrales_").on("change", function () {
            $("#section-reportes").toggle('slow');

            if( $("#tiene_reportes_centrales_").prop('checked') ) {
                $('.reportes').attr("required", true);
            }else{
                $('.reportes').removeAttr("required");
            }
        });

        // { Manejo de seccion de creditos }
        $("#section-creditos").hide();

        if( $("#tiene_creditos_bancarios_").prop('checked') ) {
             $("#section-creditos").show();
        }

        // verfica si esta en check y agrega prop required
        $("#tiene_creditos_bancarios_").on("change", function () {
            $("#section-creditos").toggle('slow');

            if( $("#tiene_creditos_bancarios_").prop('checked') ) {
                $('.creditos').attr("required", true);
            }else{
                $('.creditos').removeAttr("required");
            }
        });

        $(document).on('click', '.add-credito', function (e) {

            fila_person = $(this).parents('#creditos-bancarios').find('.row').eq(0).clone();
            fila_person.find('input').val('');
            fila_person.find(':selected').removeAttr('selected')
            fila_person.find('div.last-child-credito').append('<button type="button" class="btn btn-danger rem-credito mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>');

            $('#creditos-bancarios').append(fila_person);
        });

        $(document).on('click', '.rem-credito', function (e) {

            $(this).parents('#creditos-bancarios .row').remove();
        });
    });

</script>