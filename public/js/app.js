/* js */
var confDatepicker = {
    altFormat: "yy-mm-dd",
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    buttonImage: "img/gifs/018.gif",
    buttonImageOnly: true,
    maxDate: new Date(),
    autoSize: true,
    dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
    monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
    yearRange: "1930:2050"
};

function rangoCalendarios(fecha_inicio_id, fecha_fin_id) {
    //console.log(confDatepicker);
    var fecha1 = confDatepicker;
    fecha1.onClose = function (selectedDate) {
        $("#" + fecha_fin_id + "").datepicker("option", "minDate", selectedDate);
    };
    $("#" + fecha_inicio_id + "").datepicker(fecha1);
    var fecha2 = confDatepicker;
    fecha2.onClose = function (selectedDate) {

        if (selectedDate == "") {
            $("#" + fecha_inicio_id + "").datepicker("option", "maxDate", new Date());
        } else {
            $("#" + fecha_inicio_id + "").datepicker("option", "maxDate", selectedDate);
        }

    };

    $("#" + fecha_fin_id + "").datepicker(fecha2);
}
function seleccionarLista() {
    var campos = $("[type=radio]");
    var checkBox = 0;

    $.each(campos, function (key, value) {
        if ($(value).prop("checked")) {
            checkBox++;
        }
    });
    if (checkBox > 0) {

        return true;
    } else {
        alert("Debe seleccionar un item de la tabla");
        return false;
    }

}
function mensaje_success(mensaje) {
    $("#modal_success #texto").html(mensaje);
    $("#modal_success").modal("show");

}

function mensaje_danger(mensaje) {
    $("#modal_danger #texto").html(mensaje);
    $("#modal_danger").modal("show");
}

function mensaje_danger_view(mensaje) {
    alert("a");
    $("#modal_danger_view .modal-content").html(mensaje);
    $("#modal_danger_view").modal("show");

}

function mensaje_success_view(mensaje) {
    alert("a");
    $("#modal_success_view .modal-content").html(mensaje);
    $("#modal_success_view").modal("show");

}
$(window).resize(function(){
    if ($(window).width() > 700){  
        $("#menu_cv").show();
    }else{
        $("#menu_cv").hide();
    }   
});
$(function () {
    $("#menu_responsive").on("click",function(){
        $("#menu_cv").slideToggle();
    });


    $('#close-left-menu').click(function () {
        $('.left-menu').css('width', '80px');
        $('#close-left-menu').hide();
        $('.flex-container').hide();
        $('.menu-iconos').show();
        $('.div-expand-left-menu').show();
        $('.col-left-item-container').css("flex", "1 0 80px");
        //alert(objWidth);
    });
    $('.div-expand-left-menu').click(function () {
        $('.left-menu').css('width', '327px');
        $('#close-left-menu').show();
        $('.flex-container').show();
        $('.menu-iconos').hide();
        $(this).hide();
        $('.col-left-item-container').css("flex", "1 0 327px");
    });
    /* inicializar popover */

    /*$('[data-toggle="popover"]').popover({
     html:true,
     trigger:'focus',
     placement:'bottom',
     content:function(){
     return $($(this).data('contentwrapper')).html();
     }
     
     });*/
    /* opcion1 */
    $.fn.bootstrapSwitch.defaults.onColor = 'danger';
    $.fn.bootstrapSwitch.defaults.onColor = 'success';
    $.fn.bootstrapSwitch.defaults.onText = 'Si';
    $.fn.bootstrapSwitch.defaults.offText = 'No';
    $.fn.bootstrapSwitch.defaults.size = 'small';
    $('.checkbox-preferencias').bootstrapSwitch();

});
jQuery(document).ready(function () {
    jQuery('.solo_numeros').keypress(function (tecla) {
        console.log(tecla.charCode);
        if ((tecla.charCode < 48 || tecla.charCode > 57) && tecla.charCode != 0)
            return false;
    });

    $(document).on("keypress", ".solo_numeros", function (tecla) {
        console.log(tecla.charCode);
        if ((tecla.charCode < 48 || tecla.charCode > 57) && tecla.charCode != 0)
            return false;
    });

    $('.input-number').on('input', function () { 
     this.value = this.value.replace(/[^0-9]/g,'');
    });

    
    $(document).on('input', "[maxlength]", function (e) {
                e.preventDefault();
//solo funciona con tipo number input
           var esto = $(this);
           esto.siblings('p').remove();
           var maxlength = $(this).attr('maxlength');
           var maxlengthint = parseInt(maxlength);
           var span = $('<p></p>').insertAfter(esto);
           span.css("color", "red");
            //console.log(esto);
             // esto.find('p').html('');
            if(this.value.length > maxlengthint){
              this.value = this.value.slice(0,maxlengthint);
              span.show()
              span.html('No debe ser mayor a '+maxlengthint+' caracteres');
            }
    });

    $(document).on('input','.input-number,.solo-numero',function () { 
        this.value = this.value.replace(/[^0-9]/g,'');
    });

    /*$(".solo-numero").keydown(function(event) {

       if(event.shiftKey)
       {
            event.preventDefault();
       }

       if (event.keyCode == 46 || event.keyCode == 8)    {
       }
       else {
            if (event.keyCode < 95) {
              if (event.keyCode < 48 || event.keyCode > 57) {
                    event.preventDefault();
              }
            } 
            else {
                  if (event.keyCode < 96 || event.keyCode > 105) {
                      event.preventDefault();
                  }
            }
          }
       });*/
    
});