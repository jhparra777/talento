@extends("admin.layout.master")
@section('contenedor')
{{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Listado de documentos  $title_type"])
    @yield('btn-header')

     <div class="col-md-12 mt-2">
        <div class="panel panel-default">
                
            <div class="panel-body">
                 <h5>{{ $datos_candidato->nombres }} {{ $datos_candidato->primer_apellido }} {{ $datos_candidato->segundo_apellido }}</h5>
                <h5><b>#Req:</b> {{ $req }}</h5>
                <h5><b>#T. Proceso:</b> {{ $requerimiento->tipo_proceso }}</h5>
                <h5><b>Cargo:</b> {{ $requerimiento->cargo_especifico()->descripcion }}</h5>
            </div>
        </div>
    </div>
    
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
                                            <th> Fecha Carga </th>
                                            <th class="">Status</th>
                                            <th>Accción</th>
    	                               </tr>
    	                           </thead>

                                    @yield('body-table')
                                </table>
                                
                                
                            </div>

                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("foto",$errors) !!}
                            </p>
                </div>
                @yield('botones')
            </div>
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
    @yield('scripts-documents')
@stop