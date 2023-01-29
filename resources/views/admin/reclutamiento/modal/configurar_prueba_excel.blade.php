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
        <h4 class="modal-title">Configurar Prueba Excel para el Requerimiento # {{ $req_id }}</h4>
    @else
        <h4 class="modal-title">Configurar Prueba Excel para el Cargo <b>{{ $configuracion->descripcion }}</b></h4>
    @endif
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_config_excel"]) !!}
        @if (!empty($req_id))
            {!! Form::hidden('req_id',$req_id) !!}
        @else
            {!! Form::hidden('cargo_id',$cargo_id) !!}
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">

                    <div id="accordion-excel">
                        @if($sitio->prueba_excel_basico)
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <a data-toggle="collapse" data-target="#collapseExcelBasico" aria-expanded="true" aria-controls="collapseExcelBasico" style="cursor: pointer;">
                                            Prueba Excel Básica
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapseExcelBasico" class="collapse in" aria-labelledby="headingUnoExcel" data-parent="#accordion-excel">
                                    <div class="panel-body py-0">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox("excel_basico", 1, $configuracion->excel_basico, ["id" => "excel_basico"]) !!} Incluir prueba excel básica 
                                            </label>
                                        </div>
                                        <div class="col-md-12 porcentaje-excel-basico" style="{{ ($configuracion->excel_basico ? '' : 'display: none;') }}">
                                            <div class="col-md-7 form-group">
                                                <label for="aprobacion_excel_basico" class="control-label">Calificación de aprobación (%)<span>*</span></label>
                                                
                                                {!! Form::number("aprobacion_excel_basico", $configuracion->aprobacion_excel_basico,["class" => "form-control", "placeholder" => "", "id" => "aprobacion_excel_basico"]) !!}
                                                <span class="error-smg-valor" id="error-excel-basico">El numero debe ser mayor a 10 y menor a 101</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 porcentaje-excel-basico" style="{{ ($configuracion->excel_basico ? '' : 'display: none;') }}">
                                            <div class="col-md-7 form-group">
                                                <label for="tiempo_excel_basico" class="control-label">Tiempo máximo para responder (10minutos - 45 minutos)<span>*</span></label>
                                                
                                                {!! Form::number("tiempo_excel_basico", ($configuracion->tiempo_excel_basico != null ? $configuracion->tiempo_excel_basico : 20),["class" => "form-control", "placeholder" => "", "id" => "tiempo_excel_basico"]) !!}
                                                <span class="error-smg-valor" id="error-tiempo-excel-basico">El numero debe ser mayor a 9 y menor a 46</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($sitio->prueba_excel_intermedio)
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <a data-toggle="collapse" data-target="#collapseExcelIntermedio" aria-expanded="true" aria-controls="collapseExcelIntermedio" style="cursor: pointer;">
                                            Prueba Excel Intermedio
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapseExcelIntermedio" class="collapse in" aria-labelledby="headingDosExcel" data-parent="#accordion-excel">
                                    <div class="panel-body py-0">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox("excel_intermedio", 1, $configuracion->excel_intermedio, ["id" => "excel_intermedio"]) !!} Incluir prueba excel intermedia 
                                            </label>
                                        </div>
                                        <div class="col-md-12 porcentaje-excel-intermedio" style="{{ ($configuracion->excel_intermedio ? '' : 'display: none;') }}">
                                            <div class="col-md-7 form-group">
                                                <label for="aprobacion_excel_intermedio" class="control-label">Calificación de aprobación (%)<span>*</span></label>
                                                
                                                {!! Form::number("aprobacion_excel_intermedio", $configuracion->aprobacion_excel_intermedio, ["class" => "form-control", "placeholder" => "", "id" => "aprobacion_excel_intermedio"]) !!}
                                                <span class="error-smg-valor" id="error-excel-intermedio">El numero debe ser mayor a 10 y menor a 101</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 porcentaje-excel-intermedio" style="{{ ($configuracion->excel_intermedio ? '' : 'display: none;') }}">
                                            <div class="col-md-7 form-group">
                                                <label for="tiempo_excel_intermedio" class="control-label">Tiempo máximo para responder (10minutos - 45 minutos)<span>*</span></label>
                                                
                                                {!! Form::number("tiempo_excel_intermedio", ($configuracion->tiempo_excel_intermedio != null ? $configuracion->tiempo_excel_intermedio : 20),["class" => "form-control", "placeholder" => "", "id" => "tiempo_excel_intermedio"]) !!}
                                                <span class="error-smg-valor" id="error-tiempo-excel-intermedio">El numero debe ser mayor a 9 y menor a 46</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    {!! Form::close() !!}

    <div class="clearfix"></div> 
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" id="guardar_configuracion_excel">Guardar configuración</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>

<script type="text/javascript">
    $("#excel_basico").on("change", function () {
        var obj = $(this);
        if (obj.prop("checked")) {
            $(".porcentaje-excel-basico").show();
            $("#aprobacion_excel_basico").prop('required', 'required');
            $("#tiempo_excel_basico").prop('required', 'required');
        } else {
            $(".porcentaje-excel-basico").hide();
            $("#aprobacion_excel_basico").removeAttr('required');
            $("#tiempo_excel_basico").removeAttr('required');
        }
    });

    $("#excel_intermedio").on("change", function () {
        var obj = $(this);
        if (obj.prop("checked")) {
            $(".porcentaje-excel-intermedio").show();
            $("#aprobacion_excel_intermedio").prop('required', 'required');
            $("#tiempo_excel_intermedio").prop('required', 'required');
        } else {
            $(".porcentaje-excel-intermedio").hide();
            $("#aprobacion_excel_intermedio").removeAttr('required');
            $("#tiempo_excel_intermedio").removeAttr('required');
        }
    });

    $(function () {
        $('#guardar_configuracion_excel').click(function() {
            $("#error-excel-basico").hide();
            $("#error-excel-intermedio").hide();
            $("#error-tiempo-excel-basico").hide();
            $("#error-tiempo-excel-intermedio").hide();
            //if($('#fr_config_excel').smkValidate()) {
                let sin_error = true;
                if($("#excel_basico").prop("checked") && ($("#aprobacion_excel_basico").val() < 10 || $("#aprobacion_excel_basico").val() > 100) ) {
                    $("#error-excel-basico").show();
                    sin_error = false;
                }
                if($("#excel_intermedio").prop("checked") && ($("#aprobacion_excel_intermedio").val() < 10 || $("#aprobacion_excel_intermedio").val() > 100)) {
                    $("#error-excel-intermedio").show();
                    sin_error = false;
                }
                if($("#excel_basico").prop("checked") && ($("#tiempo_excel_basico").val() < 10 || $("#tiempo_excel_basico").val() > 45) ) {
                    $("#error-tiempo-excel-basico").show();
                    sin_error = false;
                }
                if($("#excel_intermedio").prop("checked") && ($("#tiempo_excel_intermedio").val() < 10 || $("#tiempo_excel_intermedio").val() > 45)) {
                    $("#error-tiempo-excel-intermedio").show();
                    sin_error = false;
                }
                if (!sin_error) {
                    return sin_error;
                }
                $('#guardar_configuracion_excel').prop('disabled', 'disabled');

                if($("#excel_basico").prop("checked") || $("#excel_intermedio").prop("checked")) {
                    $.ajax({
                        type: "POST",
                        data: $("#fr_config_excel").serialize(),
                        url: "{{ route('admin.guardar_configuracion_excel') }}",
                        beforeSend: function(){
                            $.smkAlert({text: 'Espere mientras se guarda la información.', type: 'info'});
                        },
                        error: function(){
                            $("#modal_gr").modal("hide");
                            $.smkAlert({text: 'Ha ocurrido un error. Verifique los datos.', type: 'danger'});
                        },
                        success: function(response){
                            if(response.success) {
                                $.smkAlert({text: 'Se ha guardado la configuración correctamente.', type: 'success'});

                                setTimeout(function(){ $("#modal_gr").modal("hide"); }, 800);
                            }
                        }
                    });
                } else {
                    $.smkAlert({text: 'No seleccionó ninguna prueba, por lo que no se guardó ninguna configuración.', type: 'info'});
                }
            //}
        });
    })
</script>