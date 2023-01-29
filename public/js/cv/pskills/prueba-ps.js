const beforeUnloadListener = (event) => {
    event.preventDefault();
    return event.returnValue = "¿Deseas salir de la prueba?";
};

/*
 * Guardar resultados
*/

document.querySelector('#saveTest').addEventListener('click', (event) => {
    //Data, crea un objeto form para el envío de resultados
    let data = new FormData();

    data.append('userId', parseInt(document.querySelector('#userId').value));
    data.append('requerimientoId', document.querySelector('#requerimientoId').value);
    data.append('psImagenes', JSON.stringify(psPictures));
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

    if (se_toman_fotos) {
        stopWebcam()
        clearInterval(intervalWebcam)
    }

    fetch('prueba-competencias-guardar-fotos', {
        method : 'post',
        body : data,
        headers :{
            'X-CSRF-TOKEN': document.querySelector('meta[name="token"]').getAttribute('content')
        }
    })
    .then(content => {
        let route = event.target.dataset.route

        $.ajax({
            type: 'POST',
            url: route,
            data: $('#frmPruebaCompetencias').serialize(),
            beforeSend: function() {
                event.target.setAttribute('disabled', true)
            },
            success: function(response) {
                $.smkAlert({
                    text: 'Resultados guardados correctamente.',
                    type: 'success',
                });

                setTimeout(() => {
                    $.smkProgressBar({
                        status:'end'
                    });
                }, 1500)

                removeEventListener("beforeunload", beforeUnloadListener, {capture: true});

                setTimeout(() => {
                    window.location.href = redir
                }, 2500)
            }
        })

        /*$.smkAlert({
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
        }, 2500)*/
    })
    .catch(error => console.log(error))  
})