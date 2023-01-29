const init = () => {
    let blobVideo = null;

    //Define the swal toast
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    const ToastNoTime = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true
    });

    const tieneSoporteUserMedia = () => !!(navigator.mediaDevices.getUserMedia)

    if (typeof MediaRecorder === 'undefined' || !tieneSoporteUserMedia())
        return Toast.fire({ icon: 'error', title: 'Tu navegador web no cumple los requisitos; por favor, actualiza a un navegador como Firefox o Google Chrome. Si estas en iOS puede que no soporte la captura de audio y video.' });

    // Declaración de elementos del DOM
    const $dispositivosDeAudio  = document.querySelector("#dispositivosDeAudio"),
          $dispositivosDeVideo  = document.querySelector("#dispositivosDeVideo"),
          $duracion             = document.querySelector("#duracion"),
          $video                = document.querySelector("#video"),
          $btnComenzarGrabacion = document.querySelector("#btnComenzarGrabacion"),
          $btnDetenerGrabacion  = document.querySelector("#btnDetenerGrabacion"),
          $btnGuardarGrabacion  = document.querySelector("#btnGuardarGrabacion"),
          $audioQuestion        = document.querySelector('#audioBox');

    // Algunas funciones útiles
    const limpiarSelect = elemento => {
        for (let x = elemento.options.length - 1; x >= 0; x--) {
            elemento.options.remove(x);
        }
    }

    const segundosATiempo = numeroDeSegundos => {
        let horas = Math.floor(numeroDeSegundos / 60 / 60);
        numeroDeSegundos -= horas * 60 * 60;

        let minutos = Math.floor(numeroDeSegundos / 60);
        numeroDeSegundos -= minutos * 60;

        numeroDeSegundos = parseInt(numeroDeSegundos);
        
        if (horas < 10) horas = "0" + horas;
        if (minutos < 10) minutos = "0" + minutos;
        if (numeroDeSegundos < 10) numeroDeSegundos = "0" + numeroDeSegundos;

        if (numeroDeSegundos >= tiempoMaxResp) detenerGrabacion();

        return `${horas}:${minutos}:${numeroDeSegundos}`;
    };

    // Variables "globales"
    let tiempoInicio, mediaRecorder, idIntervalo;
    
    const refrescar = () => {
        $duracion.textContent = segundosATiempo((Date.now() - tiempoInicio) / 1000);
    }

    // Consulta la lista de dispositivos de entrada de audio y llena el select
    const llenarLista = () => {
        navigator.mediaDevices.enumerateDevices().then(dispositivos => {
            limpiarSelect($dispositivosDeAudio);
            limpiarSelect($dispositivosDeVideo);

            dispositivos.forEach((dispositivo, indice) => {
                if (dispositivo.kind === "audioinput") {
                    const $opcion = document.createElement("option");
                    // Firefox no trae nada con label, que viva la privacidad
                    // y que muera la compatibilidad
                    $opcion.text = dispositivo.label || `Micrófono ${indice + 1}`;
                    $opcion.value = dispositivo.deviceId;
                    $dispositivosDeAudio.appendChild($opcion);
                } else if (dispositivo.kind === "videoinput") {
                    const $opcion = document.createElement("option");
                    // Firefox no trae nada con label, que viva la privacidad
                    // y que muera la compatibilidad
                    $opcion.text = dispositivo.label || `Cámara ${indice + 1}`;
                    $opcion.value = dispositivo.deviceId;
                    $dispositivosDeVideo.appendChild($opcion);
                }
            })
        })
    };

    // Ayudante para la duración; no ayuda en nada pero muestra algo informativo
    const comenzarAContar = () => {
        tiempoInicio = Date.now();
        idIntervalo = setInterval(refrescar, 500);
    };

    // Comienza a grabar el audio con el dispositivo seleccionado
    const comenzarAGrabar = () => {
        if (!$dispositivosDeAudio.options.length) return alert("No hay micrófono");
        if (!$dispositivosDeVideo.options.length) return alert("No hay cámara");

        // No permitir que se grabe doblemente
        if (mediaRecorder) return Toast.fire({ icon: 'info', title: 'Ya se está grabando.' });

        navigator.mediaDevices.getUserMedia({
            audio: {
                deviceId: $dispositivosDeAudio.value, // Indicar dispositivo de audio
            },
            video: {
                deviceId: $dispositivosDeAudio.value, // Indicar dispositivo de vídeo
            }
        })
        .then(stream => {
            // Poner stream en vídeo
            $video.srcObject = stream;
            $video.play();

            // Comenzar a grabar con el stream
            mediaRecorder = new MediaRecorder(stream);
            mediaRecorder.start();
            comenzarAContar();

            //Comienza a hablar después de un 1s
            setTimeout(function () {
                //speechText();
                $audioQuestion.play();
            }, 1000);

            //Habilita botón después de 5s
            setTimeout(function () {
                $btnGuardarGrabacion.disabled = false;
            }, tiempoBotonAceptar*1000);

            // En el arreglo pondremos los datos que traiga el evento dataavailable
            const fragmentosDeAudio = [];
        
            // Escuchar cuando haya datos disponibles
            mediaRecorder.addEventListener("dataavailable", evento => {
                // Y agregarlos a los fragmentos
                fragmentosDeAudio.push(evento.data);
            });

            // Cuando se detenga (haciendo click en el botón) se ejecuta esto
            mediaRecorder.addEventListener("stop", () => {
                // Pausar vídeo
                $video.pause();
                
                // Detener el stream
                stream.getTracks().forEach(track => track.stop());
                
                // Detener la cuenta regresiva
                detenerConteo();

                // Convertir los fragmentos a un objeto binario
                blobVideo = new Blob(fragmentosDeAudio);
            });
        })
        .catch(error => {
            // Aquí maneja el error, tal vez no dieron permiso
            console.log(error)
        });
    };

    const detenerConteo = () => {
        clearInterval(idIntervalo);
        tiempoInicio = null;
        $duracion.textContent = "";
    }

    const detenerGrabacion = () => {
        if (!mediaRecorder) return Toast.fire({ icon: 'info', title: 'No se está grabando' });
        mediaRecorder.stop();

        $audioQuestion.pause();
        mediaRecorder = null;
        //$btnGuardarGrabacion.disabled = false;
    };

    //Guardar video
    const saveVideo = () => {
        const formData = new FormData();

        // Enviar el BinaryLargeObject con FormData
        formData.append('video', blobVideo);

        var tokenvalue = $('meta[name="token"]').attr('content');
        var contrato   = $('input[name="contrato_id"]').val();
        var pregunta   = $('input[name="pregunta_id"]').val();
        var user   = $('input[name="user_id"]').val();
    
        formData.append('_token', tokenvalue);
        formData.append('contrato_id', contrato);
        formData.append('pregunta_id', pregunta);
        formData.append('user_id', user);
        formData.append('nro_pregunta', nroPregunta);
        formData.append('cantidad_preguntas', cantidadPreguntas);

        $.ajax({
            type: 'POST',
            data: formData,
            url: routeSave,
            processData: false,
            contentType: false,
            beforeSend: function(){
                ToastNoTime.fire({
                    icon: 'info',
                    title: 'Guardando video y validando información ...'
                });

                $btnGuardarGrabacion.disabled = true;
            },
            success: function (response) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Video guardado correctamente.',
                    showConfirmButton: true
                }).then((result) => {
                    if (result.value) {
                        if (nroPregunta == cantidadPreguntas) {
                            window.location.href = dashboardRedir
                        }else{
                            window.location.reload(true);
                        }
                    }
                })
            },
            error:function(response){ 
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error guardando video, intenta nuevamente.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    };

    /* Configuración para voz
        /* Seleccionar estos idiomas por defecto, en caso de que existan */
        const IDIOMAS_PREFERIDOS = ["es-MX", "es-US", "es-ES", "es_US", "es_ES", "es-419"];

        let posibleIndice = 0, vocesDisponibles = [];

        const $voces = document.querySelector("#voiceSpeech");

        // Función que pone las voces dentro del select
        const cargarVoces = () => {
            if (vocesDisponibles.length > 0) {
                console.log("No se cargan las voces porque ya existen: ", vocesDisponibles);
                return;
            }

            vocesDisponibles = speechSynthesis.getVoices();
            //console.log({ vocesDisponibles })

            posibleIndice = vocesDisponibles.findIndex(voz => IDIOMAS_PREFERIDOS.includes(voz.lang));
            
            if (posibleIndice === -1)
                posibleIndice = 0;
                vocesDisponibles.forEach((voz, indice) => {
                    const opcion = document.createElement("option");
                    opcion.value = indice;
                    opcion.innerHTML = voz.name;
                    opcion.selected = indice === posibleIndice;
                    $voces.appendChild(opcion);
                });
        };

        // Si no existe la API, lo indicamos
        if (!'speechSynthesis' in window) return alert("Lo siento, tu navegador no soporta esta tecnología");

        // No preguntes por qué pongo esto que se ejecuta dos veces
        // en determinados casos, solo así funciona en algunos casos
        cargarVoces();

        // Si hay evento, entonces lo esperamos
        if ('onvoiceschanged' in speechSynthesis) {
            speechSynthesis.onvoiceschanged = function () {
                cargarVoces();
            };
        }

        /*const speechText = () => {
            let mensaje = new SpeechSynthesisUtterance();

            mensaje.voice = vocesDisponibles[$voces.value];
            mensaje.volume = 2;
            mensaje.rate = 1;
            mensaje.text = questionContent;
            mensaje.pitch = 1;

            speechSynthesis.speak(mensaje);
        }*/
    /* Fin voz */

    $btnComenzarGrabacion.addEventListener('click', comenzarAGrabar);

    //$btnDetenerGrabacion.addEventListener('click', detenerGrabacion);
    $btnGuardarGrabacion.addEventListener('click', function () {
        detenerGrabacion();

        setTimeout(function () {
            saveVideo();
        }, 2000);
    });

    // Cuando ya hemos configurado lo necesario allá arriba llenamos la lista
    llenarLista();

    //Cancelar contrato
    const $btnCancelarContrato = document.querySelector('#btnCancelarContrato');
    const $btnSendCancel = document.querySelector('#btnSendCancel');

    const $observationField = document.querySelector('#observacion_cancelacion');
    var tokenvalue = $('meta[name="token"]').attr('content');

    const $boxMsg = document.querySelector('.invalid-feedback');
    $boxMsg.style.display = 'none';

    const cancelContract = () => {
        Swal.fire({
            title: '¿Estas seguro/a?',
            text: "Esta acción es irreversible.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Si, cancelar',
            cancelButtonText: 'No, continuar'
        }).then((result) => {
            if (result.value) {
                $('#observeModal').modal('show');
            }
        });
    }

    const sendCancelation = () => {
        if ($observationField.value == '') {
            $observationField.classList.add('is-invalid')
            $boxMsg.style.display = 'initial'

            setTimeout(() => {
                $observationField.classList.remove('is-invalid');
                $boxMsg.style.display = 'none';
            }, 3000)
        }else{
            $.ajax({
                type: 'POST',
                data: {
                    _token : tokenvalue,
                    user_id : userId,
                    req_id : reqId,
                    contrato_id : contratoId,
                    observacion : $observationField.value
                },
                url: routeCancel,
                beforeSend: function() {
                    ToastNoTime.fire({
                        icon: 'info',
                        title: 'Validando y guardando ...'
                    });
                },
                success: function(response) {
                    if(response.success == true){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Contrato cancelado.',
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            window.location.href = dashboardRedir
                        }, 1000)
                    }
                }
            });
        }
    }

    $btnCancelarContrato.addEventListener('click', () => {
        cancelContract()
    });

    $btnSendCancel.addEventListener('click', () => {
        sendCancelation()
    });
}

// Esperar a que el documento esté listo...
document.addEventListener('DOMContentLoaded', init);