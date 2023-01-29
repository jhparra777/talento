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

        .table-result{
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 0.5rem;
            font-family: 'Roboto', sans-serif;
            box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2), 0 4px 8px 0 rgba(0, 0, 0, 0.19);
        }

        .bg-blue{ background-color: #2E2D66 !important; color: white; }
        .bg-red{ background-color: #D92428 !important; color: white; }
        .bg-yellow{ background-color: #E4E42A !important; color: white; }
        .bg-green{ background-color: #00A954 !important; color: white; }

        .bg-dark{ background-color: #2c3e50 !important; color: white; }

        .bg-blue-a{ background-color: #0288d1; color: white; }
        .bg-red-a{ background-color: #f44336; color: white; }
        .bg-yellow-a{ background-color: #fdd835; color: white; }
        .bg-green-a{ background-color: #7cb342; color: white; }
    </style>

    <div class="row">
        {{-- Detalle requerimiento --}}
        <div class="col-md-12 mb-2">
            <h3>Detalle prueba BRYG-A</h3>

            <ul class="list-unstyled mt-2">
                <li>
                    <h4>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Requerimiento - Cliente:</b> {{ $candidato_bryg->req_id }} - {{ $requerimiento_detalle->nombre_cliente_req() }}
                    </h4>
                </li>

                <li>
                    <h4>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Cargo:</b> {{ $requerimiento_detalle->cargo_req() }}
                    </h4>
                </li>

                <li>
                    <h4>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Nombre:</b> {{ $candidato_bryg->nombre_completo }}
                    </h4>
                </li>
            </ul>
        </div>

        {{-- Información --}}
        <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                <b>
                    La prueba evaluó 48 posibles combinaciones para determinar el comportamiento predominante en {{ $candidato_bryg->nombres }}, por lo cual a continuación mostramos los resultados.
                </b>
                <br>
                <b>
                    Si no tienes los conocimientos de cada concepto de la prueba, puedes abrir el siguiente enlace al pdf explicativo. <a href="{{ asset('bryg-aumented.pdf') }}" target="_blank">VER PDF</a>
                </b>
            </div>
        </div>

        {{-- Validar para mostrar botón --}}
        @if($candidato_bryg->estado == 1)
            {{-- Botón informe --}}
            <div class="col-md-12 text-right mb-2">
                <a href="{{ route('admin.prueba_bryg_informe', [$candidato_bryg->id]) }}" target="_blank" class="btn btn-primary">
                    <b><i class="fa fa-file-pdf-o" aria-hidden="true"></i> GENERAR INFORME</b>
                </a>

                <button class="btn btn-primary" title="Incluir concepto final sobre la prueba." data-toggle="modal" data-target="#modalConcepto">
                    <b>CONCEPTO FINAL</b>
                </button>
            </div>
        @endif

        {{-- Resultados --}}
        <div class="col-md-12">
            @if(!empty($ajustePerfil))
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <h4>AJUSTE AL PERFIL</h4>

                        @if($ajustePerfil >= 80)
                            <h3 class="text-success"><b>{{ $ajustePerfil }}%</b></h3>
                        @elseif($ajustePerfil >= 60 && $ajustePerfil <= 79)
                            <h3 class="text-warning"><b>{{ $ajustePerfil }}%</b></h3>
                        @elseif($ajustePerfil >= 0 && $ajustePerfil <= 59 )
                            <h3 class="text-danger"><b>{{ $ajustePerfil }}%</b></h3>
                        @endif
                    </div>
                </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-body">
                    {{-- Tabla resultados BRYG --}}
                    <div class="col-md-6 mb-2">
                        <h4 class="mb-2"><i class="fa fa-angle-right" aria-hidden="true"></i> Representación BRYG en tabla</h4>

                        <table class="table-result m-auto">
                            <tr>
                                <th class="bg-blue pd-05">RADICAL</th>
                                <th class="bg-red pd-05">GENUINO</th>
                                <th class="bg-yellow pd-05">GARANTE</th>
                                <th class="bg-green pd-05">BÁSICO</th>
                            </tr>
                            <tr class="text-center fw-700">
                                @if($candidato_bryg->estado == 1)
                                    <td class="pd-05">{{ $candidato_bryg->estilo_radical }}</td>
                                    <td class="pd-05">{{ $candidato_bryg->estilo_genuino }}</td>
                                    <td class="pd-05">{{ $candidato_bryg->estilo_garante }}</td>
                                    <td class="pd-05">{{ $candidato_bryg->estilo_basico }}</td>
                                @else
                                    <td class="pd-05">0</td>
                                    <td class="pd-05">0</td>
                                    <td class="pd-05">0</td>
                                    <td class="pd-05">0</td>
                                @endif
                            </tr>
                        </table>
                    </div>

                    {{-- Tabla resultados AUMENTED --}}
                    <div class="col-md-6 mb-2">
                        <h4 class="mb-2"><i class="fa fa-angle-right" aria-hidden="true"></i> Representación AUMENTED en tabla</h4>

                        <table class="table-result m-auto">
                            <tr>
                                <th class="bg-blue-a pd-05">ANALIZADOR</th>
                                <th class="bg-yellow-a pd-05">PROSPECTIVO</th>
                                <th class="bg-red-a pd-05">DEFENSIVO</th>
                                <th class="bg-green-a pd-05">REACTIVO</th>
                            </tr>
                            <tr class="text-center fw-700">
                                @if($candidato_bryg->estado == 1)
                                    <td class="pd-05">{{ $candidato_bryg->aumented_a }}</td>
                                    <td class="pd-05">{{ $candidato_bryg->aumented_p }}</td>
                                    <td class="pd-05">{{ $candidato_bryg->aumented_d }}</td>
                                    <td class="pd-05">{{ $candidato_bryg->aumented_r }}</td>
                                @else
                                    <td class="pd-05">0</td>
                                    <td class="pd-05">0</td>
                                    <td class="pd-05">0</td>
                                    <td class="pd-05">0</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Validar para mostrar gráficos y javascript --}}
    @if($candidato_bryg->estado == 1)
        {{-- Gráficos de comparación --}}
        @if(!$configuracion->vacio)
            <div class="row">
                <div class="col-md-12">
                    {{-- Collapase radar --}}
                    <div class="panel-group" id="accordionRadarBrygComparativa" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingRadar">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordionRadarBrygComparativa" href="#collapseRadarComparativo" aria-expanded="true" aria-controls="collapseRadarComparativo">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i> Comparativa de resultados con perfil ideal
                                    </a>
                                </h4>
                            </div>

                            <div id="collapseRadarComparativo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingRadar">
                                <div class="panel-body">
                                    {{-- Gráfico --}}
                                    <div class="col-md-6">
                                        <div class="text-center" id="boxPreloaderRadarComparacionBryg">
                                            <img src="{{ asset('img/preloader_ee.gif') }}" width="30">
                                        </div>

                                        <canvas id="grafico_radar_comparacion_canvas" height="220"></canvas>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="text-center" id="boxPreloaderBarraComparacionBryg">
                                            <img src="{{ asset('img/preloader_ee.gif') }}" width="30">
                                        </div>

                                        <canvas id="grafico_barra_comparacion_canvas" height="220"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Gráfico de radar BRYG --}}
        <div class="row">
            {{-- Gráfico de radar BRYG --}}
            <div class="col-md-6" title="El color actual representa el cuadrante más alto">
                {{-- Collapase radar --}}
                <div class="panel-group" id="accordionRadarBryg" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingRadar">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordionRadarBryg" href="#collapseRadar" aria-expanded="true" aria-controls="collapseRadar">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i> Representación BRYG en radar
                                </a>
                            </h4>
                        </div>

                        <div id="collapseRadar" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingRadar">
                            <div class="panel-body">
                                {{-- Gráfico --}}
                                <div class="col-md-12">
                                    <div class="text-center" id="boxPreloaderRadarBryg">
                                        <img src="{{ asset('img/preloader_ee.gif') }}" width="30">
                                    </div>

                                    <canvas id="grafico_radar_canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gráfico de barra BRYG --}}
            <div class="col-md-6" title="Gráfico barra BRYG">
                {{-- Collapase barra --}}
                <div class="panel-group" id="accordionBarraBryg" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingBarra">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordionBarraBryg" href="#collapseBarra" aria-expanded="true" aria-controls="collapseBarra">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i> Representación BRYG en barra
                                </a>
                            </h4>
                        </div>

                        <div id="collapseBarra" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingBarra">
                            <div class="panel-body">
                                {{-- Gráfico --}}
                                <div class="col-md-12">
                                    <div class="text-center" id="boxPreloaderBarraBryg">
                                        <img src="{{ asset('img/preloader_ee.gif') }}" width="30">
                                    </div>

                                    <canvas id="grafico_barra_canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráfico de radar AUMENTED --}}
        <div class="row">
            {{-- Gráfico de radar AUMENTED --}}
            <div class="col-md-6" title="El color actual representa el cuadrante más alto">
                {{-- Collapase radar --}}
                <div class="panel-group" id="accordionRadarAumented" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingRadarAUMENTED">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordionRadarAumented" href="#collapseRadarAUMENTED" aria-expanded="true" aria-controls="collapseRadarAUMENTED">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i> Representación AUMENTED en radar
                                </a>
                            </h4>
                        </div>

                        <div id="collapseRadarAUMENTED" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingRadarAUMENTED">
                            <div class="panel-body">
                                {{-- Gráfico --}}
                                <div class="col-md-12">
                                    <div class="text-center" id="boxPreloaderRadarAumented">
                                        <img src="{{ asset('img/preloader_ee.gif') }}" width="30">
                                    </div>

                                    <canvas id="grafico_radar_aumented_canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gráfico de barra AUMENTED --}}
            <div class="col-md-6" title="Gŕaifco barra AUMENTED">
                {{-- Collapase barra --}}
                <div class="panel-group" id="accordionBarraAumented" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingBarraAUMENTED">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordionBarraAumented" href="#collapseBarraAUMENTED" aria-expanded="true" aria-controls="collapseBarraAUMENTED">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i> Representación AUMENTED en barra
                                </a>
                            </h4>
                        </div>

                        <div id="collapseBarraAUMENTED" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingBarraAUMENTED">
                            <div class="panel-body">
                                {{-- Gráfico --}}
                                <div class="col-md-12">
                                    <div class="text-center" id="boxPreloaderBarraAumented">
                                        <img src="{{ asset('img/preloader_ee.gif') }}" width="30">
                                    </div>

                                    <canvas id="grafico_barra_aumented_canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
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
                        <h4 class="modal-title" id="modalConceptoLabel">Concepto final BRYG</h4>
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
                                {{-- <textarea 
                                    name="concepto_prueba" 
                                    id="conceptoPrueba" 
                                    class="form-control" 
                                    cols="50" 
                                    rows="10"
                                    required
                                ></textarea> --}}

                                <div id="concepto_prueba" required></div>

                                <small><b>Este concepto se adjuntará al informe PDF de la prueba.</b></small>
                            </div>

                            {!! Form::hidden('bryg_id', $candidato_bryg->id) !!}
                            {!! Form::hidden('candidato_bryg', $candidato_bryg->user_id) !!}
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

        <script>
            const resultadosEstilosBRYG = {
                radical: {{ $candidato_bryg->estilo_radical }},
                genuino: {{ $candidato_bryg->estilo_genuino }},
                garante: {{ $candidato_bryg->estilo_garante }},
                basico: {{ $candidato_bryg->estilo_basico }}
            }

            const resultadosEstilosAUMENTED = {
                analizador: {{ $candidato_bryg->aumented_a }},
                prospectivo: {{ $candidato_bryg->aumented_p }},
                defensivo: {{ $candidato_bryg->aumented_d }},
                reactivo: {{ $candidato_bryg->aumented_r }}
            }

            //
            const configuracionBryg = {
                radical: {{ $configuracion->radical }},
                genuino: {{ $configuracion->genuino }},
                garante: {{ $configuracion->garante }},
                basico: {{ $configuracion->basico }}
            }

            //Valores más altos de los cuadrantes
            const bryg_index = "{{ $bryg_index[0] }}"
            const aumented_index = "{{ $aumented_index[0] }}"

            //Simular carga de las gráficas
            setTimeout(() => {
                let preloader = document.querySelector('#boxPreloaderRadarBryg')
                preloader.setAttribute('hidden', true)

                generarRadarBRYG()
            }, 1000)

            setTimeout(() => {
                let preloader = document.querySelector('#boxPreloaderBarraBryg')
                preloader.setAttribute('hidden', true)

                generarBarraBRYG()
            }, 1000)

            setTimeout(() => {
                let preloader = document.querySelector('#boxPreloaderRadarAumented')
                preloader.setAttribute('hidden', true)

                generarRadarAUMENTED()
            }, 1000)

            setTimeout(() => {
                let preloader = document.querySelector('#boxPreloaderBarraAumented')
                preloader.setAttribute('hidden', true)

                generarBarraAUMENTED()
            }, 1000)

            //Comparativos
            setTimeout(() => {
                let preloader = document.querySelector('#boxPreloaderRadarComparacionBryg')
                preloader.setAttribute('hidden', true)

                generarRadarComparacionBRYG()
            }, 1000)

            setTimeout(() => {
                let preloader = document.querySelector('#boxPreloaderBarraComparacionBryg')
                preloader.setAttribute('hidden', true)

                generarBarraComparacionBRYG()
            }, 1000)

            //Guardar concepto prueba
            document.querySelector('#guardarConcepto').addEventListener('click', () => {
                if ($('#frmConceptoFinal').smkValidate()) {
                    $.ajax({
                        type: "POST",
                        data: $("#frmConceptoFinal").serialize(),
                        url: "{{ route('admin.prueba_bryg_concepto_final') }}",
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
                $('#concepto_prueba').trumbowyg('html', `{!! $concepto_prueba->concepto !!}`)
                $('textarea[name="concepto_prueba"]').val(`{!! $concepto_prueba->concepto !!}`)
            })
        </script>

        {{-- Js para la vista actual --}}
        <script src="{{ asset('js/admin/bryg-scripts/manage-bryg-graphics.js') }}"></script>
    @else
        <h4><i class="fa fa-info-circle"></i> La prueba aún no tiene resultados.</h4>
    @endif
@stop