@extends("admin.mod_gestion_documental.layout.documents.list_document_master")
@section('btn-header')

<style type="text/css">
    .val-m {
        vertical-align: middle !important;
    }
</style>

@stop

@section('body-table')
    <tbody style="text-transform: uppercase;">
        @if($tipo_documento->count() != 0)
            @foreach($tipo_documento as $tipo)
                @if( count($tipo->documentos) > 0)
                    <?php
                        $contador=1;
                    ?>
                    @foreach($tipo->documentos as $doc)
                        <tr>
                            <td class="val-m">{{ $tipo->descripcion }}</td>
                            <td> {{ $doc->usuarioGestiono->name }} </td>
                            <td> {{ date("d-m-Y",strtotime($doc->fecha_carga)) }} </td>
                            <td>
                                <i class="fa fa-check" aria-hidden="true" style="color:green; margin-right: 4px;"></i>
                            </td>
                            <td>

                                <div class="btn-group-vertical">
                                    <div class="btn-group">
                                        <button
                                            type="button"
                                            class="btn btn-info btn-sm btn-block dropdown-toggle | tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"

                                            {{-- style="border-radius: .3rem .3rem .3rem .3rem;" --}}
                                            >
                                            <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">Documento {{$contador}}</span>
                                            
                                        
                                        </button>
                                        <ul class="dropdown-menu pd-0">
                                            <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                    <a class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$doc->nombre."|".$tipo->id)) }}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i>Ver</a>

                                                    <a class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href="{{ route('admin.descargar_recurso', ['recursos_documentos_verificados', $doc->nombre]) }}" target="_blank" title="Descargar archivo">
                                                        <i class="fa fa-download" aria-hidden="true"></i>
                                                        Descargar
                                                    </a>
                                                    @if($current_user->hasAccess("admin.gestion_documental.eliminar_documento"))
                                                        <button class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" type="button" title="Eliminar archivo" style="margin-right: 6px; border: 0;" data-id="{{ $doc->id_documento }}" onclick="eliminarDocumento(this);">
                                                            <i class="fa fa-trash-o" aria-hidden="true" style="color:red;"></i>
                                                            Eliminar
                                                        </button>
                                                    @endif
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                            $contador++;
                        ?>
                    @endforeach

                @else
                    <tr>
                        <td class="val-m">{{ $tipo->descripcion }}</td>
                        <td></td>
                        <td></td>
                        <td>
                            <i class="fa fa-times" aria-hidden="true" style="color:red;"></i>
                        </td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        @endif

        {{-- Consulta de seguridad --}}
        @if(!empty($consultaSeguridad))
            <tr>
                <td>CONSULTA DE SEGURIDAD</td>
                <td></td>
                <td></td>
                <td>
                     <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                </td>
                <td>
                    <div class="btn-group-vertical">
                        <div class="btn-group">
                            <button
                                type="button"
                                class="btn btn-info btn-sm btn-block dropdown-toggle | tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"

                                {{-- style="border-radius: .3rem .3rem .3rem .3rem;" --}}
                                >
                                <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">Documento 1</span>
                                
                            
                            </button>
                            <ul class="dropdown-menu pd-0">
                                <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                    <a class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{ url('recursos_pdf_consulta/'.$consultaSeguridad->pdf_consulta_file) }}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i>Ver</a>

                                    <a class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{ route('admin.descargar_recurso', ['recursos_pdf_consulta', $consultaSeguridad->pdf_consulta_file]) }}' target="_blank" title="Descargar archivo">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        Descargar
                                    </a>
                                </div>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        @endif

        {{-- Consulta de seguridad --}}
        @if(!empty($tusdatosData))
            <tr>
                <td>CONSULTA TUSDATOS</td>
                <td></td>
                <td></td>
                <td>
                    <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                </td>
                <td>
                    @if($tusdatosData->status == 'finalizado')
                        
                        <a href='{{ route('tusdatos_reporte', ['check' => $tusdatosData->id]) }}' target="_blank">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endif
    </tbody>
@stop

@section('botones')
    @if($current_user->hasAccess("admin.gestion_documental.eliminar_documento"))
    <div class="col-md-12 text-center">
        
        
            <button class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" id="cargarDocumentoConfi" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
    
    </div>
@endif
@stop



@section('scripts-documents')
    <script>
        $(function(){
            $("#cargarDocumentoConfi").on("click", function(){
                $.ajax({
                    url: "{{ route('admin.cargarDocumentoAdminConfidencial') }}",
                    data: {
                        user_id:{{ $candidato_id }},
                        req:{{$req}}
                    },
                    type: "POST",
                    beforeSend: function(){
                    },
                    success: function(response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

    });
</script>
    </script>
@stop