@extends("admin.mod_gestion_documental.layout.documents.list_document_master")
@section('btn-header')

<style type="text/css">
    .val-m {
        vertical-align: middle !important;
    }
</style>

<div class="row">
        <div class="col-sm-12" style="text-align: right;">
            
            @if ($pruebas != null && $pruebas != '' || count($enlaces_pruebas) > 0)
                <div class="btn-group">)
                <div class="btn-group">
                   <button 
                    type="button" 
                    class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
                    Pruebas
                    </button>
                    <button 
                        type="button" class="btn btn-default dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-toggle="dropdown"

                                 >
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                     </button>
                    <ul class="dropdown-menu">
                        @foreach ($pruebas as $prueba)
                            <a class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_pruebas/"."|".$prueba->nombre_archivo))}}' target="_blank">{{ $prueba->prueba_desc }}</a>
                        @endforeach
                        @foreach ($enlaces_pruebas as $enlace)
                            <a class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href="{{ $enlace->enlace }}" target="_blank">{{ $enlace->nombre }}</a>
                        @endforeach
                    </ul>
                </div>
            @endif

            <a type="button" class="btn btn-primary btn-sm  | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple status" href="{{ route('admin.informe_seleccion', ['user_id' => $req_can]) }}" target="_blank">Informe Selección</a>
            <a id="hoja_vida" style=" color:#FF0000;text-decoration:none;color:white;" type="button" class="btn btn-primary btn-sm  | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{ route('admin.hv_pdf', ['user_id' => $candidato_id]) }}" target="_blank">
                HV PDF
            </a>
            <a id="autorizacion" type="button" class="btn btn-primary btn-sm  | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple status" href="{{ route("admin.aceptacionPoliticaTratamientoDatos", ["user_id" => $candidato_id,"req"=>$req]) }}" target="_blank">
              ACEPTACIÓN DE POLÍTICA TRATAMIENTO DE DATOS
            </a>
        </div>
        

       
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

                                            style="border-radius: .3rem .3rem .3rem .3rem;"
                                            >
                                            <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">Documento {{$contador}}</span>
                                             {{-- <span class="caret"></span> --}}
                                        
                                        </button>
                                        <ul class="dropdown-menu pd-0">
                                            <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_documentos/"."|".$doc->nombre."|".$tipo->id)) }}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i>Ver</a>

                                                <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href="{{ route('admin.descargar_recurso', ['recursos_documentos', $doc->nombre]) }}" target="_blank" title="Descargar archivo">
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
        @else
            <p>No hay documentos para este cargo</p>
        @endif
    </tbody>
@stop

@section('botones')
    <div class="col-md-12 text-center">
        
        @if(!$req_candidato->bloqueo_carpeta && $current_user->hasAccess("admin.gestion_documental.cargar_documento"))
            <button class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" id="cargarDocumentoAsis" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
        @endif
    </div>
@stop



@section('scripts-documents')
    <script>
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
                        data: "id_doc="+boton.dataset.id+"&carpeta=seleccion",
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

        $(function(){
            $("#cargarDocumentoAsis").on("click", function(){
                $.ajax({
                    url: "{{ route('admin.cargarDocumentoAdminSeleccion') }}",
                    data: "user_id="+{{ $candidato_id }}+"&req_id="+{{$req}},
                    type: "POST",
                    beforeSend: function(){
                    },
                    success: function(response) {
                        console.log("success");
                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");
                    }
                });
            });
        })
    </script>
@stop