@extends("admin.layout.master")
@section("contenedor")
    <div class="col-md-8 col-md-offset-2">
        {!! Form::model($registro,["id" => "fr_tipos_documentos", "route" => "admin.tipos_documentos.actualizar", "method" => "POST"]) !!}
            {!! Form::hidden("id") !!}
            {!! Form::hidden("categoria") !!}
            {!! Form::hidden("codigo") !!}

            <h3>Editar Tipos Documentos</h3>
            
            <div class="clearfix"></div>
            
            @if(Session::has("mensaje_success"))
                <div class="col-md-12" id="mensaje-resultado">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get("mensaje_success") }}
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Descripción:</label>
                    <div class="col-sm-8">
                        {!! Form::text("descripcion", null, ["class" => "form-control", "placeholder" => "Descripción" ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion", $errors) !!}</p>    
                </div>

                <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Estado:</label>
                    <div class="col-sm-8">
                        {!! Form::select("active", [""=>"Seleccionar", "1" => "Activo", "0" => "Inactivo"], null, ["class" => "form-control" ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("active", $errors) !!}</p>    
                </div>

                <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Categoría de documento:</label>
                    <div class="col-sm-8">
                        <input type="text" id="categoria" class="form-control" value="{{ $registro->categorias->descripcion }}" readonly="readonly">
                    </div>
                </div>

                <div class="col-md-12 form-group" style="{{ ($registro->categoria != 1 ? 'display: none;' : '') }}">
                    <label for="carga_candidato" class="col-sm-4 control-label">Lo carga el candidato?:</label>
                    <div class="col-sm-8">
                        {!! Form::select("carga_candidato", ["1" => "SI", "0" => "NO"], null, ["class" => "form-control", "id" => "carga_candidato"]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center" style="{{ ($errors->has('carga_candidato') ? '' : 'display: none;') }}">{!! FuncionesGlobales::getErrorData("carga_candidato",$errors) !!}</p>    
                </div>
            </div>

            <div class="clearfix" ></div>

            {!! FuncionesGlobales::valida_boton_req("admin.tipos_documentos.actualizar","Actualizar","submit","btn btn-success") !!}
            
            <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
        {!! Form::close() !!}
    </div>
@stop