@extends("home.layout.master")
<!-- extends("cv.layouts.master_default")-->
<style type="text/css">
        .form-group input[type=file] {
            opacity: 1 !important;
            position: inherit !important;
            height: auto !important;
        }
</style>
@section('content')
    <section id="counter">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Crea tu cuenta</h2>
                        
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{route('home')}}" style="color: {{$sitio->color}}">
                                    <i class="ti-home"></i> Inicio
                                </a>
                            </li>

                            <li class="current">Crea tu cuenta</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="find-job section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="my-account-form formulario-registro">
                        <h1 class="color">Pre - Registro</h1>

                            @if(Session::has("email_verificacion"))
                                <div class="" id="mensaje-resultado">
                                    
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <span class="glyphicon glyphicon-info-sign" style="color: red; margin-right: 5px;"></span>
                                        {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}

                                        <strong>{{Session::get("email_verificacion")}}</strong>
                                        
                                    </div>
                                </div>
                            @endif
                        
                        {!! Form::open(['id'=>"fr_pre",'route' => 'process_registro',"autocomplete"=>"off", "files"=>true]) !!}
                            {!! Form::hidden("google_key",null) !!}
                            {!! Form::hidden("facebook_key",null) !!}
                            {!! Form::hidden("empresa_registro","T3RS") !!}
                            
                            <div class="form-group">
                                <label for="identificacion">
                                    @if(route('home') == "https://gpc.t3rsc.co") cédula de identidad @else Número de Identificación @endif
                                    <span style="color: red;">*</span>
                                    @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Personal Identification Number @endif 
                                </label>
                                
                                {!! Form::number('identificacion', null, [
                                    'class' => 'form-control solo-numero',
                                    'id' => 'identificacion',
                                    'placeholder' => '# Identificación',
                                    'value' => old('identificacion'),
                                    "maxlength" => "16",
                                    "min" => "1",
                                    "max" => "9999999999999999",
                                    'pattern' => "[0-9]{5,16}",
                                    'oncopy' => "return false",
                                    'onpaste' => "return false"
                                ]) !!}

                                <p class="text-danger">{!! FuncionesGlobales::getErrorData("identificacion",$errors) !!}</p>
                            </div>

                            <div class="form-group">
                                <label for="identificacion">
                                    Confirmar 
                                    @if(route('home') == "https://gpc.t3rsc.co") cédula de identidad @else Número de Identificación @endif
                                    <span style="color: red;">*</span> 
                                    @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") / Confirmation Personal Identification Number @endif
                                </label>

                                {!! Form::number('c-identificacion', null, [
                                    'class' => 'form-control solo-numero',
                                    'id' => 'c-identificacion',
                                    'placeholder' => '# Identificación',
                                    'value' => old('identificacion'),
                                    "maxlength" => "16",
                                    "min" => "1",
                                    "max" => "9999999999999999",
                                    'pattern' => "[0-9]{5,16}",
                                    'oncopy' => "return false",
                                    'onpaste' => "return false"
                                ]) !!}
                                
                                <p class="text-danger">{!! FuncionesGlobales::getErrorData("identificacion", $errors) !!}</p>
                            </div>
                            
                            {{--<div class="form-group">
                                <label for="name">Nombres
                                    <span style="color: red;">*</span>
                                    @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Name @endif
                                </label>

                                {!! Form::text('name', null, ['class' => 'form-control','id' => 'name','placeholder' => 'Nombres','value' => old('name')]) !!}
                                <p class="text-danger">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
                            </div>--}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primer_apellido"> Primer Nombre <span style="color: red;">*</span>@if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /First Surname @endif 
                                        </label>

                                        {!! Form::text('primer_nombre', null, [
                                            'class' => 'form-control',
                                            'id' => 'primer_nombre',
                                            'placeholder' => 'Primer Nombre',
                                            'value' => old('primer_nombre')
                                        ]) !!}

                                        <p class="text-danger">{!! FuncionesGlobales::getErrorData("primer_nombre",$errors) !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="segundo_apellido">
                                            Segundo Nombre @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Second surname @endif
                                        </label>
                        
                                        {!! Form::text('segundo_nombre', null, [
                                            'class' => 'form-control',
                                            'id' => 'segundo_nombre',
                                            'placeholder' => 'Segundo Nombre',
                                            'value' => old('segundo_nombre')
                                        ]) !!}
                                        
                                        <p class="text-danger">{!! FuncionesGlobales::getErrorData("segundo_nombre",$errors) !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primer_apellido"> Primer Apellido <span style="color: red;">*</span>@if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /First Surname @endif 
                                        </label>

                                        {!! Form::text('primer_apellido', null, [
                                            'class' => 'form-control',
                                            'id' => 'primer_apellido',
                                            'placeholder' => 'Primer Apellido',
                                            'value' => old('primer_apellido')
                                        ]) !!}

                                        <p class="text-danger">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="segundo_apellido">
                                            Segundo Apellido @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Second surname @endif
                                        </label>
                        
                                        {!! Form::text('segundo_apellido', null, [
                                            'class' => 'form-control',
                                            'id' => 'segundo_apellido',
                                            'placeholder' => 'Segundo Apellido',
                                            'value' => old('segundo_apellido')
                                        ]) !!}
                                        
                                        <p class="text-danger">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono_fijo">@if(route("home")=="https://humannet.t3rsc.co") Red Fija @else Teléfono Fijo @endif  @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Phone @endif
                                        </label>
                        
                                        {!! Form::number('telefono_fijo', null, [
                                            'class' => 'form-control solo-numero',
                                            'id' => 'telefono_fijo',
                                            "maxlength" => "7",
                                            "min" => "1",
                                            "max" => "9999999",
                                            "pattern" => ".{1,7}",
                                            'placeholder' => 'Teléfono Fijo',
                                            'value' => old('telefono_fijo')
                                        ]) !!}
                        
                                        <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_fijo", $errors) !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono_movil"> Teléfono Móvil <span style="color: red;">*</span> @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Cell Phone @endif
                                        </label>

                                        {!! Form::number('telefono_movil', null, [
                                            'class' => 'form-control solo-numero',
                                            'id' => 'telefono_movil',
                                            "maxlength" => "10",
                                            "min" => "1",
                                            "max" => "9999999999",
                                            "pattern" => ".{1,10}",
                                            'placeholder' => 'Teléfono Móvil'
                                        ]) !!}

                                        <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_movil",$errors) !!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Correo Electrónico 
                                    <span style="color: red;">*</span>

                                    <span tabindex="0" data-toggle="tooltip" title="Asegúrese de que al digitar su correo electrónico no hayan espacios al inicio y al final">
                                        <i class="fa fa-question-circle-o" aria-hidden="true"
                                        style="position: initial; top: 0px;"></i>
                                    </span>

                                    @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Email @endif
                                </label>
                
                                {!! Form::text('email', null, ['class' => 'form-control','id' => 'email','placeholder' => 'Correo electrónico','value' => old('email')]) !!}
                                
                                <p class="text-danger">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
                            </div>
 
                            @if(route('home') == "http://komatsu.t3rsc.co")
                                <div class="form-group">
                                    {!! Form::label('Nivel Estudios', 'Nivel Estudios:') !!}

                                    {!! Form::select("nivel_estudio_id",$nivelEstudios,null,["class"=>"form-control","id"=>"nivel_estudio_id"]) !!}
                
                                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("nivel_estudio_id",$errors) !!}</p>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="password">
                                    Contraseña <span style="color: red;">*</span> @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Password @endif <span> @if(route("home")!="https://expertos.t3rsc.co") (Coloca tu Cédula como Contraseña) @endif</span>
                                </label>

                                {!! Form::password('password',['autocomplete'=>"off",'class'=>'form-control','id'=>'password','placeholder'=>'Contraseña']) !!}
                                
                                <p class="text-danger">{!! FuncionesGlobales::getErrorData("password",$errors) !!}</p>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Verificar Contraseña @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Password Confirmation @endif </label>

                                {!! Form::password('password_confirmation', [
                                    'class' => 'form-control',
                                    'id' => 'password_confirmation',
                                    'placeholder' => 'Verificar Contraseña'
                                ]) !!}

                                <p class="text-danger">{!! FuncionesGlobales::getErrorData("password_confirmation",$errors) !!}</p>
                            </div>


                            <div class="form-group">
                                <label for="archivo_documento">
                                    Adjunta CV <span class="text-left">Formato (jpg, png, jpeg, pdf, doc, docx)</span>
                                </label>

                                <input type="file" class="" name="archivo_documento" id="archivo_documento" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" >

                                <p class="text-danger">
                                    {!!FuncionesGlobales::getErrorData("archivo_documento", $errors)!!}
                                </p>
                            </div>

                            <div class="form-group">
                                <label for="fuente">
                                    ¿Cómo te enteraste de nosotros? @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /How did you hear about us? @endif
                                </label>
                
                                {!! Form::select("contacto_externo", $como, null,["class"=>"form-control"]) !!}
                                <p class="text-danger"></p>
                            </div>
                            
                            <!--
                            <div class="form-group " style="text-align:">

                                <label for="captcha" class="col-md-8 control-label"></label>
                                <div  name="g-recaptcha-response " class="g-recaptcha " data-sitekey="6LeuvVIUAAAAABZ679eazL6JYVfTydB8qfPbv8iK"></div>

                            </div>
                            -->
                            @foreach( $tipos_politicas as $tipo_politica )
                                @php
                                    $ultima_politica = $tipo_politica->politicasPrivacidad->last();
                                @endphp

                                @continue($ultima_politica == null)

                                <div class="form-group">
                                    <label for="acepto_politicas_privacidad_{{$ultima_politica->id}}">
                                        {{$tipo_politica->titulo_boton_aceptar_politica}}
                                        @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Privacy Politic @endif
                                    </label>

                                    {!! Form::checkbox('acepto_politicas_privacidad', 1, false, ['class' => 'checkbox-preferencias', 'id' => 'acepto_politicas_privacidad_'.$ultima_politica->id, 'required']) !!}

                                    {!! Form::hidden('politicas_privacidad_id[]', $ultima_politica->id) !!}
                                    
                                    <span style="color: red;">*</span>

                                    <a target="_blank" href="{{ route('admin.aceptacionPoliticaTratamientoDatos', ['politica_id' => $ultima_politica->id]) }}" class="btn btn-primary btn-xs"> Ver política de protección de datos</a>
                                </div>
                            @endforeach

                            <div class="btn-container-aligned">
                                {!! Form::button('Registrarse <i class="fa fa-arrow-circle-o-right"></i>',['type'=>'submit', 'class'=>'btn btn-common btn-rm regitro-send']) !!}
                            </div>
            
                            <div class="widget hidden">
                                <div class="bottom-social-icons social-icon"> 
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a class="linkedin" href="{{ route('social.auth', 'linkedin') }}">
                                            <i class="ti-linkedin"></i> Registrate con Linkedin</a> 
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <a class="google-plus" href="{{ route('social.auth', 'google') }}">
                                            <i class="ti-google"></i> Registrate con Google</a>
                                        </div>

                                        <div class="col-md-4">
                                            <a class="facebook" href="{{ route('social.auth', 'facebook') }}">
                                            <i class="ti-facebook"></i> Registrate con Facebook</a>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <script>
                /*este codigo muestra los botones de "aceptar" y "cerrar" del modal de POLITICA DE PROTECCION DE DATOS*/
                $('#activaBotonesModal').click(function(e){
                    $('#botonesTratamientoDatos').show();
                });


                
                $(function () {
                    //****************para tiempos *******************************////////
                    $("#fr_pre").submit(function(){
                        $(".regitro-send").prop("disabled",true);
                    })
                    $("#identificacion").on('paste', function(e){
                        e.preventDefault();
                        alert('Esta acción está prohibida');
                    })
              
                    $("#identificacion").on('copy', function(e){
                        e.preventDefault();
                        alert('Esta acción está prohibida');
                    })

                    $('.input-number').on('input', function () { 
                        this.value = this.value.replace(/[^0-9]/g,'');
                    });

                    $(document).on('input', "[maxlength]", function (e) {
                        e.preventDefault();

                        var esto = $(this);
                        var maxlength = $(this).attr('maxlength');
                        var maxlengthint = parseInt(maxlength);
                        esto.siblings('p').html('');
                        
                        if(this.value.length > maxlengthint){
                            this.value = this.value.slice(0,maxlengthint);
                            esto.siblings('p').html('No debe ser mayor a '+maxlengthint+' caracteres');
                        }
                    });

                    //variables
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
                        console.log(valor1);
                        
                        //muestro el span
                        span.show().removeClass();
                        //condiciones dentro de la función
                        if((valor1 != valor2) && (valor2 !="")){
                            span.css("color", "red");
                            span.text(negacion);
                            $('.regitro-send').attr('disabled',true);
                        }
                        // if(valor1.length==0 || valor1==""){
                        // span.text(vacio);  
                        // }

                        // if(valor1.length<1 || valor1.length>16){
                            // span.text(longitud);
                        // }

                        if(valor1.length!=0 && valor1==valor2){
                            span.css("color", "skyblue");
                            span.text(confirmacion);
                            $('.regitro-send').removeAttr('disabled');
                        }
                    }

                    //ejecuto la función al soltar la tecla
                    pass2.on('keyup',function(){
                        coincidePassword();
                    });

                    pass1.on('keyup',function(){
                        coincidePassword();
                    });

                    //clave.focus(function(event) {
                    /* Act on the event */
                    // $('.mensaje1').remove();
                    // $('<span class="mensaje1">Coloca tu Cedula como Contraseña</span>').insertAfter(this);
                    // });
                });
            </script>
        </div>
    </section>
@stop()