@extends("admin.layout.master")
@section("contenedor")
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="col-md-12">
                <h3>Material de ayuda</h3>
            </div>
            <div class="panel-body">
                <table class="table-responsive table table-border" id="data-table">
                    <thead>
                        <tr>
                            <th>
                                Tema
                            </th>

                            <th>
                                Descripción
                            </th>

                            <th>
                                Enlace
                            </th>

                            <th>
                                Fecha
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ayudas as $ayuda)
                            <tr>
                                <td>{{ $ayuda->tema }}</td>
                                <td>{{ $ayuda->descripcion }}</td>
                                <td class="text-center"><a href="{!! $ayuda->enlace !!}" target="_blank">Ver material <i class="fa fa-eye"></i></a></td>
                                <td>{{ $ayuda->fecha }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        var table = $('#data-table').DataTable({
            "responsive": true,
            "paginate": true,
            "lengthChange": true,
            "deferRender":true,
            "filter": true,
            "sort": true,
            "info": true,
            "lengthMenu": [[10,20, 25, -1], [10,20, 25, "All"]],
            "autoWidth": true,
            "language": {
                "url": '{{ url("js/Spain.json") }}'
            }
        });
    });
</script>
@endsection