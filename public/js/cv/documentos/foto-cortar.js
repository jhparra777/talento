const webcamElement = document.getElementById('webcam');
const canvasElement = document.getElementById('canvas');
const webcam = new Webcam(webcamElement, 'user', canvasElement);

const cropperImage = document.querySelector('#cropper-image')

let cropper
let picture
let finalPicture = 0

//Start camera
document.querySelector('#start-camera').addEventListener('click', (event) => {
    webcam.start()
	.then(result =>{
		console.log("webcam started")

        event.target.setAttribute('disabled', 'disabled')

        document.querySelector('#stop-camera').removeAttribute('disabled')
        document.querySelector('#take-picture').removeAttribute('disabled')

        //Boxes
        document.querySelector('#foto-croppper-box').setAttribute('hidden', 'hidden')
        document.querySelector('#rotate-box').setAttribute('hidden', 'hidden')

        document.querySelector('#webcam-box').removeAttribute('hidden')

        //Botones
        document.querySelector('#take-picture-box').removeAttribute('hidden')
        document.querySelector('#save-picture-box').setAttribute('hidden', 'hidden')
	})
	.catch(err => {
		console.log(err)
		alert('Debes tener una cámara web disponible para continuar.')

		setTimeout(() => {
			location.reload()
		}, 3000)
	})
})

//Stop camera
document.querySelector('#stop-camera').addEventListener('click', (event) => {
    event.target.setAttribute('disabled', 'disabled')
    document.querySelector('#take-picture').setAttribute('disabled', 'disabled')

    document.querySelector('#start-camera').removeAttribute('disabled')

    setTimeout(() => {
        webcam.stop()
    }, 1000)
})

//Take picture
document.querySelector('#take-picture').addEventListener('click', (event) => {
    event.target.setAttribute('disabled', 'disabled')

    document.querySelector('#stop-camera').setAttribute('disabled', 'disabled')
    document.querySelector('#start-camera').removeAttribute('disabled')

    picture = webcam.snap()

    setTimeout(() => {
        document.querySelector('#webcam-box').setAttribute('hidden', 'hidden')

        document.querySelector('#foto-croppper-box').removeAttribute('hidden')
        document.querySelector('#rotate-box').removeAttribute('hidden')
        cropperImage.src = picture

        initCropper()

        document.querySelector('#take-picture-box').setAttribute('hidden', 'hidden')
        document.querySelector('#save-picture-box').removeAttribute('hidden')

        webcam.stop()
    }, 1500)
})

//Save picture
document.querySelector('#save-picture').addEventListener('click', () => {
    cropper.getCroppedCanvas().toBlob((blob) => {
        finalPicture = blob
    }, 'image/png');

    document.querySelector('#archivo-documento').removeAttribute('required')

    setTimeout(() => {
        document.querySelector('#preview-documento-box').removeAttribute('hidden')
        document.querySelector('#preview-documento').src = cropper.getCroppedCanvas().toDataURL('image/png')

        $('#fotoDocumentoModal').modal('hide')

        cropper.destroy()
    }, 1000)
})

document.querySelector('#flip-camera-box').addEventListener('click', () => {
    webcam.flip()
    webcam.start()
})

//Rotate right
document.querySelector('#rotate-right').addEventListener('click', () => {
    cropper.rotate(45)
    console.log('right')
})

//Rotate left
document.querySelector('#rotate-left').addEventListener('click', () => {
    cropper.rotate(-45)
    console.log('left')
})

const initCropper = () => {
    const image = document.getElementById('cropper-image');
    cropper = new Cropper(image, {
        rotatable: true,
        viewMode: 1
    });
}

//Detener cámara al cerrar modal
$('#fotoDocumentoModal').on('hidden.bs.modal', function (e) {
    webcam.stop()
})

if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
    // true for mobile device
    console.log("mobile device");
    document.querySelector('#flip-camera-box').removeAttribute('hidden')
}else{
    // false for not mobile device
    console.log("not mobile device");
}
