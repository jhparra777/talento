@extends("req.layout.master")
@section('contenedor')
    {{-- HEADER --}}
    <?php $cargo = $requerimiento->cargo_especifico()->descripcion ?>
    @include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Documentos selección | $datos_candidato->nombres $datos_candidato->primer_apellido $datos_candidato->segundo_apellido", 
                                                                  'more_info' => "<b>Requerimiento</b> $req | <b>Tipo Proceso</b> $requerimiento->tipo_proceso | <b>Cargo</b> $cargo"])

    <div class="row">
        <div class="col-12 col-sm-6 col-md-6" style="text-align: left;">
            {{-- <a id="autorizacion" 
                style=" color:#FF0000;text-decoration:none;color:white;" 
                type="button" class="btn btn-primary btn-sm  | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
                href="{{ route('admin.aceptacionPoliticaTratamientoDatos', ['user_id' => $candidato_id,'req'=>$req]) }}" 
                target="_blank">
              ACEPTACIÓN DE POLÍTICA TRATAMIENTO DE DATOS
            </a> --}}
        </div>
        <div class="col-12 col-sm-6 col-md-6" style="text-align: right;">
            
            @if ($pruebas != null && $pruebas != '' || count($enlaces_pruebas) > 0)
                <div class="btn-group">
                   <button 
                        type="button" 
                        class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
                        Pruebas
                    </button>
                    <button 
                        type="button" 
                        class="btn btn-default dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
                        data-toggle="dropdown"
                        >
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
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

            <a type="button" class="btn btn-primary btn-sm  | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple status" href="{{ route("req.informe_seleccion", ["user_id" => $req_can]) }}" target="_blank">Informe Selección</a>
            <a id="hoja_vida" style=" color:#FF0000;text-decoration:none;color:white;" type="button" class="btn btn-primary btn-sm  | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{ route("hv_pdf", ["user_id" => $candidato_id]) }}" target="_blank">
                HV PDF
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tabla table-responsive">
                        <table class="table table-bordered table-hover" id="data-table">
                            <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th> Usuario Cargó </th>
                                    <th> Fecha Carga </th>
                                    <th> Fecha de Vencimiento </th>
                                    <th>Status</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody style="text-transform: uppercase;">
                                @foreach($tipo_documento as $tipo)
                                    @if( count($tipo->documentos) > 0)
                                        <?php
                                            $contador=1;
                                        ?>
                                        @foreach($tipo->documentos as $doc)
                                            <tr>
                                                <td>{{ $tipo->descripcion }}</td>
                                                <td> {{$doc->usuarioGestiono->name}} </td>
                                                <td> {{ date("d-m-Y",strtotime($doc->fecha_carga)) }} </td>
                                                <td>
                                                    @if ($doc->fecha_vencimiento != null && $doc->fecha_vencimiento != '0000-00-00')
                                                        {{ date("d-m-Y",strtotime($doc->fecha_vencimiento)) }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <i class="fa fa-check" aria-hidden="true" style="color:green; margin-right: 4px;"></i>
                                                </td>
                                                
                                                <td>
                                                    {{-- {{ dd( $doc->nombre_real ) }} --}}
                                                    <div class="btn-group">
                                                        
                                                        <button
                                                            type="button"
                                                            class="btn btn-info btn-sm btn-block dropdown-toggle | tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                            data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false"
                                                            {{-- data-toggle="dropdown"
                                                            data-placement="top"
                                                            data-container="body"
                                                            title={{ $doc->nombre_real }} --}}
                                                            >
                                                            <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">Documento {{$contador}}</span>
                                                        </button>
                                                    
                                                        <ul class="dropdown-menu pd-0">
                                                            <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                                <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_documentos/"."|".$doc->nombre."|".$tipo->id)) }}' target="_blank">
                                                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                                    Ver
                                                                </a>

                                                                <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href="{{ route('admin.descargar_recurso', ['recursos_documentos', $doc->nombre]) }}" target="_blank" title="Descargar archivo">
                                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                                    Descargar
                                                                </a>
                                                                
                                                                {{-- <button class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" type="button" title="Eliminar archivo" style="margin-right: 6px; border: 0; text-transform: uppercase;" data-id="{{ $doc->id_documento }}" onclick="eliminarDocumento(this);">
                                                                    <i class="fa fa-trash-o" aria-hidden="true" style="color:red;"></i>
                                                                    Eliminar
                                                                </button> --}}
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                               $contador++;
                                            ?>
                                        @endforeach

                                    @else
                                        <tr>
                                            <td>{{ $tipo->descripcion }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center">
                                                <i class="fa fa-times" aria-hidden="true" style="color:red;"></i>
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>     
                    </div>
                </div>
                {{-- <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @if(!$req_candidato->bloqueo_carpeta)
                                <button class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" id="cargarDocumentoAsis" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
                            @endif
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-right">
            <button class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" onclick="window.history.back();" title="Volver">Volver</button>
        </div>
    </div>

    <script>
            $('#data-table').DataTable({
              "responsive": true,
              "columnDefs": [
                  { responsivePriority: 1, targets: 0 },
                  { responsivePriority: 2, targets: -1 }
              ],
              "paginate": true,
              "lengthChange": true,
              "filter": true,
              "sort": true,
              "info": true,
              initComplete: function() {
              //var div = $('#data-table');
              //$("#filtro").prepend("<label for='idDepartamento'>Cliente:</label><select id='idDepartamento' name='idDepartamento' class='form-control' required><option>Seleccione uno...</option><option value='1'>  FRITURAS</option><option value='2'>REFRESCOS</option></select>");
                  this.api().column(0).each(function() {
                      var column = this;
                      console.log(column.data());
                      $('#estado_id').on('change', function() {
                          var val = $(this).val();
                          column.search(val ? '^' + val + '$' : '', true, false)
                              .draw();
                      });
                  });
              },
              "autoWidth": true,
              "order": [[ 1, "desc" ]],
              "language": {
                  "url": '{{ url("js/Spain.json") }}'
              }
        });

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