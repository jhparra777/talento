{!! Form::open(["route"=>"admin.agregar_candidato_preperfilados","method"=>"post"]) !!}
    <input name="requerimiento_id" type="hidden" value="{{$requermiento->id}}">
                
    <table class="table data-table table-hover table-striped text-center">
        <thead>
            <tr>
                <th data-field="checkes">
                    {!! Form::checkbox("seleccionar_todos_candidatos_preperfilados",null,false,["id"=>"seleccionar_todos_candidatos_preperfilados"]) !!}
                </th>
                <th data-field="hv" style="width: 40px">AJUSTE DE RECLUTAMIENTO</th>
                <th data-field="identificacion" style="width: 10px">IDENTIFICACIÓN</th>
                <th data-field="nombre">NOMBRES</th>
                <th data-field="whatsapp">WHATSAPP</th>
                <th data-field="hv" style="width: 40px">HV</th>
                <th data-field="video" >VIDEO PERFIL</th>
                <th data-field="editar" ></th>
            </tr>
        </thead>
        <tbody>            
            @foreach($candidatos_cargo_general as $candidato_general)
                <tr id="tr_candidato_{{$candidato_general->id_preperfil}}">
                    <td>
                        <input name="aplicar_candidatos_preperfilado[]" type="checkbox" value="{{$candidato_general->user_id}}"/>
                    </td>
                    <td>
                        {{$candidato_general->ajuste_perfil}}%
                    </td>
                    <td>
                        {{$candidato_general->numero_id}}
                    </td>
                    <td>
                        {{$candidato_general->nombres ." ".$candidato_general->primer_apellido }}
                    </td>
                    <td>
                        @if($user_sesion->hasAccess("boton_ws"))
                            <a class="btn btn-sm btn-success aplicar_oferta | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-green" href="https://api.whatsapp.com/send?phone=57{{ $candidato_general->telefono_movil}}&text=Hola!%20{{$candidato_general->nombres}} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}},%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección." target="_blank">
                                <i class="fab fa-whatsapp tri-fs-14" aria-hidden="true"></i>
                            </a>
                        @endif
                    </td>
                    <td>
                        <a 
                            class="btn btn-sm btn-info | tri-br-2 tri-fs-12 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-300 tri-hover-out-blue" 
                            href="{{route('admin.hv_pdf',['id'=> $candidato_general->user_id])}}"
                            target="_blank"
                            title="Ver Hoja de Vida del Candidato"
                        >
                            <i class="fas fa-file-pdf tri-fs-14" aria-hidden="true"></i>
                        </a>

                        <a
                            class="btn btn-sm btn-info obs-candidato-hv | tri-br-2 tri-fs-12 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-300 tri-hover-out-blue"
                            title="Observaciones Hoja de Vida del Candidato"
                            data-url="{{ route('admin.mostrar_observaciones_hv') }}"
                            data-candidato_id="{{ $candidato_general->user_id }}"
                            href="#"
                        >
                            <i class="fas fa-comments"></i>
                        </a>
                    </td>
                    
                    <td>
                        @if($user_sesion->hasAccess("boton_video_perfil"))
                            @if($candidato_general->video != null )
                                <a 
                                    type="button"
                                    data-candidato_id ="{{$candidato_general->user_id}}"
                                    class="btn btn-sm btn-info video_perfil | tri-br-2 tri-fs-12 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-300 tri-hover-out-blue"
                                    title="Video Perfil del Candidato"
                                >
                                    VIDEO PERFIL
                                </a>
                            @else
                                NO POSEE
                            @endif
                        @endif
                    </td>
                    <td>
                        <a 
                            class="btn btn-sm btn-danger elim-candidato-modulo | tri-br-2 tri-fs-12 tri-txt-red tri-bg-white tri-bd-red tri-transition-300 tri-hover-out-red"
                            data-url="{{route('admin.eliminar_candidato_gestion_view')}}"
                            data-id_buscar="{{ $candidato_general->id_preperfil }}"
                            data-modulo="preperfilado"
                            title="Eliminar Candidato" 
                            href="#"
                        >
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>                    

    @if($candidatos_cargo_general->count() != 0)
        @if($user_sesion->hasAccess("admin.agregar_candidato_aplicados"))
            @if(!in_array($estado_req->estados_req,[config("conf_aplicacion.C_VENTA_PERDIDA"),config("conf_aplicacion.C_ELIMINADO"),config("conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL"),config("conf_aplicacion.C_TERMINADO")]))
                <button class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-d-yellow tri-bg-white tri-bd-d-yellow tri-transition-300 tri-hover-out-d-yellow" type="button" id="add_requerimiento_preperfilados">
                    <i class="fas fa-plus" aria-hidden="true"></i> Agregar candidatos seleccionados
                </button>
            @endif
        @endif
    @endif
{!! Form::close() !!}