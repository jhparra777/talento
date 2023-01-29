@extends("admin.layout.master")
@section('contenedor')
    <style>
        .m-0{ margin: 0; }
        .m-1{ margin: 1rem; }
        .m-2{ margin: 2rem; }
        .m-3{ margin: 3rem; }
        .m-4{ margin: 4rem; }

        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .m-auto{ margin: auto; }

        .pd-0{ padding: 0; }
        .pd-05{ padding: 0.5rem; }
        .pd-1{ padding: 1rem; }
        .pd-2{ padding: 2rem; }
        .pd-3{ padding: 3rem; }
        .pd-4{ padding: 4rem; }

        .fw-600{ font-weight: 600; }
        .fw-700{ font-weight: 700; }

        .table-result{
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 0.5rem;
            font-family: 'Roboto', sans-serif;
            box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2), 0 4px 8px 0 rgba(0, 0, 0, 0.19);
        }

        .custom-badge {
            color: #333;
            background-color: transparent;
            font-size: 15px;
        }

        .owl-nav{
            text-align: center;
            font-size: 3rem;
        }

        .owl-prev{
            padding: 1rem !important;
        }
    </style>

    <div class="row">
        {{-- Detalle requerimiento --}}
        <div class="col-md-12 mb-2">
            <h3>Detalle prueba EV (Ethical Values)</h3>

            <ul class="list-unstyled mt-2">
                <li>
                    <h4>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Requerimiento - Cliente:</b> {{ $proceso->requerimiento_id }} - {{ $configuracion->requerimiento->nombre_cliente_req() }}
                    </h4>
                </li>

                <li>
                    <h4>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Cargo:</b> {{ $configuracion->requerimiento->cargo_req() }}
                    </h4>
                </li>

                <li>
                    <h4>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Nombre:</b> {{ $candidato->fullname() }}
                    </h4>
                </li>

                <li>
                    <h4>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Número Documento:</b> {{ $candidato->numero_id }}
                    </h4>
                </li>
            </ul>
        </div>

        {{-- Validar para mostrar botón --}}
        @if($respuesta_user != null)
            {{-- Botón informe --}}
            <div class="col-md-12 text-right mb-2">
                <a href="{{ route('admin.pdf_prueba_valores', ['id'=>$respuesta_user->id]) }}" target="_blank" class="btn btn-primary">
                    <b><i class="fa fa-file-pdf-o" aria-hidden="true"></i> GENERAR INFORME</b>
                </a>

                <button class="btn btn-primary" title="Incluir concepto final sobre la prueba." data-toggle="modal" data-target="#modalConcepto">
                    <b>CONCEPTO FINAL</b>
                </button>
            </div>
        @endif
    </div>

    @if($respuesta_user != null)
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-6 text-center">
                            <div class="col-md-12 text-center">
                                <p style="font-size: 2rem;">Ajuste del <br> candidato al perfil</p>

                                <?php
                                    $promedio_porc_ideal = round(($valores_ideal_grafico['amor'] + $valores_ideal_grafico['no_violencia'] + $valores_ideal_grafico['paz'] + $valores_ideal_grafico['rectitud'] + $valores_ideal_grafico['verdad']) / 5);
                                    $promedio_porc = round(($porcentaje_valores_obtenidos['amor'] + $porcentaje_valores_obtenidos['no_violencia'] + $porcentaje_valores_obtenidos['paz'] + $porcentaje_valores_obtenidos['rectitud'] + $porcentaje_valores_obtenidos['verdad']) / 5);

                                    $dif_porc = $promedio_porc - $promedio_porc_ideal;
                                    if ($dif_porc < 0) {
                                        $dif_porc = $dif_porc * -1;
                                    }

                                    $grafica = $respuesta_user->graficaRadial($promedio_porc)
                                ?>
                                <img src="https://quickchart.io/chart?c={{ json_encode($grafica) }}" width="200">
                            </div>

                            <div class="col-md-12 text-center mt-2">
                           <!--     <p style="font-size: 2rem;">Factor de desfase</p>

                                <p style="font-size: 2.5rem; margin-left: 2.5rem;">
                                    <b>{{ $dif_porc }}%</b>
                                    
                                    @if ($dif_porc >= 0)
                                        <img style="margin-left: -1.5rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="80">
                                    @else
                                        <img style="margin-left: -1.5rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="80">
                                    @endif
                                </p> -->
                            </div>
                        </div>

                        {{-- Imagen circular --}}
                        <div class="col-md-6 text-center">
                            @if($promedio_porc < 25)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-01.png" width="400">

                            @elseif($promedio_porc >= 25 && $promedio_porc <= 50)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-00.png" width="400">

                            @elseif($promedio_porc >= 50 && $promedio_porc <= 75)

                                @if($promedio_porc > 50 && $promedio_porc < 55)
                                    <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-02.png" width="400">

                                @elseif($promedio_porc > 55 && $promedio_porc < 58)
                                    <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-03.png" width="400">

                                @elseif($promedio_porc > 58 && $promedio_porc < 64)
                                    <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-04.png" width="400">

                                @elseif($promedio_porc > 64 && $promedio_porc < 68)
                                    <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-05.png" width="400">

                                @elseif($promedio_porc > 68 && $promedio_porc < 72)
                                    <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-06.png" width="400">

                                @elseif($promedio_porc > 72 && $promedio_porc < 75)
                                    <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-07.png" width="400">
                                @endif

                            @elseif($promedio_porc >= 75 && $promedio_porc <= 100)

                                @if($promedio_porc > 75 && $promedio_porc < 78)
                                    <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-08.png" width="400">

                                @elseif($promedio_porc > 78 && $promedio_porc < 80)
                                    <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-09.png" width="400">

                                @elseif($promedio_porc > 80 && $promedio_porc < 84)
                                    <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-10.png" width="400">

                                @elseif($promedio_porc > 84 && $promedio_porc < 94)
                                    <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-11.png" width="400">

                                @elseif($promedio_porc > 94 && $promedio_porc <= 100)
                                    <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-12.png" width="400">
                                @endif
                            @endif
                        </div>

                        {{-- Referencia --}}
                        <div class="col-md-12 text-center">
                            <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-referencia-puntaje.png" width="400" style="margin-bottom: -6rem; margin-top: -5rem;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <button class="btn btn-primary" title="Incluir concepto final sobre la prueba." data-toggle="modal" data-target="#modalConcepto">
                    <b>CONCEPTO FINAL</b>
                </button>
                <a class="btn btn-danger" href="{{ route($ruta_volver) }}"><b>VOLVER</b></a>
            </div>

            @if(!empty($respuesta_user->concepto_final))
                <div class="col-md-12">
                    <div class="panel panel-default mt-2">
                        <div class="panel-body">
                            <h4><i class="fa fa-info-circle" aria-hidden="true"></i> Concepto final</h4>
                            {!! $respuesta_user->concepto_final !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>


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
                        @if($respuesta_user == null)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <b>El candidato no ha respondido la prueba; si agrega un concepto se gestionará el proceso y el candidato no podrá responder esta prueba.</b>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="guardarConcepto">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <h4><i class="fa fa-info-circle"></i> La prueba aún no tiene resultados.</h4>
        <a class="btn btn-danger" href="{{ route($ruta_volver) }}"><b>VOLVER</b></a>
    @endif

    <script>
        //Guardar concepto prueba
        document.querySelector('#guardarConcepto').addEventListener('click', () => {
            $('#guardarConcepto').prop('disabled', 'disabled');
            if ($('#frmConceptoFinal').smkValidate()) {
                $.ajax({
                    type: "POST",
                    data: $("#frmConceptoFinal").serialize(),
                    url: "{{ route('admin.prueba_valores_concepto_final') }}",
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
            } else {
                $('#guardarConcepto').removeAttr('disabled');
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