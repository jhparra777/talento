<div class="row">
    <div class="col-md-12 mb-2">
        <h4 class="tri-fw-600 tri-fs-20">
            <span data-toggle="tooltip" data-placement="top" title="Por favor relacione todas las experiencias laborales, empezando por el trabajo más reciente."><i class="fa fa-info-circle" aria-hidden="true"></i></span> 
            @if(route("home") != "https://gpc.t3rsc.co") Experiencia laboral @else Empleos anteriores @endif <small>Los campos con asterisco (*) son obligatorios.</small>
        </h4>
    </div>
</div>

<div class="row" id="fr_container_experiencia">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading | tri-bg--none" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" href="#collapseExperiencias" aria-expanded="true" aria-controls="collapseExperiencias">
                        Información experiencia
                    </a>

                    <a class="pull-right" role="button" data-toggle="collapse" href="#collapseExperiencias" aria-expanded="true" aria-controls="collapseExperiencias">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                </h4>
            </div>
        
            <div id="collapseExperiencias" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    {{-- Formulario experiencias --}}
                    {!! Form::open(["class" => "form-datos-basicos", "role" => "form", "id" => "fr_datos_experiencia"]) !!}
                        {!! Form::hidden("user_id", $datos_basicos->user_id) !!}
                        {!! Form::hidden("numero_id", $datos_basicos->numero_id) !!}
                        {!! Form::hidden("id", null, ["class" => "id_modificar_experiencia", "id" => "id_modificar_experiencia"]) !!}

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="tiene_experiencia">
                                        {!! Form::checkbox("tiene_experiencia",0,isset($datos_basicos->tiene_experiencia) && $datos_basicos->tiene_experiencia == "0" ? 1 : null,["class"=>"tiene_experiencia","id"=>"tiene_experiencia"]) !!}
                                        No tengo experiencia
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="numero_id">Nombre empresa: <span class='text-danger sm-text-label'>*</span></label>
            
                                {!! Form::text("nombre_empresa", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                    "placeholder" => "Nombre Empresa", 
                                    "id" => "nombre_empresa",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        @if(route('home') != "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numero_id">Teléfono empresa: <span class='text-danger sm-text-label'>*</span></label>
            
                                    {!! Form::text("telefono_temporal", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                        "id" => "telefono_temporal", 
                                        "placeholder" => "Teléfono empresa",
                                        "required" => "required"
                                    ]) !!}
                                </div>
                            </div>
                        @endif
            
                        @if(route('home') != "https://gpc.t3rsc.co")
                            <div class="col-md-6">                  
                                <div class="form-group">
                                    <label for="ciudad_residencia">Ciudad: <span class='text-danger sm-text-label'>*</span></label>
            
                                    {!! Form::hidden("pais_id", null, ["id" => "pais_id_res"]) !!}
                                    {!! Form::hidden("departamento_id", null, ["id" => "departamento_id_res"]) !!}
                                    {!! Form::hidden("ciudad_id", null, ["id" => "ciudad_id_res"]) !!}
                                    
                                    {!! Form::text("autocompletado_residencia", null, [
                                        "id" => "autocompletado_residencia",
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "placeholder" => "Digita ciudad",
                                        "required" => "required"
                                    ]) !!}
                                </div>
                            </div>
                        @endif
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cargo_especifico">Cargo desempeñado: <span class='text-danger sm-text-label'>*</span></label>
            
                                {!! Form::text("cargo_especifico", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "id" => "cargo_especifico",
                                    "placeholder" => "Cargo desempeñado",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        @if(route('home') != "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        Nivel cargo: 
                                    </label>

                                    {!! Form::select("nivel_cargo", ["" => "Seleccionar", "Operativo" => "Operativo", "Directivo" => "Directivo", "Asesor" => "Asesor", "Profesional" => "Profesional", "Técnico" => "Técnico", "Asistencial" => "Asistencial"], null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                        "id" => "nivel_cargo"
                                    ]) !!}
                                </div>
                            </div>
                        @endif
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_id">
                                    @if(route('home') != "https://gpc.t3rsc.co")
                                        Cargo similar
                                    @else
                                        Cargo generico
                                    @endif : <span class='text-danger sm-text-label'>*</span>
                                </label>
            
                                {!! Form::select("cargo_desempenado", $cargoGenerico, null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                    "id" => "cargo_desempenado",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombres_jefe">
                                    @if(route('home') != "https://gpc.t3rsc.co") 
                                        Nombres jefe: <span class='text-danger sm-text-label'>*</span> 
                                    @else 
                                        Nombre del supervisor:
                                    @endif
                                </label>

                                @if(route('home') != "https://gpc.t3rsc.co") 
                                    {!! Form::text("nombres_jefe", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                        "id" => "nombres_jefe",
                                        "placeholder" => "Nombres jefe inmediato",
                                        "required" => "required"
                                    ]) !!}
                                @else 
                                    {!! Form::text("nombres_jefe", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                        "id" => "nombres_jefe",
                                        "placeholder" => "Nombres jefe inmediato"
                                    ]) !!}
                                @endif
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cargo_jefe">
                                    @if(route('home') != "https://gpc.t3rsc.co") 
                                        Cargo jefe: 
                                    @else 
                                        Cargo supervisor: 
                                    @endif <span class='text-danger sm-text-label'>*</span>
                                </label>

                                {!! Form::text("cargo_jefe", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "id" => "cargo_jefe", 
                                    "placeholder" => "Cargo jefe inmediato",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
                    
                        @if(route('home') == "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lereportan">Le reportan: <span class='text-danger sm-text-label'>*</span></label>
            
                                    {!! Form::text("le_reportan", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                        "placeholder" => "le_reportan",
                                        "id" => "le_reportan"
                                    ]) !!}
                                </div>
                            </div>
                        @endif
            
                        @if(route('home') != "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono_movil_jefe">Teléfono móvil jefe: <span class='text-danger sm-text-label'>*</span></label>
            
                                    {!! Form::text("movil_jefe", null, [
                                        "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                        "placeholder" => "Movil jefe inmediato", 
                                        "id" => "telefono_movil_jefe",
                                        "required" => "required"
                                    ]) !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono_jefe">Teléfono fijo jefe:</label>
                            
                                    {!! Form::text("fijo_jefe", null, [
                                        "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                        "id" => "telefono_jefe", 
                                        "placeholder" => "Teléfono jefe inmediato"
                                    ]) !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono_jefe">Extensión fijo jefe:</label>
            
                                    {!! Form::text("ext_jefe", null, [
                                        "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                        "id" => "ext_jefe", 
                                        "placeholder" => "Extension fijo"
                                    ]) !!}
                                </div>
                            </div>
                        @endif
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_inicio">
                                    @if(route('home') == "https://gpc.t3rsc.co")
                                        Fecha ingreso 
                                    @else
                                        Fecha inicio 
                                    @endif: <span class='text-danger sm-text-label'>*</span>
                                </label>
            
                                {!! Form::text("fecha_inicio", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "id" => "fecha_inicio",
                                    "placeholder" => "Fecha inicio",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="trabajo-empresa-temporal">Trabajo actual:</label>

                                {!!Form::select("empleo_actual", ['' => "Seleccione", '1' => "Si", '2' => "No"], null, [
                                    "class" => "form-control empleo_actual | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                    "id" => "empleo_actual"
                                ])!!}
                            </div>
                        </div>
            
                        <div class="ocultar col-md-6">
                            <div class="form-group">
                                <label for="fecha_terminacion">
                                    @if(route('home') == "https://gpc.t3rsc.co") 
                                        Fecha salida 
                                    @elseif(route("home") == "https://humannet.t3rsc.co") 
                                        Fecha culminación 
                                    @else 
                                        Fecha terminación 
                                    @endif: <span class='text-danger sm-text-label'>*</span>
                                </label>
            
                                {!! Form::text("fecha_final", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "id" => "fecha_final",
                                    "placeholder" => "Fecha terminación",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        <div id="arned_salary">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="salario_devengado">
                                        @if(route('home') == "https://gpc.t3rsc.co") 
                                            Último salario 
                                        @elseif(route("home") == "https://humannet.t3rsc.co") 
                                            Sueldo líquido 
                                        @else 
                                            Salario devengado 
                                        @endif: <span class='text-danger sm-text-label'>*</span>
                                    </label>
            
                                    @if(route('home') == "http://localhost:8000" || route('home') == "https://soluciones.t3rsc.co" || route('home') == "https://gpc.t3rsc.co")
                                        {!! Form::number("salario_devengado", null, [
                                            "class" => "form-control input-number | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "salario_devengado",
                                            "min" => "1",
                                            "required" => "required"
                                        ]) !!}
                                    @else
                                        {!! Form::select("salario_devengado", $aspiracionSalarial, null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "salario_devengado",
                                            "required" => "required"
                                        ]) !!}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-6" id="motivo_r">
                                <div class="form-group">
                                    <label for="motivo_retiro">
                                        @if(route('home') == "https://gpc.t3rsc.co")
                                            Motivo de salida de la empresa 
                                        @else 
                                            Motivo retiro 
                                        @endif: <span class='text-danger sm-text-label'>*</span>
                                    </label>
            
                                    {!! Form::select("motivo_retiro", $motivos, null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                        "id" => "motivo_retiro",
                                        "required" => "required"
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        @if(route('home') == "https://gpc.t3rsc.co")
                            <div id="actual_show">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linea_negocio">Sueldo fijo bruto:</label>
            
                                        {!! Form::number("sueldo_fijo_bruto", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "sueldo_fijo_bruto", "autofocus"]) !!}
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linea_negocio">Ingreso variable mensual (comisiones/bonos):</label>
            
                                        {!! Form::number("ingreso_varial_mensual", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "ingreso_varial_mensual"]) !!}
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linea_negocio"> Otros bonos (monto y periodicidad):</label>
            
                                        {!! Form::number("otros_bonos", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "otros_bonos"]) !!}
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linea_negocio"> Total ingreso anual:</label>
            
                                        {!! Form::number("total_ingreso_anual", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "total_ingreso_anual"]) !!}
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linea_negocio">Total ingreso mensualizado:</label>
            
                                        {!! Form::number("total_ingreso_mensual", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "total_ingreso_mensual"]) !!}
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linea_negocio"> Utilidades (individual y carga):</label>
            
                                        {!! Form::number("utilidades", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "utilidades"]) !!}
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linea_negocio"> Valor actual fondos de reserva: </label>
            
                                        {!! Form::number("valor_actual_fondos", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "valor_actual_fondos"]) !!}
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linea_negocio"> Beneficios no monetarios: </label>
            
                                        {!! Form::text("beneficios_monetario", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "beneficios_monetario"]) !!}
                                    </div>
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linea_negocio">Linea negocio:</label>
            
                                    {!! Form::text("linea_negocio", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "linea_negocio",
                                        "placeholder" => "Linea negocio"]) !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_compania">Tipo compañia: <span class='text-danger sm-text-label'>*</span> </label>
            
                                    {!! Form::select("tipo_compania", ['' => "seleccione", 'nacional' => "Nacional", 'transnacional' => "Transnacional", 'multinacional' => "Multinacional"], null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "tipo_compania"
                                    ]) !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ventas_empresa">Ventas anuales de la empresa:</label>
            
                                    {!! Form::number("ventas_empresa", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "ventas_empresa"
                                    ]) !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="num_colaboradores">Número de colaboradores de la empresa:</label>
            
                                    {!! Form::number("num_colaboradores", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "num_colaboradores"
                                    ]) !!}
                                </div>
                            </div>
            
                            @if(route('home') == "http://localhost:8000")
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="otro_cargo">Otro cargo desempeñado:</label>
                                        
                                        {!! Form::text("otro_cargo", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "otro_cargo"
                                        ]) !!}
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tiempo_cargo">Tiempo del cargo:</label>
            
                                        {!! Form::text("tiempo_cargo", null, [
                                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id" => "tiempo_cargo"
                                        ]) !!}
                                    </div>
                                </div>
                            @endif
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="funciones_logros">Funciones (al menos 5 funciones específicas): <span class='text-danger sm-text-label'>*</span></label>
            
                                    {!! Form::textarea("funciones_logros", null, [
                                        "maxlength" => "550",
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "rows"=> 2,
                                        "placeholder" => "Escribe acá tu funciones. Máximo 550 caracteres",
                                        "id" => "funciones_logros"
                                    ]) !!}
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logros">Logros: <span class='text-danger sm-text-label'>*</span></label>
            
                                    {!! Form::textarea("logros", null, [
                                        "maxlength" => "550",
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "rows"=> 2,
                                        "placeholder" => "Escribe acá tus logros. Máximo 550 caracteres",
                                        "id" => "logros"
                                    ]) !!}
                                </div>
                            </div>
                        @endif
            
                        @if(route('home') != "https://gpc.t3rsc.co")
                            <div id="funciones" class="col-sm-6 col-lg-12">
                                <div class="form-group">
                                    <label for="funciones_logros">Funciones y logros:</label>
            
                                    {!!Form::textarea("funciones_logros", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "rows" => 2,
                                        "name" => "funciones_logros",
                                        "id" => "funciones_logros"
                                    ]) !!}
                                </div>
                            </div>
                        @endif
            
                        {!! Form::hidden("autoriza_solicitar_referencias", 1, null, ["class" => "checkbox-preferencias", "data-state" => "false", "id" => "autorizo_referencia"]) !!}

                        <div class="col-md-12 text-right">
                            <button 
                                type="button" 
                                class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                                id="actualizar_experiencia" 
                                style="display: none;">
                                Actualizar experiencias
                            </button>
                
                            <button 
                                type="button"
                                class="btn btn-default btn-block | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red" 
                                id="cancelar_experiencia" 
                                style="display: none;">
                                Cancelar
                            </button>
                
                            <button 
                                type="button"
                                class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                                id="guardar_experiencias">
                                Guardar experiencias
                            </button>
                        </div>
                    {!! Form::close() !!}

                    {{-- Lista de experiencias (Tabla) --}}
                    {!! Form::open(["id" => "grilla_datos_experiencia"]) !!}
                        <div class="col-md-12 mt-6">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-center" id="tbl_experiencias">
                                    <thead>
                                        <tr>
                                            <th>Empresa</th>
                                            
                                            @if(route('home') != "https://gpc.t3rsc.co")
                                                <th>Teléfono empresa</th>
                                            @endif
                                            
                                            <th>Nombres @if(route('home') != "https://gpc.t3rsc.co") Jefe inmediato @else Supervisor @endif</th>
                                            <th>Teléfono fijo</th>
                                            <th>Teléfono móvil</th>
                                            <th>Cargo @if(route('home') == "https://gpc.t3rsc.co") Supervisor @endif </th>

                                            <th>Fecha ingreso</th>
                                            <th>Fecha salida</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($experiencias as $experiencia)
                                            <tr id="tr_{{$experiencia->id}}">
                                                <td> {{$experiencia->nombre_empresa}} </td>
                                                
                                                @if(route('home') != "https://gpc.t3rsc.co")
                                                    <td> {{$experiencia->telefono_temporal}} </td>
                                                @endif

                                            <td>{{$experiencia->nombres_jefe}}</td>
                                            <td>{{$experiencia->fijo_jefe}}</td>
                                            <td>{{$experiencia->movil_jefe}}</td>
                                            <td>{{$experiencia->cargo_jefe}}</td>

                                                <td>{{$experiencia->fecha_inicio}}</td>
                                                <td>{{$experiencia->fecha_final}}</td>
                                                
                                                <td>
                                                    {!! Form::hidden("id", $experiencia->id, ["id" => $experiencia->id]) !!}
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-default btn-peq certificados_experiencias disabled_experiencia | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
                                                        Certificados <i class="fa fa-file-text-o"></i>
                                                    </button>

                                                    <button 
                                                        type="button" 
                                                        class="btn btn-default editar_experiencia disabled_experiencia | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple">
                                                        Editar <i class="fa fa-pencil"></i>
                                                    </button>

                                                    <button 
                                                        type="button" 
                                                        class="btn btn-danger eliminar_experiencia disabled_experiencia | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red">
                                                        Eliminar <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="registro_nulo">
                                                <td colspan="6">No hay registros</td>
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