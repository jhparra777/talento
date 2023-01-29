//Generar gráfico linear
const generateLinearChart = () => {
	//Año actual
	const currentDate = new Date()
	const currentYear = currentDate.getFullYear()

	let graficoLinearCanvas = document.getElementById('graficoLinearCanvas')
	let barChart = new Chart(graficoLinearCanvas, {
	    type: 'line',
	    data: {
	        labels: [`Enero ${currentYear}`, `Febrero ${currentYear}`, `Marzo ${currentYear}`, `Abril ${currentYear}`, `Mayo ${currentYear}`, `Junio ${currentYear}`, `Julio ${currentYear}`, `Agosto ${currentYear}`, `Septiembre ${currentYear}`, `Octubre ${currentYear}`, `Noviembre ${currentYear}`, `Diciembre ${currentYear}`],
	        datasets: [
	        	{
	            	label: 'Solicitadas',
	            	borderColor: ['rgba(238, 82, 83, 1.0)'],
	            	data: [
	            		candidatosSolicitados.candidatosEnero,
	            		candidatosSolicitados.candidatosFebrero,
	            		candidatosSolicitados.candidatosMarzo,
	            		candidatosSolicitados.candidatosAbril,
	            		candidatosSolicitados.candidatosMayo,
	            		candidatosSolicitados.candidatosJunio,
	            		candidatosSolicitados.candidatosJulio,
	            		candidatosSolicitados.candidatosAgosto,
	            		candidatosSolicitados.candidatosSeptiembre,
	            		candidatosSolicitados.candidatosOctubre,
	            		candidatosSolicitados.candidatosNoviembre,
	            		candidatosSolicitados.candidatosDiciembre,
	            	],
	            	borderWidth: 2,
	            	fill: false
				},
	        	{
	            	label: 'Contratadas',
	            	borderColor: ['rgba(16, 172, 132, 1.0)'],
	            	data: [
	            		candidatosContratados.candidatosEnero,
	            		candidatosContratados.candidatosFebrero,
	            		candidatosContratados.candidatosMarzo,
	            		candidatosContratados.candidatosAbril,
	            		candidatosContratados.candidatosMayo,
	            		candidatosContratados.candidatosJunio,
	            		candidatosContratados.candidatosJulio,
	            		candidatosContratados.candidatosAgosto,
	            		candidatosContratados.candidatosSeptiembre,
	            		candidatosContratados.candidatosOctubre,
	            		candidatosContratados.candidatosNoviembre,
	            		candidatosContratados.candidatosDiciembre,
	            	],
	            	borderWidth: 2,
	            	fill: false
				}
			]
	    },
	    options: {
	    	legend: {
	    		display: true,
	    		labels: { 
	    			fontSize: 14
	    		}
	    	},
	        title: {
	            display: true,
	            text: 'Indicador de efectividad',
	            fontSize: 16
	        },
	        scales: {
	        	xAxes: [{
	        		ticks: {
	        			fontColor: 'black'
	        		}
	        	}]
	        }
	    }
	})
}

//Simular carga de las gráficas
setTimeout(() => {
    let preloader = document.querySelector('#boxPreloader')
    let chartCanvas = document.querySelector('#graficoLinearCanvas')

    preloader.setAttribute('hidden', true)
    chartCanvas.setAttribute('hidden', true)

    generateLinearChart()
}, 1000)