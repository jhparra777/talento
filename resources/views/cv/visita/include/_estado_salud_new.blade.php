<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Estado de salud</h3>
    </div>
    <div class="panel-body">            
        <form id="form-8" data-smk-icon="glyphicon-remove-sign" name="form-1" class="formulario">
            <div class="col-md-12">
                <div class="old">
                    <div class="row padre">
                        <div class="item">
                            {{-- seccion lesiones --}}

                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Posee alguna lesión permanente? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_lesiones_permantes",
                                            1,
                                            ($candidatos->salud_lesiones_permanente!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_lesiones_permantes"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div id="section-lesiones" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="lesiones">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>¿Qué tipo de lesión permanente posee?: <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::textarea("salud_lesiones_permanente",
                                                        $candidatos->salud_lesiones_permanente,
                                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "maxlength"=>"550",
                                                        'rows' => 3,
                                                        "placeholder"=>"",
                                                        "id"=>"salud_lesiones_permanente"]); !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- seccion psiquiatria --}}
                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Ha tenido problemas psiquiátricos o psicológicos? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_problemas_psquiatricos",
                                            1,
                                            ($candidatos->salud_prob_psiquiatricos!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_problemas_psquiatricos"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div> 
                                </div>

                                <div class="panel-body">
                                    <div id="section-psiquiatria" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="psiquiatria">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>¿Qué tipo de problemas psiquiátricos o psicológicos ha tenido?: <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::textarea("salud_prob_psiquiatricos",
                                                        $candidatos->salud_prob_psiquiatricos,
                                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "maxlength"=>"550",
                                                        'rows' => 3,
                                                        "placeholder"=>"",
                                                        "id"=>"salud_prob_psiquiatricos"]); !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>        
                            
                            {{-- seccion tratamiento --}}
                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Recibe tratamiento médico y/o medicamentos permanentes? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_tratamiento_perma",
                                            1,
                                            ($candidatos->salud_tratamiento_perma!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_tratamiento_perma"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div> 
                                </div>

                                <div class="panel-body">
                                    <div id="section-tratamiento" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="tratamiento">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>¿Qué tratamiento médico y/o medicamentos recibe?: <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::textarea("salud_tratamiento_perma",
                                                        $candidatos->salud_tratamiento_perma,
                                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "maxlength"=>"550",
                                                        'rows' => 3,
                                                        "placeholder"=>"",
                                                        "id"=>"salud_tratamiento_perma"]); !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>  

                            {{-- seccion hospitalizado --}}
                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Ha estado hospitalizado? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_hospitalizado",
                                            1,
                                            ($candidatos->salud_hospitalizado!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_hospitalizado"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div> 
                                </div>

                                <div class="panel-body">
                                    <div id="section-hospitalizado" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="hospitalizado">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>¿Por qué motivo ha estado hospitalizado?: <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::textarea("salud_hospitalizado",
                                                        $candidatos->salud_hospitalizado,
                                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "maxlength"=>"550",
                                                        'rows' => 3,
                                                        "placeholder"=>"",
                                                        "id"=>"salud_hospitalizado"]); !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>  
                                
                            {{-- @if($current_user->inRole("admin"))
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Concepto(Evaluador): <span class='text-danger sm-text-label'>*</span></label>
                                        {!! Form::textarea("salud_concepto",
                                        $candidatos->salud_concepto,
                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "maxlength"=>"550",
                                        'rows' => 3,
                                        "required"=>true,
                                        "placeholder"=>""]); !!}
                                    </div>
                                </div>
                            @endif --}}
                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    // {Seccion de lesiones}
    $("#section-lesiones").hide();
    if( $("#tiene_lesiones_permantes").prop('checked') ) {
            $("#section-lesiones").show();
    }
    $("#tiene_lesiones_permantes").on("change", function () {
        $("#section-lesiones").toggle('slow');

        if( $("#tiene_lesiones_permantes").prop('checked') ) {
            $('#salud_lesiones_permanente').attr("required", true);
        }else{
            $('#salud_lesiones_permanente').removeAttr("required");
            $("#salud_lesiones_permanente").val('');
        }
    });

    // {Seccion de lesiones}
    $("#section-psiquiatria").hide();
    if( $("#tiene_problemas_psquiatricos").prop('checked') ) {
            $("#section-psiquiatria").show();
    }
    $("#tiene_problemas_psquiatricos").on("change", function () {
        $("#section-psiquiatria").toggle('slow');

        if( $("#tiene_problemas_psquiatricos").prop('checked') ) {
            $('#salud_prob_psiquiatricos').attr("required", true);
        }else{
            $('#salud_prob_psiquiatricos').removeAttr("required");
            $("#salud_prob_psiquiatricos").val('');
        }
    });

    // {Seccion de tratamiento}
    $("#section-tratamiento").hide();
    if( $("#tiene_tratamiento_perma").prop('checked') ) {
            $("#section-tratamiento").show();
    }
    $("#tiene_tratamiento_perma").on("change", function () {
        $("#section-tratamiento").toggle('slow');

        if( $("#tiene_tratamiento_perma").prop('checked') ) {
            $('#salud_tratamiento_perma').attr("required", true);
        }else{
            $('#salud_tratamiento_perma').removeAttr("required");
            $("#salud_tratamiento_perma").val('');
        }
    });

    // {Seccion de hospitalizado}
    $("#section-hospitalizado").hide();
    if( $("#tiene_hospitalizado").prop('checked') ) {
            $("#section-hospitalizado").show();
    }
    $("#tiene_hospitalizado").on("change", function () {
        $("#section-hospitalizado").toggle('slow');

        if( $("#tiene_hospitalizado").prop('checked') ) {
            $('#salud_hospitalizado').attr("required", true);
        }else{
            $('#salud_hospitalizado').removeAttr("required");
            $("#salud_hospitalizado").val('');
        }
    });
</script>