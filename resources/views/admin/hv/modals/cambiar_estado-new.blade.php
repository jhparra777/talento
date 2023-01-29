<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Cambiar Estado</h4>
</div>
<div class="modal-body">
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>Número Identificación</th>
                        <th>Nombres y Apellidos</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>{{ strtoupper($candidato->numero_id) }}</td>
                        <td>{{ strtoupper($candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido) }}</td>
                        <td>{{ $candidato->getEstado() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    {!! Form::model(Request::all(),["id"=>"fr_cambio_estado"]) !!}
        {!! Form::hidden("hv_id",null) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="estado_id" class="control-label">
                        Seleccionar Estado: <span class='text-danger sm-text-label'>*</span>
                    </label>
                    {!! Form::select("ESTADO_ID",$estado,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"estado_id", "required" => "required"]) !!}
                    <p class="error text-danger direction-botones-center" style="{{ ($errors->has('estado_id') ? '' : 'display: none;') }}">{!! FuncionesGlobales::getErrorData("estado_id",$errors) !!}</p>
                </div>
                <div class="form-group" id="div-motivo" style="display: none;">
                    <label for="motivo_rechazo_id" class="control-label">
                        Motivo: <span class='text-danger sm-text-label'>*</span> 
                    </label>
                    {!! Form::select("motivo_rechazo_id",$motivos,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"motivo_rechazo_id"]) !!}
                    <p class="error text-danger direction-botones-center" style="{{ ($errors->has('motivo_rechazo_id') ? '' : 'display: none;') }}">{!! FuncionesGlobales::getErrorData("motivo_rechazo_id",$errors) !!}</p>
                </div>
                <div class="form-group">
                    <label for="observaciones" class="control-label">
                        Observaciones: <span class='text-danger sm-text-label'>*</span> 
                    </label>
                    {!! Form::textarea("observaciones",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Observaciones", "rows" => 3, "required" => "required"]); !!}
                    <p class="error text-danger direction-botones-center" style="{{ ($errors->has('observaciones') ? '' : 'display: none;') }}">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-hover text-center" id="estados_anteriores">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Usuario modificó estado</th>
                                <th>Motivo</th>
                                <th>Observación</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($auditorias as $modificacion)
                                <?php
                                    $gestiono = $modificacion->gestiono();
                                    $estado_auditoria = '';
                                    try {
                                        $estado_id = json_decode($modificacion->estado)->estado;
                                        $estado_aud = $estados->where('id', "$estado_id")->first();
                                        if ($estado_aud != null) {
                                            $estado_auditoria = $estado_aud->descripcion;
                                        }
                                    } catch (\Exception $e) {
                                        $estado_auditoria = '';
                                    }
                                ?>
                                <tr>
                                    <td>{{ $estado_auditoria }}</td>
                                    <td>{{ $modificacion->fecha }}</td>
                                    <td>{{ $gestiono->nombres .' '. $gestiono->primer_apellido }}</td>
                                    <td>{{ $modificacion->motivo_rechazo_desc }}</td>
                                    <td>{{ $modificacion->observacion }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No se han realizado cambios de estado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200" id="guardar_estado">Guardar</button>
</div>

<script type="text/javascript">
    $(function() {
        $('#estados_anteriores').DataTable({
            'stateSave': true,
            "lengthChange": false,
            "responsive": true,
            "paginate": true,
            "autoWidth": true,
            "searching": false,
            "order": [[1,"desc"]],
            "lengthMenu": [[5,10, 25, -1], [5,10, 25, "All"]],
            "language": {
                "url": '{{ url("js/Spain.json") }}'
            }
        });
    });
</script>