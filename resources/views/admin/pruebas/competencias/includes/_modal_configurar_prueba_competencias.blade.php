<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="competenciasConfiguracionLabel">Configuración Prueba Personal Skills</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
                <p>
                    <b>Bienvenido(a) a la configuración de la prueba de Personal Skills.</b>
                </p>
                <p>
                    <b>
                        ...
                    </b>
                </p>
            </div>
        </div>

        <form id="frmConfiguracionCompetencias">
            <input type="hidden" name="cargo_generico_id" id="cargoGenericoId" value="{{ $cargoGenericoId }}">
            <input type="hidden" name="req_id" id="requerimientoId" value="{{ $requerimientoId }}">

            @if(isset($configuracionCargo))
                <input type="hidden" name="cargo_id" id="cargoId" value="{{ $cargoId }}">
            @endif

            <div class="col-md-12">
                <h4>Niveles asociados al cargo genérico</h4>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @foreach($familiaNiveles as $key => $nivel)
                            <div class="checkbox">
                                <label>
                                    <input type="radio" name="nivel_id" value="{{ $nivel->nivel_id }}" onchange="cargarPorNivel(this)" {{ ($key == 0) ? 'checked' : '' }}> {{ $nivel->nivel->descripcion }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <h4>Competencias asociadas a los niveles</h4>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body" id="boxTableCompetencias">
                        @include('admin.pruebas.competencias.includes._section_lista_competencias')
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

    <button 
        type="button" 
        class="btn btn-success" 
        id="guardarConfiguracionBryg" 

        @if(isset($configuracionCargo))
            {{-- Actualizar --}}
            onclick="guardarConfiguracionCargoCompetencias(this, '{{ route("admin.actualizar_configuracion_competencias_cargo") }}')"
        @elseif(!isset($configuracionReq))
            onclick="guardarConfiguracionCargoCompetencias(this, '{{ route("admin.guardar_configuracion_competencias_cargo") }}')"
        @else
            onclick="guardarConfiguracionCompetencias(this, '{{ route("admin.guardar_configuracion_competencias_requerimiento") }}')"
        @endif >
        Guardar
    </button>
</div>

<script>
    function cargarPorNivel(obj) {
        if (obj.checked) {
            $.ajax({
                type: 'POST',
                url: '{{ route("admin.cargar_configuracion_competencias") }}',
                data: {
                    nivel_id: obj.value
                },
                beforeSend: function() {
                    //
                    $.smkAlert({
                        text: 'Cargando competencias asociadas ...',
                        type: 'success',
                    });
                },
                success: function(response) {
                    //
                    document.querySelector('#boxTableCompetencias').innerHTML = response
                }
            })
        }
    }

    function competenciaCheck(obj) {
        let esperadoId = obj.dataset.esperadoId
        let margenAcertividad = obj.dataset.margenAcertividad

        if (obj.checked) {
            document.querySelector(`#${esperadoId}`).removeAttribute('disabled')
            document.querySelector(`#${margenAcertividad}`).removeAttribute('disabled')
        }else {
            document.querySelector(`#${esperadoId}`).setAttribute('disabled', true)
            document.querySelector(`#${margenAcertividad}`).setAttribute('disabled', true)
        }
    }

    function rangeValue(obj) {
        let esperadoId = obj.dataset.esperadoId
        let rangoAcertividad = obj.dataset.rangoAcertividad

        let nivelEsperado = document.querySelector(`#${esperadoId}`).value
        let spanRangoAcertividad = document.querySelector(`#${rangoAcertividad}`)

        let rangoDown = nivelEsperado - obj.value
        let rangoUp = parseInt(nivelEsperado) + parseInt(obj.value)

        spanRangoAcertividad.textContent = `${rangoDown} - ${rangoUp}`

        obj.nextElementSibling.textContent = obj.value
    }

    function inputEsperado(obj) {
        if (obj.value > 100) {
            obj.value = 100
        }

        let margenAcertividad = obj.dataset.margenAcertividad
        let rangoAcertividad = obj.dataset.rangoAcertividad

        let nivelEsperado = obj.value
        let spanRangoAcertividad = document.querySelector(`#${rangoAcertividad}`)
        let rangeMargenAcertividad = document.querySelector(`#${margenAcertividad}`)

        let rangoDown = nivelEsperado - parseInt(rangeMargenAcertividad.value)
        let rangoUp = parseInt(nivelEsperado) + parseInt(rangeMargenAcertividad.value)

        spanRangoAcertividad.textContent = `${rangoDown} - ${rangoUp}`
    }
</script>