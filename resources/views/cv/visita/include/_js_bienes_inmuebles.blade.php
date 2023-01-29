<script>

    $(document).ready(function() {
        $(".js-select2").select2({
            dropdownAutoWidth : true,
            closeOnSelect: true
        });
    });

    $(function(){

        // {Seccion de inmuebles}
        $("#section-inmuebles").hide();
        if( $("#tiene_bienes_inmuebles_").prop('checked') ) {
             $("#section-inmuebles").show();
        }
        $("#tiene_bienes_inmuebles_").on("change", function () {
            $("#section-inmuebles").toggle('slow');

            if( $("#tiene_bienes_inmuebles_").prop('checked') ) {
                $('.inmuebles').attr("required", true);
            }else{
                $('.inmuebles').removeAttr("required");
            }
        });

        $(document).on('click', '.add-inmueble', function (e) {

            $('.js-select2').select2("destroy");
            fila_person = $(this).parents('#inmuebles').find('.row').eq(0).clone(true);
            fila_person.find('input').val('');
            fila_person.find(':selected').removeAttr('selected')
            fila_person.find('div.last-child-inmueble').append('<button type="button" class="btn btn-danger rem-inmueble mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>');

            $('#inmuebles').append(fila_person);
            $(".js-select2").select2({
                dropdownAutoWidth : true,
                closeOnSelect: true
            })
        });

        $(document).on('click', '.rem-inmueble', function (e) {

            $(this).parents('#inmuebles .row').remove();
        });

        // {Seccion de vehiculos}
        $("#section-vehiculos").hide();
        if( $("#tiene_vehiculos_").prop('checked') ) {
             $("#section-vehiculos").show();
        }
        $("#tiene_vehiculos_").on("change", function () {
            $("#section-vehiculos").toggle('slow');

            if( $("#tiene_vehiculos_").prop('checked') ) {
                $('.vehiculos').attr("required", true);
            }else{
                $('.vehiculos').removeAttr("required");
            }
        });

        $(document).on('click', '.add-vehiculo', function (e) {

            fila_person = $(this).parents('#vehiculos').find('.row').eq(0).clone();
            fila_person.find('input').val('');
            fila_person.find(':selected').removeAttr('selected')
            fila_person.find('div.last-child-vehiculo').append('<button type="button" class="btn btn-danger rem-vehiculo mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>');

            $('#vehiculos').append(fila_person);
        });

        $(document).on('click', '.rem-vehiculo', function (e) {
            $(this).parents('#vehiculos .row').remove();
        });

    });
</script>