{{-- Grupo procesos masivos --}}
<div style="" class="btn-group">
    <button type="button" class="btn btn-warning">PROCESOS MASIVOS</button>

    <button 
        type="button" 

        @if($boton && route("home") != "https://listos.t3rsc.co" && route("home")!="https://vym.t3rsc.co") 
            disabled 
        @endif 

        class="btn btn-warning dropdown-toggle" 
        data-toggle="dropdown"
    >
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>

    <ul class="dropdown-menu" role="menu">
        @if ($valida_botones !== null)
            @foreach ($valida_botones as $validar)
                {{-- ESTUDIO DE SEGURIDAD - VALIDACIÓN DOCUMENTAL --}}
                @if($validar->valor == "validacion")
                    @if($user_sesion->hasAccess("admin.enviar_documento_view"))
                        @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                            <li>
                                <button style="width: 100%" type="button" class="btn btn-info btn-sm btn_documento_masivo" >
                                    ESTUDIO DE SEGURIDAD
                                </button>
                            </li>
                        @else
                            <li>
                                <button style="width: 100%" type="button" class="btn btn-info btn-sm btn_documento_masivo" >
                                    VALIDACIÓN DOCUMENTAL
                                </button>
                            </li>
                        @endif
                    @endif
                @endif

                {{-- REFERENCIAR --}}
                @if($validar->valor == "referenciacion")
                    @if($user_sesion->hasAccess("admin.enviar_referenciacion_view"))
                        <li>
                            <button style="width: 100%" type="button" class="btn btn-sm btn-info btn_referenciacion_masivo" >
                                REFERENCIAR
                            </button>
                        </li>
                    @endif
                @endif

                {{-- PRUEBAS --}}
                @if($validar->valor == "pruebas_psicotecnicas")
                    @if($user_sesion->hasAccess("admin.enviar_pruebas_view"))
                        <li>
                            <button style="width: 100%"   type="button" class="btn btn-sm  btn-info btn_pruebas_masivo">
                                PRUEBAS
                            </button>
                        </li>
                    @endif
                
                @endif
                
                {{-- ENTREVISTA --}}
                @if($validar->valor == "entrevista" || $validar->valor == "sinficha")
                    @if($user_sesion->hasAccess("admin.enviar_entrevista_view"))
                        <li>
                            <button style="width: 100%" type="button" class="btn btn-info btn-sm btn_entrevista_masivo ">
                                ENTREVISTA
                            </button>
                        </li>
                    @endif
                @endif

                @if($entrevista_virtual != 0)
                    <li>
                        <button
                            style="width: 100%"
                            type="button"
                            class="btn btn-info btn-sm btn_video_entrevista_masivo"
                            data-cliente="{{ $cliente->id }}"
                            data-req_id="{{ $requermiento->id }}">
                            ENTREVISTA VIRTUAL
                        </button>
                    </li>
                @endif

                @if($prueba_idioma != 0)
                    <li>
                        <button
                            style="width: 100%"
                            type="button"
                            class="btn btn-info btn-sm btn_prueba_idioma_masivo"
                            data-cliente="{{ $cliente->id }}"
                            data-req_id="{{ $requermiento->id }}"
                        >
                            PRUEBA IDIOMA
                        </button>
                    </li>
                @endif
            @endforeach
        @else
            @if($user_sesion->hasAccess("admin.enviar_documento_view"))
                @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                    <li>
                      <button style="width: 100%" type="button" class="btn btn-info btn-sm btn_documento_masivo">
                       ESTUDIO DE SEGURIDAD
                      </button>
                    </li>
                @else
                    <li>
                      <button style="width: 100%" type="button" class="btn btn-info btn-sm btn_documento_masivo">
                       VALIDACIÓN DOCUMENTAL
                      </button>
                    </li>
                @endif
            @endif

            @if($user_sesion->hasAccess("admin.enviar_referenciacion_view"))
                <li>
                    <button style="width: 100%" type="button" class="btn btn-sm btn-info btn_referenciacion_masivo">
                        REFERENCIAR
                    </button>
                </li>
            @endif

            @if($user_sesion->hasAccess("admin.enviar_pruebas_view"))
                <li>
                    <button style="width: 100%" type="button" class="btn btn-sm  btn-info btn_pruebas_masivo">
                        PRUEBAS
                    </button>
                </li>
            @endif

            @if($user_sesion->hasAccess("admin.enviar_entrevista_view"))
                <li>
                    <button style="width: 100%" type="button" class="btn btn-info btn-sm btn_entrevista_masivo" >
                        ENTREVISTA
                    </button>
                </li>
            @endif
        @endif

        @if($sitioModulo->evaluacion_sst == 'enabled')
            <li>
                <button
                    style="width: 100%"
                    type="button"
                    class="btn btn-info btn-sm btn_evaluacion_sst_masivo"
                    data-cliente="{{ $cliente->id }}"
                    data-req_id="{{ $requermiento->id }}"
                >
                    {{ $sitioModulo->configuracionEvaluacionSst()->titulo_boton_envio_proceso }}
                </button>
            </li>
        @endif
                      
        @if($entrevista_virtual != 0)
            <li>
                <button
                    style="width: 100%"
                    type="button"
                    class="btn btn-info btn-sm btn_video_entrevista_masivo"
                    data-cliente="{{ $cliente->id }}"
                    data-req_id="{{ $requermiento->id }}"
                >
                    ENTREVISTA VIRTUAL
                </button>
            </li>
        @endif

        @if($user_sesion->hasAccess("admin.enviar_entrevista_multiple_view"))
            <li>
                <button style="width: 100%" type="button" class="btn btn-sm  btn-info btn_entrevista_multiple">
                    ENTREVISTA MÚLTIPLE
                </button>
            </li>
        @endif
                              
        @if($prueba_idioma != 0)
            <li>
                <button
                    style="width: 100%"
                    type="button"
                    class="btn btn-info btn-sm btn_prueba_idioma_masivo"
                    data-cliente="{{ $cliente->id }}"
                    data-req_id="{{ $requermiento->id }}"
                >
                    PRUEBA IDIOMA
                </button>
            </li>
        @endif

        @if(route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" ||
            route("home") == "http://localhost:8000" || route("home") == "http://komatsu.t3rsc.co" ||
            route("home") == "https://komatsu.t3rsc.co" || route("home") == "http://vym.t3rsc.co" ||
            route("home") == "https://vym.t3rsc.co" || route("home") == "http://listos.t3rsc.co" ||
            route("home") == "https://listos.t3rsc.co" || route("home") == "https://pruebaslistos.t3rsc.co" ||
            route("home") == "http://desarrollo.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co")
            <li>
                <button
                    type="button"
                    style="width: 100%"
                    class="btn btn-info btn-sm btn-enviar-examenes-masivos"
                    data-cliente="{{ $cliente->id }}"
                >
                    EXAMENES MEDICOS
                </button>
            </li>

            <li>
                <button
                    type="button"
                    style="width: 100%"
                    class="btn btn-info btn-sm btn-enviar-estudio-seg"
                    data-cliente="{{ $cliente->id }}"
                >
                    ESTUDIO SEGURIDAD
                </button>
            </li>
        @endif
    </ul>
</div>

{{-- Grupo verificaciones masivas --}}
<div class="btn-group">
    <button class="btn btn-success" type="button">
        VERIFICACIONES MASIVAS
    </button>

    <button class="btn btn-success dropdown-toggle" @if($boton) disabled @endif data-toggle="dropdown" type="button">
        <span class="caret"></span>
        <span class="sr-only">
            Toggle Dropdown
        </span>
    </button>

    <ul class="dropdown-menu" role="menu">
        {{-- 
            @if(route('home')!= "http://talentum.t3rsc.co")
                <li>
                    <button style="width: 100%" type="button" class="btn btn-info btn-sm btn_asistencia_masivo " data-req_id="{{$requermiento->id}}">
                        ASISTIÓ
                    </button>
                </li>
            @endif
        --}}

        {{-- Botón enviar a aprobar cliente --}}
        @if($user_sesion->hasAccess("admin.enviar_aprobar_cliente_view"))
            @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                <li>
                    <button
                        type="button"
                        class="btn btn-sm btn-info btn-block btn_aprobar_cliente_masivo"
                        data-req_id="{{ $requermiento->id }}"
                    >
                        ENVIAR A APROBAR
                    </button>
                </li>
            @else
                <li>
                    <button
                        type="button"
                        class="btn btn-sm btn-info btn-block btn_aprobar_cliente_masivo"
                        data-req_id="{{ $requermiento->id }}"
                    >
                        ENVIAR A APROBAR CLIENTE
                    </button>
                </li>
            @endif
        @endif

        @if($requermiento->tipo_proceso_id == $sitio->id_proceso_sitio)
            <li>
                <button
                    type="button"
                    class="btn btn-sm btn-info btn-block btn_aprobar_candidatos_masivo"
                    data-req_id="{{ $requermiento->id }}"
                >
                    APROBAR CANDIDATOS
                </button>
            </li>
        @endif

        {{-- Botón contratar --}}
        {{-- 
            @if($user_sesion->hasAccess("admin.enviar_contratar"))
                @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                    <li>
                        <button
                            style="width: 100%"
                            type="button"
                            class="btn btn-sm  btn-info btn_contratacion_cliente_masivo"
                            data-cliente="{{ $requermiento->cliente_id }}"
                            data-req_id="{{ $requermiento->id }}"
                        >
                            AVANZAR
                        </button>
                    </li>
                @else
                    <li>
                        <button
                            style="width: 100%"
                            type="button"
                            class="btn btn-sm  btn-info btn_contratacion_cliente_masivo"
                            data-cliente="{{ $requermiento->cliente_id }}" data-req_id="{{ $requermiento->id }}"
                        >
                            @if(route("home") == "https://gpc.t3rsc.co") ENVIAR APROBAR @else CONTRATAR @endif
                        </button>
                    </li>
                @endif
            @endif
        --}}

        @if($sitio->precontrata == '1' && $requermiento->tipo_proceso_id != $sitio->id_proceso_sitio)
            {{-- Pre-contratar Masivo --}}
            <li>
                <button
                    style="width: 100%"
                    type="button"
                    class="btn btn-sm btn-info btn_pre_contratacion_masivo"
                >
                    PRE-CONTRATAR
                </button>
            </li>
        @else
            {{-- Contratar Masivo --}}
            <li>
                <button
                    style="width: 100%"
                    type="button"
                    class="btn btn-sm btn-info btn_contratacion_masivo"
                >
                    CONTRATAR
                </button>
            </li>
        @endif
    </ul>
</div>

{{-- Botón observaciones --}}
<button class="btn btn-info" data-req="{{ $requermiento->id }}" id="observaciones" type="button">
    OBSERVACIONES
</button>

{{-- Botón dotación --}}
@if(route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co" || 
    route("home") == "https://desarrollo.t3rsc.co" || route("home") == "http://localhost:8000")

    <button class="btn btn-success" data-req="{{ $requermiento->id }}" id="dotacion" type="button">
        DOTACIÓN
    </button>
@endif

@if(route("home") == "http://localhost:8000" || route("home") == "https://vym.t3rsc.co" || 
    route("home") == "https://desarrollo.t3rsc.co" || route("home") == "https://listos.t3rsc.co")
    {{-- Botón orden de contratación --}}
    @if(count($candidatos_req) > 0)
        <button class="btn btn-primary" data-req="{{ $requermiento->id }}" id="orden_contra" type="button">ORDEN DE CONTRATACIÓN</button>
    @endif

    {{-- Botón contrato kactus --}}
    <button class="btn btn-warning" data-req="{{ $requermiento->id }}" id="kactus" type="button">NÚMERO CONTRATO KACTUS</button>
@endif

{{-- Botones cuadros preselección --}}
@if(route("home") == "https://gpc.t3rsc.co" || route("home") == "http://localhost:8000")
    <a class="btn btn-success" id="btn_long">CUADRO DE PRESELECCIÓN PDF</a> 

    <a class="btn btn-success" id="btn_long2">CUADRO DE PRESELECCIÓN EXCEL</a>  
@endif

{{-- 
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-8 control-label"> Gestionar por Empresa <span></span> </label>
    
        <div class="col-sm-6">
            {!! Form::select("empresa_contrata", $empresa_logo, $requermiento->empresa_contrata, [ "class" => "form-control", "id" => "empresa_contrata","required"]); !!}
        </div>

        <div class="col-sm-4">
            <button
                class="btn btn-primary pull-right"
                id="g_empresa_contrata"
                type="button"
                data-req="{{ $requermiento->id }}"
            >
                Guardar Empresa
            </button>
        </div>
    
    </div>
--}}

<div class="btn-group">
    <button class="btn btn-warning" type="button">
        <i class="fa fa-cog" aria-hidden="true"></i>
            Configurar Pruebas
    </button>

    <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" type="button">
        <span class="caret"></span>
        <span class="sr-only">
            Toggle Dropdown
        </span>
    </button>

    <ul class="dropdown-menu" role="menu">
        {{-- Verificar si el sitio tiene brig --}}
        @if($sitio->prueba_bryg == 1)
            <li>
                <button 
                    type="button" 
                    class="btn btn-sm btn-info btn-block" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Configura el perfil que se adapte al requerimiento."

                    data-reqid="{{ $requermiento->id }}"
                    onclick="configurarBRYG(this, '{{ route("admin.configuracion_bryg_requerimiento") }}')" 
                >
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    Configurar BRYG-A
                </button>
            </li>
        @endif

        {{-- Verificar si el sitio tiene digitación --}}
        @if($sitioModulo->prueba_digitacion == 'enabled')
            <li>
                <button 
                    type="button" 
                    class="btn btn-sm btn-info btn-block" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Configurar valores prueba de digitación." 

                    data-reqid="{{ $requermiento->id }}"
                    onclick="configurarDigitacion(this, '{{ route("admin.configuracion_digitacion_requerimiento") }}')" 
                >
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    Configurar Digitación
                </button>
            </li>
        @endif

        {{-- Verificar si el sitio tiene digitación --}}
        @if($sitioModulo->prueba_competencias == 'enabled')
            <li>
                <button 
                    type="button" 
                    class="btn btn-sm btn-info btn-block" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Configurar prueba Personal Skills." 

                    data-reqid="{{ $requermiento->id }}"
                    onclick="configurarCompetencias(this, '{{ route("admin.configuracion_competencias_requerimiento") }}')" 
                >
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    Configurar Personal Skills
                </button>
            </li>
        @endif

        {{-- Verificar si el sitio tiene algun excel activo --}}
        @if($sitio->prueba_excel_basico || $sitio->prueba_excel_intermedio)
            <li>
                <button 
                    type="button" 
                    class="btn btn-sm btn-info btn-block" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Configura la prueba de Excel Basico y/o Excel Intermedio para el requerimiento."

                    data-reqid="{{ $requermiento->id }}" 
                    onclick="configurarExcel(this, '{{ route("admin.configuracion_excel_requerimiento") }}')"
                >
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    Configurar Excel
                </button>
            </li>
        @endif

        {{-- Verificar si el sitio tiene prueba Ethical Values activo --}}
        @if($sitioModulo->prueba_valores1 == 'enabled')
            <li>
                <button 
                    type="button" 
                    class="btn btn-sm btn-info btn-block" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Configura la prueba de Ethical Values para el requerimiento."

                    data-reqid="{{ $requermiento->id }}"
                    onclick="configurarEV(this, '{{ route("admin.configuracion_prueba_ethical_values") }}')"
                >
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    Configurar Ethical Values
                </button>
            </li>
        @endif
    </ul>
</div>
