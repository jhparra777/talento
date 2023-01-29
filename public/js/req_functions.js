$(function () {

    //CUANDO SE CARGA EL DOM 
    var link_activo = $("#menu_activo li[class='active']");
    if (link_activo.length > 0) {
        var objLi = link_activo.eq(0);

        var tag = objLi.find("a").data("id");
        $("#" + tag + " ol").addClass("active_submenu");

    }


    $(document).on("click", ".submenu", function () {
        $(".req_submenu").hide();
        var tag = $(this).data("id");
        $(this).parents("ul").find("li").removeClass("active");
        $(this).parents("li").addClass("active");
        console.log("asdf" + tag);
        $("#" + tag + " ol").addClass("active_submenu");
        $("#edit_cuenta").show();

    });


    $.fn.bootstrapSwitch.defaults.onColor = 'success';
    $.fn.bootstrapSwitch.defaults.onText = 'Si';
    $.fn.bootstrapSwitch.defaults.offText = 'No';
    $.fn.bootstrapSwitch.defaults.size = 'small';
    $('.checkbox-preferencias').bootstrapSwitch();


});
jQuery(document).ready(function () {
    jQuery('.solo_numeros').keypress(function (tecla) {
        console.log(tecla.charCode);
        if ((tecla.charCode < 48 || tecla.charCode > 57)&& tecla.charCode != 0)
            return false;
    });
});