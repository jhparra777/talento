@extends("cv.layouts.master_guest")
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="logo">
                <div class="col-md-12">
                    <br>
                    <img src="{{url('img/logo_poder.PNG')}}" class="img-responsive">
                    
                </div>
            </div>
            <div class="punta-logo"></div>
        </div>
        <div class="col-md-6">
            <div class="jumbotron-t3">
                <p>
                    <strong>Poder Humano Outsourcing Group.</strong> le invita a formar parte de nuestra comunidad de trabajadores que buscan crecer laboralmente. Registrese para mejorar su empleabilidad o inicie sesión si ya dispone de cuenta
                </p>
            </div>

            <h1 class="h1-login-t3">Accede a tu cuenta</h1>
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
            {!! Form::open(['route' => 'process_login',"autocomplete"=>"off"]) !!}
            <div class="form-group">
                <label for="email" class="sr-only">Email</label>
                {!! Form::text('email',null,['class'=>'form-control-t3','id'=>'email','placeholder'=>'Email','value'=>old('email')]) !!}

                <p class="text-danger">{{ $errors->has('email')?$errors->first('email'):'' }}</p>
            </div>
            <div class="form-group">
                <label for="password" class="sr-only">Contraseña</label>
                {!! Form::password('password',['class'=>'form-control-t3','id'=>'password','placeholder'=>'Contraseña']) !!}
                <p class="text-danger">{{ $errors->has('password')?$errors->first('password'):'' }}</p>
            </div>
            <div class="btn-container-aligned">


                {!! Form::submit('Iniciar Sesión',['class'=>'btn-t3 btn-2','id'=>'iniciar-sesion']) !!}

            </div>
            <article>
                <p class="t2 text-center olvidastes-t3"><a href="{{ route('recordar_email_poder') }}">¿Olvidaste la contraseña?</a></p>
                <p class="text-center small ">Crear una cuenta, acepte las Condiciones del servicio y las Políticas de privacidad de nuestra empresa.</p>
                <p class="text-center"><a style="float: none" href="{{ route('registrarse_poder') }}" class="btn-t3 btn-1 ">Regístrate</a></p>
            </article>
            {!! Form::close() !!}

          
            <div class="row">
                <div class="col-md-5">
                    <div class="linea-t3"></div>
                </div>
                <div class="col-md-2"><div class="bola-separador">O</div></div>
                <div class="col-md-5">
                    <div class="linea-t3"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                     <a href="{{route('loginRedes',["facebook","registrarse"])}}" class="btn btn-redes-sociales btn-facebook" ><span class="span-redes-sociales span-facebook"><i class="fa fa-facebook"></i>

                        </span>Facebook</a>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-5">
                    <a href="{{route('loginRedes',["google","registrarse_poder"])}}" class="btn btn-redes-sociales btn-google" ><span class="span-redes-sociales span-google"><i class="fa fa-google-plus"></i>

                        </span>Google</a>

                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
@stop()