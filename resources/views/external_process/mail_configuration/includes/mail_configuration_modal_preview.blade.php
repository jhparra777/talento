<div class="modal fade" id="previsualizarModal" tabindex="-1" role="dialog" aria-labelledby="previsualizarModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="previsualizarModalLabel">Previsualizar correo</h4>
            </div>
            <div class="modal-body">
                <form id="frmPrevisualizarCorreo" data-smk-icon="glyphicon-remove-sign">
                    {{-- Plantillas --}}
                    <div class="form-group">
                        <label for="nombre_configuracion" class="control-label">Plantilla *</label>
                        <select class="form-control" name="plantilla" id="plantilla" required>
                            <option value="">Seleccionar</option>
                            <option value="1">Plantilla sencilla</option>
                            <option value="2">Plantilla con fondo #1</option>
                            <option value="3">Plantilla con fondo #2</option>
                        </select>
                    </div>

                    {{-- Configuración --}}
                    <div class="form-group">
                        <label for="nombre_configuracion" class="control-label">Cofiguración *</label>
                        {!! Form::select('configuracion', $configuracion_correo_lista, null, ['class' => 'form-control', 'id' => 'configuracion', 'required' => 'required']) !!}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnPrevisualizar" onclick="previsualizarCorreoVentana()">Previsualizar</button>
            </div>
        </div>
    </div>
</div>