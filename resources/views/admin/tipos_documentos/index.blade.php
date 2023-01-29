@extends("admin.layout.master")
@section("contenedor")
    <h3>Lista de Tipos Documentos</h3>

    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
                {{ Session::get("mensaje_success") }}
            </div>
        </div>
    @endif

    {!! Form::model(Request::all(),["id"=>"admin.tipos_documentos.index","method"=>"GET"]) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6 form-group">
                    <label for="descripcion" class="col-sm-3 control-label">Descripción:</label>
                    <div class="col-sm-9">
                        {!! Form::text("descripcion", null, ["class" => "form-control","placeholder" => "Descripción", "id" => "descripcion"]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion", $errors) !!}</p>    
                </div>

                <div class="col-md-6 form-group">
                    <label for="active" class="col-sm-3 control-label">Estado:</label>
                    <div class="col-sm-9">
                        {!! Form::select("active", ["" => "- Seleccionar -", "1" => "Activo", "0" => "Inactivo"], null, ["class" => "form-control", "id" => "active"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("active", $errors) !!}</p>    
                </div>

                <div class="col-md-6 form-group">
                    <label for="categoria" class="col-sm-3 control-label">Categoría:</label>
                    <div class="col-sm-9">
                        {!! Form::select("categoria", $categorias, null, ["class" => "form-control", "id" => "categoria"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("categoria", $errors) !!}</p>    
                </div>
            </div>

            <div class="col-md-12">
                <button class="btn btn-warning" >Buscar</button>
                <a class="btn btn-warning" href="{{ route("admin.tipos_documentos.index") }}" >Limpiar</a>
                {!! FuncionesGlobales::valida_boton_req("admin.tipos_documentos.nuevo","Nuevo ","link","btn btn-info") !!}
                {{--
                {!! FuncionesGlobales::valida_boton_req("admin.tipos_documentos.editar","Editar","link","btn btn-warning",'onclick="return conf_registro(\'id[]\', this)"') !!}
                <a onclick="return redireccionar_registro('id[]', this, 'urlasociar')" class="btn btn-primary">Asociar cargos</a>
                --}}
            </div>
        </div>
    {!! Form::close() !!}

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @if($listas->count() == 0)
            <tr>
                <td colspan="3">No se encontraron registros</td>
            </tr>
            @endif
            @foreach($listas as $lista)
            <tr>
                <td>{{$lista->descripcion}}</td>
                <td>{{$lista->categorias->descripcion}}</td>
                <td>{{$lista->fullEstado()}}</td>
                <td>
                    <a class="btn btn-warning" href="{{ route('admin.tipos_documentos.editar',['id'=>$lista->id]) }}">Editar</a>
                    <a class="btn btn-primary" href="{{ route('admin.tipos_documentos.asociar_cargos',['id'=>$lista->id]) }}">Asociar cargos</a>
                    {{--
                    {!! Form::checkbox("id[]",$lista->id,null,["data-url"=>route('admin.tipos_documentos.editar',["id"=>$lista->id]), "data-urlasociar"=>route('admin.tipos_documentos.asociar_cargos',["id"=>$lista->id])]) !!}
                    --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {!! $listas->appends(Request::all())->render() !!}
@stop