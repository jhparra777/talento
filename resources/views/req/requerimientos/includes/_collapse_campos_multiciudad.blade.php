<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="inputEmail3" class="control-label">¿Requerimiento Multiciudad?</label>

            <select name="select_multi_reque" id="select_multi_reque" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" required="required">
                <option value="">Seleccionar</option>
                <option value="1">Si</option>
                <option value="0" selected>No</option>
            </select>
        </div>
    </div>
</div>

<div class="row" id="container_multiciudad">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading | tri-bg--none" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" href="#collapseMulticiudad" aria-expanded="true" aria-controls="collapseMulticiudad">
                        CAMPOS MULTICIUDAD
                    </a>

                    <a class="pull-right" role="button" data-toggle="collapse" href="#collapseMulticiudad" aria-expanded="true" aria-controls="collapseMulticiudad">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                </h4>
            </div>

            <div id="collapseMulticiudad" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body" id="multiciudad_req">
                    <div class="row campos-multiciudad">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ciudad Trabajo: <span class='text-danger sm-text-label'>*</span></label> <br>
                                {!! Form::select('ciudad_trabajo_multi[]', $ciudadesSelect, null, ['id'=>'ciudad_trabajo_multi','class'=>'form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300', 'required']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Salario: <span class='text-danger sm-text-label'>*</span></label>

                                <input type="number" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" placeholder="SALARIO" name="salario_multi[]" id="salario_multi" required="required">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Número Vacantes: <span class='text-danger sm-text-label'>*</span></label>

                                <input type="number" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" placeholder="VACANTES" name="num_vacantes_multi[]" id="num_vacantes_multi" required="required">
                            </div>
                        </div>

                        <div class="col-md-2 last-child">
                                <button type="button" class="btn btn-success add-reque mt-2 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>