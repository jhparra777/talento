
<!-- Inicio contenido principal -->
<div class="col-right-item-container">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row buscador-cargos">
                <label class="col-md-3 control-label">Busca tu profesión :</label>
                <div class="col-md-6">
                    {!! Form::open(["id"=>"fr_busqueda","onsubmit"=>"return false"]) !!}
                    <input type="text" name="txt-buscador-cargos" id="txt-buscador-cargos" class=""/>
                    <button type="button"  class="" name="btn-buscar-perfil" id="btn_buscar_perfil"><i class="fa fa-search"></i>
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        {!! Form::open(["route"=>"guardar_perfilamiento"]) !!}
        @if(Session::has("mensaje"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get("mensaje")}}
            </div>
        </div>
        @endif
        <div class="col-md-8">
            <p class="direction-botones-left">
                @foreach($tipo_cargos as $tipo_cargo)
                <a href="#cargos-{{$tipo_cargo->id}}" class="btn btn-defecto btn-peq">{{$tipo_cargo->descripcion}}</a>

                @endforeach
            </p>

            <div id="container_perfilamiento">
                @foreach($tipo_cargos as $tipo_cargo)

                <div class="col-md-12">
                    <h3 class="header-section-form" id="cargos-{{$tipo_cargo->id}}">{{$tipo_cargo->descripcion}}</h3>
                    @foreach($tipo_cargo->cargosActivos() as $cargo)
                    <div class="checkbox-container-cargos">
                        <label>
                            <input {{((in_array($cargo->id,$items_cargos))?"checked":"")}}  value="{{$cargo->id}}" type="checkbox" name="cargos[]" class="seleccionar_cargo" data-cargo_name="{{$tipo_cargo->descripcion}}" data-cargo_id="{{$tipo_cargo->id}}" data-item_name="{{$cargo->descripcion}}" data-id="{{$cargo->id}}"> {{$cargo->descripcion}}
                        </label>
                    </div>
                    @endforeach

                </div>
                @endforeach
            </div>

            <div class="col-md-12 separador"></div>
            <p class="direction-botones-center">
                <button class="btn btn-primario btn-gra" type="submit"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
            </p>

        </div>
        <div class="col-md-4" id="cargos_seleccionados">
            <p class="set-general-font-bold title-seleccionados">Cargos Seleccionados&nbsp;<i class="fa fa-check-square-o"></i>
            </p>

            @foreach($cargos_seleccionados as $key => $cargo)
            <div id="bloque_{{$key}}">
                <p class="set-general-font-bold title-seleccionados">{{$cargo["name"]}}</p>
                @foreach($cargo["item"] as $item =>$value_item)

                <div id="item_cargo_{{$item}}" class="flex-container-cargo-seleccionado">
                    <div class="flex-item-cargo-seleccionado-texto set-general-font">{{$value_item}}</div>
                    <div class="flex-item-cargo-seleccionado-icon"><i class="fa fa-times"></i></div>
                    <input type="hidden" name="cargo_generico_id[]" value="{{$item}}">
                </div>
                @endforeach
            </div>

            @endforeach

        </div>
        {!! Form::close() !!}
    </div><!-- /.container -->
</div>
<!-- Fin contenido principal -->
<script>

    $(function () {
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

