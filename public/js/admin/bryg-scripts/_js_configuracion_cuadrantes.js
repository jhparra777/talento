//Valores ideales de cada perfil
const perfiles = [
	{
		perfil: 'populista', radical: 90, genuino: 90, garante: 60, basico: 60
	},
	{
		perfil: 'científico', radical: 60, genuino: 60, garante: 90, basico: 90
	},
	{
		perfil: 'director', radical: 60, genuino: 90, garante: 60, basico: 90
	},
	{
		perfil: 'cocreador', radical: 90, genuino: 60, garante: 90, basico: 60
	},
	{
		perfil: 'capitán', radical: 90, genuino: 60, garante: 60, basico: 90
	},
	{
		perfil: 'protector', radical: 60, genuino: 90, garante: 90, basico: 60
	}
]

let valoresGrafico = { radical: 0, genuino: 0, garante: 0, basico: 0 }
let perfilGlobal = ""

const botonGuardarConfiguracion = document.querySelector('#guardarConfiguracionBryg')
const panelDescripcionPerfil = document.querySelector('#panelDescripcionPerfil')

//Generador de gráfico de radar BRYG
const generarRadarBRYG = () => {
	let graficoRadarCanvas = document.getElementById('graficoRadarCanvas')

	let radarChart = new Chart(graficoRadarCanvas, {
	    type: 'radar',
	    data: {
	        labels: ['RADICAL', 'GENUINO', 'GARANTE', 'BÁSICO'],
	        datasets: [{
	            label: 'Resultados',
	            backgroundColor: ['rgba(0, 169, 84, 0.8)'],
	            borderColor: [
	            	'rgba(0, 169, 84, 1)'
	            ],
	            data: [valoresGrafico.radical, valoresGrafico.genuino, valoresGrafico.garante, valoresGrafico.basico],
	            borderWidth: 1
			}]
	    },
	    options: {
	    	legend: { display: false },
	        title: {
	            display: true,
	            text: 'BRYG-A Gráfico de radar'
	        }
	    }
	})
}

//Onclick del botón de perfiles
const cargarPerfilIdeal = (obj) => {
	let perfilDescripcion = obj.dataset.perfil

	cargarCalificacionCuadrantes(perfilDescripcion)

	//Sumar los cuadrantes
	sumarCuadrantes(valoresGrafico)
}

const cargarCalificacionCuadrantes = (perfilDescripcion) => {
	perfilSeleccionado = perfiles.find(perfil => perfil.perfil === perfilDescripcion)

	document.querySelector('#radical').value = perfilSeleccionado.radical
	document.querySelector('#genuino').value = perfilSeleccionado.genuino
	document.querySelector('#garante').value = perfilSeleccionado.garante
	document.querySelector('#basico').value = perfilSeleccionado.basico

	panelDescripcionPerfil.innerHTML = `<span class="badge text-uppercase" style="font-size: 15px !important; background-color: gray;">${perfilSeleccionado.perfil}</span>`
	panelDescripcionPerfil.removeAttribute('hidden')

	//
	valoresGrafico['radical'] = perfilSeleccionado.radical
	valoresGrafico['genuino'] = perfilSeleccionado.genuino
	valoresGrafico['garante'] = perfilSeleccionado.garante
	valoresGrafico['basico'] = perfilSeleccionado.basico

	//
	perfilGlobal = perfilSeleccionado.perfil

	generarRadarBRYG()
}

//Actualizar gráfico cuando detecte cambios en los campos
const actualizarRadarBRYG = (obj) => {
	let cuadrante = obj.dataset.cuadrante

	switch (cuadrante) {
		case 'radical':
			valoresGrafico['radical'] = obj.value

			break;
		case 'genuino':
			valoresGrafico['genuino'] = obj.value

			break;
		case 'garante':
			valoresGrafico['garante'] = obj.value

			break;
		case 'basico':
			valoresGrafico['basico'] = obj.value

			break;
		default:
			break;
	}

	//Validar el valor del campo
	if (obj.value == 75) {
		obj.value = ""

		//Informa que no es valido el 75
		$.smkAlert({text: 'El valor <b>75</b>, no es un valor permitido para los cuadrantes.', type: 'danger'})
	}

	generarRadarBRYG()
	calcularPerfil()

	//Sumar los cuadrantes
	sumarCuadrantes(valoresGrafico)

	//Validar cuadrantes
	validarValoresCorrectos()
}

//Actualizar - evaluar el perfil con los valores de los campos
const calcularPerfil = () => {
	let obj = {...valoresGrafico}

	//Obtiene el cuadrante más alto (key)
	let primerCuadrante = Object.keys(obj).reduce((a, b) => obj[a] > obj[b] ? a : b)
	let primerCuadranteValor = obj[primerCuadrante]

	//Elimina ese cuadrante
	delete obj[primerCuadrante]

	//Obtiene el segundo cuadrante más alto
	let segundoCuadrante = Object.keys(obj).reduce((a, b) => obj[a] > obj[b] ? a : b)
	let segundoCuadranteValor = obj[segundoCuadrante]

	delete obj[segundoCuadrante]

	//Validar si alguno de los dos cuadrantes está en 0
	if (parseInt(primerCuadranteValor) === 0 || parseInt(segundoCuadranteValor) === 0) {
		console.log('algún cuadrante alto vacío')
	}else {
		//El perfil validado
		let perfil = validarCuadrantes(primerCuadrante, segundoCuadrante)
		perfilGlobal = perfil

		panelDescripcionPerfil.innerHTML = `<span class="badge text-uppercase" style="font-size: 15px !important; background-color: gray;">${perfil}</span>`
		panelDescripcionPerfil.removeAttribute('hidden')
	}
}

//Validar cuadrantes para mostrar perfil (campos)
const validarCuadrantes = (primerCuadrante, segundoCuadrante) => {
	let perfilValidado = "undefined";

    if (primerCuadrante === 'basico' && segundoCuadrante === 'radical') {
        //Capitán
        perfilValidado = "Capitán";

    }else if (primerCuadrante === 'radical' && segundoCuadrante === 'basico') {
        //Capitán
        perfilValidado = "Capitán";

    }else if(primerCuadrante === 'basico' && segundoCuadrante === 'garante') {
        //Científico
        perfilValidado = "Científico";

    }else if(primerCuadrante === 'garante' && segundoCuadrante === 'basico') {
        //Científico
        perfilValidado = "Científico";

    }else if(primerCuadrante === 'radical' && segundoCuadrante === 'garante') {
        //Cocreador
        perfilValidado = "Cocreador";

    }else if(primerCuadrante === 'garante' && segundoCuadrante === 'radical') {
        //Cocreador
        perfilValidado = "Cocreador";

    }else if(primerCuadrante === 'basico' && segundoCuadrante === 'genuino') {
        //Director
        perfilValidado = "Director";

    }else if(primerCuadrante === 'genuino' && segundoCuadrante === 'basico') {
        //Director
        perfilValidado = "Director";

    }else if(primerCuadrante === 'genuino' && segundoCuadrante === 'radical') {
        //Populista
        perfilValidado = "Populista";

    }else if(primerCuadrante === 'radical' && segundoCuadrante === 'genuino') {
        //Populista
        perfilValidado = "Populista";

    }else if(primerCuadrante === 'genuino' && segundoCuadrante === 'garante') {
        //Protector
        perfilValidado = "Protector";

    }else if(primerCuadrante === 'garante' && segundoCuadrante === 'genuino') {
        //Protector
        perfilValidado = "Protector";
    }

    return perfilValidado;
}

const sumarCuadrantes = (cuadrantes) => {
	let msjSumaCuadrantes = document.querySelector('#msjSumaCuadrantes')
	totalCuadrantes = parseInt(cuadrantes.radical) + parseInt(cuadrantes.genuino) + parseInt(cuadrantes.garante) + parseInt(cuadrantes.basico)

	if (totalCuadrantes > 300) {
		panelDescripcionPerfil.setAttribute('hidden', true)
		botonGuardarConfiguracion.setAttribute('disabled', true)

		msjSumaCuadrantes.innerHTML = `<b>La suma de los cuadrantes no debe ser mayor a 300. Total: ${totalCuadrantes}</b>`
		msjSumaCuadrantes.removeAttribute('hidden')
	}else {
		msjSumaCuadrantes.setAttribute('hidden', true)
		botonGuardarConfiguracion.removeAttribute('disabled')
	}
}

const validarValoresCorrectos = () => {
	let mayores = 0;
	let menores = 0;

	for(let [key, value] of Object.entries(valoresGrafico)) {	  
	  	if(value < 75) {
	  		menores++
	  	}

	  	if(value > 75) {
	  		mayores++
	  	}
	}

	let msjCuadrantesValidos = document.querySelector('#msjCuadrantesValidos')

	if (mayores == 2 && menores == 2) {
		botonGuardarConfiguracion.removeAttribute('disabled')

		msjCuadrantesValidos.setAttribute('hidden', true)

		//Sumar los cuadrantes
		sumarCuadrantes(valoresGrafico)
	}else {
		msjCuadrantesValidos.innerHTML = `<b>Deben existir dos cuadrantes mayores de 75 y dos cuadrantes menores de 75.</b>`
		msjCuadrantesValidos.removeAttribute('hidden')

		// $.smkAlert({text: 'Deben existir dos cuadrantes mayores de 75.', type: 'info'})
		// $.smkAlert({text: 'Deben existir dos cuadrantes menores de 75.', type: 'info'})
		// console.log('Deben existir dos cuadrantes mayores de 75')
		// console.log('Deben existir dos cuadrantes menores de 75')

		botonGuardarConfiguracion.setAttribute('disabled', true)
	}
}

generarRadarBRYG()