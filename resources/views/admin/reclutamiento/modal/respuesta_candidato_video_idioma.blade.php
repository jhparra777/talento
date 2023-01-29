<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<div class="modal-body">
    <div class="alert alert-success" role="alert">Respuesta del candidato</div>
    
    <br>
    <div class="clearfix"></div>

    <div class="form-alt">
        <div class="row">
            <div class="col-right-item-container">
                <div class="container-fluid">
                    <div class="col-sm-12">
                        <div id="submit_listing_box">
                            <h3></h3>
                            <div class="form-alt">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <div class="mr-auto">
                                            <video height="410" autobuffer autoloop loop controls src="{{ asset("recursos_VideoIdioma/".$respuesta->respuesta) }}"></video>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div style="text-align: center;" class="col-sm-12">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <br><br>
    <div class="clearfix"></div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>


