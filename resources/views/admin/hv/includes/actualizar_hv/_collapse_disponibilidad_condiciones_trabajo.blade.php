<div class="panel panel-default">
    <div class="panel-heading | tri-bg--none" role="tab" id="headingOne">
        <h4 class="panel-title | tri-fw-600">
            <a role="button" data-toggle="collapse" href="#collapseDisponibilidadTrabajo" aria-expanded="true" aria-controls="collapseDisponibilidadTrabajo">
                Disponibilidad para condiciones de trabajo
            </a>

            <a class="pull-right" role="button" data-toggle="collapse" href="#collapseDisponibilidadTrabajo" aria-expanded="true" aria-controls="collapseDisponibilidadTrabajo">
                <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </a>
        </h4>
    </div>

    <div id="collapseDisponibilidadTrabajo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="horario_flexible">Horarios flexibles: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::select("horario_flexible", ['' => "Seleccione", 'Si' => "Si", 'No' => "No"], null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "horario_flexible",
                        "required" => "required"
                    ]) !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo", $errors) !!}</p>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="viajes_regionales">Viajes regionales: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::select("viaje_regional", ['' => "Seleccione", 'Si' => "Si", 'No' => "No"], null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "viajes_regionales",
                        "required" => "required"
                    ]) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="viaje_internacional">Viajes internacionales: <span class='text-danger sm-text-label'>*</span></label>

                    {!!Form::select("viaje_internacional", ['' => "Seleccione",'Si' => "Si",'No' => "No"], null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "viaje_internacional",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("viaje_internacional", $errors) !!}</p>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="cambio_ciudad">Cambio de ciudad : <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::select("cambio_ciudad", ['' => "Seleccione", 'Si' => "Si", 'No' => "No"], null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "cambio_ciudad",
                        "required" => "required"
                    ]) !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cambio_ciudad", $errors) !!}</p>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="cambio_pais">Cambio de país: <span class='text-danger sm-text-label'>*</span></label>

                    {!!Form::select("cambio_pais", ['' => "Seleccione", 'Si' => "Si", 'No' => "No"], null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "cambio_pais",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cambio_pais", $errors) !!}</p>
            </div>
            
            <div class="col-md-12">
                <div class="form-group">
                    <label for="estado_salud">Explique su estado de salud actual o cualquier observacion a ser considerada: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::textarea("estado_salud", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "estado_salud",
                        "rows" => "4",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_salud", $errors) !!}</p>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="conadis">Carnet de conadis: <span class='text-danger sm-text-label'>*</span></label>

                    {!!Form::select("conadis", ['' => "Seleccione", 'Si' => "Si", 'No' => "No"], null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "conadis",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("conadis", $errors) !!}</p>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="grado_disca">Tipo y grado de discapacidad: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::textarea("grado_disca", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "grado_disca",
                        "rows" => "4",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("grado_disca", $errors) !!}</p>
            </div>
        </div>
    </div>
</div>