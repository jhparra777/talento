
@if($requermiento->archivo_perfil != null && $requermiento->archivo_perfil != " " && $requermiento->archivo_perfil != "")
    <div class="col-md-1">
        <a
            class="btn | tri-circle-btn tri-gray-100 tri-txt-gray-700 hover-bd-gray-400 tri-transition-300"
            href="{{ url('recursos_Perfiles', ['archivo' => $requermiento->archivo_perfil]) }}"
            target="_blank"

            data-toggle="tooltip"
            data-placement="top"
            data-container="body"
            title="Perfil"
        >
            <i class="fa fa-file tri-fs-16"></i> {{-- Perfil --}}
        </a>
    </div>
@endif

{{-- Botón ficha --}}
@if($user_sesion->hasAccess("admin.ficha_pdf"))
    <div class="col-md-1">
        <a
            class="btn | tri-circle-btn tri-gray-100 tri-txt-gray-700 hover-bd-gray-400 tri-transition-300"
            href="{{ route('admin.ficha_pdf', ['id' => $requermiento->id]) }}"
            target="_blank"

            data-toggle="tooltip"
            data-placement="top"
            data-container="body"
            title="Ficha"
        >
            <i class="fa fa-file tri-fs-16"></i> {{-- Ficha --}}
        </a>
    </div>
@endif

{{-- Botón nueva entrevista virtual --}}
@if($user_sesion->hasAccess("admin.entrevistas_virtuales"))
    @if($entrevista_virtual != 1)        
        <div class="col-md-1">
            <button
                type="button"
                class="btn btn-crear_entrevista_virtual | tri-circle-btn tri-gray-100 tri-txt-gray-700 hover-bd-gray-400 tri-transition-300" 
                data-req_id="{{ $requermiento->id }}"

                data-toggle="tooltip"
                data-placement="top"
                data-container="body"
                title="Nueva entrevista virtual"
            >
                <i class="fa fa-video-camera tri-fs-16"></i> {{-- Nueva entrevista virtual --}}
            </button>
        </div>
    @endif
@endif

{{-- Botón nueva prueba de idioma --}}
@if(route("home") != "https://humannet.t3rsc.co")
    @if($user_sesion->hasAccess("admin.pruebas_idiomas"))
        @if($prueba_idioma != 1)            
            <div class="col-md-1">
                <button 
                    type="button" 
                    class="btn btn-crear_prueba_idioma | tri-circle-btn tri-gray-100 tri-txt-gray-700 hover-bd-gray-400 tri-transition-300" 
                    data-req_id="{{ $requermiento->id }}"

                    data-toggle="tooltip"
                    data-placement="top"
                    data-container="body"
                    title="Nueva prueba de idioma"
                >
                    <i class="fa fa-commenting tri-fs-16"></i> {{-- Nueva prueba de idioma --}}
                </button>
            </div>
        @endif
    @endif
@endif

{{-- Botón asistente virtual --}}
@if($user_sesion->hasAccess("llamada_virtual"))
    @if($llamadas_restantes != 0)
        <div class="col-md-1">
            {!! Form::model(Request::all(), ["route" => ["llamada_virtual"], "id" => "fr_candidatos", "method" => "GET"]) !!}
                {!! Form::hidden("modulo", "seleccion") !!}

                <div id="bloque_candidatos_llamar"></div>

                <button 
                    type="button" 
                    id="llamada_virtual"
                    class="btn | tri-circle-btn tri-gray-100 tri-txt-gray-700 hover-bd-gray-400 tri-transition-300"

                    data-toggle="tooltip"
                    data-placement="top"
                    data-container="body"
                    title="Asistente virtual"
                >
                    <i class="fa fa-phone tri-fs-16"></i> {{-- Asistente virtual --}}
                </button>
        </div>
    @endif
@else
    {!! Form::model(Request::all(), ["route" => ["llamada_virtual"], "id" => "fr_candidatos", "method" => "GET"]) !!}
@endif

{{-- Verificar si el requerimiento tiene agendamiento --}}
@if(FuncionesGlobales::agendamientoRequerimiento($requermiento->id))
    <div class="col-md-1">
        <button 
            type="button" 
            class="btn | tri-circle-btn tri-gray-100 tri-txt-gray-700 hover-bd-gray-400 tri-transition-300"

            data-toggle="tooltip" 
            data-placement="top" 
            data-container="body" 
            title="Visualiza los horarios reservados por los candidatos."

            data-reqid="{{ $requermiento->id }}"
            onclick="loadReservedTimes(this, '{{ route("admin.horarios_reservados_cita") }}')" 
        >
            <i class="fas fa-calendar-o tri-fs-16" aria-hidden="true"></i>
            {{-- Citas en el requerimiento --}}
        </button>
    </div>
@endif

@if($user_sesion->hasAccess("admin.reportes_asistencia"))
    <div class="col-md-1">
        <a 
            class="btn | tri-circle-btn tri-gray-100 tri-txt-gray-700 hover-bd-gray-400 tri-transition-300" 
            href="{{ route("admin.reportes_asistencia", ["req_id" => $requermiento->id]) }}" 
            id="reporte_asistencia" 
            target="_blank" 

            data-toggle="tooltip"
            data-placement="top"
            data-container="body"
            title="Reporte asistencia"
        >
            <i class="fa fa-file-excel-o tri-fs-16"></i> {{-- Reporte asistencia --}}
        </a>
    </div>
@endif

{{-- Botón informe preliminar --}}
<div class="col-md-1">
    <button 
        type="button" 
        class="btn | tri-circle-btn tri-gray-100 tri-txt-gray-700 hover-bd-gray-400 tri-transition-300" 
        id="configurar_informe_preliminar" 

        data-toggle="tooltip"
        data-placement="top"
        data-container="body"
        title="Informe preliminar"
    >
        <i class="fa fa-cog tri-fs-16"></i> {{-- Informe preliminar --}}
    </button>
</div>
