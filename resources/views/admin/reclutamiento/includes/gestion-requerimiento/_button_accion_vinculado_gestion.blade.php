<div class="btn-group">
    <button 
        type="button" 
        class="btn btn-danger | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
        ACCIÓN
    </button>

    <button 
        type="button" 
        class="btn btn-danger dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
        data-toggle="dropdown" 
        @if($boton || isset($transferido)) disabled @endif
    >
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>

    <ul class="dropdown-menu pd-0" role="menu">
        <!-- Boton vincular -->
        @if($user_sesion->hasAccess("admin.vincular"))
            @if($user_sesion->hasAccess("boton_vil"))
                <li>
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block btn_enviar_vincular | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        data-cliente="{{ $cliente->id }}" 
                        data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                        {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id, ["ENVIO_VALIDACION", "ENVIO_CONTRATACION"])) ? "disabled='disabled'" : "") !!} 
                    >
                        ENVIAR A VINCULAR
                    </button>
                </li>
            @endif
        @endif

        <!-- Boton rechazar candidato -->
        @if($user_sesion->hasAccess("admin.rechazar_candidato_view"))
            <li>
                <button 
                    type="button" 
                    class="btn btn-default btn-sm btn-block btn_rechazar | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    data-cliente="{{ $cliente->id }}" 
                    data-candidato_req="{{ $candidato_req->req_candidato_id }}" 

                    {!! ((funcionesglobales::validabotonestado($candidato_req->req_candidato_id, config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'))) ? "disabled='disabled'" : "") !!} 
                >
                    INACTIVAR
                </button>
            </li>
        @endif

        <!-- Boton quitar -->
        @if($user_sesion->hasAccess("admin.quitar_candidato_view"))
            <li>
                <button 
                    type="button" 
                    class="btn btn-default btn-sm btn-block btn_quitar | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    data-candidato_req="{{ $candidato_req->req_candidato_id }}" 

                    {!! ((funcionesglobales::validabotonestado($candidato_req->req_candidato_id, config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'))) ? "disabled='disabled'" : "") !!} 
                >
                    QUITAR
                </button>
            </li>
        @endif

        <!-- Boton citar -->
        @if($user_sesion->hasAccess("admin.proceso_citacion"))
            <li>
                <button 
                    type="button"
                    class="btn btn-default btn-sm btn-block modal_citacion | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    data-candidato_req="{{ $candidato_req->req_candidato_id }}" 
                    data-candidato_user="{{ $candidato_req->user_id }}" 
                    data-cliente="{{ $cliente->id }}"
                >
                    CITAR
                </button>
            </li>
        @endif

        <li>
            <a 
                type="button" 
                id="hoja_vida"  
                class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                href="{{ route("admin.actualizar_hv_admin", ["user_id" => $candidato_req->user_id, "req" => $requermiento->id]) }}"

                style="padding: 1rem 10px;" 
            > 
                @if(route("home") == "https://humannet.t3rsc.co")
                    EDITAR CV
                @else
                    EDITAR HV
                @endif
            </a>
        </li>

        <li>
            <a class='"btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"' href="{{route('admin.subir_documentos',['user_id' => $candidato_req->user_id])}}" style="'padding: .5rem 10px;'">VER DOCUMENTO</a>
            
        </li>
    </ul>
</div>