@extends("cv.layouts.master")
<?php
    $porcentaje=FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
                                            //$porcentaje=$porcentaje["total"];
?>
@section("menu_candidato")
 @include("cv.includes.menu_candidato")
@endsection
@section('content')

    <!-- Inicio contenido principal -->
    <div class="col-right-item-container">
        <div class="container-fluid">
            <div class="col-md-12 all-categorie-list-title bt_heading_3">
              <h1>Perfil Laboral</h1>
                <div class="blind line_1"></div>
                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                <div class="blind line_2"></div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
             <div id="submit_listing_box">
              <p>
                Por favor indícanos en el buscador una palabra clave que identifique la profesión o labor en la cual te vas a desempeñar y luego selecciona los cargos que más se ajusten a tu perfil.
                </br>
                Procura ser lo más sensato posible, recuerda que de la precisión de tu perfilamiento depende que los especialistas en selección te asocien a sus procesos!  
              </p>
                
                  <div class="form-alt">
                    <div class="row">
                            {!! Form::open(["route"=>"guardar_perfilamiento", "id" => "fr_perfilamiento"]) !!}                        
                                @if(Session::has("mensaje"))
                                    <div class="col-md-12" id="mensaje-resultado">
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          {{Session::get("mensaje")}} 
                                        </div>
                                    </div>

                                @endif

                                <div class="col-md-8">

                                  <div class="form-group col-sm-12 col-lg-12">
                                   <label for="ocupacion">
                                    Seleccione el área: <span class='text-danger sm-text-label'>*</span>
                                    </label>
                                     <select class="form-control tag-cargo col-md-8 col-sm-8" id="tag-cargo" name="tipo_cargo" required="required">
                                      <option value=""> Seleccione... </option>
                                      @foreach($tipo_cargos as $tipo_cargo)
                                       <option value="{{$tipo_cargo->id}}">
                                        {{$tipo_cargo->descripcion}}
                                       </option>
                                      @endforeach
                                     </select>
                                 </div>

                                  <div class="form-group col-sm-12 col-lg-12">
                                     <label for="ocupacion">
                                      Seleccione cargo: <span class='text-danger sm-text-label'>*</span>
                                     </label>
                                       <select class="form-control col-md-8 col-sm-8" id="container_perfilamiento" name="cargo_generico_id[]" required="required">
                                        <option value="">Seleccione....</option>
                                       </select>
                                   </div>

                                    

                                    <div class="col-md-12 separador"></div>
                                    <p class="direction-botones-center">
                                        <button class="btn-quote" type="submit"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                                    </p>
                                </div>

                                <div class="col-md-4" id="cargos_seleccionados">
                                  <p class="set-general-font-bold title-seleccionados">Cargos Seleccionados&nbsp;<i class="fa fa-check-square-o"></i></p>

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

                                   <div class="col-md-12 separador"></div>
                                    <p class="direction-botones-center">
                                     <button class="btn-quote" type="button" id="eliminando"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                                    </p>
                                </div>
                            {!! Form::close() !!}
                        </div><!-- /.container -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin contenido principal -->

    <script>
        $(function () {

            $(document).on("click", "#eliminando", function() {

                $("#tag-cargo").removeAttr("required")

                $("#container_perfilamiento").removeAttr("required")

                $("#fr_perfilamiento").submit();
            })

            $(document).on("click", ".seleccionar_cargo", function () {
                
                var info = $(this).data();

                if ($(this).prop("checked")) {

                    //VERIFICAR SI EL BLOQUE DEL TIPO CATEGORIA EXISTE
                    var bloque;
                    
                    if($("#bloque_" + info.cargo_id).length > 0) {
                        //EXISTE EL BLOQUE
                        bloque = $("#bloque_" + info.cargo_id);
                    }else{
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

                }else{

                    $("#item_cargo_" + info.id).remove();
                     //CALCULAR LA CANTIDAD DE ITEMS POR CATEGORIAS PARA ELIMINAR EL BLOQUE DE LA CATEGORIA
                     var cantidad = $("#bloque_" + info.cargo_id + " ").children(".flex-container-cargo-seleccionado").length;

                    if(cantidad == 0) {
                     $("#bloque_" + info.cargo_id + " ").remove();
                    }
                }
            });

            $(document).on("click", ".flex-item-cargo-seleccionado-icon", function () {
               padre = $(this).parents("div");
               inputId = padre.children("input");
              
               $("#item_cargo_" + inputId.val()).remove();
               $(".seleccionar_cargo[value='" + inputId.val() + "']").prop("checked", false);
            });

            //buscador de perfiles...... y mostrarlo
            $("#txt-buscador-cargos").on("input", function () {
               setTimeout(function(){ 
                $.ajax({
                    type: "POST",
                    data: $("#fr_busqueda").serialize(),
                    url: "{{route('busqueda_pefilamiento')}}",
                    beforeSend: function(){
                      $("#container_perfilamiento").html("<label text='text'> Buscando..... </label>");
                    },
                    success: function (response) {  
                      $("#container_perfilamiento").html(response).focus();
                    }
                })}, 2000); //esperar tantos segundos para ejecutar la accion
            });

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

        });
    </script>
@stop
