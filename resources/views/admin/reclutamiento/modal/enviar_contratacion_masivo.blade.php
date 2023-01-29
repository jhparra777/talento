<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">
        @if(count($candidatos) > 0)
            @if(count($candidatos) > 1)
                <h5><strong>¿Enviar a contratar a estos {{ count($candidatos) }} candidatos?</strong></h5> 
            @else
                <h5><strong>¿Enviar a contratar a este candidato?</strong></h5>
            @endif
            @foreach ($candidatos as $key => $candidato)
                <strong>{{ $candidato->numero_id." ".$candidato->nombres." ".$candidato->primer_apellido }}</strong>,
            @endforeach
        @endif
    </h4>
</div>
<div class="modal-body">
    @if(count($candidatos) > 0)
    <div class="row">
        {!! Form::model(Request::all(),["id" => "fr_contratar_masivo", "data-smk-icon" => "fa fa-times-circle"]) !!}
            {!! Form::hidden("candidato_req", $req_can_id_j, ["id" => "candidato_req_fr"]) !!}
            <h4 style="padding-left: 20px;">Datos de contratación</h4>
            <div class="col-md-12">
                {{-- Fecha ingreso --}}
                <div class="col-md-6 form-group">
                    <label for="fecha_inicio_contrato" class="col-sm-4 control-label">Fecha Ingreso *</label>
                    
                    <div class="col-sm-8">
                        <input
                            type="text"
                            name="fecha_inicio_contrato"
                            class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                            id="fecha_inicio_contrato"
                            required="required"
                        >
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio_contrato",$errors) !!}</p>
                </div>

                {{-- Hora de ingreso --}}
                <div class="col-md-6 form-group">
                    <label for="hora_ingreso" class="col-sm-4 control-label">Hora de ingreso *:</label>

                    <div class="col-sm-8">
                        {!! Form::time("hora_ingreso",'08:00', [
                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                "id" => "time-inicio",
                                "required" => "required"
                        ]); !!}
                    </div>
            
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hora_ingreso", $errors) !!}</p>
                </div>
            </div>
            <div class="col-md-12">
                {{-- Tipo ingreso --}}
                <div class="col-md-6 form-group">
                    <label for="tipo_ingreso" class="col-sm-4 control-label">Tipo Ingreso *:</label>

                    <div class="col-sm-8">
                        <select name="tipo_ingreso" id="tipo_ingreso" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">
                            <option value="1">Nuevo</option>
                            <option value="2">Reingreso</option>
                        </select>
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_ingreso", $errors) !!} </p>
                </div>
                {{-- Fecha fin contrato --}}
                <div class="col-md-6 form-group">
                    <label for="fecha_fin_contrato" class="col-sm-4 control-label">Fecha Fin Contrato:</label>
                    
                    <div class="col-sm-8">
                        <input
                            type="text"
                            name="fecha_fin_contrato"
                            value="{{ $newEndingDate }}"
                            class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                            id="fecha_fin_contrato"
                            required
                        >
                    </div>
                    
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_fin_contrato", $errors) !!}</p>
                </div>
            </div>
            <div class="col-md-12">
                {{-- Axulio transporte Listos y VyM 
                <div class="col-md-6 form-group">
                    <label for="auxilio_transporte" class="col-sm-4 control-label">Auxilio de Transporte:</label>
                    
                    <div class="col-sm-8">
                        <select name="auxilio_transporte" class="form-control">
                            <option value="No se Paga"> No se paga </option>
                            <option value="Total"> Total </option>
                            <option value="Mitad"> Mitad </option>
                        </select>
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("auxilio_transporte", $errors) !!}</p>
                </div>--}}
                {{-- ARL --}}
                <div class="col-md-6 form-group">
                    <label for="arl" class="col-sm-4 control-label">ARL:</label>
                    
                    <div class="col-sm-8">
                        {!! Form::text("arl", 'Colpatria', ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "arl", "readonly" => "readonly"]); !!}
                    </div>
                    
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("arl", $errors) !!}</p>
                </div>
                {{-- Observaciones --}}
                <div class="col-md-6 form-group">
                    <label for="observacion_cont_masivo" class="col-sm-4 control-label">Observaciones *:</label>
                    
                    <div class="col-sm-8">
                        <textarea name="observacion_cont_masivo" id="observacion_cont_masivo" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required="required"></textarea>
                    </div>
                    
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observacion_cont_masivo",$errors) !!}</p>
                </div>
            </div>
            {{--<div class="col-md-12">
                 Observaciones 
                <div class="col-md-6 form-group">
                    <label for="observacion_cont_masivo" class="col-sm-4 control-label">Observaciones *</label>
                    
                    <div class="col-sm-8">
                        <textarea name="observacion_cont_masivo" id="observacion_cont_masivo" class="form-control" rows="2" required="required">
                        </textarea>
                    </div>
                    
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observacion_cont_masivo",$errors) !!}</p>
                </div>
            </div>--}}
        {!! Form::close()!!}
    </div>
    @endif
    @if(count($candi_no_cumplen) > 0)
    <br>
    <div class="row">
        <h4 style="padding-left: 20px;">Estos candidatos no se pueden enviar a contratar:</h4>
        <div class="col-md-12">
            <table id="table_users_no_enviados" class="table table-striped">
                <thead>
                    <th>Documento identidad</th>
                    <th>Nombres y apellido</th>
                    <th>Motivo no se envía a contratar</th>
                </thead>
                <tbody>
                    @foreach ($candi_no_cumplen as $key => $cand)
                        <tr>
                            <td>{{ $cand->numero_id }}</td>
                            <td>{{ $cand->nombres ." ". $cand->primer_apellido }}</td>
                            <td>{{ $cand->observacion_no_cumple }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    <div class="clearfix"></div>
</div>

<div class="modal-footer">    
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
    @if(count($candidatos) > 0)
        <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_contratacion_masiva" >Confirmar</button>
    @endif
</div>

<style type="text/css">
    .confirmacion{background:#C6FFD5;border:1px solid green;}
    .negacion{background:#ffcccc;border:1px solid red}
</style>

<script>
    $(function () {
        $('#table_users_no_enviados').DataTable({
            'stateSave': true,
            "lengthChange": false,
            "responsive": true,
            "paginate": true,
            "autoWidth": true,
            "searching": false,
            "order": [[1,"desc"]],
            "lengthMenu": [[3,10, 25, -1], [3,10, 25, "All"]],
            "language": {
              "url": '{{ url("js/Spain.json") }}'
            }
        });
        var confDatepicker2 = {
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
            yearRange: "1930:2050",
            minDate:new Date()
        };

        $("#fecha_fin_contrato, #fecha_inicio_contrato").datepicker(confDatepicker2);

        jQuery(document).on('change', '#fecha_inicio_contrato', (event) => {
            const element = event.target;
        
            jQuery('#fecha_fin_contrato').datepicker('option', 'minDate', element.value);
        });
    });
</script>