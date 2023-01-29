<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="{{csrf_token()}}" name="token">

        {{-- <title>
        Firma de contrato
        </title> --}}

        {{-- drawingboard CSS --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('js/drawingboard/drawingboard.min.css') }}">
        
        <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
        
        <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

        <script src="{{ asset('public/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        {{-- drawingboard JS --}}
        <script src="{{ asset('js/drawingboard/drawingboard.min.js') }}" type="text/javascript"></script>

        <style type="text/css">
            a{ text-decoration:none; }

            .mt-4{ margin-top: 4rem; }
            .mb-2{ margin-bottom: 2rem; }
            
            .clear{clear:both;}/* clear float */

            img{max-width:100%;}

            #imagen_firma div{ float: left;}
                
            .agile-wi { width: 73%; margin: 3% auto 0%; }

            #contrato p{ color: black; }

            div #instruccion{
                text-decoration: underline;
                position: absolute;
                right: 48%;
                top: 75%;
            }

            #contrato{
                width: 100%;
                height: auto;
                background: white;
                border-radius: 12px 12px 10px 10px;
            }

            body {font-family: 'Philosopher', sans-serif;}
                
            #myCanvas {
                border: 1px solid #444;
                border-radius: 63px;
                background-color: #fafafa;
            }

            .container { margin: 80px auto; }
                
            .agile-wi{width: 85%!important;}

            /*.swal2-popup { font-size: 1.4rem !important; }*/
        </style>
    </head>
<body>
    <?php $mostrar_siguiente_clausula = true; ?>

    @if($documentos_parametrizados->count() > 0)
        @if($documento != null)
            <?php
                $documento_mostrar = "home.include.adicionales.documento_".$documento->idDocumento;
                $mostrar_siguiente_clausula = false;
            ?>
            
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-12 mt-2">
                    @if($requerimiento->logo != null)
                        <img src="{{ url('configuracion_sitio')}}/{!!$requerimiento->logo!!}" width="100">
                    @else
                        @if(isset(FuncionesGlobales::sitio()->logo))
                            @if(FuncionesGlobales::sitio()->logo != "")
                                <img class="center fixedwidth"
                                    align="center"
                                    border="0"
                                    src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}"
                                    alt="Logo"
                                    title="Logo"
                                    style="clear: both; border: 0; height: auto; float: left;" width="150"
                                >
                            @else
                                <img class="center fixedwidth"
                                    align="center"
                                    border="0"
                                    src="{{ url("img/logo.png")}}"
                                    alt="Logo"
                                    title="Logo"
                                    style="clear: both; border: 0; height: auto; float: left;" width="150"
                                >
                            @endif
                        @else
                            <img src="{{ url("img/logo.png")}}" style="clear: both; border: 0; height: auto; float: left;" width="282" height="100">
                        @endif
                    @endif
                </div>

                {{-- <div class="col-md-12">
                    <h2 class="text-center">Firma de documentos adicionales</h2>
                </div> --}}

                {{-- <div class="col-md-12 mt-2 mb-2">
                    <h3 style="font-weight: bold;">Documento:</h3>
                </div> --}}

                {{-- Muestra el cuerpo de la cláusula --}}
                <div class="col-md-12 mt-4">
                    <div>
                        @include($documento_mostrar)
                    </div>
                </div>

                {{-- Tablero de firma --}}
                <div class="col-md-12 mt-3 mb-2">
                    <div id="firmBoard" style="width: 400px; height: 160px; margin: auto;"></div>
                </div>

                <div class="col-md-12">
                    <div class="text-center">
                        <button type="button" class="btn btn-warning guardarFirma">Guardar Firma</button>
                    </div>

                    {{-- <div class="text-center mb-2">
                        <button type="button" class="btn btn-danger" id="btnCancelarContrato">Cancelar contratación</button>
                    </div> --}}
                </div>
            </div>

            <script>
                $(function (){
                    var firmBoard = new DrawingBoard.Board('firmBoard', {
                        controls: [
                            { DrawingMode: { filler: false, eraser: false,  } },
                            { Navigation: { forward: false, back: false } }
                            //'Download'
                        ],
                        size: 2,
                        webStorage: 'session',
                        enlargeYourContainer: true
                    });

                    $(".guardarFirma").on("click", function() {
                        $('.drawing-board-canvas').attr('id', 'canvas');

                        var canvas1 = document.getElementById('canvas');
                        var canvas = canvas1.toDataURL();
            
                        user_id = '{{$user_id}}';
                        req_id = '{{$req_id}}';
                        estado = 1;
                        documento_id='{{$documento->idDocumento}}';
                        contrato_id= '{{$documento->contrato_id}}';
                        
                        var token = ('_token','{{ csrf_token() }}');

                        takePicture(webcam)

                        $.ajax({
                            type: 'POST',
                            data: {
                                documento_id: documento_id,
                                contrato_id: contrato_id,
                                user_id : user_id,
                                estado : estado,
                                req_id : req_id,
                                _token : token,
                                firma : canvas
                            },
                            url: "{{ route('home.guardar-firma-adicional') }}",
                             beforeSend: function(){
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Firmando documento ...',
                                        showConfirmButton: false
                                    });
                                },
                            success: function(response) {
                                if(response.success == true){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Documento firmado.',
                                        showConfirmButton: false
                                    });

                                    setTimeout(function() {
                                        localStorage.setItem('reloadTab', false)
                                        location.reload();
                                    }, 4000);
                                }

                                /*if(response.success == false){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'info',
                                        title: 'Ya se encuentra creada la firma.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }*/
                            }
                        });
                    });
                });
            </script>

        @endif
    @endif

    {{-- Muestra cláusula generada en instancia --}}
    @if($documentos_parametrizados_creado->count() > 0 && $mostrar_siguiente_clausula)
        @if($documentoCreado != null)
            <?php $mostrar_siguiente_clausula = false; ?>

            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-12 mt-2">
                    @if($requerimiento->logo != null)
                        <img src="{{ url('configuracion_sitio')}}/{!!$requerimiento->logo!!}" width="100">
                    @else
                        @if(isset(FuncionesGlobales::sitio()->logo))
                            @if(FuncionesGlobales::sitio()->logo != "")
                                <img class="center fixedwidth"
                                    align="center"
                                    border="0"
                                    src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}"
                                    alt="Logo"
                                    title="Logo"
                                    style="clear: both; border: 0; height: auto; float: left;" width="150"
                                >
                            @else
                                <img class="center fixedwidth"
                                    align="center"
                                    border="0"
                                    src="{{ url("img/logo.png")}}"
                                    alt="Logo"
                                    title="Logo"
                                    style="clear: both; border: 0; height: auto; float: left;" width="150"
                                >
                            @endif
                        @else
                            <img src="{{ url("img/logo.png")}}" style="clear: both; border: 0; height: auto; float: left;" width="282" height="100">
                        @endif
                    @endif
                </div>
                
                {{-- <div class="col-md-12">
                    <h2 class="text-center">Firma de documentos adicionales</h2>
                </div> --}}

                {{-- Muestra el cuerpo de la cláusula --}}
                <div class="col-md-12 mt-4">
                    <div>
                        @include('admin.clausulas.include.cuerpo_documento', ["cuerpo_documento" => $nuevo_cuerpo])
                    </div>
                </div>

                {{-- Tablero de firma --}}
                <div class="col-md-12 mt-3 mb-2">
                    <div id="firmBoard" style="width: 400px; height: 160px; margin: auto;"></div>
                </div>

                <div class="col-md-12">
                    <div class="text-center">
                        <button type="button" class="btn btn-warning guardarFirma">Guardar Firma</button>
                    </div>
                </div>

                {{-- <div class="text-center mb-2">
                    <button type="button" class="btn btn-danger" id="btnCancelarContrato">Cancelar contratación</button>
                </div> --}}
            </div>

            <textarea name="nuevo_cuerpo" id="nuevo_cuerpo" hidden="">{!! $nuevo_cuerpo !!}</textarea>

            <script>
                $(function (){
                    var firmBoard = new DrawingBoard.Board('firmBoard', {
                        controls: [
                            { DrawingMode: { filler: false, eraser: false,  } },
                            { Navigation: { forward: false, back: false } }
                            //'Download'
                        ],
                        size: 2,
                        webStorage: 'session',
                        enlargeYourContainer: true
                    });

                    $(".guardarFirma").on("click", function() {
                        $('.drawing-board-canvas').attr('id', 'canvas');

                        var canvas1 = document.getElementById('canvas');
                        var canvas = canvas1.toDataURL();

                        user_id = '{{ $user_id }}';
                        req_id = '{{ $req_id }}';
                        estado = 1;
                        documento_id='{{ $documentoCreado->idDocumento }}';
                        contrato_id= '{{ $documentoCreado->contrato_id }}';

                        var creada = 1;
                        var nuevo_cuerpo = $('textarea[name="nuevo_cuerpo"]').val();

                        var token = ('_token','{{ csrf_token() }}');

                        takePicture(webcam)

                        $.ajax({
                            type: 'POST',
                            data: {
                                documento_id: documento_id,
                                contrato_id: contrato_id,
                                user_id : user_id,
                                estado : estado,
                                req_id : req_id,
                                _token : token,
                                firma : canvas,
                                creada : creada,
                                nuevo_cuerpo : nuevo_cuerpo
                            },
                            url: "{{ route('home.guardar-firma-adicional') }}",
                            beforeSend: function(){
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Firmando documento ...',
                                    showConfirmButton: false
                                });
                            },
                            success: function(response) {
                                if(response.success == true){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Documento firmado.',
                                        showConfirmButton: false
                                    });

                                    setTimeout(function() {
                                        localStorage.setItem('reloadTab', false)
                                        location.reload()
                                    }, 4000);
                                }
                            }
                        });
                    });
                });
            </script>
        
        @endif
    @endif
    
    {{-- Muestra cláusula médica --}}
    @if(isset($adicional_medico) && $adicional_medico == true && isset($especificaciones) && $mostrar_siguiente_clausula)
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12 mt-2">
                @if($requerimiento->logo != null)
                    <img src="{{ url('configuracion_sitio')}}/{!!$requerimiento->logo!!}" width="100">
                @else
                    @if(isset(FuncionesGlobales::sitio()->logo))
                        @if(FuncionesGlobales::sitio()->logo != "")
                            <img class="center fixedwidth"
                                align="center"
                                border="0"
                                src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}"
                                alt="Logo"
                                title="Logo"
                                style="clear: both; border: 0; height: auto; float: left;" width="150"
                            >
                        @else
                            <img class="center fixedwidth"
                                align="center"
                                border="0"
                                src="{{ url("img/logo.png")}}"
                                alt="Logo"
                                title="Logo"
                                style="clear: both; border: 0; height: auto; float: left;" width="150"
                            >
                        @endif
                    @else
                        <img src="{{ url("img/logo.png")}}" style="clear: both; border: 0; height: auto; float: left;" width="282" height="100">
                    @endif
                @endif
            </div>

            {{-- <div class="col-md-12">
                <h2 class="text-center">Firma de documentos adicionales</h2>
            </div> --}}

            {{-- <div class="col-md-12 mt-2 mb-2">
                <h3 style="font-weight: bold;">Documento:</h3>
            </div> --}}

            {{-- Muestra el cuerpo de la cláusula --}}
            <div class="col-md-12 mt-4">
                <div>
                    @include("home.include.adicionales.documento_medico_recomendaciones", ["recomendaciones" => $especificaciones])
                </div>
            </div>

            {{-- Tablero de firma --}}
            <div class="col-md-12 mt-3 mb-2">
                <div id="firmBoard" style="width: 400px; height: 160px; margin: auto;"></div>
            </div>

            <div class="col-md-12">
                <div class="text-center">
                    <button type="button" class="btn btn-warning guardarFirma">Guardar Firma</button>
                </div>

                {{-- <div class="text-center mb-2">
                    <button type="button" class="btn btn-danger" id="btnCancelarContrato">Cancelar contratación</button>
                </div> --}}
            </div>
        </div>

        <script>
            $(function (){
                var firmBoard = new DrawingBoard.Board('firmBoard', {
                    controls: [
                        { DrawingMode: { filler: false, eraser: false,  } },
                        { Navigation: { forward: false, back: false } }
                        //'Download'
                    ],
                    size: 2,
                    webStorage: 'session',
                    enlargeYourContainer: true
                });

                $(".guardarFirma").on("click", function() {
                    $('.drawing-board-canvas').attr('id', 'canvas');

                    var canvas1 = document.getElementById('canvas');
                    var canvas = canvas1.toDataURL();

                    //Flag para recomendaciones
                    var recomendaciones = `{!! $especificaciones !!}`;

                    user_id = '{{$user_id}}';
                    req_id = '{{$req_id}}';
                    estado = 1;
                    contrato_id= '{{$contratoId}}';

                    var token = ('_token', '{{ csrf_token() }}');

                    $.ajax({
                        type: 'POST',
                        data: {
                            contrato_id: contrato_id,
                            user_id : user_id,
                            estado : estado,
                            req_id : req_id,
                            _token : token,
                            firma : canvas,
                            recomendaciones : recomendaciones
                        },
                        url: "{{ route('home.guardar-firma-adicional') }}",
                        beforeSend: function(){
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Firmando documento ...',
                                    showConfirmButton: false
                                });
                            },
                        success: function(response) {
                            if(response.success == true){
                                takePicture(webcam)

                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Documento firmado.',
                                    showConfirmButton: false
                                });

                                setTimeout(function() {
                                    localStorage.setItem('reloadTab', false)
                                    location.reload();
                                }, 2000);
                            }
                        }
                    });
                });
            });
        </script>

    @endif

    @if($finAdicionales)
        @include('contratos.includes._section_fin_firmas')
    @endif

    <script>
        $(function () {
            //Cancelar contrato
            const $btnCancelarContrato = document.querySelector('#btnCancelarContrato');
            var tokenvalue = $('meta[name="token"]').attr('content');

            let dashboardRedir = '{{ route('dashboard') }}';
            let routeCancel = '{{ route('cancelar_contratacion_candidato') }}';
            let contratoId  = '{{ $contratoId }}';
            let userId  = '{{ $userId }}';
            let reqId  = '{{ $req_id }}';

            const ToastNoTime = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timerProgressBar: true
            });

            const cancelContract = () => {
                Swal.fire({
                    title: '¿Estas seguro/a?',
                    text: "Esta acción es irreversible.",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si, cancelar',
                    cancelButtonText: 'No, continuar'
                }).then((result) => {
                    if (result.value) {
                        //$('#observeModal').modal('show');
                        Swal.fire({
                            title: 'Cancelación de contrato',
                            input: 'textarea',
                            inputPlaceholder: 'Describe la razón por la que quieres cancelar el contrato',
                            inputAttributes: {
                                'aria-label': 'Describe la razón por la que quieres cancelar el contrato'
                            },
                            inputValidator: (field) => {
                                if (!field) {
                                    return 'Debes completar el campo'
                                }
                            },
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Enviar y cancelar',
                            cancelButtonText: 'Cancelar'
                        }).then((cancelation) => {
                            $.ajax({
                                type: 'POST',
                                data: {
                                    _token : tokenvalue,
                                    user_id : userId,
                                    req_id : reqId,
                                    contrato_id : contratoId,
                                    observacion : cancelation.value
                                },
                                url: routeCancel,
                                beforeSend: function() {
                                    ToastNoTime.fire({
                                        icon: 'info',
                                        title: 'Validando y guardando ...'
                                    });
                                },
                                success: function(response) {
                                    if(response.success == true){
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Contrato cancelado.',
                                            showConfirmButton: false
                                        });

                                        setTimeout(() => {
                                            localStorage.setItem('reloadTab', false)
                                            window.location.href = dashboardRedir
                                        }, 2000)
                                    }
                                }
                            });
                        })
                    }
                });
            }

            $btnCancelarContrato.addEventListener('click', () => {
                cancelContract()
            });
        })
    </script>

    {{-- Validar fin de las clausulas para guardar las fotos tomadas --}}
    @if($finAdicionales)
        @if($validate_pictures)
            <script>
                $(function () {
                    const guardarFotos = () => {
                        const ToastNoTime = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timerProgressBar: true
                        });

                        var tokenvalue = $('meta[name="token"]').attr('content');

                        let routeFotos = '{{ route("home.guardar_firma_fotos") }}';
                        let contratoId  = '{{ $contratoId }}';
                        let userId  = '{{ $userId }}';
                        let reqId  = '{{ $req_id }}';
                        const firmaImagenes = localStorage.getItem('procesoFirmaPictures');

                        $.ajax({
                            type: 'POST',
                            data: {
                                _token : tokenvalue,
                                userId : userId,
                                reqId : reqId,
                                contratoId : contratoId,
                                firmaImagenes: firmaImagenes
                            },
                            url: routeFotos,
                            beforeSend: function() {
                                ToastNoTime.fire({
                                    icon: 'info',
                                    title: 'Validando integridad de los datos ...'
                                });

                                document.querySelector('#siguientePasoAdicionales').setAttribute('disabled', 'disabled')
                            },
                            success: function(response) {
                                if(response.success == true){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Validación finalizada',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    //Limpiar el localstorage
                                    setTimeout(() => {
                                        localStorage.clear()
                                        localStorage.setItem('nextStep', true)

                                        location.reload()
                                    }, 1500)
                                }
                            }
                        });
                    }

                    // guardarFotos()

                    setTimeout(() => {
                        localStorage.clear()
                        localStorage.setItem('reloadTab', false)
                        localStorage.setItem('nextStep', true)

                        location.reload()
                    }, 2000)
                })
            </script>
        @else
            <script>
                localStorage.setItem('reloadTab', false)

                document.querySelector('#siguientePasoAdicionales').removeAttribute('disabled')
            </script>
        @endif
    @endif
</body>
</html>