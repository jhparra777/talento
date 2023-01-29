function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function(e) {
            $('.image-upload-wrap').hide();
            $('#grant-formats-msg').hide()

            $('.file-upload-image').attr('src', e.target.result);
            $('.file-upload-content').show();

            document.querySelector('#video-name').textContent = input.files[0].name

            if (input.files[0].size >= 62914560) {
                //Video invalido
                document.querySelector('#upload-video').setAttribute('disabled', 'disabled')

                $.smkAlert({
                    text: 'El tamaño del archivo supera el máximo permitido. <b>Máx 60 MB.</b>',
                    type: 'danger'
                });
            }else {
                document.querySelector('#upload-video').removeAttribute('disabled')
            }
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload();
    }
}

function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
    $('#grant-formats-msg').show()
}

$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
})

$('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
})

function updateProgress(oEvent) {
    if (oEvent.lengthComputable) {
        var percentComplete = oEvent.loaded / oEvent.total * 100;
        $('#progreso_guardado').attr('aria-valuenow', percentComplete.toFixed(0)).css('width', percentComplete.toFixed(0)+'%').html(percentComplete.toFixed(0)+'% completado');
    } else {
        // Unable to compute progress information since the total size is unknown
    }
}

//Capturar evento del botón
document.querySelector('#upload-video').addEventListener('click', (event) => {
    document.querySelector('#upload-video').textContent = 'Subiendo archivo ....'
    document.querySelector('#upload-video').setAttribute('disabled', 'disabled')

    let ruta = 'guardar-video-descripcion'

    let formData = new FormData();
    let tokenvalue = $('meta[name="token"]').attr('content');
    let videoInput = document.querySelector("input[type='file']");

    formData.append('_token', tokenvalue);

    if (typeof videoAdmin !== 'undefined') {
        formData.append('admin_video', true);
        formData.append('user_id', document.querySelector('#userId').value);

        //Asignar ruta de admin
        ruta = routeVideo
        console.log(ruta)
        
        //En la vista admin hay más de un campo file, entonces se itera
        videoInputs = document.querySelectorAll('input[type=file]')

        for(let i = 0; i < videoInputs.length; i++){
            videoInput = videoInputs[2];
        }

        formData.append('video-blob', videoInput.files[0]);
    }else {
        formData.append('video-blob', videoInput.files[0]);
    }

    //
    mensaje_success(`
        Espere mientras se sube el video.
        Por favor no cierre la ventana, ni se mueva de menu mientras se guarda el video.
        <br>
        <div class='progress progress-striped active'>
            <div id='progreso_guardado' class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: 0%'></div>
        </div>
    `);

    $('#progreso_guardado').show();

    const request = new XMLHttpRequest()
    request.upload.addEventListener("progress", updateProgress)
    request.upload.addEventListener("load", () => {
        //Guardado ok
        document.querySelector('#upload-video').innerHTML = `Subida finalizada <i class="fa fa-check-circle" aria-hidden="true"></i>`

    })

    request.onreadystatechange = () => {
        if( request.readyState == 4 ){
            
            switch(request.status){

                case 200:
                    swal("Video perfil", "El video perfil se ha guardado con éxito", "success", {
                        buttons: {
                            ok: {
                                text: "OK",
                                className:'btn btn-success'
                            }
                        }
                    })

                    setTimeout(() => {
                        $('#modal_success').modal('hide');
                        location.reload()
                    }, 2500)
            
                break;
                case 415: //Unsupported Media Type
                        let response = JSON.parse(request.response)
                        swal("Video perfil", response.mensaje_success, "error", {
                            buttons: {
                                ok: {
                                    text: "OK",
                                    className:'btn btn-danger'
                                }
                            }
                        })

                    setTimeout(() => {
                        $('#modal_success').modal('hide');
                        removeUpload();
                    }, 1500)
                break;
                default:

                    swal("Video perfil", "Ha ocurrido un error, intenta de nuevo", "warning", {
                        buttons: {
                            ok: {
                                text: "OK",
                                className:'btn btn-danger'
                            }
                        }
                    })
            
                    setTimeout(() => {
                        $('#modal_success').modal('hide');
                    }, 1500)

            }
        }
    }

    request.upload.addEventListener("error", () => {
        swal("Video perfil", "Ha ocurrido un error, intenta de nuevo", "warning", {
            buttons: {
                ok: {
                    text: "OK",
                    className:'btn btn-danger'
                }
            }
        })

        setTimeout(() => {
            $('#modal_success').modal('hide');
        }, 1500)
    })

    request.open('POST', ruta)
    request.send(formData)

    /*
        fetch('guardar-video-descripcion', {
            method : 'post',
            body : formData,
            headers :{
                'X-CSRF-TOKEN': document.querySelector('meta[name="token"]').getAttribute('content')
            }
        })
        .then(response => {
            //console.log(response)
            if (response.status != 200) {
                swal("Video perfil", "Ha ocurrido un error, intenta de nuevo", "warning", {
                    buttons: {
                        ok: {
                            text: "OK",
                            className:'btn btn-danger'
                        }
                    }
                })
            }else {
                //Guardado ok
                document.querySelector('#upload-video').innerHTML = `Subida finalizada <i class="fa fa-check-circle" aria-hidden="true"></i>`

                swal("Video perfil", "El video perfil se ha guardado con éxito", "success", {
                    buttons: {
                        ok: {
                            text: "OK",
                            className:'btn btn-success'
                        }
                    }
                })

                setTimeout(() => {
                    location.reload()
                }, 2500)
            }
        })
        .catch(error => console.log(error))
    */
})