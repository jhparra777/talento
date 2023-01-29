let valoresIdealPruebaValores = { verdad: 0, rectitud: 0, paz: 0, amor: 0, no_violencia: 0 }

const btnGuardarPruebaValores = document.querySelector('#guardarConfiguracionPruebaValores')

//Generador de gráfico de radar BRYG
const generarIdealPruebaValores = () => {
    let graficoIdealPruebaValores = document.getElementById('graficoIdealPruebaValores')

    let radarChart = new Chart(graficoIdealPruebaValores, {
        type: 'radar',
        data: {
            labels: ['VERDAD', 'RECTITUD', 'PAZ', 'AMOR', 'NO VIOLENCIA' ],
            datasets: [{
                label: 'Resultados',
                backgroundColor: ['rgba(0, 169, 84, 0.8)'],
                borderColor: [
                    'rgba(0, 169, 84, 1)'
                ],
                data: [valoresIdealPruebaValores.verdad, valoresIdealPruebaValores.rectitud, valoresIdealPruebaValores.paz, valoresIdealPruebaValores.amor, valoresIdealPruebaValores.no_violencia],
                borderWidth: 1
            }]
        },
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Prueba de Valores 1 Gráfico de radar'
            }
        }
    })
}

//Actualizar gráfico cuando detecte cambios en los campos
$(".actualiza-grafico-ev").on('keyup input', function(){
    let obj = this;
    let cuadrante = obj.dataset.cuadrante
    let max = parseInt(obj.dataset.max)
    let cuadranteVacio = false

    switch (cuadrante) {
        case 'verdad':
            valoresIdealPruebaValores['verdad'] = obj.value

            break;
        case 'rectitud':
            valoresIdealPruebaValores['rectitud'] = obj.value

            break;
        case 'paz':
            valoresIdealPruebaValores['paz'] = obj.value

            break;
        case 'amor':
            valoresIdealPruebaValores['amor'] = obj.value

            break;
        case 'no_violencia':
            valoresIdealPruebaValores['no_violencia'] = obj.value

            break;
        default:
            break;
    }

    //Validar el valor del campo
    if (obj.value > max) {
        obj.value = ""

        //Informa que no es un valor valido 
        $.smkAlert({text: 'El valor máximo es <b>'+max+'</b>.', type: 'danger'})
        cuadranteVacio = false
    }

    generarIdealPruebaValores()

    //Sumar los valores ideales
    sumarValores(valoresIdealPruebaValores, cuadranteVacio)
});

const sumarValores = (pruebaValores, cuadranteVacio) => {
    let msjSumaPruebaValores = document.querySelector('#msjSumaPruebaValores')
    //totalPruebaValores = parseInt(pruebaValores.verdad) + parseInt(pruebaValores.rectitud) + parseInt(pruebaValores.paz) + parseInt(pruebaValores.amor) + parseInt(pruebaValores.no_violencia)

    if (pruebaValores.verdad == '' || pruebaValores.rectitud == '' || pruebaValores.paz == '' || pruebaValores.amor == '' || pruebaValores.no_violencia == '' || cuadranteVacio) {
        btnGuardarPruebaValores.setAttribute('disabled', true)

        msjSumaPruebaValores.innerHTML = `<b>Debe colocar un valor a cada item (puede ingresar cero).</b>`
        msjSumaPruebaValores.removeAttribute('hidden')
    } else {
        msjSumaPruebaValores.setAttribute('hidden', true)
        btnGuardarPruebaValores.removeAttribute('disabled')
    }
}

generarIdealPruebaValores()