@extends("admin.layout.master")
@section('contenedor')
    <h3>Gestionar {{ $nombre_prueba }}</h3>
    <h5 class="titulo1">Información Candidato</h5>

    <table class="table table-bordered">
        <tr>
            <th>Cédula</th>
            <td>{{ $candidato->numero_id }}</td>

            <th>Nombres</th>
            <td>{{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }}</td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td>{{ $candidato->telefono_fijo }}</td>

            <th>Móvil</th>
            <td>{{ $candidato->telefono_movil }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $candidato->email }}</td>
        </tr>
    </table>

    <table class="table table-bordered tbl_info">
        <tr>
            <th>Requerimiento</th>
            <th>Usuario Envio</th>
            <th>Fecha Registro</th>
            <th>Proceso</th>
            <th>Estado</th>
            <th>Calificación minima aprobatoria</th>
            <th>Calificación obtenida candidato</th>
            <th>Gestión Req</th>
        </tr>

        <tr>
            <td>{{ $proceso->requerimiento_id }}</td>
            <td>{{ $proceso->usuarioRegistro()->name }}</td>

            <td>{{ $proceso->fecha_inicio }}</td>

            <td>{{ $proceso->proceso }}</td>
            <td>
                <?php
                    switch ($proceso->apto) {
                        case 1:
                            echo "Apto";
                            break;
                        case 2:
                            echo "No Apto";
                            break;
                        case 3:
                            echo "Pendiente";
                            break;
                    }
                ?>
            </td>
            <td style="text-align: right;"><b>{{ $configuracion->minimo_aprobacion }}</b>%</td>
            <td style="text-align: right;">
                @if ($respuesta_user->respuestas_correctas != null && $respuesta_user->total_preguntas != null && $respuesta_user->total_preguntas != 0)
                    <?php
                        $porc_obtenido = $respuesta_user->respuestas_correctas * 100 / $respuesta_user->total_preguntas;
                        if ($porc_obtenido < $configuracion->minimo_aprobacion) {
                            $class = 'text-danger';
                        } else {
                            $class = 'text-success';
                        }
                    ?>
                    <span class="{{ $class }}"><b>{{ $porc_obtenido }}</b>%</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.gestion_requerimiento', $proceso->requerimiento_id) }}" class="btn btn-sm btn-info">
                    <i class="fa fa-arrow-circle-right"></i> Ir gestión Req
                </a>
            </td>
        </tr>
    </table>

    <button type="button" class="btn btn-warning" id="cambiar_estado" style="display: none;">Cambiar Estado</button>

    @if($respuesta_user->respuestas_correctas != null)
        <a class="btn btn-info" target="_blank" href="{{ route('admin.pdf_prueba_excel', ['id'=>$respuesta_user->id])}}">
            Ver Respuestas PDF
        </a>
    @endif

    <a class="btn btn-danger" href="{{ route($ruta_volver) }}">Volver</a>

    @if($respuesta_user != null)
        <button class="btn btn-primary" title="Incluir concepto final sobre la prueba." data-toggle="modal" data-target="#modalConcepto">
            Concepto Final
        </button>
    @endif

    {{-- Modal para crear concepto de la prueba --}}
    <div class="modal fade" id="modalConcepto" tabindex="-1" role="dialog" aria-labelledby="modalConceptoLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalConceptoLabel">Concepto final {{ $nombre_prueba }}</h4>
                </div>
                <div class="modal-body">
                    <form id="frmConceptoFinal" data-smk-icon="glyphicon-remove-sign">
                        <div class="form-group">
                            <label for="estado_prueba">Estado *</label>

                            <select id="estado_prueba" class="form-control" name="estado_prueba" required>
                                <option value="">Seleccionar</option>
                                <option value="1" {{ ($proceso->apto == 1 ? 'selected' : '') }}>Apto</option>
                                <option value="2" {{ ($proceso->apto == 2 ? 'selected' : '') }}>No apto</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="concepto_prueba" class="control-label">Ingresa concepto final *</label>

                            <div id="concepto_prueba" required></div>

                            <small><b>Este concepto se adjuntará al informe PDF de la prueba.</b></small>
                        </div>

                        {!! Form::hidden('respuesta_user_id', $respuesta_user->id) !!}
                        {!! Form::hidden('user_id', $respuesta_user->user_id) !!}
                        {!! Form::hidden('proceso_id', $proceso->id) !!}
                        {!! Form::hidden('tipo', $tipo) !!}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarConcepto">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        //Guardar concepto prueba
        document.querySelector('#guardarConcepto').addEventListener('click', () => {
            $('#guardarConcepto').prop('disabled', 'disabled');
            if ($('#frmConceptoFinal').smkValidate()) {
                $.ajax({
                    type: "POST",
                    data: $("#frmConceptoFinal").serialize(),
                    url: "{{ route('admin.prueba_excel_concepto_final') }}",
                    beforeSend: function(response) {
                        $.smkAlert({
                            text: 'Guardando información ...',
                            type: 'info'
                        })
                    },
                    success: function(response) {
                        $('#modalConcepto').modal('hide');
                        $.smkAlert({
                            text: 'Concepto guardado correctamente.',
                            type: 'success'
                        })

                        setTimeout(() => {
                            window.location = "{{ route($ruta_volver) }}";
                        }, 2500)
                    },
                    error: function(response) {
                        $('#modalConcepto').modal('hide');
                        $.smkAlert({
                            text: 'Ha ocurrido un error, intente nuevamente.',
                            type: 'danger'
                        })
                    }
                })
            }
        })

        //
        $( function () {
            $('#concepto_prueba').trumbowyg({
                lang: 'es',
                btns: [
                    ['undo', 'redo'],
                    ['strong' /*'em', 'del'*/],
                    ['justifyLeft', /*'justifyCenter', 'justifyRight',*/ 'justifyFull'],
                    ['removeformat']
                ],
                removeformatPasted: true,
                tagsToRemove: ['script', 'link']
            })

            //Asignar concepto al textarea
            @if($respuesta_user != null && $respuesta_user->concepto_final != null)
                $('#concepto_prueba').trumbowyg('html', "{!! $respuesta_user->concepto_final !!}")
                $('textarea[name="concepto_prueba"]').val("{!! $respuesta_user->concepto_final !!}")
            @else
                $('#concepto_prueba').trumbowyg('html', '')
                $('textarea[name="concepto_prueba"]').val('')
            @endif

            var ruta = "{{route('admin.gestion_requerimiento', $proceso->requerimiento_id)}}";

            $("#cambiar_estado").on("click", function () {
                $.ajax({
                    type: "POST",
                    data: "ref_id={{$proceso->id}}&modulo=excel_basico",
                    url: "{{ route('admin.cambiar_estado_view') }}",
                    success: function (response) {
                        console.log("af");
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_estado", function () {
                $.ajax({
                    data: $("#fr_cambio_estado").serialize(),
                    url: "{{ route('admin.guardar_cambio_estado') }}",
                    success: function (response) {
                        if (response.success) {
                            mensaje_success("Estado actualizado.. Espere sera redireccionado");
                            // window.location.href = "{{ route('admin.pruebas')}}";
                            setTimeout(function(){
                                location.href = ruta;
                            }, 3000);
                        } else {
                            $("#modal_peq").find(".modal-content").html(response.view);
                        }
                    }
                });
            });
        });
    </script>
@stop