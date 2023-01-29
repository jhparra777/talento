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

        .smk-error-msg{ display: none; }
        .smk-error-icon{ display: none; }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h3>Asociar cargos a la cláusula {{ $nombre_clausula->descripcion }}</h3>
            </div>

            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <b>Debes asociar uno o varios cargos a la clausula creada.</b>
            </div>
        </div>
    </div>

    {!! Form::open(["id" => "frm_asociar_clausula", "data-smk-icon" => "fa fa-times-circle", "method" => "POST"]) !!}
        {!! Form::hidden("adicional_id", $adicional_id, ["id" => "adicional_id"]) !!}

        <div class="row">
            <div class="col-md-12 mt-1">
                <h4>Asociar a la cláusula</h4>
            </div>

            <div class="form-group">
                <div class="col-md-4">
                    <label class="control-label" for="clientes_asociar">Cliente *</label>
                    {!! Form::select("clientes_asociar", $clientes, null, [
                        "class" => "form-control select-cliente",
                        "id" => "clientes_asociar",
                        "required" => "required"
                    ]); !!}
                </div>

                <div class="col-md-4">
                    <label class="control-label" for="cargo_especifico_asociar">Cargos cliente *</label>

                    <select
                        class="selectpicker form-control"
                        name="cargo_especifico_asociar[]"
                        id="cargo_especifico_asociar"
                        data-actions-box="true"
                        multiple
                        required>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="control-label" for="estado_clausula">Estado cláusula *</label>
                    {!! Form::select("estado_clausula", ["" => "Seleccionar", 1 => "Activa", 0 => "Inactiva"], null, [
                        "class" => "form-control",
                        "id" => "estado_clausula",
                        "required" => "required"
                    ]); !!}
                </div>

                <div class="col-md-2" style="padding-top: 2.3rem;">
                    <button type="button" class="btn btn-success" id="asociar_clausula">Asociar <i class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    <div class="row">
        <div class="col-md-12 mt-1">
            <h4>Clientes y cargos asociados a la cláusula</h4>
        </div>

        <div class="col-md-12">
            <table class="table table-bordered" id="lista_asociados" style="background-color: white;">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Cargo</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($clausulas_asociadas) > 0)
                        <tr><td></td><td></td><td></td><td></td></tr>
                    @endif

                    @foreach($clausulas_asociadas as $asociada)
                        <tr>
                            <td>{{ $asociada->nombre_cliente }}</td>
                            <td>{{ $asociada->nombre_cargo }}</td>
                            <td>
                                @if($asociada->estado_clausula == 1)
                                    ACTIVA
                                @else
                                    INACTIVA
                                @endif
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-danger borrar-asociado-{{ $asociada->cargo_adicional_id }}"
                                    data-cargo_adicional="{{ $asociada->cargo_adicional_id }}"
                                    onclick="borrarAsociado(this)"
                                >
                                    Borrar <i class="fa fa-trash"></i>
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-warning estado-asociado-{{ $asociada->cargo_adicional_id }}"
                                    data-cargo_adicional="{{ $asociada->cargo_adicional_id }}"
                                    data-adicional_estado="{{ $asociada->estado_clausula }}"
                                    onclick="estadoAsociado(this)"
                                >
                                    @if($asociada->estado_clausula == 1)
                                        INACTIVAR
                                    @else
                                        ACTIVAR
                                    @endif
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {!! Form::open(["id" => "frm_asociar_clausula_todos", "method" => "POST"]) !!}
        {!! Form::hidden("adicional_id", $adicional_id, ["id" => "adicional_id"]) !!}
        {!! Form::hidden("estado_clausula", 1, ["id" => "estado_clausula"]) !!}

        <div class="row mt-2 mb-2">
            <div class="col-md-12">
                <h4>Asociar cláusula a todos los cargos de todos los clientes</h4>
            </div>

            <div class="form-group">
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" id="asociar_clausula_todos">Asociar a todos</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    <div class="col-md-12 mt-2 text-right">
        <a href="{{ route('admin.clausulas.lista') }}" class="btn btn-warning">Volver</a>
    </div>

    <script>
        //Yo soy muy makia socio
        $(function () {
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

                $.ajax({
                    url: "{{ route('admin.get_cargos_especificos_clausulas') }}",
                    type: 'POST',
                    data: {
                        cliente_id : cliente_id
                    },
                    success: function(response){
                        var cargos_especificos = response.cargos_especificos;

                        //console.log(cargos_especificos)

                        $('#cargo_especifico_asociar').html('');

                        $.each(cargos_especificos, function(key, element) {
                            $('#cargo_especifico_asociar').append("<option value='"+key+"'>"+element+"</option>");
                        });

                        $('.selectpicker').selectpicker('refresh')
                    }
                });
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
        let asociarClausula = document.querySelector('#asociar_clausula')

        asociarClausula.addEventListener('click', () => {
            if($('#frm_asociar_clausula').smkValidate()){
                let dataForm = $('#frm_asociar_clausula').serialize()

                $.ajax({
                    url: "{{ route('admin.clausulas.asociar') }}",
                    type: 'POST',
                    data: dataForm,
                    beforeSend: function(){
                        $.smkAlert({
                            text: 'Asociando información ...',
                            type: 'info'
                        })

                        asociarClausula.disabled = true
                    },
                    success: function(response){
                        if (response.existe) {
                            $.smkAlert({
                                text: 'El cargo o los cargos ya estan asociados a la cláusula.',
                                type: 'warning',
                                permanent: true
                            })

                            asociarClausula.disabled = false
                        }else{
                            $.smkAlert({
                                text: 'Cláusula asociada correctamente.',
                                type: 'success'
                            });

                            setTimeout(() => {
                                window.location.reload(true)
                            }, 2000)

                            asociarClausula.disabled = false
                        }
                    },
                    error: function(response){
                        $.smkAlert({
                            text: 'Ha ocurrido un error, intente nuevamente.',
                            type: 'danger'
                        });
                    }
                });
            }
        })

        //Todos
        let asociarClausulaTodos = document.querySelector('#asociar_clausula_todos')

        asociarClausulaTodos.addEventListener('click', () => {
            $.smkConfirm({
                text:'La cláusula será asociada a todos lo cargos de todos los clientes, ¿asociar?',
                accept:'Aceptar',
                cancel:'Cancelar'
            },function(res){
                if (res) {
                    let dataForm = $('#frm_asociar_clausula_todos').serialize()

                    $.ajax({
                        url: "{{ route('admin.clausulas.asociar_todos') }}",
                        type: 'POST',
                        data: dataForm,
                        beforeSend: function(){
                            $.smkAlert({
                                text: 'Asociando información a todos los cargos ...',
                                type: 'info'
                            })

                            asociarClausulaTodos.disabled = true
                        },
                        success: function(response){
                            $.smkAlert({
                                text: 'Cláusula asociada correctamente.',
                                type: 'success'
                            });

                            setTimeout(() => {
                                window.location.reload(true)
                            }, 2000)

                            asociarClausulaTodos.disabled = false
                        },
                        error: function(response){
                            $.smkAlert({
                                text: 'Ha ocurrido un error, intente nuevamente.',
                                type: 'danger'
                            });
                        }
                    });
                }
            });
        })

        function borrarAsociado(obj){
            $.smkConfirm({
                text:'¿Borrar cargo asociado?',
                accept:'Aceptar',
                cancel:'Cancelar'
            },function(res){
                if (res) {
                    let cargo_adicional = obj.dataset.cargo_adicional;

                    $.ajax({
                        url: "{{ route('admin.clausulas.asociar.borrar') }}",
                        type: 'POST',
                        data: {cargo_adicional : cargo_adicional},
                        beforeSend: function(){
                            $.smkAlert({
                                text: 'Borrando información ...',
                                type: 'info',
                                time: 2
                            });

                            obj.disabled = true
                        },
                        success: function(response){
                            $.smkAlert({
                                text: 'Cargo borrado correctamente.',
                                type: 'success',
                                time: 2
                            });

                            obj.disabled = false

                            table.row( $(obj).parents('tr') ).remove().draw();
                        },
                        error: function(response){
                            $.smkAlert({
                                text: 'Ha ocurrido un error, intente nuevamente.',
                                type: 'danger'
                            });
                        }
                    });
                }
            });
        }

        function estadoAsociado(obj){
            $.smkConfirm({
                text:'¿Cambiar estado del cargo asociado?',
                accept:'Aceptar',
                cancel:'Cancelar'
            },function(res){
                if (res) {
                    let cargo_adicional = obj.dataset.cargo_adicional;
                    let adicional_estado = obj.dataset.adicional_estado;

                    if (adicional_estado == 1) {
                        var msg_before = 'Inactivando cláusula en cargo ...'
                        var msg_success = 'Cláusula inactivada.'
                    }else{
                        var msg_before = 'Activando cláusula en cargo ...'
                        var msg_success = 'Cláusula activada.'
                    }

                    $.ajax({
                        url: "{{ route('admin.clausulas.asociar.estado') }}",
                        type: 'POST',
                        data: {
                            cargo_adicional : cargo_adicional,
                            adicional_estado : adicional_estado
                        },
                        beforeSend: function(){
                            $.smkAlert({
                                text: msg_before,
                                type: 'info'
                            });

                            obj.disabled = true
                        },
                        success: function(response){
                            $.smkAlert({
                                text: msg_success,
                                type: 'success'
                            });

                            if(response.estado == 1){
                                var estado = 'ACTIVA'
                                obj.textContent = 'INACTIVAR CLÁUSULA'
                            }else{
                                var estado = 'INACTIVA'
                                obj.textContent = 'ACTIVAR CLÁUSULA'
                            }

                            //table.cell($('#cell_state_'+row_number)).data(estado).draw()

                            obj.disabled = false
                        },
                        error: function(response){
                            $.smkAlert({
                                text: 'Ha ocurrido un error, intente nuevamente.',
                                type: 'danger'
                            });
                        }
                    });
                }
            });
        }
    </script>
@stop