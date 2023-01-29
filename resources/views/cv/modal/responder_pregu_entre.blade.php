<div class="modal-header">
    <h5 class="modal-title">Video Entrevista Virtual</h5>
</div>

<div class="modal-body">
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
                    <div class="alert alert-info small mb-1" role="alert">
                        Lee la pregunta, piensa en tu respuesta y comienza a grabar cuando estes listo/a.
                    </div>

                    <div class="alert alert-success small mb-0" role="alert">
                        Para iniciar el video  dar clic en el botón <b>"Comenzar"</b> y para finalizar en el botón <b>"Pausar"</b> o espere que finalice el tiempo total; una vez pausado el video presione <b>"Terminar y Guardar"</b>.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-alt">
        <div class="row">
            <div class="col-md-12">
                <h5>Pregunta:</h5>
                <p>{{ mb_strtoupper($pregunta_entre->descripcion) }}</p>

                <div class="row">
                    {!! Form::hidden('pregu', $pregu_id , []) !!}

                    <div class="col-md-12">
                        <div class="col-md-12 mr-auto text-center">
                            <div id="img-grabacion" style=""><img src="{{ url('img/grabando.gif') }}"></div>
                            <video id="gum" playsinline  muted autoplay autofocus></video>

                            <video id="recorded" type="video/webm" autoplay autobuffer controls></video>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 text-center">
                    <div class="col-md-6 offset-md-3">
                        <div id="timer-video-descripcion">
                            <div class="timer-container col-md-6 offset-md-3">
                                <div>
                                    <span id="timer-seconds">45</span>Segundos
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center botones-grabacion">
                        <button type="button" class="btn btn-info m-2 rounded-pill" id="iniciar">Comenzar</button>
                        <button name="record" type="button" class="btn btn-info m-2 rounded-pill" id="record" style="display: none;" onclick="grabacion();">Reanudar</button>
                        <button class="btn btn-primary rounded-pill" id="btnGuardar" style="display: none;" onclick="uploadToPHPServer()">
                            Terminar y Guardar
                        </button>
                        <button type="button" class="btn btn-danger m-2 rounded-pill" id="cancel" style="display: none;" onclick="cancelar();">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
        segundo: 45
    };
    const buttonRecord = document.querySelector('#record');
    const recordedVideo = document.querySelector('video#recorded');

    function updateClock(id_elemento, totalTime) {
        document.getElementById(id_elemento).innerHTML = totalTime;
        if(totalTime > 0){
            totalTime -= 1;
            setTimeout("updateClock('"+id_elemento+"', "+totalTime+")",1000);
        }
    }

    document.querySelector('#iniciar').addEventListener("click", function(ev) {
        if (!inicio_grabacion) {
            $.smkProgressBar({
                element:'body',
                status:'start',
                bgColor: '#000',
                barColor: '#fff',
                content: 'Se solicitarán los permisos para acceder a su cámara y micrófono. Por favor presione "Permitir" para que pueda grabar su video respuesta.'
            });
            navigator.mediaDevices.getUserMedia({audio: true, video: true})
                .then(comenzar)
                .catch(procesarErrores);
        } else {
            grabacion();
        }
    })

    function comenzar(stream) {
        $.smkProgressBar({
            status:'end'
        });

        $.smkAlert({
            text: 'Aceptó los permisos, comenzará la grabación',
            type: 'success'
        });
        $('#iniciar').hide();
        $('#record').show();

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
        }, 1000);
    }

    function grabacion() {
        if ( buttonRecord.innerText === 'Pausar') {
            pausar();
        } else {
            if ( buttonRecord.innerText === 'Reanudar' && mediaRecorder !== undefined && mediaRecorder !== null) {
                if (mediaRecorder.state === 'paused') {
                    mediaRecorder.resume();
                } else {
                    mediaRecorder.start();
                }
            } else {
                try {
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

                    mediaRecorder = new MediaRecorder(window.stream, options);

                    mediaRecorder.ondataavailable = function(e) {
                        //console.log(e.data);
                        partes.push(e.data);
                    }

                    mediaRecorder.onstop = function(e) {
                        console.log('se ha detenido el video');
                    }

                    if (video.srcObject === null) {
                        $('#iniciar').hide();
                        $('#record').show();
                        video.srcObject = window.stream;
                    }
                } catch (e) {
                    //console.error(`Exception while creating MediaRecorder: ${e}`);
                    $('#modal_pregunta').modal('hide');
                    mensaje_danger(`Error al crear la video grabación. Por favor recargue la página e intente nuevamente. Si el problema persiste contacte con soporte e indique el navegador que está utilizando.`);
                    return;
                }

                mediaRecorder.start();
                $('#timer-video-descripcion').show();
            }
            $('#img-grabacion').show()
            buttonRecord.innerText = 'Pausar';
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
    }

    function pausar() {
        mediaRecorder.pause();

        $('#img-grabacion').hide();
        $('#gum').removeClass('borde-rojo-2x');
        buttonRecord.innerText = 'Reanudar';
        clearInterval(tiempo_corriendo);
        $('#cancel').show();
        $('#btnGuardar').show();
        unsaved = true;
    }

    function detener() {
        mediaRecorder.stop();

        $('#img-grabacion').hide();
        $('#timer-video-descripcion').hide();
        $("#timer-seconds").text('45');
        $("#timer-seconds").removeClass('text-red');
        $('#gum').removeClass('borde-rojo-2x');
        clearInterval(tiempo_corriendo);
        tiempo.segundo = 45;
        unsaved = true;

        recordedVideo.controls = true;

        //Se agrega el video para 
        $('#recorded').show();
        $('#gum').hide();

        if (partes.length == 0) {
            setTimeout(function(){
                mostrarVideo();
            }, 2000);
        } else {
            mostrarVideo();
        }
    }

    function mostrarVideo() {
        buttonRecord.innerText = 'Comenzar';
        buttonRecord.style.display = 'none';
        $('#cancel').show();
        $('#btnGuardar').show();
        let superBuffer = new Blob(partes, {type: 'video/webm'});

        let url = window.URL.createObjectURL(superBuffer);

        recordedVideo.src = url;

        recordedVideo.currentTime = 0;
    }

    function cancelar() {
        swal("¿Está seguro?", "¿Desea eliminar el video que acaba de grabar?. Podrá grabar uno nuevo.", "warning", {
            buttons: {
                cancelar: { text: "Cancelar",className:'btn btn-default' },
                eliminar: { text: "Eliminar",className:'btn btn-warning' },
            },
        }).then((value) => {
            switch (value) {
                case "eliminar":
                    unsaved = false;
                    partes = [];
                    $('#cancel').hide();
                    $('#btnGuardar').hide();
                    $('#img-grabacion').hide();
                    buttonRecord.innerText = 'Comenzar';
                    $('#record').show();
                    $('#recorded').hide();
                    recordedVideo.src = null;
                    $('#gum').removeClass('borde-rojo-2x');
                    $('#gum').show();
                    clearInterval(tiempo_corriendo);
                    tiempo.segundo = 45;
                    $("#timer-seconds").text('45');
                    $("#timer-seconds").removeClass('text-red');
                    $('#timer-video-descripcion').hide();
                    if (mediaRecorder.state === 'paused' || mediaRecorder.state === 'recording') {
                        mediaRecorder.stop();
                    }
                break;
                case "cancelar":
                break;
            }
        });
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
        $('#modal_pregunta').modal('hide');
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
            $("#timer-seconds").text('45');
            $("#timer-seconds").removeClass('text-red');
            $('#gum').removeClass('borde-rojo-2x');
            buttonRecord.innerText = 'Comenzar';
            buttonRecord.style.display = 'none';
            clearInterval(tiempo_corriendo);
            tiempo.segundo = 45;
        }
        $('#modal_pregunta').modal('hide');
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
        formData.append('entrevista_virtual_id', {{ $pregunta_entre->entre_vir_id }});
        formData.append('_token','{{ csrf_token() }}');

        makeXMLHttpRequest("{{route('admin.guardar_respuesta_entre')}}", formData);
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
            swal("Video Entrevista guardada", "Se ha guardado con éxito", "info", {
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
        $('#modal_pregunta').modal('hide');
        mensaje_danger("No se pudo guardar el video, intente de nuevo.");
        //console.log("An error occurred while transferring the file.");
    }

    function transferCanceled(evt) {
        $('#modal_success').hide();
        $('#modal_pregunta').modal('hide');
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

    function verificar_video_ir() {
        if (unsaved){
            swal({
                title: 'Ha grabado un video y no lo ha guardado. ¿Desea guardar antes de cerrar?',
                //text: 'Atención',
                icon: "warning",
                buttons: true,
                buttons: {
                    defeat: {
                        text: "SI",
                        value: "guardar",
                    },
                    catch: {
                      text: "NO",
                      value: "ir",
                    },
                    cancel: "CANCELAR",
                },
            })
            .then((respuesta) => {
                if (respuesta == 'guardar') {
                    uploadToPHPServer();
                } else if (respuesta == 'ir') {
                    $('#modal_pregunta').modal('hide');
                }
            });
        } else {
            if (mediaRecorder !== null && mediaRecorder !== undefined) {
                if (mediaRecorder.state === 'paused' || mediaRecorder.state === 'recording') {
                    mediaRecorder.stop();

                    $('#img-grabacion').hide();
                    $('#timer-video-descripcion').hide();
                    $("#timer-seconds").text('45');
                    $("#timer-seconds").removeClass('text-red');
                    $('#gum').removeClass('borde-rojo-2x');
                    buttonRecord.innerText = 'Comenzar';
                    buttonRecord.style.display = 'none';
                    clearInterval(tiempo_corriendo);
                    tiempo.segundo = 45;
                }
            }
            $('#modal_pregunta').modal('hide');
        }
    }

    $(function () {
        $("#btnCerrar").on('click', function (e) {
            e.preventDefault();
            //console.log('antes de verificar');
            verificar_video_ir();
        });
    });
</script>
