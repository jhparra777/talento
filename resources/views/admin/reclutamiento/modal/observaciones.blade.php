<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4>Observaciones del requerimiento</h4>
</div>

<div class="modal-body modd">
    <div class="row">
        {!! Form::model(Request::all(), ["id" => "fr_observaciones_gestion"]) !!}
            {!! Form::hidden("req_id",$req->id) !!}
            {!! Form::hidden("modulo",$modulo) !!}

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="control-label">Tipo observación:</label>
                {!! Form::select('tipo_observacion_id', $tipo_observaciones,null, ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
                tri-transition-300", "required" => "required"]) !!}
            </div>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="control-label">Nueva observación:</label>
                
                {!! Form::textarea('observacion', null, ['class' => 'form-control | tri-br-1 tri-fs-12 tri-input--focus
                tri-transition-300','rows' => 3 , "required" => "required"]) !!}

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observacion", $errors) !!}</p>
            </div>

            <div class="col-md-12 text-right mb-2">
                <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-green" id="guardar_observaciones_gestion">Guardar</button>
            </div>
        {!! Form::close() !!}
        
        

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="text-center">Lista de observaciones</h4>
                    <div class="tabla table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">N°</th>
                                    <th class="text-center">Tipo observación</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Fecha</th>
                                </tr>
                            </thead>
                            
                            <tbody>                
                                @forelse($req->observaciones_gestion as $key => $observaciones)
                                    <tr>
                                        <td class="text-center">{{ ++$key }}</td>
                                        <td class="text-center">{{ isset($observaciones->tipo_observacion) ? $observaciones->tipo_observacion->descripcion : "" }}</td>
                                        <td class="text-center">{{ $observaciones->observacion }}</td>
                                        <td class="text-center">{{ $observaciones->user->name }}</td>
                                        <td class="text-center">{{ $observaciones->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="5">No se encontraron registros</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal">Cerrar</button>
</div>

<style>
    .modd{ overflow-y: auto; }
</style>

<script>
    $(function () {
        var confDatepicker = {
            altFormat: "yy-mm-dd",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            buttonImage: "img/gifs/018.gif",
            buttonImageOnly: true,
            autoSize: true,
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            yearRange: "1930:2050"
        };

        $("#fecha_fin_contrato, #fecha_inicio_contrato").datepicker(confDatepicker);

        // $('#guardar_observaciones_gestion').click(function() {
        //     if ($('#fr_observaciones_gestion').smkValidate()) {
        //         $("#guardar_observaciones_gestion").submit();
        //     }
        // });
    });
</script>