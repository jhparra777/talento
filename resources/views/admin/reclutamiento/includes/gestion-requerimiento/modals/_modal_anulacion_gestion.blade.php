<div class="modal fade" id="modal_anulacion" >
    <div class="modal-dialog">
        <div class="modal-content | tri-br-1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <h4><b>Motivo de anulación</b></h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <form id="fr_anular">
                        <div class="col-md-12 form-group">
                            <select class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" name="motivo_anulacion" id="motivo_anulacion">
                                @foreach( $motivos_anulacion as $id => $motivo )
                                    <option value="{{$id}}">{{$motivo}}</option>
                                @endforeach
                            </select>

                            <input type="hidden" name="user_id" id="anular_user_id" value="">
                            <input type="hidden" name="req_id" id="anular_req_id" value="">
                            <input type="hidden" name="cand_req" id="anular_cand_req" value="">
                            <input type="hidden" name="cliente_id" id="anular_cliente_id" value="">
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="anular_contrato_frm">Anular</button>
            </div>
        </div>
    </div>
</div>