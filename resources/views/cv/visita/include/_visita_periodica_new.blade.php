<div class="panel panel-default">
    <div class="panel-heading">
        <h3>VISITA PERIÓDICA</h3>
    </div>
    <div class="panel-body">            
        <form id="form-10" data-smk-icon="glyphicon-remove-sign" name="form-1" class="formulario">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>¿Hace cuánto tiempo trabaja en la empresa?: <span class='text-danger sm-text-label'>*</span></label>
                        {!! Form::text("vp_trabaja",
                        $candidatos->vp_trabaja,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "required"=>true]); !!}
                    </div>
                </div>
    
                <div class="col-md-6">
                    <div class="form-group">
                        <label>¿Cómo cree que es su desempeño laboral en la empresa? <span class='text-danger sm-text-label'>*</span></label>
                        {!! Form::select("vp_desempeño",
                        [""=>"Seleccione","BUENO"=>"BUENO","REGULAR"=>"REGULAR","MALO"=>"MALO"],
                        $candidatos->vp_desempeño,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"vp_desempeño",
                        "required"=>true]); !!}
                    </div>
                </div>
            </div>


            <div class="col-md-12">     
                <div class="old">
                    <div class="row padre">
                        <div class="item">

                            {{-- seccion fraude --}}
                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Alguna vez le han propuesto hacer algún fraude  en la compañia?  <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_fraude",
                                            1,
                                            ($candidatos->vp_fraude!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_fraude"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div> 
                                </div>

                                <div class="panel-body">
                                    <div id="section-fraude" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="fraude">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Especifique qué le han propuesto: <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::textarea("vp_fraude",
                                                        $candidatos->vp_fraude,
                                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "maxlength"=>"550",
                                                        'rows' => 3,
                                                        "placeholder"=>"",
                                                        "id"=>"vp_fraude"]); !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>        
                            
                            {{-- seccion llamado de atención --}}
                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Ha tenido algún llamado de atención en la empresa? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_llamado",
                                            1,
                                            ($candidatos->vp_llamado!=null)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_llamado"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div> 
                                </div>

                                <div class="panel-body">
                                    <div id="section-llamado" class="box box-info collapsed-box col-sm-12">
                                        <div class="chart">
                                            <div class="" id="llamado">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Especifique el motivo del llamado de atención <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::textarea("vp_llamado",
                                                        $candidatos->vp_llamado,
                                                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "maxlength"=>"550",
                                                        'rows' => 3,
                                                        "placeholder"=>"",
                                                        "id"=>"vp_llamado"]); !!}
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
        </form>
    </div>
</div>
<script>
    // {Seccion de fraude}
    $("#section-fraude").hide();
    if( $("#tiene_fraude").prop('checked') ) {
            $("#section-fraude").show();
    }
    $("#tiene_fraude").on("change", function () {
        $("#section-fraude").toggle('slow');

        if( $("#tiene_fraude").prop('checked') ) {
            $('#vp_fraude').attr("required", true);
        }else{
            $('#vp_fraude').removeAttr("required");
            $("#vp_fraude").val('');
        }
    });

    // {Seccion de llamado}
    $("#section-llamado").hide();
    if( $("#tiene_llamado").prop('checked') ) {
            $("#section-llamado").show();
    }
    $("#tiene_llamado").on("change", function () {
        $("#section-llamado").toggle('slow');

        if( $("#tiene_llamado").prop('checked') ) {
            $('#vp_llamado').attr("required", true);
        }else{
            $('#vp_llamado').removeAttr("required");
            $("#vp_llamado").val('');
        }
    });
</script>