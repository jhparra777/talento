<!-- Inicio contenido principal -->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4>Video Perfil</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-right-item-container">
            <div class="container-fluid">
                <div class="col-sm-12">
                    <div id="submit_listing_box">
                        <div class="form-alt">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <video controls style="max-width: 100%">
                                        <source src='{{ route("view_document_url", encrypt("recursos_videoperfil/|".$user->video_perfil)) }}' type="video/webm">
                                    </video>
                                    <br>
                                </div>
                            </div>
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


