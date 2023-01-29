<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Citar para cliente</h4>
</div>
<div class="modal-body">
    
    @if (count($cita) > 0)
    
        {!! Form::open(["id"=>"frm_modifica_cita"]) !!}
    
            <h4>Datos de cliente para asignar cita</h4>


            <div class="row">
                
                <input type="hidden" name="id_cita" value="{{ $cita->id }}">

                <input type="hidden" name="requirimiento_id" value="{{ $userData->requerimiento_id }}">

                <input type="hidden" name="telefono_movil" value="{{ $userData->telefono_movil }}">

                <div class="col-md-12 form-group">
                    <label>Fecha Cita</label>
                    <input class="form-control" name="fecha_cita" value="{{ $cita->fecha_cita }}" readonly="readonly">
                </div>

                <div class="col-md-12 form-group">
                    <label>Indicaciones cliente</label>
                    <textarea class="form-control" name="observaciones" readonly="readonly">{{ $cita->observaciones }}</textarea>
                </div>

            </div>

        {!! Form::close() !!}

    @else

        <p>El cliente no ha asignado citas para este candidato.</p>

    @endif

    <div class="clearfix"></div>
</div>
<div class="modal-footer">

    @if (count($cita) > 0)
        <button type="button" class="btn btn-success" id="guardar_cita_to_cliente" >Citar</button>
    @endif
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>

