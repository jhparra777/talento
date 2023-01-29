<div class="panel panel-default">
    <div class="panel-heading | tri-bg--none" role="tab" id="headingOne">
        <h4 class="panel-title | tri-fw-600">
            <a role="button" data-toggle="collapse" href="#collapseDescripcionObjetivos" aria-expanded="true" aria-controls="collapseDescripcionObjetivos">
                Descripción de sus objetivos
            </a>

            <a class="pull-right" role="button" data-toggle="collapse" href="#collapseDescripcionObjetivos" aria-expanded="true" aria-controls="collapseDescripcionObjetivos">
                <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </a>
        </h4>
    </div>

    <div id="collapseDescripcionObjetivos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="obj_personales">Personales: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::textarea("obj_personales", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "obj_personales",
                        "rows" => "4",
                        "placeholder" => "Objetivos Personales",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("obj_personales", $errors) !!}</p>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="obj_profesionales">Profesionales: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::textarea("obj_profesionales", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "obj_profesionales",
                        "rows" => "4",
                        "placeholder" => "Objetivos Profesionales",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="obj_academicos">Académicos: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::textarea("obj_academicos", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "obj_academicos",
                        "rows" => "4",
                        "placeholder" => "Objetivos académicos",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("obj_academicos", $errors) !!}</p>
            </div>
        </div>
    </div>
</div>