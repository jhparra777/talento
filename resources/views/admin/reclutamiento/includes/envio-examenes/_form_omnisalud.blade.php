<div class="col-md-12 mb-2">
    <div class="checkbox">
        <label>
            <input type="checkbox" name="omnnisalud_opcion" id="laboratorioOpcion" value="1" onchange="cambiarLaboratorio(this)"> 

            ¿Usar laboratorio Omnisalud?
        </label>
    </div>
    <small>Si deseas usar Omnisalud como laboratorio marca la casilla.</small>
</div>

<div class="col-md-12" id="mensajeDefault" hidden>
    <p>
        ¿Desea enviar a este candidato a exámenes médicos?
    </p>
</div>

@if ($sitio_modulo->omnisalud == 'enabled')
    <div id="omnisaludCampos" hidden>
        <div class="col-md-12">
            <div class="form-group">
                <label for="tipo_admision_omnisalud">Tipo de admisión *</label>

                <select name="tipo_admision_omnisalud" id="tipo_admision_omnisalud" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required disabled>
                    <option value="">Seleccionar</option>
                    @foreach ($omnisalud_tipo_admision as $codigo => $descripcion)
                        <option value="{{ $codigo }}">{{ $descripcion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="examenes_omnisalud">Exámenes a realizar *</label>

                <select class="selectpicker form-control" name="examenes_omnisalud[]" id="examenes_omnisalud" data-actions-box="true" multiple required disabled>
                    @foreach($omnisalud_examenes_medicos as $examen_codigo => $examen_descripcion)
                        <option value="{{ $examen_codigo }}">
                            {{ strlen($examen_descripcion) < 100 ? $examen_descripcion : substr($examen_descripcion, 0, 100) . '...' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="ciudad_omnisalud">Ciudad *</label>

                <select name="ciudad_omnisalud" id="ciudad_omnisalud" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required disabled>
                    <option value="">Seleccionar</option>
                    @foreach ($omnisalud_ciudades as $codigo => $descripcion)
                        <option value="{{ $codigo }}">{{ $descripcion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="observacion_omnisalud">Observación *</label>

                <textarea class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" name="observacion_omnisalud" id="observacion_omnisalud" placeholder="El examen XX lo paga el paciente" maxlength="500" rows="2" required disabled></textarea>
                <small>Máximo 500 carácteres.</small>
                {{-- <b>Debes indicar si el candidato paga el examen.</b> --}}
            </div>
        </div>
    </div>
@endif