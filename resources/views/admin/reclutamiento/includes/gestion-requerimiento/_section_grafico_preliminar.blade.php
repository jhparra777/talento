<div class="row">
    <div class="col-md-12">
          <div class="box box-solid">
            @if($grafica->count() != 0)
                <div class="col-md-12" id="ancla_req" style="height: 250px;">
                    @if($user_sesion->hasAccess("admin.informe_preliminar"))
                        <div class="box-body">
                            <div id="temps_div"></div>
                            {!! \Lava::render('LineChart', 'Temps', 'temps_div') !!}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Script para mostrar la grafica --}}
    <script type="text/javascript">
        function getpreliminar(event, chart) {
            let imagen_data = chart.getImageURI();
            $("#grupo_graficas").append($("<input/>", {name: "curva_de_ajuste_al_perfil", type: "HIDDEN", value: imagen_data}));
            $('#btnInfPrePdf').prop('disabled', false);
        }
    </script>
</div>