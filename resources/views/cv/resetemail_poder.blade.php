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
            <h1 class="h1-login-t3">Recordar contraseña paso 1</h1>
            @if(Session::has('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ Session::get('status') }}
            </div>
            @else

            <p class="text-danger set-general-font-bold">Digita el correo electrónico registrado en la plataforma. </p>
            @endif

            {!! Form::open(['route' => 'recordar_email2_poder']) !!}
            <div class="form-group">
                {!! Form::label('email', 'Correo Electrónico') !!}
                {!! Form::text('email',null,['class'=>'form-control-t3','id'=>'email','placeholder'=>'Correo Electrónico','value'=>old('email')]) !!}
                <p class="text-danger">{{ $errors->has('email')?$errors->first('email'):'' }}</p>
            </div>

            <div class="btn-container-aligned">
                <button type="submit" class="btn-t3 btn-2">Recordar <i class="fa fa-arrow-circle-o-right"></i></button>
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