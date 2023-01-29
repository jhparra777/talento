@extends('home.layout.listos_master')
@section('content')
	<style type="text/css">
		#rowSueños {
    		background-color: rgb(38, 27, 46);
    		color: white;
    		height: 87px;
		}
    </style>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top sticky-top">
		<div class="container">
			<a class="navbar-brand" href="{{ route('home') }}">
				@if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://listos.t3rsc.co')
					<img class="img-responsive" src="{{ asset('assets/listos/imgs/listos-logo.png') }}" alt="" style="width: 75px;">
				@elseif(route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://vym.t3rsc.co')
					<img class="img-responsive" src="{{ asset('assets/listos/imgs/vym-logo.png') }}" alt="" style="width: 90px;">
				@endif
			</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto topnav  dropdown">
					<li class="nav-item active">
						<a class="nav-link active" href="{{ route('home') }}">Inicio
							<span class="sr-only">(current)</span>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="{{ route('registrarse') }}">Registrar Datos</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="{{ route('empleos') }}">Buscar Empleo</a>
					</li>

					<li class="nav-item">
						@if(isset(FuncionesGlobales::sitio()->web_corporativa))
                            @if(FuncionesGlobales::sitio()->web_corporativa != "")
                            	<a class="nav-link" href="{!! FuncionesGlobales::sitio()->web_corporativa !!}" target="_blank">
                            		Sobre Nosotros
                            	</a>
                            @else
                            	<a class="nav-link" href="desarrollo.t3rsc.co" target="_blank">
                            		Sobre Nosotros
                            	</a>
                            @endif
                        @else
                            <a class="nav-link" href="desarrollo.t3rsc.co" target="_blank">
                            	Sobre Nosotros
                            </a>
                        @endif
					</li>

					{{--<li class="dropdown-submenu dropdown-menu-right">
						<a class="nav-link" tabindex="-1" href="#">Transacciones</a>
						
						<ul class="dropdown-menu" id="submenu1">
							<li class="dropdown-submenu">
								<a class="nav-link" href="#">Zona Administrativa</a>
								
								<ul class="dropdown-menu" id="submenu2">
									<li>
										<a target="_blank" class="nav-link" href="#">
											Esmad
										</a>
									</li>

                                    <li>
                                    	<a target="_blank" class="nav-link" href="#">
                                    		Self Service
                                    	</a>
                                    </li>

                                    <li>
                                    	<a target="_blank" class="nav-link" href="#">Daruma</a>
                                    </li>

                                    <li>
                                    	<a target="_blank" class="nav-link" href="#">Siga</a>
                                    </li>

                                    <li>
                                    	<a target="_blank" class="nav-link" href="#">Magneto</a>
                                    </li>

                                    <li>
                                    	<a target="_blank" class="nav-link" href="#">Transacciones Administrativas</a>
                                    </li>
                                </ul>
							</li>

							<li>
								<a target="_blank" class="nav-link" href="#">Zona Clientes</a>
							</li>

							<li class="dropdown-submenu">
								<a class="nav-link" href="#">Zona Proveedores</a>
								<ul class="dropdown-menu" id="submenu3">
									<li>
										<a target="_blank" class="nav-link" href="#">Instructivo para inscripción</a>
									</li>

									<li>
										<a target="_blank" class="nav-link" href="#">Instructivo para radicar facturas</a>
									</li>

									<li>
										<a target="_blank" class="nav-link" href="#">Registro nacional de proveedores</a>
									</li>

									<li>
										<a target="_blank" class="nav-link" href="#">Ventanilla única</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>--}}

					{{--<li>
						<a target="_blank" class="nav-link" href="#">Protección Datos personales</a>
					</li>--}}
				</ul>

				<ul class="navbar-nav ml-auto topnav">
					@if (Sentinel::check())
						<li>
							<a id="aZonaEmpresas" class="nav-link" href="{{ route('dashboard') }}" style="margin-right: 1rem;">
								<i class="far fa-user"></i> MI PERFIL
							</a>
						</li>

						<li>
							<a id="aZonaEmpresas" class="nav-link" href="{{ route('logout_cv') }}">
								<i class="fas fa-sign-out-alt"></i> SALIR
							</a>
						</li>
					@else
						<li>
							<a id="aZonaEmpresas" class="nav-link" href="{{ route('registrarse') }}" style="margin-right: 1rem;">
								<i class="far fa-edit"></i> REGISTRO
							</a>
						</li>

						<li>
							<a id="aZonaEmpresas" class="nav-link" href="{{ route('login') }}">
								<i class="fas fa-unlock-alt"></i> INGRESAR
							</a>
						</li>
					@endif
					
				</ul>
			</div>
		</div>
	</nav>

	<div class="container-fluid">
		<form action="" class="form-inline" id="form-inline-footer">
			<div id="" class="form-group col-lg-4 imgs-div-footer">
				@if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://listos.t3rsc.co')
					<a href="https://api.whatsapp.com/send?phone=573125681648" class="hidden-xs" target="_blank">
						<img id="img-listos-logo-ws" src="{{ asset('assets/listos/imgs/wsboton.png') }}" class="img-responsive" alt="Whatsapp"> 
					</a>
				@elseif(route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://vym.t3rsc.co')
					<a href="https://api.whatsapp.com/send?phone=573203338319" class="hidden-xs" target="_blank">
						<img id="img-listos-logo-ws" src="{{ asset('assets/listos/imgs/wsboton.png') }}" class="img-responsive" alt="Whatsapp"> 
					</a>
				@endif
			</div> 
		</form>
            
		<form action="" class="form-inline" id="form-inline-footer"></form>

		<div class="row" id="rowSueños">
			<h2 style="text-align: center; margin: auto;">
				Quieres cumplir tus sueños?  Dá el primer paso &nbsp;
				<a id="" target="_blank" href="{{ route('registrarse') }}" class="btn btn-light" style="font-weight: bold;">Zona Aspirantes</a>
			</h2>
		</div>

		<div class="row">
			<div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators2" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators2" data-slide-to="1" class=""></li>
					<li data-target="#carouselExampleIndicators2" data-slide-to="2" class=""></li>
					<li data-target="#carouselExampleIndicators2" data-slide-to="2" class=""></li>
				</ol>

				@if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://listos.t3rsc.co')
					<div class="carousel-inner" id="imagenes carrousel">
						<div class="carousel-inner">
							<div class="carousel-item active">
								<img class="d-block w-100" src="{{ asset('assets/listos/imgs/slide/banner-01.png') }}" alt="First slide">
							</div>

							<div class="carousel-item">
								<img class="d-block w-100" src="{{ asset('assets/listos/imgs/slide/proposito.png') }}" alt="Second slide">
							</div>

							<div class="carousel-item">
								<img class="d-block w-100" src="{{ asset('assets/listos/imgs/slide/banner-superior-2.png') }}" alt="Third slide">
							</div>

							<div class="carousel-item">
								<img class="d-block w-100" src="{{ asset('assets/listos/imgs/slide/banner-superior-3.png') }}" alt="Fourth slide">
							</div>
						</div>
					</div>
				@elseif(route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://vym.t3rsc.co')
					<div class="carousel-inner" id="imagenes carrousel">
						<div class="carousel-inner">
							<div class="carousel-item active">
								<img class="d-block w-100" src="{{ asset('assets/listos/imgs/slide/vym1-crop.png') }}" alt="First slide">
							</div>
						</div>
					</div>
				@endif
				
				<a style="color: white" target="_blank" href=""></a>
				<a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Anterior</span>
				</a>

				<a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Siguiente</span>
				</a>
			</div>
		</div> 

		<section class="" id="aplicar">
			<br><br>
			<div class="row">
				<h2 style="text-align: center; margin: auto; margin-bottom: 3rem;">
					Aquí tu <b>perfil</b> se convierte en <b>empleo</b>
				</h2>
			</div>

			<div class="row" style="background-color: #fd302f;">
				<div class="col-lg-5" id="divFormulario">
					<br><br>
					
					<h2 class="white" style="text-align: -webkit-center;">
						Registra tus datos y encontraremos el mejor perfil que se acomode a ti
					</h2>
					
					<br>

					{!! Form::open(['route' => 'process_registro',"autocomplete"=>"off"]) !!}
						{!! Form::hidden("google_key",null) !!}
            			{!! Form::hidden("facebook_key",null) !!}
            			{!! Form::hidden("empresa_registro","T3RS") !!}

						<div class="row">
							<div class="col-lg-5 form-group mat-div">
								<label for="identificacion" class="white mat-label">Número de Identificación *</label>
								<input type="number" class="mat-input" name="identificacion" id="identificacion" autocomplete="off">
								<span></span>
								<p class="text-danger">{!! FuncionesGlobales::getErrorData("identificacion", $errors) !!}</p>
							</div>

							<div class="col-lg-1"></div>

							<div class="col-lg-6 form-group mat-div">
								<label for="c-identificacion" class="white mat-label">Confirmar Número de Identificación *</label>
								<input type="number" class="mat-input" name="c-identificacion" id="c-identificacion" autocomplete="off">
								<span></span>
								<p class="text-danger">{!! FuncionesGlobales::getErrorData("c-identificacion", $errors) !!}</p>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12 form-group mat-div">
								<label for="name" class="white mat-label">Nombres *</label>
								<input type="text" class=" mat-input" name="name" id="name">
								<p class="text-danger">{!! FuncionesGlobales::getErrorData("name", $errors) !!}</p>
							</div>							
                            
                            <div class="col-lg-5 form-group mat-div">
                                <label for="primer_apellido" class="white mat-label">Primer Apellido *</label>
                                <input type="text" class="mat-input" name="primer_apellido" id="primer_apellido">
                                <p class="text-danger">{!! FuncionesGlobales::getErrorData("primer_apellido", $errors) !!}</p>
                            </div>

                            <div class="col-lg-1"></div>

                            <div class="col-lg-6 form-group mat-div">
                                <label for="segundo_apellido" class="white mat-label">Segundo Apellido</label>
                                <input type="text" class=" mat-input" name="segundo_apellido" id="segundo_apellido">
                                <p class="text-danger">{!! FuncionesGlobales::getErrorData("segundo_apellido", $errors) !!}</p>
                            </div>
						</div>

						<div class="row">
							<div class="col-lg-5 form-group mat-div">
								<label for="telefono_fijo" class="white mat-label">Teléfono Fijo</label>
								<input type="number" class="mat-input" id="telefono_fijo" maxlength="7">
								<p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_fijo", $errors) !!}</p>
							</div>

							<div class="col-lg-1"></div>

							<div class="col-lg-6 form-group mat-div">
								<label for="telefono_movil" class="white mat-label">Teléfono Móvil *</label>
								<input type="number" class=" mat-input" name="telefono_movil" id="telefono_movil" maxlength="10">
								<p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_movil", $errors) !!}</p>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12 form-group mat-div">
								<label for="email" class="white mat-label">Correo Electrónico *</label>
								<input type="email" class=" mat-input" name="email" id="email">
								<p class="text-danger">{!! FuncionesGlobales::getErrorData("email", $errors) !!}</p>
							</div>

							<div class="col-lg-12 form-group mat-div">
								<label for="password" class="white mat-label">Contraseña *</label>
								<input type="password" class=" mat-input" name="password" id="password">
								<p class="text-danger">{!! FuncionesGlobales::getErrorData("password", $errors) !!}</p>
							</div>

							<div class="col-lg-12 form-group mat-div">
								<label for="password_confirmation" class="white mat-label">Verificar Contraseña</label>
								<input type="password" class=" mat-input" name="password_confirmation" id="password_confirmation">
								<p class="text-danger">{!! FuncionesGlobales::getErrorData("password_confirmation", $errors) !!}</p>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12 form-group mat-div">								
								<select id="contacto_externo" name="contacto_externo" class="form-control mat-input" style="margin-top: -16px; margin-left: 11px;">
									<option value="">Seleccionar</option>
									<option value="trabaje_con_nosotros">Trabaje con nosotros</option>
									<option value="referidos">Referidos</option>
									<option value="facebook">Facebook</option>
									<option value="clasificados">Clasificados</option>
									<option value="alcaldias">Alcaldias</option>
									<option value="emisoras">Emisoras</option>
									<option value="ferias_empresariales">Ferias empresariales</option>
									<option value="agencias_empleo">Agencias de empleo</option>
									<option value="compu_trabajo">Computrabajo</option>
								</select>
								<p class="text-danger">{!! FuncionesGlobales::getErrorData("contacto_externo", $errors) !!}</p>
							</div>
						</div>

						<div class="row">
							<div class="form-inline">
								<div class="col-lg-3 form-group">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="acepto_politicas" name="acepto_politicas" value="1">
										<label class="custom-control-label" for="acepto_politicas">Acepto *</label>
										<p class="text-danger">{!! FuncionesGlobales::getErrorData("acepto_politicas", $errors) !!}</p>
									</div>
								</div>

								<div class="col-lg-7 form-group">
									<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalPoliticas">Ver política de protección de datos</button>
								</div>

								<div class="col-lg-2 form-group">
									<button type="submit" class="btn btn-light registro-send">Registrarse</button>
								</div>
							</div>
							<br><br>
						</div>
					{!! Form::close() !!}
					<br><br>
				</div>
                    
				<div class="col-lg-7">
					<br><br> 
					<div class="row">
						<div class="col-lg-2"></div>
						<div class="col-lg-8">
							<h2 class="white" style="text-align: -webkit-center;">¿Sabes cómo postularte a empleos por medio de Listos?</h2>
						</div>

						<div class="col-lg-2"></div>
					</div>
					
					<br><br>

					<div class="row">
						@if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://listos.t3rsc.co')
							<iframe id="iframeVideo" width="560" height="400" src="https://www.youtube.com/embed/ZurDXjH0j2I" allowfullscreen=""></iframe>
						@elseif(route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://vym.t3rsc.co')
							<div id="iframeVideo" class="fb-video" data-href="https://es-la.facebook.com/visionymarketing/videos/2622921821139075/" data-width="600" data-show-text="false">
								<blockquote cite="https://developers.facebook.com/visionymarketing/videos/2622921821139075/" class="fb-xfbml-parse-ignore">
									<a href="https://developers.facebook.com/visionymarketing/videos/2622921821139075/">¿Quieres trabajar en VIsion&amp;Marketing?</a>
									<p>Si eres un apasionado del mercadeo y tienes aptitudes comerciales, VIsion&amp;Marketing es tu sitio. Encuentra tu espacio en la compañia pionera de corazón. Entra en nuestra web e inscribe tu hoja de vida. http://www.visionymarketing.com.co/#Trabaja</p>
									Publicado por <a href="https://www.facebook.com/visionymarketing/">Vision &amp; Marketing</a> en Martes, 21 de enero de 2020
								</blockquote>
							</div>
						@endif
					</div>
				</div>
			</div>
		</section>
		
		<br><br>

		<section class="" id="ofertas">
			<div class="container">
				<div class="row ">
					<div class="col-md-12 mb-4">
						<h2 style="text-align: center;margin: auto;">Ofertas laborales</h2>
					</div>
				</div>

				<div class="row">
					{{--
					@foreach($requerimientos as $req)
						<div class="col-md-12">
							<div class="job-list">
								@if($req->logo != "" && $req->logo != null)
                                    @if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://listos.t3rsc.co')
                                    	<div class="thumb" style="text-align: center;">
											<img alt="T3RS" src="https://listos.t3rsc.co/configuracion_sitio/logo_cargado.png">
										</div>
									@elseif(route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://vym.t3rsc.co')
										<div class="thumb" style="text-align: center;">
											<img alt="T3RS" src="https://vym.t3rsc.co/configuracion_sitio/logo_cargado.png">
										</div>
                                    @endif
                                @elseif(isset(FuncionesGlobales::sitio()->logo))
                                    @if(FuncionesGlobales::sitio()->logo != "")
                                        @if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://listos.t3rsc.co')
	                                    	<div class="thumb" style="text-align: center;">
												<img alt="T3RS" src="https://listos.t3rsc.co/configuracion_sitio/logo_cargado.png">
											</div>
										@elseif(route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://vym.t3rsc.co')
											<div class="thumb" style="text-align: center;">
												<img alt="T3RS" src="https://vym.t3rsc.co/configuracion_sitio/logo_cargado.png" style="width: 110px;">
											</div>
	                                    @endif
                                    @else
                                    	<div class="thumb" style="text-align: center;">
											<img alt="T3RS" src="{{url('img/logo.png')}}">
										</div>
                                    @endif
                                @else
                                    <div class="thumb" style="text-align: center;">
										<img alt="T3RS" src="{{url('img/logo.png')}}">
									</div>
                                @endif

								<div class="job-list-content">
									<h4>{{ ucfirst(mb_strtolower($req->nombre_subcargo,'UTF-8')) }}</h4>
									
									<h5>
										<a href="{{ route('home.detalle_oferta',['id'=>$req->id])}} ">
											{{ ucfirst(mb_strtolower($req->nombre_cargo,'UTF-8')) }}
										</a>
									</h5>

									<p>
										{!! str_limit($req->descripcion_oferta, 250) !!}
									</p>

									<br>

									<label>Salario :</label>
									<strong class="price">${!! number_format($req->salario, null, null, ".") !!}</strong>

									<div class="job-tag">
										<div class="pull-left">
											<div class="meta-tag">
												<span><i class="ti-location-pin"></i>
													{{ ucwords(strtolower($req->ciudad_seleccionada))}}
												</span>

												<span><i class="ti-time"></i></span>
											</div>
										</div>

										@if($req->preg_req() != 0)
											@if($req->preg_req_filtro() != 0)
												@if($req->resp_req() == 0)
													
													<div class="pull-right">
														<a href="{{ route('home.responder',['id'=>$req->id,'cargo_id'=>$req->cargo_id]) }}" class="btn btn-common btn-rm">
															Aplicar
														</a>

														<a href="{{ route('home.detalle_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">Ver Más</a>
													</div>
                                                @elseif($req->preg_req() == 50)
                                                	<div class="pull-right">
														<a href="{{ route('home.aplicar_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">
															Aplicar
														</a>

														<a href="{{ route('home.detalle_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">Ver Más</a>
													</div>
                                                @endif
                                 
                                                @if($req->resp_req() >= 1)
                                                	<div class="pull-right">
														<a href="{{ route('home.aplicar_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">
															Aplicar
														</a>

														<a href="{{ route('home.detalle_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">Ver Más</a>
													</div>
                                                @endif
                                            @else
                                                @if($req->resp_req() == 0)
                                                	<div class="pull-right">
														<a href="{{ route('home.responder_puntaje',['req_id'=>$req->id,'cargo_id'=>$req->cargo_id]) }}" class="btn btn-common btn-rm">
															Aplicar
														</a>

														<a href="{{ route('home.detalle_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">Ver Más</a>
													</div>
                                                @elseif($req->preg_req() == 50)
                                                	<div class="pull-right">
														<a href="{{ route('home.aplicar_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">
															Aplicar
														</a>

														<a href="{{ route('home.detalle_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">Ver Más</a>
													</div>
                                                @endif
                                            @if($req->resp_req() >= 1)
                                            	<div class="pull-right">
													<a href="{{ route('home.aplicar_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">
														Aplicar
													</a>

													<a href="{{ route('home.detalle_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">Ver Más</a>
												</div>
                                            @endif
                                        @endif

                                        @elseif($req->preg_req_idioma() != 0 && $req->preg_req_filtro() == 0 && $req->resp_req() == 0)
                                        	<div class="pull-right">
												<a href="{{ route("home.responder_preguntas_prueba_idioma",['req_id'=>$req->id,'cargo_id'=>$req->cargo_id]) }}" class="btn btn-common btn-rm">
													Aplicar
												</a>

												<a href="{{ route('home.detalle_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">Ver Más</a>
											</div>
                                        @else
                                        @if(route("home")=="https://komatusu.t3rsc.co" || route("home")=="https://localhost:8000")
                                            <a target="_black"  href="{{route('home.aplicar_oferta',['id'=>$req->id])}}" class="btn btn-common btn-rm">Aplicar</a><- No va
                                        @endif
                                            <div class="pull-right">
												<a href="{{ route('home.detalle_oferta',['id'=>$req->id]) }}" class="btn btn-common btn-rm">Ver Más</a>
											</div>
                                        @endif
									</div>
								</div>
							</div>
						</div>
					@endforeach
					--}}
                
                	<div class="col-md-12">
                		<div>
							<a href="{{ route('empleos') }}" class="btn btn-common btn-rm">Ver todas las ofertas</a>
						</div>
                	</div>
            	</div>
            </div>
        </section>
	</div>

	<br><br>

	<section class="" id="somos">
		<div class="row mt-5">
			<h2 style="text-align: center;margin: auto;">¿Quiénes somos?</h2>
		</div>
		
		<br><br>
		
		<div class="row">
			<div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators3" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators3" data-slide-to="1" class=""></li>
					<li data-target="#carouselExampleIndicators3" data-slide-to="2" class=""></li>
				</ol>

				@if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://listos.t3rsc.co')
					<div class="carousel-inner">
	                    <div class="carousel-item active">
	                        <img class="d-block w-100" src="{{ asset('assets/listos/imgs/slide/banner-corporativo-07.png') }}" alt="First slide">
	                    </div>

	                    <div class="carousel-item">
	                        <img class="d-block w-100" src="{{ asset('assets/listos/imgs/slide/banner-corporativo-06.png') }}" alt="Second slide">
	                    </div>

	                    <div class="carousel-item">
	                        <img class="d-block w-100" src="{{ asset('assets/listos/imgs/slide/asieslistos.png') }}" alt="Third slide">
	                    </div>
	                </div>
				@elseif(route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://vym.t3rsc.co')
					<div class="carousel-inner">
	                    <div class="carousel-item active">
	                        <img class="d-block w-100" src="{{ asset('assets/listos/imgs/slide/vym2.png') }}" alt="First slide">
	                    </div>
	                </div>
				@endif

				<a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Anterior</span>
				</a>

				<a class="carousel-control-next" href="#carouselExampleIndicators3" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Siguiente</span>
				</a>
			</div>
		</div>
		
		<br>
	</section>

	<br>

	<div class="row">
		<h2 style="text-align: center;margin: auto;">Nuestros procesos están <b>certificados</b></h2>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<img src="{{ asset('assets/listos/imgs/slide/ISO-90001.jpg') }}" class="img-responsive" alt="" style="margin: auto;">
		</div>
	</div>

	<br><br>

	{{--<div class="row">
		<h2 style="text-align: center;margin: auto;"><b>Listos más cerca de ti</b></h2>
	</div>

	<br>

	<div class="row">
		<div class="col-lg-12">
			<div id="map"></div>
		</div>
	</div>--}}

	{{--<section id="Contacto">
    	<div class="rgba-black-strong py-5">
    		<div class="container">
    			<div class="wow fadeIn">
    				<h2 class="h1 pt-5 pb-3 text-center" style="font-size: 46px; color: #25b34b">Contacto</h2>
    			</div>

				<div class="card mb-5 wow fadeInUp" data-wow-delay=".4s" style="border-color: #25b34b;">
					<div class="card-body p-5">
						<div class="row">
							<div class="col-md-6">
								<form action="#" method="POST">
									<div class="row">
										<div class="col-md-6">
											<div class="col-lg-12 form-group mat-div2">
												<label for="nombre" class="mat-label2">Nombre</label>
												<input type="nombre" class=" mat-input2" id="nombrecontacto">
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-lg-12 form-group mat-div2">
												<label for="nombre" class="mat-label2">Correo</label>
												<input type="correoContacto" class=" mat-input2" id="correoContacto">
											</div>
										</div>
									</div>
                                    
									<div class="row">
                                    	<div class="col-md-12">
                                    		<div class="md-form mat-div2">
                                    			<select id="asuntoContacto" name="asunto" class="form-control s-motivo-contacto mat-input2" onchange="">
                                    				<option value="">MOTIVO DEL CONTACTO:</option>
                                    				<option value="">MOTIVO DEL CONTACTO:</option>
                                    				<option value="">MOTIVO DEL CONTACTO:</option>
                                    			</select>
                                    		</div>
                                    	</div>
                                    </div>

                                    <br>
                                    
                                    <div class="row">
                                    	<div class="col-md-12">
                                    		<div class="md-form">
                                    			<textarea rows="10" class="form-control" id="messageContacto" name="message" required="required" placeholder="Mensaje" style="border-color: #25b34b;"></textarea>
                                    		</div>
                                    	</div>
                                    </div>
                                    
                                    <br><br>

									<div class="center-on-small-only mb-4">
										<button class="btn btn-success" onclick="enviarCorreoContacto();"> Enviar</button>
									</div>
								</form>
							</div>

							<div class="col-md-3">
								<ul class="list-unstyled text-center">
									<p>Cali <br>Calle 21 Norte# 8N-21 <br>+57(2) 6084848</p>
                                    <p>Ibagué <br>Calle 35 # 4B-38 Barrio Cádiz <br>+57(8) 2644763</p>
                                    <p>Buenaventura <br>Calle 7#2B-14 Edif. Trinidad<br>+57(2)2426225</p>
                                    <p>Pasto <br>Carrera 25 # 15-62 Centro Comercial El Zaguán del Lago Oficina 315 <br>+57(2) 7231780</p>
                                    <p>Palmira <br>Calle 31 # 28-13 Local 204 Edificio osmares <br> Tel 6084848 EXT 24001- 3127570159</p>
                                    <p>Cartagena <br>Centro Comercial e industrial Ternera <br> Bodega M1 <br>+57(5) 6619421</p>
                                    <p>Villavicencio <br>Carrera 19A # 19B-02 <br>Bodega M1 <br>+57(8) 6688289</p>
                                </ul>
                            </div>

                            <div class="col-md-3">
                                <ul class="list-unstyled text-center">
                                    <p>Bogotá <br>Carrera 47.# 100-41 <br>+57(1) 6012222</p>
                                    <p>Medellin <br> Carrera 78 A #47-33 Barrio Velódromo <br>+57(4) 4484028</p>
                                    <p>Barranqilla <br>Carrera 59#75-133 <br>3852829</p>
                                    <p>Pereira <br>Avenida 30 de agosto # 38-68 <br>+57(6)3362800</p>
                                    <p>Bucaramangara <br>Calle 59#32-79 Conucos (Antiguo Campestre) <br>+57(7)6472316</p>
                                    <p>Buga <br>Calle 6N #11-48 Centro Comercial llama Local 11 <br>+57(2)2360984</p>
                                    <p>Tuluá <br>Carrera 25#31-20 <br>+57(2)2262560</p>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>--}}    

	<div class="modal fade bd-example-modal-lg" id="modalPoliticas" tabindex="-1" role="dialog" aria-labelledby="modalPoliticasListos" aria-hidden="true">
  		<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title" id="modalPoliticasListos">
        				CONSENTIMIENTO (POLÍTICA) DE TRATAMIENTO Y PROTECCIÓN DE DATOS PERSONALES
        			</h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        			</button>
      			</div>
      			<div class="modal-body">
        			Por medio del presente documento otorgo mi consentimiento previo, expreso, e informado a T3RS S.A.S. Por medio del presente documento otorgo mi consentimiento previo, expreso, e informado a T3RS S.A.S., filiales y subordinadas, en caso de tenerlas, para recolectar, almacenar, administrar, procesar, transferir, transmitir y/o utilizar (el “Tratamiento”) (i) toda información relacionada o que pueda asociarse a mí (los “Datos Personales”), y que le he revelado a la Compañía ahora o en el pasado, para ser utilizada bajo las finalidades consignadas en este documento, y (ii) aquella información de carácter sensible, entendida como información cuyo tratamiento pueda afectar mi intimidad o generar discriminación, como lo es, entre otra, información relacionada a salud o a los datos biométricos (los “Datos Sensibles”), para ser utilizada bajo las finalidades consignadas en este documento.
                    <br/><br/>
                    Declaro que he sido informado que el Tratamiento de mis Datos Personales y Datos Sensibles se ajustará a la Política de Tratamiento de la Información de T3RS, filiales y subordinadas. (La “Política”), a la cual tengo acceso, conozco y sé que puede ser consultada. Reconozco que, de conformidad con la Ley 1581 de 2012, el Decreto 1377 de 2013 y las demás normas que las modifiquen o deroguen (la “Ley”), mis Datos Personales y Datos Sensibles se almacenarán en las bases de datos administradas por la Compañía, y podrán ser utilizados, transferidos, transmitidos y administrados por ésta, según las finalidades autorizadas, sin requerir de una autorización posterior por parte mía.
                    <br/><br/>
                    Datos Sensibles. Declaro que he sido informado que mi consentimiento para autorizar el Tratamiento de mis Datos Sensibles, que hayan sido recolectado o sean recolectados por medio de esta autorización, es completamente opcional, a menos que exista un deber legal que me exija revelarlos o sea necesario revelarlos para salvaguardar mi interés vital y me encuentre en incapacidad física, jurídica y/o psicológica para hacerlo. He sido informado de cuáles son los Datos Sensibles que la Compañía tratará y he dado mi autorización para ello conforme a la Ley.
                    <br/><br/>
                    Alcance de la autorización. Declaro que la extensión temporal de esta autorización y el alcance de la misma no se limitan a los Datos Personales y/o Datos Sensibles recolectados en esta oportunidad, sino, en general, a todos los Datos Personales y/o Datos Sensibles que fueron recolectados antes de la presente autorización cuando la Ley no exigía la autorización. Este documento ratifica mi autorización retrospectiva del Tratamiento de mis Datos Personales y/o Datos Sensibles.
                    <br/><br/>
                    FFinalidades. Autorizo para que la Compañía realice el Tratamiento de los Datos Personales y Datos Sensibles para el cumplimiento de todas, o algunas de las siguientes finalidades: 
                    <br/><br/>
                    a. De licenciamiento de software o prestación de servicios de reclutamiento. <br/><br/>
                    b. Enviar notificaciones de actualización de información. <br/><br/>
                    c. Mensajes de agradecimiento y felicitaciones.<br/><br/>
                    d. Gestionar toda la Información necesaria para el cumplimiento de las obligaciones contractuales y legales de la Compañía.<br/><br/>
                    e. El proceso de archivo, de actualización de los sistemas, de protección y custodia de información y Bases de Datos de la Compañía.<br/><br/>
                    i. Procesos al interior de la Compañía, con fines de desarrollo u operativo y/o de administración de sistemas. <br/><br/>
                    j. Permitir el acceso a los Datos Personales a entidades afiliadas a la Compañía y/o vinculadas contractualmente para la prestación de servicios de consultoría en talento humano, bajo los estándares de seguridad y confidencialidad exigidos por la normativa. <br/><br/>
                    k. La transmisión de Datos Personales a terceros en Colombia y/o en el extranjero, incluso en países que no proporcionen medidas adecuadas de protección de Datos Personales, con los cuales se hayan celebrado contratos con este objeto, para fines comerciales, administrativos y/u operativos.<br/><br/>
                    l. Mantener y procesar por computadora u otros medios, cualquier tipo de Información relacionada con el perfil de los candidatos con el fin de análisis sus competencias,  habilidades y conocimiento. <br/><br/>
                    m. Las demás finalidades que determinen los responsables del Tratamiento en procesos de obtención de Datos Personales para su Tratamiento, con el fin de dar cumplimiento a las obligaciones legales y regulatorias, así como de las políticas de la Compañía.<br/><br/>
                    <br/><br/>
                    Datos del responsable del Tratamiento. Declaro que he sido informado de los datos del responsable del Tratamiento de los Datos Personales y Datos Sensibles, los cuales son: 
                    <br/><br/>
                    El área responsable es Tecnología de T3RS administracion@t3rsc.co.<br/><br/>

                    Derechos. Declaro que he sido informado de los derechos de habeas data que me asisten como titular de los Datos Personales y Datos Sensibles, particularmente, los derechos a conocer, actualizar, rectificar, suprimir los Datos Personales o revocar la autorización aquí otorgada, en los términos y bajo el procedimiento consagrado en la Política. Igualmente, declaro que puedo solicitar prueba de la autorización otorgada a la Compañía. He sido informado de los otros derechos que la Política me concede como Titular y soy consciente de los alcances jurídicos de esta autorización.
                    <br/><br/>
                    Transmisión o transferencia. He sido informado y autorizo a la Compañía a transmitir o transferir, según sea el caso, mis Datos Personales a terceros, dentro o fuera del territorio colombiano, para los procesos de licenciamiento de software y/o reclutamiento de personal para distintas compañías. Todos los Datos Personales que yo entregue a la Compañía o que hayan sido recibidos por la Compañía por terceros, entran dentro de esta autorización para ser transmitidos o transferidos si es requerido para el cumplimiento cabal de las finalidades aquí descritas. 
                    <br/><br/>
                    Autorización de terceros. Declaro que he obtenido la autorización de terceros que han sido incluidos en mis datos personales o de referencia y que he obtenido de ellos la autorización para que la Compañía los contacte, en caso de ser necesario, para verificar los Datos Personales que yo he entregado a la Compañía.
                    <br/><br/>
                    Duración. La Compañía podrá realizar el Tratamiento de mis Datos Personales por todo el tiempo que sea necesario para cumplir con las finalidades descritas en este documento y para que pueda prestar sus servicios licenciamiento de software y/o reclutamiento de personal para distintas compañías.
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      			</div>
    		</div>
  		</div>
	</div>

	<footer class="app-footer" style="background-color: #261b2e;">
	    <br>

    	<h4 class="fot-w10" style="color: white;">
    		Entérate de más:
    		@if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://listos.t3rsc.co')
				<a class="white fot-w10" href="">
	    			<i class="fab fa-facebook-f"></i>
	    			@Listos
	    		</a>
	    		&nbsp;&nbsp;&nbsp;&nbsp;
	    		<a class="white" href="">
	    			<i class="fab fa-instagram"></i>
	    			@Listos
	    		</a>
	    		&nbsp;&nbsp;&nbsp;&nbsp;
	    		<a class="white" href="">
	    			<i class="fab fa-twitter"></i>
	    			@Listos
	    		</a>
	    		&nbsp;&nbsp;&nbsp;&nbsp;
	    		<a class="white" href="">
	    			<i class="fab fa-linkedin"></i>
	    			@Listos
	    		</a>
			@elseif(route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://vym.t3rsc.co')
				<a class="white fot-w10" href="https://www.facebook.com/visionymarketing" style="text-decoration: none;">
	    			<i class="fab fa-facebook-f"></i>
	    			Vision y marketing
	    		</a>
	    		&nbsp;&nbsp;&nbsp;&nbsp;
	    		<a class="white" href="https://twitter.com/visionbtl" style="text-decoration: none;">
	    			<i class="fab fa-twitter"></i>
	    			@visionbtl
	    		</a>
			@endif
    	</h4>
    	
    	<br>
	</footer>

	<script>
		$("#identificacion").on('copy', function(e){
       		e.preventDefault();
          	alert('Esta acción está prohibida');
       	});

		$("#identificacion").on('paste', function(e){
            e.preventDefault();
          	alert('Esta acción está prohibida');
       	});

       	var pass1 = $('#identificacion');
    	var pass2 = $('#c-identificacion');
    	var clave = $('#password');

    	var confirmacion = "Las cedulas si coinciden";
    	var longitud = "La cedula debe estar formada entre 6-10 carácteres (ambos inclusive)";
    	var negacion = "No coinciden las cedulas";
    	var vacio = "La contraseña no puede estar vacía";
    	
    	//oculto por defecto el elemento span
    	var span = $('<span></span>').insertAfter(pass2);
     	span.hide();
    	
    	//función que comprueba las dos contraseñas
    	function coincidePassword(){
    		var valor1 = pass1.val();
    		var valor2 = pass2.val();

    		//muestro el span
    		span.show().removeClass();
    		
    		//condiciones dentro de la función
		    if((valor1 != valor2) && (valor2 !="")){
		    	span.css("color", "red");
		     	span.text(negacion);
		     	$('.registro-send').attr('disabled',true);
		    }

		    if(valor1.length!=0 && valor1==valor2){
		    	span.css("color", "skyblue");
		     	span.text(confirmacion);
		     	$('.registro-send').removeAttr('disabled');
		    }
    	}

    	pass2.on('keyup',function(){
     		coincidePassword();
    	});

    	pass1.on('keyup',function(){
     		coincidePassword();
    	});
	</script>
@stop