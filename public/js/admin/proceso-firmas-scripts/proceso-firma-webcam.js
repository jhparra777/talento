// let procesoFirmaPictures = JSON.parse(localStorage.getItem('procesoFirmaPictures'))

const webcamElement = document.getElementById('webcam');
const canvasElement = document.getElementById('canvas');
const webcam = new Webcam(webcamElement, 'user', canvasElement);

let camaraStatus = true

const guardarFoto = (picture) => {
    $.ajax({
        url: fotoRoute,
        type: "POST",
        data:{
            foto: picture,
            user_id: userId,
            req_id: reqId,
            camara: camaraStatus
        },
        beforeSend: function() {
            // Swal.fire({
            //     icon: 'info',
            //     title: 'Validando información, espera un momento ...',
            //     toast: true,
            //     position: 'top-end',
            //     showConfirmButton: false,
            //     timerProgressBar: true,
            // })
        },
        success: function(response) {
            if (response.success) {
                // console.log('ok')
            }
        }
    })
}

function takePicture() {
    document.querySelector('#webcamBox').removeAttribute('hidden')

    webcam.start()
    .then(result =>{
        // console.log("webcam started");
    })
    .catch(err => {
        console.log(err);

        alert('Debes tener una cámara web disponible para continuar con el proceso de firma.')

        camaraStatus = false

		setTimeout(() => {
			location.reload()
		}, 2000)
    });

    //Toma la foto
    setTimeout(() => {
        let picture = webcam.snap();

        guardarFoto(picture)
    }, 4000)

    setTimeout(function() {
        document.querySelector('#webcamBox').setAttribute('hidden', true)

        webcam.stop();
    }, 5000)
}

function stopWebcam() {
    webcam.stop();
}