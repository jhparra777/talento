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

        .float-none {
            float: none !important;
        }

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

    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Gestionar estudio virtual de seguridad"])

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="page-header">
                                <h4 class="tri-fw-600">
                                    INFORMACIÓN GENERAL DEL ESTUDIO VIRTUAL DE SEGURIDAD

                                    <div class="pull-right">
                                        <a href="{{ route('admin.pdf_estudio_virtual_seguridad', ['id_evs'=>$candidato->id_evs]) }}" target="_blank" class="btn btn-primary btn-sm | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
                                            <b><i class="fa fa-file-pdf-o" aria-hidden="true"></i> GENERAR INFORME</b>
                                        </a>

                                        @if(in_array($user_sesion->id, $ids_usuarios_gestionan))
                                            <button class="btn btn-primary btn-sm | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" title="Incluir aspectos relevantes del candidato." id="aspectos_relevantes" data-evs="{{$candidato->id_evs}}">
                                                <b><i class="fa fa-plus" aria-hidden="true"></i> ASPECTOS RELEVANTES</b>
                                            </button>

                                            <button class="btn btn-primary btn-sm | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" title="Incluir concepto final sobre la prueba." data-toggle="modal" data-target="#modalConcepto">
                                                <b>CONCEPTO FINAL</b>
                                            </button>
                                        @endif
                                    </div>
                                </h4>
                            </div>
                        </div>
                        <h5 class="titulo1"><b>Información del candidato</b></h5>

                        <table class="table table-bordered">
                            <tr>
                                <th>Nombres y apellidos</th>
                                <td>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</td>
                                <th>Documento</th>
                                <td>{{ $candidato->tipo_id_desc .' '. $candidato->numero_id}}</td>
                            </tr>
                            <tr>
                                <th>Móvil</th>
                                <td>{{$candidato->telefono_movil}}</td>
                                <th>Email</th>
                                <td>{{$candidato->email}}</td>
                            </tr>
                        </table>
                        <h5 class="titulo1"><b>Información del estudio virtual de seguridad</b></h5>

                        <table class="table table-bordered">
                            <tr>
                                <th>Tipo estudio</th>
                                <td>{{ $candidato->tipo_evs_descripcion }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="page-header">
                                <h4 class="tri-fw-600">
                                    ESTATUS Y GESTIÓN DE LOS PROCESOS DEL ESTUDIO VIRTUAL DE SEGURIDAD
                                </h4>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Proceso</th>
                                    <th>Resultado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($candidato) && $candidato->tipo_evs->analisis_financiero == 'enabled')
                                    <tr>
                                        <td>ANÁLISIS FINANCIERO</td>
                                        <td>
                                            <?php
                                                $apto = 'PENDIENTE';
                                                $proc = $procesos->where('proceso', 'ANALISIS_FINANCIERO_EVS')->first();
                                                if (!is_null($proc)) {
                                                    if (is_null($proc->apto)){
                                                    } else
                                                    if ($proc->apto == 1) {
                                                        $apto = 'APTO';
                                                    } elseif($proc->apto == 0) {
                                                        $apto = 'NO APTO';
                                                    }
                                                }
                                            ?>
                                            {{ $apto }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($candidato) && $candidato->tipo_evs->consulta_antecedentes == 'enabled')
                                    <?php
                                        $apto = 'PENDIENTE';
                                        $proc = $procesos->where('proceso', 'CONSULTA_ANTECEDENTES_EVS')->first();
                                        if (!is_null($proc)) {
                                            if (is_null($proc->apto)){
                                            } else
                                            if ($proc->apto == 1) {
                                                $apto = 'APTO';
                                            } elseif($proc->apto == 0) {
                                                $apto = 'NO APTO';
                                            }
                                        }
                                    ?>
                                    <tr>
                                        @if(in_array($user_sesion->id, $ids_usuarios_gestionan))
                                            @if (isset($tusdatosData) && $tusdatosData->status != 'invalido')
                                                <td>
                                                    CONSULTA DE ANTECEDENTES
                                                </td>
                                            @else
                                                <td>
                                                    <a
                                                        role="button"
                                                        id="enviarTusdatos"
                                                        onclick="enviarTusDatos({{ $candidato->user_id }}, {{ $candidato->requerimiento_id }}, '{{ route('admin.tusdatos_enviar_evs') }}')"
                                                    >
                                                        CONSULTA DE ANTECEDENTES
                                                    </a>
                                                </td>
                                            @endif
                                        @else
                                            <td>CONSULTA DE ANTECEDENTES</td>
                                        @endif
                                        <td>
                                            {{ $apto }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($candidato) && $candidato->tipo_evs->referenciacion_academica == 'enabled')
                                    <?php
                                        $apto = 'PENDIENTE';
                                        $proc = $procesos->where('proceso', 'REFERENCIACION_ACADEMICA_EVS')->first();
                                        if (!is_null($proc)) {
                                            if (is_null($proc->apto)){
                                            } else
                                            if ($proc->apto == 1) {
                                                $apto = 'APTO';
                                            } elseif($proc->apto == 0) {
                                                $apto = 'NO APTO';
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td>
                                            @if(in_array($user_sesion->id, $ids_usuarios_gestionan) && $apto == 'PENDIENTE')
                                                <a target="_blank" href="{{route('admin.gestionar_referencia_estudios', ['ref_id' => $proc->id, 'id_evs' => $candidato->id_evs])}}">
                                                    REFERENCIACIÓN ACADÉMICA
                                                </a>
                                            @else
                                                REFERENCIACIÓN ACADÉMICA 
                                                @if(in_array($user_sesion->id, $ids_usuarios_gestionan) && $apto != 'PENDIENTE')
                                                    <button 
                                                        type="button" 
                                                        class="reabrir_proceso float-none | md-chip-reopen"

                                                        data-id="{{ $proc->id }}" 
                                                        data-proceso="{{ $proc->proceso }}" 
                                                        data-candidato="{{ mb_strtoupper($candidato->nombres .' '.$candidato->primer_apellido.' '.$candidato->segundo_apellido) }}"
                                                        
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        data-container="body"
                                                        title="Reabrir proceso">
                                                        <i class="fas fa-folder-open text-white tri-fs-12"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{ $apto }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($candidato) && $candidato->tipo_evs->referenciacion_laboral == 'enabled')
                                    <?php
                                        $apto = 'PENDIENTE';
                                        $proc = $procesos->where('proceso', 'REFERENCIACION_LABORAL_EVS')->first();
                                        if (!is_null($proc)) {
                                            if (is_null($proc->apto)){
                                            } else
                                            if ($proc->apto == 1) {
                                                $apto = 'APTO';
                                            } elseif($proc->apto == 0) {
                                                $apto = 'NO APTO';
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td>
                                            @if(in_array($user_sesion->id, $ids_usuarios_gestionan) && $apto == 'PENDIENTE')
                                                <a target="_blank" href="{{route('admin.gestionar_referencia', ['ref_id' => $proc->id, 'id_evs' => $candidato->id_evs])}}">
                                                    REFERENCIACIÓN LABORAL
                                                </a>
                                            @else
                                                REFERENCIACIÓN LABORAL 
                                                @if(in_array($user_sesion->id, $ids_usuarios_gestionan) && $apto != 'PENDIENTE
                                                ')
                                                    <button 
                                                        type="button" 
                                                        class="reabrir_proceso float-none | md-chip-reopen"

                                                        data-id="{{ $proc->id }}" 
                                                        data-proceso="{{ $proc->proceso }}" 
                                                        data-candidato="{{ mb_strtoupper($candidato->nombres .' '.$candidato->primer_apellido.' '.$candidato->segundo_apellido) }}"
                                                        
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        data-container="body"
                                                        title="Reabrir proceso">
                                                        <i class="fas fa-folder-open text-white tri-fs-12"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{ $apto }}
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($candidato) && $candidato->tipo_evs->visita_domiciliaria == 'enabled')
                                    <?php
                                        $id_visita = null;
                                        $apto = 'PENDIENTE';
                                        $proc = $procesos->where('proceso', 'VISITA_DOMICILIARIA_EVS')->first();
                                        if (!is_null($proc)) {
                                            $id_visita = $candidato->obtenerIdVisitaDomiciliaria();
                                            if (is_null($proc->apto)){
                                            } elseif ($proc->apto == 1) {
                                                $apto = 'APTO';
                                            } elseif($proc->apto == 0) {
                                                $apto = 'NO APTO';
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td>
                                            @if(in_array($user_sesion->id, $ids_usuarios_gestionan) AND !is_null($id_visita) AND $visita_dom->gestion_admin != '1')
                                                <a target="_blank" href="{{route('admin.gestionar_visita_domiciliaria', ['ref_id' => $id_visita, 'tipo' => 'evs'])}}">
                                                    VISITA DOMICILIARIA
                                                </a>
                                            @else
                                                VISITA DOMICILIARIA
                                            @endif
                                        </td>
                                        <td>
                                            {{ $apto }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <a class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{route('admin.lista_estudio_virtual_seguridad')}}">Volver</a>
            </div>
        </div>
    </div>

    {{-- Modal para crear concepto de la prueba --}}
    <div class="modal fade" id="modalConcepto" tabindex="-1" role="dialog" aria-labelledby="modalConceptoLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content | tri-br-1">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalConceptoLabel">Concepto final</h4>
                </div>
                <div class="modal-body">
                    <form id="frmConceptoFinal" data-smk-icon="glyphicon-remove-sign">
                        <div class="form-group">
                            <label for="apto_evs">Estado *</label>

                            <select id="apto_evs" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" name="apto" required>
                                <option value="">Seleccionar</option>
                                <option value="1" {{ ($candidato->apto == '1' ? 'selected' : '') }}>Favorable</option>
                                <option value="0" {{ ($candidato->apto == '0' ? 'selected' : '') }}>Desfavorable</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="concepto" class="control-label">Ingresa concepto final *</label>

                            <div id="concepto" class="tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required></div>

                            <small><b>Este concepto se adjuntará al informe PDF.</b></small>
                        </div>

                        {!! Form::hidden('id_evs', $candidato->id_evs) !!}
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
                    url: "{{ route('admin.guardar_concepto_evs') }}",
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
                            window.location = "{{ route('admin.lista_estudio_virtual_seguridad') }}";
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

        //Tusdatos.co
        function enviarTusDatos(user_id, req_id, route) {
            $.ajax({
                type: "POST",
                url: route,
                data: {
                    user_id: user_id,
                    req_id: req_id
                },
                success: function(response) {
                    if (response.limite) {
                        $.smkAlert({text: 'Se ha llegado al límite de consultas establecido.', type: 'danger', permanent: true})
                    }else {
                        if (response.success) {
                            //Insertar modal devuelto en el div
                            document.querySelector('#modalAjaxBox').innerHTML = response.view
                            $('#consultarTusDatosModal').modal('show')
                        }else {
                            $.smkAlert({
                                text: 'La/el candidata/o debe tener un <b>tipo de documento</b> y <b>fecha de expedición</b> definido antes de consultar.',
                                type: 'danger'
                            });
                        }
                    }
                }
            })
        }

        function consultarTusDatos(user_id, req_id, route, tipoDoc, fechaExp) {
            if ($('#formTusdatos').smkValidate()) {
                $.ajax({
                    type: "POST",
                    data: {
                        user_id : user_id,
                        req_id : req_id,
                        tipo_documento: tipoDoc,
                        fecha_expedicion: fechaExp
                    },
                    url: "{{ route('admin.tusdatos_launch_evs') }}",
                    beforeSend: function() {
                        $.smkAlert({text: 'Consultando ...', type: 'info'})
                    },
                    success: function(response) {
                        if(response.success == true) {
                            $.smkAlert({text: 'La consulta está en proceso. Puede tardar unos minutos hasta que la consulta termine.', type: 'success', permanent: true})

                            document.getElementById('enviarTusdatos').setAttribute('disabled', 'disabled');

                            setTimeout(() => {
                                $('#consultarTusDatosModal').modal('hide')
                            }, 1000);

                            setTimeout(() => {
                                location.reload()
                            }, 2000);
                        }else {
                            if (response.error) {
                                $.smkAlert({text: response.msg, type: 'danger', permanent: true})

                                setTimeout(() => {
                                    $('#consultarTusDatosModal').modal('hide')
                                }, 1000);
                            }else {
                                $.smkAlert({text: 'Ha ocurrido un error, intenta nuevamente.', type: 'danger'})
                            }
                        }
                    }
                })
            }
        }
        //

        //
        $( function () {
            $('#concepto').trumbowyg({
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

            $("#aspectos_relevantes").on("click", function() {
                var id_evs = $(this).data("evs");

                $.ajax({
                    type: "POST",
                    data: "id_evs=" + id_evs,
                    url: "{{route('admin.aspectos_relevantes_evs_view')}}",
                    success: function(response) {
                        $("#modalTriLarge").find(".modal-content").html(response)
                        $("#modalTriLarge").modal("show")
                    }
                })
            })

            $(document).on("click", ".reabrir_proceso", function() {
                var proceso=$(this).data("proceso");
                var proceso_id=$(this).data("id");
                var candidato=$(this).data("candidato");

                $.ajax({
                    type: "POST",
                    data: {
                        proceso:proceso,
                        proceso_id:proceso_id,
                        candidato:candidato
                    },
                    url: "{{route('admin.reabrir_proceso')}}",
                    success: function(response){

                        $("#modalTriSmall").find(".modal-content").html(response);

                        $("#modalTriSmall").modal("show");

                    }
                })
            });

            $(document).on("click", "#confirmar_reabrir_proceso", function() {
                $.ajax({
                    type: "POST",
                    data: $("#fr_reabrir_proceso").serialize(),
                    url: "{{route('admin.confirmar_reabrir_proceso')}}",
                    success: function(response) {
                        $("#modalTriSmall").modal("hide");

                        mensaje_success("El proceso se ha abierto");
                        setTimeout(function(){location.reload()}, 1500);
                    }
                });
            });
        });
    </script>
@stop