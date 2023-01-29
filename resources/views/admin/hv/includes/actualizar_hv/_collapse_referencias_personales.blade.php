<div class="row">
    <div class="col-md-12 mb-2">
        <h4 class="tri-fw-600 tri-fs-20">
            <span data-toggle="tooltip" data-placement="top" title="Por favor relacione todas las referencias personales."><i class="fa fa-info-circle" aria-hidden="true"></i></span> 
            Referencias @if(route('home') == "https://gpc.t3rsc.co" || route('home') == "https://humannet.t3rsc.co") Laborales @else Personales @endif <small>Los campos con asterisco (*) son obligatorios.</small>
        </h4>
    </div>
</div>

<div class="row" id="container_referencia">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading | tri-bg--none" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" href="#collapseReferenciasPersonales" aria-expanded="true" aria-controls="collapseReferenciasPersonales">
                        Información referencia
                    </a>
        
                    <a class="pull-right" role="button" data-toggle="collapse" href="#collapseReferenciasPersonales" aria-expanded="true" aria-controls="collapseReferenciasPersonales">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                </h4>
            </div>
        
            <div id="collapseReferenciasPersonales" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    {{-- Formulario referencias --}}
                    {!! Form::open(["class" => "form-datos-basicos", "role" => "form", "id" => "fr_datos_referencia"]) !!}
                        {!! Form::hidden("user_id", $datos_basicos->user_id) !!}
                        {!! Form::hidden("numero_id", $datos_basicos->numero_id) !!}
                        {!! Form::hidden("id", null, ["class" => "id_modificar_referencia", "id" => "id_modificar_referencia"]) !!}

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ref_nombres">Nombres: <span class='text-danger sm-text-label'>*</span> </label>
                            
                                {!! Form::text("nombres", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                    "placeholder" => "Nombres", 
                                    "id" => "nombre_referencia",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ref_apellido1">
                                    @if(route('home') == "https://gpc.t3rsc.co") 
                                        Apellidos 
                                    @else 
                                        Primer apellido 
                                    @endif: <span class='text-danger sm-text-label'>*</span>
                                </label>
                                
                                {!! Form::text("primer_apellido", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "placeholder" => "Primer apellido",
                                    "id" => "primer_apellido_referencia",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        @if(route('home') == "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="empresa">Empresa: <span class='text-danger sm-text-label'>*</span></label>
                            
                                    {!! Form::text("empresa", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "placeholder" => "Empresa",
                                        "id" => "empresa",
                                        "required" => "required"
                                    ]) !!}
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ref_apellido2">Segundo apellido:</label>
                                    
                                    {!! Form::text("segundo_apellido", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                        "placeholder" => "Segundo Apellido", 
                                        "id" => "segundo_apellido_referencia"
                                    ]) !!}
                                </div>
                            </div>
                        @endif
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_relacion">
                                    Tipo relación @if(route('home') == "https://gpc.t3rsc.co") Laboral @endif: <span class='text-danger sm-text-label'>*</span>
                                </label>
            
                                {!! Form::select("tipo_relacion_id", $tipoRelaciones, null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "id" => "tipo_relacion_referencia",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono_movil">Teléfono móvil: <span class='text-danger sm-text-label'>*</span> </label>
            
                                {!! Form::text("telefono_movil", null, [
                                    "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "placeholder" => "Teléfono móvil",
                                    "id" => "telefono_movil_referencia",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        @if(route('home') == "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="correo">Correo electrónico: <span class='text-danger sm-text-label'>*</span></label>
                            
                                    {!!Form::text("correo", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "placeholder" => "Correo",
                                        "id" => "correo",
                                        "required" => "required"
                                    ])!!}
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono_fijo">Teléfono fijo:</label>
                                
                                    {!! Form::text("telefono_fijo", null, [
                                        "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "placeholder" => "Teléfono fijo",
                                        "id" => "telefono_fijo_referencia"
                                    ]) !!}
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ref_ciudad">Ciudad: <span class='text-danger sm-text-label'>*</span></label>
            
                                {!! Form::hidden("codigo_pais", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "pais_id_ref"]) !!}
                                {!! Form::hidden("codigo_ciudad", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "ciudad_id_ref"]) !!}
                                {!! Form::hidden("codigo_departamento", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "departamento_id_ref"]) !!}
            
                                {!! Form::text("ciudad_autocomplete", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "id" => "ciudad_autocomplete_referencia",
                                    "placeholder" => "Digita ciudad",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        @if(route('home') == "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cargo">Cargo de la persona: <span class='text-danger sm-text-label'>*</span></label>
            
                                    {!!Form::text("cargo", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "placeholder" => "Cargo",
                                        "id" => "cargo",
                                        "required" => "required"
                                    ])!!}
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ocupacion">Ocupación: <span class='text-danger sm-text-label'>*</span> </label>
            
                                    {!! Form::select("ocupacion", ["" => "Seleccionar", "empleado" => "EMPLEADO", "desempleado" => "DESEMPLEADO"], null, [
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
                                id="actualizar_referencia" 
                                style="display: none;">
                                Actualizar referencias
                            </button> 
                
                            <button 
                                type="button"
                                class="btn btn-default btn-block | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red" 
                                id="cancelar_referencia" 
                                style="display: none;">
                                Cancelar
                            </button>
                
                            <button 
                                type="button" 
                                class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green"
                                id="guardar_referencia_personal">
                                Guardar referencias
                            </button>
                        </div>
                    {!! Form::close() !!}

                    {!! Form::open(["id" => "grilla_datos_referencia"]) !!}
                        <div class="col-md-12 mt-6">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-center" id="table_referencias">
                                    <thead>
                                        <tr>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Teléfono móvil</th>
                                            <th>Teléfono fijo</th>
                                            <th>Tipo relación</th>
                                            <th>Ciudad</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($referencias as $referencia)
                                            <tr id="tr_{{ $referencia->id }}">
                                                <td>{{ $referencia->nombres }}</td>
                                                <td>{{ $referencia->primer_apellido." ".$referencia->segundo_apellido  }}</td>
                                                <td>{{ $referencia->telefono_movil }}</td>
                                                <td>{{ $referencia->telefono_fijo }}</td>
                                                <td>{{ $referencia->relacion }}</td>
                                                <td>{{ $referencia->ciudad_seleccionada }}</td>
                                                <td>
                                                    {!! Form::hidden("id", $referencia->id, ["id" => $referencia->id]) !!}

                                                    <button 
                                                        type="button" 
                                                        class="btn btn-default btn-peq editar_referencia disabled_referencia | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple">
                                                        Editar <i class="fa fa-pen"></i>
                                                    </button>

                                                    <button 
                                                        type="button" 
                                                        class="btn btn-danger btn-peq eliminar_referencia disabled_referencia | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red">
                                                        Eliminar <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="registro_nulo">
                                                <td colspan="7">No hay registros</td>
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