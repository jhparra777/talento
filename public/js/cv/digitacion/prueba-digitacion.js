const wordCorrects = []
const wordWrong = []
let totalWpm = null
let wordIndex = 0
let pulsaciones = 0
/*
 * Countdown
*/

const beforeUnloadListener = (event) => {
    event.preventDefault();
    return event.returnValue = "¿Deseas salir de la prueba?";
};

const startMinute = 1
let timeCountdown = startMinute * 60
const labelCountdown = document.querySelector('#countdownLabel')

let intervalReference = null
let flagSeconds = 61

/*
 * Capturar evento teclado
*/

document.querySelector('#inputDigitacion').addEventListener('keydown', (event) => {
	//Sumar pulsaciones
	pulsaciones++

	if (pulsaciones === 1) {
		addEventListener("beforeunload", beforeUnloadListener, {capture: true});
	}

	let keyName = event.keyCode

	//Seleccionar span
	let elementSpan = document.querySelector(`#word${wordIndex}`)
	let wordJson = mainTxtJson[wordIndex]

	//Asignar clase actual
	elementSpan.classList.add('wactual')

	//Valor del input
	let wordValue = event.target.value

	//Validar palabras
	let compareResult = compareWords(wordJson, wordValue)

	//Actualizar span
	updateSpan(elementSpan, compareResult)

	//Space
	if (keyName === 32) {
		//Aumenta el index para buscar el siguiente span y la siguiente palabra
		wordIndex = ++wordIndex

		//Almacenar palabras ingresadas
		storeWords(compareResult, wordValue)

		//Limpiar el campo
		event.target.value = ""

		setTimeout(() => {
			//Limpiar el campo de nuevo, por alguna razón esta dejando un espacio
			event.target.value = ""
		}, 10)
	}
})

function compareWords(textWord, userWord) {
	if (textWord === userWord) {
		return true
	}else {
		return false
	}
}

function storeWords(compareResult, userWord) {
	if (compareResult) {
		//Si es correcta
		wordCorrects.push(userWord)
		console.log(wordCorrects)
	}else {
		//Incorrecta
		wordWrong.push(userWord)
		console.log(wordWrong)
	}	
}

function updateSpan(element, wordStatus) {
	if (wordStatus) {
		element.classList.remove('wdefault')
		element.classList.remove('wwrong')

		element.classList.add('wcorrect')
	}else {
		element.classList.remove('wdefault')
		element.classList.remove('wcorrect')

		element.classList.add('wwrong')
	}
}

/*
 * Eventos final contador
*/

function countdownFinalEvent() {
	setTimeout(() => {
		//Mostrar modal de finalización
		$('#digitacionFinalModal').modal({backdrop: 'static', keyboard: false, show: true});
	}, 500)

	setTimeout(() => {
		//Ocultar modal de finalización
		$('#digitacionFinalModal').modal('hide')
	}, 3000)

	//Oculta row webcam
	document.querySelector('#webcamBox').setAttribute('hidden', true)

	document.querySelector('#inputDigitacion').setAttribute('disabled', true)
	document.querySelector('#inputDigitacion').value = ''

	//Label badge
	labelCountdown.classList.remove('label-default')
	labelCountdown.classList.add('label-success')

	//Completar panel con los resultados
	totalWpm = parseInt(wordCorrects.length) + parseInt(wordWrong.length)

	const resultadoPpm = document.querySelector('#resultadoPpm')
	const resultadoPulsaciones = document.querySelector('#resultadoPulsaciones')
	const resultadoPrecision = document.querySelector('#resultadoPrecision')
	const resultadoCorrectas = document.querySelector('#resultadoCorrectas')
	const resultadoIncorrectas = document.querySelector('#resultadoIncorrectas')

	let precisionPrueba = 1-(parseInt(wordWrong.length)/totalWpm)
	precisionPrueba = precisionPrueba * 100
	//Para mostrar un solo decimal
	precisionPrueba = Math.round(precisionPrueba * 10) / 10

	//Insertar resultados en el panel
	resultadoPpm.innerHTML = `<b>${totalWpm} PPM</b>`
	resultadoPulsaciones.textContent = pulsaciones
	resultadoPrecision.textContent = `${precisionPrueba} %`
	resultadoCorrectas.textContent = wordCorrects.length
	resultadoIncorrectas.textContent = wordWrong.length

	setTimeout(() => {
		//Hace la petición al backend para guardar todo el test
		saveTest()

		//Muestra el panel
		document.querySelector('#panelResultadosBox').removeAttribute('hidden')
		document.querySelector('#btnFinalizarBox').removeAttribute('hidden')
	}, 4000)
}

/*
 * Countdown
*/

function updateCountdown() {
	const minutes = Math.floor(timeCountdown / 60)
	let seconds = timeCountdown % 60

	seconds = seconds < 10 ? '0' + seconds : seconds

	labelCountdown.textContent = `${minutes}:${seconds}`

	timeCountdown--
	timeCountdown = timeCountdown < 0 ? 0 : timeCountdown

	//Bandera para validar
	flagSeconds--

	if (flagSeconds <= 0) {
		clearInterval(intervalReference)

		//Detener intervalo webcam
		clearInterval(intervalWebcam)
		webcam.stop();

		//Ejecutar todos los eventos al finalizar el minuto
		countdownFinalEvent()
	}
}

function initCountdown() {
	intervalReference = setInterval(updateCountdown, 1000)
}

/*
 * Guardar resultados
*/

function saveTest() {
	stopWebcam()

    //Data, crea un objeto form para el envío de resultados
    let data = new FormData();

    data.append('userId', parseInt(document.querySelector('#userId').value));
    data.append('requerimientoId', document.querySelector('#requerimientoId').value);
    data.append('digitacionImagenes', JSON.stringify(digitacionPictures));
    data.append('digitacionCorrectas', parseInt(wordCorrects.length));
    data.append('digitacionIncorrectas', parseInt(wordWrong.length));
    data.append('digitacionPpm', parseInt(totalWpm));
    data.append('digitacionPulsaciones', pulsaciones);
    data.append('_token', document.querySelector('meta[name="token"]').getAttribute('content'));

    //Mostrar pantalla de progreso
    $.smkProgressBar({
        element: 'body',
        status: 'start',
        bgColor: '#7f8c8d',
        barColor: '#fff',
        content: `
            <div class="row">
                <div class="col-md-12">
                    <img src="https://desarrollo.t3rsc.co/img/preloader_ee.gif" width="40">
                </div>
                <div class="col-md-12">
                    <h3><b>Guardando resultados</b></h3>
                </div>
            </div>
        `
    });

    fetch('prueba-digitacion-guardar', {
        method : 'post',
        body : data,
        headers :{
            'X-CSRF-TOKEN': document.querySelector('meta[name="token"]').getAttribute('content')
        }
    })
    .then(content => {
        //console.log(content);
        //console.log(data);
        removeEventListener("beforeunload", beforeUnloadListener, {capture: true});

        $.smkAlert({
            text: 'Resultados guardados correctamente.',
            type: 'success',
        });

        setTimeout(() => {
            $.smkProgressBar({
                status:'end'
            });
        }, 1500)

        setTimeout(() => {
            //window.location.href = redir
        }, 2500)
    })
    .catch(error => console.log(error))
}