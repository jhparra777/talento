//Contenedor (DIV) del botón finalizar prueba
const buttonBox = document.querySelector('#buttonBox');
const paginationButtons = document.querySelector('#paginationButtonBox')

const beforeUnloadListener = (event) => {
    event.preventDefault();
    return event.returnValue = "¿Deseas salir de la prueba?";
};

//Perfilamiento
let radical = {};
let genuino = {};
let garante = {};
let basico  = {};

let questions = []

function toRadical(obj) {
    const obj_name = obj.name
    const obj_value = obj.value

    // obj.dataset.pregunta - es el id de la pregunta asignado a un atributo data
    // obj_value - es el valor de la opción seleccionada

    //Validar la opciones
    if (validateAnsweredOptions(obj.dataset.pregunta, obj_value, obj_name)) {
        //Guarda el nombre de la opción seleccionada y le asigna el valor de esa opción
        radical[obj_name] = obj_value

        //console.log(radical)
    }

    //Si hay respondido las opciones habilita el botón de finalizar
    validateTotalOptions()
}

function toGenuino(obj) {
    const obj_name = obj.name
    const obj_value = obj.value

    if (validateAnsweredOptions(obj.dataset.pregunta, obj_value, obj_name)) {
        genuino[obj_name] = obj_value

        //console.log(genuino)
    }

    //Si hay respondido las opciones habilita el botón de finalizar
    validateTotalOptions()
}

function toGarante(obj) {
    const obj_name = obj.name
    const obj_value = obj.value

    if (validateAnsweredOptions(obj.dataset.pregunta, obj_value, obj_name)) {
        garante[obj_name] = obj_value

        //console.log(garante)
    }

    //Si hay respondido las opciones habilita el botón de finalizar
    validateTotalOptions()
}

function toBasico(obj) {
    const obj_name = obj.name
    const obj_value = obj.value

    if (validateAnsweredOptions(obj.dataset.pregunta, obj_value, obj_name)) {
        basico[obj_name] = obj_value

        //console.log(basico)
    }

    //Si hay respondido las opciones habilita el botón de finalizar
    validateTotalOptions()
}

//Aumented
let a = {};
let p = {};
let d = {};
let r = {};

//Analizador
function toA(obj) {
    const obj_name = obj.name
    const obj_value = obj.value

    if (validateAnsweredOptions(obj.dataset.pregunta, obj_value, obj_name)) {
        a[obj_name] = obj_value

        //console.log(a)
    }

    //Si hay respondido las opciones habilita el botón de finalizar
    validateTotalOptions()
}

//Prospectivo
function toP(obj) {
    const obj_name = obj.name
    const obj_value = obj.value

    if (validateAnsweredOptions(obj.dataset.pregunta, obj_value, obj_name)) {
        p[obj_name] = obj_value

        //console.log(p)
    }

    //Si hay respondido las opciones habilita el botón de finalizar
    validateTotalOptions()
}

//Defensivo
function toD(obj) {
    const obj_name = obj.name
    const obj_value = obj.value

    if (validateAnsweredOptions(obj.dataset.pregunta, obj_value, obj_name)) {
        d[obj_name] = obj_value

        //console.log(d)
    }

    //Si hay respondido las opciones habilita el botón de finalizar
    validateTotalOptions()
}

//Reactivo
function toR(obj) {
    const obj_name = obj.name
    const obj_value = obj.value

    if (validateAnsweredOptions(obj.dataset.pregunta, obj_value, obj_name)) {
        r[obj_name] = obj_value

        //console.log(r)
    }

    //Si hay respondido las opciones habilita el botón de finalizar
    validateTotalOptions()
}

//Sumar el total de las opciones contestadas
function validateTotalOptions() {
    let totalBryg = parseInt(Object.keys(radical).length) + parseInt(Object.keys(genuino).length) + parseInt(Object.keys(garante).length) + parseInt(Object.keys(basico).length)
    let totalAumented = parseInt(Object.keys(a).length) + parseInt(Object.keys(p).length) + parseInt(Object.keys(d).length) + parseInt(Object.keys(r).length)

    let total = totalBryg + totalAumented

    if (total === 1) {
        addEventListener("beforeunload", beforeUnloadListener, {capture: true});
    }

    if (total >= 152) {
        buttonBox.removeAttribute('hidden')
        paginationButtons.setAttribute('hidden', true)

        return true
    }else {
        return false
    }
}

function validateAnsweredOptions(preguntaId, opcionPregunta, inputNombreClase) {
    //Buscar si ya existe el objeto de la pregunta
    const findQuestion = questions.find((pregunta) => pregunta.pregunta === parseInt(preguntaId))

    if (findQuestion !== undefined) {
        //Se busca si ya existe otra opción con el mismo valor
        const findOption = findQuestion.respuestas.find((respuesta) => respuesta.valor === parseInt(opcionPregunta))

        if (findOption !== undefined) {
            //Si encuentra un valor igual y el valor es de una estrella ya elegida asigna el nuevo valor
            if (findOption.estrella === inputNombreClase) {
                findOption.valor = parseInt(opcionPregunta)
            }

            //Si encuentra una opción igual a la seleccionada, devuelve false y resetea
            if (findQuestion.respuestas.length === 4) {
                findQuestion.respuestas = findQuestion.respuestas.filter(respuesta => respuesta.estrella !== inputNombreClase)
            }

            document.querySelector(`#${inputNombreClase}`).click() //input type reset

            $.smkAlert({
                text: 'No debes contestar dos opciones con el mismo número de estrellas.',
                type: 'danger'
            })

            //console.log('false')
            //console.log(questions)
            return false
        }else {
            const findStar = findQuestion.respuestas.find((respuesta) => respuesta.estrella === inputNombreClase)

            if (findStar !== undefined) {
                //Se actualiza el valor de la opción
                findStar.valor = parseInt(opcionPregunta)
            }else {
                //Si no existe o no esta repetida agrega la nueva opción contestada al arreglo de respuestas
                findQuestion.respuestas.push(
                    {
                        estrella: inputNombreClase,
                        valor: parseInt(opcionPregunta)
                    }
                )
            }

            //console.log('true')
            //console.log(questions)
            return true
        }
    }else {
        //Si no existe, crea el objeto de la pregunta
        questions.push(
            {
                pregunta: parseInt(preguntaId),
                respuestas: []
            }
        )

        //Vuelve y se busca la pregunta
        const findNewQuestion = questions.find((pregunta) => pregunta.pregunta === parseInt(preguntaId))

        //Se busca si ya existe otra opción con el mismo valor
        const findOption = findNewQuestion.respuestas.find((respuesta) => respuesta.valor === parseInt(opcionPregunta))

        if (findOption !== undefined) {
            //Si encuentra un valor igual y el valor es de una estrella ya elegida asigna el nuevo valor
            if (findOption.estrella === inputNombreClase) {
                findOption.valor = parseInt(opcionPregunta)
            }

            //Si encuentra una opción igual a la seleccionada, devuelve false y resetea
            if (findNewQuestion.respuestas.length === 4) {
                findNewQuestion.respuestas = findNewQuestion.respuestas.filter(respuesta => respuesta.estrella !== inputNombreClase)
            }

            //Si encuentra una opción igual a la seleccionada, devuelve false y resetea
            document.querySelector(`#${inputNombreClase}`).click() //input type reset

            $.smkAlert({
                text: 'No debes contestar dos opciones con el mismo número de estrellas.',
                type: 'danger'
            })

            //console.log('false')
            //console.log(questions)
            return false
        }else {
            const findStar = findNewQuestion.respuestas.find((respuesta) => respuesta.estrella === inputNombreClase)

            if (findStar !== undefined) {
                //Se actualiza el valor de la opción
                findStar.valor = parseInt(opcionPregunta)
            }else {
                //Si no existe o no esta repetida agrega la nueva opción contestada al arreglo de respuestas
                findNewQuestion.respuestas.push(
                    {
                        estrella: inputNombreClase,
                        valor: parseInt(opcionPregunta)
                    }
                )
            }

            //console.log('true')
            //console.log(questions)
            return true
        }
    }
}

const saveTest = document.querySelector('#saveTest');

//Guardar resultados prueba
saveTest.addEventListener('click', () => {
    //Suma de resultados para perfilamiento
    let radicalAll = 0;
    let genuinoAll = 0;
    let garanteAll = 0;
    let basicoAll  = 0;

    //Recorre los objetos con la información de las opciones y asigna el valor al nuevo objeto
    for(let index_radical in radical) {
        radicalAll = radicalAll + parseInt(radical[index_radical])
    }

    for(let index_genuino in genuino) {
        genuinoAll = genuinoAll + parseInt(genuino[index_genuino])
    }

    for(let index_garante in garante) {
        garanteAll = garanteAll + parseInt(garante[index_garante])
    }

    for(let index_basico in basico) {
        basicoAll = basicoAll + parseInt(basico[index_basico])
    }

    //Suma de resultados para aumented
    let aAll = 0;
    let pAll = 0;
    let dAll = 0;
    let rAll = 0;

    for(let index_a in a) {
        aAll = aAll + parseInt(a[index_a])
    }

    for(let index_p in p) {
        pAll = pAll + parseInt(p[index_p])
    }

    for(let index_d in d) {
        dAll = dAll + parseInt(d[index_d])
    }

    for(let index_r in r) {
        rAll = rAll + parseInt(r[index_r])
    }

    //Data, crea un objeto form para el envío de resultados
    let data = new FormData();

    data.append('estilo_radical', radicalAll);
    data.append('estilo_genuino', genuinoAll);
    data.append('estilo_garante', garanteAll);
    data.append('estilo_basico', basicoAll);
    data.append('aumented_a', aAll);
    data.append('aumented_p', pAll);
    data.append('aumented_d', dAll);
    data.append('aumented_r', rAll);

    data.append('userId', document.querySelector('#userId').value);
    data.append('requerimientoId', document.querySelector('#requerimientoId').value);

    data.append('_token', document.querySelector('meta[name="token"]').getAttribute('content'));

    //Mostrar pantalla de progreso
    $.smkProgressBar({
        element: 'body',
        status: 'start',
        bgColor: '#2E2D66',
        barColor: '#fff',
        content: `
            <div class="row">
                <div class="col-md-12">
                    <img src="https://desarrollo.t3rsc.co/img/circle-loader.gif" width="50">
                </div>
                <div class="col-md-12">
                    <h3><b>Guardando resultados</b></h3>
                </div>
            </div>
        `
    });

    //
    if (se_toman_fotos) {
        stopWebcam()
        clearInterval(intervalWebcam)
    }

    fetch('prueba_perfilamiento_save', {
        method : 'post',
        body : data,
        headers :{
            'X-CSRF-TOKEN': document.querySelector('meta[name="token"]').getAttribute('content')
        }
    })
    .then(content => {
        //Data, crea un objeto form para el envío de resultados
        let dataFoto = new FormData();

        dataFoto.append('userId', parseInt(document.querySelector('#userId').value));
        dataFoto.append('requerimientoId', document.querySelector('#requerimientoId').value);
        dataFoto.append('brygImagenes', JSON.stringify(brygPictures));
        dataFoto.append('_token', document.querySelector('meta[name="token"]').getAttribute('content'));

        fetch('prueba-bryg-guardar-fotos', {
            method : 'post',
            body : dataFoto,
            headers :{
                'X-CSRF-TOKEN': document.querySelector('meta[name="token"]').getAttribute('content')
            }
        })
        .then(content => {
            //
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
        })
        .catch(error => console.log(error))
    })
    .catch(error => console.log(error))
})

/*
let lista_preguntas = ids;

//Load on scroll end
let page = 2;
const load = document.querySelector('#load');

//Contenedor (DIV) del botón finalizar prueba
const buttonBox = document.querySelector('#buttonBox');
const paginationButtons = document.querySelector('#paginationButtonBox')

//No se puede usar este lazy load porque las preguntas se muestran random
window.onscroll = () => {
    load.removeAttribute('hidden');

    if((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight){
        fetch(`prueba_perfilamiento/siguiente?page=${page}&ids=${lista_preguntas}`, {
            method : 'get'
        })
        .then(response => response.text())
        .then(content => {
            let json = JSON.parse(content);
            lista_preguntas = json.ids;

            load.setAttribute('hidden', '');

            document.querySelector('#content-box').insertAdjacentHTML('beforeend', json.view)
            page++;
        })
        .catch(error => console.log(error))
    }
}*/