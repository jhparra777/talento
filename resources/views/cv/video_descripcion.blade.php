@extends("cv.layouts.master")

<?php
    $porcentaje=FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
    //$porcentaje=$porcentaje["total"];
?>

@section("menu_candidato")
    @include("cv.includes.menu_candidato")
@endsection

@section('content')

    <div class="col-right-item-container">
        <div class="container-fluid">
            {!! Form::token() !!}

            <div class="col-sm-12" id="submit_listing_box">
                <h3>
                    <i class="fa fa-video-camera"></i> Video Perfil

                    @if($user->video_perfil == true && file_exists("recursos_videoperfil/" . $user->video_perfil))
                        <button  data-user_id="{{ $user->id }}" type="button" class="btn btn-primary btn-sm video_perfil">
                            Video perfil guardado
                        </button>
                    @endif

                    @if(route("home") == "https://komatsu.t3rsc.co")(Obligatorio para el proceso de seleccion: Presentate brevemente dinos que experiencia y expectativas tienes y por que quieres trabajar con nosotros)@endif
                </h3>

                <div class="form-alt">
                    <div class="row">
                        <div class="col-right-item-container">
                            <div class="container-fluid">
                                <div class="col-sm-12">
                                    {{-- <div id="submit_listing_box"> --}}
                                        <h4>
                                            Descríbete brevemente en máximo 45 segundos a través de un video.
                                        </h4>

                                        <div class="form-alt">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div class="alert alert-success instrucciones" role="alert">
                                                        <strong>Nota: </strong>Para iniciar el video dar clic en el botón <strong>"Comenzar"</strong>, para guardar presiona <strong>"Pausar"</strong> y luego en el botón <strong>"Terminar y Guardar"</strong> o una vez terminado el tiempo el video se detendrá y podrás guardar.
                                                    </div>

                                                    <div>
                                                        <div id="img-grabacion"><img src="{{ url('img/grabando.gif') }}"></div>
                                                        <video class="col-xs-12" id="gum" playsinline  muted autoplay autofocus></video>
                                                        <video class="col-xs-12" id="recorded" playsinline loop controls></video>
                                                        <br><br><br>
                                                    </div>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- </div> --}}

                                    {{-- Controles de grabación --}}
                                    <div class="form-row">
                                        <div class="col-md-12 text-center">
                                            <div class="col-md-6 col-md-offset-3">
                                                <div id="timer-video-descripcion">
                                                    <div class="timer-container col-md-6 col-md-offset-3">
                                                        <div>
                                                            <span id="timer-seconds">45</span>Segundos
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 text-center">
                                                <button type="button" class="btn btn-primary m-2" id="iniciar">Comenzar</button>

                                                <button 
                                                    name="record" 
                                                    type="button" 
                                                    class="btn btn-info m-2" 
                                                    id="record" 
                                                    style="display: none;" 
                                                    onclick="grabacion();"
                                                >
                                                    Reanudar
                                                </button>

                                                <button 
                                                    class="btn btn-primary" 
                                                    id="btnGuardar" 
                                                    style="display: none;" 
                                                    onclick="uploadToPHPServer()"
                                                >
                                                    Terminar y Guardar
                                                </button>

                                                <button 
                                                    type="button" 
                                                    class="btn btn-danger m-2" 
                                                    id="cancel" 
                                                    style="display: none;" 
                                                    onclick="cancelar();"
                                                >
                                                    Cancelar
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

            @include('cv.includes.video_perfil._section_subir_video_perfil')

            <div class="col-sm-12 separador"></div>

            <a class="btn btn-warning pull-right" href="{{ route('cv.idiomas') }}" type="button">&nbsp;Siguiente</a>
        </div>
    </div>

    {{-- Upload video css --}}
    <style>
        .video-upload {
            background-color: #ffffff;
            width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        @media (max-width: 991px) {
            .video-upload {
                width: 354px;
            }

            .file-upload-image {
                width: 354px;
            }
        }

        @media (max-width: 500px) {
            .video-upload {
                width: 300px;
            }

            .file-upload-image {
                width: 354px;
            }
        }

        @media (max-width: 440px) {
            .video-upload {
                width: 280px;
            }

            .file-upload-image {
                width: 354px;
            }
        }

        @media (max-width: 400px) {
            .video-upload {
                width: 255px;
            }

            .file-upload-image {
                width: 354px;
            }
        }

        @media (max-width: 340px) {
            .video-upload {
                width: 205px;
            }

            .file-upload-image {
                width: 200px;
            }
        }

        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100% !important;
            height: 100% !important;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-content {
            display: none;
            text-align: center;
        }

        /* Drag and drop zone */
        .image-upload-wrap {
            margin-top: 20px;
            border: 4px dashed #b3b3b3;
            position: relative;
            transition: all 300ms ease;
        }

        .image-dropping, .image-upload-wrap:hover {
            background-color: #b3b3b3;
            border: 4px dashed #ffffff;
        }

        .drag-text {
            font-weight: 500;
            font-size: 1.5rem;
            text-transform: uppercase;
            color: black;
            padding: 60px 0;
        }
        
        /* Preview video */
        .file-upload-image {
            max-width: 480px;
            max-height: 320px;
            margin: auto;
            padding: 20px;
        }
    </style>

    <style>
        #gum {
            padding: 1px 1px;
            border: #2455e8 2px solid;
            border-radius: 20px;
        }

        #recorded {
            padding: 1px 1px;
            border: #2455e8 2px solid;
            border-radius: 20px;
        }

        #video-guardado {
            padding: 1px 1px;
            border: #2455e8 2px solid;
            border-radius: 20px;
        }

        .swal-button--catch {
            background-color: indianred;
        }

        .swal-button--defeat {
            background-color: forestgreen;
        }

        .borde-rojo-2x {
            border: #961212 2px solid !important;
            border-radius: 20px !important;
        }

        .text-red {
            color: #961212;
        }

        #img-grabacion {
            position: absolute;
            margin: 10px;
            display: none;
            z-index: 1;
        }

        #timer-video-descripcion {
            display: none;
        }

        #timer-video-descripcion .timer-container{
            display:table;
            color:#0061f2;
            font-weight:bold;
            text-align:center;
            text-shadow:1px 1px 4px #999;
        }

        #timer-video-descripcion .timer-container div span{
            font-size:40px;
            padding:10px;
        }

        .m-2 {
            margin: 0.5rem;
        }

        .text-center {
            text-align: center;
        }
    </style>

    {{-- Upload video js --}}
    <script src="{{ asset('js/cv/video-perfil/cargar-video-perfil.js') }}"></script>

    <script type="text/javascript">
        unsaved = false;
        let video = document.querySelector('#gum');
        $('#recorded').hide();
        let redireccion = 'reload';
        let partes = [];
        let mediaRecorder;
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
            $.smkProgressBar({
                element:'body',
                status:'start',
                bgColor: '#000',
                barColor: '#fff',
                content: 'Se solicitarán los permisos para acceder a su cámara y micrófono. Por favor presione "Permitir" para que pueda grabar su video perfil.'
            });
            navigator.mediaDevices.getUserMedia({audio: true, video: true})
                .then(comenzar)
                .catch(procesarErrores);
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
                if ( buttonRecord.innerText === 'Reanudar') {
                    if (mediaRecorder.state === 'paused') {
                        mediaRecorder.resume();
                    } else {
                        mediaRecorder.start();
                    }
                } else {
                    try {
                        mediaRecorder = new MediaRecorder(window.stream, options);

                        partes = null;
                        partes = [];

                        mediaRecorder.ondataavailable = function(e) {
                            //console.log(e.data);
                            partes.push(e.data);
                        }

                        mediaRecorder.onstop = function(e) {
                            console.log('se ha detenido el video');
                        }
                    } catch (e) {
                        //console.error(`Exception while creating MediaRecorder: ${e}`);
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
                        $('#cancel').hide();
                        if (mediaRecorder.state === 'paused' || mediaRecorder.state === 'recording') {
                            mediaRecorder.stop();
                            $('#img-grabacion').hide();
                        }
                        $('#btnGuardar').hide();
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
            var tokenvalue = $('meta[name="token"]').attr('content');

            formData.append('_token', tokenvalue);

            makeXMLHttpRequest("{{ route('guardar_video_descripcion') }}", formData);
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
            setTimeout(function() {
                $('#modal_success').modal('hide');
                swal("Video Perfil guardado", "Se ha guardado con éxito", "info", {
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
            mensaje_danger("No se pudo guardar el video, intente de nuevo.");
            //console.log("An error occurred while transferring the file.");
        }

        function transferCanceled(evt) {
            $('#modal_success').hide();
            mensaje_danger("No se pudo guardar el video, fue cancelado por el usuario.");
            //console.log("The transfer has been canceled by the user.");
        }

        // progress on transfers from the server to the client (downloads)
        function updateProgress (oEvent) {
            if (oEvent.lengthComputable) {
                var percentComplete = oEvent.loaded / oEvent.total * 100;
                $('#progreso_guardado').attr('aria-valuenow', percentComplete.toFixed(0)).css('width', percentComplete.toFixed(0)+'%').html(percentComplete.toFixed(0)+'% completado');
            } else {
                // Unable to compute progress information since the total size is unknown
            }
        }

        $('#modal_success').on('hidden.bs.modal', function (e) {
            $('#progreso_guardado').attr('aria-valuenow', 0).css('width', '0%').html('0% completado');
        })

        $(".video_perfil").on("click", function() {
            var user_id = $(this).data("user_id");
            $.ajax({
                type: "POST",
                data: {user_id: user_id},
                url: "{{route('ver_video_perfil')}}",
                success: function(response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        function verificar_video_ir(_href) {
            if (unsaved){
                swal({
                    title: 'Ha grabado un video y no lo ha guardado. ¿Desea guardar antes de continuar?',
                    //title: 'Atención',
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
                        redireccion = _href;
                        uploadToPHPServer();
                    } else if (respuesta == 'ir') {
                        if (_href == 'reload') {
                            location.reload();
                        } else {
                            location.href = _href;
                        }
                    }
                });
            } else {
                if (_href == 'reload') {
                    location.reload();
                } else {
                    location.href = _href;
                }
            }
        }

        $(function () {
            $('#nav_menu_list').find('a:not([href*="#"])').click(function (e) {
                e.preventDefault();
                verificar_video_ir(this.href);
            });

            $('.dashboard_nav_item').find('a:not([href*="#"])').click(function (e) {
                e.preventDefault();
                verificar_video_ir(this.href);
            });
        });
    </script>
@stop
