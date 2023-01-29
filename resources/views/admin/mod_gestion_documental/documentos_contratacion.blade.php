@extends("admin.mod_gestion_documental.layout.documents.list_document_master")
@section('btn-header')

<style type="text/css">
    .val-m {
        vertical-align: middle !important;
    }
</style>
            
<div class="row">
    @if ($firmaContrato != null)
        @if ($firmaContrato->estado == 1 || $firmaContrato->estado === 1)
            @if($firmaContrato->terminado != null && $firmaContrato->terminado == 1 || $firmaContrato->terminado == 3)
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-5">
                            @if ($firmaContrato->contrato !== null || $firmaContrato->contrato !== '')
                            <a type="button" class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{route('generar_carnet_general',$firmaContrato->user_id)}}" target="_blank"> Carnet Candidato </a>
                            @endif

                            @if($carta_presentacion != null)
                                @if(file_exists("recursos_carta_presentacion/$carta_presentacion->nombre"))
                                    <a href='{{route("view_document_url", encrypt("recursos_carta_presentacion/"."|".$carta_presentacion->nombre))}}' class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" target="_blank">
                                        Carta Presentación
                                    </a>
                                @endif
                            @endif
                        </div>
                        <div class="col-sm-7" style="text-align: right;">
                        @if(file_exists('contratos/contrato_sin_video_'.$firmaContrato->id.'.pdf'))
                            <a type="button" class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{route('view_document_url', encrypt('contratos/'.'|contrato_sin_video_'.$firmaContrato->id.'.pdf')) }}" target="_blank"> Aceptación condiciones </a>
                        @else
                            @if ($firmaContrato->terminado == 1)
                                @if(count($getVideoQuestion) >= 1)
                                    <button type="button" class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-toggle="modal" data-target="#videoModal"> Videos contrato </button>
                                @endif
                            @endif
                        @endif

                        @if($firmaContrato->contrato !== null && $firmaContrato->contrato !== '')
                            <a type="button" class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{route('view_document_url', encrypt('contratos/'.'|'.$firmaContrato->contrato))}}" target="_blank">
                                Contrato
                            </a>

                            @if ($clausulasContrato != null || $clausulasContrato != '')
                                <div class="btn-group">
                                       <button 
                                        type="button" 
                                        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
                                        Clausulas
                                        </button>
                                        <button 
                                            type="button" class="btn btn-default dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-toggle="dropdown"

                                                     >
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                         </button>
                                        <ul class="dropdown-menu">
                                            @foreach ($clausulasContrato as $index => $clausula)
                                                <a class="btn btn-success btn-block" href="{{route('view_document_url', encrypt('contratos/'.'|'.$clausula->documento_firmado))}}" target="_blank">Cláusula {{ ++$index }}</a>
                                            @endforeach
                                        </ul>
                                </div>
                            @endif
                        @endif
                    </div>
                    </div>
                    
                </div>
            @endif
        @else
            @if($anuladoContrato != null || $anuladoContrato != '')
                <div class="row">
                    <div class="col-sm-12" style="text-align: right;">
                        @if ($anuladoContrato->documento !== null || $anuladoContrato->documento !== '')
                            <a type="button" class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{ route('view_document_url', encrypt('contratos_anulados/'.'|'.$anuladoContrato->documento)) }}" target="_blank">
                                Contrato anulado
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    @endif

    @if($sitioModulo->evaluacion_sst === 'enabled')
        <?php
            $extension = null;
            $extensiones = ['.pdf','.docx','.doc','.png','.jpg','.jpeg'];
            foreach ($extensiones as $ext) {
                if(file_exists('recursos_evaluacion_sst/evaluacion_sst_'.$datos_candidato->user_id.'_'.$req.$ext)) {
                    $extension = $ext;
                    break;
                }
            }
            if ($extension == null) {
                foreach ($extensiones as $ext) {
                    if (file_exists('contratos/evaluacion_sst_'.$datos_candidato->user_id.$ext)) {
                        $extension = $ext;
                        break;
                    }
                }
            }
        ?>
        @if(file_exists('recursos_evaluacion_sst/evaluacion_sst_'.$datos_candidato->user_id.'_'.$req.$extension))
            <div class="row">
                <a type="button" class="btn btn-primary pull-left | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" style="margin-left: 10px;" href="{{ route('view_document_url', encrypt('recursos_evaluacion_sst/'.'|evaluacion_sst_'.$datos_candidato->user_id.'_'.$req.$extension))}}" target="_blank">
                    {{ $configuracion_sst->titulo_boton_ver_archivo }} </a>
            </div>
        @elseif(file_exists('contratos/evaluacion_sst_'.$datos_candidato->user_id.$extension))
            <div class="row">
                <a type="button" class="btn btn-primary pull-left | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" style="margin-left: 10px;" href="{{route('view_document_url', encrypt('contratos/'.'|evaluacion_sst_'.$datos_candidato->user_id.$extension))}}" target="_blank">
                    {{ $configuracion_sst->titulo_boton_ver_archivo }} </a>
            </div>
        @endif
    @endif
</div>
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
                                             {{-- <span class="caret"></span> --}}
                                        
                                        </button>
                                        <ul class="dropdown-menu pd-0">
                                            <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                <a class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$doc->nombre."|".$tipo->id)) }}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> Ver</a>

                                                <a class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href="{{ route('admin.descargar_recurso', ['recursos_documentos', $doc->nombre]) }}" target="_blank" title="Descargar archivo">
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
        @else
            <p>No hay documentos para este cargo</p>
        @endif
    </tbody>
@stop

@section('botones')
    <div class="col-md-12 text-center">
        
        @if(!$req_candidato->bloqueo_carpeta && $current_user->hasAccess("admin.gestion_documental.cargar_documento"))
            <button class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" id="cargarDocumentoContrat" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
        @endif
    </div>
@stop

<div class="modal fade" id="videoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>

                    <h4 class="modal-title">Contratación videos confirmación</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php $i = 0; ?>
                            @foreach ($getVideoQuestion as $video)
                                <?php $i++; ?>

                                <div class="panel panel-default" style="margin-bottom: 10px;">
                                    <div class="panel-body">
                                        <div class="col-md-9">
                                            {{ $video->desc_pregunta }}
                                        </div>

                                        <div class="col-md-3">
                                            <button
                                                type="button"
                                                class="btn btn-success pull-right"
                                                onclick="verVideo('{{ asset('video_contratos/'.$video->video) }}', '{{ $video->desc_pregunta }}')">
                                                Ver video <i class="fa fa-play-circle" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="videoShowModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>

                    <h4 class="modal-title">Contratación videos confirmación</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="margin: auto; text-align: center;">
                            <video width="400" height="320" controls id="videoBox" autoplay src=""></video>
                        </div>

                        <div class="col-md-12" id="questionDesc">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@section('scripts-documents')
    <script>
        $(function(){
            $("#cargarDocumentoContrat").on("click", function(){
                $.ajax({
                    url: "{{ route('admin.cargarDocumentoAdminContratacion') }}",
                    data: {
                        user_id: {{ $candidato_id }},
                        req: {{ $req }}
                    },
                    type: "POST",
                    beforeSend: function(){
                    },
                    success: function(response) {
                        $("#modal_gr").find(".modal-content").html(response)
                        $("#modal_gr").modal("show")
                    }
                })
            })

            $('#videoShowModal').on('hidden.bs.modal', function () {
                $('#videoBox').trigger('pause')
            });
        });

        function eliminarDocumento(boton) {
            swal({
                title: "¿Está seguro?",
                text: "¿Desea eliminar el documento? Está acción no se puede revertir.",
                icon: "warning",
                buttons: true,
                buttons: ["Cancelar", "Aceptar"]
            })
            .then((respuesta) => {
                if (respuesta) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.eliminar_documento') }}",
                        data: "id_doc="+boton.dataset.id+"&carpeta=contratacion",
                        success: function (response) {
                            if (response.eliminar) {
                                swal({
                                    text: "Documento eliminado correctamente.",
                                    icon: "success"
                                });
                                setTimeout(() => {
                                    location.reload()
                                }, 2000);
                            } else {
                                mensaje_danger("Se ha presentado un error, intenta nuevamente.");
                            }
                        },
                        error: function (response) {
                            mensaje_danger("Se ha presentado un error, intenta nuevamente.");
                        }
                    });
                }
            });
        }

        function verVideo(videoName, questionDesc){
            $("#videoBox").attr("src", videoName);
            $("#questionDesc").html('<p>'+questionDesc+'</p>');
            $('#videoShowModal').modal('show');
        }

        $(document).on("click", "#orden_contra", function() {
            var req = {{ $req_cand->id }};

            window.open("{{ route('orden_contratacion', $req_cand->id) }}",'_blank');

            $.ajax({
                type: "POST",
                data: "req=" +req,
                url: "{{ route('orden_contratacion',['req'=>$req_cand->id]) }}",
                success: function(response){
                    if(response.success){
                    }
                }
            })
        });
    </script>
@stop