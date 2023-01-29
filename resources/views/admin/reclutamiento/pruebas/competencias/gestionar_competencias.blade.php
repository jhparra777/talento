@extends("admin.layout.master")
@section("contenedor")
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

        .color{ color: #6F3795; }
        .color-sec{ color: #231F20; }

        .divider-20{ width: 20%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
        .divider-25{ width: 25%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }
        .divider-90{ width: 90%; background-color: #6F3795; color: #6F3795; border: 0; height: 1px; }

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
        <div class="col-md-12">
            <h3>Detalle prueba PS (Personal Skills)</h3>

            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="list-unstyled mt-2">
                        <li>
                            <h4>
                                <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Requerimiento - Cliente:</b> {{ $candidato_competencia->req_id }} - {{ $requerimiento_detalle->nombre_cliente_req() }}
                            </h4>
                        </li>

                        <li>
                            <h4>
                                <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Cargo:</b> {{ $requerimiento_detalle->cargo_req() }}
                            </h4>
                        </li>

                        <li>
                            <h4>
                                <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Nombre:</b> {{ $candidato_competencia->nombre_completo }}
                            </h4>
                        </li>
                    </ul>

                    <div class="col-md-12 text-right">
                        <a class="btn btn-primary" href="{{ route('admin.gestion_requerimiento', $candidato_competencia->req_id) }}" target="_blank">
                            Ir al requerimiento #{{ $candidato_competencia->req_id }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>

                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Validar para mostrar botón --}}
        @if($candidato_competencia->estado == 1)
            {{-- Botón informe --}}
            <div class="col-md-12 text-right mb-2">
                <a href="{{ route('admin.prueba_competencias_informe', [$candidato_competencia->id]) }}" target="_blank" class="btn btn-primary">
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i> GENERAR INFORME
                </a>

                <button class="btn btn-primary" title="Incluir concepto final sobre la prueba." data-toggle="modal" data-target="#modalConcepto">
                    CONCEPTO FINAL
                </button>
            </div>
        @endif
    </div>

    {{-- Validar para mostrar resultados --}}
    @if($candidato_competencia->estado == 1)
        <div class="row">
            {{-- Informe --}}
            @include('admin.reclutamiento.pruebas.competencias.includes._section_datos_informe')

            {{-- Fotos --}}
            <div class="col-md-10 col-md-offset-1 mb-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12 text-center mb-1">
                            <h4>Fotos tomadas durante el proceso de la prueba</h4>
                        </div>

                        <div class="col-md-12">
                            @if (count($competencias_fotos) > 0)
                                <div class="owl-carousel">
                                    @foreach($competencia_fotos as $key => $foto)
                                        <div class="text-center">
                                            <img 
                                                class="mb-1" 
                                                src="{{ asset("recursos_prueba_ps/prueba_ps_$candidato_competencia->user_id"."_"."$candidato_competencia->req_id"."_"."$candidato_competencia->id/$foto->descripcion") }}" 
                                                alt="Foto candidato prueba">

                                            <a class="mt-2" href="{{ asset("recursos_prueba_ps/prueba_ps_$candidato_competencia->user_id"."_"."$candidato_competencia->req_id"."_"."$candidato_competencia->id/$foto->descripcion") }}" target="_blank">Ver completa</a>
                                        </div>

                                        <?php
                                            if ($key === 7) {
                                                break;
                                            }
                                        ?>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-justify">No existe registro fotográfico ya que el candidato no contaba con cámara fotográfica al momento de realizar la prueba.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <button class="btn btn-primary" title="Incluir concepto final sobre la prueba." data-toggle="modal" data-target="#modalConcepto">
                    <b>CONCEPTO FINAL</b>
                </button>
            </div>

            @if(!empty($concepto_prueba))
                <div class="col-md-12">
                    <div class="panel panel-default mt-2">
                        <div class="panel-body">
                            <h4><i class="fa fa-info-circle" aria-hidden="true"></i> Concepto final</h4>
                            {!! $concepto_prueba->concepto !!}
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
                        <h4 class="modal-title" id="modalConceptoLabel">Concepto final Prueba Personal Skills</h4>
                    </div>
                    <div class="modal-body">
                        @if(!empty($concepto_prueba))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <b>La prueba ya tiene un concepto final. Sin embargo tienes la posibilidad de editarlo.</b>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form id="frmConceptoFinal" data-smk-icon="glyphicon-remove-sign">
                            <div class="form-group">
                                <label>Estado *</label>

                                <select class="form-control" name="estadoPrueba" required>
                                    <option value="">Seleccionar</option>
                                    <option value="1">Apto</option>
                                    <option value="2">No apto</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="concepto_prueba" class="control-label">Ingresa concepto final *</label>

                                <div id="concepto_prueba" required></div>

                                <small><b>Este concepto se adjuntará al informe PDF de la prueba.</b></small>
                            </div>

                            {!! Form::hidden('prueba_id', $candidato_competencia->id) !!}
                            {!! Form::hidden('candidato_competencia', $candidato_competencia->user_id) !!}
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="guardarConcepto">
                            @if(!empty($concepto_prueba))
                                Editar
                            @else
                                Guardar
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <link rel="stylesheet" href="{{ asset("js/owlcarousel2-2.3.4/dist/assets/owl.carousel.min.css") }}">
        <link rel="stylesheet" href="{{ asset("js/owlcarousel2-2.3.4/dist/assets/owl.theme.default.min.css") }}">

        <script src="{{ asset("js/owlcarousel2-2.3.4/dist/owl.carousel.min.js") }}"></script>

        <script>
            $(function () {
                $(".owl-carousel").owlCarousel({
                    loop: true,
                    margin: 10,
                    center: true,
                    autoplay: true,
                    nav: true,
                    responsiveClass: true,
                });

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
                $('#concepto_prueba').trumbowyg('html', `{!! $concepto_prueba->concepto !!}`)
                $('textarea[name="concepto_prueba"]').val(`{!! $concepto_prueba->concepto !!}`)
            });

            //Guardar concepto prueba
            document.querySelector('#guardarConcepto').addEventListener('click', () => {
                if ($('#frmConceptoFinal').smkValidate()) {
                    $.ajax({
                        type: "POST",
                        data: $("#frmConceptoFinal").serialize(),
                        url: "{{ route('admin.prueba_competencias_concepto_final') }}",
                        beforeSend: function(response) {
                            $.smkAlert({
                                text: 'Guardando información ...',
                                type: 'info'
                            })
                        },
                        success: function(response) {
                            $.smkAlert({
                                text: 'Concepto guardado correctamente.',
                                type: 'success'
                            })

                            setTimeout(() => {
                                window.location.reload(true)
                            }, 1500)
                        },
                        error: function(response) {
                            $.smkAlert({
                                text: 'Ha ocurrido un error, intente nuevamente.',
                                type: 'danger'
                            })
                        }
                    })
                }
            })
        </script>
    @else
        <h4><i class="fa fa-info-circle"></i> La prueba aún no tiene resultados.</h4>
    @endif
@stop