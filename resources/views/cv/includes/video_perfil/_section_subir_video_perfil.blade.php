<div class="col-md-12" id="submit_listing_box">
    <h3>
        <i class="fa fa-video-camera"></i> Cargar video perfil
    </h3>

    <div class="form-alt">
        <div class="row">
            {{-- Cargar video perfil --}}
            <div class="col-right-item-container">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="video-upload">
                            <button 
                                type="button" 
                                class="btn btn-primary btn-block btn-lg file-upload-btn" 
                                onclick="$('.file-upload-input').trigger( 'click' )"
                            >
                                Seleccionar archivo
                            </button>

                            <div class="image-upload-wrap">
                                <input type="file" class="file-upload-input" id="video-input" onchange="readURL(this);" accept="video/*">

                                <div class="text-center">
                                    <p class="drag-text">Arrastre y suelte un archivo o seleccionar archivo</p>
                                </div>
                            </div>

                            <div class="row" id="grant-formats-msg">
                                <div class="col-md-12 text-right" style="font-size: 1.6rem;">
                                    <strong>
                                        <small>Tamaño máximo permitido:</small> <small style="font-family: sans-serif;">60 MB</small>
                                        <small>- Formatos permitidos: MP4, WEBM</small>
                                    </strong>
                                </div>
                            </div>

                            <div class="file-upload-content">
                                {{-- <img class="file-upload-image" src="#" alt="your image"> --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <video class="file-upload-image" src="#" controls></video>

                                        <i>
                                            <p id="video-name"></p>
                                        </i>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <button type="button" class="btn btn-danger btn-block btn-lg remove-image" onclick="removeUpload()" style="margin-bottom: 2rem;">
                                            Quitar video perfil
                                        </button>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <button type="button" class="btn btn-success btn-block btn-lg" id="upload-video" style="margin-bottom: 2rem;" disabled>
                                            Cargar video perfil <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>