@extends("admin.layout.master")
@section('contenedor')
    <?php $cargo = $requerimiento->cargo_especifico()->descripcion ?>
    {{-- HEADER --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Documentos beneficiarios | $datos_candidato->nombres $datos_candidato->primer_apellido $datos_candidato->segundo_apellido", 
                                                                  'more_info' => "<b>Requerimiento</b> $req | <b>Tipo Proceso</b> $requerimiento->tipo_proceso | <b>Cargo</b> $cargo"])

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tabla table-responsive">
                        <table class="table table-hover" id="data-table">
    	                    <thead>
    	                        <tr>
                                    <th>Tipo documento</th>
                                    <th>Descripción</th>
                                    <th>Parentesco</th>
                                    <th> Fecha Carga</th>
                                    <th> Usuario Cargó</th>
                                    <th>Status</th>
                                    <th>Acción</th>
    	                        </tr>
    	                    </thead>
                            <tbody style="text-transform: uppercase;">
                                @foreach($documentosFamiliares as $doc)
                                    <tr id="{{$doc->id}}">
                                        <td>{{ $doc->tipo_documento }}</td>
                                        <td>{{ $doc->descripcion }}</td>
                                        <td>{{ $doc->parentesco }}</td>
                                        <td>{{ $doc->created_at }}</td>
                                        <td>{{ $doc->usuario_cargo }}</td>
                                        <td class="text-center">
                                            <i class="fa fa-check" aria-hidden="true" style="color:green; margin-right: 4px;"></i>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button
                                                    type="button"
                                                    class="btn btn-info btn-sm btn-block dropdown-toggle | tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                    >
                                                    Documento
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu pd-0">
                                                    <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                        <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("documentos_grupo_familiar/"."|".$doc->nombre))}}' target="_blank" title="Ver archivo">
                                                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                            Ver
                                                        </a>

                                                        <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{ route('admin.descargar_recurso', ['documentos_grupo_familiar', $doc->nombre]) }}' target="_blank" title="Descargar archivo">
                                                            <i class="fa fa-download" aria-hidden="true"></i>
                                                            Descargar
                                                        </a>
                                                    </div>
                                                </ul>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>     
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" id="cargarDocumentoBene" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
                        </div>
                    </div>
                </div>
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
            $("#cargarDocumentoBene").on("click", function(){
                $.ajax({
                    url: "{{ route('admin.cargarDocumentoAdminBeneficiario') }}",
                    data: "user_id="+{{ $candidato_id }}+"&req_id="+{{$req}},
                    type: "POST",
                    beforeSend: function(){
                    },
                    success: function(response) {
                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");
                    }
                });
            });
        })
    </script>

@stop