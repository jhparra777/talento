@extends("admin.layout.master")
@section("contenedor")
    <style>
        .text-left{ text-align: left; }
        .text-right{ text-align: right; }

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
        {{-- Detalle requerimiento --}}
        <div class="col-md-12 mb-2">
            <h3>Gestión cita @if(!$cita->estado_cita) <small class="text-danger">Esta cita ha sido cancelada</small> @endif</h3>

            <ul class="list-unstyled mt-2">
                <li>
                    <h4>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Requerimiento - Cliente:</b> {{ $cita->req_id }} - {{ $requerimiento_detalle->nombre_cliente_req() }}
                    </h4>
                </li>

                <li>
                    <h4>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Cargo:</b> {{ $requerimiento_detalle->cargo_req() }}
                    </h4>
                </li>
            </ul>
        </div>

        <div class="col-md-12">
            <h4>Candidatos asociados a la cita</h4>

            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped" id="lista_asociados">
                        <thead>
                            <th>Nombre</th>
                            <th>Fecha cita</th>
                            <th>Agendada</th>
                            <th>Asistió</th>
                            <th>Acción</th>
                        </thead>
                        <tbody>
                            @foreach($lista_cita_candidatos as $lista)
                                <tr>
                                    <td>{{ $lista->nombre_completo }}</td>
                                    <td>{{ $lista->fecha_cita }}</td>
                                    <td>
                                        @if($lista->agendada == 1)
                                            De <b>{{ $lista->hora_inicio_cita }}</b> a <b>{{ $lista->hora_fin_cita }}</b>
                                        @else
                                            Sin agendar
                                        @endif
                                    </td>
                                    <td>
                                        @if(is_null($lista->asistio) || $lista->asistio === NULL)
                                            No realizada
                                        @elseif($lista->asistio === 1 || $lista->asistio == 1)
                                            Si
                                        @elseif($lista->asistio === 0 || $lista->asistio == 0)
                                            No
                                        @endif
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-success"
                                            id="reservarBtn"
                                            title="Cambiar asistencia"

                                            {{-- Validar si la cita fue cancelada --}}
                                            @if(!$cita->estado_cita)
                                                disabled
                                            @else
                                                data-agendamiento_id="{{ $lista->agendamiento_id }}"
                                                onclick="confirmarAsistencia(this)"
                                            @endif
                                        >
                                            Confirmar asistencia
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Validar si la cita fue cancelada --}}
        @if($cita->estado_cita)
            <div class="col-md-6">
                <button 
                    type="button" 
                    class="btn btn-danger" 
                    data-cita_id="{{ $cita->id }}" 
                    onclick="cancelarCita(this)"

                    data-toggle="tooltip" data-placement="top" title="La cita actual será cancelada."
                >
                    <i class="fa fa-ban" aria-hidden="true"></i> Cancelar cita
                </button>
            </div>
        @endif

        <div class="col-md-6 text-right">
            <a href="{{ route('admin.gestionar_citas') }}" class="btn btn-warning">Volver</a>
        </div>
    </div>

    <script>
        const table = $('#lista_asociados').DataTable({
            //"searching": false,
            "responsive": true,
            "paginate": true,
            "autoWidth": true,
            "lengthChange": false,
            "language": {
                "url": '{{ url("js/Spain.json") }}'
            }
        })

        const cancelarCita = obj => {
            obj.disabled = true

            $.smkConfirm({
                text:'¿Seguro/a de cancelar esta cita?',
                accept:'Sí',
                cancel:'No'
            },function(res){
                if(res) {
                    let cita_id = obj.dataset.cita_id

                    $.ajax({
                        url: "{{ route('admin.gestionar_citas_cancelar') }}",
                        type: 'POST',
                        data: {
                            cita_id : cita_id
                        },
                        beforeSend: function(){
                            $.smkAlert({
                                text: 'Cancelando cita ...',
                                type: 'info'
                            })

                            obj.disabled = true
                        },
                        success: function(response){
                            $.smkAlert({
                                text: 'Cita cancelada correctamente...',
                                type: 'success'
                            })

                            /*$.smkAlert({
                                text: 'Será enviado un correo electrónico informando a los candidatos.',
                                type: 'success',
                                permanent: true
                            })*/

                            obj.disabled = false

                            setTimeout(() => {
                                window.location.href = "{{ route('admin.gestionar_citas') }}"
                            }, 1500)
                        },
                        error: function(response){
                            obj.disabled = false

                            $.smkAlert({
                                text: 'Ha ocurrido un error, intente nuevamente.',
                                type: 'danger'
                            });
                        }
                    });
                }else{
                    obj.disabled = false
                }
            });
        }

        const confirmarAsistencia = obj => {
            obj.disabled = true

            let agendamiento_id = obj.dataset.agendamiento_id

            $.smkConfirm({
                text:'¿El candidato asistió a la cita?',
                accept:'Sí',
                cancel:'No'
            },function(res){
                if(res) {
                    $.ajax({
                        url: "{{ route('admin.gestionar_citas_asistio') }}",
                        type: 'POST',
                        data: {
                            agendamiento_id : agendamiento_id
                        },
                        beforeSend: function(){
                            $.smkAlert({
                                text: 'Actualizando información ...',
                                type: 'info'
                            })

                            obj.disabled = true
                        },
                        success: function(response){
                            $.smkAlert({
                                text: 'Información actualizada correctamente...',
                                type: 'success'
                            })

                            obj.disabled = false

                            setTimeout(() => {
                                window.location.reload(true)
                            }, 1500)
                        },
                        error: function(response){
                            obj.disabled = false

                            $.smkAlert({
                                text: 'Ha ocurrido un error, intente nuevamente.',
                                type: 'danger'
                            })
                        }
                    })
                }else {
                    $.ajax({
                        url: "{{ route('admin.gestionar_citas_asistio') }}",
                        type: 'POST',
                        data: {
                            agendamiento_id : agendamiento_id,
                            no_asistio: true
                        },
                        beforeSend: function(){
                            $.smkAlert({
                                text: 'Actualizando información ...',
                                type: 'info'
                            })

                            obj.disabled = true
                        },
                        success: function(response){
                            $.smkAlert({
                                text: 'Información actualizada correctamente...',
                                type: 'success'
                            })

                            obj.disabled = false

                            setTimeout(() => {
                                window.location.reload(true)
                            }, 1500)
                        },
                        error: function(response){
                            obj.disabled = false

                            $.smkAlert({
                                text: 'Ha ocurrido un error, intente nuevamente.',
                                type: 'danger'
                            })
                        }
                    })
                }
            });
        }
    </script>
@stop