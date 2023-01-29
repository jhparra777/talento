<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Candidatos respuestas</h4>
</div>

<div class="modal-body">
    {!! Form::hidden("req_id", $req_id) !!}

    <table class="table table-bordered" id="lista_respuestas_candidato">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Fecha aplicación</th>
                <th class="text-center">Acción</th>
            </tr>
        </thead>

        <tbody>
            @foreach($respuestas_x_candidato as $index => $candidato)
                <tr>
                    <td class="text-center">{{ ++$index }}</td>
                    <td class="text-center">{{ $candidato->nombre_completo }}</td>
                    <td class="text-center">{{ $candidato->fecha_aplicacion }}</td>
                    <td class="text-center">
                        <button
                            type="button"
                            class="btn btn-success"
                            id="ver_resultados_candidato"
                            onclick="ver_resultados_candidato({{ $req_id }}, {{ $candidato->cargo_id }}, {{ $candidato->user_id }})"
                            data-req_id="{{ $req_id }}"
                            data-cargo_id="{{ $candidato->cargo_id }}"
                            data-user_id="{{ $candidato->user_id }}"
                        >Ver resultados <i class="fa fa-eye"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>

<script>
    const table = $('#lista_respuestas_candidato').DataTable({
        "searching": false,
        "responsive": true,
        "paginate": true,
        "autoWidth": true,
        "lengthChange": false,
        "pageLength": 10,
        "language": {
            "url": '{{ url("js/Spain.json") }}'
        }
    });

    function ver_resultados_candidato(req_id, cargo_id, user_id) {
        $.ajax({
            data: {
                req_id: req_id,
                cargo_id: cargo_id,
                user_id: user_id
            },
            url: "{{ route('admin.ver_resultados_x_candidato') }}",
            success: function (response) {
                $("#modal_resultados_x_candidato").find(".modal-content").html(response);
                $("#modal_resultados_x_candidato").modal("show");
            }
        });
    }
</script>
