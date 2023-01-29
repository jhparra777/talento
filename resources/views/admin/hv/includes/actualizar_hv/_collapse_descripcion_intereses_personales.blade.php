<div class="panel panel-default">
    <div class="panel-heading | tri-bg--none" role="tab" id="headingOne">
        <h4 class="panel-title | tri-fw-600">
            <a role="button" data-toggle="collapse" href="#collapseDescripcionInteresesPersonales" aria-expanded="true" aria-controls="collapseDescripcionInteresesPersonales">
                Descripción de sus intereses personales
            </a>

            <a class="pull-right" role="button" data-toggle="collapse" href="#collapseDescripcionInteresesPersonales" aria-expanded="true" aria-controls="collapseDescripcionInteresesPersonales">
                <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </a>
        </h4>
    </div>

    <div id="collapseDescripcionInteresesPersonales" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="motivo_cambio">¿Qué lo motiva para un cambio?: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::textarea("motivo_cambio", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "motivo_cambio",
                        "rows" => "4",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_cambio", $errors) !!}</p>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="areas_interes">Áreas de mayor interés en ámbito laboral: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::textarea("areas_interes", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "areas_interes",
                        "rows" => "4",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("areas_interes", $errors) !!}</p>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="ambiente_laboral">¿Qué valora en un ambiente laboral?: <span class='text-danger sm-text-label'>*</span></label>
                   
                    {!! Form::textarea("ambiente_laboral", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "ambiente_laboral",
                        "rows" => "4",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ambiente_laboral", $errors) !!}</p>
            </div>

            <div class="col-sm-12 col-lg-12">
                <div class="form-group">
                    <label for="genero"> Total ingreso anual / Total ingreso mensual: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::textarea("areas_interes", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "areas_interes",
                        "rows" => "4",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("areas_interes", $errors) !!}</p>
            </div>

            <div class="col-sm-12 col-lg-12">
                <div class="form-group">
                    <label for="hobbies">Actividades de interés en su tiempo libre (hobbies): <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::textarea("hobbies", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "hobbies",
                        "rows" => "4",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hobbies", $errors) !!}</p>
            </div>

            <div class="col-sm-12 col-lg-12">
                <div class="form-group">
                    <label for="membresias">Membresías colegios profesionales, asociaciones, clubes, etc: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::textarea("membresias", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "membresias",
                        "rows" => "4",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("membresias", $errors) !!}</p>
            </div>
        </div>
    </div>
</div>