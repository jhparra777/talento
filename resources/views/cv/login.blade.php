@extends("home.layout.master")

@section('content')
    <section id="counter" style="padding: 2rem 3rem">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{--<img src="{{ url('assets/img/bg/counter-bg.png') }}" style="width: 100%;">--}}

                    <div class="breadcrumb-wrapper">
                        {{--
                            <h2 class="product-title">Accede a tu cuenta</h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="http://190.146.237.133:8080/soluciones-inmediatas/public">
                                        <i class="ti-home"></i> Inicio
                                    </a>
                                </li>
                                <li class="current">Accede a tu cuenta</li>
                            </ol>
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
        $validaTipoLogin = isset($evaluacion_sst) || isset($flag) || isset($record) || isset($brig) || isset($scheduling) || isset($excel_basico) || isset($excel_intermedio) || isset($digitacion) || isset($competencias) || isset($prueba_ethical_values) || isset($visita_domiciliaria) || session('url_deseada_redireccion_candidato') != null;
    ?>

    <section class="find-job section">
        <div class="container">
            <div class="row">
                @if ($validaTipoLogin)
                    <div class="col-md-offset-3 col-md-6">
                        <div class="alert alert-success" style="color: black; font-size: 16px;">
                            Si es la primera vez que ingresas a tu cuenta, <strong>usa tu número de identificación (sin puntos ni signos) como usuario y también como contraseña</strong>.
                        </div>
                    </div>
                    <br><br><br><br>
                @endif

                <div class="@if($validaTipoLogin) col-md-offset-3 @endif col-md-6 fr_login">
                    <h1 class="color">Accede a tu cuenta</h1>

                    <div class="my-account-login">
                        @if(Session::has("mensaje_login"))
                            <div class="" id="mensaje-resultado">
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {{Session::get("mensaje_login")}}
                                </div>
                            </div>
                        @endif
                        
                        @if(Session::has("mensaje_error"))
                            <div class="" id="mensaje-resultado">
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {{Session::get("mensaje_error")}}
                                </div>
                            </div>
                        @endif

                        {!! Form::open(['route' => 'process_login', "autocomplete" => "off"]) !!}
                            @if (isset($flag))
                                {!! Form::hidden('flag', 1) !!}
                            @endif

                            @if (isset($brig))
                                {!! Form::hidden('brig', 1) !!}
                            @endif

                            @if (isset($record))
                                {!! Form::hidden('record', 1) !!}
                                {!! Form::hidden('sr', $sr) !!}
                                {!! Form::hidden('ct', $ct) !!}
                            @endif

                            @if (isset($scheduling))
                                {!! Form::hidden('scheduling', 1) !!}
                            @endif

                            @if (isset($digitacion))
                                {!! Form::hidden('digitacion', 1) !!}
                            @endif

                            @if (isset($competencias))
                                {!! Form::hidden('competencias', 1) !!}
                            @endif

                            @if (isset($prueba_ethical_values))
                                {!! Form::hidden('prueba_ethical_values', 1) !!}
                                {!! Form::hidden('req_id', $req_id) !!}
                            @endif

                            @if (isset($evaluacion_sst))
                                {!! Form::hidden('evaluacion_sst', 1) !!}
                                {!! Form::hidden('req_id', $req_id) !!}
                            @endif

                            @if (isset($visita_domiciliaria))
                                {!! Form::hidden('visita_domiciliaria', 1) !!}
                                {!! Form::hidden('visita_id', $visita_id) !!}
                            @endif

                            @if (isset($excel_basico))
                                {!! Form::hidden('excel_basico', 1) !!}
                                {!! Form::hidden('req_id', $req_id) !!}
                            @endif

                            @if (isset($excel_intermedio))
                                {!! Form::hidden('excel_intermedio', 1) !!}
                                {!! Form::hidden('req_id', $req_id) !!}
                            @endif

                            <div class="form-group">
                                <label for="email" class="sr-only">Cedula</label>
                                {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Cedula', 'value' => old('email')]) !!}

                                <p class="text-danger">{{ $errors->has('email')?$errors->first('email'):'' }}</p>
                            </div>

                            <div class="form-group">
                                <label for="password" class="sr-only">Contraseña</label>
                                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Contraseña']) !!}
                                
                                <p class="text-danger">{{ $errors->has('password')?$errors->first('password'):'' }}</p>
                            </div>

                            <div class="btn-container-aligned">
                                {!! Form::submit('Iniciar Sesión',['class' => 'btn btn-common btn-rm', 'id' => 'iniciar-sesion']) !!}
                                
                                <br>
                                
                                <p class="t2 text-center olvidastes-t3"><a href="{{ route('recordar_email') }}">¿Olvidaste la contraseña?</a></p>
                                
                                <br>

                                @if ($validaTipoLogin)
                                    <p class="t2 text-center olvidastes-t3">
                                        <i class="fa fa-whatsapp" style="font-size: 2.2rem;"></i>
                                        @if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://localhost:8000')
                                            <a href="https://wa.me/573122029919?texto=Buen%20día,%20estoy%20intentando%20ingresar%20para%20cargar%20documentos%20y%20firmar%20desde%20Listos.%20Necesito%20ayuda,%20gracias.">¿Necesitas ayuda?</a>
                                        @endif
                                    </p>

                                    <br>
                                @endif

                                <p class="t2 text-center olvidastes-t3">
                                    Si tienes alguna duda consulta nuestro video 
                                    <a href="https://www.youtube.com/watch?v=j3aaBiH6fvY&t=15s" style="color:blue;" target="_blank" >aqui</a>
                                </p>
                                
                                <br>
                            </div>
                        {!! Form::close() !!}

                        <div class="widget hidden">
                            <div class="bottom-social-icons social-icon"> 
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="linkedin" href="{{ route('social.auth','linkedin') }}">
                                            Ingresa con <i class="ti-linkedin"></i>
                                        </a> 
                                    </div>

                                    <div class="col-md-4">
                                        <a class="google-plus" href="{{ route('social.auth', 'google') }}">
                                            Ingresa con <i class="ti-google"></i>
                                        </a>
                                    </div>

                                    <div class="col-md-4">
                                        <a class="facebook" href="{{ route('social.auth', 'facebook') }}">
                                            Ingresa con <i class="ti-facebook"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($validaTipoLogin)
                @else
                    <div class="col-md-6   text-center my-account-login cv-login">
                        <h2>El trabajo que buscas <br><small class="color2">está a tan solo un paso</small></h2>

                        <p>Tenemos diferentes filtros para que encuentres el empleo que más se ajusta a tu perfil. </p>
                        <a class="btn btn-common btn-rm" href="{{ route('registrarse') }}" >Registra aquí tu hoja de vida</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@stop()