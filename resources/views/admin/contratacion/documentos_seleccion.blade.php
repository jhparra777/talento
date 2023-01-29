@extends("admin.layout.master")
@section('contenedor')
    <div class="row">
        <div class="col-sm-12" style="text-align: right;">
            @if ($pruebas != null && $pruebas != '' || count($enlaces_pruebas) > 0)
                <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pruebas <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        @foreach ($pruebas as $prueba)
                            <a class="btn btn-success btn-block" href='{{route("view_document_url", encrypt("recursos_pruebas/"."|".$prueba->nombre_archivo))}}' target="_blank">{{ $prueba->prueba_desc }}</a>
                        @endforeach
                        @foreach ($enlaces_pruebas as $enlace)
                            <a class="btn btn-success btn-block" href="{{ $enlace->enlace }}" target="_blank">{{ $enlace->nombre }}</a>
                        @endforeach
                    </ul>
                </div>
            @endif

            <a type="button" class="btn btn-info status" href="{{ route("admin.informe_seleccion", ["user_id" => $req_can]) }}" target="_blank">Informe Selección</a>
            <a id="hoja_vida" style=" color:#FF0000;text-decoration:none;color:white;" type="button" class="btn  btn-info " href="{{ route("admin.hv_pdf", ["user_id" => $candidato_id]) }}" target="_blank">
                HV PDF
            </a>
        </div>
        <div class="col-sm-12" style="text-align: left; margin-top: 15px;">
            <a id="autorizacion" style=" color:#FF0000;text-decoration:none;color:white;" type="button" class="btn btn-info" href="{{ route("admin.aceptacionPoliticaTratamientoDatos", ["user_id" => $candidato_id,"req"=>$req]) }}" target="_blank">
              ACEPTACIÓN DE POLÍTICA TRATAMIENTO DE DATOS
            </a>
        </div>
    </div>

    <div class="row">
		<div class="col-sm-6">
            <h2>Documentos selección</h2>

			<h4>{{ $datos_candidato->nombres }} {{ $datos_candidato->primer_apellido }} {{ $datos_candidato->segundo_apellido }}</h4>
            <h4><b>#Req:</b> {{ $req }}</h4>
            <h4><b>#T. Proceso:</b> {{ $requerimiento->tipo_proceso }}</h4>
			<h4><b>Cargo:</b> {{ $requerimiento->cargo_especifico()->descripcion }}</h4>
		</div>
	</div>
  
    <div class="col-right-item-container">
        <div class="container-fluid">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="submit_listing_box">
                    <div class="form-alt">
                        <div class="row">
                            <div class="tabla table-responsive">
                                <table class="table table-bordered table-hover ">
    	                           <thead>
    	                               <tr>
                                            <th class="">Documento</th>
                                            <th> Usuario Cargó </th>
                                            <th> Fecha Carga </th>
                                            <th> Fecha de Vencimiento </th>
                                            <th class="">Status</th>
    	                               </tr>
    	                           </thead>

                                    <tbody style="text-transform: uppercase;">
                                        @if($tipo_documento->count() != 0)
                                            @foreach($tipo_documento as $tipo)
                                                <tr>
                                                    <td>{{ $tipo->descripcion }}</td>

                                                    @if( count($tipo->documentos) > 0)
                                                        <td> {{$tipo->usuario_gestiono}} </td>
                                                        <td> {{ date("d-m-Y",strtotime($tipo->fecha_carga)) }} </td>
                                                        <td>
                                                            @if ($tipo->fecha_vencimiento != null && $tipo->fecha_vencimiento != '0000-00-00')
                                                                {{ date("d-m-Y",strtotime($tipo->fecha_vencimiento)) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <i class="fa fa-check" aria-hidden="true" style="color:green; margin-right: 4px;"></i>

                                                            @foreach($tipo->documentos as $doc)

                                                                <a href='{{route("view_document_url", encrypt("recursos_documentos/"."|".$doc->nombre."|".$tipo->id)) }}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

                                                                <a href="{{ route('admin.descargar_recurso', ['recursos_documentos', $doc->nombre]) }}" target="_blank" title="Descargar archivo">
                                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                                </a>
                                                                <button type="button" title="Eliminar archivo" style="margin-right: 6px; border: 0; padding-left: 2px;" data-id="{{ $doc->id_documento }}" onclick="eliminarDocumento(this);">
                                                                    <i class="fa fa-trash-o" aria-hidden="true" style="color:red;"></i>
                                                                </button>
                                                            @endforeach
                                                        </td>

                                                    @else

                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <i class="fa fa-times" aria-hidden="true" style="color:red;">
                                                        </td>

                                                    @endif
                                                        
                                                </tr>
                                            @endforeach
                                        @else
                                            <p>No hay documentos para este cargo</p>
                                        @endif
                                    </tbody>
                                </table>

                                <div style="text-align: center;">
                                    <button class="btn btn-warning" onclick="window.history.back();" title="Volver">Volver</button>
                                    @if(!$req_candidato->bloqueo_carpeta)
                                        <button class="btn btn-primary" id="cargarDocumentoAsis" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
                                    @endif
                                </div>
                            </div>

                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("foto",$errors) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });
        })
    </script>
@stop