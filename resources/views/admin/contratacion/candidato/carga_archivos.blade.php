@extends("cv.layouts.master")

@section("menu_candidato")
    @include("cv.includes.menu_candidato")
@endsection

@section('content')
    <style type="text/css">
        .mb-2 { margin-bottom: 2em; }
    </style>

    <div class="col-right-item-container">
        <div class="container-fluid">
           	@if($candidatos != null)
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="submit_listing_box">
                        <h3>
                            Documentos para contratación
                            <span class="pull-right">{{ $porcentaje }}%<sub>Completado</sub></span>
                            <p><strong>Cargo</strong>:{{ $candidatos->cargo }}</p>
                        </h3>

                        <div class="form-alt">
                            <div class="row">
                            	<div class="tabla table-responsive">
    					            <table class="table table-bordered table-hover" id="documentBox" tabindex="1">
    					                <thead>
    					                    <tr>
    					                        <th class="text-center">Documento</th>
                                                <th class="text-center">Status</th>
    					                    </tr>
    					                </thead>

    					                <tbody>
    					                	@foreach($tipo_documento as $tipo)
    					                		<tr>
                                                    <td>{{ $tipo->descripcion }}</td>
    						                		<td>
    						                			@if($tipo->nombre != "")
    						                			   <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>

    						                			   <a href='{{route("view_document_url",encrypt("recursos_documentos_verificados/"."|".$tipo->nombre."|"."$tipo->id"))}}'><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
    						                			@else
    						                			   <i class="fa fa-times" aria-hidden="true" style="color:red;">
    						                			@endif
    												</td>
    					                		</tr>
    					                	@endforeach
    					               </tbody>
                                    </table>
                                </div>

                                <p class="error text-danger direction-botones-center">
                                    {!! FuncionesGlobales::getErrorData("foto", $errors) !!}
                                </p>
                            </div>
                        </div>

                        <p class="direction-botones-center set-margin-top">
                   			<button class="btn-quote" id="cargarDocumento" type="button">
                                <i class="fa fa-cloud-upload"></i> Cargar documento
                            </button>
               			</p>
                    </div>
                </div>

                <br>

                <?php
                    $encuesta_obligatoria = 'no';
                    $titulo_encuesta = 'Encuesta del perfil sociodemográfico';
                ?>

                @if($sitioModulo->encuesta_sociodemografica == 'enabled')
                    <?php
                        $encuesta_obligatoria = $sociodemografica_config->encuesta_obligatoria;
                        $titulo_encuesta = $sociodemografica_config->titulo_encuesta;
                    ?>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="submit_listing_box">
                            <h3>
                                {{ $sociodemografica_config->titulo_encuesta }}
                            </h3>

                            {!! Form::model($datos_sociodemografico,["id" => "fr_datos_sociodemografico", "role" => "form", "method" => "POST", "files" => true]) !!}
                                @if($posee_datos_sociodemografico)
                                    <input type="hidden" name="id_datos_sociodemografico" value="{{ $datos_sociodemografico->id }}">
                                @endif

                                <input type="hidden" name="requerimiento_id" value="{{ $candidatos->req_id }}">
                                <input type="hidden" name="req_cand_id" value="{{ $requerimiento_candidato->id }}">

                                <?php
                                    $respuestas = array();
                                    if($posee_datos_sociodemografico || $posee_datos_sociodemografico_anterior) {
                                        $respuestas = json_decode($datos_sociodemografico->respuestas, true);
                                    }
                                ?>

                                <div class="form-alt">
                                    <div class="row">
                                        @foreach ($sociodemografico_questions as $question)
                                            <?php
                                                $opciones = $question->getOptionActive;
                                                $es_obligatoria = false;
                                                $id_pregunta = "preg_id_$question->id";
                                                if ($encuesta_obligatoria == 'si') {
                                                    if ($question->pregunta_obligatoria == 'si') {
                                                        $es_obligatoria = true;
                                                    }
                                                }
                                            ?>

                                            <div class="col-md-6 col-sm-12 col-xs-12 mb-2">
                                                <div class="form-group">
                                                    <label for="preg_id_{{ $question->id }}" class="control-label">
                                                        {!! $question->descripcion !!}
                                                        @if ($es_obligatoria)
                                                            <span>*</span>
                                                        @endif

                                                        @if($question->tipo == 'archivo')
                                                            @if ($respuestas["$id_pregunta"] != '' && $respuestas["$id_pregunta"] != null)
                                                                <?php
                                                                    $url = route('view_document_url', encrypt('recursos_encuesta_sociodemografica/'.'|'.$respuestas["$id_pregunta"]));
                                                                ?>

                                                                <a href="{{ $url }}" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                            @endif
                                                        @endif
                                                    </label>

                                                    @if($question->tipo == 'seleccion')
                                                        <select 
                                                            id="preg_id_{{ $question->id }}"
                                                            name="preg_id_{{ $question->id }}"
                                                            class="form-control"
                                                            @if ($es_obligatoria)
                                                                required="required"
                                                            @endif
                                                        >
                                                            <option value="">Seleccionar</option>
                                                            @foreach ($opciones as $opcion)
                                                                <option value="{{ $opcion->id }}" {{($opcion->id == $respuestas["$id_pregunta"] ? 'selected' : '')}}>
                                                                    {!! $opcion->descripcion !!}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @elseif($question->tipo == 'abierta')
                                                        <input
                                                            type="text"
                                                            id="preg_id_{{ $question->id }}"
                                                            name="preg_id_{{ $question->id }}"
                                                            class="form-control"
                                                            @if ($es_obligatoria)
                                                                required="required"
                                                            @endif
                                                            @if ($respuestas["$id_pregunta"] != '' && $respuestas["$id_pregunta"] != null)
                                                                value="{{$respuestas[$id_pregunta]}}"
                                                            @endif
                                                        >
                                                    @elseif($question->tipo == 'abierta_numerica')
                                                        @if($question->simbolo_numerico != null)
                                                            <div class="input-group">
                                                                <span class="input-group-addon">{{ $question->simbolo_numerico }}</span>
                                                                <input
                                                                    type="number"
                                                                    id="preg_id_{{ $question->id }}"
                                                                    name="preg_id_{{ $question->id }}"
                                                                    class="form-control"
                                                                    @if ($es_obligatoria)
                                                                        required="required"
                                                                    @endif
                                                                    @if ($respuestas["$id_pregunta"] != '' && $respuestas["$id_pregunta"] != null)
                                                                        value="{{$respuestas[$id_pregunta]}}"
                                                                    @endif
                                                                >
                                                            </div>
                                                        @else
                                                            <input
                                                                type="number"
                                                                id="preg_id_{{ $question->id }}"
                                                                name="preg_id_{{ $question->id }}"
                                                                class="form-control"
                                                                @if ($es_obligatoria)
                                                                    required="required"
                                                                @endif
                                                                @if ($respuestas["$id_pregunta"] != '' && $respuestas["$id_pregunta"] != null)
                                                                    value="{{$respuestas[$id_pregunta]}}"
                                                                @endif
                                                            >
                                                        @endif
                                                    @elseif($question->tipo == 'archivo')
                                                        <input
                                                            type="file"
                                                            id="preg_id_{{ $question->id }}"
                                                            name="preg_id_{{ $question->id }}"
                                                            class="form-control"
                                                            accept=".doc,.docx,.pdf,.png,.jpg,.jpeg"
                                                            @if ($es_obligatoria)
                                                                required="required"
                                                            @endif
                                                        >
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <p class="direction-botones-center set-margin-top">
                                    <button class="btn-quote" type="button" id="guardar_encuesta_sociodemografica">
                                        <i class="fa fa-floppy-o"></i>
                                        @if($posee_datos_sociodemografico)
                                            Actualizar
                                        @else
                                            Guardar
                                        @endif
                                    </button>
                                </p>
                            {!! Form::close() !!}

                            <br>

                            <div class="row">
                                <div id="mensaje-error" class="alert alert-danger danger" role="alert" style="display: none;">
                                    <strong id="error"></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                @endif
                
                {{-- Si no tiene datos sociodemografico --}}
                @if($encuesta_obligatoria == 'no' || $posee_datos_sociodemografico)
                    {{-- Si la instancia tiene activa la contratación virtual --}}
                    @if ($candidatos->firma_digital == 1)
                        {{-- Si existe registro de firma --}}
                        @if ($getFirma != null || $getFirma != '')
                            {{-- Si el contrato no esta anulado --}}
                            @if ($getFirma->estado == 1 || $getFirma->estado === 1)
                                {{-- Si la firma esta pausada --}}
                                @if($getFirma->stand_by == 1 || $getFirma->stand_by === 1)
                                    <div class="col-md-12 col-xs-12">
                                        <div class="alert alert-danger text-left" role="alert">
                                            La firma del contrato se encuentra detenida temporalmente.
                                        </div>
                                    </div>
                                @else
                                    {{-- Si el contrato esta sin terminar o sin videos --}}
                                    @if ($getFirma->terminado == null || $getFirma->terminado == 3)
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <p class="direction-botones-center set-margin-top">
                                                <button
                                                    class="btn btn-lg btn-warning"
                                                    id="firmar"
                                                    type="button"
                                                >
                                                    Firmar contrato
                                                </button>
                                            </p>

                                            @if(Session::has("mensaje_error"))
                                                <div>
                                                    <p style="color: red;">{{Session::get('mensaje_error')}}</p>
                                                </div>
                                            @endif

                                            <div class="alert alert-danger text-left" role="alert" id="stand_by" style="display: none;">
                                                La firma del contrato se encuentra detenida temporalmente.
                                            </div>
                                        </div>
                                    {{-- Si el contrato esta finalizado --}}
                                    @elseif($getFirma->terminado == 0)
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="alert alert-danger text-left" role="alert">
                                                El proceso de contratación ha sido cancelado, por favor comuníquese con el profesional que está llevando su proceso.
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        @else
                            {{--  --}}
                        @endif
                    @else
                        {{--  --}}
                    @endif
                @else
                    <div class="col-md-12 col-xs-12">
                        <div class="alert alert-info text-left" role="alert">
                            <i>Por favor completa la <b>{{ $titulo_encuesta }}</b> para que puedas continuar con tu firma de contrato</i>
                        </div>
                    </div>
                @endif

                <div>
                    <input type="hidden" value="{{ $candidatos->user_id }}" id="userId">
                    <input type="hidden" value="{{ $candidatos->req_id }}" id="reqId">
                </div>

                <div class="modal fade" id="modal_gr_local" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" id="mdialTamanio">
                        <div class="modal-content">
                            <div class="modal-header">                    
                                <h4 class="modal-title">Código de validación</h4>
                            </div>
                            
                            {!! Form::open(["id" => "fr_verificacion_codigo", "route" => "verificar_codigo_contrato", "name" => "verificacion"]) !!}
                                <div class="modal-body">
                                    <div class="alert alert-info text-left" role="alert">
                                        Se ha enviado a tu dirección de correo electrónico y a tu teléfono móvil como mensaje de texto el código de verificación para la firma de contrato. <b>Recuerda revisar la carpeta de spam en caso de que no se encuentre en recibidos.</b> Ingresa el código para continuar, por favor no cierres esta ventana.
                                    </div>
            
                                    <div class="alert alert-info text-left" role="alert">
                                        Acepto y autorizo que para perfeccionar la contratación  virtual con ({{ $sitio->nombre }}),  sea adoptada la firma que dibujé en el contrato de trabajo mediante la herramienta virtual y los videos que adjunté en la plataforma  configuran un soporte válido para el proceso de mi contratación.
                                    </div>

                                    <div class="alert alert-info text-left" role="alert">
                                        También declaro que es mi voluntad regirme por el modelo de firma electrónica pactada mediante acuerdo (el cual es el modelo legal que usa este sitio para el perfeccionamiento del proceso de la contratación laboral virtual) señalada en el numeral 1° del artículo 2.2.2.47.1.
                                    </div>

                                    <div class="alert alert-info text-left" role="alert">
                                        <b>
                                            Recuerda que desde este momento debes permitir el uso de la cámara de tu dispositivo, esto con el fin de asegurar que el proceso de la firma sea válido.
                                        </b>

                                        <br>

                                        Además recomendamos retirar tapabocas, sombreros, gorras, etc. En caso de estar usando algunos de estos elementos.
                                    </div>

                                    <div class="alert alert-danger text-left" role="alert" id="times" style="display: none;">
                                        Alcanzaste el número máximo de intentos, vuelve a dar clic en <b>Firmar contrato</b>.
                                        <br>
                                        Se creara un nuevo código.
                                    </div>
                                    
                                    <div class="form-group">
                                        {!! Form::hidden("proceso", $candidatos->proceso) !!}
                                        <input
                                            type="hidden"
                                            name="contrato"
                                            id="contrato"
                                            value=""
                                        >
                                    
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
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                {{-- Webcam --}}
                <div style="background-color: white;" id="webcamBox">
                    <div class="col-md-12 text-center" style="z-index: -1;">
                        <video id="webcam" autoplay playsinline width="640" height="420"></video>
                        <canvas id="canvas" class="d-none" hidden></canvas>
                    </div>
                </div>

                <script>
                    function soloNumeros(e){
                        var key = window.Event ? e.which : e.keyCode
                        return ((key >= 48 && key <= 57) || (key==8))
                    }
            
                    $(function() {
                        //Para toma de foto
                            const procesoFirmaPictures = []
                            const webcamElement = document.getElementById('webcam');
                            const canvasElement = document.getElementById('canvas');
                            const webcam = new Webcam(webcamElement, 'user', canvasElement);

                            const userId = document.querySelector('#userId')
                            const reqId = document.querySelector('#reqId')

                            let camaraStatus = true

                            const guardarFoto = (picture) => {
                                let tokenvalue = $('meta[name="token"]').attr('content');

                                $.ajax({
                                    url: "{{ route('contratacion.virtual.foto.store') }}",
                                    type: "POST",
                                    data:{
                                        _token : tokenvalue,
                                        foto: picture,
                                        user_id: userId.value,
                                        req_id: reqId.value,
                                        camara: camaraStatus
                                    },
                                    beforeSend: function() {
                                        // Swal.fire({
                                        //     icon: 'info',
                                        //     title: 'Validando información, espera un momento ...',
                                        //     toast: true,
                                        //     position: 'top-end',
                                        //     showConfirmButton: false,
                                        //     timerProgressBar: true,
                                        // })
                                    },
                                    success: function(response) {

                                    }
                                })
                            }

                            const takePicture = () => {
                                webcam.start()
                                .then(result =>{
                                    // console.log("webcam started")
                                })
                                .catch(err => {
                                    alert('Debes tener una cámara web disponible para continuar con el proceso de firma.')

                                    console.log(err)

                                    camaraStatus = false
                                })

                                //Toma la foto
                                setTimeout(() => {
                                    let picture = webcam.snap()

                                    guardarFoto(picture)
                                }, 4000)
                            }

                            const stopWebcam = () => {
                                webcam.stop();
                                console.log('stop')
                            }
                        //

                        document.getElementById('documentBox').focus();
            
                        $("#si").click(function() {
                            $.ajax({
                                url: "{{ route('confirmacion_asistencia_contratacion') }}",
                                type: "POST",
                                data:{
                                    'proceso':$(this).data("proceso"),
                                    'respuesta':'si'
                                },
                                beforeSend: function() {
                                },
                                success: function(response) {
                                    //console.log("success");
                                    mensaje_success("Asistencia confirmada");
                                }
                            });
                        });
            
                        $("#no").click(function(){
                           $.ajax({
                                url: "{{ route('confirmacion_asistencia_contratacion') }}",
                                type: "POST",
                                data:{
                                    'proceso':$(this).data("proceso"),
                                    'respuesta':'no'
                                },
                                beforeSend: function() {
                                },
                                success: function(response) {
                                    //console.log("success");
                                    mensaje_success("Asistencia confirmada");
                                }
                            });
                        });
            
                        $("#cargarDocumento").on("click", function() {
                            var req_id = {{ $candidatos->req_id }};
                            $.ajax({
                                url: "{{ route('admin.cargarDocumentoContratacion') }}",
            
                                type: "POST",
                                data:{
                                    req_id:req_id
                                },
                                beforeSend: function() {
                                },
                                success: function(response) {
                                    console.log("success");
                                    $("#modal_gr").find(".modal-content").html(response);
                                    $("#modal_gr").modal("show");
                                }
                            });
                        });
            
                        $("#guardar_nuevo").on("click", function() {
                            $.ajax({
                                url: "{{ route('admin.cargarDocumentoContratacion') }}",
                                type: "POST",
                                beforeSend: function() {
                                },
                                success: function(response) {
                                    console.log("success");
                                    $("#modal_gr").find(".modal-content").html(response);
                                    $("#modal_gr").modal("show");
                                },

                            });
                        });

                        const btnFirma = document.querySelector('#firmar');
                        const fieldCode = document.querySelector('#codigo');
                        const btnVerificar = document.querySelector('#verificar_codigo');
            
                        $("#firmar").on("click", function(e) {
                            e.preventDefault();

                            $.ajax({
                                url: "{{ route('codigo_firma_contrato_view') }}",
                                type: "POST",
                                data:{
                                    proceso: {{ $candidatos->proceso }}
                                },
                                beforeSend: function() {
                                    btnFirma.textContent = "Cargando ...";
                                    btnFirma.disabled = true;
                                },
                                success: function(response) {
                                    if (response.terminado == true) {
                                        window.location.href = '{{ route('dashboard') }}';
                                    }else if(response.stand_by == true){
                                        $('#stand_by').css('display', 'block');

                                        setTimeout(() => {
                                            $('#stand_by').css('display', 'none');
                                            window.location.reload(true);
                                        }, 6000)
                                    }else if(response.anulado == true) {
                                        $('#stand_by').css('display', 'block');
                                        $('#stand_by').html('El contrato se encuentra anulado.');

                                        setTimeout(() => {
                                            $('#stand_by').css('display', 'none');
                                            window.location.reload(true);
                                        }, 6000)
                                    }else {
                                        $("#modal_gr_local").modal("show");

                                        if(response.contrato){
                                            $('#contrato').val(response.contrato);
                                        }
                                    }
                                }
                            });
                        });

                        let times = 0;
                        
                        /* Validar si el código ingresado es correcto */
                        btnVerificar.addEventListener('click', () => {
                            //Validate empty field
                            if (fieldCode.value == "") {
                                document.querySelector('#errorTextInvalid').style.display = 'none';
                                document.querySelector('#errorTextLength').style.display = 'none';

                                fieldCode.style.borderColor = 'red';
                                document.querySelector('#errorText').style.display = 'initial';
            
                                setTimeout(() => {
                                    fieldCode.style.borderColor = '#ccc'; // Regresar al color por defecto
                                }, 2000)

                            }else if(fieldCode.value.toString().length < 4) {
                                document.querySelector('#errorTextInvalid').style.display = 'none';
                                document.querySelector('#errorText').style.display = 'none';

                                fieldCode.style.borderColor = 'red';
                                document.querySelector('#errorTextLength').style.display = 'initial';

                            }else{
                                $.ajax({
                                    url: "{{ route('verificar_codigo_contrato_async') }}",
                                    type: "POST",
                                    data:{
                                        proceso: {{ $candidatos->proceso }},
                                        code: fieldCode.value
                                    },
                                    beforeSend: function() {
                                        btnVerificar.textContent = "Cargando ...";
                                        btnVerificar.disabled = true;
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            document.querySelector('#errorText').style.display = 'none';
                                            document.querySelector('#errorTextInvalid').style.display = 'none';
                                            
                                            fieldCode.style.borderColor = 'green';
                                            document.querySelector('#successText').style.display = 'initial';
            
                                            //Toma foto
                                            takePicture(webcam)

                                            setTimeout(() => {
                                                const codeForm = document.querySelector('#fr_verificacion_codigo');
                                                codeForm.submit();
                                            }, 8000)
                                        }
            
                                        if (response.error) {
                                            document.querySelector('#errorText').style.display = 'none';
                                            document.querySelector('#errorTextLength').style.display = 'none';

                                            fieldCode.style.borderColor = 'red';
                                            fieldCode.value = '';

                                            document.querySelector('#errorTextInvalid').style.display = 'initial';
            
                                            btnVerificar.textContent = "Verificar";
                                            btnVerificar.disabled = false;
            
                                            setTimeout(() => {
                                                fieldCode.style.borderColor = '#ccc'; // Regresar al color por defecto
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
                        });

                        $("#guardar_encuesta_sociodemografica").on("click", function () {
                            if ($("#fr_datos_sociodemografico").smkValidate()) {
                                $("#mensaje-error").hide();

                                var formData = new FormData(document.getElementById("fr_datos_sociodemografico"));

                                $.ajax({
                                    dataType: "html",
                                    data: formData,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    type: "POST",
                                    url: "{{ route('cv.guardar_encuesta_sociodemografica') }}",
                                    success: function (response) {
                                        swal("Datos Guardados", "Los datos fueron guardados exitosamente", "info");

                                        setTimeout(function() {
                                            location.reload();
                                        }, 3000);
                                    },
                                    error:function(data) {
                                        $("#fr_datos_sociodemografico").smkValidate();

                                        $("#error").html("Debes llenar todos los campos obligatorios.");

                                        $("#mensaje-error").fadeIn();
                                    }
                                });
                            }
                        });
                    })
                </script>
            @else
                Actualmente no tiene ningún proceso de contratación activo.
            @endif
        </div>
    </div>
@stop