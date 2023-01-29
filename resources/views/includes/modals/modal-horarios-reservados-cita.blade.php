<div class="modal fade" id="horariosReservadosModal" tabindex="-1" role="dialog" aria-labelledby="horariosReservadosModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="horariosReservadosModalLabel">Citas para este requerimiento</h4>
            </div>
            <div class="modal-body">
                <div>
                    {{-- Nav tabs --}}
                    <ul class="nav nav-tabs" role="tablist">
                        {{-- Recorrer citas para los tabs --}}
                        @foreach($citas as $index => $cita)
                            <?php $counter = $index + 1; ?>

                            <li 
                                role="presentation" 
                                {{-- Validar si el indice es 0 para mostrar tab como activa --}}
                                @if($index == 0 || $index === 0)
                                    class="active"
                                @endif
                            >
                                <a 
                                    href="#citaHorarios{{ $index }}" 
                                    aria-controls="citaHorarios{{ $index }}" 
                                    role="tab" 
                                    data-toggle="tab"
                                >
                                    Cita #{{ $counter++ }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Tab content --}}
                    <div class="tab-content">
                        {{-- Recorrer citas para mostrar horarios agendados --}}
                        @foreach($citas as $index => $cita)
                            <div 
                                role="tabpanel" 

                                {{-- Validar si el indice es 0 para mostrar panel tab como activo --}}
                                @if($index == 0 || $index === 0)
                                    class="tab-pane fade in active"
                                @else
                                    class="tab-pane fade"
                                @endif 

                                id="citaHorarios{{ $index }}"
                            >
                                <div class="panel panel-default mt-2">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    <i class="fa fa-calendar"></i>
                                                    Cita programada para el día <b>{{ App\Http\Controllers\AgendamientoCitasController::fechaLetras($cita->fecha_cita) }}</b> de <b>{{ $cita->hora_inicio }}</b> a <b>{{ $cita->hora_fin }}</b>, la duración de cada cita es de <b>{{ $cita->duracion_cita }} mins</b>.
                                                </p>

                                                @if(!$cita->estado_cita)
                                                    <p class="text-danger">
                                                        <i class="fa fa-info-circle"></i>
                                                        Esta cita ha sido cancelada.
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="col-md-12">
                                                <h4>Horarios agendados</h4>

                                                <div class="table-responsive mt-2">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <th><i class="fa fa-clock-o" aria-hidden="true"></i> Horario</th>
                                                            <th><i class="fa fa-id-card-o" aria-hidden="true"></i> Nombres</th>
                                                            <th><i class="fa fa-mobile" aria-hidden="true"></i> Celular</th>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($cita->candidatosCita as $candidatoCita)
                                                                <tr>
                                                                    <td>
                                                                        <b>{{ $candidatoCita->hora_inicio_cita }}</b> a <b>{{ $candidatoCita->hora_fin_cita }}</b>
                                                                    </td>
                                                                    <td>{{ $candidatoCita->candidatoInformacion()->fullname() }}</td>
                                                                    <td>{{ $candidatoCita->candidatoInformacion()->telefono_movil }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3">
                                                                        No hay horarios reservados para esta cita.
                                                                    </td>
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
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>