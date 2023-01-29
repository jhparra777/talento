<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @if(isset($sitio->nombre))
            @if($sitio->nombre != "")
                {{ $sitio->nombre }} - Cliente
            @else
                Desarrollo | Cliente
            @endif
        @else
            Desarrollo | Cliente
        @endif
    </title>

    @if(isset($sitio->favicon))
        @if($sitio->favicon != "")
            <link href="{{ url('configuracion_sitio')}}/{{ $sitio->favicon }}" rel="shortcut icon">
        @else
            <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
        @endif
    @else
       <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
    @endif

    <script src="https://apis.google.com/js/platform.js" async defer></script>
	<script src="https://code.jquery.com/jquery-1.12.0.js" type="text/javascript"></script>
	<script src="{{ url("js/bootstrap-switch.min.js") }}" type="text/javascript"></script>
	<link href="{{ asset("css/bootstrap-switch.min.css") }}" rel="stylesheet" type="text/css"/>

	<script type="text/javascript" src="{{ url("js/jquery-ui.js") }}"></script>
	<link href="{{ url("css/jquery-ui.css") }}" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}

	<link href="{{ url("css/jquery-te-1.4.0.css") }}" type="text/css" rel="stylesheet">
	<link href="{{ asset("css/chosen.css") }}" type="text/css" rel="stylesheet">
	<link href="{{ asset("css/checkboxs.css") }}" type="text/css" rel="stylesheet">
	
	<script src="{{ asset("js/jQuery-Autocomplete-master/src/jquery.autocomplete.js") }}"></script>

	<script src="{{ asset("js/chosen.jquery.js") }}"></script>
	<script src="{{ asset("js/Chart.min.js")}}"></script>
	<script src="{{ asset("js/multiselect.min.js") }}"></script>
	<link href="{{ asset("css/multiselect.css") }}" type="text/css" rel="stylesheet">

	{{--
		<script src="https://cdn.webrtc-experiment.com/MediaStreamRecorder.js"> </script>

  		<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
		<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
	--}}

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.jqueryui.min.css">

  	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      {{-- Chart JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

	<script src="{{ asset("js/admin_functions.js") }}"></script>
	<script src="{{ asset("js/jquery-te-1.4.0.min.js") }}"></script>

	{{--
		<script src="https://cdn.webrtc-experiment.com/MediaStreamRecorder.js"> </script>

  		<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
		<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
	--}}

  	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

	<script src="{{ asset("js/admin_functions.js") }}"></script>
	<script src="{{ asset("js/jquery-te-1.4.0.min.js") }}"></script>

    {{-- Js for views --}}
	<script src="{{ asset('js/gestion-requerimiento.js') }}"></script>
    <meta name="token" content="{{ csrf_token() }}"/>

    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                }
            });

            $(".submenu_padre").on("click", function () {
                var id = $(this).data("id");
                $(this).parents("ul").find("li").removeClass("active");
                $(this).parents("li").addClass("active");
                $.ajax({
                    type: "POST",
                    data: {"padre_id": id},
                    url: "{{ route('req.cargar_menu') }}",
                    success: function (response) {
                        $(".req_submenu").hide();
                        var obj = $("#submenu_ajax ol").html("");
                        $.each(response, function (key, value) {
                            var li = $("<li></li>");
                            var a = $("<a></a>", {html: value.icono + value.nombre_menu, href: value.ruta});

                            li.append(a);
                            obj.append(li);
                        });
                        obj.addClass("active_submenu");
                        $("#submenu_ajax").show();
                    }
                });
            });

            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>

 	<!-- Bootstrap 3.3.7 -->
  	<link rel="stylesheet" href="{{ url("bower_components/bootstrap/dist/css/bootstrap.min.css") }}">
  	<link rel="stylesheet" href="{{ url("bower_components/select2/dist/css/select2.min.css") }}">
	  
	<!-- Font Awesome -->
  	<!--<link rel="stylesheet" href="{{ url("bower_components/font-awesome/css/font-awesome.min.css") }}">-->
	  
	  <!-- Ionicons -->
  	<link rel="stylesheet" href="{{ url("bower_components/Ionicons/css/ionicons.min.css") }}">
	  
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ url("dist/css/AdminLTE.min.css") }}">
	
    {{-- TRI Custom styles --}}
	<link rel="stylesheet" href="{{ asset('assets/css/tri-custom-styles.css') }}">

	<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="{{ url("dist/css/skins/_all-skins.min.css") }}">

	<!-- Morris chart -->
	<link rel="stylesheet" href="{{ url("bower_components/morris.js/morris.css") }}">

	<!-- jvectormap -->
	<link rel="stylesheet" href="{{ url("bower_components/jvectormap/jquery-jvectormap.css") }}">

	<!-- Date Picker -->
	<link rel="stylesheet" href="{{ url("bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css") }}">

	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{ url("bower_components/bootstrap-daterangepicker/daterangepicker.css") }}">
    
    {{-- Font Awesome 5 --}}
	<script src="https://kit.fontawesome.com/a23970da56.js" crossorigin="anonymous"></script>

	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="{{ url("plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }}">

	<!-- Color PICKER --> 
	<link rel="stylesheet" type="text/css" href="{{ url("plugins/colorpicker/bootstrap-colorpicker.min.css") }}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link rel="stylesheet" href="{{ asset("botones/style.css") }}">

	{{-- SmokeJS - CSS --}}
	<link rel="stylesheet" href="{{ asset("js/smoke/css/smoke.min.css") }}">
	{{-- Trumbowyg - CSS --}}
	<link rel="stylesheet" href="{{ asset("js/trumbowyg/dist/ui/trumbowyg.min.css") }}">
	{{-- Bootstrap select - CSS --}}
	<link rel="stylesheet" href="{{ asset("js/bootstrap-select/dist/css/bootstrap-select.min.css") }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    {{-- Range Date Picker--}}
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <meta name="token" content="{{ csrf_token() }}"/>
    <style type="text/css">
        #modal_peq {
            overflow: scroll;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <?php
        $user = Sentinel::getUser(); 
        $foto = "";
        if (Sentinel::check()) {
            $registro = Sentinel::getUser();
            if($registro->foto_perfil == "") {
                $foto_social = $registro->avatar;
            }else {
                $foto = $registro->foto_perfil;
            }
        }
    ?>

    <div class="wrapper">
        <header class="main-header">
            <?php
                if(isset(FuncionesGlobales::sitio()->color)){
                    if(FuncionesGlobales::sitio()->color != "") {
                        $color = FuncionesGlobales::sitio()->color;
                    }else {
                        $color = "#3c8dbc";
                    }
                }else {
                    $color = "#3c8dbc";
                }

                if(!isset($cerroMatozo)) {
                    $cerroMatozo = 0;
                }
            ?>

            @if(Route('home') == 'https://listos.t3rsc.co' && $cerroMatozo>0)
                <a  href="{{route('req_index')}}" class="logo" style="background-color: {{$color}};">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>T</b>3</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">
                        <b></b>
                        <img width="100" src="{{url('configuracion_sitio/logo-cerro-matoso.jpg') }}" class="img" alt="T3RS">
                    </span>
                </a>
            @else
                <a  href="{{route('req_index')}}" class="logo" style="background-color: {{ $color }};">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>T</b>3</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">
                        <b></b>
                        {{-- <img src="{{ url("img/t3rs.png") }}" class="img" alt="T3RS"> --}}
                        {{--
                        <img class="img" src="https://img-t3rsc.s3.amazonaws.com/t3rs-src/tri-new-logo-horizontal-letter.png" alt="TRI Logo" width="100">
                        --}}
                        <img class="img" src="{{ url('configuracion_sitio/'.$sitio->logo) }}" alt="Logo" height="40">
                    </span>
                </a>
            @endif

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" style="background-color: {{ $color }};">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if($foto != "") 
                                    <img class="user-image" alt="User T3RS" src="{{ url("recursos_datosbasicos/".$foto)}}">
                                @elseif($foto_social != "")
                                    <img class="user-image" alt="User T3RS photo" src="{{ $foto_social }}"> 
                                @else
                                    <img class="user-image" alt="User T3RS photo" src="{{ url("img/personaDefectoG.jpg")}}">
                                @endif
                                
                                <span class="hidden-xs">{{ ucwords(strtolower($user->name)) }}</span>
                            </a>
                            
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    @if($foto != "") 
                                        <img class="img-circle" alt="User T3RS" src="{{ url("recursos_datosbasicos/".$foto)}}">
                                    @elseif($foto_social != "")
                                        <img class="img-circle" alt="User T3RS photo" src="{{ $foto_social }}"> 
                                    @else
                                        <img class="img-circle" alt="User T3RS photo" src="{{ url("img/personaDefectoG.jpg")}}">
                                    @endif

                                    <p>
                                        {{ ucwords(strtolower($user->name)) }} 
                                        <small>Miembro desde {{ date_format($user->created_at, 'F Y') }}</small>
                                    </p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{route("req_cambiar_pass")}}" class="btn btn-default btn-flat">Perfil</a>
                                    </div>

                                    <div class="pull-right">
                                        <a href="{{ route('req_logout')}}" class="btn btn-default btn-flat">Salir</a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{route('req_logout')}}"><i class="fa fa-power-off"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        @if($foto != "") 
                            <img class="img-circle" alt="User T3RS" src="{{ url("recursos_datosbasicos/".$foto)}}">
                        @elseif($foto_social != "")
                            <img class="img-circle" alt="User T3RS photo" src="{{ $foto_social }}"> 
                        @else
                            <img class="img-circle" alt="User T3RS photo" src="{{ url("img/personaDefectoG.jpg")}}">
                        @endif
                    </div>

                    <div class="pull-left info">
                        <p style="white-space: break-spaces;">{{ ucwords(strtolower($user->name)) }}</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">NAVEGACIÓN PRINCIPAL</li>
                    {!! FuncionesGlobales::menu_requerimiento() !!}
                </ul>
            </section>
        </aside>

    <div class="content-wrapper">

            <section class="content">
                @yield("contenedor")
            </section>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2020 <a href="https://t3rsc.co">T3RS</a>  Versión 3.0</strong>.
        </footer>

        <div class="control-sidebar-bg"></div>
    </div>

    <div class="modal fade" id="modal_peq">
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

    <div class="modal fade" id="modal_gr" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal" id="modal_success_view">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal fade" id="modal_gra" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

	<!-- Bootstrap 3.3.7 -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	
	<!--<script type="text/javascript" src="https://nosir.github.io/cleave.js/dist/cleave.min.js"></script>
	<script type="text/javascript" src="https://nosir.github.io/cleave.js/dist/cleave-phone.i18n.js"></script>-->

	<script src="{{ url("bower_components/bootstrap-daterangepicker/daterangepicker.js") }}"></script>
	<script src="{{ url("bower_components/bootstrap/dist/js/bootstrap.min.js") }}"></script>

	<script src="{{ url("bower_components/select2/dist/js/select2.min.js") }}"></script>

	<!-- Morris.js") }} charts -->
	<script src="{{ url("bower_components/raphael/raphael.min.js") }}"></script>
	<script src="{{ url("bower_components/morris.js/morris.min.js") }}"></script>

	<!-- Sparkline -->
	<script src="{{ url("bower_components/jquery-sparkline/dist/jquery.sparkline.min.js") }}"></script>

	<!-- jvectormap -->
	<script src="{{ url("plugins/jvectormap/jquery-jvectormap-1.2.2.min.js") }}"></script>
	<script src="{{ url("plugins/jvectormap/jquery-jvectormap-world-mill-en.js") }}"></script>

	<!-- Color PICKER -->
	<script src="{{ url("plugins/colorpicker/bootstrap-colorpicker.min.js") }}"></script>

	<!-- Proloading -->
	<!-- include loa -->
	<script src="{{ url("js/loa.js") }}"></script>

	<!-- jQuery Knob Chart -->
	<script src="{{ url("bower_components/jquery-knob/dist/jquery.knob.min.js") }}"></script>

	<!-- daterangepicker -->
	<script src="{{ url("bower_components/moment/min/moment.min.js") }}"></script>

	<!-- Bootstrap WYSIHTML5 -->
	<script src="{{ url("plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js") }}"></script>

	<!-- Slimscroll -->
	<script src="{{ url("bower_components/jquery-slimscroll/jquery.slimscroll.min.js") }}"></script>

	<!-- FastClick -->
	<script src="{{ url("bower_components/fastclick/lib/fastclick.js") }}"></script>

	<!-- AdminLTE App -->
	<script src="{{ url("dist/js/adminlte.min.js") }}"></script>
	
	{{-- SmokeJS --}}
	<script src="{{ asset("js/smoke/js/smoke.min.js") }}"></script>
	{{-- SmokeJS - Language --}}
	<script src="{{ asset("js/smoke/lang/es.min.js") }}"></script>

	{{-- Trumbowyg - JS --}}
	<script src="{{ asset("js/trumbowyg/dist/trumbowyg.min.js") }}"></script>
	<script src="{{ asset("js/trumbowyg/dist/langs/es.min.js") }}"></script>
	
	{{-- Bootstrap select --}}
	<script src="{{ asset("js/bootstrap-select/dist/js/bootstrap-select.min.js") }}"></script>
	<script src="{{ asset("js/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js") }}"></script>
    
    {{-- Moment--}}
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

	{{-- Date Range Picker --}}
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
</body>
</html>
  