@extends("admin.layout.master")
@section("contenedor")

    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Documentos", 'more_info' => "<b>Candidata(o)</b> ".$usuario->fullname()." | <b>CC</b> $usuario->numero_id"])

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h4 class="tri-fw-600">
                                Documentos candidato <small>Los campos con asterisco (*) son obligatorios.</small>
                            </h4>
            
                            <ul class="tri-fs-12">
                                <li>
                                    En este módulo puedes cargar el soporte de todos los documentos que acreditan cada uno de los estudios, documento de identidad, experiencias laborales, etc.
                                </li>
                                <li>
                                    Para incluir otro documento, completa los campos y haz clic en el botón <b>Guardar</b>.
                                </li>
                                <li>
                                    El sistema soporta imágenes (JPG, JPEG, PNG) o  PDF.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <form id="fr_documento" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="user_id" value="{{ $usuario->user_id }}">
                        <input type="hidden" name="numero_id" value="{{ $usuario->numero_id }}">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipo_documento_cv">Tipo documento: <span class='text-danger sm-text-label'>*</span></label>

                                <select name="tipo_documento_id" id="tipo_documento_cv" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required>
                                    <option value="">Seleccionar</option>

                                    @foreach ($tipoDocumento as $key => $documento)
                                        <option value="{{ $key }}">{{ $documento }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion_documento_cv">Descripción: <span class='text-danger sm-text-label'>*</span></label>

                                <input type="text" name="descripcion_archivo" id="descripcion_documento_cv" placeholder="Descripción documento" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_vencimiento_cv">Fecha de vencimiento:</label>

                                <input type="text" name="fecha_vencimiento" id="fecha_vencimiento_cv" placeholder="Fecha de vencimiento" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="archivo_documento_cv">Archivo (jpg, png, pdf): <span class='text-danger sm-text-label'>*</span></label>

                                <input type="file" name="archivo_documento[]" id="archivo_documento_cv" accept=".jpg,.jpeg,.png,.pdf" multiple class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required>
                            </div>
                        </div>

                        <div class="col-md-12 text-right" id="sectionGuardar">
                            <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green"  id="guardarDocumento">
                                Guardar
                            </button>
                        </div>

                        <div class="col-md-12 text-right" id="sectionEditar" hidden>
                            <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" id="actualizarDocumento">
                                Actualizar
                            </button>

                            <button type="button" class="btn btn-default | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red"  id="cancelarDocumento">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Descripción</th>
                                <th>Fecha de carga/edición</th>
                                <th>Fecha vencimiento</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($documentos as $documento)
                                <tr id="tr_{{ $documento->id }}">
                                    <td>{{ $documento->tipo_doc }}</td>
                                    <td>{{ $documento->descripcion_archivo }}</td>
                                    <td>{{ date('Y-m-d', strtotime($documento->updated_at)) }}</td>
                                    <td>
                                        @if (empty($documento->fecha_vencimiento) || $documento->fecha_vencimiento == '0000-00-00')
                                            NO INGRESADA
                                        @else
                                            {{ $documento->fecha_vencimiento }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route("view_document_url", encrypt("recursos_documentos/"."|".$documento->nombre_archivo)) }}" target="_blank" class="btn btn-sm btn-default | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple">
                                            Ver <i class="fa fa-eye"></i>
                                        </a>

                                        <button type="button" id="editarDocumento" onclick="editarDocumento(this)" data-documento="{{ $documento->id }}" class="btn btn-sm btn-default | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple">
                                            Editar <i class="fa fa-pen"></i>
                                        </button>

                                        <button type="button" id="eliminarDocumento" onclick="eliminarDocumento(this)" data-documento="{{ $documento->id }}" class="btn btn-sm btn-default | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red">
                                            Eliminar <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No se encontraron documentos</td>
                                </tr>
                            @endforelse
                        </tbody>
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
                                Documentos Grupo Familiar <small>Los campos con asterisco (*) son obligatorios.</small>
                            </h4>
                        </div>
                    </div>

                    <form id="fr_documento_familiar" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipo_documento_gf">Tipo documento: <span class='text-danger sm-text-label'>*</span></label>

                                <select name="tipo_documento_id" id="tipo_documento_gf" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required>
                                    <option value="">Seleccionar</option>

                                    @foreach ($tipoDocumentoFamiliar as $key => $documento)
                                        <option value="{{ $key }}">{{ $documento }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion_documento_gf">Descripción: <span class='text-danger sm-text-label'>*</span></label>

                                <input type="text" name="descripcion" id="descripcion_documento_gf" placeholder="Descripción documento" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="grupo_familiar_id_gf">Familiar: <span class='text-danger sm-text-label'>*</span></label>

                                <select name="grupo_familiar_id" id="grupo_familiar_id_gf" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required>
                                    <option value="">Seleccionar</option>

                                    @foreach ($gruposFamiliares as $familiar)
                                        <option value="{{ $familiar->id }}">{{ $familiar->parentesco }} - {{ $familiar->nombres }} {{ $familiar->primer_apellido }} {{ $familiar->segundo_apellido }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="documento_gf">Archivo (jpg, png, pdf): <span class='text-danger sm-text-label'>*</span></label>

                                <input type="file" name="documento" id="documento_gf" accept=".jpg,.jpeg,.png,.pdf" multiple class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required>
                            </div>
                        </div>

                        <div class="col-md-12 text-right" id="sectionGuardarGf">
                            <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green"  id="guardarDocumentoGf">
                                Guardar
                            </button>
                        </div>

                        <div class="col-md-12 text-right" id="sectionEditarGf" hidden>
                            <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" id="actualizarDocumentoGf">
                                Actualizar
                            </button>

                            <button type="button" class="btn btn-default | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red"  id="cancelarDocumentoGf">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Descripción</th>
                                <th>Parentesco</th>
                                <th>Fecha de carga/edición</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($documentosFamiliares as $documento)
                                <tr id="tr_{{ $documento->id }}">
                                    <td>{{ $documento->tipo_documento }}</td>
                                    <td>{{ $documento->descripcion }}</td>
                                    <td>{{ $documento->parentesco }}</td>
                                    <td>{{ date('Y-m-d', strtotime($documento->updated_at)) }}</td>
                                    <td>
                                        <a href="{{ route("view_document_url", encrypt("documentos_grupo_familiar/"."|".$documento->nombre_archivo)) }}" target="_blank" class="btn btn-sm btn-default | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple">
                                            Ver <i class="fa fa-eye"></i>
                                        </a>

                                        <button type="button" id="editarDocumento" onclick="editarDocumentoGf(this)" data-documento="{{ $documento->id }}" class="btn btn-default | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple">
                                            Editar <i class="fa fa-pen"></i>
                                        </button>

                                        <button type="button" id="eliminarDocumento" onclick="eliminarDocumentoGf(this)" data-documento="{{ $documento->id }}" class="btn btn-sm btn-default | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red">
                                            Eliminar <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No se encontraron documentos</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-12 text-right">
            <a href="{{ route('admin.lista_hv_admin') }}" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" title="Volver">Volver</a>
        </div>
    </div>

    <script>
        $(function () {
            const confDatepicker = {
                altFormat: "yy-mm-dd",
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                buttonImage: "img/gifs/018.gif",
                buttonImageOnly: true,
                autoSize: true,
                dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
                monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                yearRange: "1930:2050"
            };

            $("#fecha_vencimiento_cv").datepicker(confDatepicker)

            $(document).on("change","#tipo_documento_cv", function() {
                $("#descripcion_documento_cv").val($("#tipo_documento_cv").find("option:selected").text())
            })

            $(document).on("change","#tipo_documento_gf", function() {
                $("#descripcion_documento_gf").val($("#tipo_documento_gf").find("option:selected").text())
            })
        })

        $(document).on("click", "#guardarDocumento", function () {
            if($('#fr_documento').smkValidate()) {
                $(this).prop("disabled", true)

                let formData = new FormData(document.getElementById("fr_documento"))

                $.ajax({
                    type: "POST",
                    data: formData,
                    url: "{{ route('guardar_documento_candidato') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: () => {
                        $.smkAlert({text: 'Guardando documento...', type: 'info'})
                    },
                    success: (response) => {
                        if (response.success) {
                            document.querySelector('#tipo_documento_cv').value = ''
                            document.querySelector('#descripcion_documento_cv').value = ''
                            document.querySelector('#fecha_vencimiento_cv').value = ''
                            document.querySelector('#archivo_documento_cv').value = ''

                            $.smkAlert({text: response.mensaje, type: 'success'})

                            setTimeout(() => {
                                window.location.reload()
                            }, 1500);
                        }else {
                            $.smkAlert({text: response.mensaje, type: 'danger'})
                        }
                    },
                    error: () => {
                        $.smkAlert({text: 'Ha ocurrido un error.', type: 'danger'})
                    }
                })
            }
        })

        const editarDocumento = (event) => {
            let documentoId = event.dataset.documento

            $.ajax({
                type: "POST",
                data: {
                    id: documentoId
                },
                url: "{{ route('editar_documento_candidato') }}",
                success: (response) => {
                    document.querySelector('#tipo_documento_cv').value = response.documento.tipo_documento_id
                    document.querySelector('#descripcion_documento_cv').value = response.documento.descripcion_archivo
                    document.querySelector('#fecha_vencimiento_cv').value = response.documento.fecha_vencimiento

                    document.querySelector('#archivo_documento_cv').removeAttribute('required') // Quitar atributo required de los archivos

                    document.querySelector('#sectionEditar').removeAttribute('hidden') // Mostrar botones de editar
                    document.querySelector('#sectionGuardar').setAttribute('hidden', true) // Ocultar el de guardar

                    document.querySelector('#actualizarDocumento').dataset.documento = documentoId //
                },
                error: () => {
                    $.smkAlert({text: 'Ha ocurrido un error.', type: 'success'})
                }
            })
        }

        $(document).on("click", "#actualizarDocumento", function (event) {
            let form = document.querySelector("#fr_documento")
            let formData = new FormData(form)
            let documentoId = event.target.dataset.documento

            formData.append('id', documentoId)

            $.ajax({
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                url: "{{ route('actualizar_documento_candidato') }}",
                success: (response) => {
                    if (response.success) {
                        document.querySelector('#tipo_documento_cv').value = ''
                        document.querySelector('#descripcion_documento_cv').value = ''
                        document.querySelector('#fecha_vencimiento_cv').value = ''
                        document.querySelector('#archivo_documento_cv').value = ''

                        document.querySelector('#archivo_documento_cv').setAttribute('required', true)

                        document.querySelector('#sectionEditar').setAttribute('hidden', true) // Ocultar botones de edición
                        document.querySelector('#sectionGuardar').removeAttribute('hidden') // Mostrar el botón base

                        delete event.target.dataset.documento // Quitar dataset

                        $.smkAlert({text: 'Documento actualizado.', type: 'success'})

                        setTimeout(() => {
                            window.location.reload()
                        }, 1500);
                    }else {
                        $.smkAlert({text: response.mensaje, type: 'danger'})
                    }
                },
                error: () => {
                    $.smkAlert({text: 'Ha ocurrido un error.', type: 'success'})
                }
            })
        })

        $(document).on("click", "#cancelarDocumento", function (event) {
            document.querySelector('#tipo_documento_cv').value = ''
            document.querySelector('#descripcion_documento_cv').value = ''
            document.querySelector('#fecha_vencimiento_cv').value = ''
            document.querySelector('#archivo_documento_cv').value = ''

            document.querySelector('#archivo_documento_cv').setAttribute('required', true)

            document.querySelector('#sectionEditar').setAttribute('hidden', true) // Ocultar botones de edición
            document.querySelector('#sectionGuardar').removeAttribute('hidden') // Mostrar el botón base

            delete document.querySelector('#actualizarDocumento').dataset.documento// Quitar dataset
        })

        const eliminarDocumento = (event) => {
            let documentoId = event.dataset.documento

            $.smkConfirm({
                text:'¿Eliminar documento?',
                accept:'Aceptar',
                cancel:'Cancelar'
            }, function (res) {
                if (res) {
                    $.ajax({
                        type: "POST",
                        data: {
                            id: documentoId
                        },
                        url: "{{ route('eliminar_documento') }}",
                        success: (response) => {
                            $.smkAlert({text: 'Documento eliminado.', type: 'success'})

                            setTimeout(() => {
                                window.location.reload()
                            }, 1500);
                        },
                        error: () => {
                            $.smkAlert({text: 'Ha ocurrido un error.', type: 'success'})
                        }
                    })
                }
            })
        }

        // Grupo familiar
        $(document).on("click", "#guardarDocumentoGf", function () {
            if($('#fr_documento_familiar').smkValidate()) {
                $(this).prop("disabled", true)

                let formData = new FormData(document.getElementById("fr_documento_familiar"))

                $.ajax({
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    url: "{{ route('guardar_documento_familiar') }}",
                    beforeSend: () => {
                        $.smkAlert({text: 'Guardando documento familiar...', type: 'info'})
                    },
                    success: (response) => {
                        if (response.success) {
                            document.querySelector('#tipo_documento_gf').value = ''
                            document.querySelector('#descripcion_documento_gf').value = ''
                            document.querySelector('#documento_gf').value = ''
                            document.querySelector('#grupo_familiar_id_gf').value = ''

                            $.smkAlert({text: response.mensaje, type: 'success'})

                            setTimeout(() => {
                                window.location.reload()
                            }, 1500);
                        }else {
                            $.smkAlert({text: response.mensaje, type: 'danger'})
                        }
                    },
                    error: () => {
                        $.smkAlert({text: 'Ha ocurrido un error.', type: 'danger'})
                    }
                })
            }
        })

        const editarDocumentoGf = (event) => {
            let documentoId = event.dataset.documento

            $.ajax({
                type: "POST",
                data: {
                    id: documentoId
                },
                url: "{{ route('editar_documento_familiar') }}",
                success: (response) => {
                    document.querySelector('#tipo_documento_gf').value = response.documento.tipo_documento_id
                    document.querySelector('#descripcion_documento_gf').value = response.documento.descripcion
                    document.querySelector('#grupo_familiar_id_gf').value = response.documento.grupo_familiar_id

                    document.querySelector('#documento_gf').removeAttribute('required') // Quitar atributo required de los archivos

                    document.querySelector('#sectionEditarGf').removeAttribute('hidden') // Mostrar botones de editar
                    document.querySelector('#sectionGuardarGf').setAttribute('hidden', true) // Ocultar el de guardar

                    document.querySelector('#actualizarDocumentoGf').dataset.documento = documentoId //
                },
                error: () => {
                    $.smkAlert({text: 'Ha ocurrido un error.', type: 'success'})
                }
            })
        }

        $(document).on("click", "#actualizarDocumentoGf", function (event) {
            if($('#fr_documento_familiar').smkValidate()) {
                $(this).prop("disabled", true)

                let form = document.querySelector("#fr_documento_familiar")
                let formData = new FormData(form)
                let documentoId = event.target.dataset.documento

                formData.append('id', documentoId)

                $.ajax({
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    url: "{{ route('actualizar_documento_familiar') }}",
                    success: (response) => {
                        if (response.success) {
                            document.querySelector('#tipo_documento_gf').value = ''
                            document.querySelector('#descripcion_documento_gf').value = ''
                            document.querySelector('#grupo_familiar_id_gf').value = ''
                            document.querySelector('#documento_gf').value = ''

                            document.querySelector('#documento_gf').setAttribute('required', true)

                            document.querySelector('#sectionEditarGf').setAttribute('hidden', true) // Ocultar botones de edición
                            document.querySelector('#sectionGuardarGf').removeAttribute('hidden') // Mostrar el botón base

                            delete event.target.dataset.documento // Quitar dataset

                            $.smkAlert({text: 'Documento actualizado.', type: 'success'})

                            setTimeout(() => {
                                window.location.reload()
                            }, 1500);
                        }else {
                            $.smkAlert({text: response.mensaje, type: 'danger'})
                        }
                    },
                    error: () => {
                        $.smkAlert({text: 'Ha ocurrido un error.', type: 'danger'})
                    }
                })
            }
        })

        $(document).on("click", "#cancelarDocumentoGf", function (event) {
            document.querySelector('#tipo_documento_gf').value = ''
            document.querySelector('#descripcion_documento_gf').value = ''
            document.querySelector('#grupo_familiar_id_gf').value = ''
            document.querySelector('#documento_gf').value = ''

            document.querySelector('#documento_gf').setAttribute('required', true)

            document.querySelector('#sectionEditarGf').setAttribute('hidden', true) // Ocultar botones de edición
            document.querySelector('#sectionGuardarGf').removeAttribute('hidden') // Mostrar el botón base

            delete document.querySelector('#actualizarDocumentoGf').dataset.documento// Quitar dataset
        })

        const eliminarDocumentoGf = (event) => {
            let documentoId = event.dataset.documento

            $.smkConfirm({
                text:'¿Eliminar documento familiar?',
                accept:'Aceptar',
                cancel:'Cancelar'
            }, function (res) {
                if (res) {
                    $.ajax({
                        type: "POST",
                        data: {
                            id: documentoId
                        },
                        url: "{{ route('eliminar_documento_familiar') }}",
                        success: (response) => {
                            $.smkAlert({text: 'Documento familiar eliminado.', type: 'success'})

                            setTimeout(() => {
                                window.location.reload()
                            }, 1500);
                        },
                        error: () => {
                            $.smkAlert({text: 'Ha ocurrido un error.', type: 'success'})
                        }
                    })
                }
            })
        }
    </script>
@stop