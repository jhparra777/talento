<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Ranking de ajuste al perfil</h4>
</div>

<div class="modal-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="lista_ranking_candidato">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Porcentaje de ajuste</th>

                    @foreach($preguntas as $pregunta)
                        <th class="text-center">{{ $pregunta->descripcion }}</th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach($resultados_candidatos as $index => $resultado)
                    <tr>
                        <td class="text-center">{{ ++$index }}</td>
                        <td class="text-center">{{ $resultado->nombre_completo }}</td>
                        <td class="text-center">{{ $resultado->total_global }}%</td>

                        @foreach(FuncionesGlobales::resultados_x_pregunta($resultado->req_id, $resultado->cargo_id, $resultado->user_id) as $resultado_pregunta)
                            <td class="text-center">{{ $resultado_pregunta->total_resultado }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>

<script>
    const table_ranking = $('#lista_ranking_candidato').DataTable({
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
</script>