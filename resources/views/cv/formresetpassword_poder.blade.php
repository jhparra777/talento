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
                    <strong>T3RS</strong> lo invita a formar parte del <strong>grupo Líder</strong> en el sector de servicios basados en <strong>Talento Humano</strong> con cobertura y oficinas en las principales ciudades del país.
                </p>
            </div>
            <h1 class="h1-login-t3">Recordar contraseña paso 2</h1>
            <p class="text-danger set-general-font-bold">Registra una nueva contraseña.</p>
            {!! Form::open(['route' => 'recordar_contrasena2']) !!}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                {!! Form::label('email', 'Correo Electrónico') !!}
                {!! Form::text('email',old('email'),['class'=>'form-control-t3','id'=>'email','placeholder'=>'Correo Electrónico']) !!}
                <p class="text-danger">{{ $errors->has('email')?$errors->first('email'):'' }}</p>
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Contraseña') !!}
                {!! Form::password('password',['class'=>'form-control-t3','id'=>'password','placeholder'=>'Contraseña']) !!}
                <p class="text-danger">{{ $errors->has('password')?$errors->first('password'):'' }}</p>
            </div>
            <div class="form-group">
                {!! Form::label('password_confirmation', 'Verificar Contraseña') !!}
                {!! Form::password('password_confirmation',['class'=>'form-control-t3','id'=>'password_confirmation','placeholder'=>'Verificar Contraseña']) !!}
                <p class="text-danger"></p>
            </div>
            <div class="btn-container-aligned">
                {!! Form::button('Guardar <i class="fa fa-arrow-circle-o-right"></i>',['type'=>'submit', 'class'=>'btn-t3 btn-2']) !!}
            </div>
            <div class="">
                <br>
                <a href="{{route("login_poder")}}" class="btn-t3 btn btn-danger col-md-12">Iniciar sesión</a>    
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
@stop()