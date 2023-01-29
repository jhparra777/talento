<?php
    $sitio = FuncionesGlobales::sitio();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta content="T3RS" name="author">
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{csrf_token()}}" name="token">
        
        <title>
            @if(isset($sitio->nombre))
                @if($sitio->nombre != "")
                    {{ $sitio->nombre }} - HV
                @else
                    Desarrollo | HV
                @endif
            @else
                Desarrollo | HV
            @endif
        </title>
        
        @if($sitio->favicon)
            @if($sitio->favicon != "")
                <link href="{{ url('configuracion_sitio')}}/{{$sitio->favicon }}" rel="shortcut icon">
            @else
                <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
            @endif
        @else
            <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
        @endif
       
        <script src="https://code.jquery.com/jquery-1.12.0.js" type="text/javascript"></script>
        <script src="{{ url('js/jquery-ui.js') }}" type="text/javascript"></script>
        
        <link href="{{asset('public/css/style.css')}}" rel="stylesheet"/>
        <link href="{{ url('css/jquery-ui.css') }}" rel="stylesheet"/>
        <script src="{{ asset('js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
        <link rel="stylesheet" href="{{ url("bower_components/timeTo/timeTo.css") }}">
        <link href="{{ asset('css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css"/>

        <script src="{{asset('js/app.js')}}"></script>
        <!--<script src="https://cdn.webrtc-experiment.com/MediaStreamRecorder.js"> </script>-->
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        {{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>--}}

        <script src="{{ asset('js/jQuery-Autocomplete-master/src/jquery.autocomplete.js') }}"></script>
        
        <script>
            $(function () {
                //SE UTILIZA ESTA VARIABLE PARA MENSAJES DE SOLO TEXTO
                @if (Session::has("mesaje_success"))
                    mensaje_success(" {{ Session::get('mesaje_success') }} ");
                @endif
                
                //SE UTILIZA ESTA VARIABLE PARA MENSAJES QUE RETORNAN UNA VIEW
                @if(Session::has("view_mesaje_success"))
                    $("#modal").modal("show");
                @endif

                $('[data-toggle="tooltip"]').tooltip()
            });
        </script>

        <script>
            $(function () {
                $.ajaxSetup({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                    }
                });
            });
        </script>

        <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link href="{{ url('public/css/animate.css') }}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="{{ route('generar_css_cv') }}"/>
        <link href="{{ url('public/css/responsive_style.css') }}" rel="stylesheet" type="text/css"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800%7CMontserrat:400,700" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet"/>
        <link href="{{ url('public/css/video_entrevista.css') }}" rel="stylesheet" type="text/css"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />

        {{-- SmokeJS - CSS --}}
        <link rel="stylesheet" href="{{ asset("js/smoke/css/smoke.min.css") }}">

        {{-- Cropper - CSS --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.min.css">

        {{-- Webcam JS - Pictures --}}
        <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>

        {{-- Cropper --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.min.js"></script>

        <style>
            #modal_polities{
                
                position: fixed;
                z-index: 2000;
            }

            .whatsapp-button{
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 99;
                background-color: #25d366;
                border-radius: 50px;
                color: #ffffff;
                text-decoration: none;
                width: 70px;
                height: 70px;
                font-size: 40px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                -webkit-box-shadow: 0px 0px 25px -6px rgba(0,0,0,1);
                -moz-box-shadow: 0px 0px 25px -6px rgba(0,0,0,1);
                box-shadow: 0px 0px 25px -6px rgba(0,0,0,1);
                animation: effect 5s infinite ease-in;
            }

            @keyframes effect {
                20%, 100% {
                    width: 70px;
                    height: 70px;
                    font-size: 40px;
                }
                0%, 10%{
                    width: 75px;
                    height: 75px;
                    font-size: 45px;
                }
                5%{
                    width: 70px;
                    height: 70px;
                    font-size: 40px;
                }
            }

            .btn-video{
               margin: .5em;
            }

            @media(max-width: 768px){
                .user-layout-candidato{
                    width: 70%;
                    margin: auto;
                }
                .instrucciones{
                    font-size:.8em!important;
                }
                .titulo-principal-seccion{
                    font-size:1.1em!important;
                    margin-top:50px!important;
                }
                .btn-video{
                    width: 90%;
                }
            }

            @media only screen and (max-width: 1200px){
                #nav_menu_list ul li a.cerrar-sesion-candidato{
                    padding: 10px 3px!important;
                }
            }
        </style>
    </head>
    <body>
        <div id="vfx_loader_block" style="display: none;">
            <div class="vfx-loader-item">
                <img alt="" src="{{ url('public/images/loading.gif') }}"/>
            </div>
        </div>

        <div id="logo-header">
            <div class="container">
                <div class="row">
                    <div style="position: relative; top: 20px;" class="col-sm-3 col-xs-9">
                        <a href="{{route('home')}}">
                            @if($sitio->logo)
                                @if($sitio->logo != "")
                                    <img alt="" height="60" src="{{ url('configuracion_sitio')}}/{{ $sitio->logo }}">
                                @else
                                    <img alt="" height="60" src="{{url('img/logo.png')}}">
                                @endif
                            @else
                                <img alt="" height="60" src="{{url('img/logo.png')}}">
                            @endif
                        </a>
                    </div>

                    <div class="col-sm-9 text-right">
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <button aria-expanded="false" class="navbar-toggle" data-target="#thrift-1" data-toggle="collapse" type="button">
                                    <span class="sr-only">
                                        Toggle Navigation
                                    </span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse" id="thrift-1">
                                <a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button"></a>
                                
                                <div id="nav_menu_list">
                                    <ul>
                                        <li>
                                            <a class="active" href="{{route('home')}}">
                                                Inicio
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{route('registrarse')}}">
                                                @if(route('home')=="https://expertos.t3rsc.co")
                                                    Registrar Datos
                                                @elseif(route("home")=="https://humannet.t3rsc.co")
                                                    Registrar Currículo
                                                @else
                                                    Registrar Hoja de Vida
                                                @endif
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{route('home')}}">
                                                @if(route('home')=="https://expertos.t3rsc.co")
                                                    Buscar Oportunidades
                                                @else
                                                    Buscar Empleo
                                                @endif
                                            </a>
                                        </li>

                                        <li>
                                            @if(isset($sitio->web_corporativa))
                                                @if($sitio->web_corporativa != "")
                                                    <a href="{{$sitio->web_corporativa }}" target="_blank">
                                                        Web Corporativa
                                                    </a>
                                                @else
                                                    <a href="http://desarrollo.t3rsc.co" target="_blank">
                                                        Web Corporativa
                                                    </a>
                                                @endif
                                            @else
                                                <a href="http://desarrollo.t3rsc.co" target="_blank">
                                                    Web Corporativa
                                                </a>
                                            @endif
                                        </li>

                                        <span class="btn_item cerrar-sesion-candidato">
                                            <li>
                                                <a href="{{route('logout_cv')}}" class="cerrar-sesion-candidato">
                                                    <i class="ti-lock"></i>
                                                    <i class="fa fa-sign-out"></i>
                                                    Cerrar Sesión
                                                </a>
                                            </li>
                                        </span>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            $user_gestion =Sentinel::getUser();
            $user = "";
            $foto = "";

            if (Sentinel::check()) {
                $registro = Sentinel::getUser();
                if ($registro->foto_perfil == null) {
                    $foto_social = $registro->avatar;
                } else {
                    $foto = $registro->foto_perfil;
                }
            }
        ?>

        <div class="white_bg_block" id="pricing-item-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="row">

                            <div class="col-md-3 col-sm-4 col-xs-12">
                               
                                <div id="leftcol_item">
                                    <div class="user_dashboard_pic user-layout-candidato">
                                        @if($foto != null)
                                            <img alt="user photo" src="{{ url('recursos_datosbasicos/'.$foto)}}">
                                        @elseif($foto_social != null)
                                            <img alt="user photo" src="{{ $foto_social }}">
                                        @else
                                            <img alt="user photo" src="{{ url('img/personaDefectoG.jpg')}}">
                                        @endif
                                        
                                        <span class="user-photo-action">
                                            Hola, {{ ucwords(strtolower($registro->name)) }}
                                        </span>
                                        </img>
                                        </img>
                                        </img>
                                    </div>
                                    <div class="container" style="width: 100%;">
                                        <?php
                                            $porcentaje=FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
                                            //$porcentaje=$porcentaje["total"];

                                        ?>
                                       

                                      <h4 style="font-family: ">% Hoja de Vida</h4> 
                                      <div class="progress" style="width: 100%;border:2px solid rgb(230,230,230); height: 30px;">
                                        <div class="progress-bar @if($porcentaje<=5) progress-bar-danger @elseif($porcentaje<100) progress-bar-warning @else progress-bar-success @endif" role="progressbar" aria-valuenow="{{$porcentaje['total']}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$porcentaje['total']}}%">
                                         {{ $porcentaje['total']}}%
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="navbar-header">
                                    <button aria-expanded="false" class="navbar-toggle btn btn-default" data-target="#menu_candidato" data-toggle="collapse" type="button" style="width: 75%;padding: 1em;float: none;font-size:1.5em;background: #f9f9f9;border: 1px solid #efefef!important;">
                                        Menú
                                        <span class="caret"></span>
                                        
                                        <!--<span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>-->
                                    </button>
                                </div>
                                <div class="collapse navbar-collapse" id="menu_candidato">
                                <a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" style="display: block!important;background: "></a>

                                    <div class="dashboard_nav_item">
                                        @yield("menu_candidato")
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <div id="dashboard_listing_blcok">
                                    @yield("content")
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Valida variable de sesión para aplicar a la oferta --}}
        @if(Session::has("req_preg_resp")  && Session::get("req_preg_resp") != "")
            <div aria-labelledby="myModalLabel" class="modal fade" id="modal_req_preg_resp" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        {!! FuncionesGlobales::aplica_oferta_pregunta(Session::get("req_preg_resp")) !!}
                    </div>
                </div>
            </div>

            <script>
                $(function(){
                    $("#modal_req_preg_resp").modal("show");
                });
            </script>
        @endif

        {{-- Valida variable de sesión para aplicar a la oferta --}}
        @if(Session::has("no_aplica")  && Session::get("no_aplica") != "")
            <div aria-labelledby="myModalLabel" class="modal fade" id="modal_no_aplica" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">
                                <span class="fa fa-briefcase "></span> Información
                            </h4>
                        </div>

                        <div class="modal-body">
                            <div class="alert alert-success">
                                <p>Gracias por aplicar a nuestra oferta.</p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(function(){
                    $("#modal_no_aplica").modal("show");
                });
            </script>
        @endif

        @if(Session::has("req_aplica_oferta")  && Session::get("req_aplica_oferta") != "")
            <div aria-labelledby="myModalLabel" class="modal fade" id="modal_oferta_externa" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        {!! FuncionesGlobales::aplica_oferta_externa(Session::get("req_aplica_oferta")) !!}
                    </div>
                </div>
            </div>

            <script>
                $(function(){
                    $("#modal_oferta_externa").modal("show");
                });
            </script>
        @endif

        @if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'https://pruebaslistos.t3rsc.co' || route('home') == 'http://localhost:8000')
            <a target="_blank" title="¿Necesitas ayuda?" href="https://wa.me/573122029919?texto=Buen%20día,%20soy%20usuario%20de%20Listos%20tengo%20algunas%20dudas.%20Me%20podrian%20brindar%20soporte,%20gracias." class="whatsapp-button"><i class="fa fa-whatsapp"></i></a>
        @endif

        @include('footer')

        <div class="modal fade" id="modal_peque" >
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
        </div>

        <div class="modal fade" id="modal_gr">
            <div class="modal-dialog modal-lg">
                <div class="modal-content"></div>
            </div>
        </div>

        <div class="modal" id="modal_success_view">
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
        </div>

        <div class="modal" id="modal_success">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert-info">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"><span class="fa fa-check-circle "></span> Confirmación</h4>
                    </div>
                    <div class="modal-body" id="texto"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal" id="modal_danger_view">
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
        </div>

        <div class="modal" id="modal_danger">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"><span class="fa fa-times"></span> Advertencia</h4>
                    </div>
                    <div class="modal-body" id="texto"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div aria-labelledby="myModalLabel" class="modal fade" id="modal" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    @if(Session::has("view_mesaje_success"))
                        {!! Session::get("view_mesaje_success") !!}
                    @endif
                </div>

            </div>
        </div>

        <div aria-labelledby="myModalLabel" class="modal fade" id="modal2" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content"></div>
            </div>
        </div>

        {{-- Modal con políticas --}}
        <div class="modal" id="modal_polities">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert-info">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"><span class="fa fa-info-circle "></span> {{--Políticas de protección de datos--}}
                            {!! $politica->titulo !!}</h4>
                    </div>

                    <div class="modal-body">
                        <div style="color: black; text-align:  justify; line-height: 1.6rem; font: 12px arial;">
                            {!! $politica->texto !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
		$.widget.bridge('uibutton', $.ui.button);
		$(document).ready(function() {});
	</script>

        <!--<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>-->
        <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
        {{-- <script src="{{ asset('js/ga.js') }}" type="text/javascript"></script> --}}
        
        <script src="{{ asset('public/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/js/jquery_custom.js') }}" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

        {{-- SmokeJS --}}
        <script src="{{ asset("js/smoke/js/smoke.min.js") }}"></script>
        {{-- SmokeJS - Language --}}
        <script src="{{ asset("js/smoke/lang/es.min.js") }}"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $(window).scroll(function(){
                    if ($(this).scrollTop() > 100) {
                        $('.scrollup').fadeIn();
                    } else {
                        $('.scrollup').fadeOut();
                    }
                });
                
                $('.scrollup').click(function(){
                    $("html, body").animate({ scrollTop: 0 }, 600);
                    return false;
                });     

                //Modal Cargar HV
                $(".cargar_hv").on("click", function () {
                    prueba = "prueba";
                    $.ajax({
                        type: "POST",
                        data: "cliente_id=" + prueba,
                        url: "{{ route('cargar_hv') }}",
                        success: function (response) {
                            $("#modal2").find(".modal-content").html(response);
                            $("#modal2").modal("show");
                        }
                    });
                });
            });
        </script>
    </body>
</html>
