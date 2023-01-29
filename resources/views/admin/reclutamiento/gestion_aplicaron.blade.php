@foreach($candidatos_cargo_general as $candidato)
    <tr id="tr_candidato_{{ $candidato->id_aplicaron }}">
        <td>
            <input name="aplicar_candidatos[]" type="checkbox" value="{{ $candidato->user_id }}">

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
            {{ $candidato->getEstado() }}
        </td>
        <td>
            {{$candidato->fecha_aplicacion}}
        </td>

        <td>
            <a
                class="btn btn-sm btn-info"
                href="{{ route('admin.hv_pdf',['id' => $candidato->user_id]) }}"
                target="_blank"
            >
                <i class="fa fa-file-pdf-o"></i>
            </a>

            <a
                class="btn btn-sm btn-info obs-candidato-hv"
                title="Observaciones Hoja de Vida del Candidato"
                data-url="{{ route('admin.mostrar_observaciones_hv') }}"
                data-candidato_id="{{ $candidato->user_id }}"
                href="#"
            >
                <i class="fa fa-comments-o"></i>
            </a>

            @if($user_sesion->hasAccess("boton_video_perfil"))
                @if($candidato->video != null )
                    <a
                        type="button"
                        data-candidato_id="{{ $candidato->user_id }}"
                        class="btn btn-sm btn-primary video_perfil"
                        target="_blank"
                    >
                        VIDEO PERFIL
                    </a>
                @endif
            @endif

            @if($user_sesion->hasAccess("boton_ws"))
                <a class="btn btn-sm btn-success aplicar_oferta" href="https://api.whatsapp.com/send?phone={!! env('INDICATIVO','57') !!}{{ $candidato->telefono_movil }}&text=Hola!%20{{ $candidato->nombres }} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{ $sitio->nombre }},%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección." target="_blank">
                    <span aria-hidden="true" class="fa fa-whatsapp fa-lg"></span>
                </a>
            @endif

            <a
                class="btn btn-sm btn-danger elim-candidato-modulo"
                title="Eliminar Candidato"
                data-url="{{ route('admin.eliminar_candidato_gestion_view') }}"
                data-id_buscar="{{ $candidato->id_aplicaron }}"
                data-modulo="postulado"
                href="#"
            >
                <i class="fa fa-trash"></i>
            </a>
        </td>
    </tr>
@endforeach