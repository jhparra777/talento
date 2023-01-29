@extends("cv.layouts.master")

<?php
    $porcentaje = FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
?>

@section("menu_candidato")
    @include("cv.includes.menu_candidato")
@endsection

@section('content')
    <style>
        .mt{ margin-top: 4rem; }

        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .grid-container{ overflow-x: hidden !important; }

        .modal-dialog { width: 800px; margin: 30px auto; }

        /*Radio group*/
        .radio-button-group {
            display: flex;
        }
        .radio-button-group .item {
            width: 100%;
        }
        .radio-button-group .radio-button {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
        }
        .radio-button-group .radio-button + label {
            padding: 16px 10px;
            cursor: pointer;
            border: 1px solid #CCC;
            margin-right: -2px;
            color: #555;
            background-color: #ffffff;
            display: block;
            text-align: center;
        }
        .radio-button-group .radio-button + label:hover {
            background-color: #f1f1f1;
        }
        .radio-button-group .item:first-of-type .radio-button + label{
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
        .radio-button-group .item:last-of-type .radio-button + label {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .radio-button-group .radio-button:checked + label {
            background-color: #5cb85c;
            color: #FFF;
        }
        .radio-button-group .radio-button:disabled + label {
            background-color: gray;
            color: #FFF;
            cursor: not-allowed;
        }

        .agendada{ opacity: 0.4; pointer-events: none; }
    </style>

    <div class="col-right-item-container">
        <div class="container-fluid">
            <div class="col-md-12 all-categorie-list-title bt_heading_3">
                <h1>Mis Citas</h1>

                <div class="blind line_1"></div>
                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                <div class="blind line_2"></div>
            </div>

            <div class="row">
                <h3 class="header-section-form"></h3>

                <div class="col-md-12">
                    <p class="text-primary set-general-font-bold">
                        Aquí podrá encontrar sus citas agendadas.
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h3>Mis citas</h3>
                </div>

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <th class="text-center">Oferta</th>
                                        <th class="text-center">Fecha cita</th>
                                        <th class="text-center">Agendada</th>
                                        <th class="text-center">Asistió</th>
                                        <th class="text-center" colspan="2">Acción</th>
                                    </thead>
                                    <tbody>
                                        @forelse($getCitas as $cita)
                                            <tr>
                                                <td>{{ $cita->cargo }}</td>
                                                <td>{{ $cita->fecha_cita }}</td>
                                                <td>
                                                    @if($cita->agendada == 1)
                                                        De <b>{{ $cita->hora_inicio_cita }}</b> a <b>{{ $cita->hora_fin_cita }}</b>
                                                    @else
                                                        Sin agendar
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(is_null($cita->asistio))
                                                        No realizada
                                                    @elseif($cita->asistio === 1 || $cita->asistio == 1)
                                                        Si
                                                    @elseif($cita->asistio === 0 || $cita->asistio == 0)
                                                        No
                                                    @endif
                                                </td>
                                                <td>
                                                    <button
                                                        class="btn btn-success"
                                                        id="reservarBtn"
                                                        title="Reservar horario de la cita"
                                                        data-cita_id="{{ $cita->cita_id }}"
                                                        data-req_id="{{ $cita->req_id }}"
                                                        onclick="reservarHorario(this)"
                                                    >
                                                        <i class="fa fa-clock-o"></i> Reservar
                                                    </button>
                                                </td>
                                                <td>
                                                    <a
                                                        class="btn btn-primary"
                                                        href="{{ route('home.detalle_oferta', $cita->req_id) }}"
                                                        title="Ver el detalle de la oferta"
                                                        target="_blank"
                                                    >
                                                        <i class="fa fa-eye"></i> Detalle oferta
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">No se encontraron registros de citas.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reservarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"></div>
        </div>
    </div>

    <script>
        const reservarHorario = obj => {
            let cita_id = obj.dataset.cita_id
            let req_id = obj.dataset.req_id

            $.ajax({
                type: "POST",
                data: {
                    cita_id : cita_id,
                    req_id : req_id
                },
                url: "{{ route('cv.reservar_horario_cita_candidato') }}",
                success: function (response) {
                    $("#reservarModal").find(".modal-content").html(response)
                    $("#reservarModal").modal("show")
                }
            })
        }

        const enabledButtonSave = () => {
            document.querySelector('#buttonReserve').removeAttribute('disabled')
        }

        const guardarReserva = obj => {
            const citaId = document.querySelector('#citaId').value
            const reqId = document.querySelector('#reqId').value

            const horarioReservado = document.querySelector('input[name="cita_horas"]:checked')
            const horaInicio = horarioReservado.dataset.horainicio
            const horaFin = horarioReservado.dataset.horafin

            $.ajax({
                type: "POST",
                data: {
                    cita_id: citaId,
                    req_id: reqId,
                    hora_inicio_cita: horaInicio,
                    hora_fin_cita: horaFin
                },
                url: "{{ route('cv.guardar_reservar_cita_candidato') }}",
                beforeSend: function() {
                    obj.disabled = true

                    $.smkAlert({
                        text: 'Guardando información ...',
                        type: 'info'
                    })
                },
                success: function(response) {
                    obj.disabled = false

                    if(response.success) {
                        $.smkAlert({
                            text: 'Cita reservada correctamente.',
                            type: 'success'
                        })

                        setTimeout(() => {
                            location.reload(true)
                        }, 1500)

                        $("#reservarModal").modal("hide");
                    }
                },
                error: function() {
                    obj.disabled = false

                    $.smkAlert({
                        text: 'Ha ocurrido un error, intente nuevamente.',
                        type: 'danger'
                    })
                }
            });
        }
    </script>
@stop