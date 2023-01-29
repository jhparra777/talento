@extends("admin.layout.master")
@section('contenedor')
    <?php $cargo = $requerimiento->cargo_especifico()->descripcion ?>
    {{-- HEADER --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Documentos post contratación | $datos_candidato->nombres $datos_candidato->primer_apellido $datos_candidato->segundo_apellido", 
                                                                  'more_info' => "<b>Requerimiento</b> $req | <b>Tipo Proceso</b> $requerimiento->tipo_proceso | <b>Cargo</b> $cargo"])

    <style type="text/css">
        .val-m {
            vertical-align: middle !important;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tabla table-responsive">
                        <table class="table table-bordered table-hover" id="data-table">
    	                    <thead>
    	                        <tr>
                                    <th>Documento</th>
                                    <th> Usuario Cargó </th>
                                    <th> Fecha Carga </th>
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
                                                <td class="val-m">{{ $tipo->descripcion }}</td>
                                                <td> {{ $doc->usuarioGestiono->name }} </td>
                                                <td> {{ date("d-m-Y",strtotime($doc->fecha_carga)) }} </td>
                                                <td class="text-center">
                                                    <i class="fa fa-check" aria-hidden="true" style="color:green; margin-right: 4px;"></i>
                                                </td>

                                                <td>
                                                    {{-- {{ dd($doc->nombre_real) }} --}}
                                                    <div class="btn-group">
                                                        <button
                                                            type="button"
                                                            class="btn btn-info btn-sm btn-block dropdown-toggle | tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                            data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false"
                                                            >
                                                            <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">Documento {{$contador}}</span>
                                                            {{-- <span class="caret"></span> --}}
                                                        </button>
                                                        <ul class="dropdown-menu pd-0">
                                                            <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                                <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$doc->nombre."|".$tipo->id)) }}' target="_blank">
                                                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                                    Ver
                                                                </a>

                                                                <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href="{{ route('admin.descargar_recurso', ['recursos_documentos_verificados', $doc->nombre]) }}" target="_blank" title="Descargar archivo">
                                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                                    Descargar
                                                                </a>
                                                                
                                                                <button class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" type="button" title="Eliminar archivo" style="margin-right: 6px; border: 0; text-transform: uppercase;" data-id="{{ $doc->id_documento }}" onclick="eliminarDocumento(this);">
                                                                    <i class="fa fa-trash-o" aria-hidden="true" style="color:red;"></i>
                                                                    Eliminar
                                                                </button>
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
                                            <td class="val-m">{{ $tipo->descripcion }}</td>
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
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" id="cargarDocumentoAsis" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
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
                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");
                    }
                });
            });
        })
    </script>
@stop