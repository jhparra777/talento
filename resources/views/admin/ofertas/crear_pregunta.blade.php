<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>

    <h4 class="modal-title">Nueva Pregunta</h4>
</div>

<div class="modal-body">
    {{-- Para definir preguntas --}}
    @if(isset($definir_preguntas))
        @if($cantidad_preguntas == '' || $cantidad_preguntas == null)
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <strong>Definir número de preguntas para la oferta.</strong>
                <ul>
                    <li>Cada pregunta debe tener un valor porcentual que debes asignar, no debe sobrepasar el 100%.</li>
                    <li>Las preguntas abiertas y preguntas filtro no se tienen en cuenta.</li>
                </ul>
            </div>
        @else
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <strong>Número de preguntas de la oferta.</strong>
                <p>Si la cantidad de preguntas es cambiada se debe actualizar los porcentajes nuevamente de cada una, no debe sobrepasar el 100%.</p>
            </div>
        @endif

        <div class="row vertical-flex">
            <div class="col-md-10">
                <div class="form-group">
                    <label class="control-label" for="cantidad_preguntas">
                        Definir número de preguntas para la oferta *
                    </label>

                    {!! Form::text("cantidad_preguntas", $cantidad_preguntas, [
                        "class" => "form-control",
                        "id" => "cantidad_preguntas",
                        "placeholder" => "Ingrese el número de preguntas que va tener la oferta",
                        "onkeypress" => "javascript:return isNumber(event)"
                        //"required" => "required"
                    ]); !!}
                </div>
            </div>

            <div class="col-md-2">
                <button
                    type="button"
                    class="btn btn-success"
                    id="crear_cantidad_preguntas"
                    onclick="crear_cantidad_preguntas(this)"
                    data-req_id="{{ $req_id }}"
                    style="margin-top: 1rem;"
                >
                    Definir
                </button>
            </div>
        </div>

        <h4 class="mb-1">Lista preguntas</h4>
        
        {!! Form::open(["id" => "frm_preguntas_peso_porcentual", "method" => "POST"]) !!}
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>Pregunta (Descripción)</th>
                    <th>Peso porcentual %</th>
                </thead>
                <tbody>
                    @if(count($preguntas_porcentaje) <= 0)
                        <tr>
                            <td colspan="3">
                                No hay preguntas creadas.
                            </td>
                        </tr>
                    @endif

                    <?php $total_porcentaje = 0; ?>
                    @foreach($preguntas_porcentaje as $index => $pregunta)
                        <tr>
                            <th>{{ ++$index }}</th>
                            <td>
                                {{ $pregunta->descripcion }}
                            </td>
                            <td>
                                <input type="hidden" name="pregunta_id[]" value="{{ $pregunta->id }}">

                                <input
                                    type="text"
                                    name="peso_porcentual_pregunta[]"
                                    id="porcentaje_pregunta"
                                    class="form-control"
                                    value="{{ $pregunta->peso_porcentual }}"
                                    onkeypress="javascript:return isNumber(event)"
                                    onkeyup="getTotalPorcentaje()"
                                >
                            </td>
                        </tr>

                        <?php $total_porcentaje = $total_porcentaje + $pregunta->peso_porcentual; ?>
                    @endforeach

                    <tr>
                        <th></th>
                        <td></td>
                        <td>
                            <div class="form-group input-total has-success">
                                <label class="control-label">Total:</label>

                                <input
                                    type="text"
                                    name="total_porcentual_pregunta"
                                    id="total_porcentual_pregunta_input"
                                    class="form-control"
                                    value="{{ $total_porcentaje }}"
                                    onkeypress="javascript:return isNumber(event)"
                                    disabled
                                >
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-12 text-right">
                    @if(count($preguntas_porcentaje) > 0)
                        <button type="button" class="btn btn-success" id="actualizar_porcentajes">Actualizar porcentajes</button>
                    @else
                        <button type="button" class="btn btn-success" id="actualizar_porcentajes" disabled>Actualizar porcentajes</button>
                    @endif
                </div>
            </div>
        {!! Form::close() !!}

    {{-- Para crear preguntas --}}
    @else
        {!! Form::model(Request::all(), ["id" => "frm_crear_pregunta", "data-smk-icon" => "glyphicon-remove-sign"]) !!}
            {!! Form::hidden("req_id", $req_id) !!}
            {!! Form::hidden("cargo_id", $cargo_id) !!}

            <div class="form-group">
                <label class="control-label" for="tipo_id"> Tipo de pregunta</label>
                {!! Form::select("tipo_id", $tipo_pregunta, null, [
                    "class" => "form-control",
                    "id" => "tipo_pregunta_select",
                    "onchange" => "tipo_pregunta(this)",
                    "required" => "required"
                ]); !!}

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar", $errors) !!}</p>
            </div>

            <div class="form-group">
                <label class="control-label" for="descripcion">Pregunta</label>
                
                {!! Form::text("descripcion", null, [
                    "class" => "form-control",
                    "id" => "descripcion",
                    "placeholder" => "Escriba su pregunta",
                    "required" => "required"
                ]); !!}

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion", $errors) !!}</p>
            </div>

            <div class="mb-1" id="filtro_box" hidden>
                <label class="toggle" for="myToggle">
                    <p>Pregunta filtro</p>

                    <input
                        type="checkbox"
                        class="toggle__input"
                        name="filtro"
                        id="myToggle"
                        onchange="filtro_change(this)"
                        value="1"
                    >
                    <div class="toggle__fill"></div>
                </label>
            </div>

            <div class="form-group" id="peso_porcentual" hidden>
                <label class="control-label" for="peso_porcentual_pregunta">
                    Definir peso porcentual de la pregunta % *
                </label>

                {!! Form::text("peso_porcentual_pregunta", null, [
                    "class" => "form-control",
                    "id" => "peso_porcentual_pregunta",
                    "placeholder" => "Ingrese el peso porcentual que va a tener la pregunta con respecto a las demás",
                    "onkeypress" => "javascript:return isNumber(event)",
                    //"required" => "required"
                ]); !!}
            </div>

            <div id="cantidad_opciones_box" hidden>
                <div class="row vertical-flex">
                    <div class="col-md-10">
                        <div class="form-group" id="cantidad_opciones_group">
                            <label class="control-label" for="cantidad_opciones">
                                Definir número de opciones de respuesta <small>(Máx 10)</small> *
                            </label>

                            {!! Form::text("cantidad_opciones", null, [
                                "class" => "form-control",
                                "id" => "cantidad_opciones",
                                "placeholder" => "Ingrese el número de opciones de respuesta que va tener el candidato",
                                "onkeypress" => "javascript:return isNumber(event)",
                                //"required" => "required"
                            ]); !!}

                            <span class="help-block">
                                Máximo 10 opciones por pregunta.
                            </span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button
                            type="button"
                            class="btn btn-success"
                            id="crear_opciones"
                            onclick="crear_opciones_pregunta(this)"
                            style="margin-bottom: 1.5rem;"
                        >
                            Definir
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <div class="row">
                    <div class="col-md-8 mb-1" id="options_title" hidden>
                        <h4>Definir opciones de respuesta</h4>
                    </div>
                    <div class="col-md-2 mb-1" id="options_title_porcentual" hidden>
                        <h5>
                            <span class="label label-default">Peso porcentual %</span>
                        </h5>
                    </div>
                    <div class="col-md-2 mb-1" id="options_title_filtro" hidden>
                        <h5>
                            <span class="label label-default">Opcion/es correcta/s</span>
                        </h5>
                    </div>

                    <div class="col-md-8" id="cantidad_opciones_fields"></div>
                    <div class="col-md-2" id="cantidad_porcentajes"></div>
                    <div class="col-md-2" id="cantidad_filtros" hidden></div>
                </div>

                <div class="row" id="box_total_porcentaje" hidden>
                    <div class="col-md-8"></div>
                    <div class="col-md-2 mb-1">
                        <h4>
                            <span class="label label-success" id="total_badge">Total:</span>
                        </h4>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    @endif
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

    @if(!isset($definir_preguntas))
        <button type="button" class="btn btn-success" id="guardar_preg">Guardar</button>
    @endif
</div>

{{-- Para definir preguntas --}}
@if(isset($definir_preguntas))
    <script>
        function crear_cantidad_preguntas(obj) {
            let req_id = obj.dataset.req_id
            let cantidad_preguntas = document.querySelector('#cantidad_preguntas')

            if(cantidad_preguntas.value.length != 0){
                $.ajax({
                    type: "POST",
                    data: {
                        req_id: req_id,
                        cantidad: cantidad_preguntas.value
                    },
                    url: "{{ route('admin.guardar_cantidad_preguntas') }}",
                    beforeSend: function () {
                        $.smkAlert({
                            text: 'Guardando información.',
                            type: 'info'
                        });
                    },
                    success: function (response) {
                        $.smkAlert({
                            text: 'Información guardada correctamente.',
                            type: 'success'
                        });

                        $("#modal_gr").modal("hide");
                    },
                    error: function(response) {
                        $.smkAlert({
                            text: 'Ha ocurrido un error, intenta nuevamente.',
                            type: 'danger'
                        })
                    }
                })
            }else{
                $.smkAlert({
                    text: 'Debes definir la cantidad de preguntas.',
                    type: 'danger'
                })
            }
        }

        //Guardar pregunta
        const actualizar_porcentajes = document.querySelector('#actualizar_porcentajes')
        
        actualizar_porcentajes.addEventListener('click', () =>{
            actualizar_porcentajes.disabled = true

            $.ajax({
                type: "POST",
                data: $("#frm_preguntas_peso_porcentual").serialize(),
                url: "{{ route('admin.guardar_porcentaje_preguntas') }}",
                beforeSend: function() {
                    $.smkAlert({
                        text: 'Actualizando porcentajes ...',
                        type: 'info'
                    });
                },
                success: function (response) {
                    $.smkAlert({
                        text: 'Información guardada correctamente.',
                        type: 'success'
                    });

                    actualizar_porcentajes.disabled = false

                    /*setTimeout(() => {
                        window.location.reload(true)
                    }, 1500)*/
                },
                error:function(response) {
                    $.smkAlert({
                        text: 'Ha ocurrido un error, intente nuevamente.',
                        type: 'danger'
                    });

                    actualizar_porcentajes.disabled = false
                }
            });
        });

        function isNumber(evt) {
            let iKeyCode = (evt.which) ? evt.which : evt.keyCode

            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                return false;

            return true;
        }

        function getTotalPorcentaje(obj) {
            const fieldPorcentaje = document.querySelectorAll('#porcentaje_pregunta')

            let fieldPorcentajeTotal = 0;

            fieldPorcentaje.forEach((field) => {
                if(field.value === "") {
                    fieldPorcentajeTotal = parseInt(fieldPorcentajeTotal) + 0 //Si es <empty string> se cambio por 0
                }

                if(field.value != "") {
                   fieldPorcentajeTotal = parseInt(fieldPorcentajeTotal) + parseInt(field.value)
                }
            })

            //console.log(fieldPorcentajeTotal)

            document.querySelector('#total_porcentual_pregunta_input').value = fieldPorcentajeTotal //Inserta valor en el input

            if(fieldPorcentajeTotal < 100 || fieldPorcentajeTotal > 100 || fieldPorcentajeTotal === 0) {
                document.querySelector('#actualizar_porcentajes').disabled = true

                document.querySelector('.input-total').classList.remove('has-success')
                document.querySelector('.input-total').classList.add('has-error')
            }else{
                document.querySelector('#actualizar_porcentajes').disabled = false

                document.querySelector('.input-total').classList.remove('has-error')
                document.querySelector('.input-total').classList.add('has-success')
            }
        }
    </script>

{{-- Para crear preguntas --}}
@else
    <script>
        const tipo_pregunta_select = document.querySelector('#tipo_pregunta_select')
        const peso_porcentual = document.querySelector('#peso_porcentual')
        const filtro_box = document.querySelector('#filtro_box')

        const cantidad_opciones_box = document.querySelector('#cantidad_opciones_box') //Div master de opciones
        const cantidad_opciones_group = document.querySelector('#cantidad_opciones_group')

        const cantidad_opciones_fields = document.querySelector('#cantidad_opciones_fields') //Div de opciones
        const cantidad_porcentajes = document.querySelector('#cantidad_porcentajes') //Div de porcentajes
        const cantidad_filtros = document.querySelector('#cantidad_filtros') //Div de checkbox filtros
        const options_title = document.querySelector('#options_title') //Titulo de sección
        const options_title_filtro = document.querySelector('#options_title_filtro') //Titulo de sección de filtros checks
        const options_title_porcentual = document.querySelector('#options_title_porcentual') //Titulo de sección de filtros checks

        const total_badge = document.querySelector('#total_badge')

        document.querySelector('#myToggle').addEventListener('change', () => {
            clearDivsOptions()
        })

        function tipo_pregunta(obj) {
            //Múltiple respuesta
            if(obj.value == 1) {
                clearDivsOptions() //Limpia los divs de opciones

                cantidad_opciones_box.removeAttribute('hidden')
                peso_porcentual.removeAttribute('hidden')

                filtro_box.setAttribute('hidden', true)

            //Única respuesta
            }else if(obj.value == 2) {
                clearDivsOptions() //Limpia los divs de opciones

                cantidad_opciones_box.removeAttribute('hidden')
                peso_porcentual.removeAttribute('hidden')

                filtro_box.removeAttribute('hidden')

            //Abierta
            }else if(obj.value == 3) {
                clearDivsOptions() //Limpia los divs de opciones

                cantidad_opciones_box.setAttribute('hidden', true)
                peso_porcentual.setAttribute('hidden', true)
                filtro_box.setAttribute('hidden', true)

            }else{
                clearDivsOptions() //Limpia los divs de opciones

                cantidad_opciones_box.setAttribute('hidden', true)
                peso_porcentual.setAttribute('hidden', true)
                filtro_box.setAttribute('hidden', true)
            }

            document.querySelector('#box_total_porcentaje').setAttribute('hidden', true) //Total porcentaje
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

        function crear_opciones_pregunta(obj) {
            clearDivsOptions() //Limpia los divs de opciones

            let cantidad_opciones = document.querySelector('#cantidad_opciones')
            let valor_porcentajes = 100/cantidad_opciones.value

            if(cantidad_opciones.value === "" || cantidad_opciones.value === null) {
                $.smkAlert({
                    text: 'La cantidad de opciones es obligatoria.',
                    type: 'info'
                });
            }else{
                if (validateQuantityOptions(cantidad_opciones.value)){
                    for(let i = 0; i < cantidad_opciones.value; i++){
                        //Define los campos de descripción de la opción
                        const nueva_opcion = document.createElement('input')

                        nueva_opcion.setAttribute('type', 'text')
                        nueva_opcion.setAttribute('class', 'form-control')
                        nueva_opcion.setAttribute('name', 'nueva_opcion[]')
                        nueva_opcion.setAttribute('id', 'nueva_opcion_descripcion')
                        nueva_opcion.setAttribute('placeholder', 'Descripción de opción')

                        const nuevo_form_group = document.createElement('div') //Crea el div form-group

                        nuevo_form_group.setAttribute('class', 'form-group')
                        nuevo_form_group.setAttribute('id', 'form_group_nuevas_opciones')
                        nuevo_form_group.appendChild(nueva_opcion) //Inserta los campos descripción en el div form-group

                        cantidad_opciones_fields.appendChild(nuevo_form_group) //Inserta los form-group en la columna

                        //Define los campos para los porcentajes
                        const nuevo_porcentaje = document.createElement('input')

                        nuevo_porcentaje.setAttribute('type', 'text')
                        nuevo_porcentaje.setAttribute('class', 'form-control')
                        nuevo_porcentaje.setAttribute('name', 'nuevo_porcentaje[]')
                        nuevo_porcentaje.setAttribute('id', 'nuevo_porcentaje_opcion')
                        nuevo_porcentaje.setAttribute('value', valor_porcentajes)
                        nuevo_porcentaje.setAttribute('onkeypress', 'javascript:return isNumber(event)')
                        nuevo_porcentaje.setAttribute('onkeyup', 'getTotalPorcentaje()')
                        nuevo_porcentaje.setAttribute('placeholder', 'Ingrese porcentaje de opción')

                        //Pregunta fitro, entonces inhabilita el porcentaje
                        if(tipo_pregunta_select.value == 2 && document.querySelector('#myToggle').checked == true){
                            nuevo_porcentaje.setAttribute('readonly', true)
                            cantidad_porcentajes.setAttribute('hidden', true)
                        }

                        const nuevo_form_group_porcentaje = document.createElement('div') //Crea el div form-group

                        nuevo_form_group_porcentaje.setAttribute('class', 'form-group')
                        nuevo_form_group_porcentaje.appendChild(nuevo_porcentaje) //Inserta los campos porcentaje en el div form-group

                        cantidad_porcentajes.appendChild(nuevo_form_group_porcentaje) //Inserta los form-group en la columna

                        //Pregunta filtro
                        if(tipo_pregunta_select.value == 2){
                            //Define los campos para los porcentajes
                            const nuevo_filtro = document.createElement('input')

                            nuevo_filtro.setAttribute('type', 'checkbox')
                            nuevo_filtro.setAttribute('name', 'nuevo_filtro['+ i +']')
                            nuevo_filtro.setAttribute('value', 1)

                            if(tipo_pregunta_select.value == 2 && document.querySelector('#myToggle').checked == false){
                                nuevo_filtro.setAttribute('checked', true)
                            }

                            const nuevo_form_group_filtro = document.createElement('div') //Crea el div form-group

                            nuevo_form_group_filtro.setAttribute('class', 'form-group check-pd')
                            nuevo_form_group_filtro.appendChild(nuevo_filtro) //Inserta los campos porcentaje en el div form-group

                            cantidad_filtros.appendChild(nuevo_form_group_filtro) //Inserta los form-group en la columna
                        }
                    }

                    options_title.removeAttribute('hidden') //Muestra el titulo de la sección

                    //Pregunta filtro, entonces oculta el porcentaje de las opciones
                    if(tipo_pregunta_select.value == 2 && document.querySelector('#myToggle').checked == true){
                        options_title_porcentual.setAttribute('hidden', true)
                        document.querySelector('#box_total_porcentaje').setAttribute('hidden', true) //Total porcentaje

                        options_title_filtro.removeAttribute('hidden')
                        cantidad_filtros.removeAttribute('hidden')
                    }else{
                        options_title_porcentual.removeAttribute('hidden')
                        cantidad_porcentajes.removeAttribute('hidden')
                        document.querySelector('#box_total_porcentaje').removeAttribute('hidden') //Total porcentaje

                        total_badge.innerHTML = 'Total : '+ 100 +' %'

                        options_title_filtro.setAttribute('hidden', true)
                        cantidad_filtros.setAttribute('hidden', true)
                    }
                }else{
                    options_title.setAttribute('hidden', true)
                    options_title_porcentual.setAttribute('hidden', true)
                    options_title_filtro.setAttribute('hidden', true)

                    $.smkAlert({
                        text: 'Máximo 10 opciones por pregunta.',
                        type: 'danger'
                    });
                }
            }
        }

        function validateQuantityOptions(quantity) {
            if(quantity >= 1 && quantity <= 10) {
                options_title.removeAttribute('hidden')
                options_title_porcentual.removeAttribute('hidden')
                //options_title_filtro.removeAttribute('hidden')

                cantidad_opciones_group.classList.remove('has-error')
                cantidad_opciones_group.classList.add('has-success')

                return true
            }else{
                options_title.setAttribute('hidden', true)
                options_title_porcentual.setAttribute('hidden', true)
                //options_title_filtro.setAttribute('hidden', true)

                cantidad_opciones_group.classList.remove('has-success')
                cantidad_opciones_group.classList.add('has-error')

                return false
            }
        }

        function isNumber(evt) {
            let iKeyCode = (evt.which) ? evt.which : evt.keyCode

            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                return false;

            return true;
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

            //console.log(fieldPorcentajeTotal)

            total_badge.innerHTML = 'Total : '+ fieldPorcentajeTotal +' %' //Inserta valor en el badge

            if(fieldPorcentajeTotal < 100 || fieldPorcentajeTotal > 100 || fieldPorcentajeTotal === 0) {
                document.querySelector('#guardar_preg').disabled = true

                total_badge.classList.remove('label-success')
                total_badge.classList.add('label-danger')
            }else{
                document.querySelector('#guardar_preg').disabled = false

                total_badge.classList.add('label-success')
            }
        }
    </script>
@endif