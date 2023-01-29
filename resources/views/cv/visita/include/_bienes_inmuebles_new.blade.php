<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Bienes inmuebles y vehículos del evaluado</h3>
    </div>
    <div class="panel-body">            
        <form id="form-5" data-smk-icon="glyphicon-remove-sign" name="form-1" class="formulario">
            <div class="col-md-12">
                <div class="old">
                    <div class="row padre">
                        <div class="item">
                            {{-- seccion inmuebles --}}

                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Posee bienes inmuebles? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_bienes_inmuebles_",
                                            1,
                                            ($candidatos->inmuebles!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_bienes_inmuebles_"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div id="section-inmuebles" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="inmuebles">
                                                @if($inmuebles=json_decode($candidatos->inmuebles))
                                                    <?php
                                                        $cantidad_inmuebles = 1;
                                                    ?>
                                                    @foreach($inmuebles as $in)
                                                        <div class="row">
                    
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Tipo: <span class='text-danger sm-text-label'>*</span></label>
                                                                    {!! Form::select("tipo_inmueble[]",
                                                                    $tipos_inmuebles,
                                                                    $in->tipo_inmueble,
                                                                    ["class"=>"form-control inmuebles | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "required"=>true]); !!}
                                                                </div>
                                                            </div>
                        
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Dirección: <span class='text-danger sm-text-label'>*</span></label>                           
                                                                    {!! Form::text("direccion_inmueble[]",
                                                                    $in->direccion_inmueble,
                                                                    ["class" => "form-control inmuebles | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "required"=>true]); !!}
                                                                </div>
                                                            </div>
                                                            {{-- {{ dd($in->ciudad_inmueble) }} --}}
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Ciudad <span class='text-danger sm-text-label'>*</span></label>
                                                                    {{-- {!! Form::hidden("pais[]",$in->pais,["class"=>"form-control","id"=>"pais"]) !!}
                                                                    {!! Form::hidden("departamento[]",$in->departamento,["class"=>"form-control","id"=>"departamento"]) !!}
                                                                    {!! Form::hidden("ciudad[]",$in->ciudad,["class"=>"form-control","id"=>"ciudad"]) !!} --}}

                                                                    {{-- {!! Form::text("ciudad_inmueble[]",
                                                                    $txt_ciudad_nac,
                                                                    ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "id"=>"ciudad_inmueble[]",
                                                                    "placheholder"=>"Digita Cuidad",
                                                                    "required"=>true]) !!} --}}
                                                                    {!! Form::select("ciudad_inmueble[]",
                                                                    $ciudades_general,
                                                                    $in->ciudad_inmueble,
                                                                    ["class"=>"form-control js-select2 inmuebles | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "placeholder"=>"",
                                                                    "id"=>"ciudad_inmueble[]",
                                                                    "required"=>true]) !!}
                                                                </div>
                                                            </div>
                
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Precio <span class='text-danger sm-text-label'>*</span></label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                                        {!! Form::text("valor_inmueble_bienes[]",
                                                                        $in->valor_inmueble_bienes,
                                                                        ["class"=>"form-control solo_numeros monto inmuebles | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                        "required"=>true,
                                                                        "placeholder"=>"inmuebles a tu nombre"]); !!}
                                                                    </div>
                                                                </div>
                                                            </div>                                                   
                    
                                                            {{-- Boton de agregar inmueble --}}
                                                            <div class="col-md-3 form-group last-child-inmueble">
                                                                <button type="button" class="btn btn-success add-inmueble mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Inmueble</button>
                                                                @if($cantidad_inmuebles > 1)
                                                                    <button type="button" class="btn btn-danger rem-inmueble mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>
                                                                @endif
                                                            </div>
                                                            <?php
                                                                $cantidad_inmuebles ++;
                                                            ?>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="row" id="inmueble_ind">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Tipo: <span class='text-danger sm-text-label'>*</span></label>
                                                                {!! Form::select("tipo_inmueble[]",
                                                                $tipos_inmuebles,
                                                                null,
                                                                ["class"=>"form-control inmuebles | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                ]); !!}
                                                            </div>
                                                        </div>
                    
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Dirección: <span class='text-danger sm-text-label'>*</span></label>                           
                                                                {!! Form::text("direccion_inmueble[]",
                                                                null,
                                                                ["class" => "form-control inmuebles | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                ]); !!}
                                                            </div>
                                                        </div>
        
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Ciudad <span class='text-danger sm-text-label'>*</span></label>
                                                                {{-- {!! Form::hidden("pais_inmueble[]",null,["class"=>"form-control pais_inmueble","id"=>"pais"]) !!}
                                                                {!! Form::hidden("departamento_inmueble[]",null,["class"=>"form-control departamento_inmueble","id"=>"departamento"]) !!}
                                                                {!! Form::hidden("ciudadinmueble[]",null,["class"=>"form-control ciudad_inmueble","id"=>"ciudad"]) !!}

                                                                {!! Form::text("ciudad_inmueble[]",
                                                                null,
                                                                ["class"=>"form-control ciudades_inmueble | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                "id"=>"ciudad_inmueble[]",
                                                                "placheholder"=>"Digita Cuidad",
                                                                "required"=>true]) !!} --}}
                                                                {!! Form::select("ciudad_inmueble[]",
                                                                $ciudades_general,
                                                                null,
                                                                ["class"=>"form-control js-select2 inmuebles | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                "placeholder"=>"",
                                                                "id"=>"ciudad_inmueble[]",
                                                                ]) !!}
                                                        
                                                            </div>
                                                        </div>
            
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Precio <span class='text-danger sm-text-label'>*</span></label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                                    {!! Form::text("valor_inmueble_bienes[]",
                                                                    null,
                                                                    ["class"=>"form-control solo_numeros monto inmuebles | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "placeholder"=>"inmuebles a tu nombre"]); !!}
                                                                </div>
                                                            </div>
                                                        </div>
            
                                                        {{-- Boton de agregar riesgo --}}
                                                        <div class="col-md-3 form-group last-child-inmueble">
                                                            <button type="button" class="btn btn-success add-inmueble mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Inmueble</button>
                                                        </div>
            
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Observaciones: <span class='text-danger sm-text-label'></span></label>
                                            {!! Form::textarea("inm_observaciones",
                                            $candidatos->inm_observaciones,
                                            ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "maxlength"=>"550",
                                            'rows' => 3,
                                            "placeholder"=>""]); !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- seccion vehiculos --}}
                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Posee vehículos? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_vehiculos_",
                                            1,
                                            ($candidatos->vehiculos!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_vehiculos_"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div> 
                                </div>

                                <div class="panel-body">
                                    <div id="section-vehiculos" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="vehiculos">
                                                @if($vehiculos=json_decode($candidatos->vehiculos))
                                                    <?php
                                                        $cantidad_vehiculos = 1;
                                                    ?>
                                                    @foreach($vehiculos as $ve)
                                                        <div class="row">
                    
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Marca: <span class='text-danger sm-text-label'>*</span></label>
                                                                    {!! Form::text("Marca[]",
                                                                    $ve->Marca,
                                                                    ["class"=>"form-control vehiculos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "required"=>true]); !!}
                                                                </div>
                                                            </div>
                        
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Modelo: <span class='text-danger sm-text-label'>*</span></label>                           
                                                                    {!! Form::text("modelo_vehiculo_bienes[]",
                                                                    $ve->modelo_vehiculo_bienes,
                                                                    ["class" => "form-control vehiculos| tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "required"=>true]); !!}
                                                                </div>
                                                            </div>
            
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Placa <span class='text-danger sm-text-label'>*</span></label>
                                                                    {!! Form::text("placas_vehiculos_bienes[]",
                                                                    $ve->placas_vehiculos_bienes,
                                                                    ["class"=>"form-control vehiculos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "placeholder"=>"",
                                                                    "id"=>"placas_vehiculos_bienes[]",
                                                                    "required"=>true]) !!}
                                                                    {{-- {!! Form::text("ciudad_inmueble[]",
                                                                    null,
                                                                    ["class"=>"form-control inmuebles | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "required"=>true]); !!} --}}
                                                                </div>
                                                            </div>
                
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Precio <span class='text-danger sm-text-label'>*</span></label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                                        {!! Form::text("valor_vehiculo_bienes[]",
                                                                        $ve->valor_vehiculo_bienes,
                                                                        ["class"=>"form-control solo_numeros monto vehiculos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                        "required"=>true,
                                                                        "placeholder"=>"vehículos a tu nombre"]); !!}
                                                                    </div>
                                                                </div>
                                                            </div>                                                   
                    
                                                            {{-- Boton de agregar vehiculo --}}
                                                            <div class="col-md-3 form-group last-child-vehiculo">
                                                                <button type="button" class="btn btn-success add-vehiculo mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Vehículo</button>
                                                                @if($cantidad_vehiculos > 1)
                                                                    <button type="button" class="btn btn-danger rem-vehiculo mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>
                                                                @endif
                                                            </div>
                                                            <?php
                                                                $cantidad_vehiculos ++;
                                                            ?>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Marca: <span class='text-danger sm-text-label'>*</span></label>
                                                                {!! Form::text("Marca[]",
                                                                null,
                                                                ["class"=>"form-control vehiculos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                ]); !!}
                                                            </div>
                                                        </div>
                    
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Modelo: <span class='text-danger sm-text-label'>*</span></label>                           
                                                                {!! Form::text("modelo_vehiculo_bienes[]",
                                                                null,
                                                                ["class" => "form-control  vehiculos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                ]); !!}
                                                            </div>
                                                        </div>
        
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Placa: <span class='text-danger sm-text-label'>*</span></label>
                                                                {!! Form::text("placas_vehiculos_bienes[]",
                                                                null,
                                                                ["class"=>"form-control vehiculos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                "placeholder"=>"",
                                                                "id"=>"placas_vehiculos_bienes[]",
                                                                ]) !!}
                                                                {{-- {!! Form::text("ciudad_inmueble[]",
                                                                null,
                                                                ["class"=>"form-control inmuebles | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                "required"=>true]); !!} --}}
                                                            </div>
                                                        </div>
            
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Precio <span class='text-danger sm-text-label'>*</span></label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                                                    {!! Form::text("valor_vehiculo_bienes[]",
                                                                    null,
                                                                    ["class"=>"form-control solo_numeros monto  vehiculos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                                    "placeholder"=>"vehículos a tu nombre"]); !!}
                                                                </div>
                                                            </div>
                                                        </div>
            
                                                        {{-- Boton de agregar riesgo --}}
                                                        <div class="col-md-3 form-group last-child-vehiculo">
                                                            <button type="button" class="btn btn-success add-vehiculo mt-3 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Vehículo</button>
                                                        </div>
            
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Observaciones: <span class='text-danger sm-text-label'></span></label>
                                            {!! Form::textarea("veh_observaciones",
                                            $candidatos->veh_observaciones,
                                            ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "maxlength"=>"550",
                                            'rows' => 3,
                                            "placeholder"=>""]); !!}
                                        </div>
                                    </div>
                                </div>

                            </div>                            
                                
                            @if($current_user->inRole("admin"))
                                <div class="">
                                    <div class="form-group">
                                        <label>Concepto(Evaluador): <span class='text-danger sm-text-label'>*</span></label>
                                        {!! Form::textarea("inm_veh_concepto",
                                        $candidatos->inm_veh_concepto,
                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "maxlength"=>"1500",
                                        'rows' => 3,
                                        "required"=>true,
                                        "placeholder"=>"Tener en cuenta la información económica y de bienes inmuebles observados en la entrevista"]); !!}
                                    </div>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- JS bienes_inmuebles --}}
@include("cv.visita.include._js_bienes_inmuebles")
