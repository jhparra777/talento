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
            <h1 class="h1-login-t3">Pre - Registro</h1>
            {!! Form::open(['route' => 'process_registro_poder',"autocomplete"=>"off"]) !!}
            {!! Form::hidden("google_key",null) !!}
            {!! Form::hidden("facebook_key",null) !!}
            {!! Form::hidden("empresa_registro","poder") !!}
            <div class="form-group">
                {!! Form::label('identificacion', 'Cédula') !!}
                {!! Form::text('identificacion',null,['class'=>'form-control-t3','id'=>'identificacion','placeholder'=>'# Identificación','value'=>old('identificacion')]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("identificacion",$errors) !!}</p>
            </div>
            <div class="form-group">
                {!! Form::label('name', 'Nombres') !!}
                {!! Form::text('name',null,['class'=>'form-control-t3','id'=>'name','placeholder'=>'Nombres','value'=>old('name')]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
            </div>
            <div class="form-group">
                {!! Form::label('primer_apellido', 'Primer Apellido') !!}
                {!! Form::text('primer_apellido',null,['class'=>'form-control-t3','id'=>'primer_apellido','placeholder'=>'Primer Apellido','value'=>old('primer_apellido')]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
            </div>
            <div class="form-group">
                {!! Form::label('segundo_apellido', 'Segundo Apellido') !!}
                {!! Form::text('segundo_apellido',null,['class'=>'form-control-t3','id'=>'segundo_apellido','placeholder'=>'Segundo Apellido','value'=>old('segundo_apellido')]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Correo Electrónico') !!}
                {!! Form::text('email',null,['class'=>'form-control-t3','id'=>'email','placeholder'=>'Correo Electrónico','value'=>old('email')]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
            </div>
            <div class="form-group">
                {!! Form::label('telefono_fijo', 'Teléfono Fijo') !!}
                {!! Form::text('telefono_fijo',null,['class'=>'form-control-t3','id'=>'telefono_fijo','placeholder'=>'Teléfono Fijo','value'=>old('telefono_fijo')]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
            </div>
            <div class="form-group">
                {!! Form::label('telefono_movil', 'Teléfono Móvil') !!}
                {!! Form::text('telefono_movil',null,['class'=>'form-control-t3','id'=>'telefono_movil','placeholder'=>'Teléfono Móvil']) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_movil",$errors) !!}</p>
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Contraseña') !!}
                {!! Form::password('password',['class'=>'form-control-t3','id'=>'password','placeholder'=>'Contraseña']) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("password",$errors) !!}</p>
            </div>
            <div class="form-group">
                {!! Form::label('password_confirmation', 'Verificar Contraseña') !!}
                {!! Form::password('password_confirmation',['class'=>'form-control-t3','id'=>'password_confirmation','placeholder'=>'Verificar Contraseña']) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("password_confirmation",$errors) !!}</p>
            </div>
            <div class="form-group">
                {!! Form::label('fuente', 'Porque medio se entero de nosotros') !!}
                {!! Form::select("contacto_externo",
                [
                ""=>"Seleccionar",
                "referidos"=>"Referidos",
                "facebook"=>"Facebook",
                "clasificados"=>"Clasificados",
                "alcaldias"=>"Alcaldias",
                "emisoras"=>"Emisoras",
                "ferias_empresariales"=>"Ferias empresariales",
                "agencias_empleo"=>"Agencias de empleo"
                ]
                ,null,["class"=>"form-control-t3"]) !!}

                <p class="text-danger"></p>
            </div>
            <div class="form-group">
                {!! Form::label('acepto_politicas', 'Acepto políticas de privacidad') !!}&nbsp;&nbsp;
                {!! Form::checkbox('acepto_politicas', '1',false,['class'=>'checkbox-preferencias','id'=>'acepto_politicas']) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("acepto_politicas",$errors) !!}</p>
            </div>
            <div class="btn-container-aligned">
                {!! Form::button('Regístrarse <i class="fa fa-arrow-circle-o-right"></i>',['type'=>'submit', 'class'=>'btn-t3 btn-2']) !!}
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
@stop()