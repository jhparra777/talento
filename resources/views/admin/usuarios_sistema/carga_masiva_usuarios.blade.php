@extends("admin.layout.master")
@section("contenedor")   
    <!-- Mostrar los mensaje de error del cargue de la base de datos excel -->
    @if(Session::has("errores_global") && count(Session::get("errores_global")) > 0)
    <div class="col-md-12 mb-4">
        <a class="btn btn-default" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          Clic para ver mas detalles
        </a>
    </div>
    
    <div class="col-md-12">
        <div class="collapse" id="collapseExample">
            <div class="well">
                <div class="divScroll">
                    @foreach(Session::get("errores_global") as $key => $value)
                    <div class="alert @if($value['tipo']=='error') alert-danger @else alert-info @endif alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p><strong>{{$value["tipo"]}}:</strong> El registro de la linea numero <strong>{{++$key}}</strong> no se pudo cargar por los siguientes errores:</p>
                        
                        <ul>
                            @foreach($value["errores"] as $key2 => $value2)
                                <li>{{$value2}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                    {{--<div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    @foreach(Session::get("errores_global") as $key => $value)
                        <p>El registro de la linea numero <strong>{{++$key}}</strong> no se pudo cargar por los siguientes errores:</p>
                        
                        <ul>
                            @foreach($value as $key2 => $value2)
                                <li>{{$value2}}</li>
                            @endforeach
                        </ul>
                    @endforeach
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Mostrar el mensaje del total de registro que se cargaron a la base de datos. -->
    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {!! Session::get("mensaje_success") !!}
            </div>
        </div>
    @endif

     @if(Session::has("limite_maximo"))
        <div class="" id="mensaje-resultado">
            
            <div class="alert alert-danger alert-dismissible" role="alert">
                <span class="glyphicon glyphicon-info-sign" style="color: red; margin-right: 5px;"></span>
                {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}

                <strong>{{Session::get("limite_maximo")}}</strong>
                
            </div>
        </div>
    @endif

    <div class="col-md-12">
        <h3>
            Carga Masiva de usuarios admin
            <a type="button" class="btn btn-info" href="{{asset("plantilla_carga_masiva_admin.xlsx")}}" download="PlantillaCargaMasivaAdmin.xlsx">
                Descargar Plantilla
            </a>
        </h3>
    </div>

    {!! Form::model(Request::all(),["method"=>"post","route"=>"usuarios_masivos_cargar","files"=>true]) !!}
        <div class="col-md-12">
            <div class="form-group col-md-12">
                {!! Form::label('archivo', 'Archivo Plano Excel') !!}
        
                {!! Form::file('archivo',["class"=>"form-control-file"]) !!}
                
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("archivo",$errors) !!}</p>
            </div>

            {{--<div class="form-group col-md-6">
                {!! Form::label('archivo_carga', 'Archivo de Firmas *') !!}

                {!! Form::file('archivo_carga', ["class"=>"form-control-file", "accept" => ".pdf, .jpg, .jpeg, .png", "required"]) !!}
                
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("archivo_carga", $errors) !!}</p>
            </div>--}}
      
            {!! Form::submit("Cargar archivo",["class"=>"btn btn-success pull-left "]) !!}
        </div>
    {!! Form::close() !!}

    <div class="col-md-12 mt-4">
        <h3>
            Envio de Mensajes Masivo
            <a type="button" class="btn btn-info" href="{{asset('plantilla_envio_masivo_whatsapp.xlsx')}}" download="PlantillaEnvioMasivoWhatsapp.xlsx">
                Descargar Plantilla
            </a>
        </h3>
    </div>

    {!! Form::model(Request::all(),["method"=>"post","route"=>"mensajes_masivos_whatsapp","files"=>true]) !!}
        <div class="col-md-12 mb-4">
            <div class="form-group col-md-12">
                {!! Form::label('archivo_msj', 'Archivo Plano Excel*') !!}
        
                {!! Form::file('archivo_msj',["class"=>"form-control-file"]) !!}
                
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("archivo_msj",$errors) !!}</p>
            </div>

            <div class="form-group col-md-12">
                {!! Form::label('contenido_mensaje', 'Mensaje *') !!}

                <span>Datos que se pueden ingresar:</span>
                <a class="btn" onclick="insertar('nombre')" title="Insertar Nombres en el mensaje">Nombres</a>
                <a class="btn" onclick="insertar('apellido')" title="Insertar Apellidos en el mensaje">Apellidos</a>

                {!! Form::textarea("contenido_mensaje", null,
                    [
                        "class" => "form-control",
                        "id" => "contenido_mensaje",
                        "required"=>"required",
                        "rows" => "5"
                    ]);
                !!}
                
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("contenido_mensaje", $errors) !!}</p>
            </div>
      
            {!! Form::submit("Enviar Mensaje", ["class"=>"btn btn-success text-center"]) !!}
        </div>
    {!! Form::close() !!}

    <script>
        function insertar(variable) {
            let datoInsertar = '{nombres}';
            if (variable == 'apellido') {
                datoInsertar = '{apellidos}';
            }
            $('#contenido_mensaje').val($('#contenido_mensaje').val() + datoInsertar + ' ');
            $('#contenido_mensaje').focus();
        }
    </script>
@stop