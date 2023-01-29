<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Reserva de horario</h4>
</div>
<div class="modal-body text-left">
	<div class="alert alert-success alert-dismissible" role="alert">
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">×</span>
        </button>

        <b>
        	@if($cita_reservada_candidato->agendada == 1)
        		<i class="fa fa-check"></i> Ya has reservado el horario de tu cita.
        	@else
            	<i class="fa fa-clock-o"></i> Debes definir el horario en que deseas reservar tu cita.
            @endif
        </b>
    </div>

    {{-- Validar si la cita fue cancelada --}}
    @if(!$cita->estado_cita)
    	<div class="alert alert-danger alert-dismissible" role="alert">
	        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
	            <span aria-hidden="true">×</span>
	        </button>

	        <b>
	        	<i class="fa fa-times"></i> Esta cita ha sido cancelada.
	        </b>
	    </div>
    @endif

	<div class="panel panel-default">
	  	<div class="panel-body">
	    	<p>
	    		<i class="fa fa-calendar"></i>
				Tienes una cita programada para el día <b>{{ $fecha_cita }}</b>, la persona encargada atenderá en un horario de <b>{{ $cita->hora_inicio }}</b> a <b>{{ $cita->hora_fin }}</b> con un tiempo de duración por cada cita de <b>{{ $cita->duracion_cita }} mins</b>.
			</p>

			<div class="col-md-12 mt-2" style="max-height: 200px; overflow: auto;">
				<p><i class="fa fa-clock-o"></i> Horarios reservado para esta cita.</p>

				<table class="table table-striped mt-1">
					<thead>
						<th>Cita reservada</th>
					</thead>
					<tbody>
						@if(!empty($cita_reservada_candidato))
							<tr>
								<td>
									De <b>{{ $cita_reservada_candidato->hora_inicio_cita }}</b> a <b>{{ $cita_reservada_candidato->hora_fin_cita }}</b>
									(Tu cita)
								</td>
							</tr>
						@else
							<tr>
								<td>Aún no has reservado tu horario para esta cita.</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
	  	</div>
	</div>

	<form 
		id="frm_reservar_cita" 

		{{-- Validar si el candidato ya agendo la cita o fue cancelada --}}
		@if($cita_reservada_candidato->agendada || !$cita->estado_cita) 
			data-toggle="tooltip" 
			data-placement="top" 
			title="{{ !$cita->estado_cita ? 'Horarios no disponibles' : 'Ya has reservado tu horario para esta cita.' }}" 
		@endif
	>
		<input type="hidden" name="cita_id" id="citaId" value="{{ $cita->id }}">
		<input type="hidden" name="req_id" id="reqId" value="{{ $cita->req_id }}">

		<div @if($cita_reservada_candidato->agendada || !$cita->estado_cita) class="agendada" @endif>
			<div class="row">
				@forelse($intervalos as $index => $hora)
					{{-- Sumar la duración de la cita a la hora --}}
					<?php
						$index;

			    		$hora_siguiente = new DateTime($hora);
			    		$hora_siguiente->modify("+$duracion_cita minutes");
			    		$hora_siguiente->format('H:i');

			    		$hora_siguiente = date('H:i', strtotime("$hora + $duracion_cita minutes"));
			    	?>

					<div class="col-md-4">
						<div class="radio-button-group">
					    	<div class="item">
						        <input 
						        	type="radio" 
						        	name="cita_horas" 
						        	class="radio-button" 
						        	value="1" 
						        	id="citaHoras{{ $index }}" 
						        	data-horainicio="{{ $hora }}" 
						        	data-horafin="{{ $hora_siguiente }}" 

						        	{{-- Validar si el candidato ya agendo la cita o fue cancelada --}}
						        	@if($cita_reservada_candidato->agendada || !$cita->estado_cita)
						        		disabled 
						        	@else
						        		{{-- Validar si el horario ya esta reservado --}}
							        	@if(App\Http\Controllers\AgendamientoCitasController::validarHorarios($cita->id, $cita->req_id, ['hora_inicio_cita' => $hora, 'hora_fin_cita' => $hora_siguiente]))
							        		onchange="enabledButtonSave()" 
							        	@else
							        		disabled 
							        	@endif
						        	@endif
						        >
						        <label 
						        	for="citaHoras{{ $index }}"

						        	{{-- Validar si el horario ya esta reservado --}}
						        	@if(!App\Http\Controllers\AgendamientoCitasController::validarHorarios($cita->id, $cita->req_id, ['hora_inicio_cita' => $hora, 'hora_fin_cita' => $hora_siguiente]))
						        		data-toggle="tooltip" data-placement="top" title="Horario no disponible"
						        	@endif
						        >
						    		{{ $hora }} a {{ $hora_siguiente }}
						    	</label>
						    </div>
						</div>
					</div>
				@empty
			    	<div class="col-md-12">
			    		<p>No hay horarios disponibles</p>
			    	</div>
			    @endforelse
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="buttonReserve" onclick="guardarReserva(this)" disabled>Reservar</button>
</div>

<script>$(function () { $('[data-toggle="tooltip"]').tooltip() })</script>