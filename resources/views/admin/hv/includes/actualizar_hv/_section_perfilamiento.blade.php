<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h4 class="tri-fw-600 tri-fs-20">
                <span data-toggle="tooltip" data-placement="top" title="Por favor seleccione todos los perfiles que se adapten."><i class="fa fa-info-circle" aria-hidden="true"></i></span> 
                Perfilamiento <small>Los campos con asterisco (*) son obligatorios.</small>
            </h4>
        </div>
    </div>
</div>
{{--
<div class="row">
    <div class="col-md-12" hidden>
        <div class="alert alert-info | tri-br-1 tri-blue tri-border--none" role="alert">
            Por favor relacione sus estudios finalizados / <strong>Perfilamiento.</strong>
            Seleccionar todos sus perfiles y luego dar clic en "Guardar".
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="buscador-cargos">
                    {!! Form::open(["id" => "fr_busqueda", "onsubmit" => "return false"]) !!}
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Buscar perfil:</label>

                                <input 
                                    type="text" 
                                    name="txt-buscador-cargos" 
                                    id="txt-buscador-cargos" 
                                    class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                                >
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <button 
                                    type="button" 
                                    class="btn btn-default mt-2 | tri-br-2 tri-fs-12 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-200 tri-hover-out-blue" 
                                    name="btn-buscar-perfil" 
                                    id="btn_buscar_perfil">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
--}}
<div class="row">
    {!! Form::open(["class" => "form-datos-basicos", "role" => "form", "id" => "guardar_perfil"]) !!}
        {!! Form::hidden("user_id",$datos_basicos->user_id) !!}
    
        @if(Session::has("mensaje"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible | tri-br-1 tri-green tri-border--none" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get("mensaje") }}
                </div>
            </div>
        @endif

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12 mb-2">
                        <div class="form-group">
                            <label for="ocupacion">
                                Seleccione el área: <span class='text-danger sm-text-label'></span>
                            </label>
                            <select class="form-control tag-cargo | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" id="tag-cargo" name="tipo_cargo">
                                <option value=""> Seleccione... </option>
                                @foreach($tipo_cargos as $tipo_cargo)
                                    <option value="{{$tipo_cargo->id}}">
                                        {{$tipo_cargo->descripcion}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="ocupacion">
                                Seleccione cargo: <span class='text-danger sm-text-label'></span>
                            </label>
                            <select class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" id="container_perfilamiento" name="cargo_generico_id[]">
                                <option value="">Seleccione....</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Cargos seleccionados --}}
        <div class="col-md-4" id="cargos_seleccionados">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <h4>
                            Cargos seleccionados <i class="fa fa-check-square" aria-hidden="true"></i>
                        </h4>
                    </div>

                    @foreach($cargos_seleccionados as $key => $cargo)
                        <div class="col-md-12">
                            <div class="alert alert-info | tri-br-1 tri-d-blue tri-border--none">
                                <div id="bloque_{{ $key }}">
                                    <h5 class="set-general-font-bold title-seleccionados">{{ $cargo["name"] }}</h5>

                                    @foreach($cargo["item"] as $item =>$value_item)
                                        <div id="item_cargo_{{ $item }}" class="flex-container-cargo-seleccionado">
                                            <div class="flex-item-cargo-seleccionado-icon"><i class="fa fa-times"></i></div>

                                            <div class="flex-item-cargo-seleccionado-texto set-general-font">{{ $value_item }}</div>
                                            <input type="hidden" name="cargo_generico_id[]" value="{{ $item }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-12 text-right">
            <button 
                type="button"
                class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                id="guardar_perfil_seleccionado">
                Guardar perfilamiento
            </button>
        </div>
    {!! Form::close() !!}
</div>