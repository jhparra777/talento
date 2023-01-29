<div class="panel panel-default">
    <div class="panel-heading | tri-bg--none" role="tab" id="headingOne">
        <h4 class="panel-title | tri-fw-600">
            <a role="button" data-toggle="collapse" href="#collapseDescripcionPerfilProfesional" aria-expanded="true" aria-controls="collapseDescripcionPerfilProfesional">
                Descripción de su perfil profesional
            </a>

            <a class="pull-right" role="button" data-toggle="collapse" href="#collapseDescripcionPerfilProfesional" aria-expanded="true" aria-controls="collapseDescripcionPerfilProfesional">
                <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </a>
        </h4>
    </div>

    <div id="collapseDescripcionPerfilProfesional" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefono_fijo">Años de experiencia en el cargo de aplicación: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::number("tiempo_experiencia", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "tiempo_experiencia",
                        "required" => "required"
                    ]) !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tiempo_experiencia", $errors) !!}</p>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="conoc_tecnico">Conocimientos técnicos de mayor dominio: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::text("conoc_tecnico", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "conoc_tecnico",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("conoc_tecnico", $errors) !!}</p>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="herr_tecnologicas">Herramientas tecnológicas manejadas: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::text("herr_tecnologicas", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "herr_tecnologicas",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("herr_tecnologicas", $errors) !!}</p>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="fortalezas_cargo">Principales fortalezas que considera tener para el cargo: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::text("fortalezas_cargo", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "fortalezas_cargo",
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fortalezas_cargo", $errors) !!}</p>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="areas_reforzar">Áreas a reforzar para un mayor dominio del cargo: <span class='text-danger sm-text-label'>*</span></label>

                    {!! Form::text("areas_reforzar", null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                        "id" => "areas_reforzar", 
                        "maxlength" => "5000",
                        "required" => "required"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("areas_reforzar", $errors)!!} </p>
            </div>
        </div>
    </div>
</div>