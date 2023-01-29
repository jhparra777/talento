<div class="panel panel-default" >
    <div class="panel-heading">
        <h3>Estructura familiar</h3>
    </div>

    <div class="panel-body">
        <div class="alert alert-info instrucciones">
            <p class="titulo">Instrucciones:</p>
            <p style="text-align: justify;">
                En este espacio deberá registrar su núcleo familiar. Para agregar más familiares haga clic en el ícono +
            </p>
        </div>
        <form id="form-2" data-smk-icon="glyphicon-remove-sign" name="form-2" class="formulario">
            
            <div class="" id="nuevo_familiar">
                <div class="old">
                    <div class="row padre">
                        <div class="item col-sm-12 " id="panel_familiar">
                            @if(count($familiares) > 0)
                                <?php
                                    $cantidad_familiar = 1;
                                ?> 
                                @foreach($familiares as $fam)
                                         {{-- {{ dd($exp) }} --}}
                                    <div class="row col-md-12 padre_familiar">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Parentesco: <span class='text-danger sm-text-label'>*</span></label>
                                                {!! Form::select("parentesco[]",
                                                $parentescos,
                                                $fam->parentesco_id,
                                                ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id"=>"parentesco",
                                                "required"=>true]); !!}
                                            </div>
                                        </div>
    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nombres y apellidos: <span class='text-danger sm-text-label'>*</span></label>
                                                {!! Form::text("nombre_familiar[]",
                                                $fam->nombres,
                                                ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "required"=>true]); !!}
                                            </div>
                                        </div>
    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Convive con él: <span class='text-danger sm-text-label'>*</span></label>
                                                {!! Form::select("convive_con_el[]",
                                                [""=>"Seleccione","Sí"=>"Sí","No"=>"No"],
                                                ucfirst($fam->convive_con_el),
                                                ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "required"=>true]); !!}
                                            </div>
                                        </div>
    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Estado civil: <span class='text-danger sm-text-label'>*</span></label>
                                                {!! Form::select("estado_civil_familiar[]",
                                                $estadoCivil,
                                                $fam->estado_civil_id,
                                                ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id"=>"estado_civil_familiar",
                                                "required"=>true]); !!}
                                            </div>
                                        </div>
    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Profesión: <span class='text-danger sm-text-label'>*</span></label>
                                                {!! Form::text("profesion_id[]",
                                                $fam->profesion_id,
                                                ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "required"=>true]); !!}
                                            </div>
                                        </div>

                                        <?php 
                                            if (empty($fam->edad_fam)) {
                                                if (!empty($fam->fecha_nacimiento) && $fam->fecha_nacimiento !="0000-00-00") {
                                                    $fam->edad_fam = \Carbon\Carbon::parse($fam->fecha_nacimiento)->age;
                                                }   
                                            }
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Edad: <span class='text-danger sm-text-label'>*</span></label>
                                                {!! Form::text("edad_familiar[]",
                                                $fam->edad_fam,
                                                ["class"=>"form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "required"=>true]); !!}
                                            </div>
                                        </div>
 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Telefóno móvil: <span class='text-danger sm-text-label'>*</span></label>
                                                <input 
                                                    type="tel"
                                                    name="num_contacto_familiar[]"
                                                    class="form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                                                    id="num_contacto_familiar[]"
                                                    maxlength="10"
                                                    placeholder="Teléfono móvil"
                                                    required
                                                    value= {{ $fam->numero_contacto_familiar }}
                                                >
                                            </div>
                                        </div>

                                        
                                        <div class="col-md-12 form-group last-child-familiar" style="display: block;text-align:center;">
                                            <button type="button" class="btn btn-success add-familiar | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar otro familiar</button>
                                            @if($cantidad_familiar > 1)
                                                <button type="button" class="btn btn-danger rem-familiar | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>
                                            @endif
                                        </div> 

                                    </div>
                                    <?php
                                        $cantidad_familiar ++;
                                    ?> 
                                @endforeach  
                            @else
                                <div class="row col-md-12 padre_familiar">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Parentesco: <span class='text-danger sm-text-label'>*</span></label>
                                            {!! Form::select("parentesco[]",
                                            $parentescos,
                                            null,
                                            ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id"=>"parentesco",
                                            "required"=>true]); !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nombres y apellidos: <span class='text-danger sm-text-label'>*</span></label>
                                            {!! Form::text("nombre_familiar[]",
                                            null,
                                            ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "required"=>true]); !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Convive con él: <span class='text-danger sm-text-label'>*</span></label>
                                            {!! Form::select("convive_con_el[]",
                                            [""=>"Seleccione","Sí"=>"Sí","No"=>"No"],
                                            null,
                                            ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "required"=>true]); !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Estado civil: <span class='text-danger sm-text-label'>*</span></label>
                                            {!! Form::select("estado_civil_familiar[]",
                                            $estadoCivil,
                                            null,
                                            ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id"=>"estado_civil_familiar",
                                            "required"=>true]); !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Profesión: <span class='text-danger sm-text-label'>*</span></label>
                                            {!! Form::text("profesion_id[]",
                                            null,
                                            ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "required"=>true]); !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Edad: <span class='text-danger sm-text-label'>*</span></label>
                                            {!! Form::text("edad_familiar[]",
                                            null,
                                            ["class"=>"form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "required"=>true]); !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Telefóno móvil: <span class='text-danger sm-text-label'>*</span></label>
                                            <input 
                                                type="tel"
                                                name="num_contacto_familiar[]"
                                                class="form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                                                id="num_contacto_familiar[]"
                                                maxlength="10"
                                                placeholder="Teléfono móvil"
                                                required
                                            >
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-12 form-group last-child-familiar" style="display: block;text-align:center;">
                                        <button type="button" class="btn btn-success add-familiar | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar otro familiar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar otro familiar</button>
                                        @if($cantidad_formacion > 1)
                                            <button type="button" class="btn btn-danger rem-familiar | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>
                                        @endif
                                    </div> 

                                </div>
                            @endif
                        
                        </div>
                    </div>

                    <div class="panel panel-default" style="margin-top: 30px">
                        <div class="panel-heading">
                            <h3>Información familiar adicional</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>¿Cómo es la relación con su familia? <span class='text-danger sm-text-label'>*</span></label>
                                    {!! Form::textarea("fam_relacion",
                                    $candidatos->fam_relacion,
                                    ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "maxlength"=>"550",
                                    'rows' => 3,
                                    "required"=>true]); !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enfermedades en la familia: <span class='text-danger sm-text-label'>*</span></label>
                                    {!! Form::textarea("fam_enfermedades",
                                    $candidatos->fam_enfermedades,
                                    ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "maxlength"=>"550",
                                    'rows' => 3,
                                    "required"=>true,
                                    "placeholder"=> "INDIQUE PARENTESCO Y ENFERMEDAD. EJ: PADRE - DIABETES O N/A"]); !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Actividades en el tiempo libre: <span class='text-danger sm-text-label'>*</span></label>
                                    {!! Form::textarea("fam_act_tmp_lbre",
                                    $candidatos->fam_act_tmp_lbre,
                                    ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "maxlength"=>"550",
                                    'rows' => 3,
                                    "required"=>true]); !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Situaciones difíciles en la familia: <span class='text-danger sm-text-label'>*</span></label>
                                    {!! Form::textarea("fam_situaciones_dificiles",
                                    $candidatos->fam_situaciones_dificiles,
                                    ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "maxlength"=>"550",
                                    'rows' => 3,
                                    "required"=>true]); !!}
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Proyectos a mediano y largo plazo: <span class='text-danger sm-text-label'>*</span></label>
                                    {!! Form::textarea("metas_corto_plazo",
                                    $candidatos->metas_corto_plazo,
                                    ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "maxlength"=>"550",
                                    'rows' => 3,
                                    "required"=>true]); !!}
                                </div>
                            </div>
    
                            {{-- @if($current_user->inRole("admin"))
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Concepto(Evaluador): <span class='text-danger sm-text-label'>*</span></label>
                                        {!! Form::textarea("fam_concepto",
                                        $candidatos->fam_concepto,
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

    //clona el primer hijo, le reinicia los inputs y selects
    $(document).on('click', '.add-familiar', function (e) {
        fila_person = $(this).parents('.old').find('.padre_familiar').eq(0).clone();
        fila_person.find('input').val('').removeAttr("readonly");
        fila_person.find(':selected').removeAttr('selected')
        fila_person.find('div.last-child-familiar').append('<button type="button" class="btn btn-danger rem-familiar | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>');
        
        $(this).parents('.old').find('.item').append(fila_person);
    });

    //eliminar el hijo clickado
    $(document).on('click', '.rem-familiar', function (e) {
        $(this).parents(".padre_familiar").remove();
    });

</script>