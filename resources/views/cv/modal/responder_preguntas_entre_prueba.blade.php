
<!-- Inicio contenido principal -->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
          <div class="alert alert-success" role="alert">
                                            <strong>Nota: </strong>Para iniciar el video  dar clic en el botón "Empezar Grabar" y para finalizar en el botón "Terminar Grabar", una vez terminado el video se puede ver dando clic en el botón "Ver".
                                          </div>    
   <br>
 <div class="clearfix"></div> 
    <div class="form-alt">
                    <div class="row">
                       <div class="col-right-item-container">
                        <div class="container-fluid">
                            <div class="col-sm-12">
                                <div id="submit_listing_box">
                                    <h3>
                                        {!! Form::hidden('pregu',$pregu_id , []) !!}
                                         {!! Form::hidden('numero_id',$numero_id , []) !!}

                                    </h3>
                                    <div class="form-alt">
                                        <div class="row">
                                           <div class="form-group col-md-12">
                                         
                            
                            <div>
                                <video   class="col-xs-12" id="gum" playsinline  muted autoplay autofocus></video>
                                <video class="col-xs-12" id="recorded" playsinline loop controls></video>
                        
                                <br><br><br>
                               
                            </div>
                            <br>
                               {{--  <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            <label>
                                Video Perfil
                                <span>
                                </span>
                            </label>
                            {!! Form::file("video-blob",["class"=>"form-control", "id"=>"video-blob" ,"name"=>"video-blob" ]) !!}
                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("video-blob",$errors) !!}
                            </p>
                        </div> --}}
            
                        </div>
                                        </div>
                                    </div>
                                </div>
                                            <div style="text-align: center;" class="col-sm-12">
           

                                    {{-- <h1 id="numero">45</h1> --}}
                                    <button   onclick="setTimeout('stopRecording()',45000);" name="record" type="button" class="btn btn-info" id="record" disabled >Empezar Grabar</button> 
                                    <button   name="play" type="button" class="btn btn-info" id="play" disabled>Ver</button>
                                    <button style="display: none;" name="download" type="button" class="btn btn-info" id="download" disabled>Descargar</button>
                                

                                {{--  @if($user->video_perfil ==true)
                                        <a  href="{{asset("recursos_videoperfil/"."$user->video_perfil?".date('His'))}}" class="btn btn-warning" target="_black" >
                                        Video Perfil
                                    </a>
                                @endif --}}
             
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
    <button class="btn btn-primary" id="guardar" name="guardar"  onclick="uploadToPHPServer()"><i class="fa fa-floppy-o"></i>Guardar</button>

</div>

<script>
    $('#recorded').hide();

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
  }
});


 

const playButton = document.querySelector('button#play');
playButton.addEventListener('click', () => {
  $('#recorded').show();
  $('#gum').hide();
  const superBuffer = new Blob(recordedBlobs, {type: 'video/webm'});

 
  
  recordedVideo.src = window.URL.createObjectURL(superBuffer);
//console.log(recordedVideo.src);
  // workaround for non-seekable video taken from
  // https://bugs.chromium.org/p/chromium/issues/detail?id=642012#c23
  recordedVideo.addEventListener('loadedmetadata', () => {
    if (recordedVideo.duration === Infinity) {
      recordedVideo.currentTime = 1e101;
      recordedVideo.ontimeupdate = function() {
        recordedVideo.currentTime = 0;
        recordedVideo.ontimeupdate = function() {
          delete recordedVideo.ontimeupdate;
          recordedVideo.play();


        };
      };
    } else {
      recordedVideo.play();
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

// window.isSecureContext could be used for Chrome

const constraints = {
  audio: true,
  video: true
};

function handleSourceOpen(event) {
  console.log('MediaSource opened');
  sourceBuffer = mediaSource.addSourceBuffer('video/webm; codecs="vp8"');
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
  playButton.disabled = false;
    downloadButton.disabled = false;
  //recordButton.textContent = 'Empezar Grabar';
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

const saveButton = document.querySelector('button#guardar');
function mensaje_success(mensaje) {
    $("#modal_success #texto").html(mensaje);
    $("#modal_success").modal("show");

}
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
    var tokenvalue = $('meta[name="token"]').attr('content');
     //formData.append('preg_entre_id',{{$pregu_id}});
     
     formData.append('numero_id',{{$numero_id}});
    
    
    formData.append('_token',tokenvalue);

    makeXMLHttpRequest("{{route('home.guardar_respuesta_entre_prueba')}}", formData);
    mensaje_success("Espere mientras se sube el video, se le abrirá otra ventana confirmandole que se ha guardado.");
    $("#modal_peque").modal("hide");
    saveButton.disabled = true;

    //location.reload();
}
function makeXMLHttpRequest(url, data) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
          mensaje_success("Se ha guardado el video con éxito!");
           setTimeout("location.reload()'",1000);
        }else{

          mensaje_success("No se pudo guardar el video , intente de nuevo.");
        }
    };
     
    request.open('POST', url);
    request.send(data);

    request
}
   
function handleError(error) {
  console.log('navigator.getUserMedia error: ', error);
}

navigator.mediaDevices.getUserMedia(constraints).then(handleSuccess).catch(handleError);
</script>
