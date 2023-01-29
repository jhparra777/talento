@extends("reclutamiento_externo.layout.master")
@section("menu_candidato")
    @include("reclutamiento_externo.layout.include.menu_reclutamiento")
@endsection

@section('content')

<?php
        $color_azul = "#01273A";
        if(isset(FuncionesGlobales::sitio()->color)) {
            if(FuncionesGlobales::sitio()->color != "") {
                $color_azul = FuncionesGlobales::sitio()->color;
            }
        }
    ?>
    <style>
        .swal2-popup {
            font-size: 1.6rem !important;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 all-categorie-list-title bt_heading_3">
                <h1>Bienvenido Reclutador</h1>
                <div class="blind line_1"></div>
                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                <div class="blind line_2"></div>
            </div>

        
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3  class="h3-t3">Ofertas Disponibles</h3>

                <div class="grid-container">
                    {!! Form::open(["id"=>"fr_aplicar"]) !!}
                        @if($ofertas->count() == 0)
                            <div>
                                No se encontraron ofertas en las cuales puedas reclutar.
                            </div>
                        @endif

                        @if(route('home') == "http://soluciones.t3rsc.co")
                            @foreach($ofertas as $oferta)
                                <div class="row">
                                    <div class="recent-listing-box-container-item list-view-item">
                                        <div class="col-md-4 col-sm-12 nopadding feature-item-listing-item listing-item">
                                            <div class="recent-listing-box-image">
                                                @if ($oferta->tipo_proceso_id == 7) <h1> PROCESO BACKUP </h1> @endif
                                                <img src="{{ url( (($oferta->logo == "") ? "img/personaDefectoG.jpg" : "recursos_clientes_logos/".$oferta->logo) )}}" alt="img1">
                                            </div>

                                            <div class="hover-overlay">
                                                <div class="hover-overlay-inner">
                                                    <ul class="listing-links">
                                                        <li>
                                                            <button type="button" title="Detalle" class="detalle_oferta">
                                                                <i class="fa fa-eye green-1"></i>
                                                            </button>
                                                            {!! FORM::hidden("id_oferta", "$oferta->id", ["class" => "id"]) !!}
                                                        </li>

                                                        <li>
                                                            <button type="button" title="Aplicar" class="aplicar_oferta">
                                                                <i class="fa fa-check blue-1"></i>
                                                            </button>
                                                            {!! FORM::hidden("id_oferta", "$oferta->id", ["class" => "id"]) !!}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-8 col-sm-12 nopadding">
                                            <div class="recent-listing-box-item">
                                                <div class="listing-boxes-text {{ (($oferta->f_aplicacion != "") ? "oferta_aplicada" : "") }}">
                                                    {{--<h3>{{ ucwords($oferta->nombre_cliente_req()) }} (COD-{{ $oferta->cod_req }})</h3>--}}
                                                    <i class="fa fa-calendar-check-o"></i> {{$oferta->fecha_publicacion}}
                                                    <p>
                                                        {!! str_limit($oferta->descripcion_oferta, 100) !!}
                                                    </p>
                                                </div>

                                                <div class="recent-feature-item-rating">
                                                    <h2><i class="fa fa-map-marker"></i> {{ $oferta->getUbicacionReq() }}</h2>

                                                    <button type="button" title="Detalle" class="detalle_oferta boton">
                                                        <i class="fa fa-eye green-1"></i> Ver más
                                                    </button>

                                                    {!! FORM::hidden("id_oferta", "$oferta->id", ["class" => "id"]) !!}
                                                    <button type="button" title="Aplicar" class="aplicar_oferta boton">
                                                        <i class="fa fa-check blue-1"></i> Aplicar
                                                    </button>
                                                    {!! FORM::hidden("id_oferta", "$oferta->id", ["class" => "id"]) !!}

                                                    <span>
                                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach($ofertas as $oferta)
                                <div class="row">
                                    <div class="recent-listing-box-container-item list-view-item">
                                        <div class="col-md-4 col-sm-12 nopadding feature-item-listing-item listing-item">
                                            <div class="recent-listing-box-image">
                                                @if ($oferta->tipo_proceso_id == 7) <span class="proceso-backup" style="background: {{ $color_azul }} none repeat scroll 0 0;"> PROCESO BACKUP </span> @endif
                                                <img src="{{ url( (($oferta->logo == "") ? "img/personaDefectoG.jpg" : "recursos_clientes_logos/".$oferta->logo) )}}" alt="img1">
                                            </div>

                                            <div class="hover-overlay">
                                                <div class="hover-overlay-inner">
                                                    <ul class="listing-links">
                                                        <li>
                                                            <button type="button" title="Detalle" class="detalle_oferta">
                                                                <i class="fa fa-eye green-1"></i>
                                                            </button>
                                                            {!! FORM::hidden("id_oferta", "$oferta->id", ["class" => "id"]) !!}
                                                        </li>
                                                        
                                                        <li>
                                                            <button type="button" title="Asociar" class="asociar_candidato">
                                                                <i class="fa fa-check blue-1"></i>
                                                            </button>
                                                            {!! FORM::hidden("id_oferta", "$oferta->id", ["class" => "id"]) !!}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-8 col-sm-12 nopadding">
                                            <div class="recent-listing-box-item">
                                                <div class="listing-boxes-text {{ (($oferta->f_aplicacion != "")?"oferta_aplicada":"") }}">
                                                    {{--<h3>{{ ucwords($oferta->nombre_cliente) }} (COD-{{ $oferta->cod_req }})</h3>--}}
                                                    <i class="fa fa-calendar-check-o"></i> {{ $oferta->fecha_publicacion }}
                                                    <p>
                                                        {!! str_limit($oferta->descripcion_oferta, 100) !!}
                                                    </p>

                                                    <ul style="list-style: none;font-size:.8em;">
                                                        <li>Vencimiento:{{$oferta->fecha_cierre_externo}} {{$oferta->hora_cierre_externo}}</li>
                                                        <li>HV $:{{$oferta->precio_hv}}</li>
                                                        <li>Cantidad:{{$oferta->cantidad_hv}}</li>
                                                    
                                                    </ul>
                                                </div>

                                                <div class="recent-feature-item-rating">
                                                    <h2><i class="fa fa-map-marker"></i> {{ $oferta->ciudad_seleccionada }}</h2>

                                                    <button type="button" title="Detalle" class="detalle_oferta boton">
                                                        <i class="fa fa-eye green-1"></i> Ver más
                                                    </button>
                                                        
                                                    {!! FORM::hidden("id_oferta", "$oferta->id", ["class" => "id"]) !!}
                                                    
                                                    <button type="button" title="Asociar" class="asociar_candidato detalle_oferta boton">
                                                        <i class="fa fa-check blue-1"></i> Asociar
                                                    </button>
                                                    
                                                    {!! FORM::hidden("id_oferta", "$oferta->id", ["class" => "id"]) !!}

                                                    {{--<span>
                                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i>
                                                    </span>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    {!! Form::close() !!}
                
                    {{--<p class="direction-botones-right">
                        <a type="button" href="{{route("mis_ofertas")}}" class="btn btn-defecto btn-peq boton"><i class="fa fa-eye"></i>&nbsp;
                            Ver todas las ofertas...
                        </a>
                    </p>--}}
                </div>
            </div>
        </div>
    </div>

    @if (Session::has('no_prueba'))
        <div class="modal" id="modal_informacion">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert-info">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Información</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{ Session::get('no_prueba') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(function () {
                $("#modal_informacion").modal("show");
            })
        </script>
    @endif

    <div class="modal" id="modal_success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Felicidades</h4>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="200">
                    <br><br>
                    <h4 class="animated bounce">¡Bienvenido/a a la familia!</h4>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            @if($showModal == true)
                $("#modal_success").modal("show");
            @endif

            window.history.pushState(null, "", window.location.href);        
            
            window.onpopstate = function() {
                window.history.pushState(null, "", window.location.href);
            };

            $(".detalle_oferta").on("click", function () {
                var objButton = $(this);
                id = objButton.parent().find("input").val();
                if(id){
                   $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{ route('detalle_oferta_modal_reclutamiento') }}",
                    success: function (response) {
                      $("#modal").find(".modal-content").html(response);
                      $("#modal").modal("show");
                    }
                   });
                }else{
                  alert("Algo salio mal, favor intentar nuevamente.");
                }
            });

            $(document).on("click", "#aplica_oferta_modal", function () {
                $(this).prop("disabled", true);
                $.ajax({
                    type: "POST",
                    data: $("#fr_oferta_modal").serialize(),
                    url: "{{ route('aplicar_oferta') }}",
                    success: function (response) {
                        alert("Has aplicado a la oferta laboral.");
                        $("#modal").modal("hide");
                        window.location.reload();
                    }
                });
            });
        
            $(document).on("click", ".aplicar_oferta", function () {
                var objButton = $(this);
                id = objButton.parent().find("input").val();
                
                if(id){
                    $.ajax({
                        type: "POST",
                        data: {"id":id},
                        url: "{{ route('verificar_oferta') }}",
                        success: function (response) {
                            $("#modal").find(".modal-content").html(response);
                            $("#modal").modal("show");
                        }
                    });
                }else{
                    alert("Algo salio mal, favor intentar nuevamente.");
                }
            });

            $(document).on("click", ".asociar_candidato", function () {
                var objButton = $(this);
                id = objButton.parent().find("input").val();
                
                if(id){
                    $.ajax({
                        type: "POST",
                        data: {"id":id},
                        url: "{{ route('reclutamiento_externo.asociar_candidato') }}",
                        success: function (response) {
                            $("#modal").find(".modal-content").html(response.view);
                            $("#modal").modal("show");
                        }
                    });
                }else{
                    alert("Algo salio mal, favor intentar nuevamente.");
                }
            });
        })
    </script>

@stop