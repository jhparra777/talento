<div class="panel panel-default">
    <div class="panel-heading | tri-bg--none" role="tab" id="headingOne">
        <h4 class="panel-title | tri-fw-600">
            <a role="button" data-toggle="collapse" href="#collapseAspiracionSalarial" aria-expanded="true" aria-controls="collapseAspiracionSalarial">
                Aspiración salarial y de beneficios
            </a>

            <a class="pull-right" role="button" data-toggle="collapse" href="#collapseAspiracionSalarial" aria-expanded="true" aria-controls="collapseAspiracionSalarial">
                <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </a>
        </h4>
    </div>

    <div id="collapseAspiracionSalarial" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sueldo_bruto">Sueldo fijo bruto: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::text("sueldo_bruto", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "sueldo_bruto",
                        "required" => "required"
                    ]) !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("sueldo_bruto", $errors) !!}</p>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="comision_bonos">Ingreso variable mensual (comisiones/bonos): <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::text("comision_bonos", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "comision_bonos",
                        "placeholder" => "",
                        "maxlength" => "5000",
                        "required" => "required"
                    ]) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="otros_bonos">Otros bonos (montos y periodicidad) : <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::text("otros_bonos", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "otros_bonos",
                        "placeholder" => "",
                        "maxlength"=>"5000",
                        "required" => "required"
                    ]) !!}
                </div>

                <p class="error text-danger direction-botones-center">{!!FuncionesGlobales::getErrorData("otros_bonos", $errors) !!}</p>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="ingreso_anual">Total ingreso anual: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::text("ingreso_anual", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "ingreso_anual",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!!FuncionesGlobales::getErrorData("ingreso_anual", $errors) !!}</p>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="ingreso_mensual">Total ingreso mensual: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::text("ingreso_mensual", null, [
                        "class" => "form-control input-number | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "ingreso_mensual",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!!FuncionesGlobales::getErrorData("ingreso_mensual", $errors) !!}</p>
            </div>
                
            <div class="col-md-6">
                <div class="form-group">
                    <label for="otros_beneficios">Otros beneficios : <span class='text-danger sm-text-label'>*</span></label>

                    {!!Form::text("otros_beneficios", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "otros_beneficios",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("otros_beneficios", $errors) !!}</p>
            </div>
        </div>
    </div>
</div>