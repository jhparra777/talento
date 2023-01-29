@extends("admin.layout.master")
@section('contenedor')
    
    <h3>Gestionar Retroalimentación</h3>
    
    <h5 class="titulo1">Información Candidato</h5>

    <input type="hidden" id="candidato_id" value="{{ $candidato->user_id }}">
    <input type="hidden" id="req_id" value="{{ $candidato->requerimiento_id }}">
    <input type="hidden" id="cand_req_id" value="{{ $candidato->requerimiento_candidato_id }}">
    
    <table class="table table-bordered">
        <tr>
            <th>Cedula</th>
            <td>{{$candidato->numero_id}}</td>
            <th>Nombres</th>
            <td>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</td>
        </tr>
        <tr>
            <th>Telefono</th>
            <td>{{$candidato->telefono_fijo}}</td>
            <th>Movil</th>
            <td>{{$candidato->telefono_movil}}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{$candidato->email}}</td>
        </tr>
        <tr>
            <th>Requerimiento</th>
            <td>{{$candidato->requerimiento_id}}</td>
        </tr>
    </table>

    <table class="table table-bordered tbl_info">
        <tr>
            <th>Usuario Grabo</th>
            <th>Fecha Registro Vídeo</th>
            <th>Ultimo Usuario Envió</th>
            <th>Ultima Fecha de Envío</th>
            <th>Observación</th>
            <th>Acciones</th>
        </tr>
        @if(count($retroalimentacion_videos) === 0)
            <tr>
                <td colspan="6">No se han grabado vídeos de retroalimentación</td>
            </tr>
        @endif

        @foreach($retroalimentacion_videos as $ref)
            <tr>
                <td>{{ $ref->usuario_gestiono() }}</td>
                <td>{{ $ref->created_at }}</td>
                <td>{{ $ref->nombre_usuario_envio() }}</td>
                <td>{{ $ref->fecha_enviado }}</td>
                <td>{{ $ref->observacion }}</td>
                <td>
                    {{--<button class="btn btn-xs btn-info" title="Enviar nuevamente por correo"><i class="fa fa-envelope" aria-hidden="true"></i></button>--}}
                    <a class="btn btn-xs btn-success" title="Ver video" href='{{ url("recursos_retroalimentacion/$ref->nombre_archivo") }}' target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </td>
            </tr>
        @endforeach

    </table>
    <div class="row">
        <div class="col-sm-12">
            <button type="button" class="btn btn-warning" id="cambiar_estado">Cambiar Estado</button>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" id="submit_listing_box">
            <h3 class="header-section-form"> 
                <span class='text-danger'> Grabar nueva retroalimentación </span>
            </h3>
            <ul style="text-align: justify; padding: 5%; padding-top: 1%; padding-bottom: 1%; font-size: 1.4rem;">
                <li> Crea el vídeo de retroalimentación de máximo 90 segundos de duración.</li>
                <li> Para iniciar el vídeo dar clic en el botón "Empezar Grabar" y para finalizar en el botón "Terminar Grabar", una vez terminado el vídeo se podrá vizualizar. </li>
            </ul>
            <div class="form-alt">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="row">
                            <div class="form-group col-md-12">
                              <div>
                                  <video class="col-xs-12" id="gum" playsinline  muted autoplay autofocus></video>
                                  <video class="col-xs-12" id="recorded" playsinline loop controls></video>
                                  <br><br><br>
                              </div>
                              <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="observacion" class="col-sm-8 control-label"> Observación <span></span></label>
                               
                                <div class="col-sm-12">
                                  {!! Form::textarea("observacion",null,[
                                    "maxlength" => "2000",
                                    "placeholder" => "Máximo 2000 caracteres",
                                    "class"=>"form-control",
                                    "id"=>"observacion",
                                    "rows"=>"4"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observacion",$errors) !!}</p>
                            </div>
                            <div class="col-sm-12">
                                <div class="row text-center">
                                    <h1 id="countdown"></h1>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 text-center">
                                        <button name="record" type="button" class="btn btn-info" id="record" disabled>Empezar Grabar</button>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <button   name="play" type="button" class="btn btn-info" id="play" disabled style="display: none;">Ver</button>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <button class="btn btn-primary" id="btnGuardar" name="guardar" onclick="uploadToPHPServer()" disabled="true"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                                    </div>
                                </div>
                                <button style="display: none;" name="download" type="button" class="btn btn-info" id="download" disabled>Descargar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<style>
.usar + .slide:after {
    position: absolute;
    content: "NO" !important;
}
.usar:checked + .slide:after {
   content: "SI"  !important;
}
#gum {
  padding: 1px 1px;
  border: #2455e8 2px solid;
  border-top-left-radius: 20px;
  border-bottom-right-radius: 20px;
}
#recorded {
  padding: 1px 1px;
  border: #2455e8 2px solid;
  border-top-left-radius: 20px;
  border-bottom-right-radius: 20px;
}
</style>
<link rel="stylesheet" href='{{ url("bower_components/timeTo/timeTo.css") }}'>
<script src="{{ asset('public/js/timeto.min.js') }}" type="text/javascript"></script>
<script>
    'use strict';
    var detenerGrabacion = '';

    /* globals MediaRecorder */

    $('#recorded').hide();  
    $('#countdown').hide();
    $('#record').on('click', null, function(event) {
        $('#countdown').show();

        $('#countdown').timeTo({
            seconds: 90,
            displayHours: false
        });
        if ($('#record').text() == "Terminar Grabar") {
            $('#countdown').hide();
        }else{
            $('#countdown').show();
            detenerGrabacion = setTimeout('stopRecording()',90000);
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
        //alert(`Your browser can not play ${recordedVideo.src} media clip. event: ${JSON.stringify(ev)}`);
        var mensaje = "Este navegador no soporta la grabacion de vídeo. Por favor prueba con otro navegador.";
        var icon = "warning";
        swal("Atención", mensaje, icon, {
            buttons: {
                ok: { text: "Aceptar",className:'btn btn-warning' }
            },
        }).then((value) => {
            window.location.reload();
        });
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
            //playButton.disabled = false;
            downloadButton.disabled = false;
        }
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

    // window.isSecureContext could be used for Chrome

    const constraints = {
        audio: true,
        video: true
    };

    function handleSourceOpen(event) {
        //console.log('MediaSource opened');
        sourceBuffer = mediaSource.addSourceBuffer('video/webm; codecs="vp8"');
        //console.log('Source buffer: ', sourceBuffer);
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
        recordButton.textContent = 'Terminar Grabar';
        //playButton.disabled = true;
        downloadButton.disabled = true;
        mediaRecorder.onstop = handleStop;
        mediaRecorder.ondataavailable = handleDataAvailable;
        mediaRecorder.start(10); // collect 10ms of data
        //console.log('MediaRecorder started', mediaRecorder);
    }

    function stopRecording() {
        $('#countdown').hide();
        clearTimeout(detenerGrabacion);
        detenerGrabacion = '';
        mediaRecorder.stop();
        recordButton.textContent = 'Empezar Grabar';
        //console.log('Recorded Blobs: ', recordedBlobs);
        recordedVideo.controls = true;
        //playButton.disabled = false;
        downloadButton.disabled = false;

        //Se agrega el vídeo para 
        $('#recorded').show();
        $('#gum').hide();
        const superBuffer = new Blob(recordedBlobs, {type: 'video/webm'});

        recordedVideo.src = window.URL.createObjectURL(superBuffer);
        // workaround for non-seekable vídeo taken from
        // https://bugs.chromium.org/p/chromium/issues/detail?id=642012#c23

        recordedVideo.currentTime = 0;
        $('#btnGuardar').prop('disabled', false);
    }

    function handleSuccess(stream) {
        recordButton.disabled = false;
        console.log('getUserMedia() got stream: ', stream);
        window.stream = stream;
        console.log(window.stream);

        const gumVideo = document.querySelector('video#gum');
        gumVideo.srcObject = stream;
    }

    ///////////////////////FUNCION PARA GUARDAR EL VIDEO //////////////////////////

    function uploadToPHPServer() {
  
        const superBuffer = new Blob(recordedBlobs, {type: 'video/webm'});
        var file = new File([superBuffer], 'msr-' + (new Date).toISOString().replace(/:|\./g, '-') + '.webm', {
            type: 'video/webm'
        });

        //console.log(file);
        // create FormData
        var formData = new FormData();
        formData.append('video-filename', file.name);
        formData.append('video-blob', file);
        var tokenvalue = $('meta[name="token"]').attr('content');
        //console.log(tokenvalue);
        
        formData.append('observacion', $('#observacion').val());
        formData.append('req_id', $('#req_id').val());
        formData.append('candidato_id', $('#candidato_id').val());
        formData.append('cand_req_id', $('#cand_req_id').val());
        formData.append('_token',tokenvalue);

        makeXMLHttpRequest("{{route('admin.guardar_retroalimentacion_video')}}", formData);
        mensaje_success("Espere mientras se sube el vídeo. Por favor no cierre la ventana, ni se mueva de menú mientras se guarda el vídeo.<br><div class='progress progress-striped active'><div class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: 0%'></div></div>");
    }

    function makeXMLHttpRequest(url, data) {
        //console.info(url);
        $('#progressBar').show();
        var request = new XMLHttpRequest();
        request.upload.addEventListener("progress", updateProgress); //Avance de la carga del vídeo
        request.upload.addEventListener("load", transferComplete);   //Al finalizar la carga del vídeo
        request.upload.addEventListener("error", transferFailed);    //Si ocurre un error al guardar el vídeo
        request.upload.addEventListener("abort", transferCanceled);  //Si se cancela el guardar de alguna manera por el usuario
        
        request.onreadystatechange = function() {
            if (request.readyState === 4) {
                var res = JSON.parse(request.response);
                completarRequest(res);
            }
        }

        request.open('POST', url);
        request.send(data);
    }

    function completarRequest(response) {
        $.smkAlert({
            text: 'Espere mientras se envía el correo al candidato.',
            type: 'info',
        });
        $('#modal_success').modal('hide');
        var mensaje = "Se ha guardado con éxito la Retroalimentación, pero ocurrió un problema y no se envió por correo.";
        var icon = "warning";
        if (response.mail_enviado) {
            icon = "success";
            mensaje = "Se ha guardado con éxito la Retroalimentación y se envió por correo!!";
        }
        setTimeout(function(){
            swal("Vídeo Retroalimentación guardado", mensaje, icon, {
                buttons: {
                    ok: { text: "OK",className:'btn btn-success' }
                },
            }).then((value) => {
                window.location.reload();
            });
        }, 2000);
    }

    function transferComplete(evt) {
        setTimeout(function(){
            $.smkAlert({
                text: 'Vídeo Retroalimentación guardado.',
                type: 'success',
            });
        }, 2000);
    }

    function transferFailed(evt) {
        $('#modal_success').hide();
        mensaje_danger("No se pudo guardar el vídeo, intente de nuevo.");
        console.log("An error occurred while transferring the file.");
    }

    function transferCanceled(evt) {
        $('#modal_success').hide();
        mensaje_danger("No se pudo guardar el vídeo, fue cancelado por el usuario.");
        console.log("The transfer has been canceled by the user.");
    }

    // progress on transfers from the server to the client (downloads)
    function updateProgress (oEvent) {
    if (oEvent.lengthComputable) {
        var percentComplete = oEvent.loaded / oEvent.total * 100;
        //console.log(percentComplete);

        $('.progress-bar').attr('aria-valuenow', percentComplete.toFixed(0)).css('width', percentComplete.toFixed(0)+'%').html(percentComplete.toFixed(0)+'% completado');
        } else {
        // Unable to compute progress information since the total size is unknown
        }
    }

    $('#modal_success').on('hidden.bs.modal', function (e) {
        $('.progress-bar').attr('aria-valuenow', 0).css('width', '0%').html('0% completado');
    })
   
    function handleError(error) {
        console.log('navigator.getUserMedia error: ', error);
    }

    navigator.mediaDevices.getUserMedia(constraints).then(handleSuccess).catch(handleError);

    $(function (){
        var ruta = "{{route('admin.gestion_requerimiento',$candidato->requerimiento_id)}}";

        $("#cambiar_estado").on("click", function () {
            $.ajax({
                type: "POST",
                data: "ref_id={{$candidato->ref_id}}",
                url: "{{route('admin.cambiar_estado_view')}}",
                success: function (response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        });

        $(document).on("click", "#guardar_estado", function () {
            $.ajax({
                data: $("#fr_cambio_estado").serialize(),
                url: "{{route('admin.guardar_cambio_estado')}}",
                success: function (response) {
                    if(response.success) {
                      
                      mensaje_success("Estado actualizado.. Espere sera redireccionado");
                       // window.location.href = "{{ route('admin.valida_documentos')}}";
                      setTimeout(function(){
                        location.href=ruta; }, 3000);

                    }else{
                     $("#modal_peq").find(".modal-content").html(response.view);
                    }

                }
            });
        });
    })

</script>
@stop
