@extends("home.layout.master")
<!--extends("cv.layouts.master_default")-->
@section('content')

<div class="page-header" style="background: url({{url('assets/img/banner1.jpg')}});">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="breadcrumb-wrapper">
<h2 class="product-title">Nueva contraseña</h2>
<ol class="breadcrumb">
<li><a href="{{ route('home') }}"><i class="ti-home"></i> Inicio</a></li>
<li style="color: #ed8402;">Nueva contraseña</li>
</ol>
</div>
</div>
</div>
</div>
</div>

<section class="find-job section">
    <div class="container">
        <div class=" center-block">
            <div class="col-md-6 col-md-offset-3 fr_login">
                <h1 class="color">Recordar contraseña paso 2</h1>
                <p class="text-danger set-general-font-bold">
                    Registra una nueva contraseña
                </p>
                {!! Form::open(['route' => 'recordar_contrasena2']) !!}
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        {!! Form::label('email', 'Correo Electrónico') !!}
                        {!! Form::text('email',null,['class'=>'form-control','id'=>'email','placeholder'=>'Correo Electrónico','value'=>old('email')]) !!}
                        <p class="text-danger">{{ $errors->has('email')?$errors->first('email'):'' }}</p>
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Contraseña') !!}
                        {!! Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Contraseña']) !!}
                        <p class="text-danger">{{ $errors->has('password')?$errors->first('password'):'' }}</p>
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('password_confirmation', 'Verificar Contraseña') !!}
                        {!! Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','placeholder'=>'Verificar Contraseña']) !!}
                        <p class="text-danger"></p>
                    </div>

                    <div class="btn-container-aligned">
                        <button type="submit" class="btn btn-common btn-rm">Guardar <i class="fa fa-arrow-circle-o-right"></i></button>
                    </div>
                     <div class="">
                        <br>
                        <a href="{{route("login")}}" class="btn-t3 btn btn-danger col-md-12">Iniciar sesión</a>    
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>
@stop()