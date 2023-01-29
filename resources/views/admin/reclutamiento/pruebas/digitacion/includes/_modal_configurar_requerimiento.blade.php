<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Configurar prueba digitación</h4>
</div>

<div class="modal-body">
    <div class="row">
        <form id="frmConfiguracionReq">
            <input type="hidden" name="req_id" value="{{ $reqId }}">
            <input type="hidden" name="cargo_id" value="{{ $cargoId }}">

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ppmEsperada" class="control-label">Palabras por minuto</label>
                        <input 
                            type="number" 
                            class="form-control" 
                            name="ppm_esperada" 
                            id="ppmEsperada" 
                            placeholder="Ingresa las palabras por minuto esperadas"

                            value="{{ $digitacionRequerimiento->ppm_esperada }}" 
                        >

                        <small>
                            <a href="https://es.wikipedia.org/wiki/Palabras_por_minuto" target="_blank">Información adicional (PPM)</a>
                        </small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ppmEsperada">Precisión esperada %</label>
                        <input 
                            type="number" 
                            class="form-control" 
                            name="precision_esperada" 
                            id="precisionEsperada" 
                            placeholder="Ingresa el porcentaje de precisión esperado"

                            value="{{ $digitacionRequerimiento->precision_esperada }}" 
                        >
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

    @if(isset($reqId))
        <button 
            type="button" 
            class="btn btn-success" 
            id="guardarConfiguracionDigitacion"
            onclick="guardarConfiguracionDigitacion(this, '{{ route("admin.guardar_configuracion_digitacion_requerimiento") }}')">Guardar</button>
    @else
        <button 
            type="button" 
            class="btn btn-success" 
            id="guardarConfiguracionDigitacionCargo"
            onclick="guardarConfiguracionDigitacionCargo(this, '{{ route("admin.guardar_configuracion_digitacion_cargo") }}')">Guardar</button>
    @endif
</div>
