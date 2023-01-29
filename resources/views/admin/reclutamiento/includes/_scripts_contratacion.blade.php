<script type="text/javascript">

    function tipoIngresoChange(obj) {
        if(obj.value == "1"){
            document.querySelector('#fecha_fin_ultimo').setAttribute('hidden', true)
        }else{
            document.querySelector('#fecha_fin_ultimo').removeAttribute('hidden')
        }
    }

    $(function () {
        var confDatepicker2 = {
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
            yearRange: "1930:2050",
            minDate:new Date()
        };

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

        $('#table_users_no_contratados').DataTable({
            'stateSave': true,
            "lengthChange": false,
            "responsive": true,
            "paginate": true,
            "autoWidth": true,
            "searching": false,
            "order": [[1,"desc"]],
            "lengthMenu": [[3,10, 25, -1], [3,10, 25, "All"]],
            "language": {
              "url": '{{ url("js/Spain.json") }}'
            }
        });
    
        tipo = $("#tipo_ingreso").val();

        if(tipo == "1"){
            $("#fecha_fin_ultimo").hide();
        }else{
            $("#fecha_fin_ultimo").show();
        }

        $("#fecha_fin_contrato, #fecha_inicio_contratos, #fecha_inicio_contrato").datepicker(confDatepicker2);

        $("#fecha_ingreso_contra")
            .datepicker(calendarOptionChange)
            .on("change", function() {
                var fecha_ingreso = new Date($(this).val());
                fecha_ingreso.setFullYear(fecha_ingreso.getFullYear()+1);
                fecha_ingreso.setDate(fecha_ingreso.getDate() - 1);
                var fecha_fin_contrato = fecha_ingreso.toISOString().substring(0,10);

                $('#fecha_fin_contrato').val(fecha_fin_contrato);
            });

        jQuery(document).on('change', '#fecha_inicio_contrato', (event) => {
            const element = event.target;
        
            jQuery('#fecha_fin_contrato').datepicker('option', 'minDate', element.value);
        });

        var pass1 = $('[name=numero_cuenta]');
        var pass2 = $('[name=confirm_numero_cuenta]');
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
                document.querySelector('#confirmar_informacion_contratacion').disabled = true
            }
            
            if(valor1.length==0 || valor1==""){
                span.text(vacio).addClass('negacion');
                document.querySelector('#confirmar_informacion_contratacion').disabled = true  
            }

            /*if(valor1.length<6 || valor1.length>10){
                span.text(longitud).addClass('negacion');
            }*/

            if(valor1.length!=0 && valor1==valor2){
                span.text(confirmacion).removeClass("negacion").addClass('confirmacion');
                document.querySelector('#confirmar_informacion_contratacion').disabled = false
            }
        }
        
        //ejecuta la función al soltar la tecla
        pass2.keyup(function(){
            coincidePassword();
        });
    });
</script>