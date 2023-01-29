@extends("admin.layout.master")
@section('contenedor')

<div class="row">
    <div class="col-sm-6">
        <h2>Documentos post contratación</h2>

        <h4>{{ $datos_candidato->nombres }} {{ $datos_candidato->primer_apellido }} {{ $datos_candidato->segundo_apellido }}</h4>
		<h4><b>#Req:</b> {{ $requerimiento->id }}</h4>
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
                                        <th> Observación </th>
                                        <th> Usuario Cargó </th>
                                        <th> Fecha Carga </th>
									    <th class=""> Status </th>
									</tr>
								</thead>

								<tbody style="text-transform: uppercase;">
									@if($tipo_documento->count() != 0)
                                        @foreach($tipo_documento as $tipo)
                                            <tr>
                                                <td>{{ $tipo->descripcion }}</td>
                                                <td>{{ $tipo->observacion }}</td>

                                                @if( count($tipo->documentos) > 0)
                                                    <td> {{$tipo->usuario_gestiono}} </td>
                                                    <td> {{ date("d-m-Y",strtotime($tipo->fecha_carga)) }} </td>
                                                    <td>
                                                        <i class="fa fa-check" aria-hidden="true" style="color:green; margin-right: 4px;"></i>

                                                        @foreach($tipo->documentos as $doc)
                                                            <a href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$doc->nombre."|".$tipo->id)) }}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

                                                            <a href="{{ route('admin.descargar_recurso', ['recursos_documentos_verificados', $doc->nombre]) }}" target="_blank" title="Descargar archivo">
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
						</div>

						<div style="text-align: center;">
                                <button class="btn btn-warning" onclick="window.history.back();" title="Volver">Volver</button>
                                 <button class="btn btn-primary" id="cargarDocumentoAsis" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
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

        $(function(){
            $("#cargarDocumentoAsis").on("click", function(){
                $.ajax({
                    url: "{{ route('admin.cargarDocumentoAdminPost') }}",
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