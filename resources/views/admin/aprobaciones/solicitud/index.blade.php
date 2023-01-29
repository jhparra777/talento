@extends("admin.layout.master")
@section("contenedor")
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    Listado de solicitudes
                </h3>
                @if ($userSolicitudes->count() >= 1 || route('home') ==  "https://localhost:8000")
                    <button class="btn-warning btn pull-right" id="nuevaSolicitud" type="button">
                        <i class="fa fa-plus">
                        </i>
                        Nueva solicitud
                    </button>
                @endif
            </div>
            <!-- /.box-header -->
    
            <div class="box-body">
                {!! Form::model(Request::all(),["route"=>"admin.solicitud","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Estado:</label>
                        <div class="col-sm-8">
                         {!! Form::select("estado_id",$estados,null,["class"=>"form-control" ]); !!}
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-success" >Buscar</button>
                        </div>

                    </div>

                {!!Form::close()!!}

                <table class="data-table table-responsive table table-border" id="example1">
                    <thead>
                        <tr>
                            <th class="hidden">
                                Estado
                            </th>
                            <th data-priority="1">
                                # solicitud
                            </th>
                            <th>
                                Persona solicita
                            </th>
                            <th>
                                Cargo solicita
                            </th>
                            <th>
                                Cantidad vacantes
                            </th>
                            <th>
                                Sede
                            </th>
                            <th>
                                Valorado
                            </th>
                            <th data-priority="2">
                                Estado
                            </th>
                            @if ($userSolicitudes->count() < 1 || $user->hasAccess("admin.btn-compensar") || $user->hasAccess("admin.btn-aprobar"))
                                <th>
                                    Acción
                                </th>
                            @endif
                            <th>
                                fecha creación
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $item)
                        <tr>
                            <td class="hidden">
                              {{$item->estado}}
                            </td>
                            <td>
                                {{ $item->id }}
                            </td>
                            <td>
                                {{ \App\Models\DatosBasicos::nombreUsuario($item->user_id) }}
                            </td>
                            <td>
                                {{ $item->cargoGenerico()->descripcion }}
                            </td>
                            <td>
                                {{ $item->numero_vacante }}
                            </td>
                            <td>
                                {{ \App\Models\SolicitudSedes::nombreSede($item->ciudad_id) }}
                            </td>
                            <td>
                                $ {{ $item->salario }}
                            </td>
                            <td>
                                <button class="btn btn-small btn-default btn-block detalle" type="button" data-id={{$item->id}}>
                                            <i class="fa fa-eye">
                                            </i>
                                           {{ $item->solicitudEstado()->descripcion }}
                                        </button>
                                
                            </td>
                            @if ($userSolicitudes->count() < 1 || $user->hasAccess("admin.btn-compensar") || $user->hasAccess("admin.btn-aprobar"))
                                <td>
                                    @if ($item->solicitudEstado()->id == 5) {{-- Ya se encuentra Rechazadp --}}
                                        <button class="btn btn-warning btn-block" type="button" disabled="true">
                                            <i class="fa fa-dollar">
                                            </i>p
                                            Rechazado
                                        </button>

                                   @elseif($item->solicitudEstado()->id == 10)
                                    <button class="btn btn-warning btn-block" type="button" disabled="true">
                                            <i class="fa fa-dollar">
                                            </i>
                                            Vencida
                                    </button>

                                    @else
                                        {!! Form::hidden('id', $item->id) !!}
                                        @if ($user->hasAccess("admin.btn-compensar"))
                                            @if ($item->solicitudEstado()->id != 1) {{-- Aun no ha sido Valorado --}}
                                                <button class="btn btn-success btn-block" type="button" disabled="true">
                                                    <i class="fa fa-dollar">
                                                    </i>
                                                    Valorar
                                                </button>
                                            @else
                                            <button class="btn btn-success compensar btn-block" type="button">
                                                <i class="fa fa-dollar">
                                                </i>
                                                Valorar
                                            </button>
                                            @endif
                                        @endif

                                        @if ($user->hasAccess("admin.btn-aprobar"))
                                            @if ($item->solicitudEstado()->id == 9) {{-- Ya se encuentra Liberado --}}
                                                <button class="btn btn-success btn-block" type="button" disabled="true">
                                                        <i class="fa fa-check">
                                                        </i>
                                                        Aprobar
                                                </button>
                                            @else
                                                @if (\App\Models\SolicitudTrazabilidad::validaEStado($item->id, $user) == 0 || route('home') == "http://localhost:8000" )
                                                    <button class="btn btn-success btn-block aprobar" id="aprobar" type="button">
                                                        <i class="fa fa-check">
                                                        </i>
                                                        Aprobar
                                                    </button>
                                                @else
                                                    <button class="btn btn-success btn-block" type="button" disabled="true" >
                                                        <i class="fa fa-check">
                                                        </i>
                                                        Aprobar
                                                    </button>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </td>
                            @endif
                            <td>{{$item->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Funciones script -->
<script>
    $(function(){
        /**
       * Table
       **/
      $('.data-table').DataTable({
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
     
        /**
         * Nueva solicitud
         **/
        $("#nuevaSolicitud").on("click", function(){
            $.ajax({
                url: "{{ route('admin.nuevaSolicitud') }}",
                type: "POST",
                beforeSend: function(){
                    //imagen de carga
                    $.blockUI({
                        message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                        css: {
                            border: "0",
                            background: "transparent"
                        },
                        overlayCSS:  {
                            backgroundColor: "#fff",
                            opacity:         0.6,
                            cursor:          "wait"
                        }
                    });
                },
                success: function(response) {
                    $.unblockUI();
                    console.log("success");
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        /**
         *  Compensar
         **/
        $(".compensar").on("click", function(){
            var objButton = $(this);
            id = objButton.parent().find("input").val();
            $.ajax({
                url: "{{ route('admin.compensarSolicitud') }}",
                type: "POST",
                data: {id: id},
                beforeSend: function(){
                    //imagen de carga
                    $.blockUI({
                        message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                        css: {
                            border: "0",
                            background: "transparent"
                        },
                        overlayCSS:  {
                            backgroundColor: "#fff",
                            opacity:         0.6,
                            cursor:          "wait"
                        }
                    });
                },
                success: function(response) {
                    $.unblockUI();
                    console.log("success");
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        /**
         *  Aprobar
         **/
        $(".aprobar").on("click", function(){
            var objButton = $(this);
            id = objButton.parent().find("input").val();
            $.ajax({
                url: "{{ route('admin.modalAprobarSolicitud') }}",
                type: "POST",
                data: {id: id},
                beforeSend: function(){
                    //imagen de carga
                    $.blockUI({
                        message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                        css: {
                            border: "0",
                            background: "transparent"
                        },
                        overlayCSS:  {
                            backgroundColor: "#fff",
                            opacity:         0.6,
                            cursor:          "wait"
                        }
                    });
                },
                success: function(response) {
                    $.unblockUI();
                    console.log("success");
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        $(".detalle").on("click", function(){
            var objButton = $(this);
            id = $(this).data("id");
            $.ajax({
                url: "{{ route('admin.modalDetalleSolicitud') }}",
                type: "POST",
                data: {id: id},
                beforeSend: function(){
                    //imagen de carga
                    $.blockUI({
                        message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                        css: {
                            border: "0",
                            background: "transparent"
                        },
                        overlayCSS:  {
                            backgroundColor: "#fff",
                            opacity:         0.6,
                            cursor:          "wait"
                        }
                    });
                },
                success: function(response) {
                    $.unblockUI();
                    console.log("success");
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });


        $(document).on("click","#imprimir",function(e){
             e.preventDefault();

            imprSelec();

        });

        function imprSelec() {
          var ficha = document.getElementById('print');
          var ventimp = window.open(' ', 'popimpr');
          ventimp.document.write(ficha.innerHTML);
          ventimp.document.close();
          ventimp.print( );
          ventimp.close();
        }
    });
</script>
@endsection
