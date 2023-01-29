@extends("admin.layout.master")
@section('contenedor')
    <div class="row">
		<div class="col-sm-6">
            <h2>Documentos beneficiarios</h2>

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
                                            <th>Tipo documento</th>
                                            <th>Descripción</th>
                                            <th>Parentesco</th>
                                            <th> Fecha Carga </th>
                                            <th> Usuario Cargó </th>
                                            <th>Status</th>
    	                               </tr>
    	                           </thead>

                                    <tbody style="text-transform: uppercase;">
                                        @if($documentosFamiliares->count() != 0)
                                            @foreach($documentosFamiliares as $doc)
                                                <tr id="{{$doc->id}}">
                                                    <td>{{ $doc->tipo_documento }}</td>
                                                    <td>{{ $doc->descripcion }}</td>
                                                    <td>{{ $doc->parentesco }}</td>
                                                    <td>{{ $doc->created_at }}</td>
                                                    <td>{{ $doc->usuario_cargo }}</td>
                                                    <td>
                                                        <i class="fa fa-check" aria-hidden="true" style="color:green; margin-right: 4px;"></i>
                                                        <a href='{{route("view_document_url", encrypt("documentos_grupo_familiar/"."|".$doc->nombre))}}' target="_blank">
                                                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                        </a>
                                                        <a href='{{ route('admin.descargar_recurso', ['documentos_grupo_familiar', $doc->nombre]) }}' target="_blank" title="Descargar archivo" style="margin-right: 6px;">
                                                            <i class="fa fa-download" aria-hidden="true"></i>
                                                        </a>
                                                        </td>
                                                        
                                                </tr>
                                            @endforeach
                                        @else
                                            <p>No hay documentos para este cargo</p>
                                        @endif
                                    </tbody>
                                </table>

                                <div style="text-align: center;">
                                    <button class="btn btn-warning" onclick="window.history.back();" title="Volver">Volver</button>
                                    <button class="btn btn-primary" id="cargarDocumentoBene" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
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
        $(function(){
            $("#cargarDocumentoBene").on("click", function(){
                $.ajax({
                    url: "{{ route('admin.cargarDocumentoAdminBeneficiario') }}",
                    data: "user_id="+{{ $candidato_id }}+"&req_id="+{{$req}},
                    type: "POST",
                    beforeSend: function(){
                    },
                    success: function(response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });
        })
    </script>

@stop