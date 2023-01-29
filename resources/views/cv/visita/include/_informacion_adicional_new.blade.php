<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Información adicional</h3>
    </div>
    <div class="panel-body">            
        <form id="form-10" data-smk-icon="glyphicon-remove-sign" name="form-1" class="formulario">
            <div class="col-md-12">
                <div class="old">
                    <div class="row padre">
                        <div class="item">
                            {{-- seccion demandas --}}

                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Posee actualmente demandas de alimentos y/o embargos? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_demandas",
                                            1,
                                            ($candidatos->info_demandas!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_demandas"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div id="section-demandas" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="demandas">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Especifique qué demandas de alimentos y/o embargos posee: <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::textarea("info_demandas",
                                                        $candidatos->info_demandas,
                                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "maxlength"=>"550",
                                                        'rows' => 3,
                                                        "placeholder"=>"",
                                                        "id"=>"info_demandas"]); !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- seccion antecedentes --}}
                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Algún miembro de su familia presenta antecedentes penales? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_antecedentes",
                                            1,
                                            ($candidatos->info_antecedentes!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_antecedentes"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div> 
                                </div>

                                <div class="panel-body">
                                    <div id="section-antecedentes" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="antecedentes">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Especifique qué miembro de su familia presenta antecedentes penales: <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::textarea("info_antecedentes",
                                                        $candidatos->info_antecedentes,
                                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "maxlength"=>"550",
                                                        'rows' => 3,
                                                        "placeholder"=>"",
                                                        "id"=>"info_antecedentes"]); !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>        
                            
                            {{-- seccion sustancias --}}
                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Ha consumido sustancias psicoactivas? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_sustancias",
                                            1,
                                            ($candidatos->info_sustancias!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_sustancias"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div> 
                                </div>

                                <div class="panel-body">
                                    <div id="section-sustancias" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="sustancias">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Especifique qué tipo de sustancias: <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::textarea("info_sustancias",
                                                        $candidatos->info_sustancias,
                                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "maxlength"=>"550",
                                                        'rows' => 3,
                                                        "placeholder"=>"",
                                                        "id"=>"info_sustancias"]); !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>  

                            {{-- seccion ilicitas --}}
                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Ha sabido de actividades ilícitas en su entorno social o laboral? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_ilicitas",
                                            1,
                                            ($candidatos->info_ilicitas!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_ilicitas"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div> 
                                </div>

                                <div class="panel-body">
                                    <div id="section-ilicitas" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="ilicitas">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Especifique qué tipo de actividades ilícitas existen en su entorno social o laboral: <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::textarea("info_ilicitas",
                                                        $candidatos->info_ilicitas,
                                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "maxlength"=>"550",
                                                        'rows' => 3,
                                                        "placeholder"=>"",
                                                        "id"=>"info_ilicitas"]); !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>  
                                
                            @if($current_user->inRole("admin"))
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Concepto(Evaluador): <span class='text-danger sm-text-label'>*</span></label>
                                        {!! Form::textarea("info_concepto",
                                        $candidatos->info_concepto,
                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "maxlength"=>"550",
                                        'rows' => 3,
                                        "required"=>true,
                                        "placeholder"=>"Tener en cuenta aspectos de salud e información adicional observados en la entrevista"]); !!}
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
<script>
    // {Seccion de demandas}
    $("#section-demandas").hide();
    if( $("#tiene_demandas").prop('checked') ) {
            $("#section-demandas").show();
    }
    $("#tiene_demandas").on("change", function () {
        $("#section-demandas").toggle('slow');

        if( $("#tiene_demandas").prop('checked') ) {
            $('#info_demandas').attr("required", true);
        }else{
            $('#info_demandas').removeAttr("required");
            $("#info_demandas").val('');
        }
    });

    // {Seccion de antecedentes}
    $("#section-antecedentes").hide();
    if( $("#tiene_antecedentes").prop('checked') ) {
            $("#section-antecedentes").show();
    }
    $("#tiene_antecedentes").on("change", function () {
        $("#section-antecedentes").toggle('slow');

        if( $("#tiene_antecedentes").prop('checked') ) {
            $('#info_antecedentes').attr("required", true);
        }else{
            $('#info_antecedentes').removeAttr("required");
            $("#info_antecedentes").val('');
        }
    });

    // {Seccion de sustancias}
    $("#section-sustancias").hide();
    if( $("#tiene_sustancias").prop('checked') ) {
            $("#section-sustancias").show();
    }
    $("#tiene_sustancias").on("change", function () {
        $("#section-sustancias").toggle('slow');

        if( $("#tiene_sustancias").prop('checked') ) {
            $('#info_sustancias').attr("required", true);
        }else{
            $('#info_sustancias').removeAttr("required");
            $("#info_sustancias").val('');
        }
    });

    // {Seccion de ilicitas}
    $("#section-ilicitas").hide();
    if( $("#tiene_ilicitas").prop('checked') ) {
            $("#section-ilicitas").show();
    }
    $("#tiene_ilicitas").on("change", function () {
        $("#section-ilicitas").toggle('slow');

        if( $("#tiene_ilicitas").prop('checked') ) {
            $('#info_ilicitas').attr("required", true);
        }else{
            $('#info_ilicitas').removeAttr("required");
            $("#info_ilicitas").val('');
        }
    });
</script>