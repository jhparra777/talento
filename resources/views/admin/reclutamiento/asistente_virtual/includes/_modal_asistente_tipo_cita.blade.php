<div class="modal fade" data-backdrop="false" data-keyboard="false" id="modal_tipo_cita">
    <div class="modal-dialog modal-md">
        <div class="modal-content | tri-br-1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Citación candidatos</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <p><b>¿Que tipo de cita desea crear?</b></p>
                    </div>

                    <div class="col-md-6 mb-1">
                        <button type="button" class="btn btn-default btn-block | tri-br-2 tri-fs-14 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-tipo="without" onclick="agendamiento(this)">
                            <i class="fas fa-phone"></i> Cita sin agendamiento
                        </button>
                    </div>

                    <div class="col-md-6">
                        <button type="button" class="btn btn-default btn-block | tri-br-2 tri-fs-14 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-tipo="with" onclick="agendamiento(this)">
                            <i class="fas fa-calendar"></i> Cita con agendamiento
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>