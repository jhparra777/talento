<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<div class="modal-body">
    {!! Form::model(Request::all(),["id"=>"frm_crear_cita"]) !!}

        {!! Form::hidden("req_id",$req_id,["id"=>"req_id"]) !!}
        {!! Form::hidden("user_id",$user_id,["id"=>"user_id"]) !!}
        {!! Form::hidden("candidato_req",$candidato_req,["id"=>"candidato_req"]) !!}
        {!! Form::hidden("cliente_id",null) !!}
       
        <h3>Crear Cita</h3>

        <br>

        <div class="row">
            
            <div class="col-md-12 form-group">
                <label>Fecha Cita</label>

                {!! Form::text ("fecha_cita",null,["class"=>"form-control","id"=>"fecha_cita"]); !!}
            </div>

            <div class="col-md-12 form-group">
                <label>Indicaciones cita (dirección, etc.)</label>

                {!! Form::textarea('observacion_cita',null,['id' => 'observacion_cita', 'class' => 'form-control', 'rows' => 3]) !!}
            </div>

        </div>

    {!! Form::close() !!}

    <h4>Historial de Citas</h4>

    <div class="tabla table-responsive">
        <table class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th>Num Req</th>
                    <th>Fecha Cita</th>
                    <th>Indicaciones</th>
                    <th>Pendiente</th>
                </tr>
            </thead>
            
            <tbody>
                @if($citas->count() == 0)
                    <tr>
                        <td colspan="5">No se encontro historial de citas</td>
                    </tr>
                @endif

                @foreach($citas as $cita)
                    <tr>
                        <td>{{$req_id}}</td>
                        <td>{{$cita->fecha_cita}}</td>
                        <td>{{$cita->observaciones}}</td>
                        @if ($cita->estado == 0)
                            <td class="bg-danger">Si</td>
                        @else
                            <td class="bg-success">No</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_cita_cliente" >Guardar</button>
</div>

<script>
    $(function () {
    
        $('#fecha_cita').daterangepicker({

            "singleDatePicker": true,
            "timePicker": true,
            "minDate": moment(),
            "opens": "left",
            locale: {
                format: 'YYYY/MM/DD hh:mm A',
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "autoApply": true,
                "daysOfWeek": [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mier",
                    "Jue",
                    "Vie",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Augosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ]
            }
        });

    });
</script>
