@extends("home.layout.master")
@section('content')
  <!-- Header Section End -->    
    <section id="counter">
      <div class="container">
        <div class="row">
          {!!Form::token()!!}
          <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    <h2 class="product-title"> <i class="fa fa-video-camera"></i> Video entrevista </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route("home") }}">
                                <i class="ti-home"></i> Inicio
                            </a>
                        </li>
                        <li class="current">Video entrevista </li>
                    </ol>
                </div>
            </div>
         
        </div>
      </div>
    </section>
    <!-- end intro section -->
    <!-- Find Job Section Start -->
    <section id="work" name="work" class="find-job section">
      <div class="container">
        <h5 class="section-title">Hola, recuerda que tienes 45 segundos para responder la pregunta. Muchos éxitos!</h5>
        <div class="row">
            
          <div class="col-md-12">
            <div class="job-list">

                <div class="thumb">
                @if(isset(FuncionesGlobales::sitio()->logo))
                    @if(FuncionesGlobales::sitio()->logo != "")
                        <img alt="logo" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}">
                    @else
                        <img alt="logo" src="{{url('img/logo.png')}}">
                    @endif
                @else
                    <img alt="logo" src="{{url('img/logo.png')}}">
                @endif
              </div>
              
              <div class="job-list-content">
                <br>
                                    <div>
    <table class="table table-bordered">
        <thead>
            <tr>
                
               </tr>
        </thead>
        <tbody>
            
            <tr>
               
               <td><strong>1) </strong>¿Cúal ha sido tu mayor logro profesional?
              {{--  @if($datos_temporales === true) --}}
               <td  style="text-align: center;"><a class="btn btn-info responder_pregunta" name="responder" id="responder" data-numero_id ="{{$numero_id}}" >Responder Pregunta</a></td>
          {{--      @endif
            <td  style="text-align: center;"><button class="btn btn-info responder_pregunta" name="responder" id="responder" disabled>Responder Pregunta</button></td> --}}
              
            </tr>
          
        </tbody>
    </table>
</div> 

                   

                   
                  </div>
                </div>
              </div>
            </div>

          </div>
            

  
</div>
          <div class="col-md-12">
            <div class="showing pull-left">
             
            </div>                    
          </div>
      </div>
    </section>

    <!-- Find Job Section End -->
    <!-- Counter Section Start -->
   
    <!-- Counter Section End -->

    <!-- Infobox Section Start -->
   
    <!-- Infobox Section End -->
<style>
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
<script>
$(function () {
 
$(".responder_pregunta").on("click", function() {

          //alert('lol');
            var pregu_id = $(this).data("pregunta_id");
            var numero_id = $(this).data("numero_id");
            $.ajax({
                type: "POST",
                data:"pregu_id_id="+pregu_id + "&numero_id=" + numero_id,
                url: "{{route('home.responder_pregunta_entre_prueba')}}",
                success: function(response) {
                    $("#modal_peque").find(".modal-content").html(response);
                    $("#modal_peque").modal("show");
                }
            });
        });



  });
/*
*  Copyright (c) 2015 The WebRTC project authors. All Rights Reserved.
*
*  Use of this source code is governed by a BSD-style license
*  that can be found in the LICENSE file in the root of the source
*  tree.
*/

// This code is adapted from
// https://rawgit.com/Miguelao/demos/master/mediarecorder.html

'use strict';

/* globals MediaRecorder */

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
    
    
    formData.append('_token',tokenvalue);

    makeXMLHttpRequest("{{route('guardar_video_descripcion')}}", formData);
    mensaje_success("Espere mientras se sube el video, se le abrirá otra ventana confirmandole que se ha guardado.");
    //location.reload();
}

function makeXMLHttpRequest(url, data) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
          mensaje_success("Se ha guardado el video con éxito!");

        }else{

          mensaje_success("No se pudo guardar el video , intente de nuevo.");
        }
    };
     
    request.open('POST', url);
    request.send(data);

    
}
   
function handleError(error) {
  console.log('navigator.getUserMedia error: ', error);
}

navigator.mediaDevices.getUserMedia(constraints).then(handleSuccess).catch(handleError);


</script>

@stop