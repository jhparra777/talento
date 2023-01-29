<script>
    $(function () {
        //Acción del botón guardar
        $("#guardar_datos_contacto").on("click", function () {
            if ($('#fr_datos_contacto').smkValidate()) {
                $("#guardar_datos_contacto").prop('disabled','disabled');

                var formData = new FormData(document.getElementById("fr_datos_contacto"));

                $.ajax({
                    type: "POST",
                    data: formData,
                    url: "{{ route('admin.ajax_actualizar_datos_contacto',$user_id) }}",
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#guardar_datos_contacto").prop('disabled', false);
                        $("#email-pre-registro").val(response.email);
                        $("#numero_id-pre-registro").val(response.numero_id);

                        //Se actualiza en la vista de informacion personal los datos de contacto modificados
                        $("#email").val(response.email);
                        $("#numero_id").val(response.numero_id);
                        $("#telefono_movil").val($("#telefono_movil-pre-registro").val());
                        $("#primer_nombre").val($("#primer_nombre-pre-registro").val());
                        $("#segundo_nombre").val($("#segundo_nombre-pre-registro").val());
                        $("#primer_apellido").val($("#primer_apellido-pre-registro").val());
                        $("#segundo_apellido").val($("#segundo_apellido-pre-registro").val());

                        $("#span-more-info").text($("#primer_nombre-pre-registro").val() + ' ' + $("#segundo_nombre-pre-registro").val() + ' ' + $("#primer_apellido-pre-registro").val() + ' ' + $("#segundo_apellido-pre-registro").val());

                        mensaje_success(response.mensaje_success);
                    },
                    error:function(data) {
                        $("#guardar_datos_contacto").prop('disabled', false);
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