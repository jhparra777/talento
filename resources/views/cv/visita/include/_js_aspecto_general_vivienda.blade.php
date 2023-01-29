<script type="text/javascript">

    $( document ).ready(function() {
        var hipoteca = document.getElementById('viv_hipoteca').value;

        if (hipoteca == 'Sí') {
            $("#depend-hipoteca").show();
            $("#viv_valor_hipoteca").attr("required","required");
        } else {
            $("#depend-hipoteca").hide('slow');
            $("#viv_valor_hipoteca").removeAttr("required");
        }
    });

    $(function(){
        $("#viv_hipoteca").on("change", function () {
            if($(this).val()== 'Sí'){
                $("#depend-hipoteca").toggle('slow');
                $("#viv_valor_hipoteca").attr("required","required");
            }
            else{
                $("#depend-hipoteca").hide('slow');
                $("#viv_valor_hipoteca").removeAttr("required");
                $("#viv_valor_hipoteca").val('');
            }
        });
    });
</script>