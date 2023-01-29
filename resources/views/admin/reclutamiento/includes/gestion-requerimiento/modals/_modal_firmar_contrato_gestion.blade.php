@if($requermiento->tipo_proceso_id == $sitio->id_proceso_sitio)
    {{-- Para firmar contrato desde Gestion Req --}}
    <div class="modal fade" id="modal_gr_local" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" id="mdialTamanio">
            <div class="modal-content">
                <div class="modal-header">                    
                    <h4 class="modal-title">Confirmación</h4>
                </div>

                {!! Form::open(["id" => "fr_verificacion_codigo", "route" => "verificar_codigo_contrato", "name" => "verificacion"]) !!}
                    <div class="modal-body black">
                        <div class="alert alert-info text-left" role="alert">
                            Acepto y autorizo que para perfeccionar la contratación virtual con ({{ $sitio->nombre }}), sea adoptada la firma que dibujé en el contrato de trabajo mediante la herramienta virtual y los videos que adjunté en la plataforma configuran un soporte válido para el proceso de mi contratación.
                        </div>

                        <div class="alert alert-info text-left" role="alert">
                            También declaro que es mi voluntad regirme por el modelo de firma electrónica pactada mediante acuerdo (el cual es el modelo legal que usa este sitio para el perfeccionamiento del proceso de la contratación laboral virtual) señalada en el numeral 1° del artículo 2.2.2.47.1.
                        </div>

                        <div class="alert alert-info text-left" role="alert">
                            <b>
                                Recuerda que desde este momento debes permitir el uso de la cámara de tu dispositivo, esto con el fin de asegurar que el proceso de la firma sea válido.
                            </b>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="modal-footer">
                        <a target="_blank" id="btnIrFirmaContrato" hidden></a>

                        <button type="button" class="btn btn-success" id="btnAceptarFirmaContrato">Aceptar y verificar</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {{-- Webcam --}}
    <div style="background-color: white;" id="webcamBox">
        <div class="col-md-12 text-center" style="z-index: -1;">
            <video id="webcam" autoplay playsinline width="640" height="420"></video>
            <canvas id="canvas" class="d-none" hidden></canvas>
        </div>
    </div>

    {{-- Webcam JS - Pictures --}}
    <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
@endif