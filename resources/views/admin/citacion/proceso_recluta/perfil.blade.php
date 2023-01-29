@extends("admin.layout.master")
@section("contenedor")
    
    <!-- Mostrar los mensaje de error del cargue de la base de datos excel -->
    @if(Session::has("errores_global") && count(Session::get("errores_global")) > 0)
        <div class="col-md-12" id="mensaje-resultado">
            <div class="divScroll">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                @foreach(Session::get("errores_global") as $key => $value)
                <p>EL registro de la linea numero {{++$key}} tiene los siguientes errores</p>
                <ul>
                    @foreach($value as $key2 => $value2)
                    <li>{{$value2}}</li>
                    @endforeach
                </ul>
                @endforeach
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

    <div class="col-md-12">
        <h3>Carga Masiva por perfilamiento</h3>
    </div>

    @if($user->hasAccess("admin.cargar_bd"))
        {!! Form::model(Request::all(),["method"=>"post","route"=>"admin.perfil_db","files"=>true]) !!}
        <br><br><br><br>
        <div class="col-md-12">
                <div class="form-group col-md-6">
                    <a type="button" class="btn btn-info" href="{{asset("plantilla_carga_masiva_n.xlsx")}}" download="PlantillaCargaMasiva">
                        Descargar Plantilla
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    {!! Form::label('perfil_id', 'Seleccionar Perfil') !!}
                    {!! Form::select("perfil_id",$perfil_candidato,null,["class"=>"form-control","id"=>"perfil"]) !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("perfil_id",$errors) !!}</p>
                </div>
                 <div class="form-group col-md-12">
                    {!! Form::hidden("motivo",$motivo_carga_db->id,null,["class"=>"form-control","id"=>"motivo"]) !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("motivo",$errors) !!}</p>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    {!! Form::label('archivo', 'Archivo Plano Excel') !!}
                    {!! Form::file('archivo',["class"=>"form-control-file"]) !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("archivo",$errors) !!}</p>
                </div>
                <br><br><br><br><br>
                {!! Form::submit("Cargar archivo",["class"=>"btn btn-success "]) !!}
            </div>
        {!! Form::close() !!}
    @endif
{!! Form::close() !!}

@stop