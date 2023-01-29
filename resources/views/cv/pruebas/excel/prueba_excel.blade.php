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

        .d-none { display: none !important; }

        .f-white {
            background-color: #fff;
        }

        .z-index-f {
            z-index: -1;
        }

        .panel-info {
            border-color: #a3a2f5;
        }

        .panel-info > .panel-heading {
            color: white;
            background-color: #2E2D66;
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
            color: white;
            background-color: #E4E42A;
        }

        .question-page-numbers > li > a.active{
            color: white;
            background-color: #E4E42A;
        }

        .text-red {
            color: #961212;
        }
    </style>

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
                    Hola <b>{{ $name_user->nombre_candidato }}</b>, te damos la bienvenida a la realización de la prueba de {{ $nombre_prueba }} que el equipo de selección de <b>{{ $sitio->nombre }}</b> ha preparado para ti.
                </p>

                <p>
                    A continuación te vamos a hacer una serie de preguntas, las cuales nos servirán para medir tu conocimiento de Excel. Las instrucciones son las siguientes:
                </p>

                <p>
                    <span><b>1.</b></span> Vas a encontrar <b>{{ $total_preguntas }} preguntas</b> de múltiples opciones, con respuesta única.
                </p>

                <p>
                    <span><b>2.</b></span> Debes responder a todos los enunciados, en el menor tiempo posible. Tendrás <b>{{ $configuracion->tiempo_maximo }} minutos</b> máximo para responder la prueba.
                </p>

                <p>
                    <span><b>3.</b></span> Cada enunciado está acompañado de múltiples opciones de respuesta, debes seleccionar la que creas correcta.
                </p>

                <p>
                    <span><b>4.</b></span> Soló puedes responder una vez la prueba, asegúrate de contar con una conexión estable de internet antes de responder.
                </p>

                <p>
                    <span><b>5.</b></span> Se solicitará permiso para acceder a tu cámara, ya que te tomaremos fotos mientras respondes la prueba para mantener el registro de quien respondió la misma.
                </p>

                <blockquote class="mt-2" style="font-size: 15.5px;">
                    <p>
                        Te sugerimos que estés concentrado respondiendo la prueba para no afectar los resultados. A continuación encontrarás la pregunta de ejemplo y posteriormente las preguntas correspondientes. ¡Muchos éxitos!
                    </p>
                </blockquote>
            </div>

            <div class="col-md-12">
                <div class="page-header title-bryg">
                    <h4>Ejemplo <br class="jump-line" hidden></h4>
                </div>

                <div class="panel panel-warning mt-2">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Una hoja de cálculo en Excel tiene la extensión:
                            <i 
                                class="text-right fa fa-question-circle"
                                data-toggle="tooltip" 
                                data-placement="right" 
                                title="Debes seleccionar la opción que consideres correcta."
                            ></i>
                        </h3>
                    </div>

                    <ol class="list-group">
                        <li class="list-group-item">
                            <label><input type="radio" name="prueba"> exc </label>
                        </li>
                        <li class="list-group-item">
                            <label><input type="radio" name="prueba"> xls </label>
                        </li>
                        <li class="list-group-item">
                            <label><input type="radio" name="prueba"> doc </label>
                        </li>
                        <li class="list-group-item">
                            <label><input type="radio" name="prueba"> pdf </label>
                        </li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-12 text-center mb-4">
                <button type="button" class="btn btn-lg btn-success" id="comenzar">Comenzar prueba</button>
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
                    @include('cv.pruebas.excel.paginacion_contenido')
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

    <script>
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

        $('#frm-prueba input').on('click', function() { 
            let resp = 0;
            $('#frm-prueba input').each(function(index, element) {
                if(element.checked) {
                    resp++;
                    if (resp === 1) {
                        addEventListener("beforeunload", beforeUnloadListener, {capture: true});
                    }
                }
            });
            $('#nroRespuestas').html(resp);
            if (resp == totalPreguntas) {
                buttonBox.removeAttribute('hidden');
            }
        });

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
            if (se_toman_fotos) {
                clearInterval(tiempo_foto);

                tomarFoto();
            }

            let data = new FormData(document.getElementById("frm-prueba"));

            data.append('userId', document.querySelector('#userId').value);
            data.append('req_id', document.querySelector('#req_id').value);

            data.append('fotosExcel', JSON.stringify(fotos));

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
    <script src="{{ asset('js/paginator-js/paginga.jquery.js') }}"></script>
    <script>
        $(".question-paginate").paginga({
            itemsPerPage: 5,
            itemsContainer: '.question-items',
            pageNumbers: '.question-page-numbers'
        })
    </script>
@stop