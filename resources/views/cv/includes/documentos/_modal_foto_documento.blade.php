<div class="modal fade" id="fotoDocumentoModal" tabindex="-1" role="dialog" aria-labelledby="fotoDocumentoModalLabel">
    <div class="modal-dialog modal-lg modal-photo-custom" role="document" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="fotoDocumentoModalLabel">Foto Documentos</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    {{-- Cropper --}}
                    <div class="col-md-12" id="foto-croppper-box" style="margin-bottom: 2rem;" hidden>
                        <div>
                            <img id="cropper-image" src="#">
                        </div>
                    </div>

                    {{-- Webcam --}}
                    <div class="col-md-12 text-center" id="webcam-box" style="margin-bottom: 1rem;">
                        <video class="webcam-video" id="webcam" autoplay playsinline width="640" height="480"></video>
                        <canvas id="canvas" class="d-none" hidden></canvas>
                    </div>

                    {{-- Buttons control --}}
                    <div class="col-md-12 text-center" id="rotate-box" style="margin-bottom: 1rem;" hidden>
                        <button class="btn-quote" type="button" id="rotate-left" style="display: initial;">
                            <i class="fa fa-undo" aria-hidden="true"></i>
                        </button>

                        <button class="btn-quote" type="button" id="rotate-right" style="display: initial;">
                            <i class="fa fa-repeat" aria-hidden="true"></i>
                        </button>
                    </div>

                    {{-- Botones de media --}}
                    <div class="col-md-12 text-center" id="flip-camera-box" style="margin-bottom: 1rem;" hidden>
                        {{-- Botón flip --}}
                        <button class="btn-quote" type="button" id="flip-camera" style="display: initial; display: initial; border-radius: 100%; height: 7rem; width: 7rem; font-size: 3rem;">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </button>
                    </div>

                    {{-- Botones de media --}}
                    <div class="col-md-6 text-center" style="margin-bottom: 1rem;">
                        <button class="btn-quote btn-block" type="button" id="start-camera" style="display: initial;">
                            <i class="fa fa-camera" aria-hidden="true"></i> INICIAR CÁMARA
                        </button>
                    </div>

                    <div class="col-md-6 text-center" style="margin-bottom: 1rem;">
                        <button class="btn-quote btn-block" type="button" id="stop-camera" style="display: initial;" disabled>
                            <i class="fa fa-eye-slash" aria-hidden="true"></i> DETENER CÁMARA
                        </button>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="col-md-12 text-center" id="take-picture-box">
                        <button class="btn-quote btn-block" type="button" id="take-picture" disabled>
                            TOMAR FOTO
                        </button>
                    </div>

                    <div class="col-md-12 text-center" id="save-picture-box" hidden>
                        <button class="btn-quote btn-block" type="button" id="save-picture">
                            GUARDAR FOTO
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn-quote" type="button" style="display: initial;" data-dismiss="modal" hidden>
                    CERRAR
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    #image {
        display: block;

        /* This rule is very important, please don't ignore this */
        max-width: 100%;
    }
</style>