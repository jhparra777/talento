<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><b>Crear observación</b></h4>
</div>

<div class="modal-body modd">
    <div class="row">
        {!! Form::model(Request::all(), ["id" => "fr_observacion_req"]) !!}
            {!! Form::hidden("candidato_req", $candidato_req, ["id" => "candidato_req_fr"]) !!}
            {!! Form::hidden("cliente_id", null) !!}

            <div class="col-md-12 form-group">
                <label class="control-label">Observación:</label>
                {!! Form::textarea('observacion', null, ['class'=>'form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300', 'rows' => 3]) !!}

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observacion", $errors) !!}</p>
            </div>
        {!! Form::close() !!}

        <div class="col-md-12 text-center">
            <h4>Observaciones</h4>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tabla table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">N°</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Usuario gestionó</th>
                                    <th class="text-center">Fecha Creación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($observacion as $key =>  $observaciones)
                                    <tr>
                                        <td class="text-center">{{++$key}}</td>
                                        <td class="text-center">{{$observaciones->observacion}}</td>
                                        <td class="text-center">{{$observaciones->nombre}}</td>
                                        <td class="text-center">{{$observaciones->created_at}}</td>            
                                        {{--<td>{{$observaciones->UltimaVista()}}</td>--}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="4">No se encontraron registros</td>
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
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="guardar_observacion">Guardar</button>
</div>

<style>
    .modd{
        overflow-y: auto;
    }
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
    });
</script>
