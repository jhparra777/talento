@extends("home.layout.master")
<!--extends("req.layout.master_login")-->
@section('content')
<div class="page-header" style="background: url(http://190.146.237.133:8080/soluciones-inmediatas/public/assets/img/banner1.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <h2 class="product-title">Recuperar cuenta</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="http://190.146.237.133:8080/soluciones-inmediatas/public">
                                <i class="ti-home"></i> Inicio
                            </a>
                        </li>
                        <li class="current">Recuperar cuenta</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="find-job section">
    <div class="container">
        <div class="row">
        <div class="col-md-3"></div>
            <div class="col-md-6 fr_registro">
                <h1 class="color">Recordar contraseña paso 2</h1>
                <p class="set-general-font-bold">Registra una nueva contraseña.</p>
                {!! Form::open(['route' => 'recordar_contrasena2']) !!}
                    <input type="hidden" name="token" value="{{ $datos->hash }}">
                    <div class="form-group">
                        {!! Form::label('email', 'Correo Electrónico') !!}
                        {!! Form::text('email',old('email'),['class'=>'form-control','id'=>'email','placeholder'=>'Correo Electrónico']) !!}
                        <p class="error text-danger direction-botones-center">{{ $errors->has('email')?$errors->first('email'):'' }}</p>
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Contraseña') !!}
                        {!! Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Contraseña']) !!}
                        <p class="error text-danger direction-botones-center">{{ $errors->has('password')?$errors->first('password'):'' }}</p>
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', 'Verificar Contraseña') !!}
                        {!! Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','placeholder'=>'Verificar Contraseña']) !!}
                        <p class="text-danger"></p>
                    </div>
                    <div class="btn-container-aligned">
                        {!! Form::button('Guardar <i class="fa fa-arrow-circle-o-right"></i>',['type'=>'submit', 'class'=>'btn btn-common btn-rm']) !!}
                    </div>
                    <div class="">
                        <br>
                        <a href="{{route("login_req_view")}}" class="btn-t3 btn btn-danger col-md-12">Iniciar sesión</a>    
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>
@stop()