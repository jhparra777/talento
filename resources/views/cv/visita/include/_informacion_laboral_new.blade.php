<div class="panel panel-default" >
    <div class="panel-heading">
        <h3>Información laboral</h3>
    </div>

    <div class="panel-body">
        <form id="form-7" data-smk-icon="glyphicon-remove-sign" name="form-1" class="formulario">
            
            <div class="" id="nuevo_formacion">
                <div class="old">
                    <div class="row padre">
                        <div class=" col-sm-12 " id="panel_laboral">
                            <div class="panel panel-default">
                                <div class="panel-heading col-sm-12">
                                    <label class=" " for="inputEmail3">
                                        ¿Posee experiencia laboral? <span></span> 
                                    </label>
                                    <div class="">
                                        <label class="">
                                            {!! Form::checkbox("tiene_experiencia_",
                                            1,
                                            (count($experiencias) > 0)?1:0,
                                            ["class"=>"inputc",
                                            "id"=>"tiene_experiencia_"]) !!}
                                            {{-- <div class="tri-toggle__fill"></div> --}}
                                        </label>
                                    </div>
                                </div>
                                <div id="section-experiencia" class=" item box box-info collapsed-box col-sm-12">
                                    @if(count($experiencias) > 0)
                                        <?php
                                            $cantidad_laboral = 1;
                                        ?> 
                                        @foreach($experiencias as $exp)
                                                {{-- {{ dd($exp) }} --}}
                                            <div class="row col-md-12 padre_laboral">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            ¿Trabajo actual?
                                                        </label>
                                                        {!! Form::select("exp_trabajo_actual[]", 
                                                        ["2" => "No", "1" => "Sí"],
                                                        (($exp->empleo_actual == "2") ? "2" : "1"), 
                                                        ["class" => "form-control select_trabajo_actual experiencias | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                        "id" => "exp_trabajo_actual[]",
                                                        "required"=>true]) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="institucion">Empresa: <span class='text-danger sm-text-label'>*</span></label>
                        
                                                        {!! Form::text("exp_empresa[]", 
                                                            $exp->nombre_empresa, [
                                                            "class" => "form-control experiencias empresa | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                            "placeholder" => "Empresa",
                                                            "id" => "exp_empresa[]",
                                                            "required"=>true]) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="titulo_obtenido">Cargo: <span class='text-danger sm-text-label'>*</span></label>
                                    
                                                        {!! Form::text("exp_cargo[]", 
                                                            $exp->cargo_especifico, [
                                                            "class" => "form-control experiencias cargo | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                            "id" => "exp_cargo[]", 
                                                            "placeholder" => "",
                                                            "required"=>true
                                                        ]) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="titulo_obtenido">Fecha ingreso: <span class='text-danger sm-text-label'>*</span></label>
                                    
                                                        {!! Form::date("exp_fecha_ingreso[]", 
                                                            $exp->fecha_inicio, [
                                                            "max" => date('Y-m-d'),
                                                            "class" => "form-control experiencias fecha_ingreso | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                            "placeholder" => "",
                                                            "id" => "exp_fecha_ingreso[]",
                                                            "required"=>true
                                                        ]) !!}
                                                        {{-- {!! Form::text("exp_fecha_ingreso[]", 
                                                            $exp->fecha_inicio, [
                                                            "class" => "form-control fecha | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                            "id" => "exp_fecha_ingreso[]", 
                                                            "placeholder" => "",
                                                            "readonly" => "readonly"
                                                        ]) !!} --}}
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="titulo_obtenido">Fecha retiro: <span class='text-danger sm-text-label'></span></label>
                                                        {!! Form::date("exp_fecha_retiro[]",
                                                        $exp->fecha_final, [
                                                        "class" => "form-control fecha actual_fecha experiencias fecha_retiro | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                        "id" => "exp_fecha_retiro[]", 
                                                        "max"=> date('Y-m-d'),
                                                        "readonly" => (($exp->empleo_actual == "1")? true : false)
                                                        ]) !!}
                                                        
                                                    </div>
                                                </div>                               

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="titulo_obtenido">Motivo del retiro: <span class='text-danger sm-text-label'>*</span></label>
                                                        {!! Form::select("exp_motivo_retiro[]", 
                                                            $motivos,
                                                            (($exp->motivo_retiro != "0")? $exp->motivo_retiro : ""), [
                                                            "class" => "form-control actual_motivo experiencias | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                            "id" => "exp_motivo_retiro[]", 
                                                            "placeholder" => "",
                                                            "disabled"=> (($exp->empleo_actual == "1")? true : false)
                                                        
                                                        ]) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Teléfono empresa: <span class='text-danger sm-text-label'></span></label>
                                                        <input 
                                                            type="text"
                                                            name="exp_telefono_contacto[]"
                                                            class="form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                                                            id="exp_telefono_contacto[]"
                                                            maxlength="10"
                                                            placeholder="Teléfono móvil"
                                                            value= {{ $exp->movil_jefe }}
                                                        >
                                                    </div>
                                                </div>

                                                {{-- @if($current_user->inRole("admin"))
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="Concepto">
                                                                Concepto(Evaluador): <span class='text-danger sm-text-label'>*</span>  
                                                            </label>
                                                            {!! Form::textarea("exp_concepto[]",  
                                                            $exp->concepto, 
                                                            ["class" => "form-control concepto_fa | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                            "id" => "exp_concepto[]",
                                                            "rows"=>"3",
                                                            "required"=>true]) !!}
                                                        </div>
                                                    </div>
                                                @endif  --}}

                                                
                                                <div class="col-md-12 form-group last-child-laboral" style="display: block;text-align:center;">
                                                    <button type="button" class="btn btn-success add-laboral | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar otra experiencia</button>
                                                    @if($cantidad_laboral > 1)
                                                        <button type="button" class="btn btn-danger rem-laboral | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>
                                                    @endif
                                                </div> 

                                            </div>
                                            <?php
                                                $cantidad_laboral ++;
                                            ?> 
                                        @endforeach

                                    @else
                                        <div class="row col-md-12 padre_laboral">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        ¿Trabajo actual?
                                                    </label>
                                                    {!! Form::select("exp_trabajo_actual[]", 
                                                    ["2" => "No", "1" => "Sí"], 
                                                    null,
                                                    ["class" => "form-control select_trabajo_actual experiencias | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                    "id" => "exp_trabajo_actual[]",
                                                    "required"=>true]) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="institucion">Empresa: <span class='text-danger sm-text-label'>*</span></label>
                    
                                                    {!! Form::text("exp_empresa[]", 
                                                        null,[
                                                        "class" => "form-control experiencias empresa | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "placeholder" => "Empresa",
                                                        "id" => "exp_empresa[]",
                                                        "required" => true
                                                    ]) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="titulo_obtenido">Cargo: <span class='text-danger sm-text-label'>*</span></label>
                                
                                                    {!! Form::text("exp_cargo[]", 
                                                        null,[
                                                        "class" => "form-control experiencias cargo | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                        "id" => "exp_cargo[]", 
                                                        "placeholder" => "",
                                                        "required" => true
                                                    ]) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="titulo_obtenido">Fecha ingreso: <span class='text-danger sm-text-label'>*</span></label>
                                
                                                    {!! Form::date("exp_fecha_ingreso[]", 
                                                        null,[
                                                        "max" => date('Y-m-d'),
                                                        "class" => "form-control experiencias fecha_ingreso | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                        "placeholder" => "",
                                                        "id" => "exp_fecha_ingreso[]",
                                                        "required" => true
                                                    ]) !!}
                                                    {{-- {!! Form::text("exp_fecha_ingreso[]", 
                                                        $exp->fecha_inicio, [
                                                        "class" => "form-control fecha | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                        "id" => "exp_fecha_ingreso[]", 
                                                        "placeholder" => "",
                                                        "readonly" => "readonly"
                                                    ]) !!} --}}
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="titulo_obtenido">Fecha retiro: <span class='text-danger sm-text-label'></span></label>
                                                    <input type="date" 
                                                        name="exp_fecha_retiro[]" 
                                                        max={{ date('Y-m-d') }}
                                                        id="exp_fecha_retiro[]"
                                                        class="form-control  actual_fecha experiencias fecha_retiro | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                                                        required
                                                    >
                                                
                                                    {{-- {!! Form::text("exp_fecha_retiro[]", 
                                                        $exp->fecha_final, [
                                                        "class" => "form-control fecha actual_fecha | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                        "id" => "exp_fecha_retiro[]", 
                                                        "placeholder" => "",
                                                        "readonly" => "readonly"
                                                    ]) !!} --}}
                                                </div>
                                            </div>                               

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="titulo_obtenido">Motivo del retiro: <span class='text-danger sm-text-label'>*</span></label>
                                                    {!! Form::select("exp_motivo_retiro[]", 
                                                        $motivos,
                                                        (($exp->motivo_retiro != "0")? $exp->motivo_retiro : "0"), [
                                                        "class" => "form-control actual_motivo experiencias actual_motivo | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                        "id" => "exp_motivo_retiro[]", 
                                                        "placeholder" => "",
                                                        "required"=> true
                                                    
                                                    ]) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Teléfono empresa: <span class='text-danger sm-text-label'></span></label>
                                                    <input 
                                                        type="text"
                                                        name="exp_telefono_contacto[]"
                                                        class="form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                                                        id="exp_telefono_contacto[]"
                                                        maxlength="10"
                                                        placeholder="Teléfono móvil"
                                                    >
                                                </div>
                                            </div>

                                            {{-- @if($current_user->inRole("admin"))
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="Concepto">
                                                            Concepto(Evaluador): <span class='text-danger sm-text-label'>*</span>  
                                                        </label>
                                                        {!! Form::textarea("exp_concepto[]",  
                                                        null, 
                                                        ["class" => "form-control concepto_fa | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                        "id" => "exp_concepto[]",
                                                        "rows"=>"3",
                                                        "required"=>true]) !!}
                                                    </div>
                                                </div>
                                            @endif  --}}

                                            
                                            <div class="col-md-12 form-group last-child-laboral" style="display: block;text-align:center;">
                                                <button type="button" class="btn btn-success add-laboral | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar otra experiencia</button>
                                                @if($cantidad_formacion > 1)
                                                    <button type="button" class="btn btn-danger rem-laboral | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>
                                                @endif
                                            </div> 

                                        </div>
                                    @endif 
                                </div>
                            </div>
                            @if($current_user->inRole("admin"))
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Concepto">
                                            Concepto(Evaluador): <span class='text-danger sm-text-label'>*</span>  
                                        </label>
                                        {!! Form::textarea("acad_lab_concepto",  
                                        $candidatos->acad_lab_concepto, 
                                        ["class" => "form-control concepto_fa | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                        "id" => "exp_concepto[]",
                                        "rows"=>"3",
                                        "maxlength"=>"1500",
                                        "required"=>true,
                                        "placeholder"=>"Tener en cuenta la información académica y laboral observados en la entrevista"]) !!}
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
    $(function(){
        $("#section-experiencia").hide();
        if( $("#tiene_experiencia_").prop('checked') ) {
            $("#section-experiencia").show();
        }else{
            $('.experiencias').removeAttr("required");
            $('.concepto_fa').removeAttr("required");
        }
    });

     // {Seccion de experiencia}
    $("#tiene_experiencia_").on("change", function () {
        $("#section-experiencia").toggle('slow');

        if( $("#tiene_experiencia_").prop('checked') ) {

            $(".padre_laboral").find('.select_trabajo_actual').each(function() {
                var elemento= this;
                var valor = elemento.value;
                
                var trabajo_actual = $(this).parents('.padre_laboral').find('.select_trabajo_actual').eq(0);
                var empresa = $(this).parents('.padre_laboral').find('.empresa').eq(0);
                var cargo = $(this).parents('.padre_laboral').find('.cargo').eq(0);
                var fecha_ingreso = $(this).parents('.padre_laboral').find('.fecha_ingreso').eq(0);
                var fecha_retiro = $(this).parents('.padre_laboral').find('.fecha_retiro').eq(0);
                var actual_motivo = $(this).parents('.padre_laboral').find('.actual_motivo').eq(0);
                if(valor == 1 ){
                    trabajo_actual.attr("required","required");
                    empresa.attr("required","required");
                    cargo.attr("required","required");
                    fecha_ingreso.attr("required","required");
                    fecha_retiro.removeAttr("required");
                    actual_motivo.removeAttr("required");
                
                }else{
                    trabajo_actual.attr("required","required");
                    empresa.attr("required","required");
                    cargo.attr("required","required");
                    fecha_ingreso.attr("required","required");
                    fecha_retiro.attr("required","required");
                    actual_motivo.attr("required","required");
                }
            });
            $('.concepto_fa').attr("required","required");
        }else{
            $('.experiencias').removeAttr("required");
            $('.concepto_fa').removeAttr("required");
        }
    });

    //evalua el campo es trabajo actual?...
    $('.panel-body').delegate('.select_trabajo_actual', 'change', function(){

        var actual_fecha = $(this).parents('.padre_laboral').find('.actual_fecha').eq(0); 
        var actual = Number($(this).val().replaceAll('.', '')); //1 si; 2 no
        var actual_motivo = $(this).parents('.padre_laboral').find('.actual_motivo').eq(0);

        // si actual es no = 2; deshabilita fecha fin y motivo del retiro
        if(actual == 2 ){
                
            actual_fecha.removeAttr("readonly");
            actual_fecha.attr("required","required");

            actual_motivo.prop('selectedIndex',1);
            actual_motivo.attr("required","required");
            actual_motivo.prop('disabled', false);
            
        }
        else{
            actual_fecha.val("");
            actual_fecha.attr("readonly","true");
            actual_fecha.removeAttr("required");

            actual_motivo.prop('selectedIndex',1);
            actual_motivo.removeAttr("required");
            actual_motivo.prop('disabled', true);  
        }
    });

    //clona el primer hijo, le reinicia los inputs y selects
    $(document).on('click', '.add-laboral', function (e) {
        fila_person = $(this).parents('.old').find('.padre_laboral').eq(0).clone();
        fila_person.find('input').val('').removeAttr("readonly");
        fila_person.find(':selected').removeAttr('selected')
        fila_person.find('.actual_fecha').attr("readonly",false);
        fila_person.find('.actual_fecha').attr("required","required");
        fila_person.find('.actual_motivo').prop('selectedIndex',1);
        fila_person.find('.actual_motivo').attr("required","required");
        fila_person.find('.actual_motivo').prop('disabled', false);
        fila_person.find('div.last-child-laboral').append('<button type="button" class="btn btn-danger rem-laboral | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>');
        
        $(this).parents('.old').find('.item').append(fila_person);
    });

    //eliminar el hijo clickado
    $(document).on('click', '.rem-laboral', function (e) {
        $(this).parents(".padre_laboral").remove();
    });

</script>