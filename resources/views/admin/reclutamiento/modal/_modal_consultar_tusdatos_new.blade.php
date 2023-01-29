<div class="modal fade" id="consultarTusDatosModal" tabindex="-1" role="dialog" aria-labelledby="consultarTusDatosModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content | tri-br-1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="consultarTusDatosModalLabel">
                    <b>Consulta de Antecedentes</b><br>
                    <b>Candidato</b> {{ $datos_basicos->nombres." ".$datos_basicos->primer_apellido." ".$datos_basicos->segundo_apellido }} | <b>{{$datos_basicos->cod_tipo}}</b> {{$datos_basicos->numero_id}}
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="formTusdatos">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipoDocumentoDatos" class="control-label">Selecciona tipo de documento <span class='text-danger sm-text-label'>*</span></label>
                                <select name="tipo_documento" id="tipoDocumentoDatos" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required>
                                    <option value="">Seleccionar</option>

                                    @foreach ($tipos_documentos as $key => $value)
                                        <option value="{{ $key }}" {{ $datos_basicos->tipo_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fechaExpedicionDatos" class="control-label">Ingresa fecha de expedición <span class='text-danger sm-text-label'>*</span></label>
                                <input type="date" name="fecha_expedicion" id="fechaExpedicionDatos" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" value="{{ $datos_basicos->fecha_expedicion }}" required="">
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
                <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300" id="confirmarTusDatos" onclick="consultarTusDatos({{ $user_id }}, {{ $req_id }}, '{{ route('admin.tusdatos_launch') }}', document.querySelector('#tipoDocumentoDatos').value, document.querySelector('#fechaExpedicionDatos').value)">Confirmar</button>
            </div>
        </div>
    </div>
</div>