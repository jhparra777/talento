@extends("home.layout.master")
<!--extends("admin.layout.master_login")-->
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
            <div class="col-md-3">  
            </div>
            <div class="col-md-6 fr_registro">
                <h1 class="color">Recordar contraseña paso 1</h1>
                @if(Session::has('status'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ Session::get('status') }}
                    </div>
                @else
                    <p class="text-danger set-general-font-bold">
                     Digita el correo electrónico registrado en la plataforma.
                    </p>
                @endif

                {!! Form::open(['route' => 'admin.recordar_email']) !!}
                    <div class="form-group">
                      {!! Form::label('email', 'Correo Electrónico') !!}
                      {!! Form::text('email',null,['class'=>'form-control','id'=>'email','placeholder'=>'Correo Electrónico','value'=>old('email')]) !!}
                       <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
                    </div>

                    <div class="btn-container-aligned">
                      <button type="submit" class="btn btn-common btn-rm">Recordar <i class="fa fa-arrow-circle-o-right"></i></button>
                    </div>
                      <div class="">
                       <br>
                       <a href="{{route("admin.login")}}" class="btn-t3 btn btn-danger col-md-12">Iniciar sesión</a>    
                    </div>
                {!! Form::close() !!}
            </div>
        <div class="col-md-3"></div>
        </div>
    </div>
</section>
@stop()