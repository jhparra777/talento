<div class="row">
    <div class="col-md-12 mb-2">
        <h4 class="tri-fw-600 tri-fs-20">
            <span data-toggle="tooltip" data-placement="top" title="Por favor relacione todos los beneficiarios / personas a cargo."><i class="fa fa-info-circle" aria-hidden="true"></i></span> 
            Grupo familiar <small>Los campos con asterisco (*) son obligatorios.</small>
        </h4>
    </div>
</div>

<div class="row" id="grupo_container">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading | tri-bg--none" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" href="#collapseGrupoFamiliar" aria-expanded="true" aria-controls="collapseGrupoFamiliar">
                        Información grupo familiar
                    </a>
        
                    <a class="pull-right" role="button" data-toggle="collapse" href="#collapseGrupoFamiliar" aria-expanded="true" aria-controls="collapseGrupoFamiliar">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                </h4>
            </div>
        
            <div id="collapseGrupoFamiliar" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    {{-- Formulario grupo familiar --}}
                    {!! Form::open(["class" => "form-datos-basicos", "role" => "form", "id" => "fr_grupo"]) !!}
                        {!! Form::hidden("user_id", $datos_basicos->user_id) !!}
                        {!! Form::hidden("numero_id", $datos_basicos->numero_id) !!}
                        {!! Form::hidden("id", null, ["class" => "id_modificar_familiar", "id" => "id_modificar_familiar"]) !!}

                        @if(route('home') != "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_documento">
                                        Tipo documento: 
                                        @if(route('home') != "https://vym.t3rsc.co" && route('home')!= "https://listos.t3rsc.co") 
                                            <span class='text-danger sm-text-label'>*</span> 
                                        @endif 
                                    </label>
            
                                    {!! Form::select("tipo_documento", $selectores->tipoDocumento, null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "tipo_documento_familiar",
                                        "required" => "required"
                                    ]) !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documento_identidad"># Documento: <span class='text-danger sm-text-label'>*</span></label>
                            
                                    {!! Form::text("documento_identidad", null, ["class" => "form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "documento_identidad_familiar", "required" => "required"]) !!}
                                </div>
                            </div>
                        @endif
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombres">Nombres: <span class='text-danger sm-text-label'>*</span></label>
                                
                                {!! Form::text("nombres", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "placeholder" => "Nombres", 
                                    "id" => "nombres_familiar",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ref_apellido1">Primer apellido: <span class='text-danger sm-text-label'>*</span> </label>
                            
                                {!! Form::text("primer_apellido", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "placeholder" => "Primer apellido",
                                    "id" => "primer_apellido_familiar",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        @if(route('home')!= "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ref_apellido2">Segundo apellido:</label>
                            
                                    {!! Form::text("segundo_apellido", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "placeholder" => "Segundo apellido",
                                        "id" => "segundo_apellido_familiar"
                                    ]) !!}
                                </div>
                            </div>
                        @endif
            
                        @if(route('home') != "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="escolaridad_id_familiar">Nivel estudio: <span class='text-danger sm-text-label'>*</span></label>
            
                                    {!!Form::select("escolaridad_id", $selectores->escolaridad, null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "escolaridad_id_familiar",
                                        "required" => "required"
                                    ])!!}
                                </div>
                            </div>
                        @endif
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parentesco_id_familiar">Parentesco: <span class='text-danger sm-text-label'>*</span></label>
                            
                                {!! Form::select("parentesco_id", $selectores->parentesco, null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "id" => "parentesco_id_familiar",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        @if(route('home')!= "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="genero_familiar">Género: <span class='text-danger sm-text-label'>*</span></label>
                            
                                    {!! Form::select("genero",$selectores->genero, null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "genero_familiar",
                                        "required" => "required"
                                    ]) !!}
                                </div>
                            </div>
                        @endif
            
                        @if(route('home')!= "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_nacimiento">Fecha nacimiento: <span class='text-danger sm-text-label'>*</span></label>
            
                                    {!! Form::text("fecha_nacimiento", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "fecha_nacimiento_familiar",
                                        "placeholder" => "Fecha nacimiento",
                                        "required" => "required"
                                    ]) !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ciudad_nacimiento">Ciudad nacimiento: <span class='text-danger sm-text-label'>*</span></label>
                                
                                    {!! Form::hidden("codigo_pais_nacimiento", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "pais_id_familia_nac"]) !!}
                                    {!! Form::hidden("codigo_ciudad_nacimiento", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "ciudad_id_familia_nac"]) !!}
                                    {!! Form::hidden("codigo_departamento_nacimiento", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "departamento_id_familia_nac"]) !!}
            
                                    {!! Form::text("ciudad_autocomplete_familia_nacimiento", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "ciudad_autocomplete_familia_nacimiento",
                                        "placeholder" => "Digita ciudad",
                                        "required" => "required"
                                    ]) !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profesion">Profesión: <span class='text-danger sm-text-label'>*</span></label>
                            
                                    {!! Form::text("profesion_id", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "placeholder" => "Profesión",
                                        "id" => "profesion_id",
                                        "required" => "required"
                                    ]) !!}
                                </div>
                            </div>
                        @else
                            <div id="rangoedad" class="col-md-6">
                                <div class="form-group">
                                    <label for="escolaridad">Rango Edad:</label>
            
                                    {!! Form::select("rango_edad", ['' => "Seleccione...", '0-5' => "0-5", '6-10' => "6-10", '11-15' => "11-15", '16-20' => "16-20", '21-25' => "21-25", '26-30' => "26-30", '31-35' => "31-35", '36-40' => "36-40", '41-45' => "41-45", '45-50' => "45-50", '50-mas' => "50-mas"], null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "rango_edad"
                                    ]) !!}
                                </div>
                            </div>
                        @endif

                        @if(route('home') == "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ocupacion">Ocupación: <span class='text-danger sm-text-label'>*</span> </label>
            
                                    {!! Form::text("ocupacion", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "ocupacion_referencia",
                                        "required" => "required"
                                    ])!!}
                                </div>
                            </div>
                        @endif

                        <div class="col-md-12 text-right">
                            <button 
                                type="button"
                                class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                                id="actualizar_familiar" 
                                style="display: none;">
                                Actualizar grupo familiar
                            </button> 
                
                            <button 
                                type="button"
                                class="btn btn-default btn-block | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red" 
                                id="cancelar_familiar" 
                                style="display: none;">
                                Cancelar
                            </button>
                
                            <button 
                                type="button"
                                class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                                id="guardar_familia">
                                Guardar grupo familiar
                            </button>
                        </div>
                    {!! Form::close() !!}

                    {!! Form::open(["id" => "grilla_datos_familia"]) !!}
                        <div class="col-md-12 mt-6">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-center" id="tbl_familia">
                                    <thead>
                                        <tr>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>

                                            @if(route('home')!= "https://gpc.t3rsc.co")
                                                <th># Identidad</th>
                                                <th>Género</th>
                                            @endif

                                            @if(route('home')!= "https://gpc.t3rsc.co")
                                                <th>Fecha Nacimiento</th>
                                                <th>Ciudad Nacimiento</th>
                                                <th>Escolaridad</th>
                                            @endif
                                            
                                            <th>Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($familiares as $familiar)
                                            <tr id="tr_{{$familiar->id}}">
                                                <td>{{$familiar->nombres}}</td>
                                                <td>{{$familiar->primer_apellido." ".$familiar->segundo_apellido}}</td>
                                                
                                                @if(route('home')!= "https://gpc.t3rsc.co")
                                                    <td>{{$familiar->documento_identidad}}</td>
                                                    <td>{{$familiar->genero}}</td>
                                                @endif

                                                @if(route('home')!= "https://gpc.t3rsc.co")
                                                    <td>@if ($familiar->fecha_nacimiento != "") {{$familiar->fecha_nacimiento}} @endif</td>
                                                    <td>@if(!empty($familiar->getLugarNacimiento())) {{$familiar->getLugarNacimiento()->ciudad }} @endif</td>
                                                    <td>{{$familiar->escolaridad}}</td>
                                                @endif

                                                <td>
                                                    {!! Form::hidden("id", $familiar->id, ["id" => $familiar->id]) !!}
                                                    
                                                    <button type="button" class="btn btn-default btn-peq editar_familiar disabled_familia | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple">
                                                        Editar <i class="fa fa-pen"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-default btn-peq eliminar_familia disabled_familia | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red">
                                                        Eliminar <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="no_registros">
                                                <td colspan="8"> No registros</td>
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