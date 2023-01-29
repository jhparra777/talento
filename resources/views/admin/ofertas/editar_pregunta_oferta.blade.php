<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>

    <h4 class="modal-title">Editar Pregunta</h4>
</div>

<div class="modal-body">
    {!! Form::model(Request::all(), ["id" => "frm_editar_pregunta", "data-smk-icon" => "glyphicon-remove-sign"]) !!}
        {!! Form::hidden("pregunta_id", $pregunta_id) !!}

        <div class="form-group">
            <label class="control-label" for="tipo_id"> Tipo de pregunta</label>
            {!! Form::select("tipo_id", $tipo_pregunta, $pregunta->tipo_id, [
                "class" => "form-control",
                "id" => "tipo_pregunta_select",
                //"onchange" => "tipo_pregunta(this)",
                "required" => "required",
                "disabled"
            ]); !!}

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar", $errors) !!}</p>
        </div>

        <div class="form-group">
            <label class="control-label" for="descripcion">Pregunta</label>
            
            {!! Form::text("descripcion", $pregunta->descripcion, [
                "class" => "form-control",
                "id" => "descripcion",
                "placeholder" => "Escriba su pregunta",
                "required" => "required"
            ]); !!}

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion", $errors) !!}</p>
        </div>

        {{-- Muestra el perso porcentual --}}
        @if($pregunta->tipo_id == 1 || $pregunta->tipo_id == 2 || $pregunta->filtro == 1)
            <div class="form-group" id="peso_porcentual">
                <label class="control-label" for="peso_porcentual_pregunta">
                    Definir peso porcentual de la pregunta % *
                </label>

                {!! Form::text("peso_porcentual_pregunta", $pregunta->peso_porcentual, [
                    "class" => "form-control",
                    "id" => "peso_porcentual_pregunta",
                    "placeholder" => "Ingrese el peso porcentual que va a tener la pregunta con respecto a las demás",
                    "onkeypress" => "javascript:return isNumber(event)",
                    "disabled"
                ]); !!}
            </div>
        @endif

        {{-- Única respuesta --}}
        @if($pregunta->tipo_id == 2)
            <div class="mb-1" id="filtro_box">
                <label class="toggle" for="myToggle">
                    <p>Pregunta filtro</p>

                    <input
                        type="checkbox"
                        class="toggle__input"
                        name="filtro"
                        id="myToggle"
                        onchange="filtro_change(this)"
                        value="1"
                        disabled
                        {{ ($pregunta->filtro) ? 'checked' : '' }}
                    >
                    <div class="toggle__fill"></div>
                </label>
            </div>
        @endif

        <div>
            <div class="row">
                @if($pregunta->tipo_id == 1 || $pregunta->tipo_id == 2)
                    <div class="col-md-8 mb-1" id="options_title">
                        <h4>Opciones de respuesta</h4>
                    </div>

                    @if($pregunta->filtro == 0)
                        <div class="col-md-2 mb-1" id="options_title_porcentual">
                            <h5>
                                <span class="label label-default">Peso porcentual %</span>
                            </h5>
                        </div>
                    @endif

                    @if($pregunta->filtro == 1)
                        <div class="col-md-2 mb-1" id="options_title_filtro">
                            <h5>
                                <span class="label label-default">Opcion/es correcta/s</span>
                            </h5>
                        </div>
                    @endif

                    <div class="col-md-8" id="cantidad_opciones_fields">
                        @foreach($opciones_pregunta as $opcion)
                            {!! Form::hidden("opcion_id[]", $opcion->id) !!}
                            <div class="form-group" id="form_group_nuevas_opciones">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="nueva_opcion[]"
                                    id="nueva_opcion_descripcion"
                                    placeholder="Descripción de opción"
                                    value="{{ $opcion->descripcion_resp }}"
                                >
                            </div>
                        @endforeach
                    </div>

                    @if($pregunta->filtro == 0)
                        <div class="col-md-2" id="cantidad_porcentajes">
                            <?php $total_porcentaje = 0; ?>
                            @foreach($opciones_pregunta as $opcion)
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="nuevo_porcentaje[]"
                                        id="nuevo_porcentaje_opcion"
                                        placeholder="Descripción de opción"
                                        value="{{ $opcion->puntuacion }}"
                                        onkeypress="javascript:return isNumber(event)"
                                        onkeyup="getTotalPorcentaje()"
                                        placeholder="Ingrese porcentaje de opción"
                                    >
                                </div>

                                <?php $total_porcentaje = $total_porcentaje + $opcion->puntuacion; ?>
                            @endforeach
                        </div>
                    @endif

                    @if($pregunta->filtro == 1)
                        <div class="col-md-2" id="cantidad_filtros">
                            @foreach($opciones_pregunta as $index => $opcion)
                                <div class="form-group check-pd">
                                    <input
                                        type="checkbox"
                                        name="nuevo_filtro[{{ $index }}]"
                                        value="1"
                                        {{ ($opcion->minimo == 1) ? 'checked' : '' }}
                                    >
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>

            @if($pregunta->tipo_id == 1 || $pregunta->tipo_id == 2)
                @if($pregunta->filtro == 0)
                    <div class="row" id="box_total_porcentaje">
                        <div class="col-md-8"></div>
                        <div class="col-md-2 mb-1">
                            <h4>
                                <span class="label label-success" id="total_badge">Total: {{ $total_porcentaje }} %</span>
                            </h4>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    {!! Form::close() !!}
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="actualizar_preg">Editar</button>
</div>

<script>
    const tipo_pregunta_select = document.querySelector('#tipo_pregunta_select')
    const peso_porcentual = document.querySelector('#peso_porcentual')
    const filtro_box = document.querySelector('#filtro_box')
    const cantidad_opciones_fields = document.querySelector('#cantidad_opciones_fields') //Div de opciones
    const cantidad_porcentajes = document.querySelector('#cantidad_porcentajes') //Div de porcentajes
    const cantidad_filtros = document.querySelector('#cantidad_filtros') //Div de checkbox filtros
    const options_title = document.querySelector('#options_title') //Titulo de sección
    const options_title_filtro = document.querySelector('#options_title_filtro') //Titulo de sección de filtros checks
    const options_title_porcentual = document.querySelector('#options_title_porcentual') //Titulo de sección de filtros checks
    const total_badge = document.querySelector('#total_badge')

    //Validar si la pregunta es de única respuesta
    if (tipo_pregunta_select.value == 2) {
        document.querySelector('#myToggle').addEventListener('change', () => {
            clearDivsOptions()
        })
    }

    //Solo permitir números
    function isNumber(evt) {
        let iKeyCode = (evt.which) ? evt.which : evt.keyCode

        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;

        return true;
    }

    function filtro_change(obj) {
        //Si es filtro
        if(obj.checked){
            peso_porcentual.setAttribute('hidden', true)

            document.querySelector('#box_total_porcentaje').setAttribute('hidden', true) //Total porcentaje
        //No es filtro
        }else{
            peso_porcentual.removeAttribute('hidden')
        }
    }

    function clearDivsOptions() {
        options_title.setAttribute('hidden', true)
        options_title_porcentual.setAttribute('hidden', true)
        options_title_filtro.setAttribute('hidden', true)

        cantidad_opciones_fields.innerHTML = '';
        cantidad_porcentajes.innerHTML = '';
        cantidad_filtros.innerHTML = '';
    }

    function getTotalPorcentaje() {
        const fieldPorcentaje = document.querySelectorAll('#nuevo_porcentaje_opcion')

        let fieldPorcentajeTotal = 0;

        fieldPorcentaje.forEach((field) => {
            if(field.value === "") {
                fieldPorcentajeTotal = parseInt(fieldPorcentajeTotal) + 0 //Si es <empty string> se cambio por 0
            }

            if(field.value != "") {
               fieldPorcentajeTotal = parseInt(fieldPorcentajeTotal) + parseInt(field.value)
            }
        })

        total_badge.innerHTML = 'Total : '+ fieldPorcentajeTotal +' %' //Inserta valor en el badge

        if(fieldPorcentajeTotal < 100 || fieldPorcentajeTotal > 100 || fieldPorcentajeTotal === 0) {
            document.querySelector('#actualizar_preg').disabled = true

            total_badge.classList.remove('label-success')
            total_badge.classList.add('label-danger')
        }else{
            document.querySelector('#actualizar_preg').disabled = false

            total_badge.classList.add('label-success')
        }
    }
</script>