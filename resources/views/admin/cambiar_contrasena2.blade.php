@extends("admin.layout.master")
@section("contenedor")

<!-- Inicio contenido principal -->
<h3 class="header-section-form">Cambiar Clave <span class='text-danger sm-text-label' style="font-size: 14px"> Campos con asterisco(*) son obligatorios</span></h3>
    <div class="col-lg-8 col-md-offset-2">

        {!! Form::open(["route"=>"admin.actualizar_contrasena_admin","class"=>"form-horizontal form-datos-basicos", "role"=>"form","method"=>"post"]) !!}
        <div class="row">
            
            <div class="col-md-12">
                <p class="text-primary set-general-font-bold ">
                    *Por seguridad cambia regularmente tu clave.*			      	 
                </p>

            </div>
            @if(Session::has("mensaje"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get("mensaje")}}
                </div>
            </div>
            @endif
            <div class="col-sm-6 col-lg-12">
                <div class="form-group">
                    <label for="descripcion_documentos" class="col-md-4 control-label">Clave Actual:<span class='text-danger sm-text-label'>*</span> </label>
                    <div class="col-md-6">

                        {!! Form::password("contrasena_ant",["class"=>"form-control" , "placeholder"=>"Clave Anterior" ]) !!}
                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("contrasena_ant",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-12">
                <div class="form-group">
                    <label for="clave_nueva" class="col-md-4 control-label">Clave Nueva:<span class='text-danger sm-text-label'>*</span> </label>
                    <div class="col-md-6">

                        {!! Form::password("contrasena",["class"=>"form-control" , "placeholder"=>"Nueva Clave " ]) !!}
                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("contrasena",$errors) !!}</p>
            </div>
            <div class="col-sm-6 col-lg-12">
                <div class="form-group">
                    <label for="repetir_clave" class="col-md-4 control-label">Repite Clave Nueva:<span class='text-danger sm-text-label'>*</span> </label>
                    <div class="col-md-6">

                        {!! Form::password("contrasena_confirmation",["class"=>"form-control" , "placeholder"=>"Repetir Clave Nueva" ]) !!}

                    </div>
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("contrasena_confirmation",$errors) !!}</p>
            </div>
        </div><!-- fin row -->
        <a class="btn btn-warning" href="{{route("req_index")}}">Volver</a>
        <p class="col-lg-9 set-margin-top">
            <button class="btn btn-success btn-gra pull-right " type="submit" ><i class="fa fa-floppy-o"></i>&nbsp;Cambiar Clave</button>

        </p>
        {!! Form::close() !!}<!-- /.fin form -->
    </div><!-- /.container -->

<!-- Fin contenido principal -->
@stop