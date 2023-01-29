<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Realizar pruebas a : <strong>{{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }}</strong> </h4>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(["id" => "frmPruebasTecnicas"]) !!}
                {!! Form::hidden("candidato_req", $candidato->req_candidato) !!}

                <p>Selecciona la(s) prueba(s) a realizar:</p>

                <ul class="list-unstyled">
                    @if ($sitioModulo->prueba_digitacion == 'enabled')
                        <li>
                            <input type="checkbox" name="pruebas_tecnicas[]" value="1" id="pruebaDigitacion">
                            <label for="pruebaDigitacion">PRUEBA DIGITACIÓN</label>
                        </li>
                    @endif
                </ul>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button 
        type="button" 
        class="btn btn-success" 
        data-gestion="0" 
        id="confirmarPruebasTecnicas"
        onclick="confirmarPruebasTecnicas(this, '{{ route("admin.confirmar_pruebas_tecnicas") }}')">Confirmar</button>
</div>
