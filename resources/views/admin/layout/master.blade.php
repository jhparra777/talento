<?php
    $sitio = FuncionesGlobales::sitio();
    $sitioModulo = FuncionesGlobales::sitioModulo();
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  	<title>
        @if(isset($sitio->nombre))
          	@if($sitio->nombre != "")
            	{{ $sitio->nombre }} - Admin
          	@else
            	Desarrollo | Admin
          	@endif
        @else
          	Desarrollo | Admin
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

	<script src="{{ asset("js/admin_functions.js") }}"></script>
	<script src="{{ asset("js/jquery-te-1.4.0.min.js") }}"></script>

	{{-- Js for views --}}
	<script src="{{ asset('js/gestion-requerimiento.js') }}"></script>

	{{-- Chart JS --}}
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

  	<meta name="token" content="{{ csrf_token() }}"/>

  	<script>
    	$(function () {
      		$.ajaxSetup({
        		type: "POST",
        		headers: {
          			'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        		},
        		error: function() {
          			/* Act on the event */
         			// swal("Atencion",'Error al procesar los datos',"warning");
        		},
      		});

      		$("form:not(.not)").submit(function(e) {
            	//e.preventDefault();
          		//$('.modal').modal('hide');
        		console.log();
        		$('.btn').prop('disabled',true);
          		
				$.blockUI({
            		message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                	css: {
                 		border: "0",
                 		background: "transparent"
                	},
                	overlayCSS:  {
                 		backgroundColor: "#fff",
                 		opacity:         0.6,
                 		cursor:          "wait"
                	}
            	});

           		return true;
          		// $('.btn').prop('disabled',false);
        		//$('.btn').removeAttr('disabled');
      		});

      		$(".btn").ajaxStart(function(){
        		$(this).attr("disabled","disabled");
      		});

      		$(".btn").ajaxStop(function(){
        		$(this).attr("disabled",false);
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
	{{-- Range Date Picker--}}
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	{{-- Font Awesome 5 --}}
	<script src="https://kit.fontawesome.com/a23970da56.js" crossorigin="anonymous"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
	<?php
    	$user = Sentinel::getUser();
    	$foto = "";
    	$foto_social = "";
    
    	if (Sentinel::check()) {
      		$registro = Sentinel::getUser();
      		if ($registro->foto_perfil == "") {
        		$foto_social = $registro->avatar;
      		} else {
        		$foto = $registro->foto_perfil;
      		}
    	}
  	?>

  	<div class="wrapper">
  		<header class="main-header">
    		<?php
      			if(isset($sitio->color)){
        			if($sitio->color != ""){
          				$color = $sitio->color;
        			}else{
          				$color = "#3c8dbc";
        			}
      			}else{
        			$color = "#3c8dbc";
      			}
    		?>

    		<a href="{{ route('admin.index') }}" class="logo" style="background-color: #575756;">
				<span class="logo-mini"><b>T</b>3</span>

				<span class="logo-lg">
					{{-- <img
						@if(route('home') == "https://gpc.t3rsc.co")
							src="{{ asset('assets/admin/imgs/gpc.png') }}" width="50"
						@else
							src="https://img-t3rsc.s3.amazonaws.com/t3rs-src/tri-new-logo-horizontal-letter.png"
						@endif class="img" alt="T3RS" width="100"
					> --}}

					@if (route('home') == "https://gpc.t3rsc.co")
						<img src="{{ asset('assets/admin/imgs/gpc.png') }}" width="50" class="img" alt="T3RS" width="100">
					@else
						<img alt="t3rs" height="40" src="{{ url('configuracion_sitio')}}/{{ $sitio->logo }}">
					@endif
				</span>
			</a>

    		<nav class="navbar navbar-static-top" style="background-color: #575756;">
      			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
       				<span class="sr-only">Toggle navigation</span>
      			</a>

      			<div class="navbar-custom-menu">
        			<ul class="nav navbar-nav">
          				<li class="dropdown user user-menu">
            				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								@if($foto != "")
									<img class="user-image" alt="User T3RS" src="{{ url("recursos_datosbasicos/".$foto)}}">
								@elseif($foto_social != "")
									<img class="user-image" alt="User T3RS photo" src="{{ $foto_social }}">
								@else
									<img class="user-image" alt="User T3RS photo" src="{{ url("img/personaDefectoG.jpg")}}">
								@endif

              					<span class="hidden-xs">{{ucwords(strtolower($user->name))}}</span>
            				</a>
							
							<ul class="dropdown-menu">
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
                  						<small>Miembro desde {{ date_format($user->created_at,'F Y') }}</small>
                					</p>
              					</li>

              					<li class="user-footer">
               						@if(route('home') != "https://gpc.t3rsc.co")
                						<div class="pull-left">
                 							<a href="#" class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">Perfil</a>
                						</div>
									@endif

									<div class="pull-right">
										<a href="{{ route('admin.logout')}}" class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray">Salir</a>
									</div>
              					</li>
            				</ul>
          				</li>

          				<li>
          					<a href="{{ route('home.ayuda_admin') }}" target="_blank" title="Ver Temas de Ayuda"><i class="fa fa-question-circle fa-lg"></i></a>
          				</li>

          				<li class="dropdown">
					        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user"></i>
					        <span class="caret"></span></a>
					        <ul class="dropdown-menu pd-0">
					          	<li><a href="{{ route('admin_cambiar_pass')}}" class="text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none">Cambiar contraseña</a></li>
					          	<li><a href="{{ route('admin.logout')}}" class="text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none">Salir</a></li> 
					        </ul>
					     </li>

          				{{--<li>
            				<a href="{{ route('admin.logout')}}"><i class="fa fa-power-off"></i></a>
          				</li>--}}
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
							<img class="img-circle" alt="User T3RS photo" src="{{ url("img/personaDefectoG.jpg") }}">
						@endif
					</div>
					
        			<div class="pull-left info">
          				<p>{{ substr($user->name,0,20) }}</p>
          				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        			</div>
				</div>

				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">NAVEGACIÓN PRINCIPAL</li>
					{{--  --}}
          @if(session()->has("menu_admin"))
            {!! session()->get("menu_admin") !!}
          @else
            {!! FuncionesGlobales::menu_admin() !!}
          @endif

				</ul>
    		</section>
  		</aside>

  		<div class="content-wrapper">
			{{-- TODO: Esto se debe borrar, se deja hasta que el otro header este en la mayoría de vistas --}}
    		{{-- <section class="content-header">
      			<div class="container">
        			<ul class="breadcrumb">
            			<li>Inicio</li>
            			{!!  FuncionesGlobales::migaPan();!!}
        			</ul>
       			</div>
    		</section> --}}

    		<section class="content">
      			@yield("contenedor")
    		</section>
  		</div>

  		<footer class="main-footer">
    		<div class="row">
				<div class="col-md-6" style="line-height: 3;">
					<strong>Copyright &copy; {{ date('Y') }} <a href="https://t3rsc.co">T3RS</a>  Versión 3.0</strong>.
				</div>
	
				<div class="col-md-6 text-right">
					<img src="https://img-t3rsc.s3.amazonaws.com/t3rs-src/tri-new-logo-horizontal-letter.png" alt="T3RS" width="80">
				</div>
			</div>
  		</footer>

  		<div class="modal fade" id="modal_peq" >
      		<div class="modal-dialog">
          		<div class="modal-content"></div>
      		</div>
  		</div>

		  <div class="modal fade" id="modalTriSmall">
			<div class="modal-dialog">
				<div class="modal-content | tri-br-1"></div>
			</div>
		</div>

		<div class="modal fade" id="modal_gr">
			<div class="modal-dialog modal-lg" id="mdialTamanio">
				<div class="modal-content"></div>
			</div>
		</div>

		<div class="modal fade" id="modalTriLarge">
			<div class="modal-dialog modal-lg" id="mdialTamanio">
				<div class="modal-content | tri-br-1"></div>
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

		{{-- Div para insertar modales --}}
		<div id="modalAjaxBox"></div>

		<div class="control-sidebar-bg"></div>
	</div>

	{{-- Modal Encuesta --}}
    @include('admin.encuesta._modal_encuesta')
	
	<!-- jQuery 3 -->
	<!--<script src="{{ url("bower_components/jquery/dist/jquery.min.js") }}"></script>-->

	<!-- jQuery UI 1.11.4 -->
	<!-- PROBLEMAS CON AUTOCOMPLETADO DE CIUDAD
		<script src="{{ url("bower_components/jquery-ui/jquery-ui.min.js") }}"></script>
	-->

	<script>
		$.widget.bridge('uibutton', $.ui.button);
		$(document).ready(function() {});
	</script>

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
	<script src="{{ asset("js/trumbowyg/dist/trumbowyg.js") }}"></script>
	<script src="{{ asset("js/trumbowyg/dist/langs/es.min.js") }}"></script>
	<script src="{{ asset("js/trumbowyg/plugins/upload/trumbowyg.upload.js") }}"></script>
	
	{{-- Bootstrap select --}}
	<script src="{{ asset("js/bootstrap-select/dist/js/bootstrap-select.min.js") }}"></script>
	<script src="{{ asset("js/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js") }}"></script>

	{{-- Moment--}}
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

	{{-- Date Range Picker --}}
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

	<!--
  		Libreria conflicto en ruta("/public/admin/editar_hv_admin/{id}") cuando el capo es requerido lo señala en rojo pero si lo gestionan lo sigue dejando en rojo
  		<script src="{{ url("dist/js/pages/dashboard.js") }}"></script>
	-->

	<script src="{{ url("dist/js/demo.js") }}"></script>

  	<script>
		function validar_sesion(){
			$.ajax({
				type: "POST",
				data:{},  
				url: "{{ route('admin.validar_sesion') }}",
				success: function(response) {
					if(!response.session){
						swal("Atención", "Su sesión ha expirado. Haga clic en iniciar sesión para ingresar nuevamente", "info", {
							buttons: {
								//cancelar: { text: "No",className:'btn btn-success'},
								iniciar: {
									text: "Inciar sesión",className:'btn btn-info'
								},
							},
						}).then((value) => {
							switch(value){
								case "cancelar":
									//var candidato=$(allPages).find(".check_candi").serialize();
									//var candidato = $("input[name='req_candidato[]']").serialize();
									//$(this).prop("href","?"+candidato+"&req_id="+req);
									//window.open("{{route('admin.hv_long_list')}}?"+candidato+"&req_id="+req,'_blank');
									//return false;
								break;
								case "iniciar":
									//var candidato=$(allPages).find(".check_candi").serialize();
									//setTimeout(function(){location.reload()}, 1500);
									window.location=("{{route('admin.login')}}");
								break;
							}
						});
					}                
				}
			});
		}

		var timer_encuesta
		$(document).ready(function(){
			//validar si existe encuesta_realizada en sesion
			var t_5_seg = 5000;
			timer_encuesta = setInterval(() => {
				presenta_encuesta();
			}, t_5_seg);
		});

		function presenta_encuesta() {
			$.ajax({
                type: "POST",
                url: "{{ route('admin.presenta_encuesta_timer') }}",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response.success) {
                        if(response.lleno == false) {
                            $("#modal_encuesta").modal("show");
                        }else if(response.lleno == true){
							//cancela setinterval
							$("#modal_encuesta").modal("hide");
							clearInterval(timer_encuesta);
						}else{

						}
                    } else {
                        // $.smkAlert({
                        //     text: response.mensaje,
                        //     type: 'danger'
                        // });
                        // $('#btn_guardar').show();
                    }
                },
				error: function(){
					// $.smkAlert({
                    //         text: 'Ha ocurrido un error, intente nuevamente.',
                    //         type: 'danger'
                    //     });
				}
                // success: function(response){
                //     console.log(response)
                //     if(response.lleno == false) {
                //         $("#modal_encuesta").modal("show");
                //     }
                // }
            });
		}
    	//setInterval(validar_sesion,60000);
  	</script>
</body>
</html>
