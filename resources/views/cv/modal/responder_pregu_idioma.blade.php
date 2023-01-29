<div id="accordion" class="mb-2">
    <div class="card">
        <div class="card-header p-2" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Instrucciones
                </button>
            </h5>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body p-1">
                <div class="alert alert-success mb-0" role="alert">
                    Estás por comenzar la prueba de idiomas, tendrás un tiempo estimado para responderla. Verás la pregunta cuando comience la grabación. Una vez que comience a grabar solo podrá "Terminar y Guardar" o se guardará automáticamente cuando finalice el tiempo máximo para responder.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-alt">
    <div class="row">
        <div class="col-md-12">
            <h3>Pregunta:</h3>
            <h6>Tienes {{$pregunta_prueba->tiempo}} seg para responder.</h6>
            {!! Form::hidden('pregu',$pregu_id , []) !!}
            <h4 style="display: none;" id="pregunta">{{$pregunta_prueba->descripcion}}</h4>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12 mr-auto text-center">
                        <div id="img-grabacion" style=""><img src="{{ url('img/grabando.gif') }}"></div>
                        <video id="gum" playsinline  muted autoplay autofocus></video>
                        <video id="recorded" type="video/webm"  autoplay="false"  controls ></video>
                    </div>
                </div>
            </div>

            <div class="col-md-12 text-center">
                <div class="col-md-6 offset-md-3">
                    <div id="timer-video-descripcion">
                        <div class="timer-container col-md-6 offset-md-3">
                            <div>
                                <span id="timer-seconds">{{$pregunta_prueba->tiempo}}</span>Segundos
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center botones-grabacion">
                    <button type="button" class="btn btn-info m-2 rounded-pill" id="iniciar">Comenzar</button>
                    <button class="btn btn-primary rounded-pill" id="btnGuardar" style="display: none;" onclick="uploadToPHPServer()">
                        Terminar y Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-sm" id="btnCerrar">Cerrar</button>
</div>

<script type="text/javascript">
    unsaved = false;
    let video = document.querySelector('#gum');
    $('#recorded').hide();
    let redireccion = 'reload';
    let partes = [];
    let mediaRecorder = null;
    let options = {
        mimeType: 'video/webm;codecs=h264'
    }
    let tiempo_corriendo = null;
    let tiempo = {
        segundo: {{$pregunta_prueba->tiempo}}
    };
    const recordedVideo = document.querySelector('video#recorded');

    function updateClock(id_elemento, totalTime) {
        document.getElementById(id_elemento).innerHTML = totalTime;
        if(totalTime > 0){
            totalTime -= 1;
            setTimeout("updateClock('"+id_elemento+"', "+totalTime+")",1000);
        }
    }

    document.querySelector('#iniciar').addEventListener("click", function(ev) {
        $.smkProgressBar({
            element:'body',
            status:'start',
            bgColor: '#000',
            barColor: '#fff',
            content: 'Se solicitarán los permisos para acceder a su cámara y micrófono. Por favor presione "Permitir" para que pueda grabar su video idioma.'
        });
        navigator.mediaDevices.getUserMedia({audio: true, video: true})
            .then(comenzar)
            .catch(procesarErrores);
    })

    function comenzar(stream) {
        $.smkProgressBar({
            status:'end'
        });
        $('#pregunta').show("slow");

        $.smkAlert({
            text: 'Aceptó los permisos, comenzará la grabación',
            type: 'success'
        });
        $('#iniciar').hide();
        $('#btnGuardar').show();
        $('.modal-footer').hide();

        inicio_grabacion = true;

        video.srcObject = stream;
        window.stream = stream;

        if (!MediaRecorder.isTypeSupported(options.mimeType)) {
            options = { mimeType: 'video/webm' }
            if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                //console.log(options.mimeType + ' is not Supported');
                options = {mimeType: 'video/webm;codecs=vp8'};
                if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                    //console.log(options.mimeType + ' is not Supported');
                    options = {mimeType: 'video/webm;codecs=vp9'};
                    if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                        //console.log(options.mimeType + ' is not Supported');
                        options = {mimeType: ''};
                    }
                }
            }
        }

        mediaRecorder = new MediaRecorder(stream, options)

        $('#timer-video-descripcion').show();

        mediaRecorder.ondataavailable = function(e) {
            //console.log(e.data);
            partes.push(e.data);
        }

        mediaRecorder.onstop = function(e) {
            console.log('se ha detenido el video');
        }

        setTimeout(() => {
            grabacion()
        }, 2000);
    }

    function grabacion() {
        mediaRecorder.start();
        $('#img-grabacion').show()
        tiempo_corriendo = setInterval(function(){
            // Segundos
            tiempo.segundo--;
            if(tiempo.segundo < 0) {
                detener();
            }

            $('#gum').toggleClass('borde-rojo-2x');
            $("#timer-seconds").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
            if (tiempo.segundo < 10) {
                $("#timer-seconds").addClass('text-red');
            }
        }, 1000);
    }

    function detener() {
        mediaRecorder.stop();

        $('#img-grabacion').hide();
        $('#timer-video-descripcion').hide();
        $("#timer-seconds").text('{{$pregunta_prueba->tiempo}}');
        $("#timer-seconds").removeClass('text-red');
        $('#gum').removeClass('borde-rojo-2x');
        clearInterval(tiempo_corriendo);
        tiempo.segundo = {{$pregunta_prueba->tiempo}};
        unsaved = true;

        recordedVideo.controls = true;

        //Se agrega el video para 
        $('#recorded').show();
        $('#gum').hide();

        if (partes.length == 0) {
            setTimeout(function(){
                uploadToPHPServer();
            }, 2000);
        } else {
            uploadToPHPServer();
        }
    }

    function procesarErrores(err) {
        $.smkProgressBar({
            status:'end'
        });
        var totalTime = 7;
        var mensaje = 'Se produjo un error inesperado. Por favor intente nuevamente, si el problema persiste contacte con soporte e indique que navegador está utilizando.';
        if (err.name === 'NotAllowedError') {
            mensaje = 'Para poder grabar el video se necesitan los permisos de la cámara y micrófono';
        } else if (err.name === 'NotReadableError' || err.name === 'AbortError') {
            mensaje = 'Error al compartir la cámara y micrófono. Verifique que no estén en uso en otro navegador.';
        } else if (err.name === 'NotFoundError') {
            mensaje = 'No se detectaron dispositivos de audio y video.';
        }
        mensaje += '<br><br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';
        $('#modal_peque').modal('hide');
        mensaje_danger(mensaje);
        updateClock("tiempo_recarga", totalTime);
        setTimeout(function(){
            location.reload();
        }, totalTime*1000);
    }

    ///////////////////////FUNCION PARA GUARDAR EL VIDEO //////////////////////////
    function uploadToPHPServer() {
        if (mediaRecorder.state === 'paused' || mediaRecorder.state === 'recording') {
            mediaRecorder.stop();

            $('#img-grabacion').hide();
            $('#timer-video-descripcion').hide();
            $("#timer-seconds").text('{{$pregunta_prueba->tiempo}}');
            $("#timer-seconds").removeClass('text-red');
            $('#gum').removeClass('borde-rojo-2x');
            clearInterval(tiempo_corriendo);
            tiempo.segundo = {{$pregunta_prueba->tiempo}};
        }
        $('#modal_peque').modal('hide');
        mensaje_success("Espere mientras se sube el video. Por favor no cierre la ventana, ni se mueva de menu mientras se guarda el video.<br><div class='progress progress-striped active'><div id='progreso_guardado' class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: 0%'></div></div>");
        setTimeout(function(){
            completarGuardado();
        }, 2000);
    }

    function  completarGuardado() {
        let superBuffer = new Blob(partes, {type: 'video/webm'});
        var file = new File([superBuffer], 'msr-' + (new Date).toISOString().replace(/:|\./g, '-') + '.webm', {
            type: 'video/webm'
        });

        var formData = new FormData();
        formData.append('video-filename', file.name);
        formData.append('video-blob', file); 
        formData.append('preg_entre_id','{{ $pregu_id }}');
        formData.append('user_id','{{ $user_id }}');
        formData.append('_token','{{ csrf_token() }}');

        makeXMLHttpRequest("{{route('admin.guardar_respuesta_idioma')}}", formData);
    }

    function makeXMLHttpRequest(url, data) {
        $('#progreso_guardado').show();
        var request = new XMLHttpRequest();
        request.upload.addEventListener("progress", updateProgress); //Avance de la carga del video
        request.upload.addEventListener("load", transferComplete);   //Al finalizar la carga del video
        request.upload.addEventListener("error", transferFailed);    //Si ocurre un error al guardar el video
        request.upload.addEventListener("abort", transferCanceled);  //Si se cancela el guardar de alguna manera por el usuario

        request.open('POST', url);
        request.send(data);

        request
    }

    function transferComplete(evt) {
        setTimeout(function(){
            $('#modal_success').modal('hide');
            swal("Video Idioma Guardado", "Se ha guardado con éxito", "info", {
                buttons: {
                    ok: {
                        text: "OK",
                        className:'btn btn-success'
                    }
                },
            }).then((value) => {
                if (redireccion == 'reload') {
                    window.location.reload();
                } else {
                    location.href = redireccion;
                }
            });
        }, 3000);
    }

    function transferFailed(evt) {
        $('#modal_success').hide();
        $('#modal_peque').modal('hide');
        mensaje_danger("No se pudo guardar el video, intente de nuevo.");
        //console.log("An error occurred while transferring the file.");
    }

    function transferCanceled(evt) {
        $('#modal_success').hide();
        $('#modal_peque').modal('hide');
        mensaje_danger("No se pudo guardar el video, fue cancelado por el usuario.");
        //console.log("The transfer has been canceled by the user.");
    }

    // progress on transfers from the server to the client (downloads)
    function updateProgress (oEvent) {
        if (oEvent.lengthComputable) {
        var percentComplete = oEvent.loaded / oEvent.total * 100;
        //console.log(percentComplete);

        $('#progreso_guardado').attr('aria-valuenow', percentComplete.toFixed(0)).css('width', percentComplete.toFixed(0)+'%').html(percentComplete.toFixed(0)+'% completado');
        } else {
        // Unable to compute progress information since the total size is unknown
        }
    }

    $('#modal_success').on('hidden.bs.modal', function (e) {
        $('#progreso_guardado').attr('aria-valuenow', 0).css('width', '0%').html('0% completado');
    })

    $(function () {
        $("#btnCerrar").on('click', function (e) {
            e.preventDefault();
            $('#modal_peque').modal('hide');
        });
    });
</script>
