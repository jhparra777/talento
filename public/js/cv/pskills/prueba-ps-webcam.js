const psPictures = []

let intervalWebcam = null
let pictureCount = 1;
//let firstPicture = true
let se_toman_fotos = true;

const webcamElement = document.getElementById('webcam');
const canvasElement = document.getElementById('canvas');
const webcam = new Webcam(webcamElement, 'user', canvasElement);

function initWebcam() {
	takePicture(webcam)

	if (se_toman_fotos) {
		//Crea intervalo de 10s para las demás fotos
		intervalWebcam = setInterval(() => {
			takePicture(webcam)
			//console.log('Foto')
		}, 120000)
	}
}

function takePicture() {
	document.querySelector('#webcamBox').removeAttribute('hidden')

	let picture = null

	webcam.start()
	.then(result =>{
		//console.log("webcam started");
	})
	.catch(err => {
		console.log(err);
		/*alert('Debes tener una cámara web disponible para continuar con el proceso de la prueba.')

		setTimeout(() => {
			location.reload()
		}, 3000)*/
        Swal.fire({
			title: 'Error al iniciar la cámara',
			text: 'Se ha producido un error al iniciar la cámara, porque no lo admite su navegador o porque no ha permitido el uso de la cámara.',
			icon: 'warning',
			backdrop: true,
			confirmButtonText: `Continuar`,
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
                se_toman_fotos = false;
                $('#webcamBox').hide();
                clearInterval(intervalWebcam);
                return;
			} else {
                clearInterval(intervalWebcam);
                location.reload(true);
			}
		})
	});

    setTimeout(() => {
		//Toma la foto
		let picture = webcam.snap();

		//Guardar el nombre en orden de la foto y el string base64 PNG
		psPictures.push({
			'name': `ps-foto-${pictureCount}`,
			'picture': picture
		})

		pictureCount++

		document.querySelector('#webcamBox').setAttribute('hidden', true)

		stopWebcam();
    }, 3500)
}

function stopWebcam() {
	webcam.stop();
	//console.log('stop')
}