<div class="btn-group">
    <button 
        class="btn btn-success | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
        type="button">
        VERIFICACIÓN
    </button>

    <button 
        type="button"
        class="btn btn-success dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
        data-toggle="dropdown" 
    >
        <span class="caret"></span>

        <span class="sr-only">Toggle Dropdown</span>
    </button>

    <ul class="dropdown-menu pd-0" role="menu">
        {{-- Boton informe preliminar --}}
        @if($user_sesion->hasAccess("admin.informe_preliminar_formulario"))
            @if(\App\Models\PreliminarTranversalesCandidato::realizoInformePreliminar($candidato_req->user_id, $requermiento->id) == "")
                <li>
                    <button 
                        type="button"
                        class="btn btn-default btn-sm btn-block get_informe_preliminar | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        data-candidato_user="{{ $candidato_req->user_id }}" 
                        data-cliente="{{ $cliente->id }}" 
                        data-valida_boton="false" 
                        @if($boton || isset($transferido)) disabled @endif
                    >
                        @if(route("home") == "https://gpc.t3rsc.co")
                            ENTREVISTA BEI
                        @else
                            INFORME PRELIMINAR
                        @endif
                    </button>
                </li>
            @else
                <li>
                    <button 
                        type="button"
                        class="btn btn-default btn-sm btn-block get_informe_preliminar | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        data-candidato_user="{{ $candidato_req->user_id }}" 
                        data-cliente="{{ $cliente->id }}" 
                        data-valida_boton="true" 
                        @if($boton || isset($transferido)) disabled @endif
                    >
                        @if(route("home") == "https://gpc.t3rsc.co")
                            ACT.ENTREVISTA BEI
                        @else
                            ACTUALIZA INFORME PRELIMINAR
                        @endif
                    </button>
                </li>
            @endif
        @endif

        {{-- Boton asistio --}}
        @if(route('home') != "https://talentum.t3rsc.co" && route('home')!= "https://vym.t3rsc.co")
            {{-- 
            <li>
                @if($candidato_req->asistio != 1)
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block btn_asistencia | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        data-req_id="{{ $candidato_req->req_id }}" 
                        data-candidato_id="{{ $candidato_req->candidato_id }}" 
                        data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                        @if(in_array('ENVIO_CONTRATACION',$processes))
                            disabled
                        @endif
                        
                    >
                        ASISTIÓ
                    </button>
                @else
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        disabled
                    >
                        ASISTIÓ
                    </button>
                @endif
            </li>
            --}}
        @endif

        @if($user_sesion->hasAccess("admin.enviar_retroalimentacion_video_view"))
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block btn_retroalimentacion | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                    @if(in_array('RETROALIMENTACION',$processes) || $deshabilitar_btn || isset($transferido))
                        disabled
                    @endif
                   
                >
                    RETROALIMENTACIÓN
                </button>
            </li>
        @endif

        {{-- Boton enviar a aprobar cliente --}}
        @if($user_sesion->hasAccess("admin.enviar_aprobar_cliente_view"))
            @if(route("home") == "https://komatsu.t3rsc.co")
                <li>
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block btn_aprobar_cliente | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        data-cliente="{{ $cliente->id }}" 
                        data-candidato_req="{{ $candidato_req->req_candidato_id }}" 

                        @if(in_array('ENVIO_APROBAR_CLIENTE',$processes) || in_array('ENVIO_CONTRATACION_CLIENTE',$processes) || in_array('ENVIO_CONTRATACION',$processes))
                            disabled
                        @endif
                        
                    >
                        ENVIAR A APROBAR
                    </button>
                </li>
            @else
                <li>
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block btn_aprobar_cliente | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        data-cliente="{{ $cliente->id }}" 
                        data-candidato_req="{{ $candidato_req->req_candidato_id }}" 

                        @if(in_array('ENVIO_APROBAR_CLIENTE',$processes) || in_array('ENVIO_CONTRATACION_CLIENTE',$processes) || in_array('ENVIO_CONTRATACION',$processes) || isset($transferido))
                            disabled
                        @endif
                        
                    >
                       
                        ENVIAR A APROBAR CLIENTE
                        }
                    </button>
                </li>
            @endif
        @endif

        {{-- CONTRATAR --}}
        @if($sitio->precontrata == 1)
            <li>
                <button 
                    type="button"
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    id="pre_contratar"
                    data-cliente="{{ $cliente->id }}"
                    data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                    @if(in_array('PRE_CONTRATAR',$processes) || isset($transferido))
                        disabled
                    @endif
                    
                >
                    PRE-CONTRATAR
                </button>
            </li>
        @else
            @if($contra_cliente != 0)
                @if($user_sesion->hasAccess("admin.enviar_contratar"))
                    <li>
                        <button
                            type="button"
                            class="btn btn-default btn-sm btn-block btn_contratar2 | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                            data-cliente="{{$cliente->id}}"
                            data-user_id ="{{ $candidato_req->user_id }}"
                            data-candidato_req="{{$candidato_req->req_candidato_id}}"
                            data-req_id="{{$candidato_req->req_id}}"

                            {!!
                                ((funcionesglobales::validabotonestado(
                                    $candidato_req->req_candidato_id,
                                    config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')
                                ) || $deshabilitar_btn || isset($transferido)) ? "disabled='disabled'" : "")
                            !!}
                        >
                            {{ (route("home") == "https://gpc.t3rsc.co") ? 'ENVIAR APROBAR' : 'CONTRATAR' }}
                        </button>
                    </li>
                @endif
            @else
                @if($user_sesion->hasAccess("admin.enviar_contratar"))
                    {{-- Valida si el cargo tiene video confirmación --}}
                    @if (FuncionesGlobales::getCargoVideo($requermiento->cargo_especifico_id))
                        {{-- Valida si el candidato esta en proceso de firma sin videos --}}
                        @if (FuncionesGlobales::getLastProcess($candidato_req->req_candidato_id, $candidato_req->user_id, $requermiento->id))
                            <li>
                                <button
                                    type="button"
                                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                    id="btn_recontratar_videos"
                                    data-candidato_id ="{{ $candidato_req->user_id }}"
                                    data-requerimiento_id ="{{ $requermiento->id }}"

                                >
                                    COMPLETAR VIDEOS CONTRATO
                                </button>
                            </li>
                        @else
                            <!-- Este es -->
                            <li>
                                <button
                                    type="button"
                                    class="btn btn-default btn-sm btn-block btn_contratar2 | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                    data-cliente="{{ $cliente->id }}"
                                    data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                                    {!!
                                        ((funcionesglobales::validabotonestado(
                                            $candidato_req->req_candidato_id,
                                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')
                                        ) || $deshabilitar_btn || isset($transferido)) ? "disabled='disabled'" : "")
                                    !!}
                                >
                                    {{ (route("home") == "https://gpc.t3rsc.co") ? 'ENVIAR APROBAR' : 'CONTRATAR' }}
                                </button>
                            </li>
                        @endif
                    @else
                        <li>
                            <button
                                type="button"
                                class="btn btn-default btn-sm btn-block btn_contratar2 | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                data-cliente="{{ $cliente->id }}"
                                data-candidato_req="{{ $candidato_req->req_candidato_id }}"
                                
                                {!!
                                    ((funcionesglobales::validabotonestado(
                                        $candidato_req->req_candidato_id,
                                        config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')
                                    ) || $deshabilitar_btn || isset($transferido)) ? "disabled='disabled'" : "")
                                !!}
                            >
                                {{ (route("home") == "https://gpc.t3rsc.co") ? 'ENVIAR APROBAR' : 'CONTRATAR' }} <!-- Este es -->
                            </button>
                        </li>
                    @endif
                @endif
            @endif
        @endif

        {{-- PAUSAR FIRMA --}}
        @if($requermiento->firma_digital == 1 && $sitio->asistente_contratacion == 1)
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    id="pausar_firma"
                    data-user_id ="{{ $candidato_req->user_id }}"
                    data-req_id ="{{ $requermiento->id }}"
                    data-req_cand_id ="{{ $candidato_req->req_candidato_id }}"
                    data-cliente="{{ $cliente->id }}"

                    {!!
                        ((App\Jobs\FuncionesGlobales::validaBotonProcesosAsistente(
                            $requermiento->id,
                            $candidato_req->user_id,
                            ["FIRMA_VIRTUAL_SIN_VIDEOS", "FIN_CONTRATACION_VIRTUAL"]
                        )) ? "disabled title='El contrato ya se encuentra firmado.'" : "")
                    !!}

                    {!!
                        ((App\Jobs\FuncionesGlobales::validaBotonProcesosAsistente(
                            $requermiento->id,
                            $candidato_req->user_id,
                            ["ENVIO_CONTRATACION"]
                        )) ? "" : "disabled")
                    !!}
                >
                    {{
                        (App\Jobs\FuncionesGlobales::getStateContract($candidato_req->user_id, $requermiento->id)) ? "INICIAR FIRMA" : "PAUSAR FIRMA"
                    }}
                </button>
            </li>
        @endif

        {{-- Anular contrato --}}
        @if($requermiento->firma_digital == 1 && $sitio->asistente_contratacion == 1)
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    id="anular_contrato"
                    data-user_id ="{{ $candidato_req->user_id }}"
                    data-req_id="{{ $requermiento->id }}"
                    data-req_cand_id="{{ $candidato_req->req_candidato_id }}"
                    data-cliente_id="{{ $cliente->id }}"

                    {!!
                        ((App\Jobs\FuncionesGlobales::getFirmState(
                            $candidato_req->user_id,
                            $requermiento->id
                        )) ? "" : "disabled")
                    !!}
                >
                    ANULAR CONTRATO
                </button>
            </li>
        @endif

        {{-- Ver paquete de contratación --}}
        @if(route('home') != "https://gpc.t3rsc.co" && route('home') != "https://asuservicio.t3rsc.co" && route('home')!= "https://humannet.t3rsc.co")
            @if($user_sesion->hasAccess("admin.paquete_contratacion_pdf"))
                <li>
                    <a
                        href="{{ route('admin.paquete_contratacion_pdf', ['id' => $candidato_req->req_candidato_id]) }}"
                        class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                        target="_blank"
                        data-cliente="{{ $cliente->id }}"
                        data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                        style="padding: .5rem 10px;"
                    >
                        {{-- IMPRIMIR --}}
                        @if(route("home") == "http://localhost:8000" || route("home") == "https://desarrollo.t3rsc.co" ||  route("home") == "https://listos.t3rsc.co")
                            ORDEN 
                        @else
                            PAQUETE 
                        @endif
                        DE CONTRATACIÓN
                    </a>
                </li>
            @endif
        @endif
    </ul>
</div>