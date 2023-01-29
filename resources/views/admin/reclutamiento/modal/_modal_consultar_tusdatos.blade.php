<div class="modal fade" id="consultarTusDatosModal" tabindex="-1" role="dialog" aria-labelledby="consultarTusDatosModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="consultarTusDatosModalLabel">Consultar de Seguridad</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="formTusdatos">
                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipoPlan">Selecciona el tipo de consulta para continuar *</label>
                                <select name="plan" id="tipoPlan" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="protegido">Consulta Protegido</option>
                                    <option value="blindado">Consulta Blindado</option>
                                </select>
                            </div>
                        </div> --}}

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipoDocumentoDatos">Selecciona tipo de documento *</label>
                                <select name="tipo_documento" id="tipoDocumentoDatos" class="form-control" required>
                                    <option value="">Seleccionar</option>

                                    @foreach ($tipos_documentos as $key => $value)
                                        <option value="{{ $key }}" {{ $datos_basicos->tipo_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fechaExpedicionDatos">Ingresa fecha de expedición *</label>
                                <input type="date" name="fecha_expedicion" id="fechaExpedicionDatos" class="form-control" value="{{ $datos_basicos->fecha_expedicion }}">
                            </div>
                        </div>
                    </form>

                    <div class="col-md-12 mb-2">
                        ¿Desea realizar la consulta de seguridad a este candidato?
                    </div>

                    <div class="col-md-12">
                        <div class="alert alert-info" role="alert">
                            El tiempo estimado para completar la consulta es de <b>5 minutos</b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="confirmarTusDatos" onclick="consultarTusDatos({{ $user_id }}, {{ $req_id }}, '{{ route('admin.tusdatos_launch') }}', document.querySelector('#tipoDocumentoDatos').value, document.querySelector('#fechaExpedicionDatos').value)">Confirmar</button>
            </div>
        </div>
    </div>
</div>