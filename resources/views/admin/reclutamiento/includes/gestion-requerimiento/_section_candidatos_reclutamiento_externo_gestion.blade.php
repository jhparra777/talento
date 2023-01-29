<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-12 col-md-6 mb-1">
                <h4 class="tri-fs-14">CANDIDATOS RECLUTAMIENTO EXTERNO</h4>
            </div>

            <div class="box-body">
                {!! Form::open(["route" => "admin.agregar_candidato_aplicados", "method" => "post"]) !!}
                    <input name="requerimiento_id" type="hidden" value="{{ $requermiento->id }}" id="req_id_section_reclutamiento_externo">

                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5px">
                                    {!! Form::checkbox("seleccionar_todos_candidatos_reclutamiento_externo", null, false, [
                                        "id" => "seleccionar_todos_candidatos_reclutamiento_externo"
                                    ]) !!}
                                </th>

                                <th style="width: 10px">IDENTIFICACIÓN</th>
                                <th style="width: 30px">NOMBRES</th>
                                <th style="width: 10px">MÓVIL</th>
                                <th style="width: 10px">EMAIL</th>

                                <th style="width: 20px">HOJA DE VIDA /VIDEO PERFIL / WHATSAPP/</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($candidatos_reclutamiento_externo as $candidato)
                                <tr id="tr_candidato_{{ $candidato->id_postulacion }}">
                                    <td>
                                        <input name="aplicar_candidatos[]" type="checkbox" value="{{ $candidato->user_id }}" class="externo">

                                        @if ($candidato->referer != null || $candidato->referer == 1)
                                            <img src="{{ asset('assets/admin/imgs/tcn-logo.png') }}" alt="">
                                        @endif
                                    </td>

                                    <td>
                                        {{ $candidato->numero_id }}
                                    </td>

                                    <td>
                                        {{ $candidato->nombres ." ".$candidato->apellidos }}
                                    </td>

                                    <td>
                                        {{ $candidato->telefono_movil }}
                                    </td>

                                    <td>
                                        {{ $candidato->email }}
                                    </td>

                                    <td>
                                        <a
                                            class="btn btn-info"
                                            href="{{ route('admin.hv_pdf',['id' => $candidato->user_id]) }}"
                                            target="_blank"
                                        >
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>

                                        @if($user_sesion->hasAccess("boton_video_perfil"))
                                            @if($candidato->video != null )
                                                <a
                                                    type="button"
                                                    class="btn btn-sm btn-primary video_perfil | tri-br-2 tri-fs-12 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-300 tri-hover-out-blue"
                                                    target="_blank"
                                                    data-candidato_id="{{ $candidato->user_id }}"
                                                >
                                                    VIDEO PERFIL
                                                </a>
                                            @endif
                                        @endif

                                        @if($user_sesion->hasAccess("boton_ws"))
                                            <a class="btn btn-sm btn-success" href="https://api.whatsapp.com/send?phone={!! env('INDICATIVO','57') !!}{{ $candidato->telefono_movil }}&text=Hola!%20{{ $candidato->nombres }} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{ $sitio->nombre }},%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección." target="_blank">
                                                <span aria-hidden="true" class="fa fa-whatsapp fa-lg"></span>
                                            </a>
                                        @endif

                                        <a
                                            class="btn btn-danger elim-fuente"
                                            title="Eliminar Candidato"
                                            data-url="{{ route('admin.eliminar_candidato_postulado',['id'=>$candidato->id_postulacion] ) }}"
                                            href="#"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        No se encontraron registros.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {!! $candidatos_reclutamiento_externo->appends(Request::all())->render() !!}

                    @if($candidatos_reclutamiento_externo->count() != 0)
                        @if($user_sesion->hasAccess("admin.agregar_candidato_aplicados"))
                            @if(!in_array($estado_req->estados_req, [
                                config("conf_aplicacion.C_VENTA_PERDIDA"),
                                config("conf_aplicacion.C_ELIMINADO"),
                                config("conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL"),
                                config("conf_aplicacion.C_TERMINADO")
                            ]))

                                <button 
                                    class="btn btn-warning | tri-br-2 tri-fs-12 tri-txt-d-yellow tri-bg-white tri-bd-d-yellow tri-transition-300 tri-hover-out-d-yellow"
                                    type="button" id="add_requerimiento_reclutamiento_externo">
                                    Agregar candidatos seleccionados
                                </button>
                            @endif
                        @endif
                    @endif
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>