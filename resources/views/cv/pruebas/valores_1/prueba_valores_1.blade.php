{{-- Notese el orden y tabulación de las etiquetas, hace entendible la lectura de la vista y facilita la modificación en caso de ser necesario. --}}
@extends("cv.layouts.master_out")
@section('content')
    <style>
        .text-justify{ text-align: justify; }

        .mt-0{ margin-top: 0; }
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .mb-0{ margin-bottom: 0; }
        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .pt-0{ padding-top: 0rem !important; }

        .d-none { display: none !important; }

        .f-white {
            background-color: #fff;
        }

        .z-index-f {
            z-index: -1;
        }

        .panel-info {
            border: 2px #2E2D66 solid;
            border-color: #2E2D66;
        }

        .panel-info > .panel-heading {
            color: black;
            background-color: #c6d4f3;
            border-color: #2E2D66;
        }

        .btn-primary {
            color: #fff;
            background-color: #2E2D66;
            border-color: #2E2D66;
        }

        .btn-primary:hover {
            background-color: #201f4a;
        }

        .btn-primary:focus {
            background-color: #201f4a;
        }

        .btn-primary.disabled {
            background-color: #5a58b0;
            border-color: #5a58b0;
        }

        .btn-primary.disabled:focus {
            background-color: #5a58b0;
            border-color: #5a58b0;
        }

        .question-page-numbers > li{
            font-weight: 700;
            margin: 0.2rem;
        }

        .question-page-numbers > li > a:hover{
            color: black;
            background-color: #40F2FE;
        }

        .question-page-numbers > li > a.active{
            color: black;
            background-color: #40F2FE;
        }

        .text-red {
            color: #961212;
        }

        .bl-example {
            border-left: 2px #8a6d3b solid;
        }

        .br-example {
            border-right: 2px #8a6d3b solid;
        }

        .bl-2 {
            border-left: 2px #2e2d66 solid;
        }

        .br-2 {
            border-right: 2px #2e2d66 solid;
        }

        .bt-0 {
            border-top: 0px !important;
        }

        .ancho-celda {
            height: 30px;
        }
    </style>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ url('js/rateyo/jquery.rateyo.css') }}">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img alt="Prueba" src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="60">
                </a>
            </div>

            <div class="collapse navbar-collapse">
                <p class="navbar-text navbar-right">{{ $user->name }}</p>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row" id="informacion-inicial">
            <div class="col-md-12 text-justify">
                <div class="page-header title-bryg">
                    <h3>Instrucciones para realizar la prueba <small class="text-danger"><b class="title-helper">LEE ATENTAMENTE</b></small></h3>
                </div>

                <p>
                    Hola <b>{{ $name_user->nombre_candidato }}</b>, te damos la bienvenida a la realización de la {{ $nombre_prueba }} que el equipo de selección de <b>{{ $sitio->nombre }}</b> ha preparado para ti.
                </p>

                <p>
                    A continuación te vamos a hacer una serie de preguntas, las cuales nos servirán para identificar características de tu personalidad, por lo cual no hay respuestas buenas o malas, simplemente queremos conocerte un poco más. Las instrucciones son las siguientes:
                </p>

                <p>
                    <span><b>1.</b></span> Vas a encontrar <b>{{ $total_preguntas }} preguntas</b>, con dos premisas las cuales puedes valorar de 0 a 6 estrellas máximo (entre cada premisa); donde 6 estrellas es lo que más te identifica con la frase o la acción que más te molesta, esto va a depender del enunciado de la pregunta.
                </p>

                <p>
                    <span><b>2.</b></span> Debes responder a todos los enunciados, en el menor tiempo posible. Tendrás <b>{{ $configuracion->tiempo_maximo }} minutos</b> máximo para responder la prueba.
                </p>

                <p>
                    <span><b>3.</b></span> En cada enunciado tendrás 2 premisas, a las cuales podrás asignar de 0 a 6 estrellas de acuerdo con tus preferencias.
                </p>

                <p>
                    <span><b>4.</b></span> El sistema balancea automáticamente la asignación de estrellas de acuerdo con tu selección, por ejemplo, si asignaste 4 estrellas a la premisa de la izquierda, el sistema automáticamente asignará 2 estrellas a la premisa de la derecha. O si le asignas 1 estrella a la premisa de la izquierda, el sistema le asignará 5 estrellas a la premisa de la derecha.
                </p>

                <p>
                    <span><b>5.</b></span> No puedes dar el valor de 3 estrellas a las premisas, pues esperamos encontrar las tendencias orientadas a una premisa u otra.
                </p>

                <p>
                    <span><b>6.</b></span> Debes estar atento a cada enunciado de la pregunta, porque en ocasiones te preguntaremos con cual frase te sientes más identificado y en otras te cuestionaremos por la frase más inaceptable para ti.
                </p>

                <blockquote class="mt-2" style="font-size: 15.5px;">
                    <p>
                        Se solicitará permiso para acceder a tu cámara, ya que te tomaremos fotos mientras respondes la prueba para mantener el registro de quien respondió la misma.
                    </p>
                </blockquote>

                <blockquote class="mt-2" style="font-size: 15.5px;">
                    <p>
                        Recuerda que no hay respuestas correctas o incorrectas, se lo más honesta/o posible, no lo pienses demasiado y responde con lo primero que venga a tu cabeza!<br>
                        Muchos éxitos en tu proceso de selección
                    </p>
                </blockquote>
            </div>

            <div class="col-md-12">
                <div class="page-header title-bryg">
                    <h4>Ejemplo <br class="jump-line" hidden><small><b>Esta pregunta es la representación de como debes responder la prueba.</b></small></h4>
                </div>

                <p><b>Responde como si te identificaras más con la frase "El chocolate es la solución para todo". </b> <span class="small">Presiona 4 o más estrellas para esa opción, como se te muestra en el ejemplo a continuación:</span></p>

                <div class="row col-md-12 text-center mb-2">
                    <img src="{{ asset('img/ejemplo-ethical-values.png') }}" style="max-width: 80%">
                </div>

                <p class="mt-2">¡Ahora es tu turno de practicar, selecciona las estrellas como se te indica en el ejemplo!</p>
                <div class="panel panel-info mt-1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Me identifico más con la frase…
                            <i 
                                class="text-right fa fa-info-circle"
                                data-toggle="tooltip" 
                                data-placement="right" 
                                title="Presiona para seleccionar la cantidad de estrellas para dar un valor de 0 a 6 estrellas a cada premisa."
                            ></i>
                        </h3>
                    </div>
                    <table class="table">
                        <tr>
                            <td width="50%" class="br-example">
                                El chocolate es la solución para todo
                                <br>
                                <div
                                    class="rateYoLeftExample pull-right"
                                    id="calificacion1"
                                    data-inverso="calificacion2"
                                ></div>
                            </td>
                            <td width="50%" class="bl-example">
                                A veces hay decisiones un poco difíciles
                                <br>
                                <div
                                    class="rateYoRightExample"
                                    id="calificacion2"
                                    data-inverso="calificacion1"
                                ></div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" class="br-example bt-0">
                                <span class="small pull-right" id="calificacion1_star"></span>
                            </td>
                            <td width="50%" class="bl-example bt-0">
                                <span class="small" id="calificacion2_star"></span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="col-md-12 text-center mb-4">
                <button type="button" class="btn btn-lg btn-success" id="comenzar" disabled="">Comenzar prueba</button>
            </div>
        </div>
        <div class="row" hidden id="mostrar-prueba">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="mt-0">
                            Preguntas Respondidas <span id="nroRespuestas">0</span>/{{ $total_preguntas }}
                        </h3>
                    </div>
                    <div class="col-md-6 pull-right">
                        <h3 class="pull-right mt-0">
                            Restan <span id="tiempoRestante">{{ $configuracion->tiempo_maximo }} minutos : 00 segundos</span>
                        </h3>
                    </div>
                </div>
            </div>

                {{-- Id del usuario y del requerimiento --}}
                <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
                <input type="hidden" name="req_id" id="req_id" value="{{ $req_id }}">

            <form id="frm-prueba">
                {{-- Incluye vista con todas la preguntas a listar paginadas --}}
                <div class="col-md-12" id="content-box">
                    @include('cv.pruebas.valores_1.paginacion_contenido')
                </div>
            </form>
        </div>
    </div>
    <div class="row" id="rowCam" style="background-color: #fff;">
        <div class="col-md-12">
            <div class="col-md-12 text-center" style="z-index: -1;">
                <video id="webcam" autoplay playsinline width="640" height="420"></video>
                <canvas id="canvas" class="d-none" hidden></canvas>
            </div>
        </div>
    </div>

    @if(Session::has("reloadPage"))
        {{ Session::put('reloadPage', 'yes') }}

        <script>
            //location.reload()
        </script>
    @endif

    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ url('js/rateyo/jquery.rateyo.js') }}"></script>

    <script>
        unsaved = false;
        idElementMsj = null;
        $(function () {
            $(".rateYoLeftExample").rateYo({
                starWidth: "24px",
                fullStar: true,
                normalFill: "#A0A0A0",
                rtl: true,
                numStars: 6,
                maxValue: 6,
                multiColor: {
                  "startColor": "#00AAE4", //ALICEBLUE
                  "endColor"  : "#40F2FE"  //BLUE
                },
                onChange: function (rating, rateYoInstance) {
                    let valorInverso = 6 - rating;
                    let itemInverso = $('#'+this.dataset.inverso);
                    let span = $('#'+this.id+'_star');
                    let spanInverso = $('#'+this.dataset.inverso+'_star');
                    itemInverso.rateYo("rating", valorInverso);
                    span.text('Haz seleccionado '+rating+' estrella(s)');
                    spanInverso.text('Haz seleccionado '+valorInverso+' estrella(s)');

                    if ($('#calificacion1').rateYo("rating") > 3) {
                        $('#comenzar').removeAttr('disabled');
                    } else {
                        $('#comenzar').prop('disabled', true);
                    }
                },
                onSet: function (rating, rateYoInstance) {
                    if (rating === 3) {
                        if (idElementMsj != '#'+this.id) {
                            $.smkAlert({
                                text: 'No puede seleccionar 3 estrellas en ambos enunciados. Por favor seleccione otros valores.',
                                type: 'danger',
                            });
                            idElementMsj = '#'+this.id;
                        }
                        $('#'+this.id).rateYo("rating", 2);
                        $('#'+this.dataset.inverso).rateYo("rating", 4);
                        $('#'+this.dataset.input).val(2);
                        $('#'+this.dataset.inputinverso).val(4);
                        return false;
                    }
                }
            });
            $(".rateYoRightExample").rateYo({
                starWidth: "24px",
                fullStar: true,
                normalFill: "#A0A0A0",
                numStars: 6,
                maxValue: 6,
                multiColor: {
                  "startColor": "#00AAE4", //ALICEBLUE
                  "endColor"  : "#40F2FE"  //BLUE
                },
                onChange: function (rating, rateYoInstance) {
                    let valorInverso = 6 - rating;
                    let itemInverso = $('#'+this.dataset.inverso);
                    itemInverso.rateYo("rating", valorInverso);
                    let span = $('#'+this.id+'_star');
                    let spanInverso = $('#'+this.dataset.inverso+'_star');
                    itemInverso.rateYo("rating", valorInverso);
                    span.text('Haz seleccionado '+rating+' estrella(s)');
                    spanInverso.text('Haz seleccionado '+valorInverso+' estrella(s)');

                    if ($('#calificacion1').rateYo("rating") > 3) {
                        $('#comenzar').removeAttr('disabled');
                    } else {
                        $('#comenzar').prop('disabled', true);
                    }
                }
            });

            $(".rateYoLeft").rateYo({
                starWidth: "24px",
                fullStar: true,
                normalFill: "#A0A0A0",
                rtl: true,
                numStars: 6,
                maxValue: 6,
                multiColor: {
                  "startColor": "#00AAE4", //ALICEBLUE
                  "endColor"  : "#40F2FE"  //BLUE
                },
                onChange: function (rating, rateYoInstance) {
                    let valorInverso = 6 - rating;
                    let itemInverso = $('#'+this.dataset.inverso);
                    itemInverso.rateYo("rating", valorInverso);

                    $('#'+this.dataset.input).val(rating);
                    $('#'+this.dataset.inputinverso).val(valorInverso);

                    $('#'+this.dataset.input+'_star').text('Haz seleccionado '+rating+' estrella(s)');
                    $('#'+this.dataset.inputinverso+'_star').text('Haz seleccionado '+valorInverso+' estrella(s)');

                    let resp = 0;
                    $('#frm-prueba input').each(function(index, element) {
                        if(element.value != '') {
                            resp++;
                        }
                    });
                    resp /= 2;
                    if (resp === 1) {
                        addEventListener("beforeunload", beforeUnloadListener, {capture: true});
                    }
                    $('#nroRespuestas').html(resp);
                    if (resp == totalPreguntas) {
                        buttonBox.removeAttribute('hidden');
                    }
                },
                onSet: function (rating, rateYoInstance) {
                    if (rating === 3) {
                        if (idElementMsj != '#'+this.id) {
                            $.smkAlert({
                                text: 'No puede seleccionar 3 estrellas en ambos enunciados. Por favor seleccione otros valores.',
                                type: 'danger',
                            });
                            idElementMsj = '#'+this.id;
                        }
                        $('#'+this.id).rateYo("rating", 2);
                        $('#'+this.dataset.inverso).rateYo("rating", 4);
                        $('#'+this.dataset.input).val(2);
                        $('#'+this.dataset.inputinverso).val(4);
                        //return false;
                    }
                }
            });
            $(".rateYoRight").rateYo({
                starWidth: "24px",
                fullStar: true,
                normalFill: "#A0A0A0",
                numStars: 6,
                maxValue: 6,
                multiColor: {
                  "startColor": "#00AAE4", //ALICEBLUE
                  "endColor"  : "#40F2FE"  //BLUE
                },
                onChange: function (rating, rateYoInstance) {
                    let valorInverso = 6 - rating;
                    let itemInverso = $('#'+this.dataset.inverso);
                    itemInverso.rateYo("rating", valorInverso);

                    $('#'+this.dataset.input).val(rating);
                    $('#'+this.dataset.inputinverso).val(valorInverso);

                    $('#'+this.dataset.input+'_star').text('Haz seleccionado '+rating+' estrella(s)');
                    $('#'+this.dataset.inputinverso+'_star').text('Haz seleccionado '+valorInverso+' estrella(s)');

                    let resp = 0;
                    $('#frm-prueba input').each(function(index, element) {
                        if(element.value != '') {
                            resp++;
                        }
                    });
                    resp /= 2;
                    if (resp === 1) {
                        addEventListener("beforeunload", beforeUnloadListener, {capture: true});
                    }
                    $('#nroRespuestas').html(resp);
                    if (resp == totalPreguntas) {
                        buttonBox.removeAttribute('hidden');
                    }
                }
            });
        });
        const buttonBox = document.querySelector('#buttonBox');
        const paginationButtons = document.querySelector('#paginationButtonBox');
        const saveTest = document.querySelector('#saveTest');

        const webcamElement = document.getElementById('webcam');
        const canvasElement = document.getElementById('canvas');
        const webcam = new Webcam(webcamElement, 'user', canvasElement);
        const fotos = [];

        const beforeUnloadListener = (event) => {
            event.preventDefault();
            return event.returnValue = "¿Deseas salir de la prueba?";
        };

        let redir = "{{ $ruta_resultados }}";
        let totalPreguntas = parseInt("{{ $total_preguntas }}");
        let ids = {{ json_encode($ids) }};
        let pictureCount = 1;
        let tiempo = {
            minutos: parseInt("{{ $configuracion->tiempo_maximo }}"),
            segundo: 0
        };
        let se_toman_fotos = true;

        /*$('#frm-prueba input').on('click', function() { 
            let resp = 0;
            $('#frm-prueba input').each(function(index, element) {
                if(element.checked) {
                    resp++;
                }
            });
            $('#nroRespuestas').html(resp);
            if (resp == totalPreguntas) {
                buttonBox.removeAttribute('hidden');
            }
        });*/

        function continuar_prueba() {
            $.smkProgressBar({
                status:'end'
            });

            $('#informacion-inicial').hide();
            $('#mostrar-prueba').show();
            $('#mostrar-vide-prueba').show();
            $("html, body").animate({ scrollTop: 0 }, 200);

            tiempo_corriendo = setInterval(function(){
                // Segundos
                if (tiempo.segundo === 0 && tiempo.minutos > 0) {
                    tiempo.minutos--;
                    tiempo.segundo = 59;
                } else if (tiempo.segundo > 0) {
                    tiempo.segundo--;
                }
                if(tiempo.minutos === 0 && tiempo.segundo <= 0) {
                    detener();
                }

                $("#tiempoRestante").text(tiempo.minutos + ' minutos : ' + ((tiempo.segundo < 10) ? '0' + tiempo.segundo : tiempo.segundo) + ' segundos');
                if (tiempo.minutos === 0 && tiempo.segundo < 11) {
                    $("#tiempoRestante").toggleClass('text-red');
                }
            }, 1000);
        }

        $("#comenzar").on("click", function () {
            $.smkProgressBar({
                element:'body',
                status:'start',
                bgColor: '#000',
                barColor: '#fff',
                content: `
                        <div class="row">
                            <div class="col-md-12">
                                <h3><b>Se solicitarán los permisos para acceder a su cámara y micrófono. <br> Por favor presione "Permitir".</b></h3>
                            </div>
                        </div>
                    `
            });
            webcam.start()
               .then(result =>{
                    console.log("webcam started");

                    setTimeout(() => {
                        let foto = webcam.snap();
                        webcam.stop();
                        $('#rowCam').addClass('d-none');

                        fotos.push({
                            'name': `excel-foto-${pictureCount}`,
                            'picture': foto
                        })

                        pictureCount++;

                        tiempo_foto = setInterval(function(){
                            tomarFoto();
                        }, 120000)
                    }, 2500)

                    continuar_prueba();

                })
                .catch(err => {
                    console.log(err);
                    swal("Error al iniciar la cámara", "Se ha producido un error al iniciar la cámara, porque no lo admite su navegador o porque no ha permitido el uso de la cámara.", "warning", {
                        buttons: {
                            si: { text: "Continuar",className:'btn btn-warning' },
                        },
                    }).then((value) => {
                        if (value == "si") {
                            se_toman_fotos = false;
                            $('#rowCam').hide();
                            continuar_prueba();
                            return;
                        } else {
                            location.reload(true);
                        }
                    });
                });
        });

        function tomarFoto() {
            let foto = null;
            webcam.start()
               .then(result =>{
                    console.log("webcam iniciada tomarFoto");
                })
                .catch(err => {
                    console.log(err);
                });
            setTimeout(() => {
                $('#rowCam').removeClass('d-none');
                foto = webcam.snap();
                webcam.stop();
                $('#rowCam').addClass('d-none');

                fotos.push({
                    'name': `excel-foto-${pictureCount}`,
                    'picture': foto
                })

                pictureCount++
                if (pictureCount == 7) {
                    clearInterval(tiempo_foto);
                }
            }, 3500)
        }

        function detener () {
            $("#tiempoRestante").text('0 minutos : 00 segundos');
            saveTest.click();
        }

        //Guardar resultados prueba
        saveTest.addEventListener('click', () => {
            $('#buttonBox').hide();
            clearInterval(tiempo_corriendo);

            if(se_toman_fotos) {
                clearInterval(tiempo_foto);
            }

            let data = new FormData(document.getElementById("frm-prueba"));

            data.append('userId', document.querySelector('#userId').value);
            data.append('req_id', document.querySelector('#req_id').value);

            data.append('fotosPrueba', JSON.stringify(fotos));

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
                            <h3><b>Guardando respuestas</b></h3>
                        </div>
                    </div>
                `
            });

            $.ajax({
                type: "POST",
                data: data,
                url: "{{ $ruta_save }}",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response){
                    removeEventListener("beforeunload", beforeUnloadListener, {capture: true});

                    if(response.success) {
                        $.smkAlert({
                            text: 'Respuestas guardadas correctamente.',
                            type: 'success',
                        });


                        setTimeout(() => {
                            $.smkProgressBar({
                                status:'end'
                            });
                        }, 1500)

                        swal("Prueba finalizada", "¡Culminaste la prueba exitosamente!", "success", {
                            buttons: {
                                si: { text: "Ok",className:'btn btn-success' },
                            },
                        }).then((value) => {
                            if (value == "si") {
                                window.location.href = "{{ route('dashboard') }}";
                            } else {
                                window.location.href = "{{ route('dashboard') }}";
                            }
                        });
                    } else {
                        setTimeout(() => {
                            $.smkProgressBar({
                                status:'end'
                            });
                        }, 1500)

                        $.smkAlert({
                            text: response.mensaje,
                            type: 'danger',
                        });

                        setTimeout(() => {
                            window.location.href = response.ruta
                        }, 2500)
                    }
                }
            });
        })

    </script>

    {{-- Paginga Js --}}
    <script src="{{ asset('js/cv/paginator-js/ps-paginga.jquery.js') }}"></script>
    <script>
        $(".question-paginate").paginga({
            itemsPerPage: 5,
            itemsContainer: '.question-items',
            pageNumbers: '.question-page-numbers',
            scrollToTop: {
                offset: 70,
                speed: 100,
            },
        })

        const validateAnswers = () => {
            let activePage = document.querySelector('.active').dataset.page
            let itemsPerPage = 5
            let itemsInput = 2
            let loops = itemsPerPage * activePage * itemsInput

            let answerValue = 0

            const rbs = document.querySelectorAll(`.table input`)

            for (const rb of rbs) {
                if (rb.value != '') {
                    answerValue++
                }
            }

            if (answerValue === loops) {
                return false
            }
            return true
        }

        const showAlert = () => {
            $.smkAlert({
                text: 'Parece que has olvidado responder una o más preguntas, verifica antes de continuar',
                type: 'warning',
            });
        }
    </script>
@stop