<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<div class="modal-body">
    <div class="alert alert-success" role="alert">Respuesta del candidato</div>

    <div class="form-alt">
        <div class="row">
            <div class="col-right-item-container">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <video height="400" width="560" controls>
                                <source
                                    src="{{asset("recursos_videoRespuesta/"."$respuesta->respuesta?".date('His'))}}"
                                    type="video/webm"
                                >
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>


