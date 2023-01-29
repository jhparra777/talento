@extends("admin.layout.master")
@section("contenedor")
    <style>
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .help-block.smk-error-msg {
            padding-right: 15px;
        }

        .error-smg {
            color: #dd4b39;
            padding-right: 15px;
            position: absolute;
            right: 0;
            font-size: 12px;
            margin-top: 0;
            margin-bottom: 0;
            display: none;
        }

        .error-mt-3 {
            margin-top: 3.4rem !important;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h3>Asociar cargos al Tipo de Documento <b>{{ $nombre_tipo_doc->descripcion }}</b></h3>
            </div>

            @if(Session::has("mensaje_success"))
                <div class="row col-md-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        
                        {{ Session::get("mensaje_success") }}
                    </div>
                </div>
            @endif

            <div class="row col-md-12">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <b>Debes asociar uno o varios cargos al tipo de documento creado.</b>
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(["id" => "frm_asociar_tipo_doc", "data-smk-icon" => "fa fa-times-circle", "method" => "POST"]) !!}
        {!! Form::hidden("tipo_documento_id", $tipo_documento_id, ["id" => "tipo_documento_id"]) !!}

        <div class="row">
            <div class="col-md-12 mt-1">
                <h4>Asociar el tipo de documento</h4>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <label class="control-label" for="clientes_asociar">Cliente *</label>
                    {!! Form::select("clientes_asociar", $clientes, null, [
                        "class" => "form-control select-cliente",
                        "id" => "clientes_asociar",
                        "required" => "required"
                    ]); !!}
                    <span class="error-smg" id="error-cliente">Debe seleccionar un cliente</span>
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <label class="control-label" for="cargo_especifico_asociar">Cargos cliente *</label>

                    <select
                        class="selectpicker form-control"
                        name="cargo_especifico_asociar[]"
                        id="cargo_especifico_asociar"
                        data-actions-box="true"
                        multiple
                        required="true">
                    </select>
                    <span class="error-smg error-mt-3" id="error-cargo">Debe seleccionar al menos un (1) cargo</span>
                </div>
            </div>

            <div class="col-md-2" style="padding-top: 2.3rem;">
                <button type="button" class="btn btn-success" id="asociar_tipo_doc">Asociar <i class="fa fa-plus"></i></button>
            </div>
        </div>
    {!! Form::close() !!}

    <div class="row">
        <div class="col-md-12 mt-1">
            <h4>Clientes y cargos asociados al tipo de documento <b>{{ $nombre_tipo_doc->descripcion }}</b></h4>
        </div>

        <div class="col-md-12">
            <table class="table table-bordered" id="lista_asociados" style="background-color: white;">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Cargo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cargos_asociados as $asociado)
                        <tr>
                            <td>{{ $asociado->nombre_cliente }}</td>
                            <td>{{ $asociado->nombre_cargo }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-danger borrar-asociado-{{ $asociado->cargo_documento_id }}"
                                    data-cargo_documento_id="{{ $asociado->cargo_documento_id }}"
                                    onclick="eliminarAsociado(this)"
                                >
                                    Borrar <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td></td><td></td><td></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {!! Form::open(["id" => "frm_asociar_tipo_doc_todos", "method" => "POST"]) !!}
        {!! Form::hidden("tipo_documento_id", $tipo_documento_id, ["id" => "tipo_documento_id_all"]) !!}

        <div class="row mt-2 mb-2">
            <div class="col-md-12">
                <h4>Asociar el tipo de documento a todos los cargos</h4>
            </div>

            <div class="form-group">
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" id="asociar_tipo_doc_todos">Asociar a todos</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    <div class="col-md-12 mt-2 text-right">
        <a href="{{ route('admin.tipos_documentos.index') }}" class="btn btn-warning">Volver</a>
    </div>

    <script>
        num_intentos = 0;
        $(function () {
            $('.error-smg').hide();

            $(".selectpicker").selectpicker()

            $('.select-cliente').select2({
                placeholder: 'Selecciona un cliente'
            })

            $('.select-cargo').select2({
                placeholder: 'Selecciona un cargo'
            })

            $("#clientes").change(function(){
                var cliente_id = $(this).val();

                $.ajax({
                    url: "{{ route('admin.get_cargos_especificos_clausulas') }}",
                    type: 'POST',
                    data: {
                        cliente_id : cliente_id
                    },
                    success: function(response){
                        var cargos_especificos = response.cargos_especificos;

                        $('#cargo_especifico').empty();
                        $('#cargo_especifico').append("<option value=''>Seleccionar</option>");

                        $.each(cargos_especificos, function(key, element) {
                            $('#cargo_especifico').append("<option value='"+key+"'>"+element+"</option>");
                        });
                    }
                });
            })

            $("#clientes_asociar").change(function(){
                var cliente_id = $(this).val();
                $('.error-smg').hide();

                $.ajax({
                    url: "{{ route('admin.get_cargos_especificos_clausulas') }}",
                    type: 'POST',
                    data: {
                        cliente_id : cliente_id
                    },
                    success: function(response){
                        var cargos_especificos = response.cargos_especificos;

                        $('#cargo_especifico_asociar').html('');

                        $.each(cargos_especificos, function(key, element) {
                            $('#cargo_especifico_asociar').append("<option value='"+key+"'>"+element+"</option>");
                        });

                        $('.selectpicker').selectpicker('refresh')
                    }
                });
            })

            $('#cargo_especifico_asociar').change(function() {
                $('#error-cargo').hide();
            })
        })

        var table = $('#lista_asociados').DataTable({
            //"searching": false,
            "responsive": true,
            "paginate": true,
            "autoWidth": true,
            "lengthChange": false,
            "language": {
                "url": '{{ url("js/Spain.json") }}'
            }
        });

        //Asociar
        let asociarTipoDoc = document.querySelector('#asociar_tipo_doc')

        asociarTipoDoc.addEventListener('click', () => {
            $('.error-smg').hide();
            if (num_intentos > 0) {
                $('#error-cargo').removeClass('error-mt-3');
            }
            if($('#clientes_asociar').val() != null && $('#clientes_asociar').val() != '' && $('#cargo_especifico_asociar').val() != null && $('#cargo_especifico_asociar').val() != '') {
                let dataForm = $('#frm_asociar_tipo_doc').serialize()

                $.ajax({
                    url: "{{ route('admin.tipos_documentos.asociar_cargos_guardar') }}",
                    type: 'POST',
                    data: dataForm,
                    beforeSend: function(){
                        $.smkAlert({
                            text: 'Asociando información ...',
                            type: 'info'
                        })

                        asociarTipoDoc.disabled = true
                    },
                    success: function(response){
                        if (response.success) {
                            swal({
                                text: "Tipo de documento asociado a los cargos correctamente.",
                                icon: "success"
                            })

                            setTimeout(() => {
                                window.location.reload(true)
                            }, 2000)
                        } else {
                            swal({
                                text: "No se ha asociado el tipo de documento a los cargos, intenta nuevamente. Si persiste el inconveniente contacta a soporte.",
                                icon: "warning"
                            })
                        }

                        asociarTipoDoc.disabled = false
                    },
                    error: function(response){
                        $.smkAlert({
                            text: 'Ha ocurrido un error, intente nuevamente.',
                            type: 'danger'
                        });
                    }
                });
            } else {
                if ($('#clientes_asociar').val() == null || $('#clientes_asociar').val() == '') {
                    $('#error-cliente').show();
                }
                if ($('#cargo_especifico_asociar').val() == null || $('#cargo_especifico_asociar').val() == '') {
                    $('#error-cargo').show();
                    num_intentos++;
                }
            }
        })

        //Todos
        let asociarTipoDocTodos = document.querySelector('#asociar_tipo_doc_todos')

        asociarTipoDocTodos.addEventListener('click', () => {
            swal({
                title: "Confirma",
                text: "El tipo de documento será asociado a todos lo cargos de todos los clientes, ¿asociar?",
                icon: "info",
                buttons: true,
                buttons: ["Cancelar", "Aceptar"]
            })
            .then((confirm) => {
                if (confirm) {
                    let tipo_documento_id = $('#tipo_documento_id_all').val();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.tipos_documentos.asociar_cargos_guardar') }}",
                        data: {
                            tipo_documento_id: tipo_documento_id
                        },
                        beforeSend: function(){
                            $.smkAlert({
                                text: 'Asociando información a todos los cargos ...',
                                type: 'info'
                            })
                            asociarTipoDocTodos.disabled = true
                        },
                        success: function (response) {
                            if (response.success) {
                                swal({
                                    text: "Tipo de documento asociado a todos los cargos correctamente.",
                                    icon: "success"
                                })

                                setTimeout(() => {
                                    window.location.reload(true)
                                }, 2000)
                            } else {
                                swal({
                                    text: "No se ha asociado el tipo de documento a los cargos, intenta nuevamente. Si persiste el inconveniente contacta a soporte.",
                                    icon: "warning"
                                })
                            }
                            asociarTipoDocTodos.disabled = false
                        },
                        error: function (response) {
                            swal({
                                text: "Se ha presentado un error, intenta nuevamente. Si persiste el inconveniente contacta a soporte.",
                                icon: "error"
                            })
                            asociarTipoDocTodos.disabled = false
                        }
                    });
                }
            });
        })

        function eliminarAsociado(obj){
            swal({
                title: "Confirma",
                text: "¿Está seguro que desea eliminar el documento asociado al cargo?",
                icon: "warning",
                buttons: true,
                buttons: ["Cancelar", "Eliminar"]
            })
            .then((confirm) => {
                if (confirm) {
                    let cargo_documento_id = obj.dataset.cargo_documento_id;
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.tipos_documentos.eliminar') }}",
                        data: {
                            cargo_documento_id: cargo_documento_id
                        },
                        beforeSend: function(){
                            $.smkAlert({
                                text: 'Eliminando el documento asociado al cargo...',
                                type: 'info'
                            })
                        },
                        success: function (response) {
                            if (response.response) {
                                swal({
                                    text: "Se ha eliminado correctamente.",
                                    icon: "success"
                                })

                                setTimeout(() => {
                                    window.location.reload(true)
                                }, 2000)
                            } else {
                                swal({
                                    text: "No se ha eliminado el registro, intenta nuevamente. Si persiste el inconveniente contacta a soporte.",
                                    icon: "warning"
                                })
                            }
                        },
                        error: function (response) {
                            swal({
                                text: "Se ha presentado un error, intenta nuevamente. Si persiste el inconveniente contacta a soporte.",
                                icon: "error"
                            })
                        }
                    });
                }
            });
        }
    </script>
@stop