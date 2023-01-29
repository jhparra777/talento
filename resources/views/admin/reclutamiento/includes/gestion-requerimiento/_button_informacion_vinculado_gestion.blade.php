<div class="btn-group">
    <button
        type="button" 
        class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
        INFORMACIÓN 

        @if($candidato_req->getObservacionesNoLeidas() != 0)
            <span class="tri-bg-white tri-txt-purple" style="border-radius: 50%; padding:0 5px;">
                {{ $candidato_req->getObservacionesNoLeidas() }}
            </span>
        @endif
    </button>

    <button 
        type="button" 
        class="btn btn-info dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
        data-toggle="dropdown"
    >
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>

    <ul class="dropdown-menu pd-0" role="menu" id="botones_de_informacion">
        {{-- HOJA DE VIDA --}}
        @if($user_sesion->hasAccess("admin.hv_pdf"))
            <li>
                <a 
                    id="hoja_vida" 
                    type="button" 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    href="{{ route("admin.hv_pdf", ["user_id" => $candidato_req->user_id, "req" => $requermiento->id]) }}" 
                    target="_blank"

                    style="padding: .5rem 10px;" 
                >
                    @if(route("home") == "https://humannet.t3rsc.co") CV PDF @else HV PDF @endif
                </a>
            </li>
        @endif

        {{-- TRAYECTORIA --}}
        @if(route("home") == "https://gpc.t3rsc.co" || route("home") == "http://localhost:8000")
            <li>
                <a 
                    id="hoja_vida" 
                    type="button" 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    href="{{ route("hv_pdf_tabla", ["user_id" => $candidato_req->user_id, "req" => $requermiento->id]) }}" 
                    target="_blank"

                    style="padding: .5rem 10px;" 
                >
                    TRAYECTORIA
                </a>
            </li>
        @endif

        {{-- VER FIRMA --}}
        @if(\App\Models\FirmaContratos::firmaContrato($candidato_req->user_id, $requermiento->id) != "")
            <li>
                <a 
                    type="button" 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    href="{{ \App\Models\FirmaContratos::firmaContrato($candidato_req->user_id, $requermiento->id) }}" 
                    target="_blank"

                    style="padding: .5rem 10px;" 
                >
                    VER FIRMA
                </a>
            </li>
        @endif

        {{-- INFORME DE SELECCION Y BOTON MOSTRAR CONTACTOS --}}
        @if($user_sesion->hasAccess("admin.hv_pdf"))
            @if(route('home') == "http://poderhumano.t3rsc.co")
                <a type="button" style="width: 100%;text-decoration:none;color:white" class="btn btn-info btn-sm" href="{{route("admin.informe_seleccion",["user_id"=>$candidato_req->req_candidato_id])}}" target="_blank">
                    INFORME SELECCIÓN
                </a>

                <li>
                    @if($candidato_req->datos_basicos_activo ==1)
                        <button type="button" style="width: 100%;"  class="btn btn-sm btn-danger" data-datos ="{{ $candidato_req->datos_basicos_id}}" id="datos_contacto_no_mostrar"  >
                            NO MOSTRAR DATOS CONTACTO
                        </button>
                    @else
                        <button type="button" style="width: 100%;" data-datos ="{{ $candidato_req->datos_basicos_id}}" class="btn btn-sm btn-info" id="datos_contacto_mostrar">
                            MOSTRAR DATOS CONTACTO
                        </button>
                    @endif
                </li>
            @else
                <li>
                    <a 
                        type="button" 
                        class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        href="{{ route("admin.informe_seleccion", ["user_id" => $candidato_req->req_candidato_id]) }}" 
                        target="_blank"

                        style="padding: .5rem 10px;" 
                    >
                        INFORME SELECCIÓN
                    </a>
                </li>
            @endif
        @endif

        @if($requermiento->firma_digital == 1 && $sitio->asistente_contratacion == 1)
            {{-- PREVIEW CONTRATO --}}
            @if(!FuncionesGlobales::validaBotonProcesosAsistente($requermiento->id, $candidato_req->user_id, ["ENVIO_CONTRATACION"]))
                <li>
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        title="Permite previsualizar el pdf del contrato."
                        onclick="generateContractPreview('{{ route('home.contrato-laboral-recurso', [$candidato_req->user_id, $candidato_req->req_id]) }}')"
                    >
                        PREVIEW CONTRATO
                    </button>
                </li>
            @endif

            {{-- CONTRATO SIN FIRMAR --}}
            <li>
                <button
                    type="submit"
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    onclick="sendContractFirmForm('{{ route('home.contrato-laboral-recurso', ['user_id' => $candidato_req->user_id, 'req' => $requermiento->id]) }}')"
                    {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id, ["ENVIO_CONTRATACION"])) ? : "disabled = 'disabled'") !!}
                >
                    CONTRATO SIN FIRMAR
                </button>
            </li>

            {{-- EMAIL CONTRATO --}}
            <li>
                <button
                    type="submit"
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    onclick="sendContractFirmForm('{{ route('home.contrato-laboral-recurso', ['user_id' => $candidato_req->user_id, 'req' => $requermiento->id, 'email' => 'true']) }}')"
                    {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id, ["ENVIO_CONTRATACION"])) ? : "disabled = 'disabled'") !!}
                >
                    EMAIL CONTRATO
                </button>
            </li>

            {{-- REENVIAR CORREO CONTRATACIÓN --}}
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    id="reenviar_correo_contrato"

                    data-candidato_id ="{{ $candidato_req->user_id }}"
                    data-req_id="{{$requermiento->id}}"

                    {!!
                        ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id, ["FIRMA_VIRTUAL_SIN_VIDEOS", "FIN_CONTRATACION_VIRTUAL"])) ? "disabled" : "")
                    !!}
                >
                    REENVIAR CORREO CONTRATACIÓN
                </button>
            </li>
        @endif

        {{-- INFORME INDIVIDUAL --}}
        @if(route('home') == "https://gpc.t3rsc.co")
            <li>
                <a 
                    type="button" 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    href="{{ route("admin.informe_individual_pdf", ["user_id" => $candidato_req->candidato_id, "req_id" => $requermiento->id]) }}" 
                    target="_blank"

                    style="padding: .5rem 10px;" 
                >
                    INFORME INDIVIDUAL
                </a>
            </li>
        @endif

        {{-- VIDEO PERFIL --}}
        @if($user_sesion->hasAccess("boton_video_perfil"))
            @if($candidato_req->video != null )
                <li>
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        id="videoPerfil" 
                        data-candidato_id="{{ $candidato_req->user_id }}" 
                    >
                        VIDEO PERFIL
                    </button>
                </li>
            @endif
        @endif

        {{-- OBSERVACIONES --}}
        @if($candidato_req->getObservaciones() != null )
            <li>
                <button 
                    type="button" 
                    class="btn btn-default btn-sm btn-block btn_observaciones | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    data-req_can_id="{{ $candidato_req->req_candidato_id }}" 
                >
                    OBSERVACIONES
                    
                    @if($candidato_req->getObservacionesNoLeidas() != 0)
                        <span class="tri-bg-white tri-txt-blue" style="border-radius: 50%; padding: 0 5px; font-weight: bold; position: absolute; right: 0;">
                            {{ $candidato_req->getObservacionesNoLeidas() }}
                        </span>
                    @endif
                </button>
            </li>
        @endif

        {{-- CITAR PARA CLIENTE --}}
        <li>
            <button 
                type="button" 
                class="btn btn-default btn-sm btn-block btn_citar_to_cliente | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                data-cliente="{{ $cliente->id }}" 
                data-candidato_req="{{ $candidato_req->req_candidato_id }}"
            >
                CITAR PARA CLIENTE
            </button>
        </li>

        <li>
            <a 
                type="button" 
                class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                href="{{ route("admin.aceptacionPoliticaTratamientoDatos", ["user_id" => $candidato_req->candidato_id, "req" => $requermiento->id]) }}" 
                    target="_blank"

                style="padding: .5rem 10px;" 
                >
                    POLÍTICA TRATAMIENTO DE DATOS
                </a>
        </li>
    </ul>
</div>