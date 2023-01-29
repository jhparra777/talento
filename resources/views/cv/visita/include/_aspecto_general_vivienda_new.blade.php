<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Aspectos generales de la vivienda</h3>
    </div>
    <div class="panel-body">
            
        <form id="form-3" data-smk-icon="glyphicon-remove-sign" name="form-1" class="formulario">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Tipo vivienda <span class='text-danger sm-text-label'>*</span>
                        </label>
                        {!! Form::select("tipo_vivienda",
                        $tipoVivienda,
                        $candidatos->tipo_vivienda,
                        ["required","class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"tipo_vivienda",
                        "required"=>true]) !!}
                    </div> 
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Tenencia <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::select("propiedad",
                        $tipoPropiedad,
                        $candidatos->propiedad,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"propiedad",
                        "required"=>true]) !!}  
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Servicios públicos: <span class='text-danger sm-text-label'>*</span></label>
                        {!! Form::select("viv_serv_pub",
                        [""=>"Seleccione","Sí"=>"Sí","No"=>"No"],
                        $candidatos->viv_serv_pub,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "required"=>true,]); !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Zona: <span class='text-danger sm-text-label'>*</span></label>
                        {!! Form::select("sector",
                        $sector,
                        $candidatos->sector,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "required"=>true]); !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-12 control-label" for="inputEmail3">
                            Estrato <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::select("estrato",[""=>"Seleccionar","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5", "6"=>"6"],
                        $candidatos->estrato,
                        ["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                        "id"=>"estrato",
                        "required"=>true]) !!}
                    </div>  
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>¿Tiene hipoteca?: <span class='text-danger sm-text-label'>*</span></label>
                        {!! Form::select("viv_hipoteca",
                        [""=>"Seleccione","Sí"=>"Sí","No"=>"No"],
                        $candidatos->viv_hipoteca,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=> "viv_hipoteca",
                        "required"=>true]); !!}
                    </div>
                </div>

                <div id="depend-hipoteca">
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label class="control-label" for="inputEmail3">
                                Valor hipoteca <span class='text-danger sm-text-label'>*</span> 
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">$</span>
                                {!! Form::text("viv_valor_hipoteca",
                                $candidatos->viv_valor_hipoteca,
                                ["class"=>"form-control solo_numeros monto contable_total_aporte_ingreso validar_menor | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                "id"=>"viv_valor_hipoteca"]); !!}
                            </div>  
                        </div>
                    </div>
                </div>

                <div class="col-md-6" >
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Tiempo de residencia en la vivienda <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::text("viv_tmp_resd",
                        $candidatos->viv_tmp_resd,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"viv_tmp_resd",
                        "required"=>true]) !!}  
                    </div>
                </div>

                <div class="col-md-6" >
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Vias de acceso <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::select("viv_via_acc",
                        [""=>"Seleccione","BUENAS"=>"BUENAS","REGULARES"=>"REGULARES","MALAS"=>"MALAS","NO"=>"NO CUENTA CON VÍAS DE ACCESO"],
                        $candidatos->viv_via_acc,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=> "viv_via_acc",
                        "required"=>true]); !!}

                        {{-- {!! Form::text("viv_via_acc",
                        $candidatos->viv_via_acc,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"viv_via_acc",
                        "required"=>true]) !!}   --}}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alcantarillado: <span class='text-danger sm-text-label'>*</span></label>
                        {!! Form::select("viv_alcantarillado",
                        [""=>"Seleccione","Sí"=>"Sí","No"=>"No"],
                        $candidatos->viv_alcantarillado,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "required"=>true]); !!}
                    </div>
                </div>

                <div class="col-md-6" >
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Presentación externa <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::select("viv_prs_externa",
                        [""=>"Seleccione","BUENA"=>"BUENA","REGULAR"=>"REGULAR","MALA"=>"MALA"],
                        $candidatos->viv_prs_externa,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=> "viv_prs_externa",
                        "required"=>true]); !!}
                        {{-- {!! Form::text("viv_prs_externa",
                        $candidatos->viv_prs_externa,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"viv_prs_externa",
                        "required"=>true]) !!}   --}}
                    </div>
                </div>
                
                <div class="col-md-6" >
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Presentación interna <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::select("viv_prs_interna",
                        [""=>"Seleccione","BUENA"=>"BUENA","REGULAR"=>"REGULAR","MALA"=>"MALA"],
                        $candidatos->viv_prs_interna,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=> "viv_prs_interna",
                        "required"=>true]); !!}
                        {{-- {!! Form::text("viv_prs_interna",
                        $candidatos->viv_prs_interna,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"viv_prs_interna",
                        "required"=>true]) !!}   --}}
                    </div>
                </div>

                <div class="col-md-6" >
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Aseo y orden <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::select("viv_aseo_orden",
                        [""=>"Seleccione","BUENO"=>"BUENO","REGULAR"=>"REGULAR","MALO"=>"MALO"],
                        $candidatos->viv_aseo_orden,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=> "viv_aseo_orden",
                        "required"=>true]); !!}
                        {{-- {!! Form::text("viv_aseo_orden",
                        $candidatos->viv_aseo_orden,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"viv_aseo_orden",
                        "required"=>true]) !!}   --}}
                    </div>
                </div>

                <div class="col-md-6" >
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Ambiente del sector <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::select("viv_amb_sector",
                        [""=>"Seleccione","BUENO"=>"BUENO","REGULAR"=>"REGULAR","MALO"=>"MALO"],
                        $candidatos->viv_amb_sector,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=> "viv_amb_sector",
                        "required"=>true]); !!}
                        {{-- {!! Form::text("viv_amb_sector",
                        $candidatos->viv_amb_sector,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"viv_amb_sector",
                        "required"=>true]) !!}   --}}
                    </div>
                </div>

                @if($current_user->inRole("admin"))
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Concepto(Evaluador): <span class='text-danger sm-text-label'>*</span></label>
                            {!! Form::textarea("viv_concepto",
                            $candidatos->viv_concepto,
                            ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                            "maxlength"=>"1500",
                            'rows' => 3,
                            "required"=>true,
                            "placeholder"=>"Tener en cuenta los aspectos datos básicos, familiares y de vivienda observados en la entrevista"]); !!}
                        </div>
                    </div>
                @endif

            </div>
        </form>
    </div>
</div>
@include("cv.visita.include._js_aspecto_general_vivienda")
