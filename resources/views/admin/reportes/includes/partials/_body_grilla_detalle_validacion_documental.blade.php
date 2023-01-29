<tr>
    <td>
        {{$field->nombres}}
    </td>
    <td>
        {{$field->primer_apellido}} {{$field->segundo_apellido}}
    </td>
    <td>
        @if(strlen($field->numero_id)>10)
        {{(string)"\t"."PEP".$field->numero_id."\t"}}
        @else
        {{$field->numero_id}}
        @endif
    </td>
    <td>
        {{$field->req_id}}
    </td>
    <td>
        {{$field->cargo}}
    </td>
    <td>
        {{$field->cliente}}
    </td>

    @foreach ($field->documentos as $documentos)
    <td style="text-align: center;">
        @if (count($documentos['documentos']) > 0 && !isset($formato))
            @foreach ($documentos['documentos'] as $doc)
                @if(file_exists('recursos_documentos/'.$doc->nombre_archivo))
                    <a style="padding-right: 5px;" href='{{ asset("recursos_documentos/$doc->nombre_archivo") }}' target="_blank"><i
                            class="fa fa-file-text-o" aria-hidden="true"></i></a>

                @elseif(file_exists('recursos_documentos_verificados/'.$doc->nombre_archivo))
                    <a style="padding-right: 5px;" href='{{ asset("recursos_documentos_verificados/$doc->nombre_archivo") }}'
                        target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                        
                @elseif(file_exists('contratos/'.$doc->nombre_archivo))
                    <a style="padding-right: 5px;" href='{{ asset("contratos/$doc->nombre_archivo") }}' target="_blank"><i
                            class="fa fa-file-text-o" aria-hidden="true"></i></a>
                @endif
            @endforeach
        @elseif (count($documentos['documentos']) > 0 && isset($formato))
            SI
        @else
            <i class="fa fa-times" aria-hidden="true" style="color:red;">
        @endif
    </td>
    @endforeach
    <td>
        <a target="_blank"
            href="https://api.whatsapp.com/send?phone={!! env('INDICATIVO','57') !!}{{ $field->telefono_movil}}&text=¡Hola %20{{$field->nombres}}! %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}},%20te%20invitamos%20a%20ingresar%20a%20la%20plataforma%20a%20cargar%20los%20documentos%20que%20tienes%20pendientes%20para%20continuar%20con%20tu%20proceso."
            class="btn  btn-block  btn-success aplicar_oferta">@if (isset($formato)) WhatsApp @else <span
                class="fa fa-whatsapp fa-lg" aria-hidden="true"></span> @endif</a>
    </td>
</tr>