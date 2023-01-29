@extends("admin.layout.master")
@section("contenedor")
    <div class="col-md-8 col-md-offset-2">
        {!! Form::open(["id"=>"fr_tipos_documentos","route"=>"admin.tipos_documentos.guardar","method"=>"POST"]) !!}
            {!! Form::hidden("active",1 ,["id"=>"active" ]); !!}
            {!! Form::hidden("codigo",1 ,["id"=>"codigo" ]); !!}

            <h3>Nuevo tipos documentos</h3>
            
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
                    <label for="descripcion" class="col-sm-4 control-label">Descripción:</label>
                    <div class="col-sm-8">
                        {!! Form::text("descripcion", null, ["class" => "form-control", "placeholder" => "Descripción" ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center" style="{{ ($errors->has('descripcion') ? '' : 'display: none;') }}">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
                </div>

                <div class="col-md-12 form-group">
                    <label for="categoria" class="col-sm-4 control-label">Categoría de documento:</label>
                    <div class="col-sm-8">
                        {!! Form::select("categoria", $categorias, null, ["class" => "form-control", "id" => "categoria"]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center" style="{{ ($errors->has('categoria') ? '' : 'display: none;') }}">{!! FuncionesGlobales::getErrorData("categoria", $errors) !!}</p>    

                    <div class="col-md-12" id="mensaje-categoria" style="display: none; margin-top: 5px;">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Para esta categoría, el tipo de documento se asociará a todos los cargos para todos los clientes.
                        </div>
                    </div>
                </div>

                <div class="col-md-12 form-group" style="display: none;" id="div-carga-candidato">
                    <label for="carga_candidato" class="col-sm-4 control-label">Lo carga el candidato?:</label>
                    <div class="col-sm-8">
                        {!! Form::select("carga_candidato", ["1" => "SI", "0" => "NO"], null, ["class" => "form-control", "id" => "carga_candidato"]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center" style="{{ ($errors->has('carga_candidato') ? '' : 'display: none;') }}">{!! FuncionesGlobales::getErrorData("carga_candidato",$errors) !!}</p>    
                </div>
            </div>

            <div class="clearfix" ></div>

            {!! FuncionesGlobales::valida_boton_req("admin.tipos_documentos.guardar","Guardar","submit","btn btn-success") !!}
            <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
        {!! Form::close() !!}
    </div>
    <script type="text/javascript">
        $(function() {
            $('#categoria').change(function() {
                $("#codigo").val('1');
                $("#carga_candidato").val('0');
                $("#div-carga-candidato").hide();
                if ($('#categoria').val() == '4' || $('#categoria').val() == '3') {
                    $('#mensaje-categoria').show();
                    if ($('#categoria').val() == '3') {
                        $("#codigo").val('CG');
                    }
                } else {
                    $('#mensaje-categoria').hide();
                    if ($('#categoria').val() == '1') {
                        $("#div-carga-candidato").show();
                    }
                }
            })
        })
    </script>
@stop