@extends("admin.layout.master")
@section("contenedor")
<!-- Mostrar los mensaje de error del cargue de la base de datos excel -->
    @if(Session::has("errores_global") && count(Session::get("errores_global")) > 0)
      <div class="col-md-12" id="mensaje-resultado">
            <div class="divScroll">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                @foreach(Session::get("errores_global") as $key => $value)
                <ul>
                  <li>{{$value}}</li>
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
      <h3>Carga Masiva Desde Otras Fuentes</h3>
    </div>

    @if($user->hasAccess("admin.cargar_bd"))
        {!! Form::model(Request::all(),["method"=>"post","route"=>"admin.carga_candidatos_fuentes","files"=>true,"id"=>"fr_carga","data-smk-icon"=>"glyphicon-remove-sign"]) !!}
            <br><br><br><br>
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    {!! Form::label('cargos', 'Lista de Cargos') !!}
                    {!! Form::select("cargos",$perfil_candidato,null,["class"=>"form-control","id"=>"cargos"]) !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("perfil_id",$errors) !!}</p>
                </div>

                {!! Form::hidden("motivo",$motivo_carga_db->id,null,["class"=>"form-control","id"=>"motivo"]) !!}
            </div>

            <div class="col-md-6">
                <div class="form-group col-md-12">
                    {!! Form::label('nombre_carga', 'Nombre Carga') !!}
                    {!! Form::text("nombre_carga",null,["class"=>"form-control","id"=>"nombre_carga"]) !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("nombre_carga",$errors) !!}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group col-md-12">
                    {!! Form::label('archivo', 'Archivo En csv') !!}
                    {!! Form::file('archivo',["class"=>"form-control-file"]) !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("archivo",$errors) !!}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group col-md-12">
                    {!! Form::label('claves','Palabras Clave (separados por coma (,))')!!}
                    {!! Form::text('claves',null,["class"=>"form-control","id"=>"claves","data-role"=>"tagsinput","placeholder"=>"electricista,plomero","required"=>true]) !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("claves",$errors) !!}</p>
                </div>
            </div>

            <br><br><br><br><br>
            <div class="col-md-12">
                <div class="col-md-6">
                    {!! Form::submit("Cargar archivo",["class"=>"btn btn-success "]) !!}
                </div>
            </div>
        {!! Form::close() !!}
    @endif


@stop