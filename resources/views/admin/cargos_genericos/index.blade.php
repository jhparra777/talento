@extends("admin.layout.master")
@section("contenedor")
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    Lista de cargos genéricos
                </h3>
                {!! FuncionesGlobales::valida_boton_req("admin.cargos_genericos.nuevo","(+) Nuevo cargo genérico","link","btn-warning btn pull-right") !!}
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table-responsive table table-border" id="data-table">
                    <thead>
                        <tr>
                            <th>
                                Código
                            </th>
                            <th>
                                @if(route("home")=="https://gpc.t3rsc.co")
                                    Nombre del cargo
                                @else
                                    Descripción
                                @endif
                                
                            </th>
                            <th>
                                Estado
                            </th>
                            <th>
                                Categoria
                            </th>
                            <th>
                                Acción
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listas as $lista)
                        <tr id="{{ $lista->id }}">
                            <td>
                                {{ $lista->id }}
                            </td>
                            <td>
                                {{$lista->descripcion}}
                            </td>
                            <td>
                                {{$lista->fullEstado()}}
                            </td>
                            <td>
                                {{$lista->tipoCargo()->descripcion}}
                            </td>
                            <td>
                                {!! FuncionesGlobales::valida_boton_req("admin.cargos_genericos.editar","Editar cargo genérico","boton","btn btn-info cargoGenerico") !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        /**
        * Table
        **/
        var table = $('#data-table').DataTable({
            "responsive": true,
            "paginate": true,
            "lengthChange": true,
            "filter": true,
            "sort": true,
            "info": true,
            "autoWidth": true,
            "language": {
                "url": '{{ url("js/Spain.json") }}'
            }
        });

        /**
        *  Editar cargo generico
        **/
        $("#data-table tbody").on("click", ".cargoGenerico", function () {
            var id = table.row( $(this).parents('tr') ).id();
            $.ajax({
                url: "{{ route('admin.cargos_genericos.editar') }}",
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
        })

       
    });
</script>
@endsection
