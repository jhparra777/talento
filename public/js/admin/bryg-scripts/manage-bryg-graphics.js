//Validar valores de cuadrante para color
let radarBrygColor
switch (bryg_index) {
	case 'radical':
		radarBrygColor = '46, 45, 102'
		break;
	case 'genuino':
		radarBrygColor = '217, 36, 40'
		break;
	case 'garante':
		radarBrygColor = '228, 228, 42'
		break;
	case 'basico':
		radarBrygColor = '0, 169, 84'
		break;
	default:
		radarBrygColor = '0, 169, 84'
		break;
}

let radarAumentedColor
switch (aumented_index) {
	case 'analizador':
		radarAumentedColor = '2, 136, 209'
		break;
	case 'prospectivo':
		radarAumentedColor = '253, 216, 53'
		break;
	case 'defensivo':
		radarAumentedColor = '244, 67, 54'
		break;
	case 'reactivo':
		radarAumentedColor = '124, 179, 66'
		break;
	default:
		radarAumentedColor = '124, 179, 66'
		break;
}

//Generador de gráfico de radar BRYG
const generarRadarBRYG = () => {
	let graficoRadarCanvas = document.getElementById('grafico_radar_canvas')
	let radarChart = new Chart(graficoRadarCanvas, {
	    type: 'radar',
	    data: {
	        labels: ['RADICAL', 'GENUINO', 'GARANTE', 'BÁSICO'],
	        datasets: [{
	            label: 'Resultados',
	            backgroundColor: [
	            	`rgba(${radarBrygColor}, 0.8)`
	            ],
	            borderColor: [
	            	`rgba(${radarBrygColor}, 1)`
	            ],
	            data: [
	                resultadosEstilosBRYG.radical,
	                resultadosEstilosBRYG.genuino,
	                resultadosEstilosBRYG.garante,
	                resultadosEstilosBRYG.basico
	            ],
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

//Generador de gráfico de barra BRYG
const generarBarraBRYG = () => {
	let graficoBarraCanvas = document.getElementById('grafico_barra_canvas')
	let barChart = new Chart(graficoBarraCanvas, {
	    type: 'bar',
	    data: {
	        labels: ['RADICAL', 'GENUINO', 'GARANTE', 'BÁSICO'],
	        datasets: [{
	            label: 'Resultados',
	            backgroundColor: [
	            	'rgba(46, 45, 102, 0.7)',
	                'rgba(217, 36, 40, 0.7)',
	                'rgba(228, 228, 42, 0.7)',
	                'rgba(0, 169, 84, 0.7)'
	            ],
	            borderColor: [
	            	'rgba(46, 45, 102, 1)',
	                'rgba(217, 36, 40, 1)',
	                'rgba(228, 228, 42, 1)',
	                'rgba(0, 169, 84, 1)'
	            ],
	            data: [
	                resultadosEstilosBRYG.radical,
	                resultadosEstilosBRYG.genuino,
	                resultadosEstilosBRYG.garante,
	                resultadosEstilosBRYG.basico
	            ],
	            borderWidth: 1
			}]
	    },
	    options: {
	    	legend: { display: false },
	        title: {
	            display: true,
	            text: 'BRYG-A Gráfico de barra'
	        }
	    }
	})
}

//Generador de gráfico de radar AUMENTED
const generarRadarAUMENTED = () => {
	let graficoRadarCanvas = document.getElementById('grafico_radar_aumented_canvas')
	let radarChart = new Chart(graficoRadarCanvas, {
	    type: 'radar',
	    data: {
	        labels: ['ANALIZADOR', 'PROSPECTIVO', 'DEFENSIVO', 'REACTIVO'],
	        datasets: [{
	            label: 'Resultados',
	            backgroundColor: [
	            	`rgba(${radarAumentedColor}, 0.8)`
	            ],
	            borderColor: [
	            	`rgba(${radarAumentedColor}, 1)`
	            ],
	            data: [
	                resultadosEstilosAUMENTED.analizador,
	                resultadosEstilosAUMENTED.prospectivo,
	                resultadosEstilosAUMENTED.defensivo,
	                resultadosEstilosAUMENTED.reactivo
	            ],
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

//Generador de gráfico de barra AUMENTED
const generarBarraAUMENTED = () => {
	let graficoBarraCanvas = document.getElementById('grafico_barra_aumented_canvas')
	let barChart = new Chart(graficoBarraCanvas, {
	    type: 'bar',
	    data: {
	        labels: ['ANALIZADOR', 'PROSPECTIVO', 'DEFENSIVO', 'REACTIVO'],
	        datasets: [{
	            label: 'Resultados',
	            backgroundColor: [
	            	'rgba(2, 136, 209, 0.7)',
	                'rgba(253, 216, 53, 0.7)',
	                'rgba(244, 67, 54, 0.7)',
	                'rgba(124, 179, 66, 0.7)'
	            ],
	            borderColor: [
	            	'rgba(2, 136, 209, 1)',
	                'rgba(253, 216, 53, 1)',
	                'rgba(244, 67, 54, 1)',
	                'rgba(124, 179, 66, 1)'
	            ],
	            data: [
	                resultadosEstilosAUMENTED.analizador,
	                resultadosEstilosAUMENTED.prospectivo,
	                resultadosEstilosAUMENTED.defensivo,
	                resultadosEstilosAUMENTED.reactivo
	            ],
	            borderWidth: 1
			}]
	    },
	    options: {
	    	legend: { display: false },
	        title: {
	            display: true,
	            text: 'BRYG-A Gráfico de barra'
	        }
	    }
	})
}

//Crear gráficos de comparación
const generarRadarComparacionBRYG = () => {
	let graficoRadarCanvas = document.getElementById('grafico_radar_comparacion_canvas')
	let radarChart = new Chart(graficoRadarCanvas, {
	    type: 'radar',
	    data: {
	        labels: ['RADICAL', 'GENUINO', 'GARANTE', 'BÁSICO'],
	        datasets: [
		        {
		            label: 'Resultados candidato',
		            backgroundColor: [
		            	`rgba(${radarBrygColor}, 0.8)`
		            ],
		            borderColor: [
		            	`rgba(${radarBrygColor}, 1)`
		            ],
		            data: [
		                resultadosEstilosBRYG.radical,
		                resultadosEstilosBRYG.genuino,
		                resultadosEstilosBRYG.garante,
		                resultadosEstilosBRYG.basico
		            ],
		            borderWidth: 1
				},
				{
		            label: 'Perfil ideal',
		            backgroundColor: [
		            	`rgba(93, 94, 97, 0.8)`
		            ],
		            borderColor: [
		            	`rgba(93, 94, 97, 1)`
		            ],
		            data: [
		                configuracionBryg.radical,
		                configuracionBryg.genuino,
		                configuracionBryg.garante,
		                configuracionBryg.basico
		            ],
		            borderWidth: 1
				}
			]
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

//Generador de gráfico de barra BRYG
const generarBarraComparacionBRYG = () => {
	let graficoBarraCanvas = document.getElementById('grafico_barra_comparacion_canvas')
	let barChart = new Chart(graficoBarraCanvas, {
	    type: 'bar',
	    data: {
	        labels: ['RADICAL', 'GENUINO', 'GARANTE', 'BÁSICO'],
	        datasets: [
		        {
		            label: 'Resultados candidato',
		            backgroundColor: [
		            	'rgba(46, 45, 102, 0.7)',
		                'rgba(217, 36, 40, 0.7)',
		                'rgba(228, 228, 42, 0.7)',
		                'rgba(0, 169, 84, 0.7)'
		            ],
		            borderColor: [
		            	'rgba(46, 45, 102, 1)',
		                'rgba(217, 36, 40, 1)',
		                'rgba(228, 228, 42, 1)',
		                'rgba(0, 169, 84, 1)'
		            ],
		            data: [
		                resultadosEstilosBRYG.radical,
		                resultadosEstilosBRYG.genuino,
		                resultadosEstilosBRYG.garante,
		                resultadosEstilosBRYG.basico
		            ],
		            borderWidth: 1
				},
				{
		            label: 'Perfil ideal',
		            backgroundColor: [
		            	'rgba(93, 94, 97, 0.7)',
		                'rgba(93, 94, 97, 0.7)',
		                'rgba(93, 94, 97, 0.7)',
		                'rgba(93, 94, 97, 0.7)'
		            ],
		            borderColor: [
		            	'rgba(93, 94, 97, 1)',
		                'rgba(93, 94, 97, 1)',
		                'rgba(93, 94, 97, 1)',
		                'rgba(93, 94, 97, 1)'
		            ],
		            data: [
		                configuracionBryg.radical,
		                configuracionBryg.genuino,
		                configuracionBryg.garante,
		                configuracionBryg.basico
		            ],
		            borderWidth: 1
				}
			]
	    },
	    options: {
	    	legend: { display: false },
	        title: {
	            display: true,
	            text: 'BRYG-A Gráfico de barra'
	        }
	    }
	})
}