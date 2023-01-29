<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>Pregunta Idioma</strong></h4>
</div>
<div  class="modal-body">

    <div class="row">

        <div class="col-md-12">
            
            <div style="margin: auto; text-align: center;">
                <video style="width: 80%; height: 80%;" id="gum" playsinline  muted autoplay autofocus></video>
                <video id="recorded" type="video/webm"  autoplay="false"  controls ></video>
            </div>

            <h4 style="text-align: center; display: none;" id="pregunta">{{ $pregunta->descripcion }}</h4>

        </div>

        <button style="visibility: hidden;" class="btn btn-sm" id="guardar" name="guardar" onclick="uploadToPHPServer()">Guardar</button>

        <div class="col-md-12" style="text-align: center;">
            <h1 id="countdown"></h1> 

            <button name="record" class="btn btn-info btn-sm" id="record" disabled >Empezar Grabar</button>

            <button style="display: none;" name="play" type="button" class="btn btn-info" id="play" disabled>Ver</button>

            <button style="display: none;" name="download" type="button" class="btn btn-info" id="download" disabled>Descargar</button>

        </div>        

    </div>

    <script>

        'use strict';

        $('#recorded').hide();
        $('#countdown').hide();

        var contador;

        //Evento de botón Empezar Grabar
        $('#record').on('click', null, function(event) {
        
            $('#countdown').show();
            $('#pregunta').show("slow");
            $('#countdown').timeTo({
                seconds: 45,
                displayHours: false
            });

            contador = setTimeout( function(){
                stopRecording();
            },45000);

            if ($('#record').text() == "Terminar Grabar") {
                $('#countdown').hide();
            }else{
                $('#countdown').show();
            }

        });

        const mediaSource = new MediaSource();
        mediaSource.addEventListener('sourceopen', handleSourceOpen, false);
        let mediaRecorder;
        let recordedBlobs;
        let sourceBuffer;

        const recordedVideo = document.querySelector('video#recorded');
        recordedVideo.addEventListener('error', function(ev) {
            console.error('MediaRecording.recordedMedia.error()');
            alert(`Your browser can not play ${recordedVideo.src} media clip. event: ${JSON.stringify(ev)}`);
        }, true);

        const recordButton = document.querySelector('button#record');
        recordButton.addEventListener('click', () => {
        
            $('#recorded').hide();
            $('#gum').show();
        
            if (recordButton.textContent === 'Empezar Grabar') {
                startRecording();
            } else {
                stopRecording();
                recordButton.textContent = 'Empezar Grabar';
                playButton.disabled = false;
                downloadButton.disabled = false;
                //uploadToPHPServer();
            }

        });

        const playButton = document.querySelector('button#play');
        playButton.addEventListener('click', () => {
            $('#recorded').show();
            $('#gum').hide();
        
            const superBuffer = new Blob(recordedBlobs, {type: 'video/webm'});

            recordedVideo.src = window.URL.createObjectURL(superBuffer);
        
            recordedVideo.addEventListener('loadedmetadata', () => {
                if (recordedVideo.duration === Infinity) {
                    recordedVideo.currentTime = 1e101;
                    recordedVideo.ontimeupdate = function() {
                        recordedVideo.currentTime = 0;
                        recordedVideo.ontimeupdate = function() {
                            delete recordedVideo.ontimeupdate;
                        };
                    };
                }
            });
        });

        const downloadButton = document.querySelector('button#download');
        downloadButton.addEventListener('click', () => {
            const blob = new Blob(recordedBlobs, {type: 'video/webm'});
            const url = window.URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'Video_perfil.webm';
            document.body.appendChild(a);
            a.click();
            setTimeout(() => {
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }, 100);
        });

        const constraints = {
            audio: true,
            video: true
        };

        function handleSourceOpen(event) {
            console.log('MediaSource opened');
            sourceBuffer = mediaSource.addSourceBuffer('video/webm; codecs="vorbis,vp8"');
            console.log('Source buffer: ', sourceBuffer);
        }

        function handleDataAvailable(event) {
            if (event.data && event.data.size > 0) {
                recordedBlobs.push(event.data);
            }
        }

        function handleStop(event) {
            console.log('Recorder stopped: ', event);
        }

        function startRecording() {
            recordedBlobs = [];
            let options = {mimeType: 'video/webm;codecs=vp9'};
      
            if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                console.log(options.mimeType + ' is not Supported');
                options = {mimeType: 'video/webm;codecs=vp8'};

                if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                    console.log(options.mimeType + ' is not Supported');
                    options = {mimeType: 'video/webm'};
            
                    if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                        console.log(options.mimeType + ' is not Supported');
                        options = {mimeType: ''};
                    }
                }
            }

            try {
                mediaRecorder = new MediaRecorder(window.stream, options);
            } catch (e) {
                console.error(`Exception while creating MediaRecorder: ${e}`);
                alert(`Exception while creating MediaRecorder: ${e}. mimeType: ${options.mimeType}`);
                return;
            }

            console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
            
            //Renombra botón
            recordButton.textContent = 'Terminar Grabar';
            playButton.disabled = true;
            downloadButton.disabled = true;
            mediaRecorder.onstop = handleStop;
            mediaRecorder.ondataavailable = handleDataAvailable;
            mediaRecorder.start(10); // collect 10ms of data
            console.log('MediaRecorder started', mediaRecorder);
        }

        function stopRecording() {
            mediaRecorder.stop();
            recordButton.textContent = 'Empezar Grabar';
            console.log('Recorded Blobs: ', recordedBlobs);
            recordedVideo.controls = true;
            //playButton.disabled = true;
            //downloadButton.disabled = false;
            
            $('#guardar').trigger('click');
        }

        function handleSuccess(stream) {
            recordButton.disabled = false;
            console.log('getUserMedia() got stream: ', stream);
            window.stream = stream;
            console.log(window.stream);

            const gumVideo = document.querySelector('video#gum');
            gumVideo.srcObject = stream;
        }

        ////////////////////FUNCION PARA GUARDAR EL VIDEO ///////////////////////

        function uploadToPHPServer() {
            const superBuffer = new Blob(recordedBlobs, {type: 'video/webm'});
            var file = new File([superBuffer], 'msr-' + (new Date).toISOString().replace(/:|\./g, '-') + '.webm', {
                type: 'video/webm'
            });

            console.log(file);

            // create FormData
            var formData = new FormData();
            formData.append('video-filename', file.name);
            formData.append('video-blob', file); 
            formData.append('preg_app_id','{{ $pregunta->id }}');
            formData.append('req_id','{{ $req_id }}');
            formData.append('cargo_id','{{ $cargo_id }}');
            formData.append('_token','{{ csrf_token() }}');

            saveVideo(formData);
        }

        function saveVideo(data) {

            var preguntaRespCount = {{ $preguntaRespCount }};
            var preguntaCount = {{ $preguntaCount }};

            $.ajax({
                data: data,
                url: "{{ route('home.guardar_respuestas_prueba_idioma') }}",
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $("#loading").html("<img src='http://www.fundacionprotejer.com/wp-content/plugins/filtros/img/loading.gif' width='70' height='110'>");
                },
                success: function (response) {
                    //console.log(response.videoBs64);                    
                    $("#modal_gr").hide();
                    $("#modal_success").find(".modal-body").html('<p>Se ha guardado la respuesta con exito.</p>');
                    $('#modal_success').show();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error:function(response)
                {        
                    alert("¡Advertencia! , Problemas al guardar el video, intentar nuevamente.");
                }
            });
        }
       
        function handleError(error) {
            console.log('navigator.getUserMedia error: ', error);
        }
        
        navigator.mediaDevices.getUserMedia(constraints).then(handleSuccess).catch(handleError);
    </script>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>