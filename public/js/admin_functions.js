
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
    yearRange: "1930:2050"
};

function conf_registro(campo_name, obj) {
    var checks = $("input[name='" + campo_name + "']:checked");
    if (checks.length == 0) {
        mensaje_success("Debe seleccionar un item de la tabla.");
    } else {
        var url = checks.eq(0).data("url");
        $(obj).attr("href", url);
        return true;
    }

    return false;
}

//Posible problemas con lista de checkbox
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

function redireccionar_registro(campo_name, obj, data_tag_url) {
    var checks = $("input[name='" + campo_name + "']:checked");

    if (checks.length == 0) {
        mensaje_success("Debe seleccionar un item de la tabla.");
    } else {
        var url = checks.eq(0).data(data_tag_url);
        $(obj).attr("href", url);

        return true;
    }

    return false;

}

$(function () {
    $(".menu a").on("click", function () {
        var padre = $(this).parents(".menu").find(".submenu");
        var data = $(this).data("submenu");

        $.each(padre, function (key, value) {
            var objHijo = $(value);
            var data_hijo = objHijo.attr("id");

            console.log($("#" + data_hijo + "").css("height"));

            if (data_hijo == data) {
                if ($("#" + data_hijo + "").css("height") == "auto") {
                    $("#" + data_hijo + "").css({height: "0"});     
                }else{
                    $("#" + data_hijo + "").css({height: "auto"});        
                }     
            }else {
                $("#" + data_hijo + "").css({height: "0"});     
            }
        });
    });

    $.fn.bootstrapSwitch.defaults.onColor = 'danger';
    $.fn.bootstrapSwitch.defaults.onColor = 'success';
    $.fn.bootstrapSwitch.defaults.onText = 'Si';
    $.fn.bootstrapSwitch.defaults.offText = 'No';
    $.fn.bootstrapSwitch.defaults.size = 'small';
    $('.checkbox-preferencias').bootstrapSwitch();

    /*RANGOS DE FECHA. Configuración para campos de rango de fechas, general,ente usados
    en reportes e indicadores. Solo se le debe colocar cla clase range al input
    */
   
    $(".range").attr("readonly",true);
    $('.range').daterangepicker({
        "autoApply": true,
        "autoUpdateInput": false,
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 Días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
            'Mes actual': [moment().startOf('month'), moment().endOf('month')],
            'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "locale": {
            "format": "YYYY-MM-DD",
            "separator": " | ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Personalizado",
            "weekLabel": "W",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Deciembre"
            ],
            "firstDay": 1
        }
    });

    $('.range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' | ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('.range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});

function mensaje_success(mensaje) {
    $("#modal_success #texto").html(mensaje);
    $("#modal_success").modal("show");
}

function mensaje_success_sin_boton(mensaje) {
    $("#modal_success_view #texto").html(mensaje);
    $("#modal_success_view").modal("show");
}

function mensaje_danger(mensaje) {
    $("#modal_danger #texto").html(mensaje);
    $("#modal_danger").modal("show");
}

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

    $(document).on('input','.input-number,.solo-numero',function () { 
        this.value = this.value.replace(/[^0-9]/g,'');
    });

    $(document).on('input','.numero-guion-letra',function () {
        var numeros = /^([0-9])/;
        var guion = /^\-/;
        var letra_numero = /^([kK0-9])/;
        var posicion = this.value.length - 1;

        if (this.value.length > 0) {
            if (!numeros.test(this.value[posicion]) && !guion.test(this.value[posicion]) && !letra_numero.test(this.value[posicion])) {
                this.value = this.value.replace(this.value[posicion], '');
            }
        }
    });

    $('.input-letras').on('input', function () { 
        this.value = this.value.replace(/[^a-zA-Z\s]/gi,'');
    });

    //para hacer q escriba hasta el maximo
    $(document).on('input', "[maxlength]", function (e) {
        e.preventDefault();

        //solo funciona con tipo number input
        var esto = $(this);
        esto.siblings('p').remove();
        var maxlength = $(this).attr('maxlength');
        var maxlengthint = parseInt(maxlength);
        var span = $('<p></p>').insertAfter(esto);
        span.css("color", "red");

        if(this.value.length > maxlengthint){
            this.value = this.value.slice(0,maxlengthint);
            span.show()
            span.html('No debe ser mayor a '+maxlengthint+' caracteres');
        }
    });
});

// Filtrar en tablas
const filterTable = (idInput, idTableBody) => {
    let filterInput = document.querySelector(`#${idInput}`).value.toUpperCase()
    let tableBody = document.querySelector(`#${idTableBody}`)
    let flag = false

    for (let row of tableBody.getElementsByTagName('tr')) {
        let cells = row.getElementsByTagName('td')

        for (let cell of cells) {
            if (cell.textContent.toLocaleUpperCase().indexOf(filterInput) > -1) {
                flag = true
                break
            }
        }

        if (flag) {
            row.style.display = ""
        }else {
            row.style.display = "none"
        }

        flag = false
    }
}