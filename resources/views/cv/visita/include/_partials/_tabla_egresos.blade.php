<div class="col-sm-12">
    <div class="old">
        <div class="row padre">
            <div class="item">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Egresos</h2>
                    </div>
                    <div class="panel-body" id="panel_egreso">

                        <div class="row col-sm-12 padre_egreso">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Motivo</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr style="text-align: center">
                                        <td>Servicios públicos</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                    {!! Form::text("ing_egr_servicios",
                                                    $candidatos->ing_egr_servicios,
                                                    ["class"=>"form-control solo_numeros monto contable_total_egreso | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "required"=>true]); !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr style="text-align: center">
                                        <td>Alimentación</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                    {!! Form::text("ing_egr_alimentacion",
                                                    $candidatos->ing_egr_alimentacion,
                                                    ["class"=>"form-control solo_numeros monto contable_total_egreso | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "required"=>true]); !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr style="text-align: center">
                                        <td>Jardín</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                    {!! Form::text("ing_egr_jardin",
                                                    $candidatos->ing_egr_jardin,
                                                    ["class"=>"form-control solo_numeros monto contable_total_egreso | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "required"=>true]); !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr style="text-align: center">
                                        <td>Universidad</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                    {!! Form::text("ing_egr_universidad",
                                                    $candidatos->ing_egr_universidad,
                                                    ["class"=>"form-control solo_numeros monto contable_total_egreso | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "required"=>true]); !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr style="text-align: center">
                                        <td>Otros</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                    {!! Form::text("ing_egr_otros",
                                                    $candidatos->ing_egr_otros,
                                                    ["class"=>"form-control solo_numeros monto contable_total_egreso | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "required"=>true,
                                                    "placeholder"=>"Cualquier gasto mensual no contemplado en el listado anterior"]); !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr style="text-align: center">
                                        <td><b>Total Egreso</b></td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$ COP</span>
                                                {!! Form::text("total_egresos",
                                                $candidatos->total_egresos,
                                                ["class"=>"form-control monto total_egresos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "required"=>true,
                                                "id"=>"total_egresos",
                                                "readonly"=>true]); !!}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
            </div>
        </div>           
    </div>
</div>