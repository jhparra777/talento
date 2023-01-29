@extends("cv.layouts.master")
<?php
    $sitio = FuncionesGlobales::sitio();
    $porcentaje=FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
?>
@section("menu_candidato")
    @include("cv.includes.menu_candidato")
@endsection

@section('content')
    <style type="text/css">
        .bs-callout-danger {
            border-left-color: #ce4844 !important;
        }
        .bs-callout-info {
            border-left-color: #2196F3 !important;
        }
        .bs-callout {
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #dadada;
            border-left-width: 5px;
            border-radius: 3px;
            background-color: #fff
        }

        .d-none { display: none !important; }

        .text-justify {
            text-align: justify;
        }

        label > span {
            color: red;
        }

        @media (max-width: 720px) {
            #webcam {
                width: 100%
            }
        }

        .link-whatsapp {
            font-weight: 600;
        }

        .link-whatsapp:hover {
            color: #4064a0 !important;
            font-weight: bold;
        }

        .link-whatsapp:focus {
            color: #4064a0 !important;
        }

        #submit_listing_box .form-group:last-child {
            margin-bottom: 15px !important;
        }

        .swal-text {
            text-align: justify !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('js/drawingboard/drawingboard.min.css') }}">

    {{-- drawingboard JS --}}
    <script src="{{ asset('js/drawingboard/drawingboard.min.js') }}" type="text/javascript"></script>
    <div class="col-right-item-container">
        <div class="container-fluid">
            @if($candidato != null)
                <?php $monto_limite_formateado = number_format($monto_maximo_a_solicitar, 0, ',', '.'); ?>
                <div class="row" id="informacion-inicial">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="text-justify bs-callout bs-callout-info">
                            Bienvenido. A continuación, encontrarás la interfaz de solicitud de anticipo de nómina. Aquí podrás realizar tu solicitud, la cual será atendida y gestionada por el equipo de <b>CARTAPP</b>.
                            <br><br>
                            Podrás solicitar hasta <b>${{$monto_limite_formateado}}</b> de adelanto. El costo administrativo de esta solicitud será de <b>$6.500</b>, los cuales se te descontarán en tu próximo pago.
                            <br><br>
                            Recuerda que esta funcionalidad es un beneficio exclusivo de <b>{{$sitio->nombre}}</b> que, en alianza con <b>CARTAPP</b>, ofrece a sus trabajadores, los cuales podrán acceder a él de manera voluntaria. Si tienes alguna pregunta o requieres de asistencia en el proceso de solicitud, por favor escríbenos al siguiente WhatsApp <a class="link-whatsapp" href="https://wa.me/573017336175" target="_blank">3017336175</a>.
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form id="datos-solicitud">
                            <input type="hidden" id="requerimiento_id" value="{{ $candidato->requerimiento_id }}">
                            <div id="submit_listing_box" class="text-left">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                ¿Cuenta propia o de tercero?
                                                <span>*</span>
                                            </label>

                                            <select name="cuenta" id="cuenta" class="form-control selectcuenta" required="required">
                                                <option value="" selected="">Seleccionar</option>
                                                <option value="propia">Propia</option>
                                                <option value="terceros">Tercero</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Banco
                                                <span>*</span>
                                            </label>

                                            <select name="banco_nomina_id" id="banco_nomina_id" class="form-control selectbanco" required="required">
                                                <option value="" data-tipo="">Seleccionar</option>
                                                @foreach($bancos_nomina as $banco)
                                                    <option value="{{ $banco->id }}" data-tipo="{{ $banco->tipo_manejo }}">{{ $banco->descripcion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="cuenta_tercero" hidden="">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Nombre y apellido <span>*</span> 
                                            </label>

                                            <input type="text" name="nombre_tercero" id="nombre_tercero" class="form-control" placeholder="Nombre y apellido" required="required">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Número documento identidad <span>*</span> 
                                            </label>

                                            <input type="text" name="nro_documento_tercero" id="nro_documento_tercero" class="form-control" placeholder="Número de documento de identidad" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="datos-cuenta" hidden="">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Tipo de cuenta
                                                <span>*</span>
                                            </label>

                                            <select name="tipo_cuenta" id="tipo_cuenta" class="form-control" required="required">
                                                <option value="">Seleccionar</option>
                                                @foreach($tipos_cuentas as $tipo_cuenta)
                                                    <option value="{{ $tipo_cuenta->id }}">{{ $tipo_cuenta->descripcion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Número de cuenta <span>*</span> 
                                            </label>

                                            <input type="text" name="numero_cuenta" id="numero_cuenta" class="form-control no-copy no-paste" maxlength="11" required="required">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Confirmar número de cuenta <span>*</span> 
                                            </label>

                                            <input type="text" name="confirmar_numero_cuenta" id="confirmar_numero_cuenta" maxlength="11" class="form-control no-copy no-paste" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="telefono-cuenta" hidden="">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Número de teléfono en donde será transferido el adelanto<span>*</span> 
                                            </label>

                                            <input type="number" name="telefono" maxlength="10" id="telefono" class="form-control no-copy no-paste" required="required" onkeypress="return soloNumeros(event)">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Confirmar número de teléfono <span>*</span> 
                                            </label>

                                            <input type="number" name="confirmar_telefono" maxlength="10" id="confirmar_telefono" class="form-control no-copy no-paste" required="required" onkeypress="return soloNumeros(event)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Valor <span>*</span>
                                            </label>
                                            <span class="small">Máximo ${{$monto_limite_formateado}}</span>

                                            <select name="valor" id="valor" class="form-control" required="required">
                                                <option value="">Seleccionar</option>
                                                @foreach($valores as $val)
                                                    <option value="{{ $val->valor }}">{{ $val->descripcion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row text-center">
                                    <button class="btn-quote" type="button" id="realizar_solicitud">
                                        Realizar solicitud
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row" hidden="" id="documento-firmar">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="submit_listing_box" class="text-left">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div id="text-doc"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal_gr_local" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" id="mdialTamanio">
                        <div class="modal-content">
                            <div class="modal-header">                    
                                <h4 class="modal-title">Código de validación</h4>
                            </div>

                            <div class="modal-body">
                                <div class="alert alert-info text-left" role="alert">
                                    Se ha enviado a tu dirección de correo electrónico y a tu teléfono móvil como mensaje de texto el código de verificación para la solicitud de adelanto de nómina. **Recuerda revisar la carpeta de spam en caso de que no se encuentre en recibidos.** Ingresa el código para continuar, por favor no cierres esta ventana.
                                </div>

                                <div class="alert alert-info text-left" role="alert">
                                    <b>
                                        Recuerda que desde este momento debes permitir el uso de la cámara de tu dispositivo, esto con el fin de asegurar que el proceso de la solicitud sea válido.
                                    </b>
                                </div>

                                <div class="alert alert-danger text-left" role="alert" id="times" style="display: none;">
                                    Alcanzaste el número máximo de intentos, vuelve a dar clic en <b>Realizar solicitud</b>.
                                    <br>
                                    Se creara un nuevo código.
                                </div>

                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="codigo" class="control-label">Código</label>
                                    </div>

                                    <div class="col-md-8">
                                        <input
                                            type="number"
                                            name="codigo"
                                            id="codigo"
                                            class="form-control"
                                            placeholder="Código de validación"
                                            maxlength="5"
                                            minlength="4"
                                            onkeypress="return soloNumeros(event)"
                                            autofocus
                                        >

                                        <small id="errorTextLength" class="form-text text-muted pull-left text-danger" style="display: none;">
                                            No debe ser menor a 4 caracteres
                                        </small>

                                        <small id="errorText" class="form-text text-muted pull-left text-danger" style="display: none;">
                                            Debes ingresar el código de validación.
                                        </small>

                                        <small id="errorTextInvalid" class="form-text text-muted pull-left text-danger" style="display: none;">
                                            Código inválido, asegurate de ingresar el número correcto.
                                        </small>

                                        <small id="successText" class="form-text text-muted pull-left text-success" style="display: none;">
                                            Código válido.
                                        </small>
                                    </div>
                                </div>
        
                                <div class="clearfix"></div>
                            </div>
        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="verificar_codigo">Aceptar y verificar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-firma" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Firma</h3>
                            </div>

                            <div class="modal-body" style="overflow:auto;">
                                <div id="texto">
                                    <p>Por favor dibuja tu firma en el panel blanco usando tu mouse o usa tu dedo si estás desde un dispositivo móvil</p>

                                    <table class="col-md-12 col-xs-12 col-sm-12 center table" bgcolor="#f1f1f1">
                                        <tr>
                                            <td width="10%"></td>
                                            <td>
                                                <div>
                                                    <div>
                                                        <div id="firmBoard" style="width: 400px; height: 160px; margin: 1rem;"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="text-center">
                                    <button type="button" class="btn btn-success guardarFirma" disabled>Firmar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row white_bg_block" id="rowCam">
                    <div class="col-md-12">
                        <div class="text-center" style="z-index: -1;">
                            <video id="webcam" autoplay playsinline width="640" height="420"></video>
                            <canvas id="canvas-foto" class="d-none" hidden></canvas>
                        </div>
                    </div>
                </div>

                <script>
                    const webcamElement = document.getElementById('webcam');
                    const canvasElement = document.getElementById('canvas-foto');
                    const webcam = new Webcam(webcamElement, 'user', canvasElement);
                    const fotos = [];
                    let pictureCount = 1;
                    let nro_documento_identidad = '{{$candidato->numero_id}}';
                    let monto_maximo_quincena = '{{$monto_limite}}';

                    function soloNumeros(e){
                        var key = window.Event ? e.which : e.keyCode
                        return ((key >= 48 && key <= 57) || (key==8))
                    }

                    function validarCuenta() {
                        let confirmar = true;
                        let tipo = '';
                        tipo = $('#banco_nomina_id option:selected').data('tipo');

                        if (tipo == 'telefono') {
                            if ($('#telefono').val() != $('#confirmar_telefono').val()) {
                                $.smkAlert({text: 'No coincide la confirmación del teléfono', type:'warning'});
                                confirmar = false;
                            } else if($('#telefono').val() == nro_documento_identidad) {
                                $.smkAlert({text: 'Coloco su documento de identidad en el campo teléfono', type:'warning'});
                                $('#telefono').focus();
                                confirmar = false;
                            }
                        } else if(tipo == 'cuenta') {
                            if ($('#numero_cuenta').val() != $('#confirmar_numero_cuenta').val()) {
                                $.smkAlert({text: 'No coincide la confirmación del número de cuenta', type:'warning'});
                                confirmar = false;
                            } else if($('#numero_cuenta').val() == nro_documento_identidad) {
                                $.smkAlert({text: 'Coloco su documento de identidad en el campo número de cuenta', type:'warning'});
                                $('#numero_cuenta').focus();
                                confirmar = false;
                            }
                        } else {
                            confirmar = false;
                        }

                        return confirmar;
                    }

                    function tomarFoto() {
                        let foto = null;
                        webcam.start()
                           .then(result =>{
                                //console.log("webcam iniciada tomarFoto");
                            })
                            .catch(err => {
                                //console.log(err);
                            });
                        setTimeout(() => {
                            $('#rowCam').removeClass('d-none');
                            foto = webcam.snap();
                            webcam.stop();
                            $('#rowCam').addClass('d-none');

                            fotos.push({
                                'name': `nomina-foto-${pictureCount}`,
                                'picture': foto
                            })

                            pictureCount++
                        }, 3500)
                    }

                    function formatNumber (n) {
                        n = String(n).replace(/\D/g, "");
                        return n === '' ? n : Number(n).toLocaleString();
                    }

                    $(function(){
                        let firmBoard = new DrawingBoard.Board('firmBoard', {
                            controls: [
                                { DrawingMode: { filler: false, eraser: false,  } },
                                { Navigation: { forward: false, back: false } }
                                //'Download'
                            ],
                            size: 2,
                            webStorage: 'session',
                            enlargeYourContainer: true
                        });

                        //listen draw event
                        firmBoard.ev.bind('board:stopDrawing', getStopDraw);
                        firmBoard.ev.bind('board:reset', getResetDraw);

                        function getStopDraw() {
                            $(".guardarFirma").attr("disabled", false);
                        }

                        function getResetDraw() {
                            $(".guardarFirma").attr("disabled", true);
                        }

                        $(".no-paste").on('paste', function(e){
                            e.preventDefault();
                            $.smkAlert({text: 'Acción no permitida', type:'info'});
                        });

                        $(".no-copy").on('copy', function(e){
                            e.preventDefault();
                            $.smkAlert({text: 'Acción no permitida', type:'info'});
                        });

                        $('.container-fluid').delegate( '.monto', 'keyup', function(){
                            //const value = $(this).val();
                            //$(this).val(formatNumber(value));
                        });

                        $('#cuenta').change(function() {
                            if ($(this).val() == 'terceros') {
                                $('#cuenta_tercero input').prop('disabled', false);
                                $('#cuenta_tercero').show();
                            } else {
                                $('#cuenta_tercero input').prop('disabled', true);
                                $('#cuenta_tercero input').val('');
                                $('#cuenta_tercero').hide();
                            }
                        });

                        $('#banco_nomina_id').change(function() {
                            let tipo = '';
                            tipo = $('#banco_nomina_id option:selected').data('tipo');

                            if (tipo == 'telefono') {
                                $('#telefono-cuenta input').prop('disabled', false);
                                $('#telefono-cuenta').show();
                                $('#datos-cuenta input').val('');
                                $('#datos-cuenta input').prop('disabled', true);
                                $('#datos-cuenta select').val('');
                                $('#datos-cuenta select').prop('disabled', true);
                                $('#datos-cuenta').hide();
                            } else if(tipo == 'cuenta') {
                                $('#datos-cuenta input').prop('disabled', false);
                                $('#datos-cuenta select').prop('disabled', false);
                                $('#datos-cuenta').show();
                                $('#telefono-cuenta input').val('');
                                $('#telefono-cuenta input').prop('disabled', true);
                                $('#telefono-cuenta').hide();
                            } else {
                                $('#telefono-cuenta input').val('');
                                $('#datos-cuenta input').val('');
                                $('#datos-cuenta select').val('');
                                $('#telefono-cuenta input').prop('disabled', true);
                                $('#datos-cuenta input').prop('disabled', true);
                                $('#datos-cuenta select').prop('disabled', true);
                                $('#telefono-cuenta').hide();
                                $('#datos-cuenta').hide();
                            }
                        });

                        $(document).on("click", "#firmar-doc", function () {
                            $('#modal-firma').modal({backdrop: 'static', keyboard: false });
                        });

                        $(document).on("click", ".guardarFirma", function() {
                            $('.drawing-board-canvas').attr('id', 'canvas-firma');
                            tomarFoto();

                            var canvas1 = document.getElementById('canvas-firma');
                            var canvas = canvas1.toDataURL();
                            var telefono = null;
                            var numero_cuenta = null;
                            var tipo_cuenta = '';
                            var nombre_tercero = '';
                            var nro_documento_tercero = '';

                            var valor = $('#valor').val();
                            var banco_nomina_id = $('#banco_nomina_id').val();
                            var requerimiento_id = $('#requerimiento_id').val();
                            var cuenta = $('#cuenta').val();

                            var valor_formateado = new Intl.NumberFormat('es-ES').format(valor);

                            if (cuenta == 'terceros') {
                                nombre_tercero = $('#nombre_tercero').val();
                                nro_documento_tercero = $('#nro_documento_tercero').val();
                            }

                            let tipo = '';
                            tipo = $('#banco_nomina_id option:selected').data('tipo');
                            if (tipo == 'telefono') {
                                telefono = $('#telefono').val();
                            } else if(tipo == 'cuenta') {
                                numero_cuenta = $('#numero_cuenta').val();
                                tipo_cuenta = $('#tipo_cuenta').val();
                            }
                            var token = ('_token', '{{ csrf_token() }}');

                            $.ajax({
                                type: 'POST',
                                data: {
                                    requerimiento_id : requerimiento_id,
                                    banco_nomina_id : banco_nomina_id,
                                    cuenta : cuenta,
                                    numero_cuenta : numero_cuenta,
                                    telefono : telefono,
                                    tipo_cuenta : tipo_cuenta,
                                    nombre_tercero : nombre_tercero,
                                    nro_documento_tercero : nro_documento_tercero,
                                    valor : valor,
                                    _token : token,
                                    firma : canvas
                                },
                                url: "{{ route('save_solicitud_adelanto_nomina') }}",
                                beforeSend: function(response) {
                                    document.querySelector(".guardarFirma").setAttribute('disabled', 'disabled')
                                    $.smkAlert({
                                        text: 'Guardando la solicitud de adelanto de nómina, por favor espere',
                                        type: 'info'
                                    });
                                },
                                success: function(response) {
                                    if (response.success) {
                                        //clearInterval(tiempo_foto)
                                        //stopWebcam()

                                        //document.querySelector(".guardarFirma").removeAttribute('disabled')

                                        let rutaDashboard = "{{ route('dashboard') }}";

                                        //Guardar fotos
                                        let nominaImagenes = JSON.stringify(fotos);

                                        $.ajax({
                                            type: 'POST',
                                            data: {
                                                _token : token,
                                                nominaImagenes: nominaImagenes,
                                                solicitud_id: response.solicitud_id,
                                                monto_maximo_quincena : monto_maximo_quincena
                                            },
                                            url: "{{ route('completar_solicitud_adelanto_nomina') }}",
                                            beforeSend: function(response) {
                                                document.querySelector(".guardarFirma").setAttribute('disabled', 'disabled')
                                            },
                                            success: function(response) {
                                                swal("Completado", "Se ha creado la solicitud de adelanto de nómina exitosamente por el valor de $"+valor_formateado+"; antes de 4 horas hábiles le informaremos el estado de aprobación o de negación de su solicitud. En caso de ser aprobada, procederemos a realizar la transferencia de su adelanto. Gracias por su atención.", "success", {
                                                    buttons: {
                                                        finalizar: {text: "Continuar", className:'btn btn-success'}
                                                    },
                                                    closeOnClickOutside: false,
                                                    closeOnEsc: false,
                                                    allowOutsideClick: false,
                                                }).then((value) => {
                                                    switch (value) {
                                                        case "finalizar":
                                                            window.location.href = rutaDashboard;
                                                        break;
                                                    }
                                                });
                                            }
                                        });
                                    }else{
                                        document.querySelector(".guardarFirma").removeAttribute('disabled')
                                    }
                                }
                            });
                        });

                        $('#realizar_solicitud').click(function () {
                            if ($('#datos-solicitud').smkValidate() && $('#valor').val() <= 200000 && validarCuenta()){
                                $(this).hide();
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('codigo_adelanto_nomina') }}",
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function () {
                                        $.smkAlert({text: 'Enviando código ', type:'info'})
                                    },
                                    success: function (data) {
                                        if (data.success) {
                                            $('#modal_gr_local').modal('show');
                                            //$.smkAlert({text: 'Código enviado', type:'success'})
                                            $.smkProgressBar({
                                                element:'body',
                                                status:'start',
                                                bgColor: '#000',
                                                barColor: '#fff',
                                                content: `
                                                        <div class="row">
                                                            <div class="col-md-10 col-md-offset-1">
                                                                <h3><b>Se solicitarán los permisos para acceder a su cámara y micrófono. <br> Por favor presione "Permitir".</b></h3>
                                                            </div>
                                                        </div>
                                                    `
                                            });
                                            webcam.start()
                                               .then(result =>{
                                                    //console.log("webcam started");

                                                    setTimeout(() => {
                                                        let foto = webcam.snap();
                                                        webcam.stop();
                                                        $('#rowCam').addClass('d-none');

                                                        fotos.push({
                                                            'name': `nomina-foto-${pictureCount}`,
                                                            'picture': foto
                                                        })

                                                        pictureCount++;
                                                    }, 2500)

                                                    $.smkProgressBar({
                                                        status:'end'
                                                    });
                                                })
                                                .catch(err => {
                                                    console.log(err);
                                                    swal("Error al iniciar la cámara", "Se ha producido un error al iniciar la cámara, porque no lo admite su navegador o porque no ha permitido el uso de la cámara.", "warning", {
                                                        buttons: {
                                                            si: { text: "Ok",className:'btn btn-warning' },
                                                        },
                                                    }).then((value) => {
                                                        if (value == "si") {
                                                            window.location.reload();
                                                        } else {
                                                            window.location.reload();
                                                        }
                                                    });
                                                });
                                        } else {
                                            swal("Ocurrio un error", "Vuelve a intentarlo de nuevo.", "warning");
                                            window.location.reload();
                                        }
                                    },
                                    error:function(data){
                                        $(this).show();
                                        swal("Ocurrio un error", "Vuelve a intentarlo de nuevo.", "warning");
                                    }
                                });
                            } else {
                                if ($('#valor').val() > 200000) {
                                    $.smkAlert({text: 'Debe ingresar un valor menor o igual a $200.000', type:'warning'})
                                }
                            }
                        });

                        let times = 0;
                        const $btnFirma = document.querySelector('#firmar');
                        const $fieldCode = document.querySelector('#codigo');
                        const $btnVerificar = document.querySelector('#verificar_codigo');

                        $btnVerificar.addEventListener('click', () => {
                            if ($fieldCode.value == "") {
                                document.querySelector('#errorTextInvalid').style.display = 'none';
                                document.querySelector('#errorTextLength').style.display = 'none';
                                $fieldCode.style.borderColor = 'red';
                                document.querySelector('#errorText').style.display = 'initial';
            
                                setTimeout(() => {
                                    $fieldCode.style.borderColor = '#ccc';
                                }, 2000)
                            }else if($fieldCode.value.toString().length < 4){
                                document.querySelector('#errorTextInvalid').style.display = 'none';
                                document.querySelector('#errorText').style.display = 'none';
                                $fieldCode.style.borderColor = 'red';
                                document.querySelector('#errorTextLength').style.display = 'initial';
                            }else{
                                var telefono = null;
                                var numero_cuenta = null;
                                var tipo_cuenta = '';
                                var nombre_tercero = '';
                                var nro_documento_tercero = '';

                                var valor = $('#valor').val();
                                var banco_nomina_id = $('#banco_nomina_id').val();
                                var requerimiento_id = $('#requerimiento_id').val();
                                var cuenta = $('#cuenta').val();

                                if (cuenta == 'terceros') {
                                    nombre_tercero = $('#nombre_tercero').val();
                                    nro_documento_tercero = $('#nro_documento_tercero').val();
                                }

                                let tipo = '';
                                tipo = $('#banco_nomina_id option:selected').data('tipo');
                                if (tipo == 'telefono') {
                                    telefono = $('#telefono').val();
                                } else if(tipo == 'cuenta') {
                                    numero_cuenta = $('#numero_cuenta').val();
                                    tipo_cuenta = $('#tipo_cuenta').val();
                                }

                                $.ajax({
                                    url: "{{ route('verificar_codigo_adelanto_nomina_async') }}",
                                    type: "POST",
                                    data:{
                                        requerimiento_id : requerimiento_id,
                                        banco_nomina_id : banco_nomina_id,
                                        cuenta : cuenta,
                                        numero_cuenta : numero_cuenta,
                                        telefono : telefono,
                                        tipo_cuenta : tipo_cuenta,
                                        nombre_tercero : nombre_tercero,
                                        nro_documento_tercero : nro_documento_tercero,
                                        monto_maximo_quincena : monto_maximo_quincena,
                                        valor : valor,
                                        code: $fieldCode.value
                                    },
                                    beforeSend: function(){
                                        $btnVerificar.textContent = "Cargando ...";
                                        $btnVerificar.disabled = true;
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            $('#modal_gr_local').modal('hide');
                                            document.querySelector('#errorText').style.display = 'none';
                                            document.querySelector('#errorTextInvalid').style.display = 'none';
                                            
                                            $fieldCode.style.borderColor = 'green';
                                            document.querySelector('#successText').style.display = 'initial';
            
                                            //Toma foto
                                            tomarFoto();

                                            $('#informacion-inicial').hide();
                                            $('#documento-firmar').show();
                                            $('#text-doc').html(response.view);
                                            $("html, body").animate({ scrollTop: 0 }, 200);
                                        }
            
                                        if (response.error) {
                                            document.querySelector('#errorText').style.display = 'none';
                                            document.querySelector('#errorTextLength').style.display = 'none';
                                            $fieldCode.style.borderColor = 'red';
                                            $fieldCode.value = '';
                                            document.querySelector('#errorTextInvalid').style.display = 'initial';
            
                                            $btnVerificar.textContent = "Verificar";
                                            $btnVerificar.disabled = false;
            
                                            setTimeout(() => {
                                                $fieldCode.style.borderColor = '#ccc';
                                            }, 2000)
            
                                            times = times + 1;
            
                                            if (times >= 3) {
                                                document.querySelector('#times').style.display = 'block';
            
                                                setTimeout(() => {
                                                    window.location.reload(true)
                                                }, 4000)
                                            }
                                        }
                                    }
                                });
                            }
                        })
                    });
                </script>
            @else
                <div class="col-md-offset-2 col-md-8">
                    <div class="text-center bs-callout bs-callout-danger">
                        {!! $mensaje !!}
                        <br>
                        <img style="margin-top: 20px;" alt="Logo CARTAPP" height="auto" src="{{ asset('img/logo_cartapp.png')}}" width="200">
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop