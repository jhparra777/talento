@extends("admin.layout.master")
@section("contenedor")
<style>
    .confirmacion{background:#C6FFD5;border:1px solid green;}
    .negacion{background:#ffcccc;border:1px solid red}
</style>
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Editar hoja de vida", 'more_info' => $datos_basicos->fullname()])

    {{-- DATOS BÁSICOS --}}
    {{-- @if($req != "")
        <a class="btn btn-default pull-right" href="{{route("admin.gestion_requerimiento",["req_id"=>$req])}}"> Volver al req {{$req}}</a>
    @endif --}}

    {{-- <div class="row">
        <div class="col-md-12 mb-2">
            <h3>Editar hoja de vida</h3>
        </div>
    </div> --}}

    @if($sitioModulo->modifica_datos_contacto == 'enabled')
        {{-- Datos de contacto --}}
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="page-header">
                        <h4 class="tri-fw-600">
                            Datos de contacto <small>Los campos con asterisco (*) son obligatorios.</small>
                        </h4>
                    </div>
                </div>

                {!! Form::model($datos_basicos, [
                    "class" => "form-datos-basicos",
                    "id" => "fr_datos_contacto",
                    "role" => "form",
                    "method" => "POST"
                ]) !!}

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primer_nombre-pre-registro">Primer nombre: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::text("primer_nombre", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "primer_nombre-pre-registro",
                                            "placeholder" => "Primer nombre",
                                            "required" => "required"
                                        ]) !!}

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_nombre", $errors) !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="segundo_nombre-pre-registro">Segundo nombre:</label>

                                        {!! Form::text("segundo_nombre", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "segundo_nombre-pre-registro",
                                            "placeholder" => "Segundo nombre",
                                        ]) !!}

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_nombre", $errors) !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primer_apellido-pre-registro">Primer apellido: <span class='text-danger sm-text-label'>*</span></label>
                                        
                                        {!! Form::text("primer_apellido", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "primer_apellido-pre-registro",
                                            "placeholder" => "Primer apellido",
                                            "required" => "required"
                                        ]) !!}
                                    </div>
                        
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="segundo_apellido-pre-registro">Segundo Apellido: </label>

                                        {!! Form::text("segundo_apellido", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "segundo_apellido-pre-registro",
                                            "placeholder" => "Segundo apellido"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_id">
                                            {{-- Para GPC
                                                Cédula de identidad: 
                                            --}}
                                            Número de identificación: 
                                            <span class='text-danger sm-text-label'>*</span>
                                        </label>

                                        {!! Form::number("numero_id", null, [
                                            "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "numero_id-pre-registro" ,
                                            "maxlength" => "16",
                                            "min" => "1",
                                            "max" => "9999999999999999",
                                            "pattern" => ".{1,16}",
                                            "placeholder" => "Identificación",
                                            "required" => "required"
                                        ]) !!}
                                    </div>
                                    
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_id", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email-pre-registro">Correo electrónico: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::text("email", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "email-pre-registro",
                                            "placeholder" => "Correo electrónico",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono_movil-pre-registro">Número de celular: <span class='text-danger sm-text-label'>*</span></label>
                                        
                                        {!! Form::text("telefono_movil", null, [
                                            "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "telefono_movil-pre-registro",
                                            "placeholder" => "Número de celular",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo", $errors) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 text-right">
                        <button 
                            type="button"
                            class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                            id="guardar_datos_contacto">
                            Guardar datos de contacto
                        </button>
                    </div>

                    <div id="container_tab"></div>
                {!! Form::close() !!}
            </div>
        {{-- Fin datos de contacto}}
    @endif

    @if($sitioModulo->modifica_datos_contacto == 'enabled')
        {{-- Scripts datos de contacto --}}
        @include('admin.hv.includes.actualizar_hv.src.js._js_datos_contacto')
    @endif

    {{-- Información personal --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="page-header">
                    <h4 class="tri-fw-600">
                        Información Personal <small>Los campos con asterisco (*) son obligatorios.</small>
                    </h4>
                </div>
            </div>

            {!! Form::model($datos_basicos, [
                "class" => "form-datos-basicos",
                "id" => "fr_datos_basicos",
                "role" => "form",
                "route" => ["admin.hv_actualizada",$datos_basicos->user_id],
                "method" => "POST",
                "files" => true
            ]) !!}              {!! Form::hidden("user_id", null, ['id' => 'userId']) !!}

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @if(route("home") == "https://komatsu.t3rsc.co")
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_id">Imagen personal:</label>
                                        
                                        {!! Form::file("foto", [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                            "id" => "foto", 
                                            "name" => "foto", 
                                            "accept" => ".jpg,.jpeg,.png"
                                        ]) !!}

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("foto", $errors) !!}</p>
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primer_nombre">Primer nombre: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::text("primer_nombre", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "primer_nombre",
                                            "placeholder" => "Primer nombre",
                                            "required" => "required"
                                        ]) !!}

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres", $errors) !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="segundo_nombre">Segundo nombre:</label>

                                        {!! Form::text("segundo_nombre", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "segundo_nombre",
                                            "placeholder" => "Segundo nombre",
                                        ]) !!}

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres", $errors) !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primer_apellido">Primer apellido: <span class='text-danger sm-text-label'>*</span></label>
                                        
                                        {!! Form::text("primer_apellido", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "name" => "primer_apellido",
                                            "id" => "primer_apellido",
                                            "placeholder" => "Primer apellido",
                                            "required" => "required"
                                        ]) !!}
                                    </div>
                        
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="segundo_apellido">Segundo Apellido: @if(route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif</label>

                                        {!! Form::text("segundo_apellido", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "segundo_apellido",
                                            "placeholder" => "Segundo apellido",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_id">Tipo de identificación: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::select("tipo_id", $tipos_documentos, null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "tipo_id",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_id", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_id">
                                            @if(route('home') == "https://gpc.t3rsc.co")
                                                Cédula de identidad
                                            @else
                                                Número de identificación
                                            @endif: <span class='text-danger sm-text-label'>*</span>
                                        </label>

                                        {!! Form::number("numero_id", null, [
                                            "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "numero_id" ,
                                            "maxlength" => "7",
                                            "min" => "1",
                                            "max" => "9999999",
                                            "pattern" => ".{1,7}",
                                            "placeholder" => "Identificación",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_id", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ciudad_id">
                                            Ciudad de expedición de la identificación: <span class='text-danger sm-text-label'>*</span>
                                        </label>

                                        {!! Form::hidden("pais_id", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "pais_id"]) !!}
                                        {!! Form::hidden("ciudad_expedicion_id", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "ciudad_id"]) !!}
                                        {!! Form::hidden("departamento_expedicion_id", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "departamento_id"]) !!}

                                        {!! Form::text("ciudad_autocomplete", $txtLugarExpedicion, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "ciudad_autocomplete",
                                            "placeholder" => "Digita ciudad",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_id", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_expedicion">Fecha expedición de la identificación: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::text("fecha_expedicion", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "fecha_expedicion",
                                            "placeholder" => "Fecha expedición",
                                            "readonly" => "readonly",
                                            "required" => "required"
                                        ]) !!}
                                    </div>
                        
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_expedicion_id", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pais_nacimiento">Lugar nacimiento: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::hidden("pais_nacimiento", null, ["id" => "pais_nacimiento"]) !!}
                                        {!! Form::hidden("departamento_nacimiento", null, ["id" => "departamento_nacimiento"]) !!}
                                        {!! Form::hidden("ciudad_nacimiento", null, ["id" => "ciudad_nacimiento"]) !!}

                                        {!! Form::text("txt_nacimiento", $txtLugarNacimiento, [
                                            "id" => "txt_nacimiento",
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "placeholder" => "Digita ciudad",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_nacimiento", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_nacimiento">Fecha nacimiento: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::text("fecha_nacimiento", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "fecha_nacimiento",
                                            "placeholder" => "Fecha Nacimiento",
                                            "readonly" => "readonly",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_nacimiento", $errors) !!}</p>
                                </div>

                                {{-- Aquí habia campo rh --}}

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="movil">Número de celular:</label>
                                        
                                        {!! Form::text("telefono_movil", null, [
                                            "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "telefono_fijo",
                                            "placeholder" => "Número de celular"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo", $errors) !!}</p>
                                </div>

                                {{-- Había número fijo --}}

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Correo electrónico: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::text("email", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "email",
                                            "placeholder" => "Correo electrónico",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email", $errors)!!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="aspiracion_salarial">Aspiración salarial: <span class='text-danger sm-text-label'>*</span></label>

                                        {{-- Había validación aspiración --}}

                                        {!! Form::select("aspiracion_salarial", $aspiracionSalarial, null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "aspiracion_salarial",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspiracion_salarial", $errors) !!}</p>
                                </div>

                                {{-- Había validación campos tallas --}}

                                {{-- Había validación de barrio, y otros --}}

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categoria_licencia">Tiene licencia: <span>*</span></label>
                                        
                                        {!! Form::select("tiene_licencia", ["" => "Seleccionar", "1" => "Si", "0" => "No"], null, [
                                            "class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "tiene_licencia",
                                            "required" => "required"
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categoria_licencia">Categoría licencia:</label>
                                        
                                        {!! Form::select("categoria_licencia", $categoriaLicencias, NULL, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "categoria_licencia"
                                        ])  !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("categoria_licencia", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="complemento">¿Tiene conflicto de intereses?</label>
                                        
                                        {!! Form::select("conflicto", ["" => "Seleccionar", "1" => "Si", "0" => "No"], null, [
                                            "class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "conflicto"
                                        ]) !!}

                                        <div class="text-right mt-1">
                                            <button 
                                                type="button" 
                                                class="btn btn-primary btn-sm | tri-br-2 tri-fs-10 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-300 tri-hover-out-blue" 
                                                data-toggle="modal" 
                                                data-target="#modalConflictoIntereses">
                                                Ver política de conflicto de intereses
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="complemento">¿Trabaja actualmente en Komatsu?</label>

                                        {!! Form::select("trabaja", ["" => "Seleccionar", "1" => "Si", "0" => "No"], null, [
                                            "class" => "form-control selectcategory| tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "trabaja"
                                        ]) !!}
                                    </div>
                                </div>

                                @if($datos_basicos->descripcion_conflicto && $datos_basicos->conflicto == 1)
                                    <div class="col-sm-6 col-lg-12" id="descripcion_conflicto">
                                        <div class="form-group">
                                            <label> ¿Qué parentezco tiene, los nombres y el área del trabajador?  / Caracteres restantes: </label>

                                            {!! Form::textarea("descripcion_conflicto", $datos_basicos->descripcion_conflicto, [
                                                "maxlength" => "550",
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                'rows' => 3,
                                                "id" => "descripcion_conflicto"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("barrio", $errors) !!}</p>
                                    </div>
                                @else
                                    <div class="col-sm-6 col-lg-12" style="display: none;" id="descripcion_conflicto">
                                        <div class="form-group">
                                            <label>¿Qué parentezco tiene, los nombres y el área del trabajador?  / Caracteres restantes:</label>
                                            
                                            {!! Form::textarea("descripcion_conflicto", null, [
                                                "maxlength" => "550",
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                'rows' => 3,
                                                "id" => "descripcion_conflicto"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("barrio", $errors) !!}</p>
                                    </div>
                                @endif

                                {{-- Había validación de perfil laboral --}}
                            @else
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_id">
                                            Foto(formato png, jpg o jpeg): 

                                            @if($user->foto_perfil != "" && $user->foto_perfil != null)
                                                <a 
                                                    class="tri-txt-gray" 
                                                    title="Visualizar foto de perfil" 
                                                    target="_blank" 
                                                    href="{{ url("recursos_datosbasicos/".$user->foto_perfil) }}" >
                                                    <i class="fa fa-eye"> </i> Ver
                                                </a>
                                            @endif
                                        </label>

                                        {!! Form::file("foto", [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "foto" ,
                                            "name" => "foto",
                                            "accept" => ".jpg,.jpeg,.png"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("foto", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="archivo_documento">
                                            @if(route("home") == "https://humannet.t3rsc.co")
                                                Currículo(.PDF, .DOC o .DOCX): 
                                            @else 
                                                Hoja de Vida(.PDF, .DOC o .DOCX):
                                            @endif 

                                            @if($hoja_vida != null)
                                                <a 
                                                    class="tri-txt-gray" 
                                                    title="Visualizar hoja de vida" 
                                                    target="_blank" 
                                                    href="{{ url("recursos_documentos/".$hoja_vida->nombre_archivo) }}">
                                                    <i class="fa fa-eye"></i> Ver
                                                </a>
                                            @endif
                                        </label>

                                        {!! Form::file("archivo_documento", [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "archivo_documento",
                                            "accept" => ".pdf,.doc,.docx"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("archivo_documento", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_id">Tipo identificación: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::select("tipo_id", $tipos_documentos, null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "tipo_id",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_id", $errors) !!}</p>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_id">
                                            @if(route('home') == "https://gpc.t3rsc.co")
                                                Cédula de identidad: 
                                            @else 
                                                Número de identificación: 
                                            @endif
                                            <span class='text-danger sm-text-label'>*</span>
                                        </label>

                                        {!! Form::number("numero_id", null, [
                                            "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "numero_id" ,
                                            "maxlength" => "16",
                                            "min" => "1",
                                            "max" => "9999999999999999",
                                            "pattern" => ".{1,16}",
                                            "placeholder" => "Identificación",
                                            "required" => "required"
                                        ]) !!}
                                    </div>
                                    
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_id", $errors) !!}</p>
                                </div>

                                @if(route("home") != "https://gpc.t3rsc.co")
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ciudad_id">
                                                Ciudad de 
                                                @if(route("home") == "https://humannet.t3rsc.co")
                                                    emisión 
                                                @else 
                                                    expedición 
                                                @endif 
                                                documento: <span class='text-danger sm-text-label'>*</span>
                                            </label>

                                            {!! Form::hidden("pais_id", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "pais_id_exp"]) !!}
                                            {!! Form::hidden("departamento_expedicion_id", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "departamento_id_exp"]) !!}
                                            {!! Form::hidden("ciudad_expedicion_id", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "ciudad_id_exp"]) !!}

                                            {!! Form::text("ciudad_autocomplete", $txtLugarExpedicion, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "ciudad_autocomplete",
                                                "placeholder" => "Digita ciudad",
                                                "required" => "required"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_id", $errors) !!}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_expedicion">
                                                Fecha 
                                                @if(route("home") == "https://humannet.t3rsc.co") 
                                                    emisión: 
                                                @else 
                                                    expedición: 
                                                @endif 
                                                <span class='text-danger sm-text-label'>*</span>
                                            </label>

                                            {!! Form::text("fecha_expedicion", null, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "fecha_expedicion",
                                                "placeholder" => "Fecha expedición",
                                                "readonly" => "readonly",
                                                "required" => "required"
                                            ])!!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_expedicion_id", $errors) !!}</p>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primer_nombre">Primer nombre: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::text("primer_nombre", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "primer_nombre",
                                            "placeholder" => "Primer nombre",
                                            "required" => "required"
                                        ]) !!}

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres", $errors) !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="segundo_nombre">Segundo nombre:</label>

                                        {!! Form::text("segundo_nombre", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "segundo_nombre",
                                            "placeholder" => "Segundo nombre",
                                        ]) !!}

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres", $errors) !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primer_apellido">Primer apellido: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::text("primer_apellido", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "name" => "primer_apellido",
                                            "id" => "primer_apellido",
                                            "placeholder" => "Primer apellido",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="segundo_apellido">Segundo apellido:</label>

                                        {!! Form::text("segundo_apellido", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "segundo_apellido",
                                            "placeholder" => "Segundo apellido"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_nacimiento">Fecha nacimiento: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::text("fecha_nacimiento", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "fecha_nacimiento",
                                            "placeholder" => "Fecha nacimiento",
                                            "readonly" => "readonly",
                                            "required" => "required"
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pais_nacimiento">Lugar nacimiento: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::hidden("pais_nacimiento", null, ["id" => "pais_nacimiento"]) !!}
                                        {!! Form::hidden("departamento_nacimiento", null, ["id" => "departamento_nacimiento"]) !!}
                                        {!! Form::hidden("ciudad_nacimiento", null, ["id" => "ciudad_nacimiento"]) !!}

                                        {!! Form::text("txt_nacimiento", $txtLugarNacimiento, [
                                            "id" => "txt_nacimiento",
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "placeholder" => "Digita ciudad",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_nacimiento", $errors) !!}</p>
                                </div>

                                @if(route('home') != "https://gpc.t3rsc.co")
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_nacimiento">Grupo sanguineo: <span class='text-danger sm-text-label'>*</span></label>

                                            {!! Form::select("grupo_sanguineo", ["" => "Seleccionar", "A" => "A", "B" => "B", "O" => "O", "AB" => "AB"], null, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "grupo_sanguineo",
                                                "required" => "required"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("rh", $errors) !!}</p>
                                    </div>

                                    <div class="col-md-6">   
                                        <div class="form-group">
                                            <label for="rh">RH: <span class='text-danger sm-text-label'>*</span></label>

                                            {!! Form::select("rh", ["" => "Seleccionar", "positivo" => "POSITIVO", "negativo" => "NEGATIVO"], null, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "rh",
                                                "required" => "required"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("rh", $errors) !!}</p>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="genero">Género: <span class='text-danger sm-text-label'>*</span></label>

                                            {!! Form::select("genero", $genero, null, [
                                                "id" => "genero",
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "required" => "required"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero", $errors) !!}</p>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado_civil">Estado civil: <span class='text-danger sm-text-label'>*</span></label>
                                        
                                        {!! Form::select("estado_civil", $estadoCivil, null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "estado_civil",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_civil", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="movil">Teléfono móvil: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::number("telefono_movil", null, [
                                            "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "telefono_fijo",
                                            "maxlength" => "10",
                                            "min" => "1",
                                            "max" => "9999999999",
                                            "pattern" => ".{1,10}",
                                            "placeholder" => "Móvil",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono_fijo">
                                            @if(route("home") == "https://humannet.t3rsc.co")
                                                Red fija: 
                                            @else 
                                                Teléfono fijo: 
                                            @endif 
                                        </label>

                                        {!! Form::number("telefono_fijo", null, [
                                            "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "telefono_fijo",
                                            "maxlength" => "7",
                                            "min" => "1",
                                            "max" => "9999999",
                                            "pattern"=>".{1,7}",
                                            "placeholder" => "Teléfono fijo"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Correo electrónico:<span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::email("email", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "email",
                                            "placeholder" => "Correo electrónico",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email", $errors) !!}</p>
                                </div>

                                @if(route("home") != "https://gpc.t3rsc.co")
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="aspiracion_salarial">Aspiración salarial: <span class='text-danger sm-text-label'>*</span></label>

                                            @if(route('home') == "http://localhost:8000" || route('home') == "https://soluciones.t3rsc.co" ||  route('home') == "https://desarrollo.t3rsc.co")
                                                {!! Form::text("aspiracion_salarial", null, [
                                                    "class" => "form-control input-number | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "id" => "aspiracion_salarial",
                                                    "min" => "1",
                                                    "required" => "required"
                                                ])!!}
                                            @else
                                                {!! Form::select("aspiracion_salarial", $aspiracionSalarial, null, [
                                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "id" => "aspiracion_salarial",
                                                    "required" => "required"
                                                ]) !!}
                                            @endif
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspiracion_salarial", $errors) !!}</p>
                                    </div>
                                @endif

                                @if(route('home') == "https://gpc.t3rsc.co")
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="aspiracion_salarial">Dirección de skype:</label>

                                            {!!Form::text("direccion_skype", $datos_basicos->direccion_skype, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "skype",
                                                "placeholder" => "skype"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("direccion_skype", $errors) !!}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="aspiracion_salarial">Otro telefono ubicación:</label>

                                            {!!Form::text("otro_telefono", $datos_basicos->otro_telefono, [
                                                "class" => "form-control input-number | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "otro_telefono",
                                                "placeholder" => ""
                                            ])!!}
                                        </div>

                                        <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("otro_telefono", $errors)!!} </p>
                                    </div>
                                @endif

                                {{--Tallas--}}
                                @if(route('home') != "https://gpc.t3rsc.co")
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="talla_zapatos">Talla zapatos:</label>

                                            {!! Form::select("talla_zapatos", $talla_zapatos, null, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "talla_zapatos"
                                            ]) !!}

                                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("talla_zapatos", $errors) !!}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="talla_camisa">Talla camisa:</label>

                                            {!! Form::select("talla_camisa", $talla_camisa, null, [
                                                "class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "talla_camisa"
                                            ]) !!}

                                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("talla_camisa", $errors) !!}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="talla_pantalon">Talla pantalón</label>

                                            {!! Form::select("talla_pantalon", $talla_pantalon, null, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "talla_pantalon"
                                            ]) !!}

                                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("talla_pantalon", $errors) !!}</p>
                                        </div>
                                    </div>
                                @endif

                                @if(route('home') != "https://gpc.t3rsc.co")
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            @if(route("home") == "https://humannet.t3rsc.co")
                                                <label for="entidad_eps">Fondo de salud: <span class='text-danger sm-text-label'>*</span></label>
                                            @else
                                                <label for="entidad_eps">Entidad(EPS): <span class='text-danger sm-text-label'>*</span></label>
                                            @endif

                                            {!! Form::select("entidad_eps", $entidadesEps, NULL, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "entidad_eps",
                                                "required" => "required"
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">   
                                        <div class="form-group">
                                            <label for="entidad_afp">Entidad(AFP): <span class='text-danger sm-text-label'>*</span></label>

                                            {!! Form::select("entidad_afp", $entidadesAfp, null, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "entidad_afp",
                                                "required" => "required"
                                            ]) !!}
                                        </div>
                                    </div>
                                @endif

                                @if(route('home') == "https://listos.t3rsc.co")
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="caja_compensaciones">Entidad (CAJA COMPENSACIÓN): <span class='text-danger sm-text-label'>*</span></label>

                                            {!! Form::select("caja_compensaciones", $caja_compensaciones, NULL, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "caja_compensaciones",
                                                "required" => "required"
                                            ]) !!}
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ciudad_residencia">Ciudad Residencia: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::hidden("pais_residencia", null, ["id" => "pais_residencia"]) !!}
                                        {!! Form::hidden("departamento_residencia", null, ["id" => "departamento_residencia"]) !!}
                                        {!! Form::hidden("ciudad_residencia", null, ["id" => "ciudad_residencia"]) !!}

                                        {!! Form::text("txt_residencia", $txtLugarResidencia, [
                                            "id" => "txt_residencia",
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "placeholder" => "Digita ciudad",
                                            "required" => "required"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("txt_residencia", $errors) !!}</p>
                                </div>

                                @if(route("home") != "https://gpc.t3rsc.co")
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="complemento">
                                                @if(route("home") == "https://humannet.t3rsc.co")
                                                    Comuna: 
                                                @else 
                                                    Barrio: 
                                                @endif
                                                <span class='text-danger sm-text-label'>*</span>
                                            </label>

                                            {!! Form::text("barrio", null, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "direccion",
                                                "placeholder" => "",
                                                "required" => "required"
                                            ]) !!}
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="complemento">Dirección: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::text("direccion", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "direccion",
                                            "placeholder" => "Dirección",
                                            "required" => "required"
                                        ]) !!}
                                    </div>
                                </div>

                                @if(route('home') == "https://gpc.t3rsc.co")
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipo_vivienda">Tipo vivienda:</label>

                                            {!! Form::select("tipo_vivienda", ['' => "Seleccionar", 'propia' => "Propia", 'alquilada' => "Alquilada", '0' => "otro"], $datos_basicos->tipo_vivienda, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "tipo_vivienda"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_vivienda", $errors) !!}</p>
                                    </div>

                                    <div class="col-md-6">  
                                        <div class="form-group">
                                            <label for="numero_hijos">Número hijos:</label>

                                            {!! Form::select("numero_hijos", ["N/A" => "N/A", "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5 o mas" => "5 o mas"], $datos_basicos->numero_hijos, [
                                                "class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "numero_hijos"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_hijos", $errors) !!}</p>
                                    </div>

                                    <div class="col-md-6">  
                                        <div class="form-group">
                                            <label for="edad_hijos">Edad hijos: <small>Separar por comas(,)</small></label>

                                            {!! Form::text("edad_hijos", $datos_basicos->edad_hijos, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "edad_hijos"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("edad_hijos", $errors)!!}</p>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estrato">Estrato:</label>

                                        {!! Form::select("estrato", ["" => "Seleccionar", "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6"], null, [
                                            "class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "estrato"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!!FuncionesGlobales::getErrorData("estrato", $errors)!!} </p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pertenece_grupo_poblacional">¿Pertenece a algún grupo poblacional?</label>

                                        {!! Form::select("pertenece_grupo_poblacional", ["0" => "No", "1" => "Si"], (is_null($datos_basicos->grupo_poblacional) || $datos_basicos->grupo_poblacional == "") ? 0 : 1, [
                                            "class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "pertenece_grupo_poblacional"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("pertenece_grupo_poblacional", $errors) !!}</p>
                                </div>

                                <div class="col-md-6" id="grupo_poblacional">
                                    <div class="form-group">
                                        <label for="select_grupo_poblacional">Grupo poblacional:</label>

                                        {!!Form::select("grupo_poblacional",[
                                                ""                  =>"Seleccionar", 
                                                "Afrodescendiente"  => "Afrodescendiente",
                                                "Indígena"          => "Indígena",
                                                "Población victima" => "Población victima",
                                                "Desmovilizados"    => "Desmovilizados",
                                                "Inclusión laboral" => "Inclusión laboral",
                                                "Otro" => "Otro"
                                            ], $datos_basicos->grupo_poblacional, [
                                            "class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "select_grupo_poblacional"
                                        ])!!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("grupo_poblacional", $errors) !!}</p>
                                </div>

                                <div class="col-md-6" id="otro_grupo">
                                    <div class="form-group">
                                        <label for="otro_grupo_poblacional">Describa otro grupo poblacional:</label>

                                        {!!Form::text("otro_grupo_poblacional", $datos_basicos->otro_grupo_poblacional, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "otro_grupo_poblacional"
                                        ])!!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("otro_grupo_poblacional", $errors) !!}</p>
                                </div>

                                <div class="col-md-6" id="situacion_militar">
                                    <div class="form-group">
                                        <label for="situacion_militar_definida">Situación Militar Definida:</label>

                                        {!! Form::select("situacion_militar_definida", ["" => "Seleccionar", "1" => "Si", "0" => "No"], null, [
                                            "class" => "form-control militar_situacion selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                                        ]) !!}
                                    </div>
                                </div>

                                <div id="libreta_militar">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="numero_libreta">No. Libreta: <span class='text-danger sm-text-label'>*</span></label>

                                            {!! Form::text("numero_libreta", null, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "numero_libreta",
                                                "placeholder" => "# Libreta Militar"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_libreta", $errors) !!}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="clase_libreta">Clase libreta: <span class='text-danger sm-text-label'>*</span></label>

                                            {!! Form::select("clase_libreta", $claseLibreta, null, [
                                                "id" => "clase_libreta",
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("clase_libreta", $errors) !!}</p>
                                    </div>
                            
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="distrito_militar"># Distrito Militar: <span class='text-danger sm-text-label'>*</span></label>

                                            {!! Form::text("distrito_militar", null, [
                                                "id" => "distrito_militar",
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "placeholder" => "Número distrito"
                                            ]) !!}
                                        </div>
                                        
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("distrito_militar", $errors) !!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        @if(route("home") == "https://humannet.t3rsc.co")
                                            <label for="tiene_vehiculo">¿Posee auto?:</label>
                                        @else  
                                            <label for="tiene_vehiculo">¿Tiene vehículo?:</label>
                                        @endif

                                        {!! Form::select("tiene_vehiculo", ["" => "Seleccionar", "1" => "Si", "0" => "No"], null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "tiene_vehiculo"
                                        ]) !!}
                                    </div>
                                </div>

                                @if(route("home") == "https://humannet.t3rsc.co")
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tiene_vehiculo"> Nivel estudio:</label>           
                                            
                                            {!!Form::select("nivel_estudio", $nivel_academico, null, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "nivel_estudio"
                                            ])!!}
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_vehiculo">Tipo vehículo: <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::select("tipo_vehiculo", $tipoVehiculo, null, [
                                            "id" => "tipo_vehiculo",
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_vehiculo", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="num_licencia"># Licencia:</label>
                                        
                                        {!! Form::text("numero_licencia", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "numero_licencia",
                                            "placeholder" => "# Licencia"
                                        ]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_licencia", $errors) !!}</p>
                                </div>

                                @if(route('home') == "https://gpc.t3rsc.co")
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipo_vehiculo">Tipo vehículo:</label>

                                            {!!Form::select("tipo_vehiculo_t", ['' => "Seleccione", 'propio' => "Propio", 'prendado' => "Prendado", '0' => "otro"], null, [
                                                "id" => "tipo_vehiculo_t",
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                                            ]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_vehiculo", $errors) !!}</p>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>¿Tiene cuenta bancaria activa?<span></span></label>

                                        {!! Form::select("tiene_cuenta_bancaria",[""=>"Seleccionar","1"=>"Sí","0"=>"No"],null,["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tiene_cuenta_bancaria"]) !!}
                                    </div>
                                        
                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("tiene_cuenta_bancaria",$errors) !!}
                                    </p>
                                </div>

                                <div class="banco col-md-6">
                                    <div class="form-group">
                                        <label>Nombre del Banco <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::select("nombre_banco", $bancos,null,["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"nombre_banco"]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("nombre_banco",$errors) !!}
                                    </p>
                                </div>

                                <div class="banco col-md-6">
                                    <div class="form-group">
                                        <label>Tipo Cuenta <span class='text-danger sm-text-label'>*</span></label>

                                        {!! Form::select("tipo_cuenta", ["" => "Sleccionar", "Ahorro" => "Ahorro", "Corriente" => "Corriente"],null,["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_cuenta"]) !!}
                                    </div>
                                        
                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("tipo_cuenta",$errors) !!}
                                    </p>
                                </div>

                                <div class="banco col-md-6">
                                    <div class="form-group">
                                        <label>Número Cuenta <span class='text-danger sm-text-label'>*</span></label>
                                        <input
                                            type="number"
                                            name="numero_cuenta"
                                            class="form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                                            value="{{ ($datos_basicos->numero_cuenta != 0) ? $datos_basicos->numero_cuenta : '' }}"
                                            id="numero_cuenta"
                                        >
                                    </div>
                                    
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta", $errors) !!}</p>
                                </div>

                                <div class="banco col-md-6">
                                    <div class="form-group">
                                        <label>Confirmar Cuenta <span class='text-danger sm-text-label'>*</span></label>
                                        <input
                                            type="number"
                                            name="numero_cuenta_confirmation"
                                            class="form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                                            id="confirm_numero_cuenta"
                                            value="{{ ($datos_basicos->numero_cuenta != 0) ? $datos_basicos->numero_cuenta : '' }}"
                                            >
                                    </div>
                                    
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta_confirmation", $errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contacto_emergencia">Nombre contacto emergencia: </label>

                                        {!! Form::text("contacto_emergencia",null,[
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "contacto_emergencia",
                                            "placeholder" => ""
                                        ]) !!}
                                    </div>
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("contacto_emergencia",$errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="parentesco_contacto_emergencia">Parentesco Contacto emergencia: </label>

                                        {!! Form::text("parentesco_contacto_emergencia",null,[
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "parentesco_contacto_emergencia",
                                            "placeholder" => "Parentesco"
                                        ]) !!}
                                       
                                    </div>
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("parentesco_contacto_emergencia",$errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono_emergencia">Número telefono contacto emergencia: </label>

                                        {!! Form::text("telefono_emergencia",null,[
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "telefono_emergencia",
                                            "placeholder" => ""
                                        ]) !!}

                                    </div>
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_emergencia",$errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correo_emergencia">Correo contacto emergencia:</label>

                                        {!! Form::email("correo_emergencia",null,[
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "correo_emergencia",
                                            "placeholder" => "Correo electrónico emergencia"
                                        ]) !!}
                                        <p class="error text-danger direction-botones-center">
                                       {!!FuncionesGlobales::getErrorData("correo_emergencia",$errors)!!} </p>
                                    </div>
                                </div>

                                {{-- Perfil profesional --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descripción de su perfil profesional:</label>
                                        
                                        {!! Form::textarea("descrip_profesional", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            'rows' => 3,
                                            "id" => "descrip_profesional",
                                            "placeholder" => "Escribe aca tu descripcion profesional. Máximo 550 caracteres."
                                        ])!!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descrip_profesional", $errors) !!} </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if(route("home") == "https://gpc.t3rsc.co")
                    {{-- Descripción de objetivos --}}
                    <div class="col-md-12" id="info-adicional">
                        @include('admin.hv.includes.actualizar_hv._collapse_descripcion_objetivos')
                    </div>

                    {{-- Disponibilidad condiciones trabajo --}}
                    <div class="col-md-12" id="info-adicional">
                        @include('admin.hv.includes.actualizar_hv._collapse_disponibilidad_condiciones_trabajo')
                    </div>

                    {{-- Aspiración salarial y de beneficios --}}
                    <div class="col-md-12" id="info-adicional">
                        @include('admin.hv.includes.actualizar_hv._collapse_aspiracion_salarial_beneficios')
                    </div>

                    {{-- Descripción de sus intereses personales --}}
                    <div class="col-md-12" id="info-adicional">
                        @include('admin.hv.includes.actualizar_hv._collapse_descripcion_intereses_personales')
                    </div>

                    {{-- Descripción de su perfil profesional --}}
                    <div class="col-md-12" id="info-adicional">
                        @include('admin.hv.includes.actualizar_hv._collapse_descripcion_perfil_profesional')
                    </div>
                @endif

                {{-- Información adicional --}}
                @if(route("home") == "https://komatsu.t3rsc.co")
                    <div id="info-adicional">
                        <div class="col-md-12">
                            <h3>Información Adicional(Opcional)</h3>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono_fijo">Número de teléfono fijo: <span class='text-danger sm-text-label'>*</span></label>

                                {!! Form::text("telefono_fijo", null, [
                                    "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "id" => "telefono_fijo",
                                    "placeholder" => "Teléfono fijo",
                                    "required" => "required"
                                ]) !!}
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo", $errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="direccion">Dirección:</label>

                                {!! Form::text("direccion", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "id" => "direccion",
                                    "placeholder" => ""
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="genero">Género: <span class='text-danger sm-text-label'>*</span></label>

                                {!!Form::select("genero", $genero, null, [
                                    "id" => "genero",
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "required" => "required"
                                ])!!}
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero", $errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado_civil">Estado civil: <span class='text-danger sm-text-label'>*</span></label>

                                {!! Form::select("estado_civil", $estadoCivil, null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "id" => "estado_civil",
                                    "required" => "required"
                                ]) !!}
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_civil", $errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="direccion">¿De donde conoce a Komatsu? / Caracteres restantes:</label>
                                
                                {!!Form::textarea("conocenos", null, [
                                    "maxlength" => "550",
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    'rows' => 3,
                                    "id" => "direccion"
                                ])!!}
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("direccion", $errors) !!}</p>
                        </div>
                    </div>
                @endif

                <div class="col-md-12 text-right">
                    <button 
                        type="button"
                        class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                        id="guardar_datos_basicos_admin">
                        Guardar información personal
                    </button>
                </div>

                <div id="container_tab"></div>
            {!! Form::close() !!}
        </div>

        {{-- Modal conflicto de intereses --}}
        @include('admin.hv.includes.actualizar_hv.modals._modal_conflicto_intereses_actualizar_hv')

        {{-- Scripts información personal --}}
        @include('admin.hv.includes.actualizar_hv.src.js._js_informacion_personal')
    {{-- Fin --}}

    {{-- Video perfil --}}
        @include('admin.hv.includes.actualizar_hv._section_video_perfil')

        {{-- Estilos video perfil --}}
        @include('admin.hv.includes.actualizar_hv.src.css._css_video_perfil')

        <script>
            const videoAdmin = true
            const routeVideo = '{{ route("admin.guardar_video_descripcion") }}';
        </script>

        <script src="{{ asset('js/cv/video-perfil/cargar-video-perfil.js') }}"></script>
    {{-- FIn --}}

    {{-- Estudios --}}
        <div class="panel panel-default">
            <div class="panel-body">
                @include('admin.hv.includes.actualizar_hv._collapse_estudios')
            </div>
        </div>

        {{-- Scripts estudios --}}
        @include('admin.hv.includes.actualizar_hv.src.js._js_estudios')
    {{-- Fin --}}

    {{-- Experiencia --}}
        <div class="panel panel-default">
            <div class="panel-body">
                @include('admin.hv.includes.actualizar_hv._collapse_experiencias')
            </div>
        </div>

        {{-- Scripts experiencias --}}
        @include('admin.hv.includes.actualizar_hv.src.js._js_experiencias')
    {{-- Fin --}}

    {{-- Referencias personales --}}
        @if(route("home") != "https://listos.t3rsc.co" && route("home") != "https://vym.t3rsc.co")
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('admin.hv.includes.actualizar_hv._collapse_referencias_personales')
                </div>
            </div>

            {{-- Scripts experiencias --}}
            @include('admin.hv.includes.actualizar_hv.src.js._js_referencias_personales')
        @endif
    {{-- Fin --}}

    {{-- Grupo familiar --}}
        @if(route('home') != "http://komatsu.t3rsc.co")
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('admin.hv.includes.actualizar_hv._collapse_grupo_familiar')
                </div>
            </div>

            {{-- Scripts grupo familiar --}}
            @include('admin.hv.includes.actualizar_hv.src.js._js_grupo_familiar')
        @endif
    {{-- Fin --}}

    {{-- Idiomas --}}
        <div class="panel panel-default">
            <div class="panel-body">
                @include('admin.hv.includes.actualizar_hv._collapse_idiomas')
            </div>
        </div>

        {{-- Scripts idiomas --}}
        @include('admin.hv.includes.actualizar_hv.src.js._js_idiomas')
    {{-- Fin --}}

    {{-- Perfilamiento --}}
        @include('admin.hv.includes.actualizar_hv._section_perfilamiento')

        {{-- Scripts perfilamiento --}}
        @include('admin.hv.includes.actualizar_hv.src.js._js_perfilamiento')
    {{-- Fin --}}
@stop