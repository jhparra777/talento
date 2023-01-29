<div class="btn-group">
    <button 
        type="button" 
        class="btn btn-warning | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
        PROCESO
    </button>

    <button 
        type="button" 
        class="btn btn-warning dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-toggle="dropdown" 

        @if(($boton || isset($transferido)) && route("home") != "https://listos.t3rsc.co" && route("home") != "https://vym.t3rsc.co") disabled @endif
    >
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>

    <ul class="dropdown-menu pd-0" role="menu">
        @if ($valida_botones !== null)
            @foreach ($valida_botones as $validar)
                {{-- Boton validación documental --}}
                @if($validar->valor == "validacion")
                    @if($user_sesion->hasAccess("admin.enviar_documento_view"))
                        @if(route("home") == "https://komatsu.t3rsc.co")
                            <li>
                                <button 
                                    type="button" 
                                    class="btn btn-default btn-sm btn-block btn_documento | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                                    data-cliente="{{ $cliente->id }}" 
                                    data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                                    @if(in_array('ENVIO_DOCUMENTOS',$processes) || in_array('ENVIO_CONTRATACION',$processes))

                                    disabled

                                    @endif
                                >
                                    ESTUDIO DE SEGURIDAD
                                </button>
                            </li>
                        @else
                            <li>
                                <button 
                                    type="button" 
                                    class="btn btn-default btn-sm btn-block btn_documento | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                                    data-cliente="{{ $cliente->id }}" 
                                    data-candidato_req="{{ $candidato_req->req_candidato_id }}"


                                    @if(in_array('ENVIO_DOCUMENTOS',$processes) || in_array('ENVIO_CONTRATACION',$processes))

                                    disabled

                                    @endif 
                                >
                                    VALIDACIÓN DOCUMENTAL
                                </button>
                            </li>
                        @endif
                    @endif
                @endif

                {{-- Botón referenciar --}}
                @if($validar->valor == "referenciacion")
                    @if($user_sesion->hasAccess("admin.enviar_referenciacion_view"))
                        <li>
                            <button
                                 @if(in_array('ENVIO_REFERENCIACION',$processes) || in_array('ENVIO_CONTRATACION',$processes))
                                    disabled
                                 @endif
                                
                                type="button" 
                                class="btn btn-default btn-sm btn-block btn_referenciacion | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                                data-cliente="{{ $cliente->id }}" 
                                data-candidato_req="{{ $candidato_req->req_candidato_id }}"
                            >
                                REFERENCIAS LABORALES

                            </button>
                        </li>
                    @endif
                @endif

                {{-- Botón referencia academica --}}
                @if($validar->valor == "referencia_estudios")
                    @if($user_sesion->hasAccess("admin.enviar_referencia_estudios_view"))
                        <li>
                            <button 
                                {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_REFERENCIA_ESTUDIO","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}         
                                type="button"
                                class="btn btn-default btn-sm btn-block btn_referencia_estudios | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                                data-cliente="{{$cliente->id}}" 
                                data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                REFERENCIAS ACADÉMICAS
                            </button>
                        </li>
                    @endif
                @endif

                {{-- Botón pruebas --}}
                @if($validar->valor == "pruebas_psicotecnicas")
                    @if($user_sesion->hasAccess("admin.enviar_pruebas_view"))
                        <li>
                            <button
                                type="button"
                                class="btn btn-default btn-sm btn-block btn_pruebas | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                data-cliente="{{ $cliente->id }}"
                                data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                                {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id, ["ENVIO_CONTRATACION"])) ? "disabled='disabled'" : "") !!}
                            >
                                PRUEBAS
                            </button>
                        </li>
                    @endif
                @endif

                {{-- Botón entrevista --}}
                @if($validar->valor == "entrevista" || $validar->valor == "sinficha")
                    @if($user_sesion->hasAccess("admin.enviar_entrevista_view"))
                        <li>
                            <button 
                                type="button" 
                                class="btn btn-default btn-sm btn-block btn_entrevista | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                                data-cliente="{{ $cliente->id }}" 
                                data-candidato_req="{{ $candidato_req->req_candidato_id }}" 
                                data-route="{{ route('home') }}"

                                {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_ENTREVISTA","ENVIO_CONTRATACION"])) ? "disabled='disabled'" : "") !!} 
                            >
                                ENTREVISTA
                            </button>
                        </li>
                    @endif
                @endif

                {{-- Botón entrevista virtual --}}
                @if($entrevista_virtual != 0)
                    <li>
                        <button 
                            type="button" 
                            class="btn btn-default btn-sm btn-block btn_video_entrevista | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                            data-cliente="{{ $cliente->id }}" 
                            data-user_id="{{ $candidato_req->user_id }}" 
                            data-req_id="{{ $requermiento->id }}" 
                            data-cliente="{{ $cliente->id }}" 
                            data-candidato_req="{{ $candidato_req->req_candidato_id }}" 
                            data-candidato="{{ $candidato_req->candidato_id }}"

                            {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id, ["ENVIO_ENTREVISTA_VIRTUAL", "ENVIO_CONTRATACION"])) ? "disabled='disabled'" : "") !!} 
                        >
                            ENTREVISTA VIRTUAL
                        </button>
                    </li>
                @endif
            @endforeach
        @else
            {{-- Botón validación documental --}}
            @if($user_sesion->hasAccess("admin.enviar_documento_view"))
                @if(route("home") == "https://komatsu.t3rsc.co")
                    <li>
                        <button 
                            type="button" 
                            class="btn btn-default btn-sm btn-block btn_documento | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                            data-cliente="{{ $cliente->id }}" 
                            data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                            @if(in_array('ENVIO_DOCUMENTOS',$processes) || in_array('ENVIO_CONTRATACION',$processes))

                                disabled

                            @endif
                        >
                            ESTUDIO DE SEGURIDAD
                        </button>
                    </li>
                @else
                    <li>
                        <button 
                            type="button" 
                            class="btn btn-default btn-sm btn-block btn_documento | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                            data-cliente="{{ $cliente->id }}" 
                            data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                            @if(in_array('ENVIO_DOCUMENTOS',$processes) || in_array('ENVIO_CONTRATACION',$processes))
                                disabled
                            @endif
                        >
                            VALIDACIÓN DOCUMENTAL
                        </button>
                    </li>
                @endif
            @endif

            {{-- Boton referenciar --}}
            @if($user_sesion->hasAccess("admin.enviar_referenciacion_view"))
                <li>
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block btn_referenciacion | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        data-cliente="{{ $cliente->id }}" 
                        data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                        @if(in_array('ENVIO_REFERENCIACION',$processes) ||
                         in_array('ENVIO_CONTRATACION',$processes))
                                    disabled
                        @endif

                    >
                        REFERENCIAS LABORALES
                    </button>
                </li>
            @endif

            {{-- Boton referenciacion academica --}}
            @if($user_sesion->hasAccess("admin.enviar_referencia_estudios_view"))
                <li>
                    <button 
                        @if(in_array('ENVIO_REFERENCIA_ESTUDIO',$processes) ||
                         in_array('ENVIO_CONTRATACION',$processes))
                                    disabled
                        @endif
                        
                        type="button" 
                        class="btn btn-default btn-sm btn-block btn_referencia_estudios | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        data-cliente="{{$cliente->id}}" 
                        data-candidato_req="{{$candidato_req->req_candidato_id}}">
                        REFERENCIAS ACADÉMICAS
                    </button>
                </li>
            @endif

            {{-- Boton pruebas --}}
            @if($user_sesion->hasAccess("admin.enviar_pruebas_view"))
                <li>
                    <button
                        type="button"
                        class="btn btn-default btn-sm btn-block btn_pruebas | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                        data-cliente="{{ $cliente->id }}"
                        data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                        @if(in_array('ENVIO_CONTRATACION',$processes))
                            disabled
                        @endif
                        
                    >
                        PRUEBAS
                    </button>
                </li>
            @endif

            {{-- Boton entrevista --}}
            @if($user_sesion->hasAccess("admin.enviar_entrevista_view"))
                <li>
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block btn_entrevista | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        data-cliente="{{ $cliente->id }}" 
                        data-candidato_req="{{ $candidato_req->req_candidato_id }}" 
                        data-route="{{ route('home') }}"

                        @if(in_array('ENVIO_ENTREVISTA',$processes) ||
                         in_array('ENVIO_CONTRATACION',$processes))
                            disabled
                        @endif
                         
                    >
                        ENTREVISTA
                    </button>
                </li>
            @endif
        @endif

        @if($sitioModulo->estudio_virtual_seguridad == 'enabled')
            <li>
                <button
                    type="button"
                    class="btn btn-default btn-sm btn-block btn_enviar_evs | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                    @if(in_array('ESTUDIO_VIRTUAL_SEGURIDAD',$processes) ||
                         in_array('ENVIO_CONTRATACION',$processes))
                        disabled
                    @endif
                >
                    ESTUDIO VIRTUAL DE SEGURIDAD
                </button>
            </li>
        @endif

        <!-- Boton entrevista virtual -->
        @if($entrevista_virtual != 0)
            <li>
                <button 
                    type="button" 
                    class="btn btn-default btn-sm btn-block btn_video_entrevista | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    data-cliente="{{ $cliente->id }}" 
                    data-req_id="{{ $requermiento->id }}" 
                    data-user_id="{{ $candidato_req->user_id }}" 
                    data-cliente="{{ $cliente->id }}"
                    data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                    @if(in_array('ENVIO_ENTREVISTA_VIRTUAL',$processes) ||
                         in_array('ENVIO_CONTRATACION',$processes))
                            disabled
                    @endif
                    
                >
                    ENTREVISTA VIRTUAL
                </button>
            </li>
        @endif

        <!-- Boton prueba idioma -->
        @if($prueba_idioma != 0)
            <li>
                <button 
                    type="button" 
                    class="btn btn-default btn-sm btn-block btn_prueba_idioma | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    data-cliente="{{ $cliente->id }}" 
                    data-req_id="{{ $requermiento->id }}" 
                    data-user_id="{{ $candidato_req->user_id }}" 
                    data-cliente="{{ $cliente->id }}"
                    data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                    @if(in_array('ENVIO_PRUEBA_IDIOMA',$processes) || in_array('ENVIO_CONTRATACION',$processes))
                        disabled
                    @endif
                    
                >
                    PRUEBA IDIOMA
                </button>
            </li>
        @endif

        <!-- Examenes medicos -->  
        <li>
            <button
                type="button"
                class="btn btn-default btn-sm btn-block btn-enviar-examenes | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                data-cliente="{{ $cliente->id }}"
                data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                @if(in_array('ENVIO_EXAMENES',$processes) ||in_array('ENVIO_CONTRATACION',$processes))
                    disabled
                @endif
                
            >
                EXÁMENES MÉDICOS
            </button>
        </li>

        {{--<li>
            <button
                type="button"
                class="btn btn-default btn-sm btn-block btn-enviar-estudio-seg | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                data-cliente="{{ $cliente->id }}"
                data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                @if(in_array('ESTUDIO_SEGURIDAD',$processes) ||in_array('ENVIO_CONTRATACION',$processes))
                    disabled
                @endif
                
            >
                ESTUDIO SEGURIDAD
            </button>
        </li>--}}

        @if($sitioModulo->consulta_tusdatos == 'enabled')
            <li>
                <?php $tusdatos = FuncionesGlobales::getTusDatos($requermiento->id, $candidato_req->user_id); ?>

                @if ($tusdatos->status != 'invalido' && isset($tusdatos))
                    <button class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" type="button" disabled>
                        CONSULTA DE SEGURIDAD AVANZADA
                    </button>
                @else
                    <button 
                        class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        type="button" 
                        id="enviarTusdatos" 
                        onclick="enviarTusDatos({{ $candidato_req->user_id }}, {{ $requermiento->id }}, '{{ route('admin.tusdatos_enviar') }}')"
                    >
                        CONSULTA DE SEGURIDAD AVANZADA
                    </button>
                @endif
            </li>
        @endif

        @if($sitioModulo->consulta_seguridad == 'enabled')
            <li>
                <button 
                    type="button" 
                    onclick="consultaSeguridadCore('consulta_seguridad', '{{ route("admin.verificacion_documento_core") }}', '{{ route("admin.consulta_documento_core") }}', {{ $candidato_req->numero_id }},  {{ $candidato_req->user_id }},  {{ $candidato_req->req_id }}, {{ $cliente->id }});" 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                >
                    CONSULTA DE SEGURIDAD
                </button>
            </li>
        @endif

        @if($sitioModulo->listas_vinculantes == 'enabled' && $lista_vinculante_acceso)
            <li>
                <button 
                    type="button" 
                    onclick="consultaSeguridadCore('listas_vinculantes', '{{ route("admin.verificacion_documento_core") }}', '{{ route("admin.consulta_documento_core") }}', {{ $candidato_req->numero_id }},  {{ $candidato_req->user_id }},  {{ $candidato_req->req_id }}, {{ $cliente->id }});" 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                >
                    LISTAS VINCULANTES
                </button>
            </li>
        @endif

        {{-- @if (route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co")
            <li>
                @if (FuncionesGlobales::getTruora($requermiento->id, $candidato_req->user_id) == 1)
                    <button type="button" class="btn btn-sm btn-info | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" disabled>
                        CONSULTAR EN TRUORA
                    </button>
                @else
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                        id="generateTruora" 
                        onclick="generateTruora({{ $candidato_req->user_id }}, {{ $requermiento->id }}, '{{ route('admin.generate_check_truora') }}')"
                    >
                        CONSULTAR EN TRUORA
                    </button>
                @endif
            </li>
        @endif --}}

        @if(route("home") == "https://gpc.t3rsc.co" || route("home") == "http://localhost:8000")
            <li>                                                         
                <button 
                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    type="button" 
                    id="btn_gestion_indi" 
                    data-candidato_user="{{ $candidato_req->user_id }}" 
                    data-req_id="{{ $requermiento->id }}"
                >
                    GESTIÓN INFORME INDIVDUAL
                </button>
            </li>
        @endif

        @if($sitioModulo->consentimiento_permisos == 'enabled' && $consentimiento_config->envia_proceso_gestion == 'SI')
            <li>
                <button 
                    class="btn btn-default btn-sm btn-block btn_consentimiento_permisos_adic | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                    type="button"
                    data-candidato_req="{{ $candidato_req->req_candidato_id }}"

                    @if(in_array('CONSENTIMIENTO_PERMISO',$processes) ||in_array('ENVIO_CONTRATACION',$processes))
                        disabled
                    @endif
                >
                    {{ $consentimiento_config->titulo_boton_envio_proceso }}
                </button>
            </li>
        @endif

        @if($sitioModulo->evaluacion_sst == 'enabled')
            <li>
                <button 
                    class="btn btn-default btn-sm btn-block btn_enviar_sst | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                    type="button" 
                    data-cliente="{{ $cliente->id }}" 
                    data-candidato_req="{{ $candidato_req->req_candidato_id }}" 

                     @if(in_array('ENVIO_SST',$processes) ||in_array('ENVIO_CONTRATACION',$processes))
                         disabled
                    @endif
                    
                >
                    {{ $configuracion_sst->titulo_boton_envio_proceso }}
                </button>
            </li>
        @endif

        @if($sitioModulo->visita_domiciliaria == 'enabled' && ($requermiento->tipo_visita_id==2 || $requermiento->tipo_visita_id==3))

        <li>
            <button 
                type="button" 
                class="btn btn-default btn-sm btn-block btn_enviar_visita_domiciliaria | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"  
                data-cliente="{{$cliente->id}}" 
                data-candidato_req="{{$candidato_req->req_candidato_id}}" 

                @if(in_array('VISITA_DOMICILIARIA',$processes) ||in_array('ENVIO_CONTRATACION',$processes))
                  disabled
                @endif
               >
                VISITA DOMICILIARIA
            </button>
        </li>
        @endif


    </ul>
</div>