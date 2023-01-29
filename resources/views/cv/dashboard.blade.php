@extends("cv.layouts.master")

<?php
    $porcentaje = FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
    //$porcentaje=$porcentaje["total"];
?>

@section("menu_candidato")
    @include("cv.includes.menu_candidato")
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

        .m-0{ margin: 0; }
        .m-1{ margin: 1rem; }
        .m-2{ margin: 2rem; }
        .m-3{ margin: 3rem; }
        .m-4{ margin: 4rem; }

        .ml-0{ margin-left: 0; }
        .ml-1{ margin-left: 1rem; }
        .ml-2{ margin-left: 2rem; }
        .ml-3{ margin-left: 3rem; }
        .ml-4{ margin-left: 4rem; }

        .mt-0{ margin-top: 0; }
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .mb-0{ margin-bottom: 0; }
        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .m-auto{ margin: auto; }

        /*Button success*/
        .btn-success{ color: #fff; background-color: {{ $sitio->color }}; border-color: {{ $sitio->color }}; }

        .btn-success[disabled] { background-color: {{ $sitio->color }}; border-color: {{ $sitio->color }}; }
        .btn-success:focus[disabled] { background-color: {{ $sitio->color }}; border-color: {{ $sitio->color }}; }
        .btn-success:hover { background-color: {{ $sitio->color }}; border-color: {{ $sitio->color }}; }
        .btn-success:focus { background-color: {{ $sitio->color }}; border-color: {{ $sitio->color }}; }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 all-categorie-list-title bt_heading_3">
                <h1>Bienvenido</h1>
                <div class="blind line_1"></div>
                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                <div class="blind line_2"></div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="dashboard_listing_blcok">
                    <div class="col-md-3 col-sm-6">
                        <div class="statusbox">
                            <h3  style="background-color: #2455e8;color: white;">% DATOS BÁSICOS</h3>
                            <div class="statusbox-content">
                                <p class="ic_status_item ic_col_one"><i class="fa fa-address-card-o"></i></p>
                                <h2>{{ $datosBasicos->datos_basicos_count }}%</h2>
                                <span>Completitud de tus datos básicos</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="statusbox">
                            <h3 style="background-color: #2455e8;color: white;">% @if(route("home")=="https://humannet.t3rsc.co")CURRÍCULO  @else HOJA DE VIDA @endif </h3>
                            <div class="statusbox-content">
                                <p class="ic_status_item ic_col_two"><i class="fa fa-black-tie"></i></p>
                                <h2>{{ $porcentaje["total"] }}%</h2>
                                <span>Completitud de tu hoja de vida</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="statusbox">
                            <h3 style="background-color: #2455e8;color: white;"><a href="{{route('mis_ofertas')}}#ofertas_aplicadas" style="color:white;">N° APLICACIONES</a></h3>
                            <div class="statusbox-content">
                                <p class="ic_status_item ic_col_three"><i class="fa fa-line-chart"></i></p>
                                <h2>{{ $total_aplicados }}</h2>
                                <span>Ofertas a las que has aplicado</span>
                            </div>
                        </div>
                    </div>

                    @if(route('home') == "http://soluciones.t3rsc.co")
                        <div class="col-md-3 col-sm-6">
                            <div class="statusbox">
                                <h3 style="background-color: #2455e8;color: white;">PROCESOS ACTIVOS</h3>
                                <div class="statusbox-content">
                                    <p class="ic_status_item ic_col_four"><i class="fa fa-cogs"></i></p>
                                    <h2>{{ $procesos_activos }}</h2>
                                    <span>Procesos activos en los que estas participando</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-3 col-sm-6">
                            <div class="statusbox">
                                <h3 style="background-color: #2455e8;color: white;"><a href="{{route('mis_ofertas')}}#ofertas_en_proceso" style="color:white;">PROCESOS ACTIVOS</a></h3>
                                <div class="statusbox-content">
                                    <p class="ic_status_item ic_col_four"><i class="fa fa-cogs"></i></p>
                                    <h2>{{ $procesos_activos }}</h2>
                                    <span>Procesos activos en los que estas participando</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class=row>
            <div class="col-md-12">
                <h3  class="h3-t3">Proceso Activo</h3>
                <div class="grid-container">


                     @if(is_null($ultimo_proceso_activo))
                        <div>
                            No está activo en ningun proceso actualmente.
                        </div>
                    @else
                        <div class="row">
                            <div class="recent-listing-box-container-item list-view-item" style="background: white;">
                                <div class="col-md-4 col-sm-12 nopadding feature-item-listing-item listing-item" style="background: white; height: 100%;border: none;">
                                    <div class="recent-listing-box-image">
                                        @if ($ultimo_proceso_activo->tipo_proceso_id == 7)
                                            <span class="proceso-backup" style="background: {{ $color_azul }} none repeat scroll 0 0;">
                                                PROCESO BACKUP
                                            </span>
                                        @endif

                                        <img src="{{ url( (($sitio->logo != "") ? "configuracion_sitio/$sitio->logo" : "img/personaDefectoG.jpg") )}}" alt="img1">
                                    </div>

                                    {{--<div class="hover-overlay">
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
                                    </div>--}}
                                </div>

                                <div class="col-md-8 col-sm-12 nopadding">
                                    <div class="recent-listing-box-item">
                                        <div class="listing-boxes-text {{ (($ultimo_proceso_activo->f_aplicacion != "") ? "oferta_aplicada" : "") }}">
                                            <h4> {{ ucfirst(mb_strtolower($ultimo_proceso_activo->cargo_especifico,'UTF-8')) }} </h4>
                                            <i class="fa fa-calendar-check-o"></i>{{ $ultimo_proceso_activo->fecha_publicacion }}
                                            <p>
                                                {!! str_limit($ultimo_proceso_activo->descripcion_oferta, 100) !!}
                                            </p>
                                        </div>

                                        <div class="recent-feature-item-rating">
                                            <h2><i class="fa fa-map-marker"></i> {{ $ultimo_proceso_activo->ciudad_seleccionada }}</h2>

                                            <a href="{{ route('home.detalle_oferta', ['id' => $ultimo_proceso_activo->cod_req]) }}" type="button" title="Detalle" class="detalle_ofert boton pull-right">
                                                <i class="fa fa-eye green-1"></i> Ver más
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3  class="h3-t3">Ofertas Disponibles</h3>

                <div class="grid-container">
                    {!! Form::open(["id" => "fr_aplicar"]) !!}
                        @if($ofertas->count() == 0)
                            <div>
                                No se encontraron ofertas que coincidan con tu perfil.
                            </div>
                        @endif

                        @if(route('home') == "http://soluciones.t3rsc.co")
                            @foreach($ofertas as $oferta)
                                <div class="row">
                                    <div class="recent-listing-box-container-item list-view-item">
                                        <div class="col-md-4 col-sm-12 nopadding feature-item-listing-item listing-item">
                                            <div class="recent-listing-box-image">
                                                @if ($oferta->tipo_proceso_id == 7) <h1> PROCESO BACKUP </h1> @endif
                                                <img src="{{ url( (($oferta->logo == "") ? "img/personaDefectoG.jpg" : "cliente_img/".$oferta->logo) )}}" alt="img1">
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
                                    <div class="recent-listing-box-container-item list-view-item" style="background: white;">
                                        <div class="col-md-4 col-sm-12 nopadding feature-item-listing-item listing-item" style="background: white; height: 100%;border: none;">
                                            <div class="recent-listing-box-image">
                                                @if ($oferta->tipo_proceso_id == 7) <span class="proceso-backup" style="background: {{ $color_azul }} none repeat scroll 0 0;"> PROCESO BACKUP </span> @endif
                                                <img src="{{ url( (($sitio->logo != "") ? "configuracion_sitio/$sitio->logo" : "img/personaDefectoG.jpg") )}}" alt="img1">
                                            </div>

                                            {{--<div class="hover-overlay">
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
                                            </div>--}}
                                        </div>

                                        <div class="col-md-8 col-sm-12 nopadding">
                                            <div class="recent-listing-box-item">
                                                <div class="listing-boxes-text {{ (($oferta->f_aplicacion != "")?"oferta_aplicada":"") }}">
                                                    <h4> {{ ucfirst(mb_strtolower($oferta->cargo_especifico,'UTF-8'))}} </h4>
                                                    <i class="fa fa-calendar-check-o"></i> {{ $oferta->fecha_publicacion }}
                                                    <p>
                                                        {!! str_limit($oferta->descripcion_oferta, 100) !!}
                                                    </p>
                                                </div>

                                                <div class="recent-feature-item-rating">
                                                    <h2><i class="fa fa-map-marker"></i> {{ $oferta->ciudad_seleccionada }}</h2>

                                                    <a href="{{ route('home.detalle_oferta', ['id' => $oferta->id]) }}" type="button" title="Detalle" class="detalle_ofert boton pull-right">
                                                        <i class="fa fa-eye green-1"></i> Ver más
                                                    </a>
                                                        
                                                    {!! FORM::hidden("id_oferta", "$oferta->id", ["class" => "id"]) !!}
                                                    
                                                    <button type="button" title="Aplicar" class="aplicar_oferta boton pull-right">
                                                        <i class="fa fa-check blue-1"></i> Aplicar
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

                    <p class="direction-botones-right mt-1">
                        <a type="button" href="{{ route("mis_ofertas") }}" class="btn btn-success">
                            <i class="fa fa-eye"></i>
                            MIS OFERTAS Y CITAS
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert para visita domiciliaria --}}

     @if (Session::has('no_visita'))
        <div class="modal" id="modal_informacion">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert-info">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Información</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{ Session::get('no_visita') }}</p>
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

    {{-- Alert para pruebas bryg --}}
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
    @elseif(Session::has('finalBryg') || Session::has('finalDigitacion'))
        {{ Session::forget('finalBryg') }}
        {{ Session::forget('finalDigitacion') }}

        <div class="modal" id="modal_informacion">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert-info">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Información</h4>
                    </div>
                    <div class="modal-body">
                        ¡Has terminado con éxito la prueba!, agradecemos tu participación.
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

    {{-- Modal con aceptación de políticas  --}}
    <style>
        .swal-overlay{ z-index: 1000; }
    </style>
    @php

     $politicaActual = $datosBasicos->politicaActual();

    @endphp

    @if ( !$politicaActual['acepto'] )

        @if ( $datosBasicos->politicasPrivacidad()->count() == 0 )
            <script>
                const msgModalPolities = "Para continuar con el uso de nuestra plataforma, debes aceptar nuestras políticas de privacidad. <a target='_blank' href='{{route('admin.aceptacionPoliticaTratamientoDatos', ['politica_id' => $politicaActual['politica_id']])}}'>Ver políticas</a>"
            </script>
        @elseif( $datosBasicos->politicasPrivacidad()->count() < $cantidad_politicas )
            <script>
                const msgModalPolities = "Hemos actualizado nuestra política de privacidad, para continuar con el uso de nuestra plataforma por favor haz clic en aceptar. <a target='_blank' href='{{route('admin.aceptacionPoliticaTratamientoDatos', ['politica_id' => $politicaActual['politica_id']])}}'>Ver políticas</a>"
            </script>
        @else
            <script>
                const msgModalPolities = "Para continuar con el uso de nuestra plataforma, debes aceptar nuestras políticas de privacidad. <a target='_blank' href='{{route('admin.aceptacionPoliticaTratamientoDatos', ['politica_id' => $politicaActual['politica_id']])}}'>Ver políticas</a>"
            </script>
        @endif
        <script>
            const p = document.createElement("p")
            p.innerHTML = msgModalPolities

            swal({
                title: "Políticas de privacidad",
                content: p,
                icon: "warning",
                buttons: true,
                buttons: ["Cancelar", "Aceptar"]
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        data: {
                            politica_id: "{{$politicaActual['politica_id']}}"
                        },
                        url: "{{ route('cv.privacyAccept') }}",
                        success: function (response) {
                            swal({
                                text: "Políticas aceptadas correctamente.",
                                icon: "success"
                            })
                        },
                        error: function (response) {
                            swal({
                                text: "Se ha presentado un error, intenta nuevamente.",
                                icon: "error"
                            })
                        }
                    });
                } else {
                    swal({
                        text: "Debes aceptar nuestras políticas de privacidad para continuar.",
                        icon: "error"
                    })

                    setTimeout(() => {
                        location.reload()
                    }, 2000)
                }
            });
        </script>
    @endif

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
                    url: "{{ route('detalle_oferta_modal') }}",
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
                    url: "{{ route('aplicar_oferta_post') }}",
                    success: function (response) {

                        $("#modal").modal("hide");

                        swal({
                            title: "¡Muy bien!",
                            text: "Has aplicado a la oferta laboral.",
                            icon: "success",
                            buttons: false
                        });

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
        })
    </script>
@stop
