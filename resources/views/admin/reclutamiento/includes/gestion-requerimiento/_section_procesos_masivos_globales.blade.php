{{-- Grupo procesos masivos --}}
<div class="btn-group">
    <button 
        type="button" 
        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
        PROCESOS MASIVOS
    </button>

    <button 
        type="button" class="btn btn-default dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-toggle="dropdown"

        @if($boton && route("home") != "https://listos.t3rsc.co" && route("home") != "https://vym.t3rsc.co")
            disabled
        @endif
    >
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>

    <ul class="dropdown-menu pd-0" role="menu">
        @if ($valida_botones !== null)
            @foreach ($valida_botones as $validar)
                {{-- ESTUDIO DE SEGURIDAD - VALIDACIÓN DOCUMENTAL --}}
                @if($validar->valor == "validacion")
                    @if($user_sesion->hasAccess("admin.enviar_documento_view"))
                        @if(route("home") == "https://komatsu.t3rsc.co")
                            <li>
                                <button 
                                    type="button" 
                                    class="btn btn-default btn-sm btn-block btn_documento_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                >
                                    ESTUDIO DE SEGURIDAD
                                </button>
                            </li>
                        @else
                            <li>
                                <button 
                                    type="button" 
                                    class="btn btn-default btn-sm btn-block btn_documento_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                >
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
                            <button 
                                type="button" 
                                class="btn btn-default btn-sm btn-block btn_referenciacion_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                            >
                                REFERENCIAR
                            </button>
                        </li>
                    @endif
                @endif

                {{-- PRUEBAS --}}
                @if($validar->valor == "pruebas_psicotecnicas")
                    @if($user_sesion->hasAccess("admin.enviar_pruebas_view"))
                        <li>
                            <button 
                                type="button" 
                                class="btn btn-default btn-sm btn-block btn_pruebas_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                            >
                                PRUEBAS
                            </button>
                        </li>
                    @endif
                @endif
                
                {{-- ENTREVISTA --}}
                @if($validar->valor == "entrevista" || $validar->valor == "sinficha")
                    @if($user_sesion->hasAccess("admin.enviar_entrevista_view"))
                        <li>
                            <button 
                                type="button" 
                                class="btn btn-default btn-sm btn-block btn_entrevista_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                            >
                                ENTREVISTA
                            </button>
                        </li>
                    @endif
                @endif

                @if($entrevista_virtual != 0)
                    <li>
                        <button
                            type="button"
                            class="btn btn-default btn-sm btn-block btn_video_entrevista_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                            data-cliente="{{ $cliente->id }}"
                            data-req_id="{{ $requermiento->id }}">
                            ENTREVISTA VIRTUAL
                        </button>
                    </li>
                @endif

                @if($prueba_idioma != 0)
                    <li>
                        <button
                            type="button"
                            class="btn btn-default btn-sm btn-block btn_prueba_idioma_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
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
                @if(route("home") == "https://komatsu.t3rsc.co")
                    <li>
                        <button 
                            type="button" 
                            class="btn btn-default btn-sm btn-block btn_documento_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                        >
                            ESTUDIO DE SEGURIDAD
                        </button>
                    </li>
                @else
                    <li>
                        <button 
                            type="button" 
                            class="btn btn-default btn-sm btn-block btn_documento_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                        >
                            VALIDACIÓN DOCUMENTAL
                        </button>
                    </li>
                @endif
            @endif

            @if($user_sesion->hasAccess("admin.enviar_referenciacion_view"))
                <li>
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block btn_referenciacion_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    >
                        REFERENCIAS LABORALES
                    </button>
                </li>
            @endif

            @if($user_sesion->hasAccess("admin.enviar_referencia_estudios_view"))
                <li>
                    <button style="width: 100%" type="button" class="btn btn-sm btn-default btn_referencia_estudios_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none">
                        REFERENCIAS ACADÉMICAS
                    </button>
                </li>
            @endif

            @if($user_sesion->hasAccess("admin.enviar_pruebas_view"))
                <li>
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block btn_pruebas_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    >
                        PRUEBAS
                    </button>
                </li>
            @endif

            @if($user_sesion->hasAccess("admin.enviar_entrevista_view"))
                <li>
                    <button
                        type="button" 
                        class="btn btn-default btn-sm btn-block btn_entrevista_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    >
                        ENTREVISTA
                    </button>
                </li>
            @endif
        @endif

        @if($sitioModulo->evaluacion_sst == 'enabled')
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block btn_evaluacion_sst_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    data-cliente="{{ $cliente->id }}"
                    data-req_id="{{ $requermiento->id }}"
                >
                    {{ $configuracion_sst->titulo_boton_envio_proceso }}
                </button>
            </li>
        @endif

        @if($entrevista_virtual != 0)
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block btn_video_entrevista_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    data-cliente="{{ $cliente->id }}"
                    data-req_id="{{ $requermiento->id }}"
                >
                    ENTREVISTA VIRTUAL
                </button>
            </li>
        @endif

        @if($user_sesion->hasAccess("admin.enviar_entrevista_multiple_view"))
            <li>
                <button 
                    type="button" 
                    class="btn btn-default btn-sm btn-block btn_entrevista_multiple | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                >
                    ENTREVISTA MÚLTIPLE
                </button>
            </li>
        @endif
                              
        @if($prueba_idioma != 0)
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block btn_prueba_idioma_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    data-cliente="{{ $cliente->id }}"
                    data-req_id="{{ $requermiento->id }}"
                >
                    PRUEBA IDIOMA
                </button>
            </li>
        @endif

        <li>
            <button
                type="button"
                class="btn btn-default btn-sm btn-block btn-enviar-examenes-masivos | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                data-cliente="{{ $cliente->id }}"
                data-req_id="{{ $requermiento->id }}"
            >
                EXÁMENES MÉDICOS
            </button>
        </li>

        @if($sitioModulo->estudio_virtual_seguridad == 'enabled')
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block btn-enviar-evs-masivos | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                >
                    ESTUDIO VIRTUAL DE SEGURIDAD
                </button>
            </li>
        @endif

        @if(false && $sitioModulo->consulta_seguridad == 'enabled')
            {{-- ocultando boton porque no esta hecho el proceso --}}
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block btn-enviar-examenes-masivos | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    data-cliente="{{ $cliente->id }}"
                >
                    CONSULTA DE SEGURIDAD
                </button>
            </li>
        @endif

        @if(route("home") == "http://localhost:8000" || route("home") == "https://komatsu.t3rsc.co" || 
            route("home") == "https://vym.t3rsc.co" || route("home") == "https://listos.t3rsc.co" || 
            route("home") == "https://desarrollo.t3rsc.co")
            
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block btn-enviar-estudio-seg | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
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
    <button 
        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
        type="button"
    >
        VERIFICACIONES MASIVAS
    </button>

    <button 
        class="btn btn-default dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
        @if($boton) disabled @endif 
        data-toggle="dropdown" 
        type="button"
    >
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>

    <ul class="dropdown-menu pd-0" role="menu">
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
            @if(route("home") == "https://komatsu.t3rsc.co")
                <li>
                    <button
                        type="button"
                        class="btn btn-default btn-sm btn-block btn_aprobar_cliente_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                        data-req_id="{{ $requermiento->id }}"
                    >
                        ENVIAR A APROBAR
                    </button>
                </li>
            @else
                <li>
                    <button
                        type="button"
                        class="btn btn-default btn-sm btn-block btn_aprobar_cliente_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                        data-req_id="{{ $requermiento->id }}"
                    >
                        ENVIAR A APROBAR CLIENTE
                    </button>
                </li>
            @endif
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

        @if($sitio->precontrata == '1')
            {{-- Pre-contratar Masivo --}}
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block btn_pre_contratacion_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                >
                    PRE-CONTRATAR
                </button>
            </li>
        @else
            {{-- Contratar Masivo --}}
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block btn_contratacion_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                >
                    CONTRATAR
                </button>
            </li>
        @endif
    </ul>
</div>

{{-- Grupo configuración pruebas --}}
<div class="btn-group">
    <button 
        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
        type="button">
        CONFIGURAR PRUEBAS
    </button>

    <button class="btn btn-default dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-toggle="dropdown" type="button">
        <span class="caret"></span>
        <span class="sr-only">
            Toggle Dropdown
        </span>
    </button>

    <ul class="dropdown-menu pd-0" role="menu">
        {{-- Verificar si el sitio tiene brig --}}
        @if($sitio->prueba_bryg == 1)
            <li>
                <button 
                    type="button" 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Configura el perfil que se adapte al requerimiento."

                    data-reqid="{{ $requermiento->id }}"
                    onclick="configurarBRYG(this, '{{ route("admin.configuracion_bryg_requerimiento") }}')" 
                >
                    CONFIGURAR BRYG-A
                </button>
            </li>
        @endif

        {{-- Verificar si el sitio tiene digitación --}}
        @if($sitioModulo->prueba_digitacion == 'enabled')
            <li>
                <button 
                    type="button" 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Configurar valores prueba de digitación." 

                    data-reqid="{{ $requermiento->id }}"
                    onclick="configurarDigitacion(this, '{{ route("admin.configuracion_digitacion_requerimiento") }}')" 
                >
                    CONFIGURAR DIGITACIÓN
                </button>
            </li>
        @endif

        {{-- Verificar si el sitio tiene digitación --}}
        @if($sitioModulo->prueba_competencias == 'enabled')
            <li>
                <button 
                    type="button" 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Configurar prueba Personal Skills." 

                    data-reqid="{{ $requermiento->id }}"
                    onclick="configurarCompetencias(this, '{{ route("admin.configuracion_competencias_requerimiento") }}')" 
                >
                    CONFIGURAR PERSONAL SKILLS
                </button>
            </li>
        @endif

        {{-- Verificar si el sitio tiene algun excel activo --}}
        @if($sitio->prueba_excel_basico || $sitio->prueba_excel_intermedio)
            <li>
                <button 
                    type="button" 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Configura la prueba de Excel Basico y/o Excel Intermedio para el requerimiento."

                    data-reqid="{{ $requermiento->id }}" 
                    onclick="configurarExcel(this, '{{ route("admin.configuracion_excel_requerimiento") }}')"
                >
                    CONFIGURAR EXCEL
                </button>
            </li>
        @endif

        {{-- Verificar si el sitio tiene prueba Ethical Values activo --}}
        @if($sitioModulo->prueba_valores1 == 'enabled')
            <li>
                <button 
                    type="button" 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Configura la prueba de Ethical Values para el requerimiento."

                    data-reqid="{{ $requermiento->id }}"
                    onclick="configurarEV(this, '{{ route("admin.configuracion_prueba_ethical_values") }}')"
                >
                    CONFIGURAR ETHICAL VALUES
                </button>
            </li>
        @endif
    </ul>
</div>

{{-- Botón observaciones --}}
<button 
    type="button" 
    class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" 
    data-req="{{ $requermiento->id }}" 
    id="observaciones"
>
    OBSERVACIONES
</button>

{{-- Botón dotación --}}
@if(route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co")
    <button 
        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
        data-req="{{ $requermiento->id }}" 
        id="dotacion" 
        type="button"
    >
        DOTACIÓN
    </button>
@endif

{{-- Botón orden de contratación --}}
@if(route("home") == "https://vym.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co" || route("home") == "https://listos.t3rsc.co")
    @if(count($candidatos_req) > 0)
        <button 
            type="button"
            class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
            data-req="{{ $requermiento->id }}" 
            id="orden_contra" 
        >
            ORDEN DE CONTRATACIÓN
        </button>
    @endif
@endif

{{-- Botón contrato kactus --}}
@if(route("home") == "https://vym.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co" || route("home") == "https://listos.t3rsc.co")
    <button 
        type="button"
        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
        data-req="{{ $requermiento->id }}" 
        id="kactus"
    >
        NÚMERO CONTRATO KACTUS
    </button>
@endif

{{-- Botones cuadros preselección --}}
@if(route("home") == "https://gpc.t3rsc.co")
    <a 
        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
        id="btn_long"
    >
        CUADRO DE PRESELECCIÓN PDF
    </a>

    <a 
        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
        id="btn_long2"
    >
        CUADRO DE PRESELECCIÓN EXCEL
    </a>
@endif

{{-- Select gestionar por empresa
@if(route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co" || route("home") == "http://localhost:8000")
    <div class="col-md-6 mt-1 form-group">
        <label for="empresa_contrata">
            Gestionar por empresa
        </label>

        {!! Form::select("empresa_contrata", $empresa_logo, $requermiento->empresa_contrata, [
            "class" => "form-control input-sm | tri-br-03 tri-fs-12 tri-input--focus tri-transition-300",
            "id" => "empresa_contrata",
            "required" => "required"
        ]); !!}

        <button
            type="button"
            class="btn btn-primary btn-sm pull-right mt-1 | tri-br-2 tri-blue"
            id="g_empresa_contrata"
            data-req="{{ $requermiento->id }}"
        >
            Guardar empresa
        </button>                
    </div>
@endif --}}