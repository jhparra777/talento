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
        <h3>Carga Masiva</h3>
    </div>

    @if($user->hasAccess("admin.cargar_bd"))  
        {!! Form::model(Request::all(),["method"=>"post","route"=>"admin.reclutamiento_db","files"=>true]) !!}
            <div class="col-md-12">
                <div class="form-group col-md-6">
                    <a type="button" class="btn btn-info" href="{{ asset('plantilla_carga_masiva_v3.xlsx') }}" download="PlantillaCargaMasiva.xlsx">
                        Descargar Plantilla
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group col-md-12">
                    {!! Form::label('motivo', 'Motivo') !!}

                    {!! Form::select("motivo",$motivo_carga_db,null,["class"=>"form-control","id"=>"motivo"]) !!}
                    
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("motivo",$errors) !!}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group col-md-12">
                    {!! Form::label('nombre_carga', 'Nombre Carga') !!}
            
                    {!! Form::text("nombre_carga",null,["class"=>"form-control","id"=>"nombre_carga"]) !!}
                    
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("nombre_carga",$errors) !!}</p>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group col-md-12">
                    {!! Form::label('archivo', 'Archivo Plano Excel') !!}
            
                    {!! Form::file('archivo',["class"=>"form-control-file", "accept" => ".xlsx, .xls, .csv"]) !!}
                    
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
    @endif
{!! Form::close() !!}
@stop