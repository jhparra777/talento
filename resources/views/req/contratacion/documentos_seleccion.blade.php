@extends("req.layout.master")
@section('contenedor')
    <div class="row">
        <div class="col-sm-12" style="text-align: right;">
            <a type="button" class="btn btn-info status" href="{{ route("req.informe_seleccion", ["user_id" => $req_can]) }}" target="_blank">Informe Selección</a>
            
            <a
                id="hoja_vida"
                style=" color:#FF0000;text-decoration:none;color:white;"
                type="button"
                class="btn btn-info"
                href="{{ route("hv_pdf", ["user_id" => $candidato_id]) }}"
                target="_blank"
            >
                HV PDF
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <h2>Documentos selección</h2>
    
            <h4>{{ $datos_candidato->nombres }} {{ $datos_candidato->primer_apellido }} {{ $datos_candidato->segundo_apellido }}</h4>
            <h4><b>#Req:</b> {{ $requerimiento->id }}</h4>
            <h4><b>Cargo:</b> {{ $requerimiento->cargo()->descripcion }}</h4>
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
                                            <th class="">Status</th>
	                                   </tr>
	                               </thead>

                                    <tbody style="text-transform: uppercase;">
                                        {{--@if($tipo_documento->count()!=0)
                                            @foreach($tipo_documento as $tipo)
                                                <tr>
                                                    <td>{{$tipo->descripcion}}</td>
  						                            <td>
                                                        @if($tipo->nombre!="")
  						                                    <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
  						                                    <a href='{{route("view_document_url", encrypt("recursos_documentos/"."|".$tipo->nombre."|".$tipo->id))}}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
  						                                @else
                                                            <i class="fa fa-times" aria-hidden="true" style="color:red;">
  						                                @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <p>No hay documentos para este cargo</p>
                                        @endif--}}

                                        @if($tipo_documento->count() != 0)
                                            @foreach($tipo_documento as $tipo)
                                                <tr>
                                                    <td>{{ $tipo->descripcion }}</td>

                                                    @if( count($tipo->documentos) > 0)
                                                        <td>
                                                            <i class="fa fa-check" aria-hidden="true" style="color:green; margin-right: 4px;"></i>

                                                            @foreach($tipo->documentos as $doc)
                                                                <a href='{{route("view_document_url", encrypt("recursos_documentos/"."|".$doc->nombre."|".$tipo->id))}}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

                                                                <a href='{{ route('admin.descargar_recurso', ['recursos_documentos', $doc->nombre]) }}' target="_blank" title="Descargar archivo" style="margin-right: 6px;">
                                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                                </a>
                                                            @endforeach
                                                        </td>
                                                    @else
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
                                    {{--
                                        <button class="btn btn-primary" id="cargarDocumentoAsis" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
                                    --}}
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
            $("#cargarDocumentoAsis").on("click", function(){
                $.ajax({
                    url: "{{ route('req.cargarDocumentoReqSeleccion') }}",
                    data: "user_id="+{{ $candidato_id }},
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