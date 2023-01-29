<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-sm-12 col-md-6 mb-2">
            <h4 class="tri-fs-14">CANDIDATOS OTRAS FUENTES</h4>
        </div>

        <div class="col-sm-12 col-md-6 text-right">
            @if(route("home") == "https://gpc.t3rsc.co")
                @if($candidatos_fuentes != null)
                    <a 
                        class="btn btn-success | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-green" 
                        href="#" 
                        id="export_excel_btn" 
                        role="button" data-req={{ $requermiento->id }}
                    >
                        Excel <i aria-hidden="true" class="fas fa-file-excel"></i>
                    </a>
                @endif
            @endif
        </div>

        <div class="col-md-12">
            {!! Form::open(["route" => "admin.agregar_candidato_fuentes", "method" => "post", "id" => "fr_candidatosotrafuentes"]) !!}
                <input name="requerimiento_id" type="hidden" value="{{ $requermiento->id }}" id="req_id_section_otras_fuentes">

                <table class="table table-hover table-striped text-center candidatosOtrasFuentesGestion" id="tbl_preguntas">
                    <thead>
                        <tr>
                            <th>
                                {!! Form::checkbox("seleccionar_todos_candidatos_fuentes", null, false, ["id" => "seleccionar_todos_candidatos_fuentes"]) !!}
                            </th>
                            <th style="width: 10px">IDENTIFICACIÓN</th>
                            <th>NOMBRES</th>
                            <th>CELULAR</th>
                            <!--<th>MÓVIL</th>-->
                            <th style="width: 30px">HV?</th>
                            <th colspan="2" style="width: 50px">ACCIÓN</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($candidatos_fuentes as $candidato_fuentes)
                            <tr id="tr_candidato_{{ $candidato_fuentes->id }}">
                                <td class="text-center">
                                    <input name="aplicar_candidatos_fuentes[]" type="checkbox" value="{{ $candidato_fuentes->cedula }}">
                                </td>

                                @if(route("home") == "https://gpc.t3rsc.co")
                                    <td>
                                        <button 
                                            type="button"
                                            class="btn btn-small btn-default btn-block detalle_otras_fuentes" 
                                            data-id="{{ $candidato_fuentes->cedula }}" 
                                            data-req_id={{ $candidato_fuentes->requerimiento_id }}
                                        >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                @endif

                                <td>
                                    {{ $candidato_fuentes->cedula }}
                                </td>
                    
                                <td>
                                    @if($candidato_fuentes->nombres != "")
                                        {{ $candidato_fuentes->nombres }}
                                    @else
                                        {{ ucwords(mb_strtolower($candidato_fuentes->nombreIdentificacion())) }}
                                    @endif
                                </td>

                                <td>
                                    {{ $candidato_fuentes->celular }}
                                </td>

                                <td>
                                    {{ $candidato_fuentes->verificaHv() }}
                                </td>

                                {{-- Acciones --}}
                                <td>
                                    <button 
                                        class="btn btn-xs btn-primary edit-fuente" 
                                        data-url="{{ route('admin.editar_candidato_fuentes', $candidato_fuentes->id) }}" 
                                        modal-toggle="modal" 
                                        title="Editar candidato"
                                    >
                                        <i class="fas fa-pen"></i>
                                    </button>

                                    @if($candidato_fuentes->email != "")
                                        <button type="button" class="btn btn-xs btn-info construir_email" title="Enviar correo">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        {!! Form::hidden("id_candidato", $candidato_fuentes->id) !!}
                                    @endif

                                    @if($candidato_fuentes->celular)
                                        @if($user_sesion->hasAccess("boton_ws"))
                                            <a 
                                                class="btn btn-xs btn-success" 
                                                href="https://api.whatsapp.com/send?phone={!! env('INDICATIVO','57') !!}{{ $candidato_fuentes->celular }}&text=Hola!%20{{$candidato_fuentes->nombres}} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}}," 
                                                target="_blank" 
                                                title="Enviar Whatsapp"
                                            >
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        @endif
                                    @endif

                                    <button 
                                        class="btn btn-xs btn-danger elim-fuente" 
                                        data-url="{{ route('admin.eliminar_candidato_fuentes',$candidato_fuentes->id) }}" 
                                        title="Eliminar Candidato"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr id="no_hay">
                                <td colspan="6">
                                    No se encontraron registros. 
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {!! $candidatos_fuentes->appends(Request::all())->render() !!}

                <div>
                    <button 
                        type="button" 
                        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" 
                        data-req="{{ $requermiento->id }}" 
                        id="ingresar_candidato" 
                    >
                        <i class="fas fa-user-plus" aria-hidden="true"></i> Ingresar candidato
                    </button>

                    <div id="botonAgregarCandidato" style="display: inline-block;">
                        @if($candidatos_fuentes->count() != 0)
                            @if($user_sesion->hasAccess("admin.agregar_candidato_aplicados"))
                                @if(!in_array($estado_req->estados_req, [
                                    config("conf_aplicacion.C_VENTA_PERDIDA"),
                                    config("conf_aplicacion.C_ELIMINADO"),
                                    config("conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL"),
                                    config("conf_aplicacion.C_TERMINADO")
                                ]))
                                    <button 
                                        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-d-yellow tri-bg-white tri-bd-d-yellow tri-transition-300 tri-hover-out-d-yellow"
                                        type="button" id="add_requerimiento_cand_fuente" 
                                    >
                                        <i class="fas fa-plus" aria-hidden="true"></i> Agregar candidatos seleccionados
                                    </button>
                                @endif
                            @endif
                        @endif
                    </div>

                    @if(!$boton && $requermiento->tipo_proceso_id == $sitio->id_proceso_sitio)
                        <a class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-300 tri-hover-out-blue" target="_blank" href="{{ route('admin.lista_carga_scanner', ['req_id' => $requermiento->id]) }}">
                            Scanner candidato
                        </a>
                    @endif
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>