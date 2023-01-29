<div class="col-md-12">
    <div class="old">
        <div class="row padre">
            <div class="item">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Información crediticia del evaluado</h3>
                    </div>
                    <div class="panel-body">

                        {{-- seccion reporte centrales --}}
                        <div class="panel panel-default">
                            <div class="panel-heading col-sm-12">
                                <label class=" " for="inputEmail3">
                                    ¿Está reportado en centrales de riesgo? <span></span> 
                                </label>
                                <div class="">
                                    <label class="">
                                        {!! Form::checkbox("tiene_reportes_centrales_",
                                        1,
                                        ($candidatos->reportes_central!=null)?1:0,
                                        ["class"=>"inputc",
                                        "id"=>"tiene_reportes_centrales_"]) !!}
                                        {{-- <div class="tri-toggle__fill"></div> --}}
                                    </label>
                                    {{-- <input type="checkbox" class="input"> --}}
                                </div>
                                
                            </div>
                            <div class="panel-body">
                                <div id="section-reportes" class="box box-info collapsed-box col-sm-12">
                                    <div class="chart">
                                        <div class="" id="reportes-centrales">
                                            @if($reportes=json_decode($candidatos->reportes_central))
                                                <?php
                                                    $cantidad_riesgos = 1;
                                                ?>
                                                @foreach($reportes as $re)
                                                    <div class="row">
                
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Entidad: <span class='text-danger sm-text-label'>*</span></label>
                                                                {!! Form::select("banco_central[]",
                                                                $bancos,
                                                                $re->banco,
                                                                ["class"=>"form-control reportes | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                "required"=>true]); !!}
                                                            </div>
                                                        </div>
                    
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>¿Hace cuanto está reportado?: <span class='text-danger sm-text-label'>*</span></label>                           
                                                                {!! Form::text("hace_cuanto_reportado[]",
                                                                $re->hace_cuanto_reportado,
                                                                ["class" => "form-control reportes | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                "required"=>true]); !!}
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>¿Cuál es el valor reportado? <span class='text-danger sm-text-label'>*</span></label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                                    {!! Form::text("valor_reportado[]",
                                                                    $re->valor_reportado,
                                                                    ["class"=>"form-control solo_numeros monto reportes | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "required"=>true,
                                                                    "placeholder"=>"reportes centrales a tu nombre"]); !!}
                                                                </div>
                                                            </div>
                                                        </div>                                                    
                
                                                        {{-- Boton de agregar riesgo --}}
                                                        <div class="col-md-3 form-group last-child-riesgo">
                                                            <button type="button" class="btn btn-success add-reporte mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Reporte</button>
                                                            @if($cantidad_riesgos > 1)
                                                                <button type="button" class="btn btn-danger rem-reporte mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>
                                                            @endif
                                                        </div>
                                                        <?php
                                                            $cantidad_riesgos ++;
                                                        ?>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Entidad: <span class='text-danger sm-text-label'>*</span></label>
                                                            {!! Form::select("banco_central[]",
                                                            $bancos,
                                                            null,
                                                            ["class"=>"form-control reportes | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",]); !!}
                                                        </div>
                                                    </div>
                
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>¿Hace cuanto está reportado?: <span class='text-danger sm-text-label'>*</span></label>                           
                                                            {!! Form::text("hace_cuanto_reportado[]",
                                                            null,
                                                            ["class" => "form-control reportes | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"]); !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>¿Cuál es el valor reportado? <span class='text-danger sm-text-label'>*</span></label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                                {!! Form::text("valor_reportado[]",
                                                                    null,
                                                                    ["class"=>"form-control solo_numeros monto reportes | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "placeholder"=>"reportes centrales a tu nombre"]); !!}
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    {{-- Boton de agregar riesgo --}}
                                                    <div class="col-md-3 form-group last-child-riesgo">
                                                        <button type="button" class="btn btn-success add-reporte mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Reporte</button>
                                                    </div>
        
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- seccion creditos --}}
                        <div class="panel panel-default">
                            <div class="panel-heading col-sm-12">
                                <label class="" for="inputEmail3">
                                    ¿Tiene algún crédito a su nombre? <span></span> 
                                </label>
                                <div class="">
                                    <label class="">
                                        {!! Form::checkbox("tiene_creditos_bancarios_",
                                        1,
                                        ($candidatos->creditos_bancarios!=null)?1:0,
                                        ["class"=>"inputc",
                                        "id"=>"tiene_creditos_bancarios_"]) !!}
                                        {{-- <div class="tri-toggle__fill"></div> --}}
                                    </label>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="section-creditos" class="box box-info collapsed-box col-sm-12">
                                    <div class="chart">
                                        <div class="" id="creditos-bancarios">
                                            @if($creditos=json_decode($candidatos->creditos_bancarios))
                                                <?php
                                                    $cantidad_creditos = 1;
                                                ?>
                                                @foreach($creditos as $cre)
                                                    <div class="row">
                
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Entidad: <span class='text-danger sm-text-label'>*</span></label>
                                                                {!! Form::select("banco_credito[]",
                                                                $bancos,
                                                                $cre->banco,
                                                                ["class"=>"form-control creditos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                "required"=>true]); !!}
                                                            </div>
                                                        </div>
                    
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>¿Hace cuánto tiene el crédito?: <span class='text-danger sm-text-label'>*</span></label>                           
                                                                {!! Form::text("hace_cuanto_reportado_credito[]",
                                                                $cre->hace_cuanto_reportado_credito,
                                                                ["class" => "form-control creditos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                "required"=>true]); !!}
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>¿Cuál es el valor adeudado? <span class='text-danger sm-text-label'>*</span></label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                                    {!! Form::text("valor_reportado_credito[]",
                                                                        $cre->valor_reportado_credito,
                                                                        ["class"=>"form-control solo_numeros monto creditos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                        "required"=>true,
                                                                        "placeholder"=>"créditos a tu nombre"]); !!}
                                                                </div>
                                                            </div>
                                                        </div>                                                    
                
                                                        {{-- Boton de agregar credito --}}
                                                        <div class="col-md-3 form-group last-child-credito">
                                                            <button type="button" class="btn btn-success add-credito mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Credito</button>
                                                            @if($cantidad_creditos > 1)
                                                                <button type="button" class="btn btn-danger rem-credito mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>
                                                            @endif
                                                        </div>
                                                        <?php
                                                            $cantidad_creditos ++;
                                                        ?>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Entidad: <span class='text-danger sm-text-label'>*</span></label>
                                                            {!! Form::select("banco_credito[]",
                                                            $bancos,
                                                            null,
                                                            ["class"=>"form-control creditos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",]); !!}
                                                        </div>
                                                    </div>
                
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>¿Hace cuánto tiene el crédito?: <span class='text-danger sm-text-label'>*</span></label>                           
                                                            {!! Form::text("hace_cuanto_reportado_credito[]",
                                                            null,
                                                            ["class" => "form-control creditos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"]); !!}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>¿Cuál es el valor adeudado? <span class='text-danger sm-text-label'>*</span></label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                                {!! Form::text("valor_reportado_credito[]",
                                                                null,
                                                                ["class"=>"form-control solo_numeros monto creditos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                "placeholder"=>"créditos a tu nombre"]); !!}
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    {{-- Boton de agregar credito --}}
                                                    <div class="col-md-3 form-group last-child-credito">
                                                        <button type="button" class="btn btn-success add-credito mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Credito</button>
                                                    </div>
        
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>