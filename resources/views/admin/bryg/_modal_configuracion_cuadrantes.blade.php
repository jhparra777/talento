<div class="modal fade" id="brygConfiguracionCuadrantes" tabindex="-1" role="dialog" aria-labelledby="brygConfiguracionCuadrantesLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="brygConfiguracionCuadrantesLabel">Configuración BRYG-A</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            
                            <p>
                                <b>Bienvenido(a) a la configuración de la prueba BRYG-A.</b>
                            </p>
                            <p>
                                <b>
                                    Antes de comenzar a modificar parámetros o definirlos te recomendamos leer el siguiente PDF (<a href="{{ asset('bryg-aumented.pdf') }}" role="button" target="_blank">VER PDF</a>) que te ayudara a entender que significa cada cuadrante y como se crean los perfiles.
                                </b>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title">ELIGE EL PERFIL QUE SE AJUSTE A LO QUE ESTAS BUSCANDO</h3>
                            </div>

                            <div class="panel-body">
                                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                    <div class="btn-group" role="group">
                                        <button 
                                            type="button" 
                                            class="btn btn-default" 
                                            onclick="cargarPerfilIdeal(this)" 
                                            data-perfil="populista">
                                            POPULISTA
                                        </button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button 
                                            type="button" 
                                            class="btn btn-default" 
                                            onclick="cargarPerfilIdeal(this)" 
                                            data-perfil="científico">
                                            CIENTÍFICO
                                        </button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button 
                                            type="button" 
                                            class="btn btn-default" 
                                            onclick="cargarPerfilIdeal(this)" 
                                            data-perfil="director">
                                            DIRECTOR
                                        </button>
                                    </div>
                                </div>

                                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                    <div class="btn-group" role="group">
                                        <button 
                                            type="button" 
                                            class="btn btn-default" 
                                            onclick="cargarPerfilIdeal(this)" 
                                            data-perfil="cocreador">
                                            COCREADOR
                                        </button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button 
                                            type="button" 
                                            class="btn btn-default" 
                                            onclick="cargarPerfilIdeal(this)" 
                                            data-perfil="capitán">
                                            CAPITÁN
                                        </button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button 
                                            type="button" 
                                            class="btn btn-default" 
                                            onclick="cargarPerfilIdeal(this)" 
                                            data-perfil="protector">
                                            PROTECTOR
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h1 class="panel-title" id="panelDescripcionPerfil" hidden></h1>
                            </div>

                            <div class="panel-body">
                                <form id="frmCuadrantes">
                                    <div class="form-group">
                                        <div class="col-md-3 text-center">
                                            <label for="radical">RADICAL</label>
                                            <input 
                                                type="number" 
                                                class="form-control solo-numero" 
                                                id="radical" 
                                                placeholder="RADICAL" 
                                                data-cuadrante="radical" 
                                                onkeyup="actualizarRadarBRYG(this)">
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <label for="genuino">GENUINO</label>
                                            <input 
                                                type="number" 
                                                class="form-control solo-numero" 
                                                id="genuino" 
                                                placeholder="GENUINO" 
                                                data-cuadrante="genuino" 
                                                onkeyup="actualizarRadarBRYG(this)">
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <label for="garante">GARANTE</label>
                                            <input 
                                                type="number" 
                                                class="form-control solo-numero" 
                                                id="garante" 
                                                placeholder="GARANTE" 
                                                data-cuadrante="garante" 
                                                onkeyup="actualizarRadarBRYG(this)">
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <label for="basico">BÁSICO</label>
                                            <input 
                                                type="number" 
                                                class="form-control solo-numero" 
                                                id="basico" 
                                                placeholder="BÁSICO" 
                                                data-cuadrante="basico" 
                                                onkeyup="actualizarRadarBRYG(this)">
                                        </div>
                                    </div>
                                </form>

                                <div class="col-md-12">
                                    <br>

                                    <p class="text-danger" id="msjSumaCuadrantes" hidden></p>
                                    <p class="text-danger" id="msjCuadrantesValidos" hidden></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Canvas para cargar gráfico --}}
                    <div class="col-md-12">
                        <canvas id="graficoRadarCanvas" height="120"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                @if(isset($cargoModulo))
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        id="guardarConfiguracionBryg" 
                        onclick="guardarConfiguracionCargoBryg(this, '{{ route("admin.guardar_configuracion_bryg_requerimiento") }}')" >
                        Guardar
                    </button>
                @else
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        id="guardarConfiguracionBryg" 
                        onclick="guardarConfiguracionBryg(this, '{{ route("admin.guardar_configuracion_bryg_requerimiento") }}')" 
                        data-reqid="{{ $requermiento->id }}">
                        Guardar
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>