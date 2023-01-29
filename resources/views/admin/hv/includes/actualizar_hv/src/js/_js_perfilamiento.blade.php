<script>
    $(function () {

        $(".tag-cargo").on("change", function (e) {
                  e.preventDefault();
                
                buscar = $(this).val();
                buscar = buscar.trim();
               //console.log(buscar);
              
                $.ajax({
                    type: "POST",
                    data: {"_token": $('input[name="_token"]').val(),'txt-buscador-cargos':buscar},
                    url: "{{route('select_pefilamiento')}}",
                    beforeSend: function(){
                      $("#container_perfilamiento").html("<label text='text'> Buscando..... </label>");
                    },
                    success: function (response) {
                     console.log(response);
                      $("#container_perfilamiento").html(response).focus();
                    }
                }); //esperar tantos segundos para ejecutar la accion
              return false;
            });

        $("#guardar_perfil_seleccionado").on("click", function () {
            $.ajax({
                type: "POST",
                data: $("#guardar_perfil").serialize(),
                url: "{{ route('admin.ajax_guardar_perfil') }}",
                beforeSend: function() {
                    $("#guardar_perfil_seleccionado").prop('disabled','disabled');
                },
                success: function (response) {
                    $("#guardar_perfil_seleccionado").prop('disabled',false);
                    mensaje_success("Perfilamiento guardado correctamente.");
                    location.reload()
                    //$("#container_tab").html(response.view);
                }
            });
        });

        $(document).on("click", ".seleccionar_cargo", function () {
            var info = $(this).data();

            if ($(this).prop("checked")) {
                //VERIFICAR SI EL BLOQUE DEL TIPO CATEGORIA EXISTE
                var bloque;

                if ($("#bloque_" + info.cargo_id).length > 0) {//EXISTE EL BLOQUE
                    bloque = $("#bloque_" + info.cargo_id);
                } else {
                    //AGREGAR BLOQUE
                    bloque = $("<div></div>", {id: "bloque_" + info.cargo_id});
                    bloque.append($("<p></p>", {text: info.cargo_name, class: "set-general-font-bold title-seleccionados"}));
                    $("#cargos_seleccionados").append(bloque);
                }

                // agregar item cargo
                //VERIFICAR SI EL CARGO YA SE AGREGO
                if ($("#item_cargo_" + info.id).length <= 0) {
                    var cargo = $("<div></div>", {class: "flex-container-cargo-seleccionado", id: "item_cargo_" + info.id});
                    cargo.append($("<div></div>", {class: "flex-item-cargo-seleccionado-texto set-general-font", text: info.item_name}));
                    cargo.append($("<div></div>", {class: "flex-item-cargo-seleccionado-icon"}).append($("<i></i>", {class: "fa fa-times"})));
                    cargo.append($("<input />", {type: "hidden", name: "cargo_generico_id[]", value: info.id}));
                    bloque.append(cargo);
                }
            } else {
                $("#item_cargo_" + info.id).remove();
                //CALCULAR LA CANTIDAD DE ITEMS POR CATEGORIAS PARA ELIMINAR EL BLOQUE DE LA CATEGORIA
                var cantidad = $("#bloque_" + info.cargo_id + " ").children(".flex-container-cargo-seleccionado").length;

                if (cantidad == 0) {
                    $("#bloque_" + info.cargo_id + " ").remove();

                }
            }
        });

        $(document).on("click", ".flex-item-cargo-seleccionado-icon", function () {
            var padre = $(this).parents("div");
            var inputId = padre.children("input");
            $("#item_cargo_" + inputId.val()).remove();
            $(".seleccionar_cargo[value='" + inputId.val() + "']").prop("checked", false);
        });

        $("#btn_buscar_perfil").on("click", function () {
            $.ajax({
                type: "POST",
                data: $("#fr_busqueda").serialize(),
                url: "{{ route('busqueda_pefilamiento') }}",
                success: function (response) {

                    $("#container_perfilamiento").html(response);
                }
            })
        });
    });

</script>