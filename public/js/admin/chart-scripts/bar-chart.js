//Generar gráfico linear
const generateBarChart = (labels,colors,data) => {
	//Año actual
	
	let graficoBarCanvas = document.getElementById('graficoBarCanvas')
	let barChart = new Chart(graficoBarCanvas, {
		  type: 'bar',
		  data: {
		  	labels: labels,
		  
			  datasets: data
		  },
		  options: {
		    responsive: true,
		    plugins: {
		      legend: {
		        position: 'top',
		      },
		      title: {
		        display: true,
		        text: 'Solicitdadas Vs Contratadas'
		      }
		    },
		    scales: {
		        yAxes: [{
		            display: true,
		            //stacked: true,
		            ticks: {
		                min: 0, // minimum value
		                
		            }
		        }]
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