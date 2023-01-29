<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Ingresos y egresos económicos del núcleo familiar</h3>
    </div>
    <div class="panel-body">
            
        <form id="form-4" data-smk-icon="glyphicon-remove-sign" name="form-1" class="formulario">

            <div class="col-sm-12">
                <div class="old">
                    <div class="row padre">
                        <div class="item">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2>Ingresos</h2>
                                </div>
                                <div class="panel-body" id="panel_ingreso">
                                    @if($ingresos = json_decode($candidatos->ing_egr_familiar))
                                        <?php
                                            $cantidad_ingresos = 1;
                                        ?> 
                                        @foreach($ingresos as $ing)
                                            <div class="row padre_ingreso">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Nombre de quien aporta: <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::text("ing_egr_nombre[]",
                                                        $ing->ing_egr_nombre ,
                                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "id"=>"ing_egr_nombre",
                                                        "required"=>true]); !!}
                                                    </div>
                                                </div>
            
                                                <div class="valida">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Ingreso personal: <span class='text-danger sm-text-label'>*</span></label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                                {!! Form::text("ing_egr_ingreso[]",
                                                                $ing->ing_egr_ingreso,
                                                                ["class"=>"form-control solo_numeros monto contable_total_ingreso validar_mayor | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                "required"=>true]); !!}
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Valor aporte: <span class='text-danger sm-text-label'>*</span></label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                                {!! Form::text("ing_egr_aporte[]",
                                                                $ing->ing_egr_aporte,
                                                                ["class"=>"form-control solo_numeros monto contable_total_aporte_ingreso validar_menor | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                "required"=>true]); !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3 form-group last-child-ingreso">
                                                    <button type="button" class="btn btn-success add-ingreso mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> ingreso</button>
                                                    @if($cantidad_ingresos>1)
                                                        <button type="button" class="btn btn-danger rem-ingreso mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>
                                                    @endif
                                                </div>

                                                <?php
                                                    $cantidad_ingresos++;
                                                ?>

                                            </div>
                                        @endforeach  
                                    @else
                                        <div class="row padre_ingreso">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Nombre de quien aporta: <span class='text-danger sm-text-label'>*</span></label>
                                                    {!! Form::text("ing_egr_nombre[]",
                                                    null,
                                                    ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "id"=>"ing_egr_nombre",
                                                    "required"=>true]); !!}
                                                </div>
                                            </div>
                                            
                                            <div class="valida">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Ingreso personal: <span class='text-danger sm-text-label'>*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                            {!! Form::text("ing_egr_ingreso[]",
                                                            null,
                                                            ["class"=>"form-control solo_numeros monto contable_total_ingreso validar_mayor | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                            "required"=>true]); !!}
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Valor aporte: <span class='text-danger sm-text-label'>*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                            {!! Form::text("ing_egr_aporte[]",
                                                            null,
                                                            ["class"=>"form-control solo_numeros monto contable_total_aporte_ingreso validar_menor | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                            "required"=>true]); !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Boton de agregar ingreso --}}
                                            <div class="col-md-3 form-group last-child-ingreso">
                                                <button type="button" class="btn btn-success add-ingreso mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> ingreso</button>
                                            </div>

                                        </div>
                                    @endif
                                </div>
                                {{-- div de total ingreso --}}
                                <div class="col-sm-12" style="margin-top: 10px">
                                    <div class="col-md-3" style="float: right;">
                                        <div class="form-group">
                                            <label>Total Ingreso: <span class='text-danger sm-text-label'></span></label>
                                            <div class="input-group" style="display: none">
                                                {!! Form::text("ing_egr_aportes_total",
                                                $candidatos->ing_egr_aportes_total,
                                                ["class"=>"form-control monto total_aporte_ingresos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "required"=>true,
                                                "id"=>"ing_egr_aportes_total",
                                                "readonly"=>true]); !!}
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$ COP</span>
                                                {!! Form::text("total_ingresos",
                                                $candidatos->total_ingresos,
                                                ["class"=>"form-control monto total_ingresos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "required"=>true,
                                                "id"=>"total_ingresos",
                                                "readonly"=>true]); !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>           
                </div>
            </div>

            {{-- Maquetado de egresos --}}
            @include("cv.visita.include._partials._tabla_egresos")

            {{-- Maquetado de información crediticia --}}
            @include("cv.visita.include._partials._informacion_crediticia")            

            {{-- @if($current_user->inRole("admin"))
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Concepto(Evaluador): <span class='text-danger sm-text-label'>*</span></label>
                        {!! Form::textarea("ing_egr_concepto",
                        $candidatos->ing_egr_concepto,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "maxlength"=>"550",
                        'rows' => 3,
                        "required"=>true,
                        "placeholder"=>""]); !!}
                    </div>
                </div>
            @endif --}}
        </form>
    </div>
</div>

{{-- JS ingresos_egresos --}}
@include("cv.visita.include._js_ingresos_egresos")