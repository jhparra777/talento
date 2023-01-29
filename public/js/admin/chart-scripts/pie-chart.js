//Generar gráfico linear
const generatePieChart = (labels,colors,data) => {
	//Año actual
	
	let graficoPieCanvas = document.getElementById('graficoPieCanvas')
	let pieChart = new Chart(graficoPieCanvas, {
		  type: 'pie',
		  data: {
		  	labels: labels,
		  
			  datasets: [
			  {
			    data: data,
			    backgroundColor: colors
			  }]
		  },
		  options: {
		    responsive: true,
		    plugins: {
		      legend: {
		        position: 'top',
		      },
		      title: {
		        display: true,
		        text: 'Porcentajes cumplimiento'
		      }
		    }
		  }
		})
}

//Simular carga de las gráficas
/*setTimeout(() => {
    let preloader = document.querySelector('#boxPreloader')
    let chartCanvas = document.querySelector('#graficoPieCanvas')

    preloader.setAttribute('hidden', true)
    chartCanvas.setAttribute('hidden', true)

    generatePieChart()
}, 1000)*/