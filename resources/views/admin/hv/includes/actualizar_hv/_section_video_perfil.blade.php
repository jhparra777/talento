{{-- <div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h4 class="tri-fw-600">
                Video perfil
            </h4>
        </div>
    </div>
</div> --}}

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 mb-2">
            <h4 class="tri-fw-600">
                Video perfil
            </h4>
        </div>

        <div class="video-upload">
            <button 
                type="button" 
                class="btn btn-default btn-block file-upload-btn | tri-br-2 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-200 tri-hover-out-blue" 
                onclick="$('.file-upload-input').trigger( 'click' )"
            >
                Seleccionar archivo
            </button>

            <div class="image-upload-wrap | tri-bd-l-gray">
                <input type="file" class="file-upload-input" id="video-input" onchange="readURL(this);" accept="video/*">

                <div class="text-center">
                    <p class="drag-text | tri-txt-gray">Arrastre y suelte un archivo o seleccionar archivo</p>
                </div>
            </div>

            <div class="row" id="grant-formats-msg">
                <div class="col-md-12 text-right | tri-fs-16">
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

                        <p class="tri-txt-gray" id="video-name"></p>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <button type="button" class="btn btn-default btn-block remove-image | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red" onclick="removeUpload()" style="margin-bottom: 2rem;">
                            Quitar video perfil
                        </button>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <button type="button" class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" id="upload-video" style="margin-bottom: 2rem;" disabled>
                            Cargar video perfil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>