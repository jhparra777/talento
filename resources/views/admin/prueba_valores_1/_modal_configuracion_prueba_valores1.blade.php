<div class="modal fade" id="pruebaValores1Configuracion" tabindex="-1" role="dialog" aria-labelledby="pruebaValores1ConfiguracionLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="pruebaValores1ConfiguracionLabel">Configuración Prueba EV (Ethical Values)</h4>
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
                                <form id="frmIdealPruebaValores">
                                    <div class="form-group">
                                        <div class="col-md-4 text-center">
                                            <label for="verdad">VERDAD <span class="small">(rango 0-100 %)</span></label>
                                            <input 
                                                type="number" 
                                                class="form-control solo-numero actualiza-grafico-ev" 
                                                id="verdad" 
                                                placeholder="VERDAD" 
                                                data-cuadrante="verdad" 
                                                data-max="100">
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <label for="rectitud">RECTITUD <span class="small">(rango 0-100 %)</span></label>
                                            <input 
                                                type="number" 
                                                class="form-control solo-numero actualiza-grafico-ev" 
                                                id="rectitud" 
                                                placeholder="RECTITUD" 
                                                data-cuadrante="rectitud" 
                                                data-max="100">
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <label for="paz">PAZ <span class="small">(rango 0-100 %)</span></label>
                                            <input 
                                                type="number" 
                                                class="form-control solo-numero actualiza-grafico-ev" 
                                                id="paz" 
                                                placeholder="PAZ" 
                                                data-cuadrante="paz" 
                                                data-max="100">
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <label for="amor">AMOR <span class="small">(rango 0-100 %)</span></label>
                                            <input 
                                                type="number" 
                                                class="form-control solo-numero actualiza-grafico-ev" 
                                                id="amor" 
                                                placeholder="AMOR" 
                                                data-cuadrante="amor" 
                                                data-max="100">
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <label for="no_violencia">NO VIOLENCIA <span class="small">(rango 0-100 %)</span></label>
                                            <input 
                                                type="number" 
                                                class="form-control solo-numero actualiza-grafico-ev" 
                                                id="no_violencia" 
                                                placeholder="NO VIOLENCIA" 
                                                data-cuadrante="no_violencia" 
                                                data-max="100">
                                        </div>
                                    </div>
                                </form>

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

                @if(isset($cargoPruebaValores))
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        id="guardarConfiguracionPruebaValores" 
                        onclick="guardarConfiguracionPruebaValores(this, '{{ route("admin.guardar_configuracion_prueba_valores") }}')"
                        disabled="disabled">
                        Guardar
                    </button>
                @else
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        id="guardarConfiguracionPruebaValores" 
                        onclick="guardarConfiguracionPruebaValores(this, '{{ route("admin.guardar_configuracion_prueba_valores") }}')" 
                        data-reqid="{{ $requermiento->id }}"
                        disabled="disabled">
                        Guardar
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>