@extends("admin.layout.master")
@section('contenedor')
    {{-- Custom styles --}}
    <link rel="stylesheet" href="{{ asset('src/css/bootstrap-datetimepicker-styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Asistente Virtual"])

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="{{ route('post_llamada_virtual') }}" method="POST" id="fr_llamada_virtual" accept-charset="UTF-8">
                        @csrf
                        <input type="hidden" name="modulo" value="{{ $modulo }}">
                        <input type="hidden" name="req_id" value="{{ $req_id }}">
                        <input type="hidden" name="req_ids" value="{{ $req_ids }}">
                        <input type="hidden" name="numeros" value="{{ $numeros }}">
                        <input type="hidden" name="tipo_cita" id="tipo_cita">
                        <input type="hidden" name="mensaje_enviar" id="mensaje_enviar" value="1">

                        <div id="agendamiento" hidden>
                            <div class="col-md-12 mb-1">
                                <h4 class="mb-2">Definir parámetros para la cita</h4>

                                <div class="alert alert-success alert-dismissible | tri-br-1 tri-green tri-border--none" role="alert">
                                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                        <span aria-hidden="true">×</span>
                                    </button>

                                    <b>
                                        El agendamiento del asistente virtual permite definir una fecha, horario y duración de la cita o entrevista para los candidatos seleccionados.
                                    </b>

                                    <br><br>

                                    <b>
                                        Al crear una cita con agendamiento, el sistema automáticamente creara un proceso de entrevista para los candidatos seleccionados.
                                    </b>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="asunto_cita">Asunto de la cita *: <span></span></label>

                                    {!! Form::text('asunto_cita', null, [
                                        'class' => 'form-control | tri-br-1 tri-fs-14 tri-input--focus tri-transition-300',
                                        'id' => 'asunto_cita',
                                        'placeholder' => 'Ingrese el asunto de la cita'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_cita">Día de la cita *: <span></span></label>

                                    {!! Form::date('fecha_cita', null, [
                                        'class' => 'form-control | tri-br-1 tri-fs-14 tri-input--focus tri-transition-300',
                                        'id' => 'fecha_cita'
                                    ]) !!}
                                </div>
                            </div>

                            {{-- Hora inicio --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora_inicio">Horario de atención (Hora inicio) *: </label>

                                    <div class="input-group time" id="timepicker_hora_inicio">
                                        <input type="text" class="form-control | tri-br-1 tri-fs-14 tri-input--focus tri-transition-300" name="hora_inicio" placeholder="HH:MM AM/PM" autocomplete="off" onkeypress="return soloLetras(event)">

                                        <span class="input-group-append input-group-addon" style="cursor: pointer;">
                                            <span class="input-group-text">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora_fin">Horario de atención (Hora fin) *: <span></span></label>

                                    <div class="input-group time" id="timepicker_hora_fin">
                                        <input type="text" class="form-control | tri-br-1 tri-fs-14 tri-input--focus tri-transition-300" name="hora_fin" placeholder="HH:MM AM/PM" autocomplete="off" onkeypress="return soloLetras(event)">

                                        <span class="input-group-append input-group-addon" style="cursor: pointer;">
                                            <span class="input-group-text">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="duracion_cita">Duración de cada cita *: <span></span></label>

                                    {!! Form::select('duracion_cita', [
                                            '' => 'Seleccionar',
                                            15 => '15 mins.',
                                            30 => '30 mins.',
                                            45 => '45 mins.',
                                            60 => '60 mins.'
                                        ], null, [
                                            'class' => 'form-control | tri-br-1 tri-fs-14 tri-input--focus tri-transition-300',
                                            'id' => 'duracion_cita'
                                        ])
                                    !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="asunto_cita">Asunto*: <span></span></label>

                                {!! Form::text('asunto', null, [
                                    'class' => 'form-control | tri-br-1 tri-fs-14 tri-input--focus tri-transition-300',
                                    'id' => 'asunto',
                                    'placeholder' => 'Ingrese el asunto'
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="message">Mensaje: <span></span></label>

                                <textarea name="mensaje" id="message" maxlength="300" rows="5" class="form-control | tri-br-1 tri-fs-14 tri-input--focus tri-transition-300" placeholder="Escriba las indicaciones de la entrevista para el candidato. Ejemplo : lugar, hora, dirección y empresa de donde será la entrevista"></textarea>
                                <small class="help-block" id="caracteresUsados">Caracteres usados: <span class="tri-fw-600"></span></small>
                            </div>
                        </div>

                        <div class="col-md-6 col-md-offset-3">
                            <button class="btn btn-default btn-block | tri-br-2 tri-fs-14 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" id="submitBtn" type="submit">Enviar llamada, mensaje de texto, correo electrónico y mensaje por WhatsApp</button>
                            <button type="submit" class="btn btn-default btn-block | tri-br-2 tri-fs-14 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" name="solo_correo" id="EnviarSoloCorreo">Enviar correo electrónico</button>
                            <a class="btn btn-default btn-block | tri-px-2 tri-br-2 tri-border--none tri-transition-200" href="#" onclick="window.history.back()">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible | tri-br-1 tri-green tri-border--none" role="alert">
                    <button aria-hidden="true" class="close" data-dismiss="alert" type="button">x</button>

                    {{ Session::get("mensaje_success") }}
                </div>
            </div>
        @endif

        @if(session()->has('message'))
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible | tri-br-1 tri-green tri-border--none" role="alert">
                    <button aria-hidden="true" class="close" data-dismiss="alert" type="button">x</button>

                    {{ session()->get('message') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible | tri-br-1 tri-red tri-border--none">
                    <button aria-hidden="true" class="close" data-dismiss="alert" type="button">x</button>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Mostrar mensaje cuando llegue al limite de la función --}}
        @if (Session::has('mensaje_limite'))
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible | tri-br-1 tri-red tri-border--none" role="alert">
                    <button aria-hidden="true" class="close" data-dismiss="alert" type="button">x</button>

                    <ul>
                        <li>{!! Session::get('mensaje_limite') !!}</li>
                    </ul>
                </div>
            </div>
        @endif
    </div>

    {{-- Modal selección tipo cita --}}
    @include('admin.reclutamiento.asistente_virtual.includes._modal_asistente_tipo_cita')

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        let horariosOcupados = @json($horario_ocupado)
    </script>

    <script>
        $(function (){
            $("#modal_tipo_cita").modal("show");

            //Timepicker plugin
            $("#timepicker_hora_inicio, #timepicker_hora_fin").datetimepicker({
                format: "HH:mm",
                useCurrent: false,
                icons: {
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down"
                },
                disabledHours: horariosOcupados
            })
        })

        //Definir tipo de cita
        const agendamiento = (obj) => {
            const tipo = obj.dataset.tipo

            switch (tipo) {
                case 'with':
                    document.querySelector('#agendamiento').removeAttribute('hidden')
                    document.querySelector('#tipo_cita').value = 'with'

                    $.smkAlert({
                        text: 'Cita con agendamiento',
                        type: 'info'
                    })
                    $('#modal_tipo_cita').modal('hide')
                    break;
                case 'without':
                    document.querySelector('#agendamiento').setAttribute('hidden', true)
                    document.querySelector('#tipo_cita').value = 'without'

                    $.smkAlert({
                        text: 'Cita sin agendamiento (normal)',
                        type: 'info'
                    })
                    $('#modal_tipo_cita').modal('hide')
                    break;
                default:
                    document.querySelector('#agendamiento').setAttribute('hidden', true)
                    break;
            }
        }

        //Validar caracteres en campo textarea
        $(document).on('keyup', "#message", function (e) {
            let textareaEl = $(this)
            let maxlength = 100
            let maxlengthint = parseInt(maxlength)
            let textoActual = textareaEl.val()
            let currentCharacters = textareaEl.val().length
            let remainingCharacters = maxlengthint - currentCharacters
            let caracteresEl = $('#caracteresUsados').find('span')

            if (document.addEventListener && !window.requestAnimationFrame) {
                if (remainingCharacters <= -1) {
                    remainingCharacters = 0;
                }
            }
      
            caracteresEl.html(currentCharacters);
      
            let valorAct = $(this).val();
            let msgSend = 0;

            if(valorAct.length >= 1 && valorAct.length <= 130) {
                msgSend = 1;
            }else {
                if(valorAct.length >= 131 && valorAct.length <= 230) {
                    msgSend = 2;
                }else {
                    if(valorAct.length >= 231 && valorAct.length <= 330) {
                        msgSend = 3;
                    }else {
                        if(valorAct.length >= 331 && valorAct.length <= 430) {
                            msgSend = 4;
                        }else {
                            if(valorAct.length = '') {
                                msgSend = 0;
                            }
                        }
                    }
                }
            }
        })

        $(document).on('click', "#EnviarSoloCorreo", function (e) {
            e.preventDefault()
            
            $("#fr_llamada_virtual").append(`<input type="hidden" name="solo_correo" value="si"/>`)
            
            $("#fr_llamada_virtual").submit()
        })

        function soloLetras(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toLowerCase();
            letras = "";
            especiales = "8-37-39-46";

            tecla_especial = false
            for(var i in especiales){
                if(key == especiales[i]){
                    tecla_especial = true;
                    break;
                }
            }

            if(letras.indexOf(tecla)==-1 && !tecla_especial) {
                return false;
            }
        }

        //Configurar campo Date, mostrar solo fechas a partir del presente día.
        const dateToday = new Date()
        let month = dateToday.getMonth() + 1
        let day = dateToday.getDate()
        let year = dateToday.getFullYear()

        if(month < 10)
            month = '0' + month.toString()

        if(day < 10)
            day = '0' + day.toString()

        const maxDate = year + '-' + month + '-' + day

        document.querySelector('#fecha_cita').setAttribute('min', maxDate)
    </script>
@stop