<style type="text/css">
    .py-0 {
        padding-bottom: 0px; padding-top: 0px;
    }

    .scroll-doc {
        max-height: 300px; overflow: scroll;
    }

    .mb-2 {
        margin-bottom: 0.5rem;
    }

    .mb-0 {
        margin-bottom: 0px;
    }

    .error-smg-valor {
        color: #dd4b39;
        padding-right: 15px;
        position: absolute;
        right: 0;
        font-size: 12px;
        margin-top: 0;
        margin-bottom: 0;
        display: none;
    }
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    @if (!empty($req_id))
        <h4 class="modal-title">Configurar Prueba Ethical Values para el Requerimiento # {{ $req_id }}</h4>
    @else
        <h4 class="modal-title">Configurar Prueba Ethical Values para el Cargo <b>{{ $configuracion->cargo->descripcion }}</b></h4>
    @endif
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
                <p>
                    <b>Bienvenido(a) a la configuración de la Prueba EV (Ethical Values).</b>
                </p>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h1 class="panel-title" id="panelDescripcionPruebaValores" hidden></h1>
                </div>

                <div class="panel-body">
                    {!! Form::open(["id"=>"frmIdealPruebaValores"]) !!}
                        @if (!empty($req_id))
                            {!! Form::hidden('req_id',$req_id) !!}
                        @else
                            {!! Form::hidden('cargo_id',$cargo_id) !!}
                        @endif
                        <div class="form-group">
                            <div class="col-md-4 text-center">
                                <label for="verdad">VERDAD <span class="small">(rango 0-100 %)</span></label>
                                <input 
                                    type="number" 
                                    class="form-control solo-numero" 
                                    id="verdad" 
                                    placeholder="VERDAD" 
                                    data-cuadrante="verdad" 
                                    data-max="100" 
                                    value="{{ $configuracion->valor_verdad }}">
                            </div>
                            <div class="col-md-4 text-center">
                                <label for="rectitud">RECTITUD <span class="small">(rango 0-100 %)</span></label>
                                <input 
                                    type="number" 
                                    class="form-control solo-numero" 
                                    id="rectitud" 
                                    placeholder="RECTITUD" 
                                    data-cuadrante="rectitud" 
                                    data-max="100" 
                                    value="{{ $configuracion->valor_rectitud }}">
                            </div>
                            <div class="col-md-4 text-center">
                                <label for="paz">PAZ <span class="small">(rango 0-100 %)</span></label>
                                <input 
                                    type="number" 
                                    class="form-control solo-numero" 
                                    id="paz" 
                                    placeholder="PAZ" 
                                    data-cuadrante="paz" 
                                    data-max="100" 
                                    value="{{ $configuracion->valor_paz }}">
                            </div>
                            <div class="col-md-4 text-center">
                                <label for="amor">AMOR <span class="small">(rango 0-100 %)</span></label>
                                <input 
                                    type="number" 
                                    class="form-control solo-numero" 
                                    id="amor" 
                                    placeholder="AMOR" 
                                    data-cuadrante="amor" 
                                    data-max="100" 
                                    value="{{ $configuracion->valor_amor }}">
                            </div>
                            <div class="col-md-4 text-center">
                                <label for="no_violencia">NO VIOLENCIA <span class="small">(rango 0-100 %)</span></label>
                                <input 
                                    type="number" 
                                    class="form-control solo-numero" 
                                    id="no_violencia" 
                                    placeholder="NO VIOLENCIA" 
                                    data-cuadrante="no_violencia" 
                                    data-max="100" 
                                    value="{{ $configuracion->valor_no_violencia }}">
                            </div>
                        </div>
                    {!! Form::close() !!}

                    <div class="col-md-12">
                        <br>

                        <p class="text-danger" id="msjSumaPruebaValores" hidden></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Canvas para cargar gráfico --}}
        <div class="col-md-12">
            <canvas id="graficoIdealPruebaValores" height="120"></canvas>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

    @if (!empty($req_id))
        <button 
            type="button" 
            class="btn btn-success" 
            id="guardarConfiguracionPruebaValores" 
            onclick="guardarConfiguracionPruebaValores(this, '{{ route("admin.guardar_configuracion_prueba_valores") }}')" 
            data-reqid="{{ $req_id }}"
            disabled="disabled">
            Guardar
        </button>
    @else
        <button 
            type="button" 
            class="btn btn-success" 
            id="guardarConfiguracionPruebaValores" 
            onclick="guardarConfiguracionPruebaValores(this, '{{ route("admin.guardar_configuracion_prueba_valores") }}')"
            disabled="disabled">
            Guardar
        </button>
    @endif
</div>

<script>
    cargo_modulo = null;
    cargo_es_id = null;
    reque_id = null;

    @if (!empty($req_id))
        reque_id = "{{ $req_id }}";
    @else
        cargo_modulo = true;
        cargo_es_id = "{{ $cargo_id }}";
    @endif

    let valoresIdealPruebaValores = {
        verdad: parseInt("{{ ($configuracion->valor_verdad != null ? $configuracion->valor_verdad : 0) }}"), 
        rectitud: parseInt("{{ ($configuracion->valor_rectitud != null ? $configuracion->valor_rectitud : 0) }}"), 
        paz: parseInt("{{ ($configuracion->valor_paz != null ? $configuracion->valor_paz : 0) }}"), 
        amor: parseInt("{{ ($configuracion->valor_amor != null ? $configuracion->valor_amor : 0) }}"), 
        no_violencia: parseInt("{{ ($configuracion->valor_no_violencia != null ? $configuracion->valor_no_violencia : 0) }}") 
    }

    const btnGuardarPruebaValores = document.querySelector('#guardarConfiguracionPruebaValores')

    //Generador de gráfico de radar
    const generarIdealPruebaValores = () => {
        let graficoIdealPruebaValores = document.getElementById('graficoIdealPruebaValores')

        let radarChart = new Chart(graficoIdealPruebaValores, {
            type: 'radar',
            data: {
                labels: ['VERDAD', 'RECTITUD', 'PAZ', 'AMOR', 'NO VIOLENCIA' ],
                datasets: [{
                    label: 'Resultados',
                    backgroundColor: ['rgba(0, 169, 84, 0.8)'],
                    borderColor: [
                        'rgba(0, 169, 84, 1)'
                    ],
                    data: [valoresIdealPruebaValores.verdad, valoresIdealPruebaValores.rectitud, valoresIdealPruebaValores.paz, valoresIdealPruebaValores.amor, valoresIdealPruebaValores.no_violencia],
                    borderWidth: 1
                }]
            },
            options: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Prueba Ethical Values Gráfico de radar'
                }
            }
        })
    }

    //Actualizar gráfico cuando detecte cambios en los campos
    $("input[type=number]").on('keyup input', function(){
        let obj = this;
        let cuadrante = obj.dataset.cuadrante
        let max = parseInt(obj.dataset.max)
        let cuadranteVacio = false

        switch (cuadrante) {
            case 'verdad':
                valoresIdealPruebaValores['verdad'] = obj.value

                break;
            case 'rectitud':
                valoresIdealPruebaValores['rectitud'] = obj.value

                break;
            case 'paz':
                valoresIdealPruebaValores['paz'] = obj.value

                break;
            case 'amor':
                valoresIdealPruebaValores['amor'] = obj.value

                break;
            case 'no_violencia':
                valoresIdealPruebaValores['no_violencia'] = obj.value

                break;
            default:
                break;
        }

        //Validar el valor del campo
        if (obj.value > max) {
            obj.value = ""

            //Informa que no es un valor valido 
            $.smkAlert({text: 'El valor máximo es <b>'+max+'</b>.', type: 'danger'})
            cuadranteVacio = false
        }

        generarIdealPruebaValores()

        //Sumar los valores ideales
        sumarValores(valoresIdealPruebaValores, cuadranteVacio)
    });

    const sumarValores = (pruebaValores, cuadranteVacio) => {
        let msjSumaPruebaValores = document.querySelector('#msjSumaPruebaValores')
        //totalPruebaValores = parseInt(pruebaValores.verdad) + parseInt(pruebaValores.rectitud) + parseInt(pruebaValores.paz) + parseInt(pruebaValores.amor) + parseInt(pruebaValores.no_violencia)

        if (pruebaValores.verdad == '' || pruebaValores.rectitud == '' || pruebaValores.paz == '' || pruebaValores.amor == '' || pruebaValores.no_violencia == '' || cuadranteVacio) {
            btnGuardarPruebaValores.setAttribute('disabled', true)

            msjSumaPruebaValores.innerHTML = `<b>Debe colocar un valor a cada item (puede ingresar cero).</b>`
            msjSumaPruebaValores.removeAttribute('hidden')
        } else {
            msjSumaPruebaValores.setAttribute('hidden', true)
            btnGuardarPruebaValores.removeAttribute('disabled')
        }
    }

    generarIdealPruebaValores()

    function guardarConfiguracionPruebaValores(obj, route) {
        $.ajax({
            type: "POST",
            url: route,
            data: {
                cargo_id: cargo_es_id,
                req_id: reque_id,
                cargo_modulo: cargo_modulo,
                valor_verdad: valoresIdealPruebaValores.verdad,
                valor_rectitud: valoresIdealPruebaValores.rectitud,
                valor_amor: valoresIdealPruebaValores.amor,
                valor_paz: valoresIdealPruebaValores.paz,
                valor_no_violencia: valoresIdealPruebaValores.no_violencia
            },
            beforeSend: function() {
                obj.setAttribute('disabled', true)
            },
            success: function(response) {
                $.smkAlert({text: 'Configuración guardada con éxito.', type: 'success'})
                obj.removeAttribute('disabled')

                setTimeout(() => {
                    $('#modal_gr').modal('hide')
                }, 800)
            }
        })
    }
</script>