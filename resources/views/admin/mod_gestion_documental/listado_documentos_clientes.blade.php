@extends("admin.layout.master")
@section('contenedor')
{{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "$cliente->nombre | $categoria->descripcion"])
    @yield('btn-header')

     {{--<div class="col-md-12 mt-2">
        <div class="panel panel-default">
                
            <div class="panel-body">
                 <h5>{{ $datos_candidato->nombres }} {{ $datos_candidato->primer_apellido }} {{ $datos_candidato->segundo_apellido }}</h5>
                <h5><b>#Req:</b> {{ $req }}</h5>
                <h5><b>#T. Proceso:</b> {{ $requerimiento->tipo_proceso }}</h5>
                <h5><b>Cargo:</b> {{ $requerimiento->cargo_especifico()->descripcion }}</h5>
            </div>
        </div>
    </div>--}}
    
    <div class="row">
        <div class="col-sm-6">
           

           
        </div>
    </div>
    
  
    <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                
                <div class="panel-body">
                            <div class="tabla table-responsive">
                                <table class="table table-hover" id="data-table">
                                   <thead>
                                       <tr>
                                            <th class="">Documento</th>
                                            <th> Usuario Cargó </th>
                                            <th> Fecha última carga </th>
                                            <th class="">Status</th>
                                            <th>Accción</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                      @foreach($tipo_documento as $tipo)
                                       
                                        <tr>
                                          <td>
                                            {{$tipo->descripcion}}
                                          </td>
                                          <td>
                                            {{$tipo->usuario_gestiono}}
                                          </td>
                                          <td>
                                            {{$tipo->fecha_carga}}
                                          </td>
                                          <td>
                                            @if($tipo->nombre!="")
                                              <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                                            @else
                                              <i class="fa fa-times" aria-hidden="true" style="color:red;">
                                            @endif
                                          </td>
                                          <td>
                                            <div class="btn-group-vertical">
                                                    <?php
                                                      $contador=1;
                                                    ?>
                                                  @foreach($tipo->documentos as $doc)
                                                    <?php
                                                        $nombre_boton = App\Jobs\FuncionesGlobales::str_limit(
                                                            $doc->nombre_real
                                                        );
                                                        if (empty($nombre_boton)) {
                                                            $nombre_boton = 'Documento '. $contador;
                                                            $contador++;
                                                        }
                                                    ?>
                                                       <div class="btn-group">
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-info btn-sm btn-block dropdown-toggle | tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                                        data-toggle="dropdown"
                                                                        aria-haspopup="true"
                                                                        aria-expanded="false"

                                                                        {{-- style="border-radius: .3rem .3rem .3rem .3rem;" --}}
                                                                        >
                                                                        <span data-toggle="tooltip" data-container="body"  title="{{ $doc->nombre_real }}">{{$nombre_boton}}</span>
                                                                         {{-- <span class="caret"></span> --}}
                                                                    
                                                                    </button>
                                                                    <ul class="dropdown-menu pd-0">
                                                                        <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                                            <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{asset("documentos_clientes/$cliente->id/$categoria->descripcion/$doc->nombre") }}' target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i>Ver</a>

                                                                            <a  class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" href='{{ route("admin.descargar_recurso", ["documentos_clientes|$cliente->id|$categoria->descripcion", $doc->nombre])}}' target="_blank" title="Descargar archivo">
                                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                                                Descargar
                                                                            </a>
                                                                            @if($current_user->hasAccess("admin.gestion_documental.eliminar_documento"))
                                                                                <button class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" type="button" title="Eliminar archivo" style="margin-right: 6px; border: 0; ;" data-id="{{ $doc->id_documento }}" onclick="eliminarDocumento(this);">
                                                                                    <i class="fa fa-trash-o" aria-hidden="true" style="color:red;"></i>
                                                                                    Eliminar
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </ul>
                                                                </div>

                                                                <?php
                                                                    //$contador++;
                                                                ?>
                                                        
                                                       
                                                  @endforeach
                                            </div>
                                          </td>
                                        </tr>
                                      @endforeach
                                   </tbody>

                                </table>
                                
                                
                            </div>

                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("foto",$errors) !!}
                            </p>
                </div>
                <!--Botones-->
            </div>
    </div>
    <div class="col-md-12 text-center">
        
        
            <button class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" id="cargarDocumentoCliente" type="button"><i class="fa fa-cloud-upload"></i>&nbsp;Cargar documento</button>
      
    </div>

    <div class="col-sm-12 text-right">
        <button class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" onclick="window.history.back();" title="Volver">Volver</button>
    </div>
    
    <script type="text/javascript">
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
    </script>
    <script type="text/javascript">
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
                        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                        data: "id_doc="+boton.dataset.id+"&carpeta=clientes&categoria={{$categoria->id}}&cliente={{$cliente->id}}",
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
            $("#cargarDocumentoCliente").on("click", function(){
                $.ajax({
                    url: "{{ route('admin.gestion_documental.cargarDocumentoCliente') }}",
                    data: {
                        categoria:"{{$categoria->id}}",
                        cliente: "{{$cliente->id}}"
                    },
                    type: 'POST',
                    beforeSend: function(){
                    },
                    success: function(response) {
                        console.log("success");
                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");
                    }
                });
        });
      });
      
    </script>
    
@stop