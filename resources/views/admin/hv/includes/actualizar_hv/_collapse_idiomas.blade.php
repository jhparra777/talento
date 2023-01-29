{{-- Idiomas --}}
<div class="row">
    <div class="col-md-12 mb-2">
        <h4 class="tri-fw-600 tri-fs-20">
            <span data-toggle="tooltip" data-placement="top" title="Por favor relacione todos los idiomas que domina."><i class="fa fa-info-circle" aria-hidden="true"></i></span> 
            Idiomas <small>Los campos con asterisco (*) son obligatorios.</small>
        </h4>
    </div>
</div>

{{-- Formulario estudios --}}
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading | tri-bg--none" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" href="#collapseIdiomas" aria-expanded="true" aria-controls="collapseIdiomas">
                        Información idioma
                    </a>

                    <a class="pull-right" role="button" data-toggle="collapse" href="#collapseIdiomas" aria-expanded="true" aria-controls="collapseIdiomas">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                </h4>
            </div>

            <div id="collapseIdiomas" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    {{-- Formulario estudios --}}
                    {!! Form::open(["role" => "form", "id" => "fr_idioma"])!!}
                        {!! Form::hidden("id",null,["class"=>"e_idioma_id", "id"=>"e_idioma_id"]) !!}
                        {!! Form::hidden("user_id", $datos_basicos->user_id) !!}

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="idioma_autocomplete">Idioma: <span class='text-danger sm-text-label'>*</span></label>

                                {!! Form::hidden("id_idioma", null, ["class"=>"form-control", "id"=>"id_idioma"]) !!}
                
                                {!! Form::text("idioma", null, [
                                    "class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "placeholder"=>"Digite idioma",
                                    "id"=>"idioma_autocomplete",
                                    "required" => "required"
                                ])!!}
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nivel">Nivel idioma: <span class='text-danger sm-text-label'>*</span></label>

                                {!! Form::select("nivel", $niveles, null, ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id"=>"nivel", "required"]) !!}
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="col-md-12 text-right">
                            <button 
                                class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                                type="button" 
                                id="actualizar_idioma" 
                                style="display: none;">
                                Actualizar idioma
                            </button>

                            <button 
                                class="btn btn-default btn-block | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red" 
                                type="button" 
                                id="cancelar_idioma" 
                                style="display: none;">
                                Cancelar
                            </button>

                            <button 
                                class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                                type="button" 
                                id="guardar_idioma">
                                Guardar idioma
                            </button>
                        </div>
                    {!! Form::close() !!}

                    {{-- Lista de estudios (Tabla) --}}
                    {!! Form::open(["id" => "grilla_datos_idiomas"]) !!}
                        <div class="col-md-12 mt-6">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-center" id="table_idiomas">
                                    <thead>
                                        <tr>
                                            <th>Idioma</th>
                                            <th>Nivel</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($idiomas as $idioma)
                                            <tr id="tr_idioma_{{ $idioma->id }}">
                                                <td>{{ $idioma->nombre_idioma->descripcion }}</td>
                                                <td>{{ $idioma->nivel_idioma->descripcion }}</td>

                                                <td>
                                                    {!! Form::hidden("id", $idioma->id, ["id" => $idioma->id]) !!}

                                                    <button type="button" class="btn btn-default btn-peq editar_idioma disabled_idioma | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple" data-id="{{ $idioma->id }}">
                                                        Editar <i class="fa fa-pen"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-default btn-peq eliminar_idioma disabled_idioma | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red" data-id="{{ $idioma->id }}">
                                                        Eliminar <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="registro_nulo_idioma">
                                                <td colspan="3">No  hay registros</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>  
</div>